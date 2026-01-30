<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditModel;
use App\Core\Middleware;
use PDO;

class AdminController {
    private $pdo;
    private $userModel;
    private $auditModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
        $this->auditModel = new AuditModel($pdo);
        Middleware::requireRole('admin');
    }

    public function manageUsers() {
        $users = $this->userModel->getAllUsers();
        include __DIR__ . '/../Views/admin_users.html';
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Middleware::csrfCheck();
            $data = [
                'username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
                'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
                'role' => $_POST['role'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            $this->userModel->updateUser($id, $data);
            $this->auditModel->logAction($_SESSION['user_id'], 'edit_user', 'Edited user ID: ' . $id);
            header('Location: /admin/users');
            exit;
        }
        $user = $this->userModel->getUserById($id);
        include __DIR__ . '/../Views/admin_users.html';
    }

    public function deleteUser($id) {
        $this->userModel->deleteUser($id);
        $this->auditModel->logAction($_SESSION['user_id'], 'delete_user', 'Deleted user ID: ' . $id);
        header('Location: /admin/users');
        exit;
    }

    public function systemAnalytics() {
        $analytics = $this->userModel->getAnalytics();
        include __DIR__ . '/../Views/dashboard.html';
    }
}