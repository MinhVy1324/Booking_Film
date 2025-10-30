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
}
?>DashboardDAO.php