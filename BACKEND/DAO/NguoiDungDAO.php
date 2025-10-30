<?php
// File: backend/DAO/NguoiDungDAO.php

// Nạp các file cần thiết
include_once __DIR__ . '/../Database.php'; // Kết nối CSDL
include_once __DIR__ . '/../MODEL/NguoiDung.php'; // Model NguoiDung

class NguoiDungDAO {
    
    private $db; // Biến để giữ kết nối CSDL

    // Hàm khởi tạo (constructor) sẽ tự động chạy khi 'new NguoiDungDAO()'
    public function __construct() {
        // Tạo đối tượng Database và lấy kết nối
        $this->db = (new Database())->getConnection();
    }

    /**
     * Phương thức kiểm tra đăng nhập
     * @param string $email Email người dùng nhập
     * @param string $matKhau Mật khẩu người dùng nhập (chưa hash)
     * @return NguoiDung|null Trả về 1 đối tượng NguoiDung nếu thành công, null nếu thất bại
     */
    public function kiemTraDangNhap($email, $matKhau) {
        // Câu lệnh SQL (dùng PreparedStatement để bảo mật)
        $sql = "SELECT * FROM NguoiDung WHERE Email = ?";
        
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Lỗi prepare statement: " . $this->db->error);
        }
        
        $stmt->bind_param("s", $email); // "s" nghĩa là kiểu string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Tìm thấy email
            $row = $result->fetch_assoc();
            
            // 1. Lấy mật khẩu đã hash từ CSDL
            $matKhauDaHash = $row['MatKhau'];
            
            // 2. So sánh mật khẩu người dùng nhập với mật khẩu đã hash
            if (password_verify($matKhau, $matKhauDaHash)) {
                
                // MẬT KHẨU KHỚP! -> Tạo đối tượng Model NguoiDung
                $user = new NguoiDung();
                $user->setId($row['Id']);
                $user->setHoTen($row['HoTen']);
                $user->setEmail($row['Email']);
                $user->setLoaiNguoiDung($row['LoaiNguoiDung']);
                
                $stmt->close();
                $this->db->close();
                return $user; // Trả về đối tượng người dùng
            }
        }
        
        // Nếu không tìm thấy email HOẶC sai mật khẩu
        $stmt->close();
        $this->db->close();
        return null; // Trả về null
    }

    /**
     * Phương thức kiểm tra Email đã tồn tại chưa
     * @param string $email Email cần kiểm tra
     * @return bool True nếu đã tồn tại, False nếu chưa
     */
    public function emailDaTonTai($email) {
        $sql = "SELECT Id FROM NguoiDung WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tontai = $result->num_rows > 0;
        
        $stmt->close();
        // (Không đóng $this->db ở đây vì có thể hàm themNguoiDung sẽ gọi)
        return $tontai;
    }

    /**
     * Phương thức thêm người dùng mới (dùng cho đăng ký)
     * @param NguoiDung $user Đối tượng NguoiDung (DTO) chứa thông tin (HoTen, Email, MatKhau đã hash)
     * @return bool True nếu thêm thành công, False nếu thất bại
     */
    public function themNguoiDung(NguoiDung $user) {
        $sql = "INSERT INTO NguoiDung (HoTen, Email, MatKhau) VALUES (?, ?, ?)";
        // Vai trò 'KhachHang' sẽ được tự động gán (nhờ DEFAULT trong SQL)
        
        $stmt = $this->db->prepare($sql);
        
        // Lấy dữ liệu từ đối tượng Model
        $hoTen = $user->getHoTen();
        $email = $user->getEmail();
        $matKhauMaHoa = $user->getMatKhau();
        
        $stmt->bind_param("sss", $hoTen, $email, $matKhauMaHoa);

        $thanhCong = $stmt->execute();
        
        $stmt->close();
        $this->db->close();
        return $thanhCong;
    }
}
?>