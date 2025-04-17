<?php
namespace App\Controllers;

use App\Models\ClockEntry;
use App\Models\Project;
use App\Models\User;

class ClockController
{
    private \PDO $db;
    private ClockEntry $clock;

    public function __construct(\PDO $db)
    {
        session_start();
        if (!isset($_SESSION['uid'])) { header('Location: /'); exit; }
        $this->db=$db; $this->clock=new ClockEntry($db);
    }

    public function screen(): string
    {
        $uid=$_SESSION['uid'];
        return $this->view('clock/index',[
            'title'=>'Clock',
            'user'=>(new User($this->db))->find($uid),
            'active'=>$this->clock->activeFor($uid),
            'secondsToday'=>$this->clock->secondsToday($uid),
            'projects'=>(new Project($this->db))->all()
        ]);
    }

    public function in(): never
    {
        $this->clock->punchIn(
            $_SESSION['uid'],
            (int)$_POST['project_id'],
            $_POST['note']??null
        );
        header('Location: /clock'); exit;
    }

    public function out(): never
    {
        if($entry=$this->clock->activeFor($_SESSION['uid'])){
            $this->clock->punchOut($entry['id'],$_POST['note']??null);
        }
        header('Location: /clock'); exit;
    }

    private function view(string $path,array $d=[]):string{extract($d);ob_start();require __DIR__."/../views/{$path}.php";return ob_get_clean();}
}
