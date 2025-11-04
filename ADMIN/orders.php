<?php
// File: ADMIN/orders.php

// Set page title before including header
$pageTitle = "Admin - Quản Lý Đơn Hàng";

// 1. Include header
include_once dirname(__DIR__) . '/TEMPLATES/admin_header.php'; 

// 2. Include DAO
include_once dirname(__DIR__) . '/BACKEND/DAO/DonDatVeDAO.php'; 

// 3. Create DAO instance
$donDatVeDAO = new DonDatVeDAO();

// 4. Get order list
$orderList = $donDatVeDAO->getDonHangSummary();
?>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Đơn Hàng</h1>
    </header>

    <?php
    // 3. Hiển thị thông báo
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'cancel_success') echo '<p class="status-message success">Hủy đơn hàng thành công!</p>';
        if ($_GET['status'] == 'error') echo '<p class="status-message error">Có lỗi xảy ra!</p>';
    }
    ?>

    <table class="content-table">
        <thead>
            <tr>
                <th>Mã Đơn</th>
                <th>Email Khách Hàng</th>
                <th>Tên Phim</th>
                <th>Suất Chiếu</th>
                <th>Tổng Tiền</th>
                <th>Ngày Đặt</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 5. Lặp qua danh sách
            if (count($orderList) > 0) {
                foreach($orderList as $row) {
            ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo htmlspecialchars($row['Email'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($row['TenPhim'] ?? 'N/A'); ?></td>
                    <td>
                        <?php 
                        if ($row['NgayChieu']) {
                            echo date('d/m/Y', strtotime($row['NgayChieu'])) . ' lúc ' . date('H:i', strtotime($row['GioBatDau']));
                        } else { echo 'N/A'; }
                        ?>
                    </td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['NgayDat'])); ?></td>
                    <td>
                        <?php if ($row['TrangThai'] == 'DaThanhToan'): ?>
                            <span class="status-badge success">Đã Thanh Toán</span>
                        <?php else: ?>
                            <span class="status-badge cancelled">Đã Hủy</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['TrangThai'] == 'DaThanhToan'): ?>
                            <form action="../BACKEND/CONTROLLER/OrderController.php" method="POST" class="delete-form">
                                <input type="hidden" name="action" value="cancel_order">
                                <input type="hidden" name="order_id" value="<?php echo $row['Id']; ?>">
                                <button type="submit" class="action-btn delete" onclick="return confirm('Bạn có chắc muốn hủy đơn này?');">Hủy Vé</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>Chưa có đơn hàng nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php
include_once dirname(__DIR__) . '/TEMPLATES/admin_footer.php';
?>