<?php
namespace App\Models;

use PDO;

class DocumentModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getDocumentsByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM documents WHERE user_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function saveDocument($userId, $clientId, $filename, $filepath) {
        $stmt = $this->pdo->prepare("INSERT INTO documents (user_id, client_id, filename, filepath) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $clientId, $filename, $filepath]);
    }

    public function deleteDocument($id) {
        $stmt = $this->pdo->prepare("DELETE FROM documents WHERE id = ?");
        return $stmt->execute([$id]);
    }
}