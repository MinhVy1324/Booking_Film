<?php
// File: BACKEND/BUS/PhimBUS.php

include_once __DIR__ . '/../DAO/PhimDAO.php';
include_once __DIR__ . '/../DTO/Phim.php';

class PhimBUS {
    private $phimDAO;

    public function __construct() {
        $this->phimDAO = new PhimDAO();
    }

    /**
     * Xử lý nghiệp vụ thêm phim mới
     * @return array ['status' => bool, 'message' => string]
     */
    public function xuLyThemPhim($tenPhim, $moTa, $ngayKhoiChieu, $thoiLuong, $posterUrl, $theLoai, $xepHang) {
        // LUẬT 1: Tên phim không được để trống
        if (empty(trim($tenPhim))) {
            return ['status' => false, 'message' => 'Tên phim không được để trống.'];
        }

        // LUẬT 2: Thời lượng phải là số dương
        if (!is_numeric($thoiLuong) || (int)$thoiLuong <= 0) {
            return ['status' => false, 'message' => 'Thời lượng phải là một số dương.'];
        }

        // Tất cả luật đã OK
        $phim = new Phim();
        $phim->setTenPhim($tenPhim);
        $phim->setMoTa($moTa);
        $phim->setNgayKhoiChieu($ngayKhoiChieu);
        $phim->setThoiLuong((int)$thoiLuong);
        $phim->setPosterUrl($posterUrl);
        $phim->setTheLoai($theLoai);
        $phim->setXepHang($xepHang);

        if ($this->phimDAO->themPhim($phim)) {
            return ['status' => true, 'message' => 'add_success'];
        } else {
            return ['status' => false, 'message' => 'error'];
        }
    }
}
?>