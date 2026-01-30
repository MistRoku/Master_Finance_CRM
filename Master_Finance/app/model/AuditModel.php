<?php
namespace App\Models;

use PDO;

class AuditModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function logAction($userId, $action, $details) {
        $stmt = $this->pdo->prepare("INSERT INTO audit_logs (user_id, action, details) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $action, $details]);
    }

    public function getLogs() {
        $stmt = $this->pdo->query("SELECT * FROM audit_logs ORDER BY timestamp DESC");
        return $stmt->fetchAll();
    }
}