<?php
// File: backend/MODEL/DonDatVe.php

class DonDatVe {
    private $Id;
    private $NgayDat;
    private $TongTien;
    private $TrangThai;
    private $IdNguoiDung;
    private $IdSuatChieu;

    // Getters
    public function getId() { 
        return $this->Id; 
    }

    public function getNgayDat() { 
        return $this->NgayDat; 
    }

    public function getTongTien() { 
        return $this->TongTien; 
    }

    public function getTrangThai() { 
        return $this->TrangThai; 
    }

    public function getIdNguoiDung() { 
        return $this->IdNguoiDung; 
    }

    public function getIdSuatChieu() { 
        return $this->IdSuatChieu; 
    }

    // Setters
    public function setId($id) { 
        $this->Id = $id; 
    }

    public function setNgayDat($ngay) { 
        $this->NgayDat = $ngay; 
    }

    public function setTongTien($tien) { 
        $this->TongTien = $tien; 
    }

    public function setTrangThai($tt) { 
        $this->TrangThai = $tt; 
    }

    public function setIdNguoiDung($id) { 
        $this->IdNguoiDung = $id; 
    }
    
    public function setIdSuatChieu($id) { 
        $this->IdSuatChieu = $id; 
    }
}
?>