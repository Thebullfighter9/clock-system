<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private \PDO $db;
    public function __construct(\PDO $db) { $this->db = $db; }

    /* --- GET / --- */
    public function loginForm(): string
    {
        if ($this->isLoggedIn()) {
            header('Location: /dashboard'); exit;
        }
        return $this->view('auth/login', ['title' => 'Login']);
    }

    /* --- POST /login --- */
    public function login(): string
    {
        $email    = $_POST['email']   ?? '';
        $password = $_POST['password'] ?? '';

        $user = (new User($this->db))->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['uid'] = $user['id'];
            header('Location: /dashboard'); exit;
        }

        $error = 'Invalid credentials';
        return $this->view('auth/login', ['title' => 'Login', 'error' => $error, 'email' => $email]);
    }

    /* --- GET /logout --- */
    public function logout(): never
    {
        session_destroy();
        header('Location: /'); exit;
    }

    /* --- GET /dashboard --- (placeholder) */
    public function dashboard(): string
    {
        $this->guard();
        return $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'user'  => (new User($this->db))->find($_SESSION['uid']),
        ]);
    }

    /* -------- helpers -------- */
    private function view(string $path, array $data = []): string
    {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/{$path}.php";
        return ob_get_clean();
    }

    private function isLoggedIn(): bool
    {
        return isset($_SESSION['uid']);
    }

    private function guard(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: /'); exit;
        }
    }
}
