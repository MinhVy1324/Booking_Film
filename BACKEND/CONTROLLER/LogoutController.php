<?php
// File: backend/CONTROLLER/LogoutController.php

// 1. Luôn bắt đầu session trước khi thao tác
session_start();

// 2. Xóa tất cả các biến session (như user_id, user_name, user_role)
$_SESSION = array();

// 3. Hủy session trên server
session_destroy();

// 4. Chuyển hướng người dùng về trang chủ
// (Lùi ra 2 cấp thư mục: từ /backend/CONTROLLER/ về /)
header("Location: ../../index.php");
exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
?>