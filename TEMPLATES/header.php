<?php
// File: TEMPLATES/header.php
session_start();
include_once dirname(__DIR__) . '/BACKEND/Database.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        /* ... (Toàn bộ CSS chung của bạn giữ nguyên) ... */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #121212; color: #ffffff; min-height: 100vh; display: flex; flex-direction: column; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        main, .main-content { flex-grow: 1; }
        .main-header { background-color: #1a1a1a; padding: 10px 0; border-bottom: 1px solid #333; width: 100%; }
        .main-header .container { display: flex; justify-content: space-between; align-items: center; }
        
        /* 3. Logo (Thẻ <a>) */
        .logo {
            display: inline-block;
            text-decoration: none;
        }
        
        /* * ✅ SỬA LỖI:
         * Đã sửa kích thước của SVG (width 220px) 
         * và CSS cho logo-text
        */
        .logo svg {
            width: 220px; 
            height: auto;
            display: block;
        }

        .logo-text {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 32px;
            font-weight: 800; /* ExtraBold */
            fill: #FFFFFF; /* Màu trắng */
        }
        
        /* ✅ ĐỊNH DẠNG LẠI: CSS Cho chữ 'CINEMA' */
        .logo-tagline {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px; /* Tăng nhẹ kích thước */
            font-weight: 500;
            fill: #E50914; /* Màu đỏ */
            text-anchor: middle; /* Căn giữa theo trục X của text element */
            letter-spacing: 2px; /* Tăng giãn cách chữ */
        }

        /* ... (CSS cho .main-nav, .auth-buttons, .main-footer giữ nguyên) ... */
        .main-nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        .main-nav li { margin-left: 25px; }
        .main-nav a { color: #ccc; text-decoration: none; font-size: 1rem; font-weight: 500; transition: color 0.3s; }
        .main-nav a:hover { color: #ffffff; }
        .auth-buttons { display: flex; align-items: center; gap: 15px; }
        .auth-buttons span { color: #ffffff; font-weight: bold; }
        .auth-buttons a { color: #fff; text-decoration: none; padding: 8px 15px; border: 1px solid #555; border-radius: 5px; transition: background-color 0.3s, border-color 0.3s; }
        .auth-buttons a.btn-primary { background-color: #e50914; border-color: #e50914; font-weight: bold; }
        .auth-buttons a:hover { background-color: #333; border-color: #777; }
        .auth-buttons a.btn-primary:hover { background-color: #c40812; border-color: #c40812; }
        .main-footer { background-color: #1a1a1a; color: #888; padding: 30px 0; text-align: center; border-top: 1px solid #333; margin-top: 40px; width: 100%; }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 15px; /* Khoảng cách giữa các nút */
        }

        /* Nút Đăng Nhập (Nút cơ bản) */
        .auth-buttons a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid #555; 
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Nút Đăng Ký / Đăng Xuất (Nút chính, màu đỏ) */
        .auth-buttons a.btn-primary {
            background-color: #e50914; 
            border-color: #e50914;     
            font-weight: bold;
        }

        /* Hover cho nút thường (Đăng Nhập) */
        .auth-buttons a:not(.btn-primary):not(.user-profile-link):hover {
            background-color: #333; 
            border-color: #777;
        }
        
        .auth-buttons a.btn-primary:hover {
            background-color: #c40812;
            border-color: #c40812;
        }

        /* ✅ CSS MỚI CHO LINK PROFILE (ICON + TÊN) */
        .user-profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #333; /* Nền xám nhẹ */
            border-color: #555;
            padding-right: 15px; /* Thêm padding bên phải cho tên */
            padding-left: 8px; /* Padding trái nhỏ hơn cho icon */
            padding-top: 6px;
            padding-bottom: 6px;
            border-radius: 20px; /* Bo tròn (pill shape) */
        }
        
        .user-profile-link:hover {
            background-color: #444;
            border-color: #e50914; /* Viền đỏ khi hover */
        }

        .user-profile-link .user-icon {
            display: inline-block;
            line-height: 0; /* Fix lỗi căn chỉnh SVG */
        }
        
        .user-profile-link .user-icon svg {
            width: 18px;
            height: 18px;
            stroke: #FFFFFF; /* Màu icon trắng */
        }
        
        .user-profile-link .user-name {
            color: #FFFFFF;
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
    
</head>
<body> <header class="main-header">
        <div class="container">
            
            <a href="/index.php" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     width="220" height="65" 
                     viewBox="0 0 220 65">
                    
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;800&display=swap');
                        
                        .logo-text {
                            font-family: 'Montserrat', Arial, sans-serif;
                            font-size: 32px;
                            font-weight: 800; /* ExtraBold */
                            fill: #FFFFFF; /* Màu trắng */
                        }
                        .logo-tagline {
                            font-family: 'Montserrat', Arial, sans-serif;
                            font-size: 14px;
                            font-weight: 500;
                            fill: #E50914; /* Màu đỏ */
                            text-anchor: middle; 
                            letter-spacing: 2px; 
                        }
                    </style>

                    <text x="5" y="30" class="logo-text">B</text>

                    <g transform="translate(40, 0)">
                        <path fill="#FFFFFF" d="M18.6,3.2C17.3,1.3,15,0.1,12.5,0.1C8.7,0.1,5.5,3.3,5.5,7.1c0,1.3,0.4,2.5,1,3.6
                            C3.2,11.5,1,14.4,1,17.7c0,4.4,3.6,8,8,8c0.8,0,1.6-0.1,2.4-0.4c0.7,3,3.3,5.2,6.3,5.2c3.5,0,6.4-2.8,6.4-6.3
                            c0-2.3-1.2-4.4-3.1-5.5c0.8-1,1.3-2.3,1.3-3.6C22.3,10.2,20.8,6.1,18.6,3.2z"/>
                        <path fill="#333" d="M9.5,12c-2.2,0-4,1.8-4,4s1.8,4,4,4s4-1.8,4-4S11.7,12,9.5,12z M17.5,12c-2.2,0-4,1.8-4,4s1.8,4,4,4
                            s4-1.8,4-4S19.7,12,17.5,12z"/>
                        <circle fill="#E50914" cx="9.5" cy="16" r="3"/>
                        <circle fill="#1A1A1A" cx="17.5" cy="16" r="3"/>
                    </g>

                    <text x="75" y="30" class="logo-text">P RANG</text>
                    
                    <text x="110" y="52" class="logo-tagline">C I N E M A</text>

                </svg>
            </a>
            
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
                    <a href="/USER/profile.php" class="user-profile-link" title="Trang Cá Nhân Của Bạn">
                        <div class="user-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <span class="user-name">Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                    </a>
                    
                    <a href="/BACKEND/CONTROLLER/LogoutController.php" class="btn-primary">Đăng Xuất</a>
                    
                <?php else: ?>
                    <a href="/login.php">Đăng Nhập</a>
                    <a href="/signup.php" class="btn-primary">Đăng Ký</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    ```