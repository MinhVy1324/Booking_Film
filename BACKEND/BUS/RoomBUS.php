<?php
// File: BACKEND/BUS/RoomBUS.php

include_once __DIR__ . '/../DAO/RapDAO.php';
include_once __DIR__ . '/../DAO/PhongChieuDAO.php';
include_once __DIR__ . '/../DTO/Rap.php';
include_once __DIR__ . '/../DTO/PhongChieu.php';
include_once __DIR__ . '/../DAO/GheDAO.php';
include_once __DIR__ . '/../DTO/Ghe.php';

class RoomBUS {
    public function xuLyThemRap($tenRap, $diaChi) {
        // LUẬT: Tên rạp và địa chỉ không được trống
        if (empty(trim($tenRap)) || empty(trim($diaChi))) {
            return ['status' => false, 'message' => 'error'];
        }

        $rap = new Rap();
        $rap->setTenRap($tenRap);
        $rap->setDiaChi($diaChi);

        $rapDAO = new RapDAO();
        if ($rapDAO->themRap($rap)) {
            return ['status' => true, 'message' => 'add_rap_success'];
        }
        return ['status' => false, 'message' => 'error'];
    }

    public function xuLyThemPhongHangLoat($idRap, $tenPhong, $soHang, $soGheMoiHang, $soHangVIP) {
        // --- 1. Validation (Kiểm tra nghiệp vụ) ---
        if ($soHang <= 0 || $soGheMoiHang <= 0 || $soHangVIP < 0 || $soHangVIP > $soHang) {
            return ['status' => false, 'message' => 'error'];
        }
        
        $tongSoGhe = $soHang * $soGheMoiHang;

        // --- 2. Tạo đối tượng Phòng (DTO) ---
        $phong = new PhongChieu();
        $phong->setIdRap((int)$idRap);
        $phong->setTenPhong($tenPhong);
        $phong->setSoLuongGhe($tongSoGhe);
        
        // --- 3. Tạo Phòng và Lấy ID (BUS gọi DAO) ---
        $phongDAO = new PhongChieuDAO();
        $newPhongId = $phongDAO->themPhong($phong); // Hàm này giờ đã trả về ID

        if ($newPhongId === false) {
            return ['status' => false, 'message' => 'error']; // Lỗi tạo phòng
        }

        // --- 4. TỰ ĐỘNG TẠO GHẾ (Phép thuật ở đây) ---
        $gheDAO = new GheDAO();
        $alphabet = range('A', 'Z'); // Tạo mảng [A, B, C, ...]
        
        // Vòng lặp Hàng (Rows)
        for ($i = 0; $i < $soHang; $i++) {
            $tenHang = $alphabet[$i]; // A, B, C...
            
            // Xác định loại ghế cho hàng này
            $loaiGhe = 'Thuong';
            // Ví dụ: 10 hàng, 2 hàng VIP. Hàng 8 (index 7), Hàng 9 (index 8)
            // (10 - 2 = 8). Nếu $i >= 8 (tức là hàng I, J) thì là VIP
            if ($i >= ($soHang - $soHangVIP)) {
                $loaiGhe = 'VIP';
            }

            // Vòng lặp Cột (Seats)
            for ($j = 1; $j <= $soGheMoiHang; $j++) {
                $tenGhe = $tenHang . $j; // A1, A2, ... J10

                // Tạo đối tượng Ghe (DTO)
                $ghe = new Ghe();
                $ghe->setTenGhe($tenGhe);
                $ghe->setLoaiGhe($loaiGhe);
                $ghe->setIdPhongChieu($newPhongId);

                // Yêu cầu DAO thêm ghế (gọi 100 lần)
                $gheDAO->themGhe($ghe);
            }
        }

        return ['status' => true, 'message' => 'add_room_success'];
    }

    public function xuLyXoaPhong($idPhong) {
        // (Logic nghiệp vụ nâng cao: 
        //  Chúng ta nên kiểm tra xem phòng này có suất chiếu nào SẮP DIỄN RA không.
        //  Nếu có, không cho xóa. Nhưng để đơn giản cho đồ án, chúng ta sẽ cho xóa)

        $phongDAO = new PhongChieuDAO();
        if ($phongDAO->xoaPhong((int)$idPhong)) {
            return ['status' => true, 'message' => 'delete_room_success'];
        }
        return ['status' => false, 'message' => 'error'];
    }
}
?>