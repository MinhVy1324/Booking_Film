<?php
// File: BACKEND/CONTROLLER/ShowtimeController.php
session_start();
include_once __DIR__ . '/../BUS/SuatChieuBUS.php'; // GỌI BUS

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') { die("..."); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $scBUS = new SuatChieuBUS(); // TẠO BUS

    switch ($action) {
        
        // THAY THẾ CASE 'add_showtime' CŨ BẰNG CASE NÀY
        case 'add_bulk_showtime':
            $result = $scBUS->xuLyThemSuatChieuHangLoat(
                $_POST['phim_id'], 
                $_POST['phong_id'], 
                $_POST['giaVe'],
                $_POST['ngayBatDau'], // Trường mới
                $_POST['ngayKetThuc'], // Trường mới
                $_POST['cacGioChieu']  // Trường mới
            );
            header("Location: ../../ADMIN/showtimes.php?status=" . $result['message']);
            break;

        case 'edit':
            // (code 'edit' cũ của bạn giữ nguyên)
            $result = $scBUS->xuLySuaSuatChieu(
                $_POST['suatchieu_id'], $_POST['phim_id'], $_POST['phong_id'],
                $_POST['ngayChieu'], $_POST['gioBatDau'], $_POST['giaVe']
            );
            header("Location: ../../ADMIN/showtimes.php?status=" . $result['message']);
            break;
    }
}
?>