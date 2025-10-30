<?php
// File: backend/CONTROLLER/FilmController.php
session_start();
include_once __DIR__ . '/../DAO/PhimDAO.php';
include_once __DIR__ . '/../MODEL/Phim.php';

// Bảo vệ: Chỉ Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    die("Bạn không có quyền truy cập.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $phimDAO = new PhimDAO();
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            // 1. Tạo đối tượng Model
            $phim = new Phim();
            $phim->setTenPhim($_POST['tenPhim']);
            $phim->setMoTa($_POST['moTa']);
            $phim->setNgayKhoiChieu($_POST['ngayKhoiChieu']);
            $phim->setThoiLuong((int)$_POST['thoiLuong']);
            $phim->setPosterUrl($_POST['posterUrl']);
            $phim->setTheLoai($_POST['theLoai']);
            $phim->setXepHang($_POST['xepHang']);

            // 2. Gọi DAO
            if ($phimDAO->themPhim($phim)) {
                header("Location: ../../ADMIN/films.php?status=add_success");
            } else {
                header("Location: ../../ADMIN/films.php?status=error");
            }
            break;

        case 'delete':
            $phimId = (int)$_POST['phim_id'];
            
            // 2. Gọi DAO
            if ($phimDAO->xoaPhim($phimId)) {
                header("Location: ../../ADMIN/films.php?status=delete_success");
            } else {
                header("Location: ../../ADMIN/films.php?status=error");
            }
            break;
    }
}
?>