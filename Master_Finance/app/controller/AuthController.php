<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditModel;
use App\Core\Middleware;
use PDO;

class AuthController {
    private $pdo;
    private $userModel;
    private $auditModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
        $this->auditModel = new AuditModel($pdo);
        session_start();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Middleware::csrfCheck();
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUsername($username);
            if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $this->userModel->updateLastLogin($user['id']);
                $this->auditModel->logAction($user['id'], 'login', 'User logged in');
                header('Location: /dashboard');
                exit;
            }
            echo 'Invalid credentials';
        } else {
            include __DIR__ . '/../Views/login.html';
        }
    }

    public function logout() {
        $this->auditModel->logAction($_SESSION['user_id'], 'logout', 'User logged out');
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function register() {
        Middleware::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Middleware::csrfCheck();
            $data = [
                'username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
                'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
                'password' => $_POST['password'],
                'role' => $_POST['role']
            ];
            if ($this->userModel->createUser($data)) {
                $this->auditModel->logAction($_SESSION['user_id'], 'create_user', 'Created user: ' . $data['username']);
                header('Location: /admin/users');
                exit;
            }
        }
        include __DIR__ . '/../Views/admin_users.html';
    }
}