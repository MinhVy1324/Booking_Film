<?php
// File: backend/MODEL/SuatChieu.php

class SuatChieu {
    private $Id;
    private $NgayChieu;
    private $GioBatDau;
    private $GiaVe;
    private $IdPhim;
    private $IdPhongChieu;

    // Getters
    public function getId() {
        return $this->Id;
    }

    public function getNgayChieu() {
        return $this->NgayChieu;
    }

    public function getGioBatDau() {
        return $this->GioBatDau;
    }

    public function getGiaVe() {
        return $this->GiaVe;
    }

    public function getIdPhim() {
        return $this->IdPhim;
    }

    public function getIdPhongChieu() {
        return $this->IdPhongChieu;
    }

    // Setters
    public function setId($id) {
        $this->Id = $id;
    }

    public function setNgayChieu($ngay) {
        $this->NgayChieu = $ngay;
    }

    public function setGioBatDau($gio) {
        $this->GioBatDau = $gio;
    }

    public function setGiaVe($gia) {
        $this->GiaVe = $gia;
    }

    public function setIdPhim($idPhim) {
        $this->IdPhim = $idPhim;
    }

    public function setIdPhongChieu($idPhong) {
        $this->IdPhongChieu = $idPhong;
    }
}
