<?php
namespace App\Models;

use PDO;

class TransactionModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllTransactions() {
        $stmt = $this->pdo->query("SELECT * FROM transactions ORDER BY date DESC");
        return $stmt->fetchAll();
    }

    public function getTransactionsByClient($clientId) {
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE client_id = ? ORDER BY date DESC");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }

    public function createTransaction($data) {
        $stmt = $this->pdo->prepare("INSERT INTO transactions (client_id, type, amount, description, category) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['client_id'], $data['type'], $data['amount'], $data['description'], $data['category']]);
    }

    public function updateTransaction($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE transactions SET type = ?, amount = ?, description = ?, category = ? WHERE id = ?");
        return $stmt->execute([$data['type'], $data['amount'], $data['description'], $data['category'], $id]);
    }

    public function deleteTransaction($id) {
        $stmt = $this->pdo->prepare("DELETE FROM transactions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}