<?php
// File: BACKEND/CONTROLLER/ShowtimeController.php
session_start();
include_once __DIR__ . '/../BUS/SuatChieuBUS.php'; // GỌI BUS

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') { die("..."); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $scBUS = new SuatChieuBUS(); // TẠO BUS

    switch ($action) {
        case 'add_showtime':
            $result = $scBUS->xuLyThemSuatChieu(
                $_POST['phim_id'], $_POST['phong_id'], $_POST['ngayChieu'],
                $_POST['gioBatDau'], $_POST['giaVe']
            );
            header("Location: ../../ADMIN/showtimes.php?status=" . $result['message']);
            break;

        case 'edit':
            $result = $scBUS->xuLySuaSuatChieu(
                $_POST['suatchieu_id'], $_POST['phim_id'], $_POST['phong_id'],
                $_POST['ngayChieu'], $_POST['gioBatDau'], $_POST['giaVe']
            );
            header("Location: ../../ADMIN/showtimes.php?status=" . $result['message']);
            break;
    }
}
?>