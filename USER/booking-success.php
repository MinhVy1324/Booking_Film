<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Vé Thành Công!</title>
    
    <style>
        /* Thiết lập chung */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header đơn giản */
        .simple-header {
            padding: 20px 5%;
            background-color: #1a1a1a;
            border-bottom: 1px solid #333;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #e50914;
            text-decoration: none;
        }

        /* Nội dung chính */
        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Hộp xác nhận */
        .success-container {
            background-color: #1a1a1a;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            text-align: center;
            border-top: 4px solid #61d9a4; /* Màu xanh lá thành công */
        }
        
        /* Icon Check (Sử dụng SVG nội tuyến) */
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px auto;
        }
        
        .success-icon circle {
            fill: #61d9a4;
        }
        
        .success-icon path {
            stroke: #1a1a1a;
            stroke-width: 8;
            stroke-linecap: round;
        }

        .success-container h1 {
            font-size: 2rem;
            color: #61d9a4;
            margin-bottom: 15px;
        }

        .success-container p {
            font-size: 1.1rem;
            color: #aaa;
            margin-bottom: 30px;
        }
        
        /* Mã QR (Giả lập bằng SVG) */
        .qr-code {
            width: 200px;
            height: 200px;
            background-color: white; /* Nền QR phải là màu trắng */
            padding: 10px;
            border-radius: 5px;
            margin: 0 auto 20px auto;
            /* SVG Giả lập QR */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .qr-code-placeholder {
            width: 90%;
            height: 90%;
            fill: #121212;
        }

        /* Mã đặt vé */
        .booking-code {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .booking-code span {
            color: #e50914;
            background-color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            letter-spacing: 2px;
        }
        
        /* Chi tiết đơn hàng */
        .booking-details {
            border-top: 1px solid #333;
            margin-top: 30px;
            padding-top: 20px;
            text-align: left;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        
        .detail-item .label {
            color: #aaa;
        }
        
        .detail-item .value {
            color: #fff;
            font-weight: bold;
            text-align: right;
        }
        
        /* Nút quay về */
        .home-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: #e50914;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .home-btn:hover {
            background-color: #c40812;
        }

        /* Footer */
        .main-footer {
            background-color: #1a1a1a;
            color: #888;
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid #333;
        }

    </style>
</head>
<body>

    <header class="simple-header">
        <a href="index.php" class="logo">LOGO-PHIM</a>
    </header>

    <main class="main-content">
        
        <div class="success-container">
            
            <svg class="success-icon" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="46"/>
                <path d="M30 50 L45 65 L70 35"/>
            </svg>
            
            <h1>Đặt Vé Thành Công!</h1>
            <p>Vui lòng đưa mã QR này tại quầy để nhận vé.</p>
            
            <div class="qr-code">
                <svg class="qr-code-placeholder" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M0 0h35v35H0V0Zm5 5v25h25V5H5Zm50 0h35v35H55V0Zm5 5v25h25V5H60ZM0 55h35v35H0V55Zm5 5v25h25V60H5Zm50 0h35v35H55V55Zm5 5v25h25V60H60ZM40 40h15v15H40V40Zm-5-5v25h25V35H35Zm30 30h15v15H65V65Zm-5-5v25h25V60H60ZM40 65h15v15H40V65Zm-5-5v25h25V60H35Z"/>
                </svg>
            </div>
            
            <div class="booking-code">
                Mã đặt vé: <span>SGU1A8</span>
            </div>
            
            <div class="booking-details">
                <div class="detail-item">
                    <span class="label">Phim</span>
                    <span class="value">LẬT MẶT 7</span>
                </div>
                <div class="detail-item">
                    <span class="label">Rạp</span>
                    <span class="value">CGV Hùng Vương</span>
                </div>
                <div class="detail-item">
                    <span class="label">Suất chiếu</span>
                    <span class="value">19:45 - 30/10/2025</span>
                </div>
                <div class="detail-item">
                    <span class="label">Ghế</span>
                    <span class="value">C1, C2</span>
                </div>
                <div class="detail-item">
                    <span class="label">Tổng cộng</span>
                    <span class="value">200.000 VNĐ</span>
                </div>
            </div>

            <a href="index.php" class="home-btn">Quay về Trang Chủ</a>
        </div>

    </main>
    
    <footer class="main-footer">
        <p>&copy; 2025 Đồ Án PTTK Hướng Đối Tượng.</p>
    </footer>

    </body>
</html>