<?php
// File: USER/seat-selection.php

// 1. NẠP HEADER VÀ CÁC LỚP DAO
include_once __DIR__ . '/../TEMPLATES/header.php'; 
include_once __DIR__ . '/../BACKEND/DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/GheDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/ChiTietDatVeDAO.php';

// ... (Code lấy $suatchieu_id, tạo DAO, lấy $suatchieu, $gia_ve..., $listGheDaDat giữ nguyên) ...
if (!isset($_GET['suatchieu_id'])) { /* ... Lỗi ... */ }
$suatchieu_id = (int)$_GET['suatchieu_id'];
$scDAO = new SuatChieuDAO();
$gheDAO = new GheDAO();
$ctdvDAO = new ChiTietDatVeDAO();
$suatchieu = $scDAO->getSuatChieuDetailsById($suatchieu_id);
if ($suatchieu == null) { /* ... Lỗi ... */ }
$id_phongchieu = $suatchieu['IdPhongChieu'];
$gia_ve_co_ban = $suatchieu['GiaVe'];
$gia_ve_vip = $gia_ve_co_ban * 1.2; 
$listGhe = $gheDAO->getGheByPhongChieuId($id_phongchieu);
$listGheDaDat = $ctdvDAO->getGheDaDat($suatchieu_id);


// 5. ✅ NÂNG CẤP QUAN TRỌNG: NHÓM GHẾ LẠI THEO HÀNG (ROW)
// Tạo ra một mảng $ghe_theo_hang['A'] = [ghế A1, ghế A2, ...]
$ghe_theo_hang = [];
foreach ($listGhe as $ghe) {
    // Lấy chữ cái đầu tiên (Hàng)
    $hang = substr($ghe->getTenGhe(), 0, 1); 
    if (!isset($ghe_theo_hang[$hang])) {
        $ghe_theo_hang[$hang] = [];
    }
    $ghe_theo_hang[$hang][] = $ghe;
}
?>

<title>Bước 2: Chọn Ghế</title>

<style>
    /* ... (CSS cho .main-header, .main-footer, .main-content, .showtime-info, .screen, .seat, .legend, .checkout-form ... giữ nguyên như cũ) ... */
    
    .main-content {
        width: 100%;
        max-width: 1000px; /* Tăng max-width để chứa rạp 20 ghế */
        margin: 0 auto; 
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .showtime-info {
        text-align: center; background-color: #1a1a1a;
        padding: 15px; border-radius: 8px;
        margin-bottom: 30px; border: 1px solid #333;
        width: 100%;
        max-width: 800px;
    }
    .seat-map-container {
        perspective: 800px; 
        margin-bottom: 30px;
        width: 100%;
        overflow-x: auto; 
        padding: 20px 0;
        text-align: center;
    }
    .screen {
        width: 90%; /* Để màn hình tự co giãn */
        min-width: 500px;
        height: 30px; background-color: #555; color: #ccc;
        text-align: center; line-height: 30px; font-weight: bold;
        margin: 0 auto 30px auto;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        transform: rotateX(-20deg); 
    }

    /* ✅✅✅ SỬA LỖI TẠI ĐÂY ✅✅✅ */
    /* .seat-grid không còn là Grid, mà là container cho các HÀNG */
    .seat-grid {
        display: inline-block;
        flex-direction: column; /* Các hàng ghế xếp dọc */
        gap: 10px; /* Khoảng cách giữa các hàng */
        padding: 0 10px;
        text-align: left;
    }
    
    /* MỖI HÀNG (ROW) LÀ 1 FLEXBOX RIÊNG */
    .seat-row {
        display: flex;
        flex-direction: row; /* Các ghế xếp ngang */
        justify-content: flex-start;
        gap: 10px; /* Khoảng cách giữa các ghế */
    }
    
    /* Nhãn Hàng (A, B, C...) */
    .row-label {
        width: 30px; height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-weight: bold;
    }

    .seat {
        width: 30px; height: 30px;
        background-color: #444; 
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
        font-size: 0.6rem; 
        color: white;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
    }
    
    .seat.vip { background-color: #a02c2c; }
    .seat.occupied { background-color: #222; cursor: not-allowed; }
    .seat.selected { background-color: #61d9a4; color: #121212; }
    .seat:not(.occupied):hover { transform: scale(1.1); }

    /* (CSS .legend, .checkout-form, .checkout-summary, .checkout-btn giữ nguyên) */
    .legend { display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; margin-bottom: 30px; }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .legend-item .seat-example { width: 20px; height: 20px; border-top-left-radius: 5px; border-top-right-radius: 5px; }
    .legend-item .seat-example.available { background-color: #444; }
    .legend-item .seat-example.vip { background-color: #a02c2c; }
    .legend-item .seat-example.selected { background-color: #61d9a4; }
    .legend-item .seat-example.occupied { background-color: #222; }
    .checkout-form { width: 100%; max-width: 800px; }
    .checkout-summary { background-color: #1a1a1a; padding: 20px 30px; border-radius: 8px; width: 100%; border-top: 3px solid #e50914; }
    .summary-text { font-size: 1.1rem; margin-bottom: 15px; }
    #selected-seats-list { font-weight: bold; color: #61d9a4; }
    #total-price { font-size: 1.5rem; font-weight: bold; color: #fff; }
    .checkout-btn { background-color: #e50914; color: #ffffff; padding: 12px 25px; border: none; border-radius: 5px; font-size: 1.1rem; font-weight: bold; text-decoration: none; cursor: pointer; transition: background-color 0.3s; width: 100%; margin-top: 10px; }
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
            
            <div class="seat-grid" id="seat-grid-container"> <?php
                // 5. LẶP QUA CÁC HÀNG (A, B, C...)
                foreach ($ghe_theo_hang as $tenHang => $listGheTrongHang) {
                    
                    // 5.1. "Vẽ" 1 hàng mới
                    echo '<div class="seat-row">';
                    echo '<div class="row-label">' . $tenHang . '</div>'; // In nhãn A, B, C

                    // 5.2. LẶP QUA CÁC GHẾ (1, 2, 3...) TRONG HÀNG ĐÓ
                    foreach ($listGheTrongHang as $ghe) {
                        $classes = 'seat';
                        $gia = $gia_ve_co_ban;
                        
                        if ($ghe->getLoaiGhe() == 'VIP') {
                            $classes .= ' vip';
                            $gia = $gia_ve_vip;
                        }
                        
                        if (in_array($ghe->getId(), $listGheDaDat)) {
                            $classes .= ' occupied';
                        }

                        echo '<div class="' . $classes . '" 
                                   data-seat-id="' . $ghe->getId() . '" 
                                   data-seat-name="' . htmlspecialchars($ghe->getTenGhe()) . '"
                                   data-price="' . $gia . '">';
                        echo htmlspecialchars(substr($ghe->getTenGhe(), 1)); // Chỉ in số (1, 2, 3...)
                        echo '</div>';
                    }
                    echo '</div>'; // Đóng .seat-row
                }
                ?>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item"><div class="seat-example available"></div><span>Ghế Thường</span></div>
            <div class="legend-item"><div class="seat-example vip"></div><span>Ghế VIP</span></div>
            <div class="legend-item"><div class="seat-example selected"></div><span>Đang chọn</span></div>
            <div class="legend-item"><div class="seat-example occupied"></div><span>Đã bán</span></div>
        </div>

        <div class="checkout-summary">
            <div class="summary-text">
                <div>Ghế đã chọn: <span id="selected-seats-list">Chưa chọn</span></div>
                <div>Tổng cộng: <span id="total-price">0 VNĐ</span></div>
            </div>
            
            <button type="submit" class="checkout-btn">Tiếp Tục</button>
        </div>
        
    </form> </main> <script>
    // ✅ SỬA LẠI DÒNG NÀY:
    const seatGridContainer = document.getElementById('seat-grid-container'); 
    
    const selectedSeatsList = document.getElementById('selected-seats-list');
    const totalPriceElement = document.getElementById('total-price');
    const selectedSeatsInput = document.getElementById('selected-seats-input');
    const selectedSeatsNamesInput = document.getElementById('selected-seats-names-input');
    const totalPriceInput = document.getElementById('total-price-input');
    const bookingForm = document.getElementById('booking-form');

    let selectedSeats = [];

    // (Hàm updateSummary() giữ nguyên)
    function updateSummary() {
        const seatNames = selectedSeats.map(seat => seat.name);
        if (seatNames.length === 0) {
            selectedSeatsList.innerText = 'Chưa chọn';
        } else {
            selectedSeatsList.innerText = seatNames.join(', ');
        }
        const totalPrice = selectedSeats.reduce((total, seat) => total + seat.price, 0);
        totalPriceElement.innerText = `${totalPrice.toLocaleString('vi-VN')} VNĐ`;
        selectedSeatsInput.value = selectedSeats.map(seat => seat.id).join(',');
        selectedSeatsNamesInput.value = seatNames.join(', ');
        totalPriceInput.value = totalPrice;
    }

    // ✅ SỬA LẠI DÒNG NÀY (Event Delegation):
    // Gắn sự kiện click cho CẢ CONTAINER
    seatGridContainer.addEventListener('click', (e) => {
        const target = e.target;
        
        // Chỉ xử lý khi click vào ghế (.seat) VÀ không phải ghế đã bán (.occupied)
        if (target.classList.contains('seat') && !target.classList.contains('occupied')) {
            const seatId = parseInt(target.getAttribute('data-seat-id'));
            const seatName = target.getAttribute('data-seat-name');
            const seatPrice = parseInt(target.getAttribute('data-price'));
            
            target.classList.toggle('selected');
            
            if (target.classList.contains('selected')) {
                selectedSeats.push({ id: seatId, name: seatName, price: seatPrice });
            } else {
                selectedSeats = selectedSeats.filter(seat => seat.id !== seatId);
            }
            // Sắp xếp lại mảng ghế đã chọn (để hiển thị A1, A2, B1...)
            selectedSeats.sort((a, b) => a.name.localeCompare(b.name, undefined, {numeric: true}));
            
            updateSummary();
        }
    });
    
    // (Hàm bookingForm.addEventListener giữ nguyên)
    bookingForm.addEventListener('submit', (e) => {
        if (selectedSeats.length === 0) {
            e.preventDefault(); 
            alert('Vui lòng chọn ít nhất một ghế!');
        }
    });

    updateSummary();
</script>

<?php
// 8. Nạp Footer
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>