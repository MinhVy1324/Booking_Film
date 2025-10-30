<?php
// File: backend/DAO/DashboardDAO.php
include_once __DIR__ . '/../Database.php';

class DashboardDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy 4 thẻ KPI
    public function getKpiData() {
        $data = [];

        // 1. Doanh thu hôm nay
        $sql_dt_hom_nay = "SELECT SUM(TongTien) AS DoanhThuHomNay FROM DonDatVe 
                           WHERE TrangThai = 'DaThanhToan' AND DATE(NgayDat) = CURDATE()";
        $result = $this->db->query($sql_dt_hom_nay);
        $data['DoanhThuHomNay'] = $result->fetch_assoc()['DoanhThuHomNay'] ?? 0;

        // 2. Vé bán hôm nay
        $sql_ve_hom_nay = "SELECT COUNT(ctdv.Id) AS VeHomNay FROM ChiTietDatVe ctdv
                           JOIN DonDatVe ddv ON ctdv.IdDonDatVe = ddv.Id
                           WHERE ddv.TrangThai = 'DaThanhToan' AND DATE(ddv.NgayDat) = CURDATE()";
        $result = $this->db->query($sql_ve_hom_nay);
        $data['VeHomNay'] = $result->fetch_assoc()['VeHomNay'] ?? 0;

        // 3. Phim đang chiếu (Tổng số phim)
        $sql_phim = "SELECT COUNT(Id) AS TongPhim FROM Phim";
        $result = $this->db->query($sql_phim);
        $data['TongPhim'] = $result->fetch_assoc()['TongPhim'] ?? 0;

        // 4. Tổng thành viên (Khách hàng)
        $sql_user = "SELECT COUNT(Id) AS TongThanhVien FROM NguoiDung WHERE LoaiNguoiDung = 'KhachHang'";
        $result = $this->db->query($sql_user);
        $data['TongThanhVien'] = $result->fetch_assoc()['TongThanhVien'] ?? 0;

        return $data;
    }

    // Lấy dữ liệu cho biểu đồ (7 ngày qua)
    public function getRevenueChartData() {
        $sql = "SELECT 
                    DATE(NgayDat) AS Ngay, 
                    SUM(TongTien) AS DoanhThu
                FROM DonDatVe
                WHERE TrangThai = 'DaThanhToan' AND NgayDat >= CURDATE() - INTERVAL 7 DAY
                GROUP BY DATE(NgayDat)
                ORDER BY Ngay ASC";
        
        $result = $this->db->query($sql);
        $chartData = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $chartData[] = $row;
            }
        }
        $this->db->close();
        return $chartData;
    }
}
?>