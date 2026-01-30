<?php
namespace App\Controllers;

use App\Models\TransactionModel;
use App\Core\Middleware;
use PDO;
use lib\Export;

class ApiController {
    private $pdo;
    private $transactionModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->transactionModel = new TransactionModel($pdo);
        Middleware::csrfCheck();
    }

    public function getTransactions() {
        header('Content-Type: application/json');
        $transactions = $this->transactionModel->getAllTransactions();
        echo json_encode($transactions);
    }

    public function search() {
        $query = $_GET['q'] ?? '';
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE description LIKE ?");
        $stmt->execute(['%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($results);
    }

    
}