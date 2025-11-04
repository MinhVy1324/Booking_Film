<?php
// File: USER/booking-success.php
include_once __DIR__ . '/../TEMPLATES/header.php'; // Nạp header

// Lấy ID đơn hàng từ URL (để hiển thị)
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
?>

<title>Đặt Vé Thành Công!</title>

<style>
    /* ... (CSS cho .main-header, .main-footer đã có trong header.php) ... */
    .main-content {
        display: flex; justify-content: center;
        align-items: center; padding: 40px 20px;
    }
    .success-container {
        background-color: #1a1a1a; padding: 30px;
        border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        width: 100%; max-width: 500px; text-align: center;
        border-top: 4px solid #61d9a4; /* Màu xanh lá */
    }
    .success-container h1 { font-size: 2rem; color: #61d9a4; margin-bottom: 15px; }
    .success-container p { font-size: 1.1rem; color: #aaa; margin-bottom: 30px; }
    .qr-code {
        width: 200px; height: 200px; background-color: white;
        padding: 10px; border-radius: 5px; margin: 0 auto 20px auto;
    }
    .booking-code { font-size: 1.2rem; font-weight: bold; }
    .booking-code span {
        color: #e50914; background-color: #333;
        padding: 5px 10px; border-radius: 5px; letter-spacing: 2px;
    }
    .home-btn {
        display: inline-block; margin-top: 30px;
        padding: 12px 25px; background-color: #e50914;
        color: #ffffff; text-decoration: none; border-radius: 5px;
        font-weight: bold; transition: background-color 0.3s;
    }
    .home-btn:hover { background-color: #c40812; }
</style>

<main class="main-content">
    
    <div class="success-container">
        
        <h1>Đặt Vé Thành Công!</h1>
        <p>Cảm ơn bạn đã đặt vé. Vui lòng đưa mã này tại quầy.</p>
        
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=DonHang_<?php echo $order_id; ?>" alt="QR Code">
        </div>
        
        <div class="booking-code">
            Mã đặt vé của bạn: <span>VE-<?php echo $order_id; ?></span>
        </div>
        
        <a href="../index.php" class="home-btn">Quay về Trang Chủ</a>
    </div>

</main> <?php
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>