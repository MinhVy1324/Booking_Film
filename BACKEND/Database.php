<?php
// File: backend/config/Database.php

class Database {
    // Thông tin CSDL (XAMPP)
    private $host = "localhost";
    private $db_name = "bookingfilm";
    private $username = "root";
    private $password = ""; // Mật khẩu XAMPP mặc định là rỗng
    public $conn;

    // Phương thức (method) để lấy kết nối
    public function getConnection() {
        $this->conn = null; // Reset kết nối

        try {
            // Tạo đối tượng kết nối mysqli
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            // Set bảng mã UTF-8
            $this->conn->set_charset("utf8mb4");

        } catch(Exception $e) {
            echo "Lỗi kết nối CSDL: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>