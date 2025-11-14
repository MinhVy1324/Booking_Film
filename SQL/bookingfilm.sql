-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2025 lúc 02:05 PM
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
(9, 120000, 5, 100),
(10, 144000, 6, 166),
(11, 144000, 6, 167),
(12, 144000, 7, 151),
(13, 144000, 7, 152),
(14, 80000, 8, 131),
(15, 80000, 8, 132);

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
(5, '2025-11-05 02:59:07', 240000, 'DaThanhToan', 4, 1),
(6, '2025-11-05 13:26:33', 288000, 'DaThanhToan', 4, 1),
(7, '2025-11-05 13:26:53', 288000, 'DaThanhToan', 4, 1),
(8, '2025-11-10 15:39:24', 160000, 'DaThanhToan', 3, 6);

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
(274, 'J10', 'VIP', 8),
(275, 'I3', 'VIP', 1),
(276, 'I4', 'VIP', 1),
(278, 'I6', 'VIP', 1),
(279, 'I7', 'VIP', 1),
(280, 'I8', 'VIP', 1),
(281, 'I9', 'VIP', 1),
(282, 'I10', 'VIP', 1),
(283, 'I5', 'VIP', 1),
(284, 'A1', 'Thuong', 9),
(285, 'A2', 'Thuong', 9),
(286, 'A3', 'Thuong', 9),
(287, 'A4', 'Thuong', 9),
(288, 'A5', 'Thuong', 9),
(289, 'A6', 'Thuong', 9),
(290, 'A7', 'Thuong', 9),
(291, 'A8', 'Thuong', 9),
(292, 'A9', 'Thuong', 9),
(293, 'A10', 'Thuong', 9),
(294, 'A11', 'Thuong', 9),
(295, 'A12', 'Thuong', 9),
(296, 'A13', 'Thuong', 9),
(297, 'A14', 'Thuong', 9),
(298, 'A15', 'Thuong', 9),
(299, 'A16', 'Thuong', 9),
(300, 'A17', 'Thuong', 9),
(301, 'A18', 'Thuong', 9),
(302, 'A19', 'Thuong', 9),
(303, 'A20', 'Thuong', 9),
(304, 'B1', 'Thuong', 9),
(305, 'B2', 'Thuong', 9),
(306, 'B3', 'Thuong', 9),
(307, 'B4', 'Thuong', 9),
(308, 'B5', 'Thuong', 9),
(309, 'B6', 'Thuong', 9),
(310, 'B7', 'Thuong', 9),
(311, 'B8', 'Thuong', 9),
(312, 'B9', 'Thuong', 9),
(313, 'B10', 'Thuong', 9),
(314, 'B11', 'Thuong', 9),
(315, 'B12', 'Thuong', 9),
(316, 'B13', 'Thuong', 9),
(317, 'B14', 'Thuong', 9),
(318, 'B15', 'Thuong', 9),
(319, 'B16', 'Thuong', 9),
(320, 'B17', 'Thuong', 9),
(321, 'B18', 'Thuong', 9),
(322, 'B19', 'Thuong', 9),
(323, 'B20', 'Thuong', 9),
(324, 'C1', 'Thuong', 9),
(325, 'C2', 'Thuong', 9),
(326, 'C3', 'Thuong', 9),
(327, 'C4', 'Thuong', 9),
(328, 'C5', 'Thuong', 9),
(329, 'C6', 'Thuong', 9),
(330, 'C7', 'Thuong', 9),
(331, 'C8', 'Thuong', 9),
(332, 'C9', 'Thuong', 9),
(333, 'C10', 'Thuong', 9),
(334, 'C11', 'Thuong', 9),
(335, 'C12', 'Thuong', 9),
(336, 'C13', 'Thuong', 9),
(337, 'C14', 'Thuong', 9),
(338, 'C15', 'Thuong', 9),
(339, 'C16', 'Thuong', 9),
(340, 'C17', 'Thuong', 9),
(341, 'C18', 'Thuong', 9),
(342, 'C19', 'Thuong', 9),
(343, 'C20', 'Thuong', 9),
(344, 'D1', 'Thuong', 9),
(345, 'D2', 'Thuong', 9),
(346, 'D3', 'Thuong', 9),
(347, 'D4', 'Thuong', 9),
(348, 'D5', 'Thuong', 9),
(349, 'D6', 'Thuong', 9),
(350, 'D7', 'Thuong', 9),
(351, 'D8', 'Thuong', 9),
(352, 'D9', 'Thuong', 9),
(353, 'D10', 'Thuong', 9),
(354, 'D11', 'Thuong', 9),
(355, 'D12', 'Thuong', 9),
(356, 'D13', 'Thuong', 9),
(357, 'D14', 'Thuong', 9),
(358, 'D15', 'Thuong', 9),
(359, 'D16', 'Thuong', 9),
(360, 'D17', 'Thuong', 9),
(361, 'D18', 'Thuong', 9),
(362, 'D19', 'Thuong', 9),
(363, 'D20', 'Thuong', 9),
(364, 'E1', 'Thuong', 9),
(365, 'E2', 'Thuong', 9),
(366, 'E3', 'Thuong', 9),
(367, 'E4', 'Thuong', 9),
(368, 'E5', 'Thuong', 9),
(369, 'E6', 'Thuong', 9),
(370, 'E7', 'Thuong', 9),
(371, 'E8', 'Thuong', 9),
(372, 'E9', 'Thuong', 9),
(373, 'E10', 'Thuong', 9),
(374, 'E11', 'Thuong', 9),
(375, 'E12', 'Thuong', 9),
(376, 'E13', 'Thuong', 9),
(377, 'E14', 'Thuong', 9),
(378, 'E15', 'Thuong', 9),
(379, 'E16', 'Thuong', 9),
(380, 'E17', 'Thuong', 9),
(381, 'E18', 'Thuong', 9),
(382, 'E19', 'Thuong', 9),
(383, 'E20', 'Thuong', 9),
(384, 'F1', 'Thuong', 9),
(385, 'F2', 'Thuong', 9),
(386, 'F3', 'Thuong', 9),
(387, 'F4', 'Thuong', 9),
(388, 'F5', 'Thuong', 9),
(389, 'F6', 'Thuong', 9),
(390, 'F7', 'Thuong', 9),
(391, 'F8', 'Thuong', 9),
(392, 'F9', 'Thuong', 9),
(393, 'F10', 'Thuong', 9),
(394, 'F11', 'Thuong', 9),
(395, 'F12', 'Thuong', 9),
(396, 'F13', 'Thuong', 9),
(397, 'F14', 'Thuong', 9),
(398, 'F15', 'Thuong', 9),
(399, 'F16', 'Thuong', 9),
(400, 'F17', 'Thuong', 9),
(401, 'F18', 'Thuong', 9),
(402, 'F19', 'Thuong', 9),
(403, 'F20', 'Thuong', 9),
(404, 'G1', 'Thuong', 9),
(405, 'G2', 'Thuong', 9),
(406, 'G3', 'Thuong', 9),
(407, 'G4', 'Thuong', 9),
(408, 'G5', 'Thuong', 9),
(409, 'G6', 'Thuong', 9),
(410, 'G7', 'Thuong', 9),
(411, 'G8', 'Thuong', 9),
(412, 'G9', 'Thuong', 9),
(413, 'G10', 'Thuong', 9),
(414, 'G11', 'Thuong', 9),
(415, 'G12', 'Thuong', 9),
(416, 'G13', 'Thuong', 9),
(417, 'G14', 'Thuong', 9),
(418, 'G15', 'Thuong', 9),
(419, 'G16', 'Thuong', 9),
(420, 'G17', 'Thuong', 9),
(421, 'G18', 'Thuong', 9),
(422, 'G19', 'Thuong', 9),
(423, 'G20', 'Thuong', 9),
(424, 'H1', 'Thuong', 9),
(425, 'H2', 'Thuong', 9),
(426, 'H3', 'Thuong', 9),
(427, 'H4', 'Thuong', 9),
(428, 'H5', 'Thuong', 9),
(429, 'H6', 'Thuong', 9),
(430, 'H7', 'Thuong', 9),
(431, 'H8', 'Thuong', 9),
(432, 'H9', 'Thuong', 9),
(433, 'H10', 'Thuong', 9),
(434, 'H11', 'Thuong', 9),
(435, 'H12', 'Thuong', 9),
(436, 'H13', 'Thuong', 9),
(437, 'H14', 'Thuong', 9),
(438, 'H15', 'Thuong', 9),
(439, 'H16', 'Thuong', 9),
(440, 'H17', 'Thuong', 9),
(441, 'H18', 'Thuong', 9),
(442, 'H19', 'Thuong', 9),
(443, 'H20', 'Thuong', 9),
(444, 'I1', 'Thuong', 9),
(445, 'I2', 'Thuong', 9),
(446, 'I3', 'Thuong', 9),
(447, 'I4', 'Thuong', 9),
(448, 'I5', 'Thuong', 9),
(449, 'I6', 'Thuong', 9),
(450, 'I7', 'Thuong', 9),
(451, 'I8', 'Thuong', 9),
(452, 'I9', 'Thuong', 9),
(453, 'I10', 'Thuong', 9),
(454, 'I11', 'Thuong', 9),
(455, 'I12', 'Thuong', 9),
(456, 'I13', 'Thuong', 9),
(457, 'I14', 'Thuong', 9),
(458, 'I15', 'Thuong', 9),
(459, 'I16', 'Thuong', 9),
(460, 'I17', 'Thuong', 9),
(461, 'I18', 'Thuong', 9),
(462, 'I19', 'Thuong', 9),
(463, 'I20', 'Thuong', 9),
(464, 'J1', 'Thuong', 9),
(465, 'J2', 'Thuong', 9),
(466, 'J3', 'Thuong', 9),
(467, 'J4', 'Thuong', 9),
(468, 'J5', 'Thuong', 9),
(469, 'J6', 'Thuong', 9),
(470, 'J7', 'Thuong', 9),
(471, 'J8', 'Thuong', 9),
(472, 'J9', 'Thuong', 9),
(473, 'J10', 'Thuong', 9),
(474, 'J11', 'Thuong', 9),
(475, 'J12', 'Thuong', 9),
(476, 'J13', 'Thuong', 9),
(477, 'J14', 'Thuong', 9),
(478, 'J15', 'Thuong', 9),
(479, 'J16', 'Thuong', 9),
(480, 'J17', 'Thuong', 9),
(481, 'J18', 'Thuong', 9),
(482, 'J19', 'Thuong', 9),
(483, 'J20', 'Thuong', 9),
(484, 'K1', 'Thuong', 9),
(485, 'K2', 'Thuong', 9),
(486, 'K3', 'Thuong', 9),
(487, 'K4', 'Thuong', 9),
(488, 'K5', 'Thuong', 9),
(489, 'K6', 'Thuong', 9),
(490, 'K7', 'Thuong', 9),
(491, 'K8', 'Thuong', 9),
(492, 'K9', 'Thuong', 9),
(493, 'K10', 'Thuong', 9),
(494, 'K11', 'Thuong', 9),
(495, 'K12', 'Thuong', 9),
(496, 'K13', 'Thuong', 9),
(497, 'K14', 'Thuong', 9),
(498, 'K15', 'Thuong', 9),
(499, 'K16', 'Thuong', 9),
(500, 'K17', 'Thuong', 9),
(501, 'K18', 'Thuong', 9),
(502, 'K19', 'Thuong', 9),
(503, 'K20', 'Thuong', 9),
(504, 'L1', 'Thuong', 9),
(505, 'L2', 'Thuong', 9),
(506, 'L3', 'Thuong', 9),
(507, 'L4', 'Thuong', 9),
(508, 'L5', 'Thuong', 9),
(509, 'L6', 'Thuong', 9),
(510, 'L7', 'Thuong', 9),
(511, 'L8', 'Thuong', 9),
(512, 'L9', 'Thuong', 9),
(513, 'L10', 'Thuong', 9),
(514, 'L11', 'Thuong', 9),
(515, 'L12', 'Thuong', 9),
(516, 'L13', 'Thuong', 9),
(517, 'L14', 'Thuong', 9),
(518, 'L15', 'Thuong', 9),
(519, 'L16', 'Thuong', 9),
(520, 'L17', 'Thuong', 9),
(521, 'L18', 'Thuong', 9),
(522, 'L19', 'Thuong', 9),
(523, 'L20', 'Thuong', 9),
(524, 'M1', 'Thuong', 9),
(525, 'M2', 'Thuong', 9),
(526, 'M3', 'Thuong', 9),
(527, 'M4', 'Thuong', 9),
(528, 'M5', 'Thuong', 9),
(529, 'M6', 'Thuong', 9),
(530, 'M7', 'Thuong', 9),
(531, 'M8', 'Thuong', 9),
(532, 'M9', 'Thuong', 9),
(533, 'M10', 'Thuong', 9),
(534, 'M11', 'Thuong', 9),
(535, 'M12', 'Thuong', 9),
(536, 'M13', 'Thuong', 9),
(537, 'M14', 'Thuong', 9),
(538, 'M15', 'Thuong', 9),
(539, 'M16', 'Thuong', 9),
(540, 'M17', 'Thuong', 9),
(541, 'M18', 'Thuong', 9),
(542, 'M19', 'Thuong', 9),
(543, 'M20', 'Thuong', 9),
(544, 'N1', 'Thuong', 9),
(545, 'N2', 'Thuong', 9),
(546, 'N3', 'Thuong', 9),
(547, 'N4', 'Thuong', 9),
(548, 'N5', 'Thuong', 9),
(549, 'N6', 'Thuong', 9),
(550, 'N7', 'Thuong', 9),
(551, 'N8', 'Thuong', 9),
(552, 'N9', 'Thuong', 9),
(553, 'N10', 'Thuong', 9),
(554, 'N11', 'Thuong', 9),
(555, 'N12', 'Thuong', 9),
(556, 'N13', 'Thuong', 9),
(557, 'N14', 'Thuong', 9),
(558, 'N15', 'Thuong', 9),
(559, 'N16', 'Thuong', 9),
(560, 'N17', 'Thuong', 9),
(561, 'N18', 'Thuong', 9),
(562, 'N19', 'Thuong', 9),
(563, 'N20', 'Thuong', 9),
(564, 'O1', 'VIP', 9),
(565, 'O2', 'VIP', 9),
(566, 'O3', 'VIP', 9),
(567, 'O4', 'VIP', 9),
(568, 'O5', 'VIP', 9),
(569, 'O6', 'VIP', 9),
(570, 'O7', 'VIP', 9),
(571, 'O8', 'VIP', 9),
(572, 'O9', 'VIP', 9),
(573, 'O10', 'VIP', 9),
(574, 'O11', 'VIP', 9),
(575, 'O12', 'VIP', 9),
(576, 'O13', 'VIP', 9),
(577, 'O14', 'VIP', 9),
(578, 'O15', 'VIP', 9),
(579, 'O16', 'VIP', 9),
(580, 'O17', 'VIP', 9),
(581, 'O18', 'VIP', 9),
(582, 'O19', 'VIP', 9),
(583, 'O20', 'VIP', 9),
(584, 'P1', 'VIP', 9),
(585, 'P2', 'VIP', 9),
(586, 'P3', 'VIP', 9),
(587, 'P4', 'VIP', 9),
(588, 'P5', 'VIP', 9),
(589, 'P6', 'VIP', 9),
(590, 'P7', 'VIP', 9),
(591, 'P8', 'VIP', 9),
(592, 'P9', 'VIP', 9),
(593, 'P10', 'VIP', 9),
(594, 'P11', 'VIP', 9),
(595, 'P12', 'VIP', 9),
(596, 'P13', 'VIP', 9),
(597, 'P14', 'VIP', 9),
(598, 'P15', 'VIP', 9),
(599, 'P16', 'VIP', 9),
(600, 'P17', 'VIP', 9),
(601, 'P18', 'VIP', 9),
(602, 'P19', 'VIP', 9),
(603, 'P20', 'VIP', 9),
(604, 'Q1', 'VIP', 9),
(605, 'Q2', 'VIP', 9),
(606, 'Q3', 'VIP', 9),
(607, 'Q4', 'VIP', 9),
(608, 'Q5', 'VIP', 9),
(609, 'Q6', 'VIP', 9),
(610, 'Q7', 'VIP', 9),
(611, 'Q8', 'VIP', 9),
(612, 'Q9', 'VIP', 9),
(613, 'Q10', 'VIP', 9),
(614, 'Q11', 'VIP', 9),
(615, 'Q12', 'VIP', 9),
(616, 'Q13', 'VIP', 9),
(617, 'Q14', 'VIP', 9),
(618, 'Q15', 'VIP', 9),
(619, 'Q16', 'VIP', 9),
(620, 'Q17', 'VIP', 9),
(621, 'Q18', 'VIP', 9),
(622, 'Q19', 'VIP', 9),
(623, 'Q20', 'VIP', 9),
(624, 'R1', 'VIP', 9),
(625, 'R2', 'VIP', 9),
(626, 'R3', 'VIP', 9),
(627, 'R4', 'VIP', 9),
(628, 'R5', 'VIP', 9),
(629, 'R6', 'VIP', 9),
(630, 'R7', 'VIP', 9),
(631, 'R8', 'VIP', 9),
(632, 'R9', 'VIP', 9),
(633, 'R10', 'VIP', 9),
(634, 'R11', 'VIP', 9),
(635, 'R12', 'VIP', 9),
(636, 'R13', 'VIP', 9),
(637, 'R14', 'VIP', 9),
(638, 'R15', 'VIP', 9),
(639, 'R16', 'VIP', 9),
(640, 'R17', 'VIP', 9),
(641, 'R18', 'VIP', 9),
(642, 'R19', 'VIP', 9),
(643, 'R20', 'VIP', 9),
(644, 'S1', 'VIP', 9),
(645, 'S2', 'VIP', 9),
(646, 'S3', 'VIP', 9),
(647, 'S4', 'VIP', 9),
(648, 'S5', 'VIP', 9),
(649, 'S6', 'VIP', 9),
(650, 'S7', 'VIP', 9),
(651, 'S8', 'VIP', 9),
(652, 'S9', 'VIP', 9),
(653, 'S10', 'VIP', 9),
(654, 'S11', 'VIP', 9),
(655, 'S12', 'VIP', 9),
(656, 'S13', 'VIP', 9),
(657, 'S14', 'VIP', 9),
(658, 'S15', 'VIP', 9),
(659, 'S16', 'VIP', 9),
(660, 'S17', 'VIP', 9),
(661, 'S18', 'VIP', 9),
(662, 'S19', 'VIP', 9),
(663, 'S20', 'VIP', 9),
(664, 'T1', 'VIP', 9),
(665, 'T2', 'VIP', 9),
(666, 'T3', 'VIP', 9),
(667, 'T4', 'VIP', 9),
(668, 'T5', 'VIP', 9),
(669, 'T6', 'VIP', 9),
(670, 'T7', 'VIP', 9),
(671, 'T8', 'VIP', 9),
(672, 'T9', 'VIP', 9),
(673, 'T10', 'VIP', 9),
(674, 'T11', 'VIP', 9),
(675, 'T12', 'VIP', 9),
(676, 'T13', 'VIP', 9),
(677, 'T14', 'VIP', 9),
(678, 'T15', 'VIP', 9),
(679, 'T16', 'VIP', 9),
(680, 'T17', 'VIP', 9),
(681, 'T18', 'VIP', 9),
(682, 'T19', 'VIP', 9),
(683, 'T20', 'VIP', 9),
(684, 'U1', 'VIP', 9),
(685, 'U2', 'VIP', 9),
(686, 'U3', 'VIP', 9),
(687, 'U4', 'VIP', 9),
(688, 'U5', 'VIP', 9),
(689, 'U6', 'VIP', 9),
(690, 'U7', 'VIP', 9),
(691, 'U8', 'VIP', 9),
(692, 'U9', 'VIP', 9),
(693, 'U10', 'VIP', 9),
(694, 'U11', 'VIP', 9),
(695, 'U12', 'VIP', 9),
(696, 'U13', 'VIP', 9),
(697, 'U14', 'VIP', 9),
(698, 'U15', 'VIP', 9),
(699, 'U16', 'VIP', 9),
(700, 'U17', 'VIP', 9),
(701, 'U18', 'VIP', 9),
(702, 'U19', 'VIP', 9),
(703, 'U20', 'VIP', 9),
(704, 'V1', 'VIP', 9),
(705, 'V2', 'VIP', 9),
(706, 'V3', 'VIP', 9),
(707, 'V4', 'VIP', 9),
(708, 'V5', 'VIP', 9),
(709, 'V6', 'VIP', 9),
(710, 'V7', 'VIP', 9),
(711, 'V8', 'VIP', 9),
(712, 'V9', 'VIP', 9),
(713, 'V10', 'VIP', 9),
(714, 'V11', 'VIP', 9),
(715, 'V12', 'VIP', 9),
(716, 'V13', 'VIP', 9),
(717, 'V14', 'VIP', 9),
(718, 'V15', 'VIP', 9),
(719, 'V16', 'VIP', 9),
(720, 'V17', 'VIP', 9),
(721, 'V18', 'VIP', 9),
(722, 'V19', 'VIP', 9),
(723, 'V20', 'VIP', 9),
(724, 'W1', 'VIP', 9),
(725, 'W2', 'VIP', 9),
(726, 'W3', 'VIP', 9),
(727, 'W4', 'VIP', 9),
(728, 'W5', 'VIP', 9),
(729, 'W6', 'VIP', 9),
(730, 'W7', 'VIP', 9),
(731, 'W8', 'VIP', 9),
(732, 'W9', 'VIP', 9),
(733, 'W10', 'VIP', 9),
(734, 'W11', 'VIP', 9),
(735, 'W12', 'VIP', 9),
(736, 'W13', 'VIP', 9),
(737, 'W14', 'VIP', 9),
(738, 'W15', 'VIP', 9),
(739, 'W16', 'VIP', 9),
(740, 'W17', 'VIP', 9),
(741, 'W18', 'VIP', 9),
(742, 'W19', 'VIP', 9),
(743, 'W20', 'VIP', 9),
(744, 'X1', 'VIP', 9),
(745, 'X2', 'VIP', 9),
(746, 'X3', 'VIP', 9),
(747, 'X4', 'VIP', 9),
(748, 'X5', 'VIP', 9),
(749, 'X6', 'VIP', 9),
(750, 'X7', 'VIP', 9),
(751, 'X8', 'VIP', 9),
(752, 'X9', 'VIP', 9),
(753, 'X10', 'VIP', 9),
(754, 'X11', 'VIP', 9),
(755, 'X12', 'VIP', 9),
(756, 'X13', 'VIP', 9),
(757, 'X14', 'VIP', 9),
(758, 'X15', 'VIP', 9),
(759, 'X16', 'VIP', 9),
(760, 'X17', 'VIP', 9),
(761, 'X18', 'VIP', 9),
(762, 'X19', 'VIP', 9),
(763, 'X20', 'VIP', 9);

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
(3, 'Nguyen Dang', 'admin@gmail.com', '$2y$10$7oXkmIWhE.omoAqF6tlOs.MU60BEwFEzDaRgq0dNsVy48FLKq/ZUW', NULL, 'QuanTri'),
(4, 'NgDang', 'user@gmail.com', '$2y$10$k.qxQo8SOKZ5GtsUf0qy2u0jp2U/QpEYZjYywdW4qqhlbrDltbkCG', NULL, 'KhachHang');

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
(1, 'Lật Mặt 7: Một Điều Ước', 'Phim của Lý Hải. Một câu chuyện cảm động về gia đình, khi người mẹ 73 tuổi gặp nạn và cần sự chăm sóc của 5 người con.', 'Gia đình, Hành động', 130, '2025-10-10', 'IMAGES/LM7.jpg', 'C16'),
(2, 'Kẻ Trộm Mặt Trăng 4', 'Gru và các Minion trở lại trong một cuộc phiêu lưu mới, đối mặt với một kẻ thù cũ và một thành viên mới trong gia đình.', 'Hoạt hình, Hài', 95, '2025-10-15', 'IMAGES/KTMT4.jpg', 'P'),
(3, 'Gã Điên: Điệu Nhảy Của Hai Người', 'Phần tiếp theo của JOKER, khám phá mối quan hệ phức tạp giữa Arthur Fleck và Harley Quinn tại nhà thương điên Arkham.', 'Tâm lý, Nhạc kịch', 160, '2025-10-04', 'IMAGES/JOKER.jpg', 'C18'),
(4, 'Quái Vật Săn Đêm', 'Một nhóm bạn trẻ bị mắc kẹt trong một khu rừng và bị săn đuổi bởi một sinh vật cổ đại bí ẩn.', 'Kinh dị', 105, '2025-11-07', 'IMAGES/QVSD.jpg', 'C18'),
(5, 'Cuộc Phiêu Lưu Giáng Sinh', 'Một bộ phim gia đình ấm áp về hành trình của một cậu bé giúp đỡ ông già Noel tìm lại phép thuật đã mất.', 'Gia đình, Phiêu lưu', 90, '2025-12-05', 'IMAGES/shaun.jpg', 'P');

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
(8, 'Phòng 4', 100, 1),
(9, 'phòng 5', 480, 1);

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
(4, '2025-11-05', '21:00:00', '2D', 180000, 1, 8),
(5, '2025-11-10', '09:30:00', '2D', 80000, 1, 1),
(6, '2025-11-10', '12:00:00', '2D', 80000, 1, 1),
(7, '2025-11-10', '14:40:00', '2D', 80000, 1, 1),
(8, '2025-11-11', '09:30:00', '2D', 80000, 1, 1),
(9, '2025-11-11', '12:00:00', '2D', 80000, 1, 1),
(10, '2025-11-11', '14:40:00', '2D', 80000, 1, 1),
(11, '2025-11-12', '09:30:00', '2D', 80000, 1, 1),
(12, '2025-11-12', '12:00:00', '2D', 80000, 1, 1),
(13, '2025-11-12', '14:40:00', '2D', 80000, 1, 1),
(14, '2025-11-13', '09:30:00', '2D', 80000, 1, 1),
(15, '2025-11-13', '12:00:00', '2D', 80000, 1, 1),
(16, '2025-11-13', '14:40:00', '2D', 80000, 1, 1),
(17, '2025-11-14', '09:30:00', '2D', 80000, 1, 1),
(18, '2025-11-14', '12:00:00', '2D', 80000, 1, 1),
(19, '2025-11-14', '14:40:00', '2D', 80000, 1, 1),
(20, '2025-11-15', '09:30:00', '2D', 80000, 1, 1),
(21, '2025-11-15', '12:00:00', '2D', 80000, 1, 1),
(22, '2025-11-15', '14:40:00', '2D', 80000, 1, 1),
(23, '2025-11-16', '09:30:00', '2D', 80000, 1, 1),
(24, '2025-11-16', '12:00:00', '2D', 80000, 1, 1),
(25, '2025-11-16', '14:40:00', '2D', 80000, 1, 1),
(26, '2025-11-17', '09:30:00', '2D', 80000, 1, 1),
(27, '2025-11-17', '12:00:00', '2D', 80000, 1, 1),
(28, '2025-11-17', '14:40:00', '2D', 90000, 1, 9);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `dondatve`
--
ALTER TABLE `dondatve`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `ghe`
--
ALTER TABLE `ghe`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=764;

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `rap`
--
ALTER TABLE `rap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `suatchieu`
--
ALTER TABLE `suatchieu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
