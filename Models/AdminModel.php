<?php
class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function countUsers() {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) FROM users");
            return $stmt->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            error_log("Error counting users: " . $e->getMessage());
            return 0;
        }
    }

    public function getRecentActivities($limit) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM activities ORDER BY created_at DESC LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting recent activities: " . $e->getMessage());
            return [];
        }
    }

    public function verifyPassword($password) {
        try {
            $stmt = $this->db->query("SELECT value FROM settings WHERE key_name = 'admin_password'");
            $storedPassword = $stmt->fetchColumn();
            
            // Use password_verify for hashed passwords or direct comparison for plain text
            if (password_get_info($storedPassword)['algo'] !== 0) {
                return password_verify($password, $storedPassword);
            } else {
                return $password === $storedPassword;
            }
        } catch (PDOException $e) {
            error_log("Error verifying password: " . $e->getMessage());
            return false;
        }
    }

    public function calculateTotalRevenue() {
        try {
            $stmt = $this->db->query("SELECT SUM(amount) FROM revenue_records");
            return $stmt->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            error_log("Error calculating total revenue: " . $e->getMessage());
            return 0;
        }
    }

    public function getRevenueRecords($limit = 10) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM revenue_records ORDER BY date DESC LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting revenue records: " . $e->getMessage());
            return [];
        }
    }

    public function addRevenue($amount, $description, $date) {
        try {
            $stmt = $this->db->prepare("INSERT INTO revenue_records (amount, description, date, created_at) VALUES (:amount, :description, :date, NOW())");
            return $stmt->execute([
                'amount' => floatval($amount), 
                'description' => $description, 
                'date' => $date
            ]);
        } catch (PDOException $e) {
            error_log("Error adding revenue: " . $e->getMessage());
            throw new Exception("Không thể thêm doanh thu");
        }
    }

    public function updateRevenue($id, $amount, $description, $date) {
        try {
            $stmt = $this->db->prepare("UPDATE revenue_records SET amount = :amount, description = :description, date = :date, updated_at = NOW() WHERE id = :id");
            return $stmt->execute([
                'id' => intval($id), 
                'amount' => floatval($amount), 
                'description' => $description, 
                'date' => $date
            ]);
        } catch (PDOException $e) {
            error_log("Error updating revenue: " . $e->getMessage());
            throw new Exception("Không thể cập nhật doanh thu");
        }
    }

    public function deleteRevenue($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM revenue_records WHERE id = :id");
            return $stmt->execute(['id' => intval($id)]);
        } catch (PDOException $e) {
            error_log("Error deleting revenue: " . $e->getMessage());
            throw new Exception("Không thể xóa doanh thu");
        }
    }

    public function getMonthlyRevenue($months) {
        try {
            $stmt = $this->db->prepare(
                "SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS revenue
                 FROM revenue_records 
                 WHERE date >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
                 GROUP BY month 
                 ORDER BY month ASC"
            );
            $stmt->execute([$months]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $data = [];
            foreach ($results as $row) {
                $data[$row['month']] = (float)$row['revenue'];
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error getting monthly revenue: " . $e->getMessage());
            return [];
        }
    }

    // User management methods
    public function getUsers($limit = null) {
        try {
            $sql = "SELECT id, username, email, revenue, created_at FROM users ORDER BY created_at DESC";
            if ($limit) {
                $sql .= " LIMIT " . intval($limit);
            }
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting users: " . $e->getMessage());
            return [];
        }
    }

    public function addUser($username, $email, $revenue) {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, email, revenue, created_at) VALUES (:username, :email, :revenue, NOW())");
            return $stmt->execute([
                'username' => trim($username),
                'email' => trim($email),
                'revenue' => floatval($revenue)
            ]);
        } catch (PDOException $e) {
            error_log("Error adding user: " . $e->getMessage());
            if ($e->getCode() == 23000) {
                throw new Exception("Email hoặc tên người dùng đã tồn tại");
            }
            throw new Exception("Không thể thêm người dùng");
        }
    }

    public function updateUser($id, $username, $email, $revenue) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, revenue = :revenue, updated_at = NOW() WHERE id = :id");
            return $stmt->execute([
                'id' => intval($id),
                'username' => trim($username),
                'email' => trim($email),
                'revenue' => floatval($revenue)
            ]);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            if ($e->getCode() == 23000) {
                throw new Exception("Email hoặc tên người dùng đã tồn tại");
            }
            throw new Exception("Không thể cập nhật người dùng");
        }
    }

    public function deleteUser($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute(['id' => intval($id)]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            throw new Exception("Không thể xóa người dùng");
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => intval($id)]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting user by ID: " . $e->getMessage());
            return null;
        }
    }
}
?>