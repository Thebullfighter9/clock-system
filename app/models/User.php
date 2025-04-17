<?php
namespace App\Models;

class User
{
    private \PDO $db;
    public function __construct(\PDO $db){$this->db=$db;}

    public function all(): array
    {
        return $this->db->query('SELECT * FROM users ORDER BY last_name')->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find(int $id):?array
    {
        $s=$this->db->prepare('SELECT * FROM users WHERE id=?');$s->execute([$id]);
        return $s->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    public function findByEmail(string $e):?array
    {
        $s=$this->db->prepare('SELECT * FROM users WHERE email=?');$s->execute([$e]);
        return $s->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    public function create(array $d):void
    {
        $q='INSERT INTO users(employee_id,first_name,last_name,email,password,role,hourly_rate)
            VALUES(?,?,?,?,?,?,?)';
        $this->db->prepare($q)->execute([
            $d['employee_id'],$d['first_name'],$d['last_name'],$d['email'],
            password_hash($d['password'],PASSWORD_BCRYPT),
            $d['role'],$d['hourly_rate']
        ]);
    }
    public function update(int $id,array $d):void
    {
        $base='UPDATE users SET first_name=?,last_name=?,email=?,role=?,hourly_rate=?';
        $params=[$d['first_name'],$d['last_name'],$d['email'],$d['role'],$d['hourly_rate']];
        if(!empty($d['password'])){
            $base.=', password=?'; $params[]=password_hash($d['password'],PASSWORD_BCRYPT);
        }
        $base.=' WHERE id=?'; $params[]=$id;
        $this->db->prepare($base)->execute($params);
    }
    public function delete(int $id):void
    {
        $this->db->prepare('DELETE FROM users WHERE id=?')->execute([$id]);
    }
}
