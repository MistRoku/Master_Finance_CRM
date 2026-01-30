<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\DocumentModel;
use App\Models\AuditModel;
use App\Core\Middleware;
use PDO;

class UserController {
    private $pdo;
    private $clientModel;
    private $documentModel;
    private $auditModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->clientModel = new ClientModel($pdo);
        $this->documentModel = new DocumentModel($pdo);
        $this->auditModel = new AuditModel($pdo);
        Middleware::requireRole('user');
    }

    public function dashboard() {
        $clients = $this->clientModel->getClientsByUser($_SESSION['user_id']);
        include __DIR__ . '/../Views/dashboard.html';
    }

    public function uploadDocument() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Middleware::csrfCheck();
            $file = $_FILES['document'];
            if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], ['application/pdf', 'image/jpeg'])) {
                $path = '/uploads/' . basename($file['name']);
                move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public' . $path);
                $this->documentModel->saveDocument($_SESSION['user_id'], null, $file['name'], $path);
                $this->auditModel->logAction($_SESSION['user_id'], 'upload_document', 'Uploaded: ' . $file['name']);
            }
        }
        include __DIR__ . '/../Views/user_profile.html';
    }
}