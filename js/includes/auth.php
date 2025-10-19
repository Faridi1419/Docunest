<?php
// includes/auth.php
require_once __DIR__ . '/../config/database.php';

class Auth {
    private $db;
    private $session;

    public function isConnected() {
        return $this->db !== null;
    }

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function setSession($session) {
        $this->session = $session;
    }

    public function register($userData) {
        try {
            // Validate input
            if (empty($userData['email']) || empty($userData['password']) || 
                empty($userData['first_name']) || empty($userData['last_name'])) {
                return ['success' => false, 'message' => 'All fields are required'];
            }

            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Invalid email format'];
            }

            if (strlen($userData['password']) < 6) {
                return ['success' => false, 'message' => 'Password must be at least 6 characters'];
            }

            if ($userData['password'] !== $userData['confirm_password']) {
                return ['success' => false, 'message' => 'Passwords do not match'];
            }

            // Check if email exists
            $query = "SELECT id FROM users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userData['email']]);

            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email already exists'];
            }

            // Create user
            $password_hash = password_hash($userData['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO users (email, password_hash, first_name, last_name, university, major, year_of_study) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

            $success = $stmt->execute([
                $userData['email'],
                $password_hash,
                $userData['first_name'],
                $userData['last_name'],
                $userData['university'] ?? null,
                $userData['major'] ?? null,
                $userData['year_of_study'] ?? null
            ]);

            if ($success) {
                return ['success' => true, 'message' => 'Registration successful! You can now login.'];
            } else {
                return ['success' => false, 'message' => 'Registration failed. Please try again.'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Login successful - set session data
                if ($this->session) {
                    $this->session->login($user);
                } else {
                    // Fallback: set session manually
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['user_type'] = $user['user_type'] ?? 'student';
                    $_SESSION['university'] = $user['university'];
                    $_SESSION['logged_in'] = true;
                }
                return ['success' => true, 'message' => 'Login successful!'];
            } else {
                return ['success' => false, 'message' => 'Invalid email or password'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function logout() {
        if ($this->session) {
            $this->session->logout();
        } else {
            // Fallback: destroy session manually
            session_start();
            $_SESSION = array();
            session_destroy();
        }
        return ['success' => true, 'message' => 'Logged out successfully'];
    }

    public function getUserById($id) {
        try {
            // Check if database connection exists
            if (!$this->db) {
                error_log("Database connection is null in getUserById");
                return null;
            }
            
            $query = "SELECT id, email, first_name, last_name, user_type, university, major, year_of_study, profile_picture, created_at 
                      FROM users WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserById: " . $e->getMessage());
            return null;
        }
    }

    public function updateUserProfile($userId, $userData) {
        try {
            $query = "UPDATE users SET first_name = ?, last_name = ?, university = ?, major = ?, year_of_study = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute([
                $userData['first_name'],
                $userData['last_name'],
                $userData['university'],
                $userData['major'],
                $userData['year_of_study'],
                $userId
            ]);

            if ($success && $this->session) {
                // Update session
                $_SESSION['first_name'] = $userData['first_name'];
                $_SESSION['last_name'] = $userData['last_name'];
                $_SESSION['university'] = $userData['university'];
            }

            return $success;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            // Verify current password
            $query = "SELECT password_hash FROM users WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                return ['success' => false, 'message' => 'Current password is incorrect'];
            }

            // Update to new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password_hash = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute([$newPasswordHash, $userId]);

            if ($success) {
                return ['success' => true, 'message' => 'Password updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update password'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function emailExists($email) {
        try {
            $query = "SELECT id FROM users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllUsers() {
        try {
            $query = "SELECT id, email, first_name, last_name, user_type, university, major, created_at 
                      FROM users ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

// Don't create global instance here - let the calling files handle it
?>