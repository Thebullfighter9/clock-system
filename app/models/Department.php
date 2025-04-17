<?php
namespace App\Models;

class Department
{
    private \PDO $db;
    public function __construct(\PDO $db){$this->db=$db;}

    public function all(): array
    {
        return $this->db->query('SELECT * FROM departments ORDER BY name')->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $s=$this->db->prepare('SELECT * FROM departments WHERE id=?'); $s->execute([$id]);
        return $s->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    public function create(array $data): void
    {
        $q='INSERT INTO departments(name,pay_modifier) VALUES(?,?)';
        $this->db->prepare($q)->execute([$data['name'],$data['pay_modifier']]);
    }
    public function update(int $id,array $data):void
    {
        $q='UPDATE departments SET name=?, pay_modifier=? WHERE id=?';
        $this->db->prepare($q)->execute([$data['name'],$data['pay_modifier'],$id]);
    }
    public function delete(int $id):void
    {
        $this->db->prepare('DELETE FROM departments WHERE id=?')->execute([$id]);
    }
}
