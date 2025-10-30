<?php
// File: signup.php (Thư mục gốc)

// 1. Nạp Header (Menu, Session)
include 'templates/header.php'; 
?>

<title>Đăng Ký - Đặt Vé Xem Phim</title>

<style>
    /* (CSS cho .main-header và .main-footer đã có) */

    .main-content {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    /* Form đăng ký */
    .signup-container {
        background-color: #1a1a1a;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        width: 100%;
        max-width: 450px;
    }

    .signup-container h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
        color: #fff;
    }
    
    /* Hiển thị lỗi */
    .signup-error {
        color: #e50914; /* Màu đỏ */
        background-color: rgba(229, 9, 20, 0.1);
        border: 1px solid #e50914;
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

    /* Nút Đăng Ký */
    .signup-btn {
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

    .signup-btn:hover {
        background-color: #c40812;
    }
    
    /* Link Đăng nhập */
    .login-link {
        margin-top: 30px;
        text-align: center;
        color: #aaa;
    }
    
    .login-link a {
        color: #fff;
        font-weight: bold;
        text-decoration: none;
    }
    
    .login-link a:hover {
        text-decoration: underline;
    }
</style>

<main class="main-content">
    
    <div class="signup-container">
        <h1>Đăng Ký</h1>
        
        <?php
        // 2. Code PHP để hiển thị thông báo lỗi
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            $message = '';
            if ($error == 'password') {
                $message = 'Mật khẩu không trùng khớp!';
            } else if ($error == 'email') {
                $message = 'Email này đã tồn tại!';
            } else if ($error == 'stmtfailed') {
                $message = 'Đã có lỗi xảy ra, vui lòng thử lại!';
            }
            echo '<p class="signup-error">' . $message . '</p>';
        }
        ?>

        <form method="POST" action="backend/CONTROLLER/SignupController.php">
            
            <div class="input-group">
                <input type="text" id="fullname" name="fullname" class="input-field" placeholder=" " required>
                <label for="fullname" class="input-label">Họ và Tên</label>
            </div>

            <div class="input-group">
                <input type="email" id="email" name="email" class="input-field" placeholder=" " required>
                <label for="email" class="input-label">Email</label>
            </div>
            
            <div class="input-group">
                <input type="password" id="password" name="password" class="input-field" placeholder=" " required>
                <label for="password" class="input-label">Mật khẩu</label>
            </div>

            <div class="input-group">
                <input type="password" id="confirm-password" name="confirm_password" class="input-field" placeholder=" " required>
                <label for="confirm-password" class="input-label">Xác nhận mật khẩu</label>
            </div>

            <button type="submit" name="submit" class="signup-btn">Tạo Tài Khoản</button>

            <div class="login-link">
                Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay.</a>
            </div>
        </form>
    </div>

</main> <?php
// 4. Nạp Footer (để đóng </body> và </html>)
include 'templates/footer.php'; 
?>