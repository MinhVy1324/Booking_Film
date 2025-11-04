<?php
// File: BACKEND/BUS/NguoiDungBUS.php

// Nạp các file cần thiết
include_once __DIR__ . '/../DAO/NguoiDungDAO.php'; // Nạp DAO
include_once __DIR__ . '/../DTO/NguoiDung.php';   // Nạp DTO

class NguoiDungBUS {
    
    private $nguoiDungDAO;

    public function __construct() {
        // Khởi tạo DAO (Đầu bếp)
        $this->nguoiDungDAO = new NguoiDungDAO();
    }

    /**
     * Xử lý logic nghiệp vụ cho việc Đăng Nhập
     * @param string $email
     * @param string $matKhau
     * @return NguoiDung|null Trả về đối tượng NguoiDung nếu thành công, null nếu thất bại
     */
    public function xuLyDangNhap($email, $matKhau) {
        // 1. Kiểm tra nghiệp vụ (ví dụ: email có hợp lệ không)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null; // Email không hợp lệ
        }
        
        // 2. Mọi thứ ổn, yêu cầu DAO (Đầu bếp) kiểm tra
        $user = $this->nguoiDungDAO->kiemTraDangNhap($email, $matKhau);
        
        return $user; // Trả về kết quả (đối tượng User hoặc null)
    }

    /**
     * Xử lý logic nghiệp vụ cho việc Đăng Ký
     * @param string $hoTen
     * @param string $email
     * @param string $matKhau
     * @param string $matKhauNhapLai
     * @return array Trả về mảng [status (bool), message (string)]
     */
    public function xuLyDangKy($hoTen, $email, $matKhau, $matKhauNhapLai) {
        
        // LUẬT 1: Kiểm tra mật khẩu có trùng khớp không
        if ($matKhau !== $matKhauNhapLai) {
            return [
                'status' => false,
                'message' => 'password' // Gửi mã lỗi 'password'
            ];
        }

        // LUẬT 2: Kiểm tra email có hợp lệ không
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => false,
                'message' => 'email_invalid' // Mã lỗi email không hợp lệ
            ];
        }
        
        // LUẬT 3: Kiểm tra email đã tồn tại chưa (BUS gọi DAO)
        if ($this->nguoiDungDAO->emailDaTonTai($email)) {
            return [
                'status' => false,
                'message' => 'email' // Gửi mã lỗi 'email'
            ];
        }

        // LUẬT 4: Mật khẩu phải đủ mạnh (ví dụ)
        if (strlen($matKhau) < 6) {
             return [
                'status' => false,
                'message' => 'password_short' // Gửi mã lỗi 'password_short'
            ];
        }

        // TẤT CẢ LUẬT ĐÃ OK!
        
        // 1. Mã hóa mật khẩu
        $matKhauMaHoa = password_hash($matKhau, PASSWORD_DEFAULT);

        // 2. Tạo đối tượng DTO (NguoiDung)
        $userMoi = new NguoiDung();
        $userMoi->setHoTen($hoTen);
        $userMoi->setEmail($email);
        $userMoi->setMatKhau($matKhauMaHoa);
        
        // 3. Yêu cầu DAO (Đầu bếp) lưu vào CSDL
        if ($this->nguoiDungDAO->themNguoiDung($userMoi)) {
            return [
                'status' => true,
                'message' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'stmtfailed' // Lỗi CSDL
            ];
        }
    }
}
?>