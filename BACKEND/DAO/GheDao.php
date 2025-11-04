<?php
// File: BACKEND/DAO/GheDAO.php

// (Dùng __DIR__ để có đường dẫn tuyệt đối, an toàn)
include_once __DIR__ . '/../Database.php'; 
include_once __DIR__ . '/../DTO/Ghe.php';

class GheDAO {
    
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Lấy toàn bộ sơ đồ ghế của MỘT phòng chiếu
     * @param int $idPhongChieu ID của phòng chiếu
     * @return array Trả về một mảng chứa các đối tượng Ghe
     */
    public function getGheByPhongChieuId($idPhongChieu) {
        
        $sql = "SELECT * FROM ghe WHERE IdPhongChieu = ? 
                ORDER BY 
                    LEFT(TenGhe, 1) ASC, -- Sắp xếp theo chữ cái (A, B, C...)
                    CAST(SUBSTRING(TenGhe, 2) AS UNSIGNED) ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idPhongChieu);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $gheList = []; // Mảng để chứa các đối tượng Ghế

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Tạo đối tượng DTO/Ghe
                $ghe = new Ghe();
                $ghe->setId($row['Id']);
                $ghe->setTenGhe($row['TenGhe']);
                $ghe->setLoaiGhe($row['LoaiGhe']);
                $ghe->setIdPhongChieu($row['IdPhongChieu']);
                
                // Thêm đối tượng vào mảng
                $gheList[] = $ghe;
            }
        }
        
        $stmt->close();
        $this->db->close();
        return $gheList;
    }

    public function getGheById($idGhe) {
        $this->db = (new Database())->getConnection();
        $sql = "SELECT * FROM ghe WHERE Id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idGhe);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $ghe = new Ghe();
            $ghe->setId($row['Id']);
            $ghe->setTenGhe($row['TenGhe']);
            $ghe->setLoaiGhe($row['LoaiGhe']);
            $ghe->setIdPhongChieu($row['IdPhongChieu']);
            
            $stmt->close();
            $this->db->close();
            return $ghe;
        }
        $stmt->close();
        $this->db->close();
        return null;
    }

    public function themGhe(Ghe $ghe) {
        $this->db = (new Database())->getConnection();
        
        $sql = "INSERT INTO ghe (TenGhe, LoaiGhe, IdPhongChieu) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $ten = $ghe->getTenGhe();
        $loai = $ghe->getLoaiGhe();
        $idPhong = $ghe->getIdPhongChieu();

        $stmt->bind_param("ssi", $ten, $loai, $idPhong);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }

    public function xoaGhe($idGhe) {
        $this->db = (new Database())->getConnection();
        
        $sql = "DELETE FROM ghe WHERE Id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idGhe);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }
}
?>