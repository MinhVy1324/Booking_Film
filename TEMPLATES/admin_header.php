<?php
// File: templates/admin_header.php
session_start();
include_once __DIR__ . '/../BACKEND/Database.php'; // Kết nối CSDL

// BẢO VỆ TRANG ADMIN:
// 1. Kiểm tra xem session 'user_role' có tồn tại không
// 2. Kiểm tra xem 'user_role' có phải là 'QuanTri' không
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'QuanTri') {
    // Nếu không phải Admin, chuyển hướng về trang đăng nhập
    header("Location: ../login.php?error=accessdenied");
    exit(); // Dừng script ngay lập tức

}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* === CSS CHUNG CHO TRANG ADMIN === */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #202225; /* Nền tối chung */
            color: #dcddde;
            display: flex;
            min-height: 100vh;
        }

        /* 1. Bố Cục (Layout) */
        .admin-wrapper {
            display: flex;
            width: 100%;
        }

        /* 2. Sidebar (Menu bên trái) */
        .sidebar {
            width: 250px;
            background-color: #2f3136;
            flex-shrink: 0; /* Không co lại */
            padding-top: 20px;
        }

        .sidebar .logo {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #e50914;
            margin-bottom: 30px;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            padding: 15px 20px;
            color: #b9bbbe;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar-nav li a:hover {
            background-color: #3a3c43;
            color: #fff;
        }
        
        /* (JS/PHP sẽ cần thêm class 'active' cho trang hiện tại) */
        .sidebar-nav li a.active {
            background-color: #e50914; /* Màu đỏ chủ đạo */
            color: #fff;
        }

        /* 3. Nội dung chính */
        .main-content {
            flex-grow: 1; /* Lấp đầy phần còn lại */
            padding: 20px;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .main-header h1 {
            font-size: 1.8rem;
        }

        .add-new-btn {
            background-color: #e50914;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-new-btn:hover {
            background-color: #c40812;
        }

        /* Thông báo (Thêm/Xóa thành công/thất bại) */
        .status-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: 500;
        }
        .status-message.success {
            background-color: #2d614e;
            color: #61d9a4;
            border: 1px solid #61d9a4;
        }
        .status-message.error {
            background-color: #5c2c35;
            color: #e50914;
            border: 1px solid #e50914;
        }

        /* 4. Bảng Dữ Liệu */
        .content-table {
            width: 100%;
            border-collapse: collapse; /* Gộp viền */
            background-color: #2f3136;
            border-radius: 8px;
            overflow: hidden; /* Để bo góc */
        }

        .content-table th, .content-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #40444b;
        }

        .content-table th {
            background-color: #202225;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .action-btn {
            color: #61d9a4; /* Màu xanh */
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
            cursor: pointer;
        }

        .delete-form {
            display: inline-block;
        }

        .action-btn.delete {
            color: #e50914; /* Màu đỏ */
            background: none;
            border: none;
            font: inherit;
            padding: 0;
        }
        .action-btn.delete:hover {
            text-decoration: underline;
        }

        /* 5. Modal (Popup) */
        .modal {
            display: none; /* Mặc định ẩn */
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #36393f;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            color: #b9bbbe;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-btn:hover { color: #fff; }

        /* 6. Form (Bên trong Modal) */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #b9bbbe; font-size: 0.9rem; font-weight: 500; }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            background-color: #202225;
            border: 1px solid #40444b;
            border-radius: 5px;
            color: #dcddde;
            font-size: 1rem;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #e50914;
        }
        .form-group textarea { height: 80px; resize: vertical; }
        .form-group .add-new-btn { width: 100%; margin-top: 10px; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo">ADMIN</div>
        <?php
        // Lấy tên file của trang hiện tại (ví dụ: films.php, showtimes.php)
        $currentPage = basename($_SERVER['PHP_SELF']);
        ?>

        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="/ADMIN/dashboard.php" <?php if ($currentPage == 'dashboard.php') echo 'class="active"'; ?>>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/ADMIN/films.php" <?php if ($currentPage == 'films.php') echo 'class="active"'; ?>>
                        Quản Lý Phim
                    </a>
                </li>
                <li>
                    <a href="/ADMIN/rooms.php" <?php if ($currentPage == 'rooms.php') echo 'class="active"'; ?>>
                        Quản Lý Rạp & Phòng
                    </a>
                </li>
                <li>
                    <a href="/ADMIN/showtimes.php" <?php if ($currentPage == 'showtimes.php') echo 'class="active"'; ?>>
                        Quản Lý Suất Chiếu
                    </a>
                </li>
                <li>
                    <a href="/ADMIN/orders.php" <?php if ($currentPage == 'orders.php') echo 'class="active"'; ?>>
                        Quản Lý Đơn Hàng
                    </a>
                </li>
                <li>
                    <a href="/BACKEND/CONTROLLER/LogoutController.php" style="color: #e50914;">Đăng Xuất</a>
                </li>
            </ul>
        </nav>
    </aside>