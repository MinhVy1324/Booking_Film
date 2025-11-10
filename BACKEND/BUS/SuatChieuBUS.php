<?php
// File: BACKEND/BUS/SuatChieuBUS.php

include_once __DIR__ . '/../DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../DTO/SuatChieu.php';

class SuatChieuBUS {
    private function validate($ngayBatDau, $ngayKetThuc, $giaVe) {
        
        // LUẬT 1: Giá vé phải là số dương
        if (!is_numeric($giaVe) || (int)$giaVe <= 0) {
            return false;
        }

        // LUẬT 2: Ngày/giờ không được tạo trong quá khứ
        // (Đây là dòng 15 đã được sửa)
        try {
            $thoiGianBatDau = new DateTime($ngayBatDau); 
            $thoiGianKetThuc = new DateTime($ngayKetThuc);
        } catch (Exception $e) {
            return false; // Định dạng ngày tháng bị sai
        }
        
        $thoiGianHienTai = new DateTime();
        
        // LUẬT 3: Ngày kết thúc không được trước ngày bắt đầu
        if ($thoiGianKetThuc < $thoiGianBatDau) {
            return false;
        }
        
        // LUẬT 4: Ngày bắt đầu không được là ngày đã qua
        // (So sánh ngày, bỏ qua giờ)
        if ($thoiGianBatDau < $thoiGianHienTai->setTime(0, 0, 0)) {
            return false;
        }
        
        return true;
    }

    // Hàm validate MỚI cho 1 suất chiếu lẻ (SỬA)
    private function validateSingle($ngayChieu, $gioBatDau, $giaVe) {
        // LUẬT 1: Giá vé phải là số dương
        if (!is_numeric($giaVe) || (int)$giaVe <= 0) {
            return false;
        }

        // LUẬT 2: Ngày/giờ phải hợp lệ
        try {
            // Thử tạo 1 đối tượng DateTime để xem ngày/giờ có bị lỗi cú pháp không
            $thoiGianChieu = new DateTime($ngayChieu . ' ' . $gioBatDau);
        } catch (Exception $e) {
            return false; // Định dạng ngày/giờ sai (ví dụ: 25:00)
        }
        
        return true;
    }
    
    public function xuLyThemSuatChieu($idPhim, $idPhong, $ngayChieu, $gioBatDau, $giaVe) {
        if (!$this->validate($ngayChieu, $gioBatDau, $giaVe)) {
            return ['status' => false, 'message' => 'error'];
        }
        
        $sc = new SuatChieu();
        $sc->setIdPhim((int)$idPhim);
        $sc->setIdPhongChieu((int)$idPhong);
        $sc->setNgayChieu($ngayChieu);
        $sc->setGioBatDau($gioBatDau);
        $sc->setGiaVe((int)$giaVe);

        $scDAO = new SuatChieuDAO();
        if ($scDAO->themSuatChieu($sc)) {
            return ['status' => true, 'message' => 'add_success'];
        }
        return ['status' => false, 'message' => 'error'];
    }
    
    public function xuLySuaSuatChieu($id, $idPhim, $idPhong, $ngayChieu, $gioBatDau, $giaVe) {
        if (!$this->validateSingle($ngayChieu, $gioBatDau, $giaVe)) {
            return ['status' => false, 'message' => 'error'];
        }
        
        $sc = new SuatChieu();
        $sc->setId((int)$id);
        $sc->setIdPhim((int)$idPhim);
        $sc->setIdPhongChieu((int)$idPhong);
        $sc->setNgayChieu($ngayChieu);
        $sc->setGioBatDau($gioBatDau);
        $sc->setGiaVe((int)$giaVe);

        $scDAO = new SuatChieuDAO();
        if ($scDAO->suaSuatChieu($sc)) {
            return ['status' => true, 'message' => 'edit_success'];
        }
        return ['status' => false, 'message' => 'error'];
    }

    public function xuLyThemSuatChieuHangLoat($idPhim, $idPhong, $giaVe, $ngayBatDau, $ngayKetThuc, $cacGioChieu_str) {
        
        // 1. Kiểm tra nghiệp vụ
        if (!$this->validate($ngayBatDau, $ngayKetThuc, $giaVe)) {
            return ['status' => false, 'message' => 'error'];
        }

        // 2. Chuyển đổi chuỗi giờ thành mảng
        // Ví dụ: "09:30, 13:00" -> ["09:30", "13:00"]
        $mangCacGioChieu = explode(',', $cacGioChieu_str);
        if (empty($mangCacGioChieu)) {
            return ['status' => false, 'message' => 'error'];
        }
        
        // 3. Chuẩn bị vòng lặp
        $currentDate = new DateTime($ngayBatDau);
        $endDate = new DateTime($ngayKetThuc);
        
        // 4. Vòng lặp chính: Lặp qua từng NGÀY
        while ($currentDate <= $endDate) {
            
            // 5. Vòng lặp phụ: Lặp qua từng GIỜ
            foreach ($mangCacGioChieu as $gio) {
                
                // 6. Tạo đối tượng DTO cho từng suất lẻ
                $suatChieu = new SuatChieu();
                $suatChieu->setIdPhim((int)$idPhim);
                $suatChieu->setIdPhongChieu((int)$idPhong);
                $suatChieu->setGiaVe((int)$giaVe);
                $suatChieu->setNgayChieu($currentDate->format('Y-m-d'));
                $suatChieu->setGioBatDau(trim($gio));
                
                // 7. SỬA LỖI (Quan trọng):
                // Tạo một ĐỐI TƯỢNG DAO MỚI cho MỖI LẦN lặp
                // để tránh lỗi "kết nối đã bị đóng"
                $daoMoi = new SuatChieuDAO();
                $daoMoi->themSuatChieu($suatChieu);
            }
            
            // 8. Tăng ngày lên 1 để tiếp tục vòng lặp
            $currentDate->modify('+1 day');
        }

        return ['status' => true, 'message' => 'add_success'];
    }
}
?>