<?php
// File: login.php (Thư mục gốc)

// 1. Nạp Header (Menu, Session)
// (Khớp với tên thư mục TEMPLATES của bạn)
include 'TEMPLATES/header.php'; 
?>

<title>Đăng Nhập - Đặt Vé Xem Phim</title>

<style>
    /* Phần nội dung chính (giữa trang) */
    .main-content {
        flex-grow: 1; /* Đẩy footer xuống dưới */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px; /* Thêm padding trên dưới */
    }

    /* Form đăng nhập */
    .login-container {
        background-color: #1a1a1a;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        width: 100%;
        max-width: 400px;
    }

    .login-container h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
        color: #fff;
    }
    
    /* Hiển thị lỗi */
    .login-error {
        color: #e50914; /* Màu đỏ */
        background-color: rgba(229, 9, 20, 0.1);
        border: 1px solid #e50914;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .login-success {
        color: #61d9a4; /* Màu xanh */
        background-color: rgba(97, 217, 164, 0.1);
        border: 1px solid #61d9a4;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Nhóm ô nhập liệu */
    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .input-field {
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        background-color: #333;
        border: 2px solid #444;
        border-radius: 5px;
        color: #fff;
        transition: border-color 0.3s;
    }
    
    .input-field:focus {
        outline: none;
        border-color: #e50914;
    }

    .input-label {
        position: absolute;
        top: 14px;
        left: 15px;
        font-size: 1rem;
        color: #888;
        pointer-events: none;
        transition: all 0.3s ease;
    }
    
    .input-field:focus + .input-label,
    .input-field:not(:placeholder-shown) + .input-label {
        top: -10px;
        left: 10px;
        font-size: 0.75rem;
        color: #e50914;
        background-color: #1a1a1a;
        padding: 0 5px;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        background-color: #e50914;
        color: #ffffff;
        text-align: center;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .login-btn:hover { background-color: #c40812; }
    
    .login-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        font-size: 0.9rem;
        color: #aaa;
    }
    .login-options a { color: #fff; text-decoration: none; }
    .login-options a:hover { text-decoration: underline; }
    
    .signup-link {
        margin-top: 30px;
        text-align: center;
        color: #aaa;
    }
    .signup-link a { color: #fff; font-weight: bold; text-decoration: none; }
    .signup-link a:hover { text-decoration: underline; }
</style>

<main class="main-content">
    
    <div class="login-container">
        <h1>Đăng Nhập</h1>
        
        <?php
        // 2. Code PHP để hiển thị thông báo (từ Controller)
        if (isset($_GET['error'])) {
            $message = 'Email hoặc Mật khẩu không chính xác!';
            if ($_GET['error'] == 'accessdenied') {
                $message = 'Bạn phải đăng nhập (vai trò Admin) để xem trang đó!';
            }
            echo '<p class="login-error">' . $message . '</p>';
        }
        
        // Hiển thị thông báo nếu đăng ký thành công
        if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
            echo '<p class="login-success">Đăng ký thành công! Vui lòng đăng nhập.</p>';
        }
        ?>
        
        <form method="POST" action="BACKEND/CONTROLLER/LoginController.php">
            
            <div class="input-group">
                <input type="email" id="email" name="email" class="input-field" placeholder=" " required>
                <label for="email" class="input-label">Email</label>
            </div>
            
            <div class="input-group">
                <input type="password" id="password" name="password" class="input-field" placeholder=" " required>
                <label for="password" class="input-label">Mật khẩu</label>
            </div>

            <button type="submit" class="login-btn">Đăng Nhập</button>

            <div class="login-options">
                <div>
                    <input type="checkbox" id="remember-me" name="remember">
                    <label for="remember-me">Ghi nhớ tôi</label>
                </div>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <div class="signup-link">
                Bạn mới tham gia? <a href="signup.php">Đăng ký ngay.</a>
            </div>
            
        </form>
    </div>

</main> <?php
// 4. Nạp Footer
include 'TEMPLATES/footer.php'; 
?>