<?php
// File: USER/movie-details.php

// 1. Nạp Header (Menu, Session)
// (Đi ra 1 cấp, vào TEMPLATES)
include_once __DIR__ . '/../TEMPLATES/header.php'; 

// 2. Nạp các file Lớp (Class) DAO cần thiết
include_once __DIR__ . '/../BACKEND/DAO/PhimDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/SuatChieuDAO.php';

// 3. Lấy ID phim từ URL (ví dụ: ?id=1)
if (!isset($_GET['id'])) {
    echo "<main class='container'><p>Không tìm thấy phim.</p></main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}
$phim_id = (int)$_GET['id'];

// 4. TẠO ĐỐI TƯỢNG DAO
$phimDAO = new PhimDAO();
$suatChieuDAO = new SuatChieuDAO();

// 5. GỌI DAO ĐỂ LẤY DỮ LIỆU
// Lấy thông tin phim
$phim = $phimDAO->getPhimById($phim_id);
// Lấy danh sách suất chiếu
$list_suatchieu = $suatChieuDAO->getSuatChieuByPhimId($phim_id);

// 6. Kiểm tra phim có tồn tại không
if ($phim == null) {
    echo "<main class='container'><p>Phim không tồn tại.</p></main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}
?>

<title><?php echo htmlspecialchars($phim->getTenPhim()); ?> - Chi Tiết</title>

<style>
    /* ... (CSS của .main-header, .main-footer đã có trong header.php) ... */

    /* 1. Phần Thông Tin Phim */
    .movie-hero { padding: 40px 0; }
    .movie-hero-container {
        display: flex; gap: 40px;
        max-width: 1200px; margin: 0 auto; width: 90%;
    }
    .movie-poster { flex-basis: 300px; flex-shrink: 0; }
    .movie-poster img { width: 100%; border-radius: 8px; }
    .movie-details { flex-grow: 1; }
    .movie-details h1 { font-size: 2.5rem; color: #ffffff; margin-bottom: 10px; }
    .movie-details .tag {
        background-color: #e50914; color: white;
        padding: 2px 8px; border-radius: 5px;
        font-size: 0.9rem; font-weight: bold;
    }
    .movie-specs {
        margin: 15px 0; display: flex;
        flex-wrap: wrap; gap: 20px; color: #aaa;
    }
    .movie-description { margin-bottom: 20px; line-height: 1.6; }
    
    /* 2. Phần Đặt Vé (Booking Widget) */
    .booking-section {
        background-color: #1a1a1a; padding: 30px; border-radius: 8px;
        margin: 40px auto 0 auto; max-width: 1200px; width: 90%;
    }
    .booking-section h2 {
        text-align: center; font-size: 1.8rem;
        margin-bottom: 20px; color: #e50914;
    }
    
    /* Danh sách rạp / suất chiếu */
    .cinema-item {
        background-color: #222; margin-bottom: 15px;
        border-radius: 5px; padding: 20px;
    }
    .cinema-item h3 { font-size: 1.3rem; color: #fff; margin-bottom: 5px; }
    .cinema-item p { font-size: 0.9rem; color: #aaa; margin-bottom: 15px; }
    .date-group { margin-bottom: 10px; }
    .date-group h4 {
        color: #61d9a4; /* Màu xanh lá */
        border-bottom: 1px solid #444;
        padding-bottom: 5px; margin-bottom: 10px;
    }
    .showtime-grid { display: flex; flex-wrap: wrap; gap: 15px; }
    .showtime-btn {
        background-color: #444; color: #fff; text-decoration: none;
        padding: 10px 15px; border-radius: 5px; font-weight: bold;
        transition: background-color 0.3s, transform 0.2s;
    }
    .showtime-btn:hover { background-color: #e50914; transform: scale(1.05); }
</style>

<main>
    <section class="movie-hero">
        <div class="container movie-hero-container">
            <div class="movie-poster">
                <img src="<?php echo htmlspecialchars($phim->getPosterUrl()); ?>" alt="Poster Phim">
            </div>
            
            <div class="movie-details">
                <h1><?php echo htmlspecialchars($phim->getTenPhim()); ?></h1>
                <span class="tag"><?php echo htmlspecialchars($phim->getXepHang()); ?></span>
                
                <div class="movie-specs">
                    <span>Thể loại: <strong><?php echo htmlspecialchars($phim->getTheLoai()); ?></strong></span>
                    <span>Thời lượng: <strong><?php echo $phim->getThoiLuong(); ?> phút</strong></span>
                    <span>Khởi chiếu: <strong><?php echo date('d/m/Y', strtotime($phim->getNgayKhoiChieu())); ?></strong></span>
                </div>

                <p class="movie-description">
                    <?php echo nl2br(htmlspecialchars($phim->getMoTa())); // nl2br để giữ xuống dòng ?>
                </p>
            </div>
        </div>
    </section>

    <section class="booking-section container">
        <h2>Mua Vé Theo Suất Chiếu</h2>

        <div id="showtime-lists">
            <?php
            // 7. KIỂM TRA VÀ LẶP QUA DANH SÁCH SUẤT CHIẾU
            if (count($list_suatchieu) > 0) {
                
                $currentRap = "";
                $currentNgay = "";

                // Lặp qua mảng $list_suatchieu lấy từ DAO
                foreach($list_suatchieu as $sc) {
                    
                    // 7.1. Nếu là một Rạp mới, in ra tên Rạp
                    if ($sc['TenRap'] != $currentRap) {
                        if ($currentRap != "") {
                            // Đóng thẻ của Rạp trước đó (nếu không phải lần đầu)
                            echo '</div></div></div>'; // Đóng .showtime-grid, .date-group, .cinema-item
                        }
                        $currentRap = $sc['TenRap'];
                        echo '<div class="cinema-item">';
                        echo '<h3>' . htmlspecialchars($currentRap) . '</h3>';
                        echo '<p>' . htmlspecialchars($sc['DiaChi']) . '</p>';
                        
                        $currentNgay = ""; // Reset ngày khi đổi rạp
                    }

                    // 7.2. Nếu là một Ngày mới (trong cùng 1 Rạp), in ra Ngày
                    if ($sc['NgayChieu'] != $currentNgay) {
                        if ($currentNgay != "") {
                            // Đóng thẻ của Ngày trước đó
                            echo '</div></div>'; // Đóng .showtime-grid, .date-group
                        }
                        $currentNgay = $sc['NgayChieu'];
                        echo '<div class="date-group">';
                        echo '<h4>Ngày: ' . date('d/m/Y', strtotime($currentNgay)) . '</h4>';
                        echo '<div class="showtime-grid">';
                    }

                    // 7.3. In ra giờ chiếu (Nút Mua Vé)
                    // Link sẽ dẫn đến trang chọn ghế, mang theo ID Suất Chiếu
                    echo '<a href="seat-selection.php?suatchieu_id=' . $sc['Id'] . '" class="showtime-btn">';
                    echo date('H:i', strtotime($sc['GioBatDau']));
                    echo '</a>';
                }
                
                // Đóng các thẻ div cuối cùng
                echo '</div></div></div>';

            } else {
                // Nếu không có suất chiếu nào
                echo "<p style='text-align: center;'>Phim này hiện chưa có suất chiếu.</p>";
            }
            ?>
        </div>
    </section>
</main> <?php
// 8. Nạp Footer (để đóng </body> và </html>)
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>