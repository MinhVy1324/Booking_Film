<?php
// File: backend/DAO/SuatChieuDAO.php
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../MODEL/SuatChieu.php';

class SuatChieuDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tất cả suất chiếu (cho trang ADMIN/showtimes.php)
    public function getAllSuatChieuDetails() {
        $sql = "SELECT sc.Id, p.TenPhim, r.TenRap, pc.TenPhong, sc.NgayChieu, sc.GioBatDau, sc.GiaVe 
                FROM SuatChieu sc
                JOIN Phim p ON sc.IdPhim = p.Id
                JOIN PhongChieu pc ON sc.IdPhongChieu = pc.Id
                JOIN Rap r ON pc.IdRap = r.Id
                ORDER BY sc.NgayChieu DESC, sc.GioBatDau DESC";
        $result = $this->db->query($sql);
        $scList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $scList[] = $row; // Trả về mảng kết hợp
            }
        }
        $this->db->close();
        return $scList;
    }

    // Thêm suất chiếu
    public function themSuatChieu(SuatChieu $sc) {
        $sql = "INSERT INTO SuatChieu (IdPhim, IdPhongChieu, NgayChieu, GioBatDau, GiaVe) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $idPhim = $sc->getIdPhim();
        $idPhong = $sc->getIdPhongChieu();
        $ngay = $sc->getNgayChieu();
        $gio = $sc->getGioBatDau();
        $gia = $sc->getGiaVe();

        $stmt->bind_param("iissi", $idPhim, $idPhong, $ngay, $gio, $gia);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }
}
?>