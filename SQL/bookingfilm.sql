-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 04, 2025 lúc 05:14 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bookingfilm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdatve`
--

CREATE TABLE `chitietdatve` (
  `Id` int(11) NOT NULL,
  `GiaVe` decimal(10,0) NOT NULL,
  `IdDonDatVe` int(11) DEFAULT NULL,
  `IdGhe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdatve`
--

INSERT INTO `chitietdatve` (`Id`, `GiaVe`, `IdDonDatVe`, `IdGhe`) VALUES
(1, 120000, 1, 1),
(2, 120000, 1, 2),
(3, 110000, 2, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondatve`
--

CREATE TABLE `dondatve` (
  `Id` int(11) NOT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `TongTien` decimal(10,0) NOT NULL,
  `TrangThai` varchar(50) DEFAULT 'DaThanhToan',
  `IdNguoiDung` int(11) DEFAULT NULL,
  `IdSuatChieu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dondatve`
--

INSERT INTO `dondatve` (`Id`, `NgayDat`, `TongTien`, `TrangThai`, `IdNguoiDung`, `IdSuatChieu`) VALUES
(1, '2025-10-30 22:41:18', 240000, 'DaThanhToan', 1, 1),
(2, '2025-10-30 22:41:18', 110000, 'DaThanhToan', 1, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ghe`
--

CREATE TABLE `ghe` (
  `Id` int(11) NOT NULL,
  `TenGhe` varchar(10) NOT NULL,
  `LoaiGhe` varchar(20) DEFAULT 'Thuong',
  `IdPhongChieu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ghe`
--

INSERT INTO `ghe` (`Id`, `TenGhe`, `LoaiGhe`, `IdPhongChieu`) VALUES
(1, 'A1', 'Thuong', 1),
(2, 'A2', 'Thuong', 1),
(3, 'A3', 'Thuong', 1),
(4, 'B1', 'VIP', 1),
(5, 'B2', 'VIP', 1),
(6, 'C1', 'Thuong', 3),
(7, 'C2', 'Thuong', 3),
(8, 'C3', 'Thuong', 3),
(9, 'D1', 'VIP', 3),
(10, 'D2', 'VIP', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `Id` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `LoaiNguoiDung` varchar(20) DEFAULT 'KhachHang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`Id`, `HoTen`, `Email`, `MatKhau`, `SoDienThoai`, `LoaiNguoiDung`) VALUES
(1, 'Khách Hàng A', 'user@gmail.com', '123456', NULL, 'KhachHang'),
(2, 'Quản Trị Viên', 'admin@gmail.com', 'admin123', NULL, 'QuanTri');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phim`
--

CREATE TABLE `phim` (
  `Id` int(11) NOT NULL,
  `TenPhim` varchar(255) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `TheLoai` varchar(100) DEFAULT NULL,
  `ThoiLuong` int(11) DEFAULT NULL,
  `NgayKhoiChieu` date DEFAULT NULL,
  `PosterUrl` varchar(255) DEFAULT NULL,
  `XepHang` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phim`
--

INSERT INTO `phim` (`Id`, `TenPhim`, `MoTa`, `TheLoai`, `ThoiLuong`, `NgayKhoiChieu`, `PosterUrl`, `XepHang`) VALUES
(1, 'Lật Mặt 7: Một Điều Ước', 'Phim của Lý Hải. Một câu chuyện cảm động về gia đình, khi người mẹ 73 tuổi gặp nạn và cần sự chăm sóc của 5 người con.', 'Gia đình, Hành động', 130, '2025-10-10', 'https://via.placeholder.com/200x300.png?text=Lat+Mat+7', 'C16'),
(2, 'Kẻ Trộm Mặt Trăng 4', 'Gru và các Minion trở lại trong một cuộc phiêu lưu mới, đối mặt với một kẻ thù cũ và một thành viên mới trong gia đình.', 'Hoạt hình, Hài', 95, '2025-10-15', 'https://via.placeholder.com/200x300.png?text=Despicable+Me+4', 'P'),
(3, 'Gã Điên: Điệu Nhảy Của Hai Người', 'Phần tiếp theo của JOKER, khám phá mối quan hệ phức tạp giữa Arthur Fleck và Harley Quinn tại nhà thương điên Arkham.', 'Tâm lý, Nhạc kịch', 160, '2025-10-04', 'https://via.placeholder.com/200x300.png?text=Joker+2', 'C18'),
(4, 'Quái Vật Săn Đêm', 'Một nhóm bạn trẻ bị mắc kẹt trong một khu rừng và bị săn đuổi bởi một sinh vật cổ đại bí ẩn.', 'Kinh dị', 105, '2025-11-07', 'https://via.placeholder.com/200x300.png?text=Horror+Movie', 'C18'),
(5, 'Cuộc Phiêu Lưu Giáng Sinh', 'Một bộ phim gia đình ấm áp về hành trình của một cậu bé giúp đỡ ông già Noel tìm lại phép thuật đã mất.', 'Gia đình, Phiêu lưu', 90, '2025-12-05', 'https://via.placeholder.com/200x300.png?text=Christmas+Movie', 'P');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongchieu`
--

CREATE TABLE `phongchieu` (
  `Id` int(11) NOT NULL,
  `TenPhong` varchar(50) NOT NULL,
  `SoLuongGhe` int(11) DEFAULT NULL,
  `IdRap` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phongchieu`
--

INSERT INTO `phongchieu` (`Id`, `TenPhong`, `SoLuongGhe`, `IdRap`) VALUES
(1, 'Phòng 1', 100, 1),
(2, 'Phòng 2', 120, 1),
(3, 'Phòng 1', 80, 2),
(4, 'Phòng 2', 90, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rap`
--

CREATE TABLE `rap` (
  `Id` int(11) NOT NULL,
  `TenRap` varchar(100) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rap`
--

INSERT INTO `rap` (`Id`, `TenRap`, `DiaChi`) VALUES
(1, 'CGV Hùng Vương', 'Lầu 7, 126 Hùng Vương, P.12, Q.5, TP.HCM'),
(2, 'BHD Bitexco', 'Lầu 3, TTTM Bitexco, 2 Hải Triều, Q.1, TP.HCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suatchieu`
--

CREATE TABLE `suatchieu` (
  `Id` int(11) NOT NULL,
  `NgayChieu` date NOT NULL,
  `GioBatDau` time NOT NULL,
  `DinhDang` varchar(10) DEFAULT '2D',
  `GiaVe` decimal(10,0) NOT NULL,
  `IdPhim` int(11) DEFAULT NULL,
  `IdPhongChieu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `suatchieu`
--

INSERT INTO `suatchieu` (`Id`, `NgayChieu`, `GioBatDau`, `DinhDang`, `GiaVe`, `IdPhim`, `IdPhongChieu`) VALUES
(1, '2025-10-30', '19:30:00', '2D', 120000, 1, 1),
(2, '2025-10-30', '20:00:00', '2D', 150000, 1, 2),
(3, '2025-10-30', '19:45:00', '2D', 110000, 2, 3),
(4, '2025-10-31', '21:00:00', '2D', 180000, 3, 4);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdatve`
--
ALTER TABLE `chitietdatve`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdDonDatVe` (`IdDonDatVe`),
  ADD KEY `IdGhe` (`IdGhe`);

--
-- Chỉ mục cho bảng `dondatve`
--
ALTER TABLE `dondatve`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdNguoiDung` (`IdNguoiDung`),
  ADD KEY `IdSuatChieu` (`IdSuatChieu`);

--
-- Chỉ mục cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPhongChieu` (`IdPhongChieu`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `phim`
--
ALTER TABLE `phim`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `phongchieu`
--
ALTER TABLE `phongchieu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdRap` (`IdRap`);

--
-- Chỉ mục cho bảng `rap`
--
ALTER TABLE `rap`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `suatchieu`
--
ALTER TABLE `suatchieu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPhim` (`IdPhim`),
  ADD KEY `IdPhongChieu` (`IdPhongChieu`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdatve`
--
ALTER TABLE `chitietdatve`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `dondatve`
--
ALTER TABLE `dondatve`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ghe`
--
ALTER TABLE `ghe`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phim`
--
ALTER TABLE `phim`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phongchieu`
--
ALTER TABLE `phongchieu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `rap`
--
ALTER TABLE `rap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `suatchieu`
--
ALTER TABLE `suatchieu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdatve`
--
ALTER TABLE `chitietdatve`
  ADD CONSTRAINT `chitietdatve_ibfk_1` FOREIGN KEY (`IdDonDatVe`) REFERENCES `dondatve` (`Id`),
  ADD CONSTRAINT `chitietdatve_ibfk_2` FOREIGN KEY (`IdGhe`) REFERENCES `ghe` (`Id`);

--
-- Các ràng buộc cho bảng `dondatve`
--
ALTER TABLE `dondatve`
  ADD CONSTRAINT `dondatve_ibfk_1` FOREIGN KEY (`IdNguoiDung`) REFERENCES `nguoidung` (`Id`),
  ADD CONSTRAINT `dondatve_ibfk_2` FOREIGN KEY (`IdSuatChieu`) REFERENCES `suatchieu` (`Id`);

--
-- Các ràng buộc cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD CONSTRAINT `ghe_ibfk_1` FOREIGN KEY (`IdPhongChieu`) REFERENCES `phongchieu` (`Id`);

--
-- Các ràng buộc cho bảng `phongchieu`
--
ALTER TABLE `phongchieu`
  ADD CONSTRAINT `phongchieu_ibfk_1` FOREIGN KEY (`IdRap`) REFERENCES `rap` (`Id`);

--
-- Các ràng buộc cho bảng `suatchieu`
--
ALTER TABLE `suatchieu`
  ADD CONSTRAINT `suatchieu_ibfk_1` FOREIGN KEY (`IdPhim`) REFERENCES `phim` (`Id`),
  ADD CONSTRAINT `suatchieu_ibfk_2` FOREIGN KEY (`IdPhongChieu`) REFERENCES `phongchieu` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
