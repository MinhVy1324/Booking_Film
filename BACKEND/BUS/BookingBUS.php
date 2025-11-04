<?php
// File: BACKEND/BUS/BookingBUS.php

include_once __DIR__ . '/../DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../DAO/DonDatVeDAO.php';
include_once __DIR__ . '/../DAO/ChiTietDatVeDAO.php';
include_once __DIR__ . '/../DAO/GheDAO.php';
include_once __DIR__ . '/../DTO/DonDatVe.php';
include_once __DIR__ . '/../DTO/ChiTietDatVe.php';

class BookingBUS {
    /**
     * Xử lý thêm vào giỏ hàng
     * @return array|false Dữ liệu giỏ hàng hoặc false nếu lỗi
     */
    public function xuLyThemVaoGioHang($suatchieu_id, $selected_ids, $selected_names, $total_price) {
        $scDAO = new SuatChieuDAO();
        $suatchieu_details = $scDAO->getSuatChieuDetailsById($suatchieu_id);

        if ($suatchieu_details == null) {
            return false; // Suất chiếu không hợp lệ
        }

        $cart = [
            'suatchieu_id' => $suatchieu_id,
            'seat_ids' => $selected_ids,
            'seat_names' => $selected_names,
            'total_price' => $total_price,
            'details' => $suatchieu_details
        ];
        return $cart;
    }

    /**
     * Xử lý thanh toán
     * @return int|false ID đơn hàng mới hoặc false nếu lỗi
     */
    public function xuLyThanhToan($cart, $idNguoiDung) {
        // TẠO ĐƠN ĐẶT VÉ
        $donDatVe = new DonDatVe();
        $donDatVe->setIdNguoiDung($idNguoiDung);
        $donDatVe->setIdSuatChieu((int)$cart['suatchieu_id']);
        $donDatVe->setTongTien((int)$cart['total_price']);
        
        $donDatVeDAO = new DonDatVeDAO();
        $new_dondatve_id = $donDatVeDAO->taoDonDatVe($donDatVe);

        if ($new_dondatve_id === false) return false;

        // THÊM CHI TIẾT VÉ
        $ctdvDAO = new ChiTietDatVeDAO();
        $gheDAO = new GheDAO();
        $idGheArray = explode(',', $cart['seat_ids']);

        $gia_ve_co_ban = $cart['details']['GiaVe'];
        $gia_ve_vip = $gia_ve_co_ban * 1.2;

        foreach ($idGheArray as $idGhe) {
            $ghe = $gheDAO->getGheById((int)$idGhe);
            $giaVe = ($ghe->getLoaiGhe() == 'VIP') ? $gia_ve_vip : $gia_ve_co_ban;

            $ctdv = new ChiTietDatVe();
            $ctdv->setIdDonDatVe($new_dondatve_id);
            $ctdv->setIdGhe((int)$idGhe);
            $ctdv->setGiaVe($giaVe);
            
            $ctdvDAO->themChiTiet($ctdv);
        }
        $ctdvDAO->closeConnection();

        return $new_dondatve_id;
    }
}
?>