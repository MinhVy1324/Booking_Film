<?php
// File: index.php (Thư mục gốc)

// 1. Nạp Header (Menu, Session)
include 'templates/header.php'; 

// 2. Nạp file kết nối CSDL
// Chúng ta cần file này để truy vấn danh sách phim
include 'backend/connect.php'; 
?>

<title>Trang Chủ - Đặt Vé Xem Phim</title>

<style>
    /* Thiết lập chung */
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* 2. Hero Banner (Phim nổi bật) */
    .hero-banner {
        height: 500px;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1500x500.png?text=Phim+Bom+Tan') center center/cover;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }
    .hero-banner h1 { font-size: 3rem; margin-bottom: 10px; }
    .hero-banner p { font-size: 1.2rem; margin-bottom: 20px; }
    .hero-banner .btn-primary {
        background-color: #e50914;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        font-size: 1.1rem;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .hero-banner .btn-primary:hover { background-color: #c40812; }

    /* 3. Phần Danh Sách Phim */
    .movie-section {
        padding: 40px 0;
    }

    .movie-tabs {
        margin-bottom: 30px;
        border-bottom: 1px solid #333;
    }

    .tab-btn {
        background-color: transparent;
        border: none;
        color: #888;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 15px 20px;
        cursor: pointer;
        transition: color 0.3s, border-bottom 0.3s;
        border-bottom: 3px solid transparent;
    }

    .tab-btn.active {
        color: #ffffff;
        border-bottom-color: #e50914;
    }

    .movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 30px;
    }
    
    .movie-grid.hidden {
        display: none;
    }

    .movie-card {
        background-color: #1a1a1a;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .movie-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
    }

    .movie-card img.poster {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .movie-card .movie-info {
        padding: 15px;
    }

    .movie-card h3 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 44px; /* Giữ 2 dòng */
    }

    .movie-card p {
        font-size: 0.9rem;
        color: #aaa;
        margin-bottom: 15px;
    }

    .movie-card .btn-buy {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #e50914;
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    .movie-card .btn-buy:hover { background-color: #c40812; }
    
    /* (CSS Header & Footer đã có trong header.php và footer.php 
       hoặc file CSS chung của bạn) */
</style>


<section class="hero-banner">
    <h1>LẬT MẶT 7: MỘT ĐIỀU ƯỚC</h1>
    <p>Phim mới nhất, đang hot tại rạp.</p>
    <a href="/USER/movie-details.php" class="btn-primary">Đặt Vé Ngay</a>
</section>

<main class="movie-section container">
    <div class="movie-tabs">
        <button class="tab-btn active" data-target="#grid-dang-chieu">Đang Chiếu</button>
        <button class="tab-btn" data-target="#grid-sap-chieu">Sắp Chiếu</button>
    </div>

    <div class="movie-grid" id="grid-dang-chieu">
        
        <?php
        // 3.1. Code PHP để lấy phim Đang Chiếu
        // CURDATE() là hàm của MySQL lấy ngày hiện tại
        $sql_dang_chieu = "SELECT * FROM Phim WHERE NgayKhoiChieu <= CURDATE()";
        $result = $conn->query($sql_dang_chieu);

        if ($result->num_rows > 0) {
            // 3.2. Vòng lặp (Loop) để "vẽ" các thẻ phim
            while($phim = $result->fetch_assoc()) {
                // Dữ liệu tĩnh đã bị XÓA và thay bằng dữ liệu động
                echo '<div class="movie-card">';
                // Sử dụng htmlspecialchars để bảo mật, tránh lỗi XSS
                echo '    <img class="poster" src="' . htmlspecialchars($phim['PosterUrl']) . '" alt="Poster Phim">';
                echo '    <div class="movie-info">';
                echo '        <h3>' . htmlspecialchars($phim['TenPhim']) . '</h3>';
                echo '        <p>' . htmlspecialchars($phim['TheLoai']) . ' | ' . $phim['ThoiLuong'] . ' phút</p>';
                // Link sẽ dẫn đến trang chi tiết với ID của phim
                echo '        <a href="USER/movie-details.php?id=' . $phim['Id'] . '" class="btn-buy">MUA VÉ</a>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo "<p>Chưa có phim đang chiếu.</p>";
        }
        ?>

    </div>
    
    <div class="movie-grid hidden" id="grid-sap-chieu">
        <?php
        // 3.3. Code PHP để lấy phim Sắp Chiếu
        $sql_sap_chieu = "SELECT * FROM Phim WHERE NgayKhoiChieu > CURDATE()";
        $result_sap_chieu = $conn->query($sql_sap_chieu);

        if ($result_sap_chieu->num_rows > 0) {
            // 3.4. Vòng lặp (Loop)
            while($phim = $result_sap_chieu->fetch_assoc()) {
                echo '<div class="movie-card">';
                echo '    <img class="poster" src="' . htmlspecialchars($phim['PosterUrl']) . '" alt="Poster Phim">';
                echo '    <div class="movie-info">';
                echo '        <h3>' . htmlspecialchars($phim['TenPhim']) . '</h3>';
                echo '        <p>' . htmlspecialchars($phim['TheLoai']) . ' | ' . $phim['ThoiLuong'] . ' phút</p>';
                echo '        <a href="#" class="btn-buy" style="background-color: #555; cursor: not-allowed;">CHƯA MỞ BÁN</a>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo "<p>Chưa có phim sắp chiếu.</p>";
        }
        ?>
    </div>
</main>

<script>
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
// 4. Nạp Footer (để đóng </body> và </html>)
include 'templates/footer.php'; 
?>