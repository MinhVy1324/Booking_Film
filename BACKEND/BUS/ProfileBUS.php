<?php
// File: BACKEND/BUS/ProfileBUS.php

include_once __DIR__ . '/../DAO/NguoiDungDAO.php';
include_once __DIR__ . '/../DTO/NguoiDung.php';

class ProfileBUS {
    private $nguoiDungDAO;

    public function __construct() {
        $this->nguoiDungDAO = new NguoiDungDAO();
    }

    /**
     * Xử lý nghiệp vụ cập nhật thông tin cá nhân
     * @return array ['status' => bool, 'message' => string]
     */
    public function xuLyCapNhatThongTin($id, $hoTen, $sdt, $NgaySinh) {
        
        // LUẬT 1: Họ tên không được để trống
        if (empty(trim($hoTen))) {
            return ['status' => false, 'message' => 'empty_name'];
        }

        // LUẬT 2: SĐT phải là số (ví dụ đơn giản)
        if (!is_numeric($sdt) || strlen($sdt) < 10) {
            return ['status' => false, 'message' => 'invalid_phone'];
        }

        // LUẬT 3: Kiểm tra ngày sinh hợp lệ (nếu có nhập)
        if ($NgaySinh !== null) {
            $d = DateTime::createFromFormat('Y-m-d', $NgaySinh);
            if (!$d || $d->format('Y-m-d') !== $NgaySinh) {
                 return ['status' => false, 'message' => 'invalid_dob'];
            }
        }

        // Mọi thứ OK
        
        // 1. Tạo đối tượng DTO
        $user = new NguoiDung();
        $user->setId((int)$id);
        $user->setHoTen($hoTen);
        $user->setSoDienThoai($sdt);
        $user->setNgaySinh(empty($NgaySinh) ? null : $NgaySinh); // Cho phép NULL

        // 2. Yêu cầu DAO cập nhật
        if ($this->nguoiDungDAO->updateThongTinCaNhan($user)) {
            return ['status' => true, 'message' => 'update_success'];
        } else {
            return ['status' => false, 'message' => 'error'];
        }
    }

    public function xuLyDoiMatKhau($id, $matKhauCu, $matKhauMoi, $matKhauNhapLai) {
        
        // LUẬT 1: Mật khẩu mới phải khớp
        if ($matKhauMoi !== $matKhauNhapLai) {
            return ['status' => false, 'message' => 'password_mismatch'];
        }
        
        // LUẬT 2: Mật khẩu mới phải đủ mạnh
        if (strlen($matKhauMoi) < 6) {
            return ['status' => false, 'message' => 'password_short'];
        }

        // LUẬT 3: Kiểm tra mật khẩu cũ có đúng không
        $matKhauCuDaHash = $this->nguoiDungDAO->getMatKhauById($id);
        if ($matKhauCuDaHash == null || !password_verify($matKhauCu, $matKhauCuDaHash)) {
            return ['status' => false, 'message' => 'old_password_wrong'];
        }
        
        // Mọi thứ OK
        
        // 1. Mã hóa mật khẩu mới
        $matKhauMoiMaHoa = password_hash($matKhauMoi, PASSWORD_DEFAULT);
        
        // 2. Yêu cầu DAO cập nhật
        // (Phải tạo DAO mới vì hàm trên đã đóng kết nối)
        if ((new NguoiDungDAO())->updateMatKhau($id, $matKhauMoiMaHoa)) {
            return ['status' => true, 'message' => 'password_success'];
        } else {
            return ['status' => false, 'message' => 'error'];
        }
    }
}
?>