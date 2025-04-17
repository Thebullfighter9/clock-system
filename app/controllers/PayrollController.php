<?php
namespace App\Controllers;

use App\Models\ClockEntry;
use App\Models\User;

class PayrollController
{
    private \PDO $db;
    private ClockEntry $clock;

    public function __construct(\PDO $db)
    {
        session_start();
        // only founders & admins may export payroll
        $user = (new User($db))->find($_SESSION['uid'] ?? 0);
        if (!$user || !in_array($user['role'], ['founder','admin'])) {
            http_response_code(403);
            exit('Forbidden');
        }
        $this->db    = $db;
        $this->clock = new ClockEntry($db);
    }

    /**
     * GET /payroll/weekly
     * Exports CSV for current ISO‑week (Monday→Sunday).
     */
    public function weekly(): never
    {
        $dt = new \DateTime('now');
        $dt->setISODate((int)$dt->format('o'), (int)$dt->format('W'), 1);
        $from = $dt->format('Y-m-d');
        $dt->modify('+6 days');
        $to = $dt->format('Y-m-d');
        $this->exportCsv($from, $to);
    }

    /**
     * GET /payroll/range?from=YYYY-MM-DD&to=YYYY-MM-DD
     */
    public function range(): never
    {
        $from = $_GET['from'] ?? '';
        $to   = $_GET['to']   ?? '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) ||
            !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
            http_response_code(400);
            exit('Invalid date range');
        }
        $this->exportCsv($from, $to);
    }

    /**
     * @param string $from inclusive
     * @param string $to   inclusive
     */
    private function exportCsv(string $from, string $to): never
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="payroll_'.$from.'_to_'.$to.'.csv"');

        $out = fopen('php://output','w');
        fputcsv($out, ['Employee ID','Name','Hours Worked','Base Pay','Overtime Pay','Total Pay']);

        $users = (new User($this->db))->all();
        foreach ($users as $u) {
            $uid = (int)$u['id'];
            // sum seconds for period
            $stmt = $this->db->prepare("
                SELECT seconds_worked 
                  FROM clock_entries
                 WHERE user_id=? AND DATE(clock_in) BETWEEN ? AND ?");
            $stmt->execute([$uid, $from, $to]);
            $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);

            $totalSec = array_sum($rows);
            $totalHr  = $totalSec / 3600;
            $overtimeHr = max(0, $totalHr - 40);
            $regularHr  = $totalHr - $overtimeHr;

            $rate = (float)$u['hourly_rate'];
            $basePay     = $regularHr  * $rate;
            $overtimePay = $overtimeHr * $rate * 1.5;
            $totalPay    = $basePay + $overtimePay;

            fputcsv($out, [
                $u['employee_id'],
                $u['first_name'].' '.$u['last_name'],
                number_format($totalHr,2),
                number_format($basePay,2),
                number_format($overtimePay,2),
                number_format($totalPay,2),
            ]);
        }

        fclose($out);
        exit;
    }
}
