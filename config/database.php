<?php
class Database {
    private $host = "localhost";
    private $db_name = "docunest";
    private $username = "root";
    private $password = "";
    public $conn;

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
            // ✅ Log error to PHP error log instead of displaying to user
            error_log("Connection error: " . $exception->getMessage()); 
            // ❌ Optional: If you need to stop execution on failure
            // die("Database connection failed. Check your configuration."); 
        }
        return $this->conn;
    }
}
