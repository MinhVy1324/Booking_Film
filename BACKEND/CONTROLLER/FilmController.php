<?php
// File: BACKEND/CONTROLLER/FilmController.php
session_start();
include_once __DIR__ . '/../BUS/PhimBUS.php'; // GỌI BUS

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') { die("..."); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];
    $phimBUS = new PhimBUS(); // TẠO BUS

    switch ($action) {
        case 'add':
            $result = $phimBUS->xuLyThemPhim(
                $_POST['tenPhim'], $_POST['moTa'], $_POST['ngayKhoiChieu'],
                $_POST['thoiLuong'], $_POST['posterUrl'], $_POST['theLoai'], $_POST['xepHang']
            );
            header("Location: ../../ADMIN/films.php?status=" . $result['message']);
            break;

        case 'delete':
            // (Logic xóa đơn giản, có thể không cần qua BUS)
            $phimDAO = new PhimDAO();
            if ($phimDAO->xoaPhim((int)$_POST['phim_id'])) {
                header("Location: ../../ADMIN/films.php?status=delete_success");
            } else { header("Location: ../../ADMIN/films.php?status=error"); }
            break;

        case 'edit':
            $result = $phimBUS->xuLySuaPhim(
                $_POST['phim_id'], // ID của phim cần sửa
                $_POST['tenPhim'], $_POST['moTa'], $_POST['ngayKhoiChieu'],
                $_POST['thoiLuong'], $_POST['posterUrl'], $_POST['theLoai'], $_POST['xepHang']
            );
            header("Location: ../../ADMIN/films.php?status=" . $result['message']);
            break;
    }
}
?>