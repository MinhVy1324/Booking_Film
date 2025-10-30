<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    
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
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Header đơn giản */
        .simple-header {
            width: 100%;
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

        /* Layout 2 cột */
        .checkout-layout {
            display: flex;
            gap: 30px;
            padding: 30px 0;
        }

        .main-content {
            flex: 2; /* Chiếm 2/3 không gian */
        }

        .sidebar {
            flex: 1; /* Chiếm 1/3 không gian */
            position: sticky; /* Đi theo khi cuộn trang */
            top: 30px;
        }
        
        /* Box chung cho các phần */
        .checkout-box {
            background-color: #1a1a1a;
            border-radius: 8px;
            border: 1px solid #333;
            margin-bottom: 20px;
        }
        
        .checkout-box-header {
            padding: 15px 20px;
            border-bottom: 1px solid #333;
        }
        
        .checkout-box-header h2 {
            font-size: 1.3rem;
        }
        
        .checkout-box-body {
            padding: 20px;
        }

        /* 1. Phần Thông Tin Khách Hàng */
        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #aaa;
            font-size: 0.9rem;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            background-color: #333;
            border: 2px solid #444;
            border-radius: 5px;
            color: #fff;
        }

        /* 2. Phần Phương Thức Thanh Toán */
        .payment-method {
            padding: 15px;
            border: 2px solid #444;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method:hover,
        .payment-method.active {
            border-color: #e50914;
        }

        .payment-method input[type="radio"] {
            transform: scale(1.2);
            /* Tùy chỉnh radio button */
        }

        .payment-method img {
            height: 30px; /* Logo ví, ngân hàng */
        }
        
        /* 3. Phần Tóm Tắt Đơn Hàng (Sidebar) */
        .order-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #aaa;
        }

        .order-summary-item.main {
            color: #fff;
            font-weight: bold;
        }
        
        .order-summary-item.total {
            border-top: 1px solid #444;
            padding-top: 15px;
            font-size: 1.3rem;
            color: #fff;
            font-weight: bold;
        }

        /* Nút Thanh Toán */
        .checkout-btn {
            width: 100%;
            padding: 15px;
            background-color: #e50914;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .checkout-btn:hover {
            background-color: #c40812;
        }
        
        .terms {
            font-size: 0.8rem;
            color: #888;
            text-align: center;
            margin-top: 15px;
        }
        
        .terms a {
            color: #aaa;
        }
        
        /* Footer */
        .main-footer {
            width: 100%;
            background-color: #1a1a1a;
            color: #888;
            text-align: center;
            padding: 30px 0;
            margin-top: 40px;
            border-top: 1px solid #333;
        }

    </style>
</head>
<body>

    <header class="simple-header">
        <a href="index.php" class="logo">LOGO-PHIM</a>
    </header>

    <div class="container">
        <div class="checkout-layout">
            
            <main class="main-content">
                
                <div class="checkout-box">
                    <div class="checkout-box-header">
                        <h2>Thông Tin Người Nhận Vé</h2>
                    </div>
                    <div class="checkout-box-body">
                        <p style="margin-bottom: 15px; color: #aaa;">(Vé điện tử sẽ được gửi đến thông tin này)</p>
                        <form id="customer-info-form">
                            <div class="input-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="input-field" value="nguyen.van.a@gmail.com" required>
                            </div>
                            <div class="input-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" id="phone" class="input-field" value="0901234567" required>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="checkout-box">
                    <div class="checkout-box-header">
                        <h2>Chọn Phương Thức Thanh Toán</h2>
                    </div>
                    <div class="checkout-box-body" id="payment-options">
                        
                        <div class="payment-method active" data-target="momo">
                            <input type="radio" name="payment" checked>
                            <img src="https://via.placeholder.com/100x30/momo.png?text=Momo" alt="Momo">
                            <span>Thanh toán bằng ví Momo</span>
                        </div>
                        
                        <div class="payment-method" data-target="zalopay">
                            <input type="radio" name="payment">
                            <img src="https://via.placeholder.com/100x30/zalopay.png?text=ZaloPay" alt="ZaloPay">
                            <span>Thanh toán bằng ZaloPay</span>
                        </div>
                        
                        <div class="payment-method" data-target="visa">
                            <input type="radio" name="payment">
                            <img src="https://via.placeholder.com/100x30/visa.png?text=VISA/Master" alt="Visa">
                            <span>Thanh toán bằng thẻ Quốc tế</span>
                        </div>

                    </div>
                </div>

            </main>
            
            <aside class="sidebar">
                <div class="checkout-box">
                    <div class="checkout-box-header">
                        <h2>Tóm Tắt Đơn Hàng</h2>
                    </div>
                    <div class="checkout-box-body">
                        <div class="order-summary-item main">
                            <span>Phim</span>
                            <span>LẬT MẶT 7</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Rạp</span>
                            <span>CGV Hùng Vương</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Suất chiếu</span>
                            <span>19:45 - 30/10</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Ghế</span>
                            <span>C1, C2 (2 vé)</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Tiền vé</span>
                            <span>200.000 VNĐ</span>
                        </div>
                        
                        <div class="order-summary-item total">
                            <span>TỔNG CỘNG</span>
                            <span>200.000 VNĐ</span>
                        </div>

                        <button class="checkout-btn" id="confirm-payment-btn">XÁC NHẬN THANH TOÁN</button>
                        
                        <p class="terms">Bằng việc nhấn "Xác nhận", bạn đồng ý với <a href="#">Điều khoản sử dụng</a>.</p>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; 2025 Đồ Án PTTK Hướng Đối Tượng.</p>
    </footer>

    <script>
        // JAVASCRIPT ĐƠN GIẢN CHO VIỆC CHỌN PT THANH TOÁN
        const paymentOptions = document.getElementById('payment-options');
        
        paymentOptions.addEventListener('click', (e) => {
            const clickedMethod = e.target.closest('.payment-method');
            
            if (clickedMethod) {
                // Bỏ active ở tất cả
                paymentOptions.querySelectorAll('.payment-method').forEach(method => {
                    method.classList.remove('active');
                });
                
                // Thêm active cho cái được click
                clickedMethod.classList.add('active');
                
                // Tự động check radio button bên trong
                clickedMethod.querySelector('input[type="radio"]').checked = true;
            }
        });
        
        // Logic cho nút Thanh Toán
        const confirmBtn = document.getElementById('confirm-payment-btn');
        confirmBtn.addEventListener('click', async () => {
            // Khi nhấn nút này, bạn sẽ:
            // 1. Thu thập dữ liệu (email, phone, phương thức thanh toán).
            // 2. Gửi toàn bộ thông tin đơn hàng (từ trang trước) và thông tin thanh toán
            //    lên Backend Java của bạn (Lớp DonDatVe, Lớp ThanhToan).
            // 3. Backend xử lý, nếu thành công thì chuyển hướng người dùng
            //    sang trang "Thành Công" (hiển thị mã QR vé).
            
            const donHangData = {};
            // Trong đồ án, bạn sẽ điều hướng đến trang "booking-success.php"
            // window.location.href = 'booking-success.php';

            window.location.href = 'booking-success.php';
        });
    </script>

</body>
</html>