<?php
// File: backend/MODEL/Rap.php

class Rap {
    private $Id;
    private $TenRap;
    private $DiaChi;

    // Getters
    public function getId() { return $this->Id; }
    public function getTenRap() { return $this->TenRap; }
    public function getDiaChi() { return $this->DiaChi; }

    // Setters
    public function setId($id) { $this->Id = $id; }
    public function setTenRap($ten) { $this->TenRap = $ten; }
    public function setDiaChi($diaChi) { $this->DiaChi = $diaChi; }
}
?>