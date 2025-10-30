<?php
// File: backend/CONTROLLER/OrderController.php
session_start();
include_once __DIR__ . '/../DAO/DonDatVeDAO.php';

// Bảo vệ: Chỉ Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    die("Bạn không có quyền truy cập.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $donDatVeDAO = new DonDatVeDAO();
    $action = $_POST['action'];

    switch ($action) {
        case 'cancel_order':
            $orderId = (int)$_POST['order_id'];
            
            if ($donDatVeDAO->huyDonHang($orderId)) {
                header("Location: ../../ADMIN/orders.php?status=cancel_success");
            } else {
                header("Location: ../../ADMIN/orders.php?status=error");
            }
            break;
    }
}
?>