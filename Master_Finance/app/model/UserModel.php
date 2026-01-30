<?php
namespace App\Models;

use PDO;

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function createUser($data) {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['username'], $data['email'], $hash, $data['role']]);
            }

    public function updateUser($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE users SET username = ?, email = ?, role = ?, is_active = ? WHERE id = ?");
        return $stmt->execute([$data['username'], $data['email'], $data['role'], $data['is_active'], $id]);
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateLastLogin($id) {
        $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getAnalytics() {
        $stmt = $this->pdo->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
        return $stmt->fetchAll();
    }
}