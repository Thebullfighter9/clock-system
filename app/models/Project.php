<?php
namespace App\Models;

class Project
{
    private \PDO $db;
    public function __construct(\PDO $db){$this->db=$db;}

    public function all(): array
    {
        $q='SELECT p.*, d.name dept FROM projects p JOIN departments d ON d.id=p.department_id ORDER BY p.active DESC, p.title';
        return $this->db->query($q)->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find(int $id):?array
    {
        $s=$this->db->prepare('SELECT * FROM projects WHERE id=?'); $s->execute([$id]);
        return $s->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    public function create(array $d):void
    {
        $q='INSERT INTO projects(title,description,department_id,deadline,pay_modifier,active)
            VALUES(?,?,?,?,?,?)';
        $this->db->prepare($q)->execute([
            $d['title'],$d['description'],$d['department_id'],
            $d['deadline'],$d['pay_modifier'],$d['active']
        ]);
    }
    public function update(int $id,array $d):void
    {
        $q='UPDATE projects SET title=?,description=?,department_id=?,deadline=?,pay_modifier=?,active=?
            WHERE id=?';
        $this->db->prepare($q)->execute([
            $d['title'],$d['description'],$d['department_id'],
            $d['deadline'],$d['pay_modifier'],$d['active'],$id
        ]);
    }
    public function delete(int $id):void
    {
        $this->db->prepare('DELETE FROM projects WHERE id=?')->execute([$id]);
    }
}
