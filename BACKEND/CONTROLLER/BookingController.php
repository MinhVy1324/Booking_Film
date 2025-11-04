<?php
// File: BACKEND/CONTROLLER/BookingController.php
session_start();
include_once __DIR__ . '/../BUS/BookingBUS.php'; // GỌI BUS

if (!isset($_SESSION['user_id']) && isset($_POST['action']) && $_POST['action'] == 'checkout') {
    header("Location: ../../login.php?error=mustlogin"); exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $action = $_POST['action'];
    $bookingBUS = new BookingBUS(); // TẠO BUS

    switch ($action) {
        case 'add_to_cart':
            $cart_data = $bookingBUS->xuLyThemVaoGioHang(
                (int)$_POST['suatchieu_id'], $_POST['selected_seats_ids'],
                $_POST['selected_seats_names'], (int)$_POST['total_price']
            );
            if ($cart_data) {
                $_SESSION['cart'] = $cart_data; // Lưu vào Session
                header("Location: ../../USER/checkout.php");
            } else { header("Location: ../../index.php?error=invalid_showtime"); }
            exit();
            break;

        case 'checkout':
            if (!isset($_SESSION['cart']) || !isset($_SESSION['user_id'])) {
                header("Location: ../../index.php"); exit();
            }
            
            $new_order_id = $bookingBUS->xuLyThanhToan($_SESSION['cart'], (int)$_SESSION['user_id']);

            if ($new_order_id) {
                unset($_SESSION['cart']); // Xóa giỏ hàng
                header("Location: ../../USER/booking-success.php?order_id=" . $new_order_id);
            } else {
                header("Location: ../../USER/checkout.php?error=1");
            }
            exit();
            break;
    }
}
?>