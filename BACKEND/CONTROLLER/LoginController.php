<?php
// File: BACKEND/CONTROLLER/LoginController.php

// Nạp file BUS
include_once __DIR__ . '/../BUS/NguoiDungBUS.php';

// (Không cần nạp DAO hay DTO ở đây nữa, BUS đã nạp rồi)

session_start();

// 1. Kiểm tra xem người dùng có nhấn nút submit (POST) không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Lấy dữ liệu từ form (Giao diện)
    $email = $_POST['email'];
    $matKhau = $_POST['password'];

    // 3. TẠO ĐỐI TƯỢNG BUS (Quản lý)
    $nguoiDungBUS = new NguoiDungBUS();
    
    // 4. GỌI BUS ĐỂ XỬ LÝ (Controller giao việc cho BUS)
    // $user là một đối tượng NguoiDung (DTO) hoặc là null
    $user = $nguoiDungBUS->xuLyDangNhap($email, $matKhau);

    // 5. Kiểm tra kết quả (do BUS trả về)
    if ($user != null) {
        // ĐĂNG NHẬP THÀNH CÔNG!
        
        // 6. Lưu thông tin (từ DTO) vào SESSION
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getHoTen();
        $_SESSION['user_role'] = $user->getLoaiNguoiDung();

        // 7. RẼ NHÁNH
        if ($user->getLoaiNguoiDung() == 'QuanTri') {
            header("Location: ../../ADMIN/dashboard.php");
        } else {
            header("Location: ../../index.php");
        }
        exit(); // Kết thúc script

    } else {
        // ĐĂNG NHẬP THẤT BẠI
        header("Location: ../../login.php?error=1");
        exit();
    }
    
} else {
    // Nếu ai đó truy cập file này trực tiếp (không qua POST)
    header("Location: ../../login.php");
    exit();
}
?>