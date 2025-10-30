<?php
// File: backend/CONTROLLER/RoomController.php
session_start();
include_once __DIR__ . '/../DAO/RapDAO.php';
include_once __DIR__ . '/../DAO/PhongChieuDAO.php';
include_once __DIR__ . '/../MODEL/Rap.php';
include_once __DIR__ . '/../MODEL/PhongChieu.php';

// Bảo vệ: Chỉ Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    die("Bạn không có quyền truy cập.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];

    if ($action == 'add_rap') {
        $rap = new Rap();
        $rap->setTenRap($_POST['tenRap']);
        $rap->setDiaChi($_POST['diaChi']);
        
        $rapDAO = new RapDAO();
        if ($rapDAO->themRap($rap)) {
            header("Location: ../../ADMIN/rooms.php?status=add_rap_success");
        } else {
            header("Location: ../../ADMIN/rooms.php?status=error");
        }
    }
    
    if ($action == 'add_room') {
        $phong = new PhongChieu();
        $phong->setIdRap((int)$_POST['rap_id']);
        $phong->setTenPhong($_POST['tenPhong']);
        $phong->setSoLuongGhe((int)$_POST['soLuongGhe']);

        $phongDAO = new PhongChieuDAO();
        if ($phongDAO->themPhong($phong)) {
            header("Location: ../../ADMIN/rooms.php?status=add_room_success");
        } else {
            header("Location: ../../ADMIN/rooms.php?status=error");
        }
    }
}
?>