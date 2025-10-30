<?php
// File: backend/CONTROLLER/LoginController.php

// Nạp file DAO
include_once __DIR__ . '/../DAO/NguoiDungDAO.php';
// (Nạp Model NguoiDung nếu cần, nhưng DAO đã nạp rồi)

// Bắt đầu session để lưu trạng thái đăng nhập
session_start();

// 1. Kiểm tra xem người dùng có nhấn nút submit (POST) không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Lấy dữ liệu từ form (login.php)
    $email = $_POST['email'];
    $matKhau = $_POST['password'];

    // 3. Tạo một đối tượng DAO (Đầu bếp)
    $nguoiDungDAO = new NguoiDungDAO();
    
    // 4. Gọi phương thức DAO để kiểm tra (Giao việc cho Đầu bếp)
    // $user là một đối tượng NguoiDung (Model) hoặc là null
    $user = $nguoiDungDAO->kiemTraDangNhap($email, $matKhau);

    // 5. Kiểm tra kết quả
    if ($user != null) {
        // ĐĂNG NHẬP THÀNH CÔNG!
        
        // 6. Lưu thông tin người dùng (từ đối tượng Model) vào SESSION
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getHoTen();
        $_SESSION['user_role'] = $user->getLoaiNguoiDung();

        // 7. RẼ NHÁNH (Mấu chốt)
        if ($user->getLoaiNguoiDung() == 'QuanTri') {
            // Nếu là Admin -> Chuyển hướng về trang Dashboard
            // (Lùi ra 2 cấp: /backend/CONTROLLER/ -> /)
            header("Location: ../../ADMIN/dashboard.php");
        } else {
            // Nếu là Khách hàng -> Chuyển hướng về Trang Chủ
            header("Location: ../../index.php");
        }
        exit(); // Kết thúc script

    } else {
        // ĐĂNG NHẬP THẤT BẠI
        // Chuyển hướng về trang login với thông báo lỗi
        header("Location: ../../login.php?error=1");
        exit();
    }
    
} else {
    // Nếu ai đó truy cập file này trực tiếp (không qua POST)
    header("Location: ../../login.php");
    exit();
}
?>