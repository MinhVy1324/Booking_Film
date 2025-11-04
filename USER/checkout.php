<?php
// File: USER/checkout.php
include_once __DIR__ . '/../TEMPLATES/header.php'; // Nạp header

// KIỂM TRA BẢO MẬT
// 1. Nếu chưa đăng nhập, đá về trang login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=mustlogin");
    exit();
}
// 2. Nếu giỏ hàng rỗng (chưa chọn ghế), đá về trang chủ
if (!isset($_SESSION['cart'])) {
    header("Location: ../index.php");
    exit();
}

// 3. Lấy dữ liệu từ giỏ hàng (SESSION)
$cart = $_SESSION['cart'];
$details = $cart['details'];
?>

<title>Bước 3: Thanh Toán</title>

<style>
    /* ... (CSS cho .main-header, .main-footer đã có trong header.php) ... */
    .container { width: 90%; max-width: 1100px; margin: 0 auto; }
    .checkout-layout { display: flex; gap: 30px; padding: 30px 0; }
    .main-content { flex: 2; }
    .sidebar { flex: 1; position: sticky; top: 30px; }
    .checkout-box { background-color: #1a1a1a; border-radius: 8px; border: 1px solid #333; margin-bottom: 20px; }
    .checkout-box-header { padding: 15px 20px; border-bottom: 1px solid #333; }
    .checkout-box-header h2 { font-size: 1.3rem; }
    .checkout-box-body { padding: 20px; }
    /* (CSS cho form, input...) */
    .order-summary-item { display: flex; justify-content: space-between; margin-bottom: 15px; color: #aaa; }
    .order-summary-item.main { color: #fff; font-weight: bold; }
    .order-summary-item.total { border-top: 1px solid #444; padding-top: 15px; font-size: 1.3rem; color: #fff; font-weight: bold; }
    .checkout-btn { width: 100%; padding: 15px; background-color: #e50914; color: #ffffff; text-align: center; border: none; border-radius: 5px; font-weight: bold; font-size: 1.2rem; cursor: pointer; transition: background-color 0.3s; margin-top: 10px; }
    .checkout-btn:hover { background-color: #c40812; }
</style>

<main>
    <div class="container">
        <div class="checkout-layout">
            
            <div class="main-content">
                <form action="../BACKEND/CONTROLLER/BookingController.php" method="POST">
                    <input type="hidden" name="action" value="checkout">
                    
                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <h2>Thông Tin Người Nhận Vé</h2>
                        </div>
                        <div class="checkout-box-body">
                            <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                            <p style="color: #aaa; margin-top: 10px;">Vé điện tử sẽ được gửi (hoặc lưu vào lịch sử) cho tài khoản này.</p>
                        </div>
                    </div>

                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <h2>Phương Thức Thanh Toán</h2>
                        </div>
                        <div class="checkout-box-body">
                            <p>Thanh toán tại quầy (Demo)</p>
                            </div>
                    </div>
                    
                    <aside class="sidebar">
                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <h2>Tóm Tắt Đơn Hàng</h2>
                        </div>
                        <div class="checkout-box-body">
                            <div class="order-summary-item main">
                                <span>Phim</span>
                                <span><?php echo htmlspecialchars($details['TenPhim']); ?></span>
                            </div>
                            <div class="order-summary-item">
                                <span>Rạp</span>
                                <span><?php echo htmlspecialchars($details['TenRap']); ?></span>
                            </div>
                            <div class="order-summary-item">
                                <span>Suất chiếu</span>
                                <span><?php echo date('H:i', strtotime($details['GioBatDau'])) . ' - ' . date('d/m/Y', strtotime($details['NgayChieu'])); ?></span>
                            </div>
                            <div class="order-summary-item">
                                <span>Ghế</span>
                                <span style="color: #61d9a4; font-weight: bold;"><?php echo htmlspecialchars($cart['seat_names']); ?></span>
                            </div>
                            
                            <div class="order-summary-item total">
                                <span>TỔNG CỘNG</span>
                                <span><?php echo number_format($cart['total_price'], 0, ',', '.'); ?> VNĐ</span>
                            </div>

                            <button type="submit" class="checkout-btn">XÁC NHẬN THANH TOÁN</button>
                            
                        </div>
                    </div>
                </aside>
                
                </form> </div>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>