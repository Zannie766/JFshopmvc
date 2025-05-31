<?php
require_once __DIR__ . '/../../Core/Database.php';
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($fullname, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (fullname, username, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fullname, $username, $hashedPassword]);
        return $this->db->lastInsertId();
    }
    public function isUsernameExists($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
    
}
