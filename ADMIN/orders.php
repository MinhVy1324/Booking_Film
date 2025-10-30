<?php
// File: ADMIN/orders.php
include '../templates/admin_header.php'; // Nạp header
include_once __DIR__ . '/../DAO/DonDatVeDAO.php'; // NẠP DAO MỚI

// 1. Tạo đối tượng DAO
$donDatVeDAO = new DonDatVeDAO();
// 2. Gọi DAO để lấy danh sách
$orderList = $donDatVeDAO->getDonHangSummary();
?>

<title>Admin - Quản Lý Đơn Hàng</title>

<style>
    /* (CSS cho .status-badge...) */
</style>

<main class="main-content">
    <header class="main-header">
        <h1>Quản Lý Đơn Hàng</h1>
    </header>

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
            // 3. Lặp qua danh sách đã lấy từ DAO
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
                            <form action="../backend/CONTROLLER/OrderController.php" method="POST" class="delete-form">
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
include '../TEMPLATES/admin_footer.php'; // Nạp footer
?>