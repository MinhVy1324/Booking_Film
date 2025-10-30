<?php
// File: backend/MODEL/PhongChieu.php

class PhongChieu {
    private $Id;
    private $TenPhong;
    private $SoLuongGhe;
    private $IdRap;

    // Getters
    public function getId() { return $this->Id; }
    public function getTenPhong() { return $this->TenPhong; }
    public function getSoLuongGhe() { return $this->SoLuongGhe; }
    public function getIdRap() { return $this->IdRap; }

    // Setters
    public function setId($id) { $this->Id = $id; }
    public function setTenPhong($ten) { $this->TenPhong = $ten; }
    public function setSoLuongGhe($sl) { $this->SoLuongGhe = $sl; }
    public function setIdRap($idRap) { $this->IdRap = $idRap; }
}
?>