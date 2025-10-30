<?php
// File: backend/CONTROLLER/ShowtimeController.php
session_start();
include_once __DIR__ . '/../DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../MODEL/SuatChieu.php';

// Bảo vệ: Chỉ Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    die("Bạn không có quyền truy cập.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];

    if ($action == 'add_showtime') {
        $sc = new SuatChieu();
        $sc->setIdPhim((int)$_POST['phim_id']);
        $sc->setIdPhongChieu((int)$_POST['phong_id']);
        $sc->setNgayChieu($_POST['ngayChieu']);
        $sc->setGioBatDau($_POST['gioBatDau']);
        $sc->setGiaVe((int)$_POST['giaVe']);

        $scDAO = new SuatChieuDAO();
        if ($scDAO->themSuatChieu($sc)) {
            header("Location: ../../ADMIN/showtimes.php?status=add_success");
        } else {
            header("Location: ../../ADMIN/showtimes.php?status=error");
        }
    }
}
?>