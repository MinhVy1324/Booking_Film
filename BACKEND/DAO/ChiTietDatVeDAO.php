<?php
// File: BACKEND/DAO/ChiTietDatVeDAO.php

// (Dùng __DIR__ để có đường dẫn tuyệt đối, an toàn)
include_once __DIR__ . '/../Database.php'; 
// (Chúng ta không cần DTO/Model ở đây vì chỉ trả về 1 mảng ID)

class ChiTietDatVeDAO {
    
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Lấy danh sách ID các ghế ĐÃ BỊ ĐẶT của MỘT suất chiếu
     * @param int $idSuatChieu ID của suất chiếu
     * @return array Trả về một mảng chứa các ID ghế đã bị đặt (ví dụ: [1, 5, 10])
     */
    public function getGheDaDat($idSuatChieu) {
        
        $sql = "SELECT ctdv.IdGhe 
                FROM chitietdatve ctdv
                JOIN dondatve ddv ON ctdv.IdDonDatVe = ddv.Id
                WHERE ddv.IdSuatChieu = ? AND ddv.TrangThai = 'DaThanhToan'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idSuatChieu);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $gheDaDatList = []; // Mảng để chứa các ID ghế

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Thêm ID ghế vào mảng
                $gheDaDatList[] = $row['IdGhe'];
            }
        }
        
        $stmt->close();
        $this->db->close();
        return $gheDaDatList;
    }

    public function themChiTiet(ChiTietDatVe $ctdv) {
        // (Không tạo kết nối mới nếu hàm này được gọi trong 1 vòng lặp)
        if ($this->db == null || $this->db->ping() == false) {
             $this->db = (new Database())->getConnection();
        }

        $sql = "INSERT INTO chitietdatve (GiaVe, IdDonDatVe, IdGhe) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $giaVe = $ctdv->getGiaVe();
        $idDon = $ctdv->getIdDonDatVe();
        $idGhe = $ctdv->getIdGhe();
        
        $stmt->bind_param("iii", $giaVe, $idDon, $idGhe);
        
        $success = $stmt->execute();
        $stmt->close();
        // (Không đóng kết nối ở đây, để BookingController đóng)
        return $success;
    }
    
    // Hàm đóng kết nối (để Controller gọi sau khi lặp xong)
    public function closeConnection() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>