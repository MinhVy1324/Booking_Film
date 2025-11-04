<?php
// File: BACKEND/CONTROLLER/SignupController.php

// Nạp file BUS
include_once __DIR__ . '/../BUS/NguoiDungBUS.php';

// 1. Kiểm tra xem người dùng có nhấn nút submit không
if (isset($_POST["submit"])) {
    
    // 2. Lấy dữ liệu từ form (Giao diện)
    $hoTen = $_POST['fullname'];
    $email = $_POST['email'];
    $matKhau = $_POST['password'];
    $matKhauNhapLai = $_POST['confirm_password'];

    // 3. TẠO ĐỐI TƯỢNG BUS (Quản lý)
    $nguoiDungBUS = new NguoiDungBUS();

    // 4. GỌI BUS ĐỂ XỬ LÝ
    $result = $nguoiDungBUS->xuLyDangKy($hoTen, $email, $matKhau, $matKhauNhapLai);

    // 5. Xử lý kết quả (do BUS trả về)
    if ($result['status'] == true) {
        // Đăng ký thành công!
        header("Location: ../../login.php?signup=success");
        exit();
    } else {
        // Đăng ký thất bại, gửi mã lỗi về
        header("Location: ../../signup.php?error=" . $result['message']);
        exit();
    }

} else {
    // Nếu ai đó truy cập file này trực tiếp
    header("Location: ../../signup.php");
    exit();
}
?>