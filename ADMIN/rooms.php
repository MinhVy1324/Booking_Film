<?php
// File: ADMIN/rooms.php
include '../TEMPLATES/admin_header.php'; // Nạp header (đã có connect.php và kiểm tra admin)
?>

<title>Admin - Quản Lý Rạp & Phòng</title>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Rạp & Phòng</h1>
        <button class="add-new-btn" id="addRapBtn">Thêm Rạp Mới</button>
    </header>

    <?php
    // Hiển thị thông báo (nếu có)
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_rap_success') echo '<p class="status-message success">Thêm rạp mới thành công!</p>';
        if ($_GET['status'] == 'add_room_success') echo '<p class="status-message success">Thêm phòng mới thành công!</p>';
        if ($_GET['status'] == 'error') echo '<p class="status-message error">Có lỗi xảy ra!</p>';
    }
    ?>

    <div class="cinema-list">
        <?php
        // Lấy tất cả các rạp
        $sql_rap = "SELECT * FROM Rap";
        $result_rap = $conn->query($sql_rap);
        
        if ($result_rap->num_rows > 0) {
            while($rap = $result_rap->fetch_assoc()) {
        ?>
            <div class="cinema-container">
                <div class="cinema-header">
                    <div>
                        <h3><?php echo htmlspecialchars($rap['TenRap']); ?></h3>
                        <span style="color: #888; font-size: 0.9em;"><?php echo htmlspecialchars($rap['DiaChi']); ?></span>
                    </div>
                    <div>
                        <button class="add-new-btn add-room-btn" data-rap-id="<?php echo $rap['Id']; ?>">Thêm Phòng</button>
                    </div>
                </div>
                
                <table class="content-table">
                    <thead>
                        <tr><th>ID Phòng</th><th>Tên Phòng</th><th>Số Lượng Ghế</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        // Lấy các phòng thuộc rạp này
                        $sql_phong = "SELECT * FROM PhongChieu WHERE IdRap = ?";
                        $stmt_phong = $conn->prepare($sql_phong);
                        $stmt_phong->bind_param("i", $rap['Id']);
                        $stmt_phong->execute();
                        $result_phong = $stmt_phong->get_result();

                        if ($result_phong->num_rows > 0) {
                            while($phong = $result_phong->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $phong['Id'] . "</td>";
                                echo "<td>" . htmlspecialchars($phong['TenPhong']) . "</td>";
                                echo "<td>" . $phong['SoLuongGhe'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Rạp này chưa có phòng nào.</td></tr>";
                        }
                        $stmt_phong->close();
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
        <span class="close-btn" id="closeRapModal">&times;</span>
        <h2>Thêm Rạp Mới</h2>
        <form action="../backend/CONTROLLER/RoomController.php" method="POST">
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
        <span class="close-btn" id="closePhongModal">&times;</span>
        <h2>Thêm Phòng Mới</h2>
        <form action="../backend/CONTROLLER/RoomController.php" method="POST">
            <input type="hidden" name="action" value="add_room">
            <input type="hidden" id="modal_rap_id" name="rap_id">
            
            <div class="form-group">
                <label for="tenPhong">Tên Phòng (ví dụ: Phòng 1, Phòng 2)</label>
                <input type="text" id="tenPhong" name="tenPhong" required>
            </div>
            <div class="form-group">
                <label for="soLuongGhe">Tổng Số Ghế</label>
                <input type="number" id="soLuongGhe" name="soLuongGhe" required>
            </div>
            <button type="submit" class="add-new-btn">Lưu Phòng</button>
        </form>
    </div>
</div>

<style>
    .cinema-container {
        background-color: #2f3136;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden; /* Giữ table bo góc */
    }
    .cinema-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #40444b;
    }
    .cinema-header h3 { font-size: 1.3rem; }
</style>

<script>
    const rapModal = document.getElementById('rapModal');
    const addRapBtn = document.getElementById('addRapBtn');
    const closeRapModal = document.getElementById('closeRapModal');
    
    addRapBtn.onclick = () => rapModal.style.display = 'flex';
    closeRapModal.onclick = () => rapModal.style.display = 'none';

    const phongModal = document.getElementById('phongModal');
    const closePhongModal = document.getElementById('closePhongModal');
    const hiddenRapIdInput = document.getElementById('modal_rap_id');
    
    // Gán sự kiện cho TẤT CẢ các nút "Thêm Phòng"
    document.querySelectorAll('.add-room-btn').forEach(button => {
        button.onclick = function() {
            const rapId = this.getAttribute('data-rap-id'); // Lấy ID rạp từ nút
            hiddenRapIdInput.value = rapId; // Gán ID vào form
            phongModal.style.display = 'flex'; // Mở modal
        }
    });
    
    closePhongModal.onclick = () => phongModal.style.display = 'none';

    // Đóng khi nhấn ra ngoài
    window.onclick = (event) => {
        if (event.target == rapModal) rapModal.style.display = 'none';
        if (event.target == phongModal) phongModal.style.display = 'none';
    }
</script>

<?php
include '../TEMPLATES/admin_footer.php'; // Nạp footer (đóng </body>, </html>)
?>