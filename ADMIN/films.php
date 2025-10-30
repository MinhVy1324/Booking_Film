<?php
// File: ADMIN/films.php
// 1. Nạp header (đã chứa session_start, connect.php, và kiểm tra admin)
include '../TEMPLATES/admin_header.php'; 
?>

<title>Admin - Quản Lý Phim</title>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Phim</h1>
        <button class="add-new-btn" id="addNewBtn">Thêm Phim Mới</button>
    </header>
    
    <?php
    // 3. Hiển thị thông báo (nếu có từ URL)
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_success') {
            echo '<p class="status-message success">Thêm phim mới thành công!</p>';
        }
        if ($_GET['status'] == 'delete_success') {
            echo '<p class="status-message success">Xóa phim thành công!</p>';
        }
        if ($_GET['status'] == 'error') {
            echo '<p class="status-message error">Có lỗi xảy ra, vui lòng thử lại!</p>';
        }
    }
    ?>

    <table class="content-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Phim</th>
                <th>Thời Lượng</th>
                <th>Xếp Hạng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Truy vấn CSDL
            $sql = "SELECT Id, TenPhim, ThoiLuong, XepHang FROM Phim ORDER BY NgayKhoiChieu DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhim']); ?></td>
                    <td><?php echo $row['ThoiLuong']; ?> phút</td>
                    <td><?php echo htmlspecialchars($row['XepHang']); ?></td>
                    <td>
                        <a href="#" class="action-btn">Sửa</a>
                        
                        <form action="../BACKEND/CONTROLLER/FilmController.php" method="POST" class="delete-form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="phim_id" value="<?php echo $row['Id']; ?>">
                            <button type="submit" class="action-btn delete" 
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?');">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>Chưa có phim nào trong cơ sở dữ liệu.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</main> <div id="movieModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeBtn">&times;</span>
        <h2>Thêm Phim Mới</h2>
        
        <form id="movieForm" action="../BACKEND/CONTROLLER/FilmController.php" method="POST">
            <input type="hidden" name="action" value="add">
            
            <div class="form-group">
                <label for="tenPhim">Tên Phim</label>
                <input type="text" id="tenPhim" name="tenPhim" required>
            </div>
            
            <div class="form-group">
                <label for="moTa">Mô Tả</label>
                <textarea id="moTa" name="moTa"></textarea>
            </div>

            <div class="form-group">
                <label for="ngayKhoiChieu">Ngày Khởi Chiếu</label>
                <input type="date" id="ngayKhoiChieu" name="ngayKhoiChieu" required>
            </div>
            
            <div class="form-group">
                <label for="thoiLuong">Thời Lượng (phút)</label>
                <input type="number" id="thoiLuong" name="thoiLuong" required>
            </div>
            
            <div class="form-group">
                <label for="posterUrl">Link Poster (URL)</label>
                <input type="text" id="posterUrl" name="posterUrl">
            </div>

            <div class="form-group">
                <label for="theLoai">Thể Loại</label>
                <input type="text" id="theLoai" name="theLoai">
            </div>
            
            <div class="form-group">
                <label for="xepHang">Xếp Hạng (Giới hạn tuổi)</label>
                <select id="xepHang" name="xepHang">
                    <option value="P">P - Mọi lứa tuổi</option>
                    <option value="C13">C13 - Trên 13 tuổi</option>
                    <option value="C16">C16 - Trên 16 tuổi</option>
                    <option value="C18">C18 - Trên 18 tuổi</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="add-new-btn">Lưu Lại</button>
            </div>
        </form>
    </div>
</div>

<?php
// 6. Nạp footer
include '../TEMPLATES/admin_footer.php'; 
?>