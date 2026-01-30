<?php
namespace App\Models;

use PDO;

class InvoiceModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllInvoices() {
        $stmt = $this->pdo->query("SELECT * FROM invoices ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getInvoicesByClient($clientId) {
        $stmt = $this->pdo->prepare("SELECT * FROM invoices WHERE client_id = ? ORDER BY created_at DESC");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }

    public function createInvoice($data) {
        $stmt = $this->pdo->prepare("INSERT INTO invoices (client_id, amount, status, due_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['client_id'], $data['amount'], $data['status'], $data['due_date']]);
    }

    public function updateInvoice($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE invoices SET amount = ?, status = ?, due_date = ? WHERE id = ?");
        return $stmt->execute([$data['amount'], $data['status'], $data['due_date'], $id]);
    }

    public function deleteInvoice($id) {
        $stmt = $this->pdo->prepare("DELETE FROM invoices WHERE id = ?");
        return $stmt->execute([$id]);
    }
}