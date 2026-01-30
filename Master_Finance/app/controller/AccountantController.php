<?php
namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\InvoiceModel;
use App\Models\AuditModel;
use App\Core\Middleware;
use PDO;

class AccountantController {
    private $pdo;
    private $transactionModel;
    private $invoiceModel;
    private $auditModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->transactionModel = new TransactionModel($pdo);
        $this->invoiceModel = new InvoiceModel($pdo);
        $this->auditModel = new AuditModel($pdo);
        Middleware::requireRole('accountant');
    }

    public function manageTransactions() {
        $transactions = $this->transactionModel->getAllTransactions();
        include __DIR__ . '/../Views/accountant_transactions.html';
    }

    public function addTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Middleware::csrfCheck();
            $data = [
                'client_id' => (int)$_POST['client_id'],
                'type' => $_POST['type'],
                'amount' => (float)$_POST['amount'],
                'description' => filter_var($_POST['description'], FILTER_SANITIZE_STRING),
                'category' => filter_var($_POST['category'], FILTER_SANITIZE_STRING)
            ];
            $this->transactionModel->createTransaction($data);
            $this->auditModel->logAction($_SESSION['user_id'], 'add_transaction', 'Added transaction for client ID: ' . $data['client_id']);
            header('Location: /accountant/transactions');
            exit;
        }
        include __DIR__ . '/../Views/accountant_transactions.html';
    }

    public function generateInvoice() {
        // Similar to addTransaction, using InvoiceModel
        $this->invoiceModel->createInvoice($_POST);
        header('Location: /accountant/invoices');
        exit;
    } 
}