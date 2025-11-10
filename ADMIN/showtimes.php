<?php
// File: ADMIN/showtimes.php
include_once dirname(__DIR__) . '/TEMPLATES/admin_header.php'; // Nạp header
include_once dirname(__DIR__) . '/BACKEND/DAO/SuatChieuDAO.php';
include_once dirname(__DIR__) . '/BACKEND/DAO/PhimDAO.php';
include_once dirname(__DIR__) . '/BACKEND/DAO/PhongChieuDAO.php';

// Tạo DAO
$scDAO = new SuatChieuDAO();
$listSC = $scDAO->getAllSuatChieuDetails();

// Lấy dữ liệu cho các dropdown (dùng cho cả 2 modal)
$listPhim = (new PhimDAO())->getAllPhim();
$listPhong = (new PhongChieuDAO())->getAllPhongWithRap();
?>

<title>Admin - Quản Lý Suất Chiếu</title>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Suất Chiếu</h1>
        <button class="add-new-btn" id="addNewBtn">Tạo Suất Chiếu Mới</button>
    </header>

    <?php
    // Hiển thị thông báo (nếu có)
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_success') echo '<p class="status-message success">Tạo suất chiếu thành công!</p>';
        if ($_GET['status'] == 'edit_success') echo '<p class="status-message success">Cập nhật suất chiếu thành công!</p>'; // THÊM MỚI
        if ($_GET['status'] == 'error') echo '<p class="status-message error">Có lỗi xảy ra!</p>';
    }
    ?>

    <table class="content-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Phim</th>
                <th>Rạp</th>
                <th>Phòng</th>
                <th>Ngày Chiếu</th>
                <th>Giờ Bắt Đầu</th>
                <th>Giá Vé</th>
                <th>Hành Động</th> </tr>
        </thead>
        <tbody>
            <?php
            if (count($listSC) > 0) {
                foreach($listSC as $row) {
            ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhim']); ?></td>
                    <td><?php echo htmlspecialchars($row['TenRap']); ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhong']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['NgayChieu'])); ?></td>
                    <td><?php echo date('H:i', strtotime($row['GioBatDau'])); ?></td>
                    <td><?php echo number_format($row['GiaVe'], 0, ',', '.'); ?> VNĐ</td>
                    
                    <td>
                        <a href="#" class="action-btn edit-btn"
                           data-id="<?php echo $row['Id']; ?>"
                           data-phim-id="<?php echo $row['IdPhim']; ?>"
                           data-phong-id="<?php echo $row['IdPhongChieu']; ?>"
                           data-ngay="<?php echo $row['NgayChieu']; ?>"
                           data-gio="<?php echo $row['GioBatDau']; ?>"
                           data-gia="<?php echo $row['GiaVe']; ?>">
                           Sửa
                        </a>
                        </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>Chưa có suất chiếu nào.</td></tr>"; // Tăng colspan
            }
            ?>
        </tbody>
    </table>
</main>

<div id="showtimeModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Tạo Suất Chiếu Hàng Loạt</h2>
        
        <form action="../BACKEND/CONTROLLER/ShowtimeController.php" method="POST">
            <input type="hidden" name="action" value="add_bulk_showtime"> 
            
            <div class="form-group">
                <label for="phim">Chọn Phim</label>
                <select id="phim" name="phim_id" required>
                    <option value="">-- Vui lòng chọn phim --</option>
                    <?php
                    // Lấy danh sách phim từ DAO (Code này đã có)
                    foreach ($listPhim as $phim) {
                        echo '<option value="' . $phim->getId() . '">' . htmlspecialchars($phim->getTenPhim()) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="phong">Chọn Rạp & Phòng Chiếu</label>
                <select id="phong" name="phong_id" required>
                    <option value="">-- Vui lòng chọn phòng --</option>
                    <?php
                    // Lấy danh sách phòng (Code này đã có)
                    foreach ($listPhong as $phong) {
                        echo '<option value="' . $phong['Id'] . '">';
                        echo htmlspecialchars($phong['TenRap']) . ' - ' . htmlspecialchars($phong['TenPhong']);
                        echo '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label for="ngayBatDau">Từ Ngày</label>
                    <input type="date" id="ngayBatDau" name="ngayBatDau" required>
                </div>
                <div style="flex: 1;">
                    <label for="ngayKetThuc">Đến Ngày</label>
                    <input type="date" id="ngayKetThuc" name="ngayKetThuc" required>
                </div>
            </div>

            <div class="form-group">
                <label for="cacGioChieu">Các Khung Giờ Chiếu (cách nhau bằng dấu phẩy)</label>
                <input type="text" id="cacGioChieu" name="cacGioChieu" placeholder="Ví dụ: 09:30, 13:00, 19:00, 21:30" required>
            </div>

            <div class="form-group">
                <label for="giaVe">Giá Vé (VNĐ)</label>
                <input type="number" id="giaVe" name="giaVe" placeholder="Ví dụ: 100000" required>
            </div>
            
            <button type="submit" class="add-new-btn">Tạo Suất Chiếu Hàng Loạt</button>
        </form>
    </div>
</div>

<div id="editShowtimeModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Chỉnh Sửa Suất Chiếu</h2>
        
        <form action="../BACKEND/CONTROLLER/ShowtimeController.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="suatchieu_id" id="edit_suatchieu_id">
            
            <div class="form-group">
                <label for="edit_phim">Chọn Phim</label>
                <select id="edit_phim" name="phim_id" required>
                    <option value="">-- Vui lòng chọn phim --</option>
                    <?php
                    // Lặp lại danh sách phim
                    foreach ($listPhim as $phim) {
                        echo '<option value="' . $phim->getId() . '">' . htmlspecialchars($phim->getTenPhim()) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="edit_phong">Chọn Rạp & Phòng Chiếu</label>
                <select id="edit_phong" name="phong_id" required>
                    <option value="">-- Vui lòng chọn phòng --</option>
                    <?php
                    // Lặp lại danh sách phòng
                    foreach ($listPhong as $phong) {
                        echo '<option value="' . $phong['Id'] . '">';
                        echo htmlspecialchars($phong['TenRap']) . ' - ' . htmlspecialchars($phong['TenPhong']);
                        echo '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label for="edit_ngayChieu">Ngày Chiếu</label>
                    <input type="date" id="edit_ngayChieu" name="ngayChieu" required>
                </div>
                <div style="flex: 1;">
                    <label for="edit_gioBatDau">Giờ Bắt Đầu</label>
                    <input type="time" id="edit_gioBatDau" name="gioBatDau" required>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_giaVe">Giá Vé (VNĐ)</label>
                <input type="number" id="edit_giaVe" name="giaVe" required>
            </div>
            
            <button type="submit" class="add-new-btn">Lưu Thay Đổi</button>
        </form>
    </div>
</div>

<?php
// Nạp footer (sẽ chứa JS)
include dirname(__DIR__) . '/TEMPLATES/admin_footer.php'; 
?>