<?php
// File: backend/dto/NguoiDung.php

class NguoiDung {
    
    // 1. Thuộc tính (Attributes)
    // Phải là 'private' để đảm bảo tính đóng gói (Encapsulation)
    private $Id;
    private $HoTen;
    private $Email;
    private $MatKhau; // Sẽ là mật khẩu đã được hash
    private $LoaiNguoiDung;

    // 2. Phương thức (Methods): Getters và Setters
    // Dùng để truy cập và gán giá trị cho thuộc tính private

    public function getId() {
        return $this->Id;
    }
    public function setId($id) {
        $this->Id = $id;
    }

    public function getHoTen() {
        return $this->HoTen;
    }
    public function setHoTen($hoTen) {
        $this->HoTen = $hoTen;
    }

    public function getEmail() {
        return $this->Email;
    }
    public function setEmail($email) {
        $this->Email = $email;
    }

    public function getMatKhau() {
        return $this->MatKhau;
    }
    public function setMatKhau($matKhau) {
        $this->MatKhau = $matKhau;
    }

    public function getLoaiNguoiDung() {
        return $this->LoaiNguoiDung;
    }
    public function setLoaiNguoiDung($loai) {
        $this->LoaiNguoiDung = $loai;
    }
}
?>