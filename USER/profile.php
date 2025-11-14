<?php
// File: USER/profile.php

// 1. NẠP HEADER
include_once __DIR__ . '/../TEMPLATES/header.php'; 

// 2. BẢO VỆ TRANG
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=mustlogin");
    exit();
}

// 3. NẠP DAO
include_once __DIR__ . '/../BACKEND/DAO/NguoiDungDAO.php';
include_once __DIR__ . '/../BACKEND/DAO/DonDatVeDAO.php';

// 4. LẤY DỮ LIỆU
$user_id = (int)$_SESSION['user_id'];
$user = (new NguoiDungDAO())->getNguoiDungById($user_id);
$list_orders = (new DonDatVeDAO())->getDonHangByUserId($user_id);
?>

<title>Trang Cá Nhân - <?php echo htmlspecialchars($user->getHoTen()); ?></title>

<style>
    .container { width: 90%; max-width: 1000px; margin: 0 auto; }
    .profile-header { padding: 40px 0 20px 0; margin-bottom: 30px; }
    .profile-header h1 { font-size: 2.5rem; color: #fff; }
    
    /* === CSS CHO TABS === */
    .profile-tabs { display: flex; gap: 10px; border-bottom: 2px solid #333; margin-bottom: 30px; }
    .tab-btn { background: none; border: none; color: #888; font-size: 1.1rem; font-weight: 600; padding: 10px 20px; cursor: pointer; border-bottom: 3px solid transparent; transition: color 0.3s, border-color 0.3s; }
    .tab-btn:hover { color: #fff; }
    .tab-btn.active { color: #e50914; border-bottom-color: #e50914; }

    /* === CSS CHO NỘI DUNG === */
    .tab-content { background-color: #1a1a1a; border-radius: 8px; padding: 30px; }
    .tab-content.hidden { display: none; }
    
    .profile-box { /* Dùng cho cả 2 tab */
        max-width: 600px; /* Giới hạn chiều rộng form */
    }
    .profile-box h2 { font-size: 1.5rem; color: #e50914; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: #aaa; font-size: 0.9rem; }
    .form-group input { width: 100%; padding: 12px 15px; font-size: 1rem; background-color: #333; border: 2px solid #444; border-radius: 5px; color: #fff; }
    .form-group input[type="date"] { color-scheme: dark; }
    .form-group input:read-only { background-color: #222; color: #888; cursor: not-allowed; }
    .profile-btn { padding: 12px 20px; background-color: #e50914; color: #ffffff; border: none; border-radius: 5px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: background-color 0.3s; }
    .profile-btn:hover { background-color: #c40812; }

    /* (CSS cho Lịch sử đơn hàng) */
    .order-list { display: flex; flex-direction: column; gap: 15px; }
    .order-item { display: block; background-color: #222; padding: 20px; border-radius: 5px; border-left: 4px solid #e50914; text-decoration: none; transition: background-color 0.3s, border-color 0.3s; }
    .order-item:hover { background-color: #333; border-left-color: #61d9a4; }
    .order-item h3 { font-size: 1.2rem; color: #fff; margin-bottom: 10px; }
    .order-details { font-size: 0.9rem; color: #aaa; display: flex; flex-direction: column; gap: 5px; }
    .order-price { font-size: 1.1rem; font-weight: bold; color: #61d9a4; margin-top: 10px; }
    .order-price span { color: #e50914; font-size: 0.9rem; margin-left: 10px; }
    
    .status-message { padding: 10px; margin-bottom: 15px; border-radius: 5px; font-weight: 500; }
    .status-message.success { background-color: #2d614e; color: #61d9a4; }
    .status-message.error { background-color: #5c2c35; color: #e50914; }

    .dob-group {
        display: flex;
        gap: 10px;
    }
    .dob-group select {
        flex: 1; /* Chia đều không gian */
        width: 33%; /* Đảm bảo chúng lấp đầy */
        padding: 12px 10px;
        font-size: 1rem;
        background-color: #333;
        border: 2px solid #444;
        border-radius: 5px;
        color: #fff;
        color-scheme: dark;
    }
</style>

<main class="container">

    <div class="profile-header">
        <h1>Tài Khoản Của Bạn</h1>
    </div>

    <div class="profile-tabs">
        <button class="tab-btn active" data-target="#tab-info">Thông Tin Cá Nhân</button>
        <button class="tab-btn" data-target="#tab-history">Lịch Sử Giao Dịch</button>
    </div>

    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $messages = [
            'update_success' => ['class' => 'success', 'text' => 'Cập nhật thông tin thành công!'],
            'password_success' => ['class' => 'success', 'text' => 'Đổi mật khẩu thành công!'],
            'empty_name' => ['class' => 'error', 'text' => 'Họ tên không được để trống!'],
            'invalid_phone' => ['class' => 'error', 'text' => 'Số điện thoại không hợp lệ!'],
            'invalid_dob' => ['class' => 'error', 'text' => 'Ngày sinh không hợp lệ!'],
            'password_mismatch' => ['class' => 'error', 'text' => 'Mật khẩu mới không trùng khớp!'],
            'password_short' => ['class' => 'error', 'text' => 'Mật khẩu mới phải dài ít nhất 6 ký tự!'],
            'old_password_wrong' => ['class' => 'error', 'text' => 'Mật khẩu cũ không chính xác!'],
            'error' => ['class' => 'error', 'text' => 'Có lỗi xảy ra, vui lòng thử lại!']
        ];
        
        if (array_key_exists($status, $messages)) {
            echo '<p class="status-message ' . $messages[$status]['class'] . '">' . $messages[$status]['text'] . '</p>';
        }
    }
    ?>
    
    <div class="profile-content">
    
        <div id="tab-info" class="tab-content">
            <div class="profile-box">
                <h2>Thông Tin Cá Nhân</h2>
                
                <form action="../BACKEND/CONTROLLER/ProfileController.php" method="POST">
                    <input type="hidden" name="action" value="update_info">
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user->getEmail()); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="fullname">Họ và Tên</label>
                        <input type="text" id="fullname" name="fullname" 
                               value="<?php echo htmlspecialchars($user->getHoTen()); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user->getSoDienThoai()); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Ngày Sinh</label>
                        
                        <?php
                        // Tách ngày sinh (YYYY-MM-DD) từ CSDL ra 3 phần
                        $ngay_db = null;
                        $thang_db = null;
                        $nam_db = null;
                        if ($user->getNgaySinh()) {
                            $dob = new DateTime($user->getNgaySinh());
                            $ngay_db = $dob->format('d');
                            $thang_db = $dob->format('m');
                            $nam_db = $dob->format('Y');
                        }
                        ?>

                        <div class="dob-group">
                            <select name="dob_day">
                                <option value="">Ngày</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($i == $ngay_db) echo 'selected'; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            
                            <select name="dob_month">
                                <option value="">Tháng</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($i == $thang_db) echo 'selected'; ?>>
                                        Tháng <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            
                            <select name="dob_year">
                                <option value="">Năm</option>
                                <?php for ($i = date('Y'); $i >= (date('Y') - 100); $i--): // 100 năm về trước ?>
                                    <option value="<?php echo $i; ?>" <?php if ($i == $nam_db) echo 'selected'; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="profile-btn">Lưu Thay Đổi</button>
                </form>
            </div>
            
            <div class="profile-box" style="margin-top: 30px;">
                <h2>Đổi Mật Khẩu</h2>
                
                <form action="../BACKEND/CONTROLLER/ProfileController.php" method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label for="old_password">Mật khẩu cũ</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="profile-btn">Đổi Mật Khẩu</button>
                </form>
            </div>
        </div>
        
        <div id="tab-history" class="tab-content hidden">
            <div class="profile-box" style="max-width: none;"> <h2>Lịch Sử Đặt Vé</h2>
                
                <div class="order-list">
                    <?php
                    if (count($list_orders) > 0) {
                        foreach ($list_orders as $order) {
                    ?>
                        <a href="order_details.php?order_id=<?php echo $order['Id']; ?>" class="order-item">
                            <h3><?php echo htmlspecialchars($order['TenPhim'] ?? 'Phim không xác định'); ?></h3>
                            <div class="order-details">
                                <span><strong>Rạp:</strong> <?php echo htmlspecialchars($order['TenRap'] ?? 'N/A'); ?></span>
                                <span><strong>Ngày:</strong> <?php echo date('d/m/Y', strtotime($order['NgayChieu'])); ?></span>
                                <span><strong>Giờ:</strong> <?php echo date('H:i', strtotime($order['GioBatDau'])); ?></span>
                            </div>
                            <div class="order-price">
                                <?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ
                                <?php if ($order['TrangThai'] == 'DaHuy'): ?>
                                    <span>(ĐÃ HỦY)</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php
                        }
                    } else {
                        echo "<p>Bạn chưa có đơn hàng nào.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
    </div> </main> <script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const targetContent = document.querySelector(targetId);

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.add('hidden'));

            button.classList.add('active');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
</script>

<?php
// 5. Nạp Footer
include __DIR__ . '/../TEMPLATES/footer.php'; 
?>