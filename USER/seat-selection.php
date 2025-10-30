<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Ghế</title>
    
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
            align-items: center;
            min-height: 100vh;
        }

        /* Header đơn giản (Tái sử dụng) */
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
        
        /* Nội dung chính */
        .main-content {
            width: 100%;
            max-width: 1000px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 1. Thông tin suất chiếu */
        .showtime-info {
            text-align: center;
            background-color: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #333;
        }

        .showtime-info h1 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .showtime-info p {
            font-size: 1rem;
            color: #aaa;
        }

        /* 2. Sơ đồ ghế */
        .seat-map-container {
            perspective: 800px; /* Tạo hiệu ứng 3D cho màn hình */
            margin-bottom: 30px;
        }

        .screen {
            width: 500px;
            height: 30px;
            background-color: #555;
            color: #ccc;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin: 0 auto 30px auto;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
            /* Hiệu ứng cong */
            transform: rotateX(-20deg); 
        }

        .seat-grid {
            display: grid;
            /* Cấu hình 12 cột cho ghế + 1 cột cho nhãn hàng */
            grid-template-columns: 30px repeat(12, 30px);
            gap: 10px;
            justify-content: center;
        }

        /* Nhãn hàng (A, B, C...) */
        .row-label {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #888;
            font-weight: bold;
            grid-column: 1 / span 1; /* Luôn ở cột 1 */
        }

        .seat {
            width: 30px;
            height: 30px;
            background-color: #444; /* Ghế thường, còn trống */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }
        
        /* Tạo khoảng cách cho lối đi (giả sử cột 4 và 10) */
        .seat:nth-child(13n + 5) { /* Cột 4 */
            margin-right: 15px;
        }
        .seat:nth-child(13n + 11) { /* Cột 10 */
            margin-right: 15px;
        }

        /* Các loại ghế */
        .seat.vip {
            background-color: #a02c2c; /* Ghế VIP */
        }
        
        .seat.occupied {
            background-color: #222; /* Ghế đã bán (tối hơn) */
            cursor: not-allowed;
        }

        /* Trạng thái */
        .seat.selected {
            background-color: #61d9a4; /* Màu xanh lá khi chọn */
        }
        
        /* Hiệu ứng Hover (chỉ cho ghế còn trống) */
        .seat:not(.occupied):hover {
            transform: scale(1.1);
        }

        /* 3. Chú thích */
        .legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-item .seat-example {
            width: 20px;
            height: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .legend-item .seat-example.available { background-color: #444; }
        .legend-item .seat-example.vip { background-color: #a02c2c; }
        .legend-item .seat-example.selected { background-color: #61d9a4; }
        .legend-item .seat-example.occupied { background-color: #222; }

        /* 4. Tóm tắt thanh toán */
        .checkout-summary {
            background-color: #1a1a1a;
            padding: 20px 30px;
            border-radius: 8px;
            width: 100%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 3px solid #e50914;
        }
        
        .summary-text {
            font-size: 1.1rem;
        }
        
        #selected-seats-list {
            font-weight: bold;
            color: #61d9a4;
        }
        
        #total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .checkout-btn {
            background-color: #e50914;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .checkout-btn:hover {
            background-color: #c40812;
        }

        /* Footer (Tái sử dụng) */
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

    <main class="main-content">
        
        <div class="showtime-info">
            <h1>LẬT MẶT 7: MỘT ĐIỀU ƯỚC</h1>
            <p>CGV Hùng Vương | Phòng 3 | Hôm nay, 19:45</p>
        </div>

        <div class="seat-map-container">
            <div class="screen">MÀN HÌNH</div>
            
            <div class="seat-grid" id="seat-grid">
                <div class="row-label">A</div>
                <div class="seat available" data-seat-name="A1"></div>
                <div class="seat available" data-seat-name="A2"></div>
                <div class="seat available" data-seat-name="A3"></div>
                <div class="seat available" data-seat-name="A4"></div>
                <div class="seat occupied" data-seat-name="A5"></div>
                <div class="seat occupied" data-seat-name="A6"></div>
                <div class="seat available" data-seat-name="A7"></div>
                <div class="seat available" data-seat-name="A8"></div>
                <div class="seat available" data-seat-name="A9"></div>
                <div class="seat available" data-seat-name="A10"></div>
                <div class="seat available" data-seat-name="A11"></div>
                <div class="seat available" data-seat-name="A12"></div>
                
                <div class="row-label">B</div>
                <div class="seat available" data-seat-name="B1"></div>
                <div class="seat available" data-seat-name="B2"></div>
                <div class="seat available" data-seat-name="B3"></div>
                <div class="seat available" data-seat-name="B4"></div>
                <div class="seat available" data-seat-name="B5"></div>
                <div class="seat available" data-seat-name="B6"></div>
                <div class="seat available" data-seat-name="B7"></div>
                <div class="seat available" data-seat-name="B8"></div>
                <div class="seat available" data-seat-name="B9"></div>
                <div class="seat available" data-seat-name="B10"></div>
                <div class="seat available" data-seat-name="B11"></div>
                <div class="seat available" data-seat-name="B12"></div>
                
                <div class="row-label">C</div>
                <div class="seat vip" data-seat-name="C1"></div>
                <div class="seat vip" data-seat-name="C2"></div>
                <div class="seat vip" data-seat-name="C3"></div>
                <div class="seat vip" data-seat-name="C4"></div>
                <div class="seat vip occupied" data-seat-name="C5"></div>
                <div class="seat vip occupied" data-seat-name="C6"></div>
                <div class="seat vip occupied" data-seat-name="C7"></div>
                <div class="seat vip" data-seat-name="C8"></div>
                <div class="seat vip" data-seat-name="C9"></div>
                <div class="seat vip" data-seat-name="C10"></div>
                <div class="seat vip" data-seat-name="C11"></div>
                <div class="seat vip" data-seat-name="C12"></div>

                <div class="row-label">D</div>
                <div class="seat vip" data-seat-name="D1"></div>
                <div class="seat vip" data-seat-name="D2"></div>
                <div class="seat vip" data-seat-name="D3"></div>
                <div class="seat vip" data-seat-name="D4"></div>
                <div class="seat vip" data-seat-name="D5"></div>
                <div class="seat vip" data-seat-name="D6"></div>
                <div class="seat vip" data-seat-name="D7"></div>
                <div class="seat vip" data-seat-name="D8"></div>
                <div class="seat vip" data-seat-name="D9"></div>
                <div class="seat vip" data-seat-name="D10"></div>
                <div class="seat vip" data-seat-name="D11"></div>
                <div class="seat vip" data-seat-name="D12"></div>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item">
                <div class="seat-example available"></div>
                <span>Ghế Thường</span>
            </div>
            <div class="legend-item">
                <div class="seat-example vip"></div>
                <span>Ghế VIP</span>
            </div>
            <div class="legend-item">
                <div class="seat-example selected"></div>
                <span>Đang chọn</span>
            </div>
            <div class="legend-item">
                <div class="seat-example occupied"></div>
                <span>Đã bán</span>
            </div>
        </div>

        <div class="checkout-summary">
            <div class="summary-text">
                <div>Ghế đã chọn: <span id="selected-seats-list">Chưa chọn</span></div>
                <div>Tổng cộng: <span id="total-price">0 VNĐ</span></div>
            </div>
            <a href="/USER/checkout.php" class="checkout-btn">Tiếp Tục</a>
        </div>
        
    </main>

    <footer class="main-footer">
        <p>&copy; 2025 Đồ Án PTTK Hướng Đối Tượng.</p>
    </footer>

    <script>
        // JAVASCRIPT XỬ LÝ LOGIC CHỌN GHẾ

        // Giá vé (Backend Java của bạn sẽ cung cấp cái này)
        const GIA_THUONG = 100000;
        const GIA_VIP = 150000;

        // Lấy các phần tử DOM
        const seatGrid = document.getElementById('seat-grid');
        const selectedSeatsList = document.getElementById('selected-seats-list');
        const totalPriceElement = document.getElementById('total-price');

        // Hàm cập nhật tóm tắt (tên ghế, tổng tiền)
        function updateSummary() {
            // 1. Tìm tất cả các ghế đang có class 'selected'
            const selectedSeats = document.querySelectorAll('.seat.selected');
            
            // 2. Lấy tên ghế từ thuộc tính 'data-seat-name'
            const selectedSeatNames = [];
            let total = 0;
            
            selectedSeats.forEach(seat => {
                // Thêm tên ghế vào mảng
                selectedSeatNames.push(seat.getAttribute('data-seat-name'));
                
                // 3. Tính tổng tiền dựa trên class 'vip'
                if (seat.classList.contains('vip')) {
                    total += GIA_VIP;
                } else {
                    total += GIA_THUONG;
                }
            });

            // 4. Cập nhật giao diện tóm tắt
            if (selectedSeats.length === 0) {
                selectedSeatsList.innerText = 'Chưa chọn';
                totalPriceElement.innerText = '0 VNĐ';
            } else {
                selectedSeatsList.innerText = selectedSeatNames.join(', ');
                totalPriceElement.innerText = `${total.toLocaleString('vi-VN')} VNĐ`;
            }
        }

        // Thêm sự kiện click cho LƯỚI GHẾ (sử dụng event delegation)
        seatGrid.addEventListener('click', (e) => {
            const target = e.target;
            
            // Kiểm tra xem phần tử được click có phải là 1 ghế VÀ ghế đó không bị chiếm
            if (target.classList.contains('seat') && !target.classList.contains('occupied')) {
                // Thêm/xóa class 'selected'
                target.classList.toggle('selected');
                
                // Cập nhật lại tóm tắt
                updateSummary();
            }
        });

        // Chạy lần đầu khi tải trang để đảm bảo hiển thị 0 VNĐ
        updateSummary();
    </script>

</body>
</html>