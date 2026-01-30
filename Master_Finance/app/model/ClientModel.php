<?php
namespace App\Models;

use PDO;

class ClientModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getClientsByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function createClient($data) {
        $stmt = $this->pdo->prepare("INSERT INTO clients (user_id, name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['user_id'], $data['name'], $data['email'], $data['phone'], $data['address']]);
    }

    public function updateClient($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $id]);
    }

    public function deleteClient($id) {
        $stmt = $this->pdo->prepare("DELETE FROM clients WHERE id = ?");
        return $stmt->execute([$id]);
    }
}