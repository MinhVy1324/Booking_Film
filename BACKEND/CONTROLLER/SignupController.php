<?php
// File: backend/CONTROLLER/SignupController.php

// Nạp file DAO và Model
include_once __DIR__ . '/../DAO/NguoiDungDAO.php';
include_once __DIR__ . '/../MODEL/NguoiDung.php';
// (Chúng ta có thể tạo BUS, nhưng để đơn giản, Controller gọi DAO trực tiếp)

// 1. Kiểm tra xem người dùng có nhấn nút submit không
if (isset($_POST["submit"])) {
    
    // 2. Lấy dữ liệu từ form (signup.php)
    $hoTen = $_POST['fullname'];
    $email = $_POST['email'];
    $matKhau = $_POST['password'];
    $matKhauNhapLai = $_POST['confirm_password'];

    // 3. KIỂM TRA NGHIỆP VỤ (Validation) - (Phần này đáng lẽ ở BUS)

    // 3.1. Kiểm tra mật khẩu có trùng khớp không
    if ($matKhau !== $matKhauNhapLai) {
        header("Location: ../../signup.php?error=password");
        exit();
    }
    
    // 4. Tạo đối tượng DAO
    $nguoiDungDAO = new NguoiDungDAO();
    
    // 4.2. Kiểm tra email đã tồn tại chưa
    if ($nguoiDungDAO->emailDaTonTai($email)) {
        header("Location: ../../signup.php?error=email");
        exit();
    }

    // 5. MÃ HÓA MẬT KHẨU
    $matKhauMaHoa = password_hash($matKhau, PASSWORD_DEFAULT);

    // 6. Tạo đối tượng Model (DTO)
    $userMoi = new NguoiDung();
    $userMoi->setHoTen($hoTen);
    $userMoi->setEmail($email);
    $userMoi->setMatKhau($matKhauMaHoa);
    // (LoaiNguoiDung sẽ tự động là 'KhachHang' nhờ DEFAULT trong CSDL)

    // 7. Gọi DAO để thêm người dùng
    if ($nguoiDungDAO->themNguoiDung($userMoi)) {
        // Đăng ký thành công!
        header("Location: ../../login.php?signup=success");
        exit();
    } else {
        // Lỗi khi insert
        header("Location: ../../signup.php?error=stmtfailed");
        exit();
    }

} else {
    // Nếu ai đó truy cập file này trực tiếp
    header("Location: ../../signup.php");
    exit();
}
?>