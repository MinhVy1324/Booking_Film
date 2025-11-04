<?php
// File: BACKEND/CONTROLLER/GheController.php
session_start();
include_once __DIR__ . '/../DAO/GheDAO.php';
include_once __DIR__ . '/../DTO/Ghe.php';

// Bảo vệ: Chỉ Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    die("Bạn không có quyền truy cập.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];
    $gheDAO = new GheDAO();
    $idPhong = (int)$_POST['phong_id']; // Lấy ID phòng để quay lại đúng trang

    switch ($action) {
        
        case 'add_ghe':
            $ghe = new Ghe();
            $ghe->setTenGhe($_POST['tenGhe']);
            $ghe->setLoaiGhe($_POST['loaiGhe']);
            $ghe->setIdPhongChieu($idPhong);

            if ($gheDAO->themGhe($ghe)) {
                header("Location: ../../ADMIN/edit_room.php?phong_id=$idPhong&status=add_success");
            } else {
                header("Location: ../../ADMIN/edit_room.php?phong_id=$idPhong&status=error");
            }
            break;

        case 'delete_ghe':
            $idGhe = (int)$_POST['ghe_id'];
            if ($gheDAO->xoaGhe($idGhe)) {
                header("Location: ../../ADMIN/edit_room.php?phong_id=$idPhong&status=delete_success");
            } else {
                header("Location: ../../ADMIN/edit_room.php?phong_id=$idPhong&status=error");
            }
            break;
    }
}
?>