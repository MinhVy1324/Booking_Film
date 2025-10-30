<?php
// File: backend/MODEL/Phim.php

class Phim {
    private $Id;
    private $TenPhim;
    private $MoTa;
    private $TheLoai;
    private $ThoiLuong;
    private $NgayKhoiChieu;
    private $PosterUrl;
    private $XepHang;

    // Getters
    public function getId() { return $this->Id; }
    public function getTenPhim() { return $this->TenPhim; }
    public function getMoTa() { return $this->MoTa; }
    public function getTheLoai() { return $this->TheLoai; }
    public function getThoiLuong() { return $this->ThoiLuong; }
    public function getNgayKhoiChieu() { return $this->NgayKhoiChieu; }
    public function getPosterUrl() { return $this->PosterUrl; }
    public function getXepHang() { return $this->XepHang; }

    // Setters
    public function setId($id) { $this->Id = $id; }
    public function setTenPhim($tenPhim) { $this->TenPhim = $tenPhim; }
    public function setMoTa($moTa) { $this->MoTa = $moTa; }
    public function setTheLoai($theLoai) { $this->TheLoai = $theLoai; }
    public function setThoiLuong($thoiLuong) { $this->ThoiLuong = $thoiLuong; }
    public function setNgayKhoiChieu($ngay) { $this->NgayKhoiChieu = $ngay; }
    public function setPosterUrl($url) { $this->PosterUrl = $url; }
    public function setXepHang($xepHang) { $this->XepHang = $xepHang; }
}
?>