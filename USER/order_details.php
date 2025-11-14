<?php
// File: USER/order_details.php
include_once __DIR__ . '/../TEMPLATES/header.php'; // Nạp header

// BẢO VỆ: Nếu chưa đăng nhập, đá về
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=mustlogin");
    exit();
}

// BẢO VỆ: Nếu không có order_id, đá về
if (!isset($_GET['order_id'])) {
    header("Location: profile.php");
    exit();
}

// NẠP DAO
include_once __DIR__ . '/../BACKEND/DAO/DonDatVeDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/ChiTietDatVeDAO.php';

$order_id = (int)$_GET['order_id'];
$user_id = (int)$_SESSION['user_id'];

// LẤY DỮ LIỆU
$donDatVeDAO = new DonDatVeDAO();
// Lấy thông tin đơn hàng VÀ kiểm tra xem có đúng là của user này không
$order = $donDatVeDAO->getDonHangDetailsById($order_id, $user_id);

// BẢO VỆ: Nếu đơn hàng không tồn tại HOẶC không phải của user này
if ($order == null) {
    echo "<main class='container' style='color: white; padding: 20px;'>Lỗi: Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này.</main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}

// Lấy danh sách ghế
$ctdvDAO = new ChiTietDatVeDAO();
$ten_ghe_list = $ctdvDAO->getGheByDonHangId($order_id);
?>

<title>Chi Tiết Đơn Hàng #<?php echo $order_id; ?></title>

<style>
    .main-content {
        display: flex; justify-content: center;
        align-items: center; padding: 40px 20px;
    }
    .ticket-container {
        background-color: #1a1a1a; padding: 30px;
        border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        width: 100%; max-width: 500px; text-align: center;
        border-top: 4px solid #61d9a4;
    }
    .ticket-container h1 { font-size: 2rem; color: #61d9a4; margin-bottom: 15px; }
    .ticket-container p { font-size: 1.1rem; color: #aaa; margin-bottom: 30px; }
    .qr-code {
        width: 200px; height: 200px; background-color: white;
        padding: 10px; border-radius: 5px; margin: 0 auto 20px auto;
    }
    .booking-code { font-size: 1.2rem; font-weight: bold; margin-bottom: 30px;}
    .booking-code span {
        color: #e50914; background-color: #333;
        padding: 5px 10px; border-radius: 5px; letter-spacing: 2px;
    }
    .booking-details {
        border-top: 1px solid #333;
        padding-top: 20px; text-align: left;
    }
    .detail-item {
        display: flex; justify-content: space-between;
        margin-bottom: 12px; padding-bottom: 12px;
        border-bottom: 1px solid #333; font-size: 1rem;
    }
    .detail-item:last-child { border-bottom: none; }
    .detail-item .label { color: #aaa; }
    .detail-item .value { color: #fff; font-weight: bold; text-align: right; }
    .detail-item .value.seat { color: #61d9a4; font-size: 1.1em; }
    
    .back-btn {
        display: inline-block; margin-top: 30px;
        padding: 12px 25px; background-color: #555;
        color: #ffffff; text-decoration: none; border-radius: 5px;
        font-weight: bold; transition: background-color 0.3s;
    }
    .back-btn:hover { background-color: #777; }
</style>

<main class="main-content">
    
    <div class="ticket-container">
        
        <h1>Chi Tiết Vé</h1>
        <p>Đây là thông tin vé của bạn. Vui lòng đưa mã QR tại quầy.</p>
        
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=DonHang_<?php echo $order_id; ?>" alt="QR Code">
        </div>
        
        <div class="booking-code">
            Mã đặt vé: <span>VE-<?php echo $order_id; ?></span>
        </div>
        
        <div class="booking-details">
            <div class="detail-item">
                <span class="label">Phim</span>
                <span class="value"><?php echo htmlspecialchars($order['TenPhim']); ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Rạp</span>
                <span class="value"><?php echo htmlspecialchars($order['TenRap']); ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Suất chiếu</span>
                <span class="value"><?php echo date('H:i', strtotime($order['GioBatDau'])); ?> - <?php echo date('d/m/Y', strtotime($order['NgayChieu'])); ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Ghế đã đặt</span>
                <span class="value seat"><?php echo htmlspecialchars($ten_ghe_list); ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Tổng cộng</span>
                <span class="value"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span>
            </div>
            <div class="detail-item">
                <span class="label">Trạng Thái</span>
                <span class="value" style="color: <?php echo ($order['TrangThai'] == 'DaHuy' ? '#e50914' : '#61d9a4'); ?>;">
                    <?php echo ($order['TrangThai'] == 'DaHuy' ? 'ĐÃ HỦY' : 'Đã Thanh Toán'); ?>
                </span>
            </div>
        </div>

        <a href="profile.php" class="back-btn">&larr; Quay lại Trang Cá Nhân</a>
    </div>

</main> <?php
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>