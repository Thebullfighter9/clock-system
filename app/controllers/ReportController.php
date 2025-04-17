<?php
namespace App\Controllers;
use Dompdf\Dompdf;

class ReportController
{
    private \PDO $db;
    public function __construct(\PDO $db){session_start();$this->db=$db;}

    public function daily():never{ $this->generate(date('Y-m-d'),date('Y-m-d')); }
    public function range():never{ $this->generate($_GET['from'],$_GET['to']); }

    private function generate(string $from,string $to):never
    {
        $uid=$_SESSION['uid']??0;
        $q='SELECT c.*,p.title proj FROM clock_entries c LEFT JOIN projects p ON p.id=c.project_id
            WHERE c.user_id=? AND DATE(c.clock_in) BETWEEN ? AND ? ORDER BY c.clock_in';
        $s=$this->db->prepare($q);$s->execute([$uid,$from,$to]);$rows=$s->fetchAll(\PDO::FETCH_ASSOC);

        ob_start(); ?>
        <h2>Time‑Sheet (<?= $from ?> ➜ <?= $to ?>)</h2>
        <table border="1" cellpadding="4" cellspacing="0" width="100%">
        <tr><th>Date</th><th>Project</th><th>In</th><th>Out</th><th>Hours</th></tr>
        <?php $tot=0; foreach($rows as $r): $h=round($r['seconds_worked']/3600,2);$tot+=$h;?>
        <tr><td><?=substr($r['clock_in'],0,10)?></td>
            <td><?=htmlspecialchars($r['proj']??'—')?></td>
            <td><?=substr($r['clock_in'],11,5)?></td>
            <td><?= $r['clock_out']?substr($r['clock_out'],11,5):'—' ?></td>
            <td><?= $h ?></td></tr>
        <?php endforeach; ?>
        <tr><td colspan="4"><b>Total</b></td><td><b><?= $tot ?></b></td></tr>
        </table><?php
        $html=ob_get_clean();

        $pdf=new Dompdf(['paper'=>'a4','defaultFont'=>'Helvetica']);
        $pdf->loadHtml($html);$pdf->render();
        header('Content-Type:application/pdf');
        header('Content-Disposition:inline; filename="timesheet.pdf"');
        echo $pdf->output(); exit;
    }
}
