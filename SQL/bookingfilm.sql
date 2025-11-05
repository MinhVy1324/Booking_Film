-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 05, 2025 lúc 07:18 AM
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
(3, 110000, 2, 6),
(4, 120000, 3, 123),
(5, 120000, 3, 124),
(6, 120000, 4, 125),
(7, 120000, 4, 126),
(8, 120000, 5, 91),
(9, 120000, 5, 100);

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
(2, '2025-10-30 22:41:18', 110000, 'DaThanhToan', 1, 3),
(3, '2025-11-05 01:11:46', 240000, 'DaThanhToan', 3, 1),
(4, '2025-11-05 01:13:43', 240000, 'DaThanhToan', 3, 1),
(5, '2025-11-05 02:59:07', 240000, 'DaThanhToan', 4, 1);

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
(6, 'C1', 'Thuong', 3),
(7, 'C2', 'Thuong', 3),
(8, 'C3', 'Thuong', 3),
(9, 'D1', 'VIP', 3),
(10, 'D2', 'VIP', 3),
(91, 'A1', 'Thuong', 1),
(92, 'A2', 'Thuong', 1),
(93, 'A3', 'Thuong', 1),
(94, 'A4', 'Thuong', 1),
(95, 'A5', 'Thuong', 1),
(96, 'A6', 'Thuong', 1),
(97, 'A7', 'Thuong', 1),
(98, 'A8', 'Thuong', 1),
(99, 'A9', 'Thuong', 1),
(100, 'A10', 'Thuong', 1),
(101, 'B1', 'Thuong', 1),
(102, 'B2', 'Thuong', 1),
(103, 'B3', 'Thuong', 1),
(104, 'B4', 'Thuong', 1),
(105, 'B5', 'Thuong', 1),
(106, 'B6', 'Thuong', 1),
(107, 'B7', 'Thuong', 1),
(108, 'B8', 'Thuong', 1),
(109, 'B9', 'Thuong', 1),
(110, 'B10', 'Thuong', 1),
(111, 'C1', 'Thuong', 1),
(112, 'C2', 'Thuong', 1),
(113, 'C3', 'Thuong', 1),
(114, 'C4', 'Thuong', 1),
(115, 'C5', 'Thuong', 1),
(116, 'C6', 'Thuong', 1),
(117, 'C7', 'Thuong', 1),
(118, 'C8', 'Thuong', 1),
(119, 'C9', 'Thuong', 1),
(120, 'C10', 'Thuong', 1),
(121, 'D1', 'Thuong', 1),
(122, 'D2', 'Thuong', 1),
(123, 'D3', 'Thuong', 1),
(124, 'D4', 'Thuong', 1),
(125, 'D5', 'Thuong', 1),
(126, 'D6', 'Thuong', 1),
(127, 'D7', 'Thuong', 1),
(128, 'D8', 'Thuong', 1),
(129, 'D9', 'Thuong', 1),
(130, 'D10', 'Thuong', 1),
(131, 'E1', 'Thuong', 1),
(132, 'E2', 'Thuong', 1),
(133, 'E3', 'Thuong', 1),
(134, 'E4', 'Thuong', 1),
(135, 'E5', 'Thuong', 1),
(136, 'E6', 'Thuong', 1),
(137, 'E7', 'Thuong', 1),
(138, 'E8', 'Thuong', 1),
(139, 'E9', 'Thuong', 1),
(140, 'E10', 'Thuong', 1),
(141, 'F1', 'Thuong', 1),
(142, 'F2', 'Thuong', 1),
(143, 'F3', 'Thuong', 1),
(144, 'F4', 'Thuong', 1),
(145, 'F5', 'Thuong', 1),
(146, 'F6', 'Thuong', 1),
(147, 'F7', 'Thuong', 1),
(148, 'F8', 'Thuong', 1),
(149, 'F9', 'Thuong', 1),
(150, 'F10', 'Thuong', 1),
(151, 'G1', 'VIP', 1),
(152, 'G2', 'VIP', 1),
(153, 'G3', 'VIP', 1),
(154, 'G4', 'VIP', 1),
(155, 'G5', 'VIP', 1),
(156, 'G6', 'VIP', 1),
(157, 'G7', 'VIP', 1),
(158, 'G8', 'VIP', 1),
(159, 'G9', 'VIP', 1),
(160, 'G10', 'VIP', 1),
(161, 'H1', 'VIP', 1),
(162, 'H2', 'VIP', 1),
(163, 'H3', 'VIP', 1),
(164, 'H4', 'VIP', 1),
(165, 'H5', 'VIP', 1),
(166, 'H6', 'VIP', 1),
(167, 'H7', 'VIP', 1),
(168, 'H8', 'VIP', 1),
(169, 'H9', 'VIP', 1),
(170, 'H10', 'VIP', 1),
(171, 'I1', 'VIP', 4),
(172, 'I2, I3, I4', 'VIP', 4),
(173, 'I1', 'VIP', 1),
(174, 'I2', 'VIP', 1),
(175, 'A1', 'Thuong', 8),
(176, 'A2', 'Thuong', 8),
(177, 'A3', 'Thuong', 8),
(178, 'A4', 'Thuong', 8),
(179, 'A5', 'Thuong', 8),
(180, 'A6', 'Thuong', 8),
(181, 'A7', 'Thuong', 8),
(182, 'A8', 'Thuong', 8),
(183, 'A9', 'Thuong', 8),
(184, 'A10', 'Thuong', 8),
(185, 'B1', 'Thuong', 8),
(186, 'B2', 'Thuong', 8),
(187, 'B3', 'Thuong', 8),
(188, 'B4', 'Thuong', 8),
(189, 'B5', 'Thuong', 8),
(190, 'B6', 'Thuong', 8),
(191, 'B7', 'Thuong', 8),
(192, 'B8', 'Thuong', 8),
(193, 'B9', 'Thuong', 8),
(194, 'B10', 'Thuong', 8),
(195, 'C1', 'Thuong', 8),
(196, 'C2', 'Thuong', 8),
(197, 'C3', 'Thuong', 8),
(198, 'C4', 'Thuong', 8),
(199, 'C5', 'Thuong', 8),
(200, 'C6', 'Thuong', 8),
(201, 'C7', 'Thuong', 8),
(202, 'C8', 'Thuong', 8),
(203, 'C9', 'Thuong', 8),
(204, 'C10', 'Thuong', 8),
(205, 'D1', 'Thuong', 8),
(206, 'D2', 'Thuong', 8),
(207, 'D3', 'Thuong', 8),
(208, 'D4', 'Thuong', 8),
(209, 'D5', 'Thuong', 8),
(210, 'D6', 'Thuong', 8),
(211, 'D7', 'Thuong', 8),
(212, 'D8', 'Thuong', 8),
(213, 'D9', 'Thuong', 8),
(214, 'D10', 'Thuong', 8),
(215, 'E1', 'Thuong', 8),
(216, 'E2', 'Thuong', 8),
(217, 'E3', 'Thuong', 8),
(218, 'E4', 'Thuong', 8),
(219, 'E5', 'Thuong', 8),
(220, 'E6', 'Thuong', 8),
(221, 'E7', 'Thuong', 8),
(222, 'E8', 'Thuong', 8),
(223, 'E9', 'Thuong', 8),
(224, 'E10', 'Thuong', 8),
(225, 'F1', 'Thuong', 8),
(226, 'F2', 'Thuong', 8),
(227, 'F3', 'Thuong', 8),
(228, 'F4', 'Thuong', 8),
(229, 'F5', 'Thuong', 8),
(230, 'F6', 'Thuong', 8),
(231, 'F7', 'Thuong', 8),
(232, 'F8', 'Thuong', 8),
(233, 'F9', 'Thuong', 8),
(234, 'F10', 'Thuong', 8),
(235, 'G1', 'VIP', 8),
(236, 'G2', 'VIP', 8),
(237, 'G3', 'VIP', 8),
(238, 'G4', 'VIP', 8),
(239, 'G5', 'VIP', 8),
(240, 'G6', 'VIP', 8),
(241, 'G7', 'VIP', 8),
(242, 'G8', 'VIP', 8),
(243, 'G9', 'VIP', 8),
(244, 'G10', 'VIP', 8),
(245, 'H1', 'VIP', 8),
(246, 'H2', 'VIP', 8),
(247, 'H3', 'VIP', 8),
(248, 'H4', 'VIP', 8),
(249, 'H5', 'VIP', 8),
(250, 'H6', 'VIP', 8),
(251, 'H7', 'VIP', 8),
(252, 'H8', 'VIP', 8),
(253, 'H9', 'VIP', 8),
(254, 'H10', 'VIP', 8),
(255, 'I1', 'VIP', 8),
(256, 'I2', 'VIP', 8),
(257, 'I3', 'VIP', 8),
(258, 'I4', 'VIP', 8),
(259, 'I5', 'VIP', 8),
(260, 'I6', 'VIP', 8),
(261, 'I7', 'VIP', 8),
(262, 'I8', 'VIP', 8),
(263, 'I9', 'VIP', 8),
(264, 'I10', 'VIP', 8),
(265, 'J1', 'VIP', 8),
(266, 'J2', 'VIP', 8),
(267, 'J3', 'VIP', 8),
(268, 'J4', 'VIP', 8),
(269, 'J5', 'VIP', 8),
(270, 'J6', 'VIP', 8),
(271, 'J7', 'VIP', 8),
(272, 'J8', 'VIP', 8),
(273, 'J9', 'VIP', 8),
(274, 'J10', 'VIP', 8);

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
(2, 'Quản Trị Viên', 'admin@gmail.com', 'admin123', NULL, 'QuanTri'),
(3, 'Nguyen Dang', 'admin1@gmail.com', '$2y$10$7oXkmIWhE.omoAqF6tlOs.MU60BEwFEzDaRgq0dNsVy48FLKq/ZUW', NULL, 'QuanTri'),
(4, 'NgDang', 'user1@gmail.com', '$2y$10$k.qxQo8SOKZ5GtsUf0qy2u0jp2U/QpEYZjYywdW4qqhlbrDltbkCG', NULL, 'KhachHang');

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
(4, 'Phòng 2', 90, 2),
(5, 'Phòng 3', 150, 1),
(8, 'Phòng 4', 100, 1);

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
(1, '2025-11-05', '19:30:00', '2D', 120000, 1, 1),
(2, '2025-10-30', '20:00:00', '2D', 150000, 1, 2),
(3, '2025-10-30', '19:45:00', '2D', 110000, 2, 3),
(4, '2025-11-05', '21:00:00', '2D', 180000, 1, 8);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `dondatve`
--
ALTER TABLE `dondatve`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ghe`
--
ALTER TABLE `ghe`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `phim`
--
ALTER TABLE `phim`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phongchieu`
--
ALTER TABLE `phongchieu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
