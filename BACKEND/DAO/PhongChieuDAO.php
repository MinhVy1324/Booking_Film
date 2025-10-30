<?php
// File: backend/DAO/PhongChieuDAO.php
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../MODEL/PhongChieu.php';

class PhongChieuDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy phòng theo Id Rạp (cho trang ADMIN/rooms.php)
    public function getPhongByRapId($idRap) {
        $sql = "SELECT * FROM PhongChieu WHERE IdRap = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idRap);
        $stmt->execute();
        $result = $stmt->get_result();
        $phongList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $phong = new PhongChieu();
                $phong->setId($row['Id']);
                $phong->setTenPhong($row['TenPhong']);
                $phong->setSoLuongGhe($row['SoLuongGhe']);
                $phongList[] = $phong;
            }
        }
        $stmt->close();
        return $phongList; // Không đóng DB ở đây vì RapDAO có thể đang dùng
    }

    // Thêm phòng
    public function themPhong(PhongChieu $phong) {
        $sql = "INSERT INTO PhongChieu (TenPhong, SoLuongGhe, IdRap) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $ten = $phong->getTenPhong();
        $sl = $phong->getSoLuongGhe();
        $idRap = $phong->getIdRap();
        $stmt->bind_param("sii", $ten, $sl, $idRap);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    // Lấy tất cả phòng (kèm tên rạp, cho dropdown của trang Suất Chiếu)
    public function getAllPhongWithRap() {
        $sql = "SELECT pc.Id, pc.TenPhong, r.TenRap 
                FROM PhongChieu pc 
                JOIN Rap r ON pc.IdRap = r.Id 
                ORDER BY r.TenRap, pc.TenPhong";
        $result = $this->db->query($sql);
        // Trả về mảng kết hợp (associative array) đơn giản
        $phongList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $phongList[] = $row;
            }
        }
        $this->db->close();
        return $phongList;
    }
}
?>