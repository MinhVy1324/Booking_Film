<?php
// File: ADMIN/edit_room.php
include_once dirname(__DIR__) . '/TEMPLATES/admin_header.php'; // Nạp header
include_once dirname(__DIR__) . '/BACKEND/DAO/GheDAO.php';
include_once dirname(__DIR__) . '/BACKEND/DAO/PhongChieuDAO.php'; // Cần để lấy tên phòng

// 1. Lấy ID phòng từ URL
if (!isset($_GET['phong_id'])) {
    echo "<main class='main-content'><h1>Không tìm thấy phòng.</h1></main>";
    include_once dirname(__DIR__) . '/TEMPLATES/admin_footer.php';
    exit();
}
$phong_id = (int)$_GET['phong_id'];

// 2. Lấy danh sách ghế của phòng này
$gheDAO = new GheDAO();
$listGhe = $gheDAO->getGheByPhongChieuId($phong_id);

// (Code lấy tên phòng - Tạm thời bỏ qua để giữ đơn giản)
?>

<title>Admin - Chỉnh Sửa Sơ Đồ Ghế</title>

<main class="main-content">
    <header class="main-header">
        <h1>Quản lý Sơ Đồ Ghế (Phòng ID: <?php echo $phong_id; ?>)</h1>
        <a href="rooms.php" style="color: #fff; text-decoration: none;">&larr; Quay lại danh sách rạp</a>
    </header>

    <?php
    // Hiển thị thông báo
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_success') echo '<p class="status-message success">Thêm ghế thành công!</p>';
        if ($_GET['status'] == 'delete_success') echo '<p class="status-message success">Xóa ghế thành công!</p>';
        if ($_GET['status'] == 'error') echo '<p class="status-message error">Có lỗi xảy ra!</p>';
    }
    ?>

    <div style="display: flex; gap: 20px;">
        
        <div style="flex: 1;">
            <h3>Thêm Ghế Mới</h3>
            <form action="../BACKEND/CONTROLLER/GheController.php" method="POST" class="modal-content" style="position: relative; max-width: none;">
                <input type="hidden" name="action" value="add_ghe">
                <input type="hidden" name="phong_id" value="<?php echo $phong_id; ?>">
                
                <div class="form-group">
                    <label for="tenGhe">Tên Ghế (ví dụ: A1, A2...)</label>
                    <input type="text" id="tenGhe" name="tenGhe" required>
                </div>
                <div class="form-group">
                    <label for="loaiGhe">Loại Ghế</label>
                    <select id="loaiGhe" name="loaiGhe" required>
                        <option value="Thuong">Thường</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
                <button type="submit" class="add-new-btn">Thêm Ghế</button>
            </form>
        </div>

        <div style="flex: 2;">
            <h3>Danh Sách Ghế Hiện Tại (<?php echo count($listGhe); ?> ghế)</h3>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>ID Ghế</th>
                        <th>Tên Ghế</th>
                        <th>Loại Ghế</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listGhe) > 0) {
                        foreach($listGhe as $ghe) {
                    ?>
                        <tr>
                            <td><?php echo $ghe->getId(); ?></td>
                            <td><?php echo htmlspecialchars($ghe->getTenGhe()); ?></td>
                            <td>
                                <?php if($ghe->getLoaiGhe() == 'VIP'): ?>
                                    <span style="color: #e50914; font-weight: bold;">VIP</span>
                                <?php else: ?>
                                    <span>Thường</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="../BACKEND/CONTROLLER/GheController.php" method="POST" class="delete-form">
                                    <input type="hidden" name="action" value="delete_ghe">
                                    <input type="hidden" name="phong_id" value="<?php echo $phong_id; ?>">
                                    <input type="hidden" name="ghe_id" value="<?php echo $ghe->getId(); ?>">
                                    <button type="submit" class="action-btn delete" 
                                            onclick="return confirm('Bạn có chắc muốn xóa ghế <?php echo htmlspecialchars($ghe->getTenGhe()); ?>?');">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>Phòng này chưa có ghế nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
// Nạp footer (không cần JS đặc biệt)
include_once dirname(__DIR__) . '/TEMPLATES/admin_footer.php';
?>