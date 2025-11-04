<?php
// File: BACKEND/CONTROLLER/RoomController.php
session_start();
include_once __DIR__ . '/../BUS/RoomBUS.php'; // GỌI BUS

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') { die("..."); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];
    $roomBUS = new RoomBUS(); // TẠO BUS

    if ($action == 'add_rap') {
        $result = $roomBUS->xuLyThemRap($_POST['tenRap'], $_POST['diaChi']);
        header("Location: ../../ADMIN/rooms.php?status=" . $result['message']);
    }
    
    if ($action == 'add_room_bulk') {
        $result = $roomBUS->xuLyThemPhongHangLoat(
            $_POST['rap_id'], 
            $_POST['tenPhong'], 
            (int)$_POST['soHang'],
            (int)$_POST['soGheMoiHang'],
            (int)$_POST['soHangVIP']
        );
        header("Location: ../../ADMIN/rooms.php?status=" . $result['message']);
    }

    if ($action == 'delete_room') {
        $result = $roomBUS->xuLyXoaPhong($_POST['phong_id']);
        // Chuyển hướng quay lại trang rooms.php (và báo kết quả)
        header("Location: ../../ADMIN/rooms.php?status=" . $result['message']);
    }
}
?>