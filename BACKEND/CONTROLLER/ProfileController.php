<?php
// File: BACKEND/CONTROLLER/ProfileController.php
session_start();
include_once __DIR__ . '/../BUS/ProfileBUS.php'; // GỌI BUS

// Bảo vệ: Chỉ người đã đăng nhập mới được vào đây
if (!isset($_SESSION['user_id'])) {
    die("Bạn không có quyền truy cập.");
}

// Chỉ xử lý khi có hành động (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];
    $profileBUS = new ProfileBUS(); // TẠO BUS
    
    $idNguoiDung = (int)$_SESSION['user_id']; // Lấy ID từ session

    switch ($action) {
        
        // --- TRƯỜNG HỢP: CẬP NHẬT THÔNG TIN ---
        case 'update_info':
            
            // 1. Lấy dữ liệu
            $hoTen = $_POST['fullname'];
            $sdt = $_POST['phone'];
            
            // ✅ SỬA LẠI LOGIC LẤY NGÀY SINH
            $ngay = $_POST['dob_day'];
            $thang = $_POST['dob_month'];
            $nam = $_POST['dob_year'];
            
            $ngaySinh = null;
            // Kiểm tra xem người dùng có chọn đủ 3 ô không
            if (!empty($nam) && !empty($thang) && !empty($ngay)) {
                // Ghép lại thành chuỗi YYYY-MM-DD
                $ngaySinh = "$nam-$thang-$ngay";
            }
            // (Nếu 1 trong 3 ô bị trống, $ngaySinh sẽ là NULL, CSDL sẽ lưu NULL)

            // 2. Giao việc cho BUS
            $result = $profileBUS->xuLyCapNhatThongTin($idNguoiDung, $hoTen, $sdt, $ngaySinh);

            // 3. Cập nhật lại tên trong SESSION
            if ($result['status'] == true) {
                $_SESSION['user_name'] = $hoTen;
            }
            header("Location: ../../USER/profile.php?status=" . $result['message']);
            exit();
            break;

        // --- ✅ CASE 2 MỚI: ĐỔI MẬT KHẨU ---
        case 'change_password':
            $matKhauCu = $_POST['old_password'];
            $matKhauMoi = $_POST['new_password'];
            $matKhauNhapLai = $_POST['confirm_password'];

            // Giao việc cho BUS
            $result = $profileBUS->xuLyDoiMatKhau($idNguoiDung, $matKhauCu, $matKhauMoi, $matKhauNhapLai);
            
            header("Location: ../../USER/profile.php?status=" . $result['message']);
            exit();
            break;
    }
} else {
    // Nếu truy cập trực tiếp, đá về trang chủ
    header("Location: ../../index.php");
    exit();
}
?>