<?php
// File: ADMIN/dashboard.php
include_once dirname(__DIR__) . '/TEMPLATES/admin_header.php'; // Nạp header
include_once dirname(__DIR__) . '/BACKEND/DAO/DashboardDAO.php'; // NẠP DAO MỚI

// 1. Tạo đối tượng DAO
$dashboardDAO = new DashboardDAO();

// 2. Gọi DAO để lấy dữ liệu KPI
$kpiData = $dashboardDAO->getKpiData();

// 3. Gọi DAO để lấy dữ liệu Chart
// (Phải tạo 2 đối tượng DAO riêng biệt vì DAO tự đóng kết nối sau mỗi lần gọi)
$chartDataRaw = (new DashboardDAO())->getRevenueChartData(); 

// 4. Xử lý dữ liệu chart cho JavaScript
$chartLabels = [];
$chartValues = [];
foreach ($chartDataRaw as $row) {
    $chartLabels[] = date('d/m', strtotime($row['Ngay']));
    $chartValues[] = $row['DoanhThu'];
}
?>

<title>Admin - Dashboard</title>

<main class="main-content">
    <header class="main-header">
        <h1>Dashboard</h1>
    </header>
    
    <section class="kpi-grid">
        <div class="kpi-card">
            <h3>Doanh Thu Hôm Nay</h3>
            <p class="value"><?php echo number_format($kpiData['DoanhThuHomNay'], 0, ',', '.'); ?> VNĐ</p>
        </div>
        <div class="kpi-card">
            <h3>Vé Bán Hôm Nay</h3>
            <p class="value"><?php echo $kpiData['VeHomNay']; ?> vé</p>
        </div>
        <div class="kpi-card">
            <h3>Phim Đang Chiếu</h3>
            <p class="value"><?php echo $kpiData['TongPhim']; ?> phim</p>
        </div>
        <div class="kpi-card">
            <h3>Tổng Thành Viên</h3>
            <p class="value"><?php echo $kpiData['TongThanhVien']; ?></p>
        </div>
    </section>
    
    <section class="chart-container">
        <h2>Doanh Thu 7 Ngày Qua</h2>
        <canvas id="revenueChart"></canvas>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // 5. Nạp dữ liệu từ PHP vào JavaScript
    const labels = <?php echo json_encode($chartLabels); ?>;
    const revenueData = <?php echo json_encode($chartValues); ?>;
    
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenueData,
                borderColor: '#e50914',
                backgroundColor: 'rgba(229, 9, 20, 0.1)',
                fill: true,
                tension: 0.1
            }]
        },
        // (Options style... đã có ở file trước)
    });
</script>

<?php
include '../TEMPLATES/admin_footer.php'; // Nạp footer
?>