<?php
// File: BACKEND/DTO/Ghe.php

class Ghe {
    
    // Thuộc tính (giống hệt các cột trong CSDL)
    private $Id;
    private $TenGhe;
    private $LoaiGhe; // 'Thuong' hoặc 'VIP'
    private $IdPhongChieu;

    // --- Getters ---
    public function getId() {
        return $this->Id;
    }
    public function getTenGhe() {
        return $this->TenGhe;
    }
    public function getLoaiGhe() {
        return $this->LoaiGhe;
    }
    public function getIdPhongChieu() {
        return $this->IdPhongChieu;
    }

    // --- Setters ---
    public function setId($id) {
        $this->Id = $id;
    }
    public function setTenGhe($ten) {
        $this->TenGhe = $ten;
    }
    public function setLoaiGhe($loai) {
        $this->LoaiGhe = $loai;
    }
    public function setIdPhongChieu($id) {
        $this->IdPhongChieu = $id;
    }
}
?>