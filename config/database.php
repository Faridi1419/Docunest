<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Use environment variables or fallback to defaults
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->db_name = $_ENV['DB_NAME'] ?? 'docunest';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
    }

    // config/Database.php

// ... (class definition)

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                // Use a standard approach to connection string
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            // Log error to PHP error log instead of displaying to user
            error_log("Database connection error: " . $exception->getMessage()); 
            // Return null to allow graceful handling
            $this->conn = null;
        }
        return $this->conn;
    }
}
