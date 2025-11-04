<?php
// File: BACKEND/BUS/SuatChieuBUS.php

include_once __DIR__ . '/../DAO/SuatChieuDAO.php';
include_once __DIR__ . '/../DTO/SuatChieu.php';

class SuatChieuBUS {
    private function validate($ngayChieu, $gioBatDau, $giaVe) {
        // LUẬT 1: Giá vé phải là số dương
        if (!is_numeric($giaVe) || (int)$giaVe <= 0) {
            return false;
        }

        // LUẬT 2: Không được tạo suất chiếu trong quá khứ
        $thoiGianChieu = new DateTime($ngayChieu . ' ' . $gioBatDau);
        $thoiGianHienTai = new DateTime();
        if ($thoiGianChieu < $thoiGianHienTai) {
            return false;
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
        if (!$this->validate($ngayChieu, $gioBatDau, $giaVe)) {
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
}
?>