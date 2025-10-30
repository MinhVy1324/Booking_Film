<?php
// File: ADMIN/showtimes.php
include '../TEMPLATES/admin_header.php'; // Nạp header
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
            </tr>
        </thead>
        <tbody>
            <?php
            // Truy vấn JOIN nhiều bảng để lấy thông tin
            $sql = "SELECT sc.Id, p.TenPhim, r.TenRap, pc.TenPhong, sc.NgayChieu, sc.GioBatDau, sc.GiaVe 
                    FROM SuatChieu sc
                    JOIN Phim p ON sc.IdPhim = p.Id
                    JOIN PhongChieu pc ON sc.IdPhongChieu = pc.Id
                    JOIN Rap r ON pc.IdRap = r.Id
                    ORDER BY sc.NgayChieu DESC, sc.GioBatDau DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhim']); ?></td>
                    <td><?php echo htmlspecialchars($row['TenRap']); ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhong']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['NgayChieu'])); ?></td>
                    <td><?php echo date('H:i', strtotime($row['GioBatDau'])); ?></td>
                    <td><?php echo number_format($row['GiaVe'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>Chưa có suất chiếu nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<div id="showtimeModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeBtn">&times;</span>
        <h2>Tạo Suất Chiếu Mới</h2>
        
        <form action="../backend/CONTROLLER/ShowtimeController.php" method="POST">
            <input type="hidden" name="action" value="add_showtime">
            
            <div class="form-group">
                <label for="phim">Chọn Phim</label>
                <select id="phim" name="phim_id" required>
                    <option value="">-- Vui lòng chọn phim --</option>
                    <?php
                    // Lấy danh sách phim
                    $result_phim = $conn->query("SELECT Id, TenPhim FROM Phim ORDER BY TenPhim");
                    while ($phim = $result_phim->fetch_assoc()) {
                        echo '<option value="' . $phim['Id'] . '">' . htmlspecialchars($phim['TenPhim']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="phong">Chọn Rạp & Phòng Chiếu</label>
                <select id="phong" name="phong_id" required>
                    <option value="">-- Vui lòng chọn phòng --</option>
                    <?php
                    // Lấy danh sách phòng (kèm tên rạp)
                    $sql_phong = "SELECT pc.Id, pc.TenPhong, r.TenRap 
                                  FROM PhongChieu pc 
                                  JOIN Rap r ON pc.IdRap = r.Id 
                                  ORDER BY r.TenRap, pc.TenPhong";
                    $result_phong = $conn->query($sql_phong);
                    while ($phong = $result_phong->fetch_assoc()) {
                        echo '<option value="' . $phong['Id'] . '">';
                        echo htmlspecialchars($phong['TenRap']) . ' - ' . htmlspecialchars($phong['TenPhong']);
                        echo '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label for="ngayChieu">Ngày Chiếu</label>
                    <input type="date" id="ngayChieu" name="ngayChieu" required>
                </div>
                <div style="flex: 1;">
                    <label for="gioBatDau">Giờ Bắt Đầu</label>
                    <input type="time" id="gioBatDau" name="gioBatDau" required>
                </div>
            </div>

            <div class="form-group">
                <label for="giaVe">Giá Vé (VNĐ)</label>
                <input type="number" id="giaVe" name="giaVe" placeholder="Ví dụ: 100000" required>
            </div>
            
            <button type="submit" class="add-new-btn">Tạo Suất Chiếu</button>
        </form>
    </div>
</div>

<?php
// Nạp footer (có sẵn JS cho modal)
include '../TEMPLATES/admin_footer.php'; 
?>