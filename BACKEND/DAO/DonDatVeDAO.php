<?php
// File: backend/DAO/DonDatVeDAO.php
include_once __DIR__ . '/../Database.php';

class DonDatVeDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tóm tắt đơn hàng cho trang Admin (JOIN nhiều bảng)
    public function getDonHangSummary() {
        $sql = "SELECT 
                    ddv.Id, 
                    nd.Email, 
                    p.TenPhim, 
                    sc.NgayChieu, 
                    sc.GioBatDau, 
                    ddv.TongTien, 
                    ddv.NgayDat, 
                    ddv.TrangThai
                FROM DonDatVe ddv
                LEFT JOIN NguoiDung nd ON ddv.IdNguoiDung = nd.Id
                LEFT JOIN SuatChieu sc ON ddv.IdSuatChieu = sc.Id
                LEFT JOIN Phim p ON sc.IdPhim = p.Id
                ORDER BY ddv.NgayDat DESC";
        
        $result = $this->db->query($sql);
        $orderList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $orderList[] = $row;
            }
        }
        $this->db->close();
        return $orderList;
    }

    // Hủy một đơn hàng (Update trạng thái)
    public function huyDonHang($id) {
        $sql = "UPDATE DonDatVe SET TrangThai = 'DaHuy' WHERE Id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    public function taoDonDatVe(DonDatVe $don) {
        // Tạo lại kết nối
        $this->db = (new Database())->getConnection();
        
        $sql = "INSERT INTO dondatve (TongTien, TrangThai, IdNguoiDung, IdSuatChieu) 
                VALUES (?, 'DaThanhToan', ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        $tongTien = $don->getTongTien();
        $idNguoiDung = $don->getIdNguoiDung();
        $idSuatChieu = $don->getIdSuatChieu();
        
        $stmt->bind_param("iii", $tongTien, $idNguoiDung, $idSuatChieu);

        if ($stmt->execute()) {
            // INSERT thành công, lấy ID cuối cùng
            $last_id = $this->db->insert_id;
            $stmt->close();
            $this->db->close();
            return $last_id; // Trả về ID của đơn hàng vừa tạo
        } else {
            $stmt->close();
            $this->db->close();
            return false; // Thất bại
        }
    }

    public function getDonHangByUserId($userId) {
        $this->db = (new Database())->getConnection();
        
        $sql = "SELECT 
                    ddv.Id, 
                    p.TenPhim, 
                    r.TenRap,
                    sc.NgayChieu, 
                    sc.GioBatDau, 
                    ddv.TongTien, 
                    ddv.TrangThai
                FROM dondatve ddv
                LEFT JOIN suatchieu sc ON ddv.IdSuatChieu = sc.Id
                LEFT JOIN phim p ON sc.IdPhim = p.Id
                LEFT JOIN phongchieu pc ON sc.IdPhongChieu = pc.Id
                LEFT JOIN rap r ON pc.IdRap = r.Id
                WHERE ddv.IdNguoiDung = ?
                ORDER BY ddv.NgayDat DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $orderList = [];
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $orderList[] = $row;
            }
        }
        
        $stmt->close();
        $this->db->close();
        return $orderList;
    }

    public function getDonHangDetailsById($orderId, $userId) {
        $this->db = (new Database())->getConnection();
        
        $sql = "SELECT 
                    ddv.Id, ddv.NgayDat, ddv.TongTien, ddv.TrangThai,
                    p.TenPhim, p.PosterUrl, p.ThoiLuong,
                    r.TenRap, r.DiaChi,
                    pc.TenPhong,
                    sc.NgayChieu, sc.GioBatDau
                FROM dondatve ddv
                LEFT JOIN suatchieu sc ON ddv.IdSuatChieu = sc.Id
                LEFT JOIN phim p ON sc.IdPhim = p.Id
                LEFT JOIN phongchieu pc ON sc.IdPhongChieu = pc.Id
                LEFT JOIN rap r ON pc.IdRap = r.Id
                WHERE ddv.Id = ? AND ddv.IdNguoiDung = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $orderId, $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stmt->close();
            $this->db->close();
            return $row; // Trả về mảng thông tin
        }
        
        $stmt->close();
        $this->db->close();
        return null; // Không tìm thấy hoặc không đúng chủ sở hữu
    }
}
?>