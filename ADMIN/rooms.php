<?php
// File: ADMIN/rooms.php

// 1. Nạp header (đã chứa kiểm tra Admin và nạp Database.php)
include_once dirname(__DIR__) . '/TEMPLATES/admin_header.php'; 

// 2. Nạp các file DAO cần thiết
include_once dirname(__DIR__) . '/BACKEND/DAO/RapDAO.php';
include_once dirname(__DIR__) . '/BACKEND/DAO/PhongChieuDAO.php';

// 3. ✅ TẠO ĐỐI TƯỢNG DAO (Bước quan trọng nhất)
$rapDAO = new RapDAO();

// 4. ✅ GỌI DAO ĐỂ LẤY DANH SÁCH RẠP
$listRap = $rapDAO->getAllRap();
?>

<title>Admin - Quản Lý Rạp & Phòng</title>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Rạp & Phòng</h1>
        <button class="add-new-btn" id="addRapBtn">Thêm Rạp Mới</button>
    </header>

    <?php
    // Hiển thị thông báo
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_rap_success') echo '<p class="status-message success">Thêm rạp mới thành công!</p>';
        if ($_GET['status'] == 'add_room_success') echo '<p class="status-message success">Thêm phòng mới thành công!</p>';
        if ($_GET['status'] == 'error') echo '<p class="status-message error">Có lỗi xảy ra!</p>';
    }
    ?>

    <div class="cinema-list">
        <?php
        // 5. ✅ LẶP QUA DANH SÁCH ĐỐI TƯỢNG LẤY TỪ DAO
        if (count($listRap) > 0) {
            foreach($listRap as $rap) { // $rap bây giờ là 1 đối tượng
        ?>
            <div class="cinema-container">
                <div class="cinema-header">
                    <div>
                        <h3><?php echo htmlspecialchars($rap->getTenRap()); ?></h3>
                        <span style="color: #888; font-size: 0.9em;"><?php echo htmlspecialchars($rap->getDiaChi()); ?></span>
                    </div>
                    <div>
                        <button class="add-new-btn add-room-btn" data-rap-id="<?php echo $rap->getId(); ?>">Thêm Phòng</button>
                    </div>
                </div>
                
                <table class="content-table">
                    <thead>
                        <tr><th>ID Phòng</th><th>Tên Phòng</th><th>Tổng Số Ghế</th><th>Hành Động</th></tr>                    </thead>
                    <tbody>
                        <?php
                        // Lấy các phòng thuộc rạp này
                        // (Phải tạo DAO mới vì getAllRap() đã đóng kết nối)
                        $phongDAO = new PhongChieuDAO(); 
                        $listPhong = $phongDAO->getPhongByRapId($rap->getId());

                        if (count($listPhong) > 0) {
                            foreach($listPhong as $phong) { // $phong là 1 đối tượng
                                echo "<tr>";
                                echo "<td>" . $phong->getId() . "</td>";
                                echo "<td>" . htmlspecialchars($phong->getTenPhong()) . "</td>";
                                echo "<td>" . $phong->getSoLuongGhe() . "</td>";
                                
                                // THÊM CỘT HÀNH ĐỘNG MỚI
                                echo '<td>';
                                echo '  <a href="edit_room.php?phong_id=' . $phong->getId() . '" class="action-btn">Quản lý ghế</a>';
                                
                                // THÊM FORM XÓA PHÒNG
                                echo '  <form action="../BACKEND/CONTROLLER/RoomController.php" method="POST" class="delete-form" style="margin-left: 10px;">';
                                echo '      <input type="hidden" name="action" value="delete_room">';
                                echo '      <input type="hidden" name="phong_id" value="' . $phong->getId() . '">';
                                echo '      <input type="hidden" name="rap_id" value="' . $rap->getId() . '">'; // Để quay lại đúng rạp
                                echo '      <button type="submit" class="action-btn delete" onclick="return confirm(\'Bạn có chắc muốn xóa phòng này? TOÀN BỘ ghế và suất chiếu của phòng này cũng sẽ bị xóa!\');">Xóa</button>';
                                echo '  </form>';
                                
                                echo '</td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Rạp này chưa có phòng nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            }
        } else {
            echo "<p>Chưa có rạp nào. Vui lòng thêm rạp mới.</p>";
        }
        ?>
    </div>
</main>

<div id="rapModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Thêm Rạp Mới</h2>
        <form action="../BACKEND/CONTROLLER/RoomController.php" method="POST">
            <input type="hidden" name="action" value="add_rap">
            <div class="form-group">
                <label for="tenRap">Tên Rạp</label>
                <input type="text" id="tenRap" name="tenRap" required>
            </div>
            <div class="form-group">
                <label for="diaChi">Địa Chỉ</label>
                <input type="text" id="diaChi" name="diaChi" required>
            </div>
            <button type="submit" class="add-new-btn">Lưu Rạp</button>
        </form>
    </div>
</div>

<div id="phongModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Thêm Phòng Mới (Tự động tạo ghế)</h2>
        <form action="../BACKEND/CONTROLLER/RoomController.php" method="POST">
            <input type="hidden" name="action" value="add_room_bulk"> <input type="hidden" id="modal_rap_id" name="rap_id">
            
            <div class="form-group">
                <label for="tenPhong">Tên Phòng (ví dụ: Phòng 1, Phòng 2)</label>
                <input type="text" id="tenPhong" name="tenPhong" required>
            </div>
            
            <p style="color: #aaa; margin-bottom: 15px;">Hệ thống sẽ tự động tạo sơ đồ ghế dạng lưới:</p>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label for="soHang">Số Hàng (ví dụ: 10 cho A-J)</label>
                    <input type="number" id="soHang" name="soHang" min="1" max="26" placeholder="Tối đa 26 (A-Z)" required>
                </div>
                <div style="flex: 1;">
                    <label for="soGheMoiHang">Số Ghế Mỗi Hàng (ví dụ: 10)</label>
                    <input type="number" id="soGheMoiHang" name="soGheMoiHang" min="1" max="20" placeholder="Tối đa 20" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="soHangVIP">Số hàng VIP cuối cùng (ví dụ: 2)</label>
                <input type="number" id="soHangVIP" name="soHangVIP" min="0" value="2" required>
            </div>

            <button type="submit" class="add-new-btn">Tạo Phòng và Sơ Đồ Ghế</button>
        </form>
    </div>
</div>

<?php
include dirname(__DIR__) . '/TEMPLATES/admin_footer.php'; // Nạp footer (đã có JS cho 2 modal)
?>