<?php
namespace App\Models;
class Announcement{
 private \PDO $db;
 public function __construct(\PDO $db){$this->db=$db;}
 public function all():array{
   return $this->db->query('SELECT a.*,u.first_name author FROM announcements a JOIN users u ON u.id=a.user_id ORDER BY published_at DESC')
          ->fetchAll(\PDO::FETCH_ASSOC);}
 public function create(array $d):void{
   $q='INSERT INTO announcements(user_id,title,body) VALUES(?,?,?)';
   $this->db->prepare($q)->execute([$d['user_id'],$d['title'],$d['body']]);
 }
}
