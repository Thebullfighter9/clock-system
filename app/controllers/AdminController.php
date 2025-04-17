<?php
namespace App\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\User;

class AdminController
{
    private \PDO $db;
    private Department $dept;
    private Project $proj;
    private User $user;

    public function __construct(\PDO $db)
    {
        session_start();
        $this->db   = $db;
        $this->dept = new Department($db);
        $this->proj = new Project($db);
        $this->user = new User($db);

        $auth = $this->user->find($_SESSION['uid'] ?? 0);
        if (!$auth || !in_array($auth['role'],['founder','admin'])) {
            http_response_code(403); exit('Forbidden');
        }
    }

    /* ==== Departments ==== */
    public function depts():string{ return $this->view('admin/depts/index',['title'=>'Departments','rows'=>$this->dept->all()]);}
    public function deptForm():string{
        $row = isset($_GET['id'])? $this->dept->find((int)$_GET['id']):null;
        return $this->view('admin/depts/form',['title'=>$row?'Edit Department':'New Department','row'=>$row]);
    }
    public function deptSave():never{
        $d=['name'=>$_POST['name'],'pay_modifier'=>$_POST['pay_modifier']];
        $_POST['id']? $this->dept->update($_POST['id'],$d) : $this->dept->create($d);
        header('Location:/admin/depts'); exit;
    }
    public function deptDelete():never{ $this->dept->delete((int)$_GET['id']); header('Location:/admin/depts'); exit; }

    /* ==== Projects ==== */
    public function projects():string{ return $this->view('admin/projects/index',['title'=>'Projects','rows'=>$this->proj->all()]);}
    public function projectForm():string{
        $row=isset($_GET['id'])?$this->proj->find((int)$_GET['id']):null;
        return $this->view('admin/projects/form',['title'=>$row?'Edit Project':'New Project','row'=>$row,'depts'=>$this->dept->all()]);
    }
    public function projectSave():never{
        $d=$_POST; $d['active']=isset($d['active'])?1:0;
        $_POST['id']? $this->proj->update($_POST['id'],$d):$this->proj->create($d);
        header('Location:/admin/projects'); exit;
    }
    public function projectDelete():never{ $this->proj->delete((int)$_GET['id']); header('Location:/admin/projects'); exit; }

    /* ==== Users ==== */
    public function users():string{ return $this->view('admin/users/index',['title'=>'Employees','rows'=>$this->user->all()]);}
    public function userForm():string{
        $row=isset($_GET['id'])?$this->user->find((int)$_GET['id']):null;
        return $this->view('admin/users/form',['title'=>$row?'Edit Employee':'New Employee','row'=>$row]);
    }
    public function userSave():never{
        $_POST['id']? $this->user->update($_POST['id'],$_POST):$this->user->create($_POST);
        header('Location:/admin/users'); exit;
    }
    public function userDelete():never{ $this->user->delete((int)$_GET['id']); header('Location:/admin/users'); exit; }

    private function view(string $p,array $d=[]):string{extract($d);ob_start();require __DIR__."/../views/{$p}.php";return ob_get_clean();}
}
