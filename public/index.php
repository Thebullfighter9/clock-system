<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();
$pdo = require __DIR__ . '/../config/database.php';

use App\Controllers\AuthController;
use App\Controllers\ClockController;
use App\Controllers\AdminController;
use App\Controllers\ReportController;
use App\Controllers\PayrollController;  // ← NEW

/* ---------- tiny router ---------- */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    '/'                  => [AuthController::class,    'loginForm'],
    '/login'             => [AuthController::class,    'login'],
    '/logout'            => [AuthController::class,    'logout'],
    '/dashboard'         => [AuthController::class,    'dashboard'],

    /* Clock */
    '/clock'             => [ClockController::class,   'screen'],
    '/clock/in'          => [ClockController::class,   'in'],
    '/clock/out'         => [ClockController::class,   'out'],

    /* Admin → Departments */
    '/admin/depts'       => [AdminController::class,   'depts'],
    '/admin/dept/new'    => [AdminController::class,   'deptForm'],
    '/admin/dept/edit'   => [AdminController::class,   'deptForm'],
    '/admin/dept/save'   => [AdminController::class,   'deptSave'],
    '/admin/dept/delete' => [AdminController::class,   'deptDelete'],

    /* Admin → Projects */
    '/admin/projects'        => [AdminController::class,'projects'],
    '/admin/project/new'     => [AdminController::class,'projectForm'],
    '/admin/project/edit'    => [AdminController::class,'projectForm'],
    '/admin/project/save'    => [AdminController::class,'projectSave'],
    '/admin/project/delete'  => [AdminController::class,'projectDelete'],

    /* Admin → Users */
    '/admin/users'       => [AdminController::class,   'users'],
    '/admin/user/new'    => [AdminController::class,   'userForm'],
    '/admin/user/edit'   => [AdminController::class,   'userForm'],
    '/admin/user/save'   => [AdminController::class,   'userSave'],
    '/admin/user/delete' => [AdminController::class,   'userDelete'],

    /* Reports */
    '/report/daily'      => [ReportController::class,  'daily'],
    '/report/range'      => [ReportController::class,  'range'],

    /* Payroll */
    '/payroll/weekly'    => [PayrollController::class, 'weekly'],  // ← NEW
    '/payroll/range'     => [PayrollController::class, 'range'],   // ← NEW
];

if (!isset($routes[$uri])) {
    http_response_code(404);
    exit('404 Not Found');
}
[$class, $method] = $routes[$uri];
echo (new $class($pdo))->{$method}();
