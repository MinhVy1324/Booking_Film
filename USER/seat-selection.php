<?php
// File: USER/seat-selection.php

// 1. NẠP HEADER VÀ CÁC LỚP DAO
// (Dùng __DIR__ để có đường dẫn tuyệt đối, an toàn)
include_once __DIR__ . '/../TEMPLATES/header.php'; // Nạp header (đã có session_start)
include_once __DIR__ . '/../BACKEND/DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/GheDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/ChiTietDatVeDAO.php';
// (Các file DTO/Model đã được nạp bên trong DAO)

// 2. LẤY ID SUẤT CHIẾU TỪ URL
if (!isset($_GET['suatchieu_id'])) {
    echo "<main class='container' style='color: white; padding: 20px;'>Lỗi: Không tìm thấy suất chiếu.</main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit(); // Dừng script
}
$suatchieu_id = (int)$_GET['suatchieu_id'];

// 3. TẠO CÁC ĐỐI TƯỢNG DAO
$scDAO = new SuatChieuDAO();
$gheDAO = new GheDAO();
$ctdvDAO = new ChiTietDatVeDAO();

// 4. GỌI DAO ĐỂ LẤY TOÀN BỘ DỮ LIỆU CẦN THIẾT

// 4.1. Lấy thông tin chi tiết suất chiếu (Tên phim, rạp, giờ, và IdPhongChieu)
$suatchieu = $scDAO->getSuatChieuDetailsById($suatchieu_id);

if ($suatchieu == null) {
    echo "<main class='container' style='color: white; padding: 20px;'>Lỗi: Suất chiếu không hợp lệ.</main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}

// Lấy IdPhongChieu từ thông tin suất chiếu
$id_phongchieu = $suatchieu['IdPhongChieu'];
$gia_ve_co_ban = $suatchieu['GiaVe'];
// (Giả định giá VIP = 1.2 * giá thường, bạn có thể đặt giá cứng)
$gia_ve_vip = $gia_ve_co_ban * 1.2; 

// 4.2. Lấy toàn bộ SƠ ĐỒ GHẾ của phòng này (1 mảng các đối tượng Ghe)
$listGhe = $gheDAO->getGheByPhongChieuId($id_phongchieu);

// 4.3. Lấy danh sách ID các GHẾ ĐÃ BỊ ĐẶT (1 mảng các số [1, 5, 10])
$listGheDaDat = $ctdvDAO->getGheDaDat($suatchieu_id);

?>

<title>Bước 2: Chọn Ghế</title>

<style>
    /* (CSS cho .main-header, .main-footer đã có trong header.php) */
    
    /* Căn giữa nội dung chính */
    .main-content {
        width: 100%;
        max-width: 1000px;
        /* (Để căn giữa <main> nếu nó không phải flex-grow) */
        margin: 0 auto; 
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* 1. Thông tin suất chiếu */
    .showtime-info {
        text-align: center; background-color: #1a1a1a;
        padding: 15px; border-radius: 8px;
        margin-bottom: 30px; border: 1px solid #333;
        width: 100%;
        max-width: 800px;
    }
    .showtime-info h1 { font-size: 1.5rem; margin-bottom: 5px; }
    .showtime-info p { font-size: 1rem; color: #aaa; }

    /* 2. Sơ đồ ghế */
    .seat-map-container {
        perspective: 800px; /* Hiệu ứng 3D */
        margin-bottom: 30px;
        width: 100%;
        overflow-x: auto; /* Cho phép cuộn ngang nếu sơ đồ quá lớn */
        padding: 20px 0;
    }
    .screen {
        width: 500px; max-width: 90%;
        height: 30px; background-color: #555; color: #ccc;
        text-align: center; line-height: 30px; font-weight: bold;
        margin: 0 auto 30px auto;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        transform: rotateX(-20deg); 
    }

    /* Sơ đồ ghế (Dùng CSS Grid) */
    .seat-grid {
        display: grid;
        /* (Sửa số 10 này thành số cột thực tế của bạn) */
        grid-template-columns: repeat(10, 30px);
        gap: 10px;
        justify-content: center;
    }

    .seat {
        width: 30px; height: 30px;
        background-color: #444; /* Ghế thường, còn trống */
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
        /* Thêm thuộc tính để JS đọc */
        font-size: 0.6rem; /* Hiển thị tên ghế */
        color: white;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
    }
    
    .seat.vip {
        background-color: #a02c2c; /* Ghế VIP */
    }
    
    .seat.occupied {
        background-color: #222; /* Ghế đã bán (tối hơn) */
        cursor: not-allowed;
    }

    .seat.selected {
        background-color: #61d9a4; /* Màu xanh lá khi chọn */
        color: #121212;
    }
    
    .seat:not(.occupied):hover {
        transform: scale(1.1);
    }

    /* 3. Chú thích */
    .legend {
        display: flex; justify-content: center;
        flex-wrap: wrap; gap: 20px;
        margin-bottom: 30px;
    }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .legend-item .seat-example {
        width: 20px; height: 20px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .legend-item .seat-example.available { background-color: #444; }
    .legend-item .seat-example.vip { background-color: #a02c2c; }
    .legend-item .seat-example.selected { background-color: #61d9a4; }
    .legend-item .seat-example.occupied { background-color: #222; }

    /* 4. Tóm tắt thanh toán (Form) */
    .checkout-form {
        width: 100%;
        max-width: 800px;
    }
    .checkout-summary {
        background-color: #1a1a1a; padding: 20px 30px;
        border-radius: 8px; width: 100%;
        border-top: 3px solid #e50914;
    }
    .summary-text { font-size: 1.1rem; margin-bottom: 15px; }
    #selected-seats-list { font-weight: bold; color: #61d9a4; }
    #total-price { font-size: 1.5rem; font-weight: bold; color: #fff; }
    .checkout-btn {
        background-color: #e50914; color: #ffffff;
        padding: 12px 25px; border: none; border-radius: 5px;
        font-size: 1.1rem; font-weight: bold;
        text-decoration: none; cursor: pointer;
        transition: background-color 0.3s;
        width: 100%; /* Nút bấm full-width */
        margin-top: 10px;
    }
    .checkout-btn:hover { background-color: #c40812; }
</style>

<main class="main-content">
    
    <div class="showtime-info">
        <h1><?php echo htmlspecialchars($suatchieu['TenPhim']); ?></h1>
        <p>
            <?php echo htmlspecialchars($suatchieu['TenRap']); ?> | 
            <?php echo htmlspecialchars($suatchieu['TenPhong']); ?> | 
            <?php echo date('d/m/Y', strtotime($suatchieu['NgayChieu'])); ?> - 
            <strong><?php echo date('H:i', strtotime($suatchieu['GioBatDau'])); ?></strong>
        </p>
    </div>

    <form id="booking-form" class="checkout-form" action="../BACKEND/CONTROLLER/BookingController.php" method="POST">
        <input type="hidden" name="suatchieu_id" value="<?php echo $suatchieu_id; ?>">
        
        <input type="hidden" name="selected_seats_ids" id="selected-seats-input">
        <input type="hidden" name="selected_seats_names" id="selected-seats-names-input">
        <input type="hidden" name="total_price" id="total-price-input">
        
        <input type="hidden" name="action" value="add_to_cart">

        <div class="seat-map-container">
            <div class="screen">MÀN HÌNH</div>
            
            <div class="seat-grid">
                <?php
                // 5. LẶP QUA TOÀN BỘ SƠ ĐỒ GHẾ
                foreach ($listGhe as $ghe) { // $ghe là 1 đối tượng
                    
                    // 5.1. Xây dựng class CSS
                    $classes = 'seat';
                    
                    // 5.2. Kiểm tra loại ghế
                    $gia = $gia_ve_co_ban;
                    if ($ghe->getLoaiGhe() == 'VIP') {
                        $classes .= ' vip';
                        $gia = $gia_ve_vip;
                    }
                    
                    // 5.3. KIỂM TRA QUAN TRỌNG: Ghế này có trong danh sách ĐÃ BỊ ĐẶT không?
                    if (in_array($ghe->getId(), $listGheDaDat)) {
                        $classes .= ' occupied'; // Tô màu xám, không cho click
                    }

                    // 5.4. In ra thẻ <div> của ghế
                    echo '<div class="' . $classes . '" 
                               data-seat-id="' . $ghe->getId() . '" 
                               data-seat-name="' . htmlspecialchars($ghe->getTenGhe()) . '"
                               data-price="' . $gia . '">';
                    echo htmlspecialchars($ghe->getTenGhe());
                    echo '</div>';
                }
                ?>
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
            
            <button type="submit" class="checkout-btn">Tiếp Tục</button>
        </div>
        
    </form> </main> <script>
    const seatGrid = document.querySelector('.seat-grid');
    const selectedSeatsList = document.getElementById('selected-seats-list');
    const totalPriceElement = document.getElementById('total-price');
    
    // Input ẩn
    const selectedSeatsInput = document.getElementById('selected-seats-input');
    const selectedSeatsNamesInput = document.getElementById('selected-seats-names-input');
    const totalPriceInput = document.getElementById('total-price-input');
    
    const bookingForm = document.getElementById('booking-form');

    // Mảng lưu các đối tượng ghế đã chọn {id, name, price}
    let selectedSeats = [];

    // Hàm cập nhật tóm tắt và input ẩn
    function updateSummary() {
        // Cập nhật tên ghế
        const seatNames = selectedSeats.map(seat => seat.name);
        if (seatNames.length === 0) {
            selectedSeatsList.innerText = 'Chưa chọn';
        } else {
            selectedSeatsList.innerText = seatNames.join(', ');
        }
        
        // Cập nhật tổng tiền
        const totalPrice = selectedSeats.reduce((total, seat) => total + seat.price, 0);
        totalPriceElement.innerText = `${totalPrice.toLocaleString('vi-VN')} VNĐ`;
        
        // CẬP NHẬT INPUT ẨN (Quan trọng)
        selectedSeatsInput.value = selectedSeats.map(seat => seat.id).join(',');
        selectedSeatsNamesInput.value = seatNames.join(', ');
        totalPriceInput.value = totalPrice;
    }

    // Gắn sự kiện click cho LƯỚI GHẾ
    seatGrid.addEventListener('click', (e) => {
        const target = e.target;
        
        // Chỉ xử lý khi click vào ghế (.seat) VÀ không phải ghế đã bán (.occupied)
        if (target.classList.contains('seat') && !target.classList.contains('occupied')) {
            
            // Lấy thông tin từ data-*
            const seatId = parseInt(target.getAttribute('data-seat-id'));
            const seatName = target.getAttribute('data-seat-name');
            const seatPrice = parseInt(target.getAttribute('data-price'));
            
            // Thêm/xóa class 'selected'
            target.classList.toggle('selected');
            
            // Kiểm tra xem ghế đã được chọn hay bỏ chọn
            if (target.classList.contains('selected')) {
                // Thêm vào mảng
                selectedSeats.push({ id: seatId, name: seatName, price: seatPrice });
            } else {
                // Bỏ chọn -> Lọc ra khỏi mảng
                selectedSeats = selectedSeats.filter(seat => seat.id !== seatId);
            }
            
            // Cập nhật lại tóm tắt
            updateSummary();
        }
    });
    
    // Kiểm tra khi submit form (phải chọn ít nhất 1 ghế)
    bookingForm.addEventListener('submit', (e) => {
        if (selectedSeats.length === 0) {
            e.preventDefault(); // Ngăn form gửi đi
            alert('Vui lòng chọn ít nhất một ghế!');
        }
    });

    // Chạy lần đầu khi tải trang
    updateSummary();
</script>

<?php
// 8. Nạp Footer
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>