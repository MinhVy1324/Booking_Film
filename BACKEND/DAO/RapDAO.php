<?php
// File: backend/DAO/RapDAO.php
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../MODEL/Rap.php';

class RapDAO {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lấy tất cả rạp
    public function getAllRap() {
        $sql = "SELECT * FROM Rap";
        $result = $this->db->query($sql);
        $rapList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rap = new Rap();
                $rap->setId($row['Id']);
                $rap->setTenRap($row['TenRap']);
                $rap->setDiaChi($row['DiaChi']);
                $rapList[] = $rap;
            }
        }
        $this->db->close();
        return $rapList;
    }

    // Thêm rạp
    public function themRap(Rap $rap) {
        $sql = "INSERT INTO Rap (TenRap, DiaChi) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $ten = $rap->getTenRap();
        $diaChi = $rap->getDiaChi();
        $stmt->bind_param("ss", $ten, $diaChi);
        $success = $stmt->execute();
        $stmt->close();
        $this->db->close();
        return $success;
    }
}
?>