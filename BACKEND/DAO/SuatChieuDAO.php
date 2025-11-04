<?php
// File: backend/DAO/SuatChieuDAO.php
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../DTO/SuatChieu.php';

class SuatChieuDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tất cả suất chiếu (cho trang ADMIN/showtimes.php)
    public function getAllSuatChieuDetails() {
        $sql = "SELECT 
                    sc.Id, 
                    p.TenPhim, 
                    r.TenRap, 
                    pc.TenPhong, 
                    sc.NgayChieu, 
                    sc.GioBatDau, 
                    sc.GiaVe,
                    sc.IdPhim,      -- Cần cho nút Sửa
                    sc.IdPhongChieu -- Cần cho nút Sửa
                FROM suatchieu sc
                JOIN phim p ON sc.IdPhim = p.Id
                JOIN phongchieu pc ON sc.IdPhongChieu = pc.Id
                JOIN rap r ON pc.IdRap = r.Id
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

    public function getSuatChieuByPhimId($phim_id) {
        // Tạo lại kết nối
        $this->db = (new Database())->getConnection();
        
        // Câu lệnh SQL JOIN 4 bảng
        $sql = "SELECT 
                    sc.Id, 
                    sc.NgayChieu, 
                    sc.GioBatDau, 
                    sc.GiaVe,
                    r.TenRap, 
                    r.DiaChi, 
                    p.TenPhong
                FROM SuatChieu sc
                JOIN PhongChieu p ON sc.IdPhongChieu = p.Id
                JOIN Rap r ON p.IdRap = r.Id
                WHERE 
                    sc.IdPhim = ? 
                    AND sc.NgayChieu >= CURDATE() -- Chỉ lấy suất chiếu từ hôm nay
                ORDER BY 
                    r.TenRap, sc.NgayChieu, sc.GioBatDau"; // Sắp xếp
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $phim_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $suatChieuList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Trả về mảng kết hợp (vì dữ liệu từ nhiều bảng)
                $suatChieuList[] = $row;
            }
        }
        
        $stmt->close();
        $this->db->close();
        return $suatChieuList;
    }

    /**
     * Phương thức sửa một suất chiếu
     * @param SuatChieu $sc Đối tượng SuatChieu chứa thông tin mới
     * @return bool True nếu sửa thành công, False nếu thất bại
     */
    public function suaSuatChieu(SuatChieu $sc) {
        // Tạo lại kết nối
        $this->db = (new Database())->getConnection();
        
        $sql = "UPDATE suatchieu SET 
                    IdPhim = ?, 
                    IdPhongChieu = ?, 
                    NgayChieu = ?, 
                    GioBatDau = ?, 
                    GiaVe = ? 
                WHERE Id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $idPhim = $sc->getIdPhim();
        $idPhong = $sc->getIdPhongChieu();
        $ngay = $sc->getNgayChieu();
        $gio = $sc->getGioBatDau();
        $gia = $sc->getGiaVe();
        $id = $sc->getId();

        $stmt->bind_param("iissii", $idPhim, $idPhong, $ngay, $gio, $gia, $id);
        
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    public function getSuatChieuDetailsById($id) {
        // Tạo lại kết nối
        $this->db = (new Database())->getConnection();
        
        $sql = "SELECT 
                    sc.Id, sc.NgayChieu, sc.GioBatDau, sc.GiaVe,
                    p.TenPhim, p.XepHang,
                    r.TenRap,
                    pc.TenPhong, pc.Id AS IdPhongChieu
                FROM suatchieu sc
                JOIN phim p ON sc.IdPhim = p.Id
                JOIN phongchieu pc ON sc.IdPhongChieu = pc.Id
                JOIN rap r ON pc.IdRap = r.Id
                WHERE sc.Id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc(); // Lấy 1 hàng
            $stmt->close();
            $this->db->close();
            return $row; // Trả về mảng thông tin
        }
        
        $stmt->close();
        $this->db->close();
        return null; // Không tìm thấy suất chiếu
    }
}
?>