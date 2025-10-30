<?php
// File: backend/DAO/PhimDAO.php
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../MODEL/Phim.php';

class PhimDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tất cả phim
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
}
?>