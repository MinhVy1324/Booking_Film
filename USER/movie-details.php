<?php
// File: USER/movie-details.php

// 1. NẠP HEADER VÀ CÁC LỚP DAO
include_once __DIR__ . '/../TEMPLATES/header.php'; 
include_once __DIR__ . '/../BACKEND/DAO/PhimDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/SuatChieuDAO.php';

// 2. LẤY ID PHIM VÀ THÔNG TIN PHIM
if (!isset($_GET['id'])) {
    echo "<main class='container'><p>Không tìm thấy phim.</p></main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}
$phim_id = (int)$_GET['id'];
$phim = (new PhimDAO())->getPhimById($phim_id);

if ($phim == null) {
    echo "<main class='container'><p>Phim không tồn tại.</p></main>";
    include __DIR__ . '/../TEMPLATES/footer.php';
    exit();
}

// 3. LẤY DỮ LIỆU SUẤT CHIẾU TỪ DAO
$list_suatchieu = (new SuatChieuDAO())->getSuatChieuByPhimId($phim_id);

// 4. ✅ BƯỚC QUAN TRỌNG: NHÓM DỮ LIỆU (PRE-PROCESSING)
// Nhóm toàn bộ suất chiếu vào một mảng có cấu trúc:
// [Tên Rạp] => [
//     'DiaChi' => '...'
//     'Dates'  => [
//         '2025-11-10' => [ [Id: 1, Gio: '09:30'], [Id: 2, Gio: '12:00'] ],
//         '2025-11-11' => [ [Id: 3, Gio: '09:30'] ]
//     ]
// ]
$showtimes_by_rap = [];
foreach ($list_suatchieu as $sc) {
    $rap = $sc['TenRap'];
    $diaChi = $sc['DiaChi'];
    $ngay = $sc['NgayChieu'];
    $gio = ['Id' => $sc['Id'], 'Gio' => $sc['GioBatDau']];
    
    if (!isset($showtimes_by_rap[$rap])) {
        // Nếu chưa có rạp này trong mảng, tạo mới
        $showtimes_by_rap[$rap] = ['DiaChi' => $diaChi, 'Dates' => []];
    }
    if (!isset($showtimes_by_rap[$rap]['Dates'][$ngay])) {
        // Nếu chưa có ngày này trong rạp, tạo mới
        $showtimes_by_rap[$rap]['Dates'][$ngay] = [];
    }
    // Thêm giờ chiếu vào đúng ngày/rạp
    $showtimes_by_rap[$rap]['Dates'][$ngay][] = $gio;
}
?>

<title><?php echo htmlspecialchars($phim->getTenPhim()); ?> - Chi Tiết</title>

<style>
    /* ... (CSS cũ của bạn cho .movie-hero, .movie-poster, .movie-details) ... */
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
    
    /* Danh sách rạp */
    .cinema-item {
        background-color: #222; margin-bottom: 15px;
        border-radius: 5px; padding: 20px;
    }
    .cinema-item h3 { font-size: 1.3rem; color: #fff; margin-bottom: 5px; }
    .cinema-item p { font-size: 0.9rem; color: #aaa; margin-bottom: 20px; }

    /* ✅ CSS MỚI CHO CÁC TAB NGÀY */
    .date-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        border-bottom: 1px solid #444;
        margin-bottom: 20px;
    }
    .date-tab-btn {
        background-color: #333;
        color: #aaa;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: bold;
        border-radius: 5px 5px 0 0;
        transition: background-color 0.3s, color 0.3s;
    }
    .date-tab-btn:hover {
        background-color: #444;
        color: #fff;
    }
    .date-tab-btn.active {
        background-color: #e50914; /* Màu đỏ khi được chọn */
        color: #fff;
    }

    /* ✅ CSS MỚI CHO CÁC LƯỚI SUẤT CHIẾU */
    .showtime-grid {
        display: flex; /* Sửa từ 'flex' sang 'none' nếu 'hidden' */
        flex-wrap: wrap;
        gap: 15px;
    }
    .showtime-grid.hidden {
        display: none; /* Mặc định ẩn đi */
    }
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
                <img src="../<?php echo htmlspecialchars($phim->getPosterUrl()); ?>" alt="Poster Phim">
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
                    <?php echo nl2br(htmlspecialchars($phim->getMoTa())); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="booking-section container">
        <h2>Mua Vé Theo Suất Chiếu</h2>

        <div id="showtime-lists">
            <?php
            // 7. KIỂM TRA VÀ LẶP QUA CÁC RẠP
            if (count($showtimes_by_rap) > 0) {
                
                $rap_index = 0; // Dùng để tạo ID duy nhất

                foreach ($showtimes_by_rap as $tenRap => $data) {
                    $rap_index++;
            ?>
                    <div class="cinema-item">
                        <h3><?php echo htmlspecialchars($tenRap); ?></h3>
                        <p><?php echo htmlspecialchars($data['DiaChi']); ?></p>

                        <div class="date-tabs">
                            <?php
                            $date_index = 0;
                            foreach ($data['Dates'] as $ngay => $suat_chieu_list) {
                                $date_index++;
                                // Đánh dấu 'active' cho tab ngày đầu tiên
                                $active_class = ($date_index == 1) ? 'active' : '';
                                // ID của lưới giờ (ví dụ: rap-1-ngay-1)
                                $target_id = 'rap-' . $rap_index . '-ngay-' . $date_index; 
                                
                                echo '<button class="date-tab-btn ' . $active_class . '" data-target="#' . $target_id . '">';
                                echo date('d/m/Y', strtotime($ngay));
                                echo '</button>';
                            }
                            ?>
                        </div>

                        <div class="showtime-grids-container">
                             <?php
                            $date_index = 0;
                            foreach ($data['Dates'] as $ngay => $suat_chieu_list) {
                                $date_index++;
                                // Đánh dấu 'active' (không ẩn) cho lưới giờ đầu tiên
                                $hidden_class = ($date_index == 1) ? '' : 'hidden';
                                // ID của lưới giờ (phải khớp với data-target ở trên)
                                $grid_id = 'rap-' . $rap_index . '-ngay-' . $date_index;
                                
                                echo '<div class="showtime-grid ' . $hidden_class . '" id="' . $grid_id . '">';
                                
                                // 7.3. Vẽ các nút giờ
                                foreach ($suat_chieu_list as $gio) {
                                    echo '<a href="seat-selection.php?suatchieu_id=' . $gio['Id'] . '" class="showtime-btn">';
                                    echo date('H:i', strtotime($gio['Gio']));
                                    echo '</a>';
                                }
                                echo '</div>'; // Đóng .showtime-grid
                            }
                            ?>
                        </div>
                    </div> <?php
                } // Kết thúc vòng lặp Rạp

            } else {
                // Nếu không có suất chiếu nào
                echo "<p style='text-align: center;'>Phim này hiện chưa có suất chiếu.</p>";
            }
            ?>
        </div>
    </section>
</main> <script>
    // Gắn sự kiện cho TẤT CẢ các nút tab ngày
    document.querySelectorAll('.date-tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            // Lấy ra container .cinema-item (rạp) cha gần nhất
            const cinemaItem = button.closest('.cinema-item');
            
            // 1. Tắt active ở tất cả các tab CÙNG RẠP
            cinemaItem.querySelectorAll('.date-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // 2. Bật active cho tab vừa nhấn
            button.classList.add('active');
            
            // 3. Ẩn tất cả các lưới giờ (showtime-grid) CÙNG RẠP
            cinemaItem.querySelectorAll('.showtime-grid').forEach(grid => {
                grid.classList.add('hidden');
            });
            
            // 4. Lấy ID của lưới giờ mục tiêu (ví dụ: '#rap-1-ngay-1')
            const targetId = button.getAttribute('data-target');
            
            // 5. Hiển thị lưới giờ mục tiêu
            cinemaItem.querySelector(targetId).classList.remove('hidden');
        });
    });
</script>

<?php
// 9. Nạp Footer
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>