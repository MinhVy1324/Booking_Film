<?php
// File: templates/header.php
// BẮT BUỘC đặt session_start() ở dòng đầu tiên
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    
    <style>
        /* === CSS CHUNG === */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Nền tối chung */
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Lớp container chung để căn giữa */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* CSS cho các trang nội dung (như .main-content) 
           sẽ được đặt ở file riêng của trang đó (ví dụ: login.php)
           Tuy nhiên, chúng ta cần set 'flex-grow' để đẩy footer xuống
        */
        main, .main-content {
            flex-grow: 1; 
        }

        /* === CSS CHO HEADER === */
        
        /* 1. Thanh Header Chính (Thanh bọc bên ngoài) */
        .main-header {
            background-color: #1a1a1a; /* Nền đen/xám than */
            padding: 15px 0;
            border-bottom: 1px solid #333; /* Đường viền mỏng ở dưới */
            width: 100%;
        }
        
        /* 2. Lớp Container trong Header */
        .main-header .container {
            display: flex;
            justify-content: space-between; /* Đẩy các mục ra xa nhau */
            align-items: center; /* Căn giữa theo chiều dọc */
        }

        /* 3. Logo */
        .logo {
            font-size: 1.8rem;      /* Cỡ chữ to */
            font-weight: bold;
            color: #e50914;       /* Màu đỏ chủ đạo */
            text-decoration: none;  /* Bỏ gạch chân */
        }

        /* 4. Điều Hướng Chính (Nav) */
        .main-nav ul {
            list-style: none; /* Bỏ dấu chấm tròn */
            margin: 0;
            padding: 0;
            display: flex; /* Xếp các mục nav nằm ngang */
        }

        .main-nav li {
            margin-left: 25px; /* Khoảng cách giữa các mục */
        }

        .main-nav a {
            color: #ccc;            /* Màu chữ xám nhạt */
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s; /* Hiệu ứng đổi màu mượt */
        }

        .main-nav a:hover {
            color: #ffffff; /* Đổi thành màu trắng khi di chuột */
        }

        /* 5. Khu Vực Nút Đăng Nhập / Người Dùng */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 15px; /* Khoảng cách giữa các nút */
        }

        /* Văn bản "Xin chào..." */
        .auth-buttons span {
            color: #ffffff;
            font-weight: bold;
        }

        /* Nút Đăng Nhập (Nút cơ bản) */
        .auth-buttons a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid #555; /* Viền xám mờ */
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Nút Đăng Ký / Đăng Xuất (Nút chính, màu đỏ) */
        .auth-buttons a.btn-primary {
            background-color: #e50914; /* Nền đỏ */
            border-color: #e50914;     /* Viền đỏ */
            font-weight: bold;
        }

        /* Hiệu ứng Hover cho các nút */
        .auth-buttons a:hover {
            background-color: #333; /* Hover cho nút thường */
            border-color: #777;
        }

        .auth-buttons a.btn-primary:hover {
            background-color: #c40812; /* Màu đỏ sậm hơn khi hover */
            border-color: #c40812;
        }
        
        /* === CSS CHO FOOTER ĐƠN GIẢN === */
        /* (Bạn cũng có thể đặt CSS footer ở đây) */
        .main-footer {
            background-color: #1a1a1a;
            color: #888;
            padding: 30px 0;
            text-align: center;
            border-top: 1px solid #333;
            margin-top: 40px; /* Tạo khoảng cách với nội dung */
            width: 100%;
        }

    </style>
    
</head>
<body> <header class="main-header">
        <div class="container">
            <a href="/index.php" class="logo">LOGO-PHIM</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="/index.php">Trang Chủ</a></li>
                    <li><a href="#">Phim</a></li>
                    <li><a href="#">Rạp</a></li>
                    <li><a href="#">Khuyến Mãi</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                    <a href="backend/CONTROLLER/LogoutController.php" class="btn-primary">Đăng Xuất</a>
                <?php else: ?>
                    <a href="login.php">Đăng Nhập</a>
                    <a href="signup.php" class="btn-primary">Đăng Ký</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
