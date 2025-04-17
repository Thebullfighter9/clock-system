
<?php
namespace App\Models;

class ClockEntry
{
    private \PDO $db;
    public function __construct(\PDO $db) { $this->db = $db; }

    /* -- ACTIVE entry for a user (null if none) */
    public function activeFor(int $uid): ?array
    {
        $q = 'SELECT * FROM clock_entries WHERE user_id = ? AND clock_out IS NULL LIMIT 1';
        $s = $this->db->prepare($q); $s->execute([$uid]);
        return $s->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /* -- Total seconds worked today */
    public function secondsToday(int $uid): int
    {
        $q = 'SELECT COALESCE(SUM(seconds_worked),0) FROM clock_entries
              WHERE user_id = ? AND DATE(clock_in) = CURDATE()';
        $s = $this->db->prepare($q); $s->execute([$uid]);
        return (int) $s->fetchColumn();
    }

    /* -- Punch‑in */
    public function punchIn(int $uid, ?string $note = null): void
    {
        $q = 'INSERT INTO clock_entries (user_id, clock_in, notes) VALUES (?, NOW(), ?)';
        $this->db->prepare($q)->execute([$uid, $note]);
    }

    /* -- Punch‑out */
    public function punchOut(int $entryId, ?string $note = null): void
    {
        // calc seconds first
        $q   = 'SELECT clock_in FROM clock_entries WHERE id = ? LIMIT 1';
        $in  = (new \DateTime($this->db->prepare($q)->execute([$entryId]) ? $this->db->query($q)->fetchColumn() : 'now'));
        $sec = time() - $in->getTimestamp();

        $q2  = 'UPDATE clock_entries
                SET clock_out = NOW(), seconds_worked = ?, notes = COALESCE(?, notes)
                WHERE id = ?';
        $this->db->prepare($q2)->execute([$sec, $note, $entryId]);
    }
}
