<?php
// File: BACKEND/DAO/PhimDAO.php

// (Dùng __DIR__ để đảm bảo đường dẫn luôn đúng)
include_once __DIR__ . '/../Database.php'; 
include_once __DIR__ . '/../DTO/Phim.php'; // Sửa 'MODEL' thành 'DTO' cho khớp

class PhimDAO {
    private $db;
    
    // Hàm khởi tạo để lấy kết nối
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tất cả phim (cho trang Admin)
    public function getAllPhim() {
        $sql = "SELECT * FROM Phim ORDER BY NgayKhoiChieu DESC";
        $result = $this->db->query($sql);
        $phimList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $phim = new Phim();
                $phim->setId($row['Id']);
                $phim->setTenPhim($row['TenPhim']);
                $phim->setThoiLuong($row['ThoiLuong']);
                $phim->setXepHang($row['XepHang']);
                $phimList[] = $phim;
            }
        }
        $this->db->close();
        return $phimList;
    }

    // Thêm 1 phim (nhận vào 1 đối tượng Phim)
    public function themPhim(Phim $phim) {
        $sql = "INSERT INTO Phim (TenPhim, MoTa, NgayKhoiChieu, ThoiLuong, PosterUrl, TheLoai, XepHang) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $tenPhim = $phim->getTenPhim();
        $moTa = $phim->getMoTa();
        $ngay = $phim->getNgayKhoiChieu();
        $thoiLuong = $phim->getThoiLuong();
        $poster = $phim->getPosterUrl();
        $theLoai = $phim->getTheLoai();
        $xepHang = $phim->getXepHang();
        
        $stmt->bind_param("sssisss", $tenPhim, $moTa, $ngay, $thoiLuong, $poster, $theLoai, $xepHang);
        
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    public function suaPhim(Phim $phim) {
        $this->db = (new Database())->getConnection();
        
        $sql = "UPDATE phim SET 
                    TenPhim = ?, 
                    MoTa = ?, 
                    NgayKhoiChieu = ?, 
                    ThoiLuong = ?, 
                    PosterUrl = ?, 
                    TheLoai = ?, 
                    XepHang = ? 
                WHERE Id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $tenPhim = $phim->getTenPhim();
        $moTa = $phim->getMoTa();
        $ngay = $phim->getNgayKhoiChieu();
        $thoiLuong = $phim->getThoiLuong();
        $poster = $phim->getPosterUrl();
        $theLoai = $phim->getTheLoai();
        $xepHang = $phim->getXepHang();
        $id = $phim->getId(); // ID của phim cần sửa

        $stmt->bind_param("sssisssi", $tenPhim, $moTa, $ngay, $thoiLuong, $poster, $theLoai, $xepHang, $id);
        
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    // Xóa 1 phim
    public function xoaPhim($id) {
        $sql = "DELETE FROM Phim WHERE Id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    // --- PHƯƠNG THỨC MỚI CHO TRANG INDEX ---
    
    /**
     * Lấy danh sách phim Đang Chiếu
     * @return array Mảng các đối tượng Phim
     */
    public function getPhimDangChieu() {
        // (Không cần tạo lại kết nối nếu __construct đã tạo)
        
        $sql = "SELECT * FROM Phim WHERE NgayKhoiChieu <= CURDATE()";
        $result = $this->db->query($sql);
        $phimList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $phim = new Phim();
                $phim->setId($row['Id']);
                $phim->setTenPhim($row['TenPhim']);
                $phim->setPosterUrl($row['PosterUrl']);
                $phim->setTheLoai($row['TheLoai']);
                $phim->setThoiLuong($row['ThoiLuong']);
                $phimList[] = $phim;
            }
        }
        $this->db->close();
        return $phimList;
    }

    /**
     * Lấy danh sách phim Sắp Chiếu
     * @return array Mảng các đối tượng Phim
     */
    public function getPhimSapChieu() {
        // Phải tạo lại kết nối VÌ hàm getPhimDangChieu() ở trên đã đóng nó
        $this->db = (new Database())->getConnection();
        
        $sql = "SELECT * FROM Phim WHERE NgayKhoiChieu > CURDATE()";
        $result = $this->db->query($sql);
        $phimList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $phim = new Phim();
                $phim->setId($row['Id']);
                $phim->setTenPhim($row['TenPhim']);
                $phim->setPosterUrl($row['PosterUrl']);
                $phim->setTheLoai($row['TheLoai']);
                $phim->setThoiLuong($row['ThoiLuong']);
                $phimList[] = $phim;
            }
        }
        $this->db->close();
        return $phimList;
    }

    public function getPhimById($id) {
        // Phải tạo lại kết nối vì các hàm khác có thể đã đóng
        $this->db = (new Database())->getConnection();
        
        $sql = "SELECT * FROM Phim WHERE Id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            // Tạo đối tượng Model Phim
            $phim = new Phim();
            $phim->setId($row['Id']);
            $phim->setTenPhim($row['TenPhim']);
            $phim->setMoTa($row['MoTa']);
            $phim->setTheLoai($row['TheLoai']);
            $phim->setThoiLuong($row['ThoiLuong']);
            $phim->setNgayKhoiChieu($row['NgayKhoiChieu']);
            $phim->setPosterUrl($row['PosterUrl']);
            $phim->setXepHang($row['XepHang']);

            $stmt->close();
            $this->db->close();
            return $phim;
        }
        
        $stmt->close();
        $this->db->close();
        return null; // Không tìm thấy phim
    }

    public function getPhimSapChieuNoiBat() {
        // (Tạo lại kết nối)
        $this->db = (new Database())->getConnection();
        
        // Lấy phim có ngày khởi chiếu trong tương lai VÀ gần nhất
        $sql = "SELECT * FROM phim 
                WHERE NgayKhoiChieu > CURDATE() 
                ORDER BY NgayKhoiChieu ASC 
                LIMIT 1";
        
        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            // Tạo đối tượng DTO (Model)
            $phim = new Phim();
            $phim->setId($row['Id']);
            $phim->setTenPhim($row['TenPhim']);
            $phim->setMoTa($row['MoTa']);
            $phim->setTheLoai($row['TheLoai']);
            $phim->setThoiLuong($row['ThoiLuong']);
            $phim->setNgayKhoiChieu($row['NgayKhoiChieu']);
            $phim->setPosterUrl($row['PosterUrl']);
            $phim->setXepHang($row['XepHang']);

            $this->db->close();
            return $phim;
        }
        
        $this->db->close();
        return null; // Không tìm thấy phim nào sắp chiếu
    }
}
?>