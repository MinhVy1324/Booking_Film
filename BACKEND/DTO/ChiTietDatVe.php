<?php
// File: backend/MODEL/ChiTietDatVe.php

class ChiTietDatVe {
    private $Id;
    private $GiaVe;
    private $IdDonDatVe;
    private $IdGhe;

    // Getters
    public function getId() { return $this->Id; }
    public function getGiaVe() { return $this->GiaVe; }
    public function getIdDonDatVe() { return $this->IdDonDatVe; }
    public function getIdGhe() { return $this->IdGhe; }

    // Setters
    public function setId($id) { $this->Id = $id; }
    public function setGiaVe($gia) { $this->GiaVe = $gia; }
    public function setIdDonDatVe($id) { $this->IdDonDatVe = $id; }
    public function setIdGhe($id) { $this->IdGhe = $id; }
}
?>