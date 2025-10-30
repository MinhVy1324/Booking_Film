<?php
// File: USER/movie-details.php

// 1. Nạp Header (Menu, Session)
// Chúng ta ở trong thư mục USER, nên cần dùng ../ để lùi ra
include '../templates/header.php'; 

// 2. Nạp file kết nối CSDL
include '../backend/CONFIG?Database.php'; 

// 3. Lấy ID phim từ URL
// (Ví dụ: movie-details.php?id=1)
if (!isset($_GET['id'])) {
    echo "<main class='container'><p>Không tìm thấy phim. Vui lòng quay lại.</p></main>";
    include '../templates/footer.php';
    exit(); // Dừng script
}

$phim_id = (int)$_GET['id']; // Ép kiểu về số nguyên để bảo mật

// 4. Truy vấn CSDL để lấy thông tin chi tiết phim
$sql_phim = "SELECT * FROM Phim WHERE Id = ?";
$stmt_phim = $conn->prepare($sql_phim);
$stmt_phim->bind_param("i", $phim_id);
$stmt_phim->execute();
$result_phim = $stmt_phim->get_result();

if ($result_phim->num_rows == 0) {
    echo "<main class='container'><p>Phim không tồn tại.</p></main>";
    include '../templates/footer.php';
    exit();
}

// Lấy 1 hàng dữ liệu phim
$phim = $result_phim->fetch_assoc();
?>

<title><?php echo htmlspecialchars($phim['TenPhim']); ?> - Chi Tiết</title>

<style>
    /* ... (CSS của .main-header, .main-footer đã có trong header.php) ... */

    /* 1. Phần Thông Tin Phim */
    .movie-hero {
        padding: 40px 0;
    }
    .movie-hero-container {
        display: flex;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        width: 90%;
    }
    .movie-poster {
        flex-basis: 300px;
        flex-shrink: 0;
    }
    .movie-poster img {
        width: 100%;
        border-radius: 8px;
    }
    .movie-details {
        flex-grow: 1;
    }
    .movie-details h1 {
        font-size: 2.5rem;
        color: #ffffff;
        margin-bottom: 10px;
    }
    .movie-details .tag {
        background-color: #e50914;
        color: white;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 0.9rem;
        font-weight: bold;
    }
    .movie-specs {
        margin: 15px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: #aaa;
    }
    .movie-description {
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    /* 2. Phần Đặt Vé (Booking Widget) */
    .booking-section {
        background-color: #1a1a1a;
        padding: 30px;
        border-radius: 8px;
        margin-top: 40px;
        max-width: 1200px;
        margin: 40px auto 0 auto;
        width: 90%;
    }
    .booking-section h2 {
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 20px;
        color: #e50914;
    }
    
    /* Danh sách rạp / suất chiếu */
    .cinema-item {
        background-color: #222;
        margin-bottom: 15px;
        border-radius: 5px;
        padding: 20px;
    }
    .cinema-item h3 {
        font-size: 1.3rem;
        color: #fff;
        margin-bottom: 5px;
    }
    .cinema-item p {
        font-size: 0.9rem;
        color: #aaa;
        margin-bottom: 15px;
    }
    .date-group {
        margin-bottom: 10px;
    }
    .date-group h4 {
        color: #61d9a4; /* Màu xanh lá */
        border-bottom: 1px solid #444;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    .showtime-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .showtime-btn {
        background-color: #444;
        color: #fff;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.2s;
    }
    .showtime-btn:hover {
        background-color: #e50914;
        transform: scale(1.05);
    }
</style>

<main>
    <section class="movie-hero">
        <div class="container movie-hero-container">
            <div class="movie-poster">
                <img src="<?php echo htmlspecialchars($phim['PosterUrl']); ?>" alt="Poster Phim">
            </div>
            
            <div class="movie-details">
                <h1><?php echo htmlspecialchars($phim['TenPhim']); ?></h1>
                <span class="tag"><?php echo htmlspecialchars($phim['XepHang']); ?></span>
                
                <div class="movie-specs">
                    <span>Thể loại: <strong><?php echo htmlspecialchars($phim['TheLoai']); ?></strong></span>
                    <span>Thời lượng: <strong><?php echo $phim['ThoiLuong']; ?> phút</strong></span>
                    <span>Khởi chiếu: <strong><?php echo date('d/m/Y', strtotime($phim['NgayKhoiChieu'])); ?></strong></span>
                </div>

                <p class="movie-description">
                    <?php echo htmlspecialchars($phim['MoTa']); ?>
                </p>
                
                </div>
        </div>
    </section>

    <section class="booking-section container">
        <h2>Mua Vé Theo Suất Chiếu</h2>

        <div id="showtime-lists">
            <?php
            // 5. Truy vấn CSDL để lấy Suất Chiếu
            // (Chỉ lấy suất chiếu từ hôm nay trở đi)
            $sql_suatchieu = "SELECT sc.Id, sc.NgayChieu, sc.GioBatDau, sc.GiaVe,
                                    r.TenRap, r.DiaChi, p.TenPhong
                             FROM SuatChieu sc
                             JOIN PhongChieu p ON sc.IdPhongChieu = p.Id
                             JOIN Rap r ON p.IdRap = r.Id
                             WHERE sc.IdPhim = ? AND sc.NgayChieu >= CURDATE()
                             ORDER BY r.TenRap, sc.NgayChieu, sc.GioBatDau";
            
            $stmt_suatchieu = $conn->prepare($sql_suatchieu);
            $stmt_suatchieu->bind_param("i", $phim_id);
            $stmt_suatchieu->execute();
            $result_suatchieu = $stmt_suatchieu->get_result();

            if ($result_suatchieu->num_rows > 0) {
                
                // 6. Logic lặp và nhóm
                $currentRap = "";
                $currentNgay = "";

                while($sc = $result_suatchieu->fetch_assoc()) {
                    
                    // 6.1. Nếu là một Rạp mới, in ra tên Rạp
                    if ($sc['TenRap'] != $currentRap) {
                        if ($currentRap != "") {
                            // Đóng thẻ của Rạp trước đó (nếu không phải lần đầu)
                            echo '</div></div></div>'; 
                        }
                        $currentRap = $sc['TenRap'];
                        echo '<div class="cinema-item">';
                        echo '<h3>' . htmlspecialchars($currentRap) . '</h3>';
                        echo '<p>' . htmlspecialchars($sc['DiaChi']) . '</p>';
                        
                        // Reset ngày khi đổi rạp
                        $currentNgay = ""; 
                    }

                    // 6.2. Nếu là một Ngày mới (trong cùng 1 Rạp), in ra Ngày
                    if ($sc['NgayChieu'] != $currentNgay) {
                        if ($currentNgay != "") {
                            // Đóng thẻ của Ngày trước đó
                            echo '</div></div>';
                        }
                        $currentNgay = $sc['NgayChieu'];
                        echo '<div class="date-group">';
                        // Định dạng lại ngày cho đẹp
                        echo '<h4>Ngày: ' . date('d/m/Y', strtotime($currentNgay)) . '</h4>';
                        echo '<div class="showtime-grid">';
                    }

                    // 6.3. In ra giờ chiếu
                    // Link sẽ dẫn đến trang chọn ghế, mang theo ID Suất Chiếu
                    echo '<a href="seat-selection.php?suatchieu_id=' . $sc['Id'] . '" class="showtime-btn">';
                    // Định dạng lại giờ cho đẹp (bỏ :00 giây)
                    echo date('H:i', strtotime($sc['GioBatDau']));
                    echo '</a>';
                }
                
                // Đóng các thẻ div cuối cùng
                echo '</div></div></div>';

            } else {
                echo "<p style='text-align: center;'>Phim này hiện chưa có suất chiếu.</p>";
            }

            $stmt_phim->close();
            $stmt_suatchieu->close();
            $conn->close();
            ?>
        </div>
    </section>
</main> <?php
// 7. Nạp Footer (để đóng </body> và </html>)
include '../templates/footer.php'; 
?>