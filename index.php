<?php
// File: index.php

// 1. NẠP HEADER VÀ DAO
include 'TEMPLATES/header.php'; 
include_once __DIR__ . '/BACKEND/DAO/PhimDAO.php'; 

// 2. TẠO ĐỐI TƯỢNG DAO
$phimDAO = new PhimDAO();

// 3. LẤY DỮ LIỆU
// (Lấy 4 phim cho Banner)
$list_phim_banner = $phimDAO->getPhimChoBanner();
// (Lấy phim cho 2 tab Đang chiếu / Sắp chiếu)
$list_dang_chieu = (new PhimDAO())->getPhimDangChieu();
$list_sap_chieu = (new PhimDAO())->getPhimSapChieu(); 
?>

<title>Trang Chủ - Đặt Vé Xem Phim</title>

<style>
    .carousel-container {
        width: 100%;
        height: 500px; /* Chiều cao của banner */
        position: relative;
        overflow: hidden;
    }

    .carousel-slides {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        position: relative;
        background-size: cover;
        background-position: center;
    }
    
    /* Lớp phủ mờ */
    .slide::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6));
    }

    .slide-content {
        position: absolute;
        z-index: 2;
        color: white;
        
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 90%;
        max-width: 800px;
        text-align: center;
    }
    
    .slide-content h1 {
        font-size: 3rem;
        margin-bottom: 10px;
    }
    
    .slide-content p {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    
    .slide-content .btn-primary {
        background-color: #e50914;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        font-size: 1.1rem;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .slide-content .btn-primary:hover { background-color: #c40812; }

    /* Nút Next & Prev */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 24px;
        transition: 0.3s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        z-index: 3;
    }
    .next { right: 0; border-radius: 3px 0 0 3px; }
    .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
    }
    
    /* Dấu chấm (Dots) */
    .dots-container {
        text-align: center;
        padding: 10px;
        position: absolute;
        bottom: 10px;
        width: 100%;
        z-index: 3;
    }
    .dot {
        cursor: pointer;
        height: 12px;
        width: 12px;
        margin: 0 5px;
        background-color: #555;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s ease;
    }
    .dot.active, .dot:hover {
        background-color: #e50914;
    }

    .movie-section { padding: 40px 0; }
    .movie-tabs { margin-bottom: 30px; border-bottom: 1px solid #333; }
    .tab-btn {
        background-color: transparent; border: none; color: #888;
        font-size: 1.5rem; font-weight: bold; padding: 15px 20px;
        cursor: pointer; transition: color 0.3s, border-bottom 0.3s;
        border-bottom: 3px solid transparent;
    }
    .tab-btn.active { color: #ffffff; border-bottom-color: #e50914; }
    .movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 30px;
    }
    .movie-grid.hidden { display: none; }
    .movie-card {
        background-color: #1a1a1a; border-radius: 8px;
        overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .movie-card:hover { transform: translateY(-10px); }
    .movie-card img.poster { width: 100%; height: 300px; object-fit: cover; }
    .movie-card .movie-info { padding: 15px; }
    .movie-card h3 {
        font-size: 1.1rem; margin-bottom: 10px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
        height: 44px; /* Giữ 2 dòng */
    }
    .movie-card p { font-size: 0.9rem; color: #aaa; margin-bottom: 15px; }
    .movie-card .btn-buy {
        display: block; width: 100%; padding: 10px;
        background-color: #e50914; color: #ffffff;
        text-align: center; text-decoration: none;
        border-radius: 5px; font-weight: bold;
        transition: background-color 0.3s;
    }
    .movie-card .btn-buy:hover { background-color: #c40812; }

    .movie-card-link {
        text-decoration: none;
        color: inherit; /* Kế thừa màu chữ (màu trắng) */
    }

    .movie-card .btn-buy {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #e50914;
        color: #ffffff;
        text-align: center;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }
</style>

<section class="carousel-container">
    <div class="carousel-slides">
        <?php foreach ($list_phim_banner as $phim): ?>
            <a href="USER/movie-details.php?id=<?php echo $phim->getId(); ?>" 
               class="slide" 
               style="background-image: url('<?php echo htmlspecialchars($phim->getPosterUrl()); ?>');">
                
                <div class="slide-content">
                    <h1><?php echo htmlspecialchars($phim->getTenPhim()); ?></h1>
                    <p><?php echo htmlspecialchars($phim->getTheLoai()); ?></p>
                    </div>
            </a>
        <?php endforeach; ?>
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="dots-container">
        <?php for ($i = 0; $i < count($list_phim_banner); $i++): ?>
            <span class="dot" onclick="currentSlide(<?php echo $i + 1; ?>)"></span>
        <?php endfor; ?>
    </div>
</section>


<main class="movie-section container">
    <div class="movie-tabs">
        <button class="tab-btn active" data-target="#grid-dang-chieu">Đang Chiếu</button>
        <button class="tab-btn" data-target="#grid-sap-chieu">Sắp Chiếu</button>
    </div>

    <div class="movie-grid" id="grid-dang-chieu">
        <?php
        if (count($list_dang_chieu) > 0) {
            foreach($list_dang_chieu as $phim) {
                // 1. Bọc toàn bộ thẻ card trong 1 thẻ <a>
                echo '<a href="USER/movie-details.php?id=' . $phim->getId() . '" class="movie-card-link">';
                echo '  <div class="movie-card">';
                echo '    <img class="poster" src="' . htmlspecialchars($phim->getPosterUrl()) . '" alt="Poster Phim">';
                echo '    <div class="movie-info">';
                echo '        <h3>' . htmlspecialchars($phim->getTenPhim()) . '</h3>';
                echo '        <p>' . htmlspecialchars($phim->getTheLoai()) . ' | ' . $phim->getThoiLuong() . ' phút</p>';
                // 2. Biến nút Mua Vé thành 1 thẻ <span> để giữ CSS
                echo '        <span class="btn-buy">MUA VÉ</span>';
                echo '    </div>';
                echo '  </div>';
                echo '</a>'; // 3. Đóng thẻ <a>
            }
        } else {
            echo "<p>Chưa có phim đang chiếu.</p>";
        }
        ?>
    </div>
    
    <div class="movie-grid hidden" id="grid-sap-chieu">
         <?php
        if (count($list_sap_chieu) > 0) {
            foreach($list_sap_chieu as $phim) {
                // 1. Bọc toàn bộ thẻ card trong 1 thẻ <a>
                echo '<a href="USER/movie-details.php?id=' . $phim->getId() . '" class="movie-card-link">';
                echo '  <div class="movie-card">';
                echo '    <img class="poster" src="' . htmlspecialchars($phim->getPosterUrl()) . '" alt="Poster Phim">';
                echo '    <div class="movie-info">';
                echo '        <h3>' . htmlspecialchars($phim->getTenPhim()) . '</h3>';
                echo '        <p>' . htmlspecialchars($phim->getTheLoai()) . ' | ' . $phim->getThoiLuong() . ' phút</p>';
                // 2. Biến nút thành <span> (và đổi chữ)
                echo '        <span class="btn-buy" style="background-color: #555;">XEM CHI TIẾT</span>';
                echo '    </div>';
                echo '  </div>';
                echo '</a>'; // 3. Đóng thẻ <a>
            }
        } else {
            echo "<p>Chưa có phim sắp chiếu.</p>";
        }
        ?>
    </div>
</main>

<script>
    let slideIndex = 0;
    let autoSlideTimer;
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    const slideContainer = document.querySelector(".carousel-slides");
    const totalSlides = slides.length;

    function showSlides() {
        if (totalSlides === 0) return; // Không chạy nếu không có slide

        // Ẩn tất cả slide
        slideContainer.style.transform = `translateX(-${slideIndex * 100}%)`;

        // Đặt active cho dot
        dots.forEach(dot => dot.classList.remove("active"));
        dots[slideIndex].classList.add("active");

        // Tự động trượt
        clearTimeout(autoSlideTimer);
        autoSlideTimer = setTimeout(() => {
            plusSlides(1); // Tự động chuyển slide tiếp theo
        }, 5000); // 5 giây
    }

    // Nút Next/Prev
    function plusSlides(n) {
        slideIndex += n;
        if (slideIndex >= totalSlides) {
            slideIndex = 0; // Quay về slide đầu
        }
        if (slideIndex < 0) {
            slideIndex = totalSlides - 1; // Về slide cuối
        }
        showSlides();
    }

    // Nút Dots
    function currentSlide(n) {
        slideIndex = n - 1;
        showSlides();
    }

    // Khởi chạy slide đầu tiên
    if (totalSlides > 0) {
        dots[0].classList.add("active");
        showSlides();
    }

    const tabButtons = document.querySelectorAll('.tab-btn');
    const movieGrids = document.querySelectorAll('.movie-grid');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const targetGridId = button.getAttribute('data-target');
            movieGrids.forEach(grid => grid.classList.add('hidden'));
            document.querySelector(targetGridId).classList.remove('hidden');
        });
    });
</script>

<?php
// Nạp Footer
include 'TEMPLATES/footer.php'; 
?>