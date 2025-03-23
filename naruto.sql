-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th3 23, 2025 lúc 02:10 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `naruto`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `anhsp`
--

CREATE TABLE `anhsp` (
  `MaSP` int(11) NOT NULL,
  `Anh1` varchar(500) NOT NULL,
  `Anh2` varchar(500) DEFAULT NULL,
  `Anh3` varchar(500) DEFAULT NULL,
  `Anh4` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `anhsp`
--

INSERT INTO `anhsp` (`MaSP`, `Anh1`, `Anh2`, `Anh3`, `Anh4`) VALUES
(4, 'ADIDAS_4DFWD_BLACK_2.jpg', 'ADIDAS_4DFWD_BLACK_3.jpg', 'ADIDAS_4DFWD_BLACK_4.jpg', 'ADIDAS_4DFWD_BLACK_5.jpg'),
(103, 'ADIDAS_ADICANE_CLOGS_BEGIE_2.jpg', 'ADIDAS_ADICANE_CLOGS_BEGIE_3.jpg', 'ADIDAS_ADICANE_CLOGS_BEGIE_4.jpg', 'ADIDAS_ADICANE_CLOGS_BEGIE_5.jpg'),
(53, 'ADIDAS_ADICANE_SLIDE_GREY_2.jpg', 'ADIDAS_ADICANE_SLIDE_GREY_3.jpg', 'ADIDAS_ADICANE_SLIDE_GREY_4.jpg', 'ADIDAS_ADICANE_SLIDE_GREY_5.jpg'),
(5, 'ADIDAS_CAMPUS_00S_BE_2.jpg', 'ADIDAS_CAMPUS_00S_BE_3.jpg', 'ADIDAS_CAMPUS_00S_BE_4.jpg', 'ADIDAS_CAMPUS_00S_BE_5.jpg'),
(6, 'ADIDAS_CAMPUS_00S_GREEN_2.jpg', 'ADIDAS_CAMPUS_00S_GREEN_3.jpg', 'ADIDAS_CAMPUS_00S_GREEN_4.jpg', 'ADIDAS_CAMPUS_00S_GREEN_5.jpg'),
(7, 'ADIDAS_FORUM_PANDA_2.jpg', 'ADIDAS_FORUM_PANDA_3.jpg', 'ADIDAS_FORUM_PANDA_4.jpg', 'ADIDAS_FORUM_PANDA_5.jpg'),
(9, 'ADIDAS_GAZELLE_BOLD_BLACK_2.jpg', 'ADIDAS_GAZELLE_BOLD_BLACK_3.jpg', 'ADIDAS_GAZELLE_BOLD_BLACK_4.jpg', 'ADIDAS_GAZELLE_BOLD_BLACK_5.jpg'),
(10, 'ADIDAS_SAMBA_OG WHITE_GREEN_2.jpg', 'ADIDAS_SAMBA_OG WHITE_GREEN_3.jpg', 'ADIDAS_SAMBA_OG WHITE_GREEN_4.jpg', 'ADIDAS_SAMBA_OG WHITE_GREEN_5.jpg'),
(99, 'ADILETTE_22_GREY_SILVER_GREEN_2.jpg', 'ADILETTE_22_GREY_SILVER_GREEN_3.jpg', 'ADILETTE_22_GREY_SILVER_GREEN_4.jpg', 'ADILETTE_22_GREY_SILVER_GREEN_5.jpg'),
(54, 'ADILETTE_22_WHITE_BLACK_2.jpg', 'ADILETTE_22_WHITE_BLACK_3.jpg', 'ADILETTE_22_WHITE_BLACK_4.jpg', 'ADILETTE_22_WHITE_BLACK_5.jpg'),
(70, 'AIR_FORCE_1_LOW_WHITE_2.jpg', 'AIR_FORCE_1_LOW_WHITE_3.jpg', 'AIR_FORCE_1_LOW_WHITE_4.jpg', 'AIR_FORCE_1_LOW_WHITE_5.jpg'),
(101, 'DEP_ADIFOM_ADILETTE_WHITE_2.jpg', 'DEP_ADIFOM_ADILETTE_WHITE_3.jpg', 'DEP_ADIFOM_ADILETTE_WHITE_4.jpg', 'DEP_ADIFOM_ADILETTE_WHITE_5.jpg'),
(71, 'DUNK_LOW_UNIVERSITY_RED_2.jpg', 'DUNK_LOW_UNIVERSITY_RED_3.jpg', 'DUNK_LOW_UNIVERSITY_RED_4.jpg', 'DUNK_LOW_UNIVERSITY_RED_5.jpg'),
(72, 'JORDAN_1_LOW_AQUATONE_2.jpg', 'JORDAN_1_LOW_AQUATONE_3.jpg', 'JORDAN_1_LOW_AQUATONE_4.jpg', 'JORDAN_1_LOW_AQUATONE_5.jpg'),
(55, 'JORDAN_1_LOW_QUILTED_WHITE_2.jpg', 'JORDAN_1_LOW_QUILTED_WHITE_3.jpg', 'JORDAN_1_LOW_QUILTED_WHITE_4.jpg', 'JORDAN_1_LOW_QUILTED_WHITE_5.jpg'),
(73, 'JORDAN_1_LOW_WOLF_GREY_2.jpg', 'JORDAN_1_LOW_WOLF_GREY_3.jpg', 'JORDAN_1_LOW_WOLF_GREY_4.jpg', 'JORDAN_1_LOW_WOLF_GREY_5.jpg'),
(102, 'NIKE_CALM_MULE_BE_2.jpg', 'NIKE_CALM_MULE_BE_3.jpg', 'NIKE_CALM_MULE_BE_4.jpg', 'NIKE_CALM_MULE_BE_5.jpg'),
(98, 'NIKE_CALM_SLIDE_BLACK_2.jpg', 'NIKE_CALM_SLIDE_BLACK_3.jpg', 'NIKE_CALM_SLIDE_BLACK_4.jpg', NULL),
(100, 'NIKE_CALM_SLIDE_WHITE_2.jpg', 'NIKE_CALM_SLIDE_WHITE_3.jpg', 'NIKE_CALM_SLIDE_WHITE_4.jpg', 'NIKE_CALM_SLIDE_WHITE_5.jpg'),
(68, 'NIKE_COURT_BOROUGH_WHITE_PINK_2.jpg', 'NIKE_COURT_BOROUGH_WHITE_PINK_3.jpg', 'NIKE_COURT_BOROUGH_WHITE_PINK_4.jpg', 'NIKE_COURT_BOROUGH_WHITE_PINK_5.jpg'),
(69, 'NIKE_DUNK_LOW_2.jpg', 'NIKE_DUNK_LOW_3.jpg', 'NIKE_DUNK_LOW_4.jpg', 'NIKE_DUNK_LOW_5.jpg'),
(56, 'NIKE_DUNK_LOW_INDIGO_HAZE_2.jpg', 'NIKE_DUNK_LOW_INDIGO_HAZE_3.jpg', 'NIKE_DUNK_LOW_INDIGO_HAZE_4.jpg', 'NIKE_DUNK_LOW_INDIGO_HAZE_5.jpg'),
(76, 'PUMA_MULE_WHITE_PINK_2.jpg', 'PUMA_MULE_WHITE_PINK_3.jpg', 'PUMA_MULE_WHITE_PINK_4.jpg', 'PUMA_MULE_WHITE_PINK_5.jpg'),
(75, 'PUMA_REBOUND_BLUE_2.jpg', 'PUMA_REBOUND_BLUE_3.jpg', 'PUMA_REBOUND_BLUE_4.jpg', 'PUMA_REBOUND_BLUE_5.jpg'),
(74, 'PUMA_REBOUND_HAZE_CORAL_2.jpg', 'PUMA_REBOUND_HAZE_CORAL_3.jpg', 'PUMA_REBOUND_HAZE_CORAL_4.jpg', 'PUMA_REBOUND_HAZE_CORAL_5.jpg'),
(97, 'PUMA_RS-X3_PUZZLE_BLACK_WHITE_2.jpg', 'PUMA_RS-X3_PUZZLE_BLACK_WHITE_3.jpg', 'PUMA_RS-X3_PUZZLE_BLACK_WHITE_4.jpg', NULL),
(96, 'PUMA_RS-X3_PUZZLE_LIMESTONE_2.jpg', 'PUMA_RS-X3_PUZZLE_LIMESTONE_3.jpg', 'PUMA_RS-X3_PUZZLE_LIMESTONE_4.jpg', 'PUMA_RS-X3_PUZZLE_LIMESTONE_5.jpg'),
(94, 'PUMA_RS-X3_PUZZLE_PINK_2.jpg', 'PUMA_RS-X3_PUZZLE_PINK_3.jpg', 'PUMA_RS-X3_PUZZLE_PINK_4.jpg', 'PUMA_RS-X3_PUZZLE_PINK_5.jpg'),
(77, 'PUMA_RS-X3_PUZZLE_WHITE_2.jpg', 'PUMA_RS-X3_PUZZLE_WHITE_3.jpg', 'PUMA_RS-X3_PUZZLE_WHITE_4.jpg', 'PUMA_RS-X3_PUZZLE_WHITE_5.jpg'),
(95, 'PUMA_RS-X3_WHITE_RED_2.jpg', 'PUMA_RS-X3_WHITE_RED_3.jpg', 'PUMA_RS-X3_WHITE_RED_4.jpg', 'PUMA_RS-X3_WHITE_RED_5.jpg'),
(11, 'PUREBOOST_22_BLACK_WHITE_2.jpg', 'PUREBOOST_22_BLACK_WHITE_3.jpg', 'PUREBOOST_22_BLACK_WHITE_4.jpg', 'PUREBOOST_22_BLACK_WHITE_5.jpg'),
(12, 'SAMBA_OG_HALO_BLUE_2.jpg', 'SAMBA_OG_HALO_BLUE_3.jpg', 'SAMBA_OG_HALO_BLUE_4.jpg', 'SAMBA_OG_HALO_BLUE_5.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `MaBL` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `NoiDung` text NOT NULL,
  `ThoiGian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`MaBL`, `MaSP`, `MaKH`, `NoiDung`, `ThoiGian`) VALUES
(1, 4, 1, 'Sản phẩm đẹp , chất lượng . ', '2019-10-27 00:00:00'),
(2, 4, 6, ' sản phẩm rất ok', '2019-10-27 20:58:25'),
(3, 4, 6, '  sản phẩm dùng tốt', '2019-10-27 23:29:35'),
(4, 4, 1, 'ok', '2019-10-29 14:38:48'),
(5, 4, 1, ' cho 5 sao', '2019-10-29 14:39:24'),
(6, 12, 1, 'a', '2019-10-31 14:41:10'),
(7, 4, 1, 'sản phẩm chất lượng', '2019-11-06 09:19:36'),
(8, 4, 1, 'toot', '2019-11-12 15:29:30'),
(9, 4, 1, 'ok', '2019-11-12 15:31:12'),
(10, 4, 1, 'ok', '2019-11-12 15:31:51'),
(11, 4, 1, 'ok', '2019-11-12 15:32:20'),
(12, 5, 1, 'ok', '2019-11-13 09:15:31'),
(14, 5, 1, 'sản phẩm tốt', '2019-12-18 17:12:34'),
(15, 10, 1, 'Rất đẹp', '2020-01-10 14:19:19'),
(16, 4, 6, 'a', '2023-06-12 13:54:02'),
(17, 4, 6, 'a', '2023-06-12 13:54:31'),
(18, 4, 6, 'test', '2023-06-12 13:54:56'),
(19, 4, 6, 'okii nò', '2023-06-12 13:55:12'),
(20, 4, 1, 'oki', '2023-06-21 08:24:14'),
(26, 7, 16, 'asda', '2025-03-21 14:32:38'),
(27, 7, 16, 'san pham nhu cai lon', '2025-03-21 14:32:54'),
(28, 9, 16, 'sadasd', '2025-03-21 14:36:59'),
(29, 9, 16, 'asda', '2025-03-21 14:42:01'),
(30, 4, 16, 'qua dang cap', '2025-03-21 14:42:50'),
(31, 113, 16, 's', '2025-03-21 14:43:59'),
(32, 73, 16, 'san pham nhu cai lz', '2025-03-21 14:47:10'),
(33, 9, 16, 'aa', '2025-03-21 15:54:46'),
(34, 9, 16, 'sad', '2025-03-21 15:54:50'),
(35, 9, 16, 'a', '2025-03-21 15:54:57'),
(36, 9, 16, 'asda', '2025-03-21 15:55:41'),
(37, 9, 16, 'huing', '2025-03-21 15:56:44'),
(38, 9, 16, 'aa', '2025-03-21 15:57:05'),
(39, 9, 16, 'a', '2025-03-21 23:43:20'),
(40, 75, 16, '1234', '2025-03-21 23:44:15'),
(41, 75, 16, 'asd', '2025-03-21 23:44:19'),
(42, 75, 16, 'aasdasd', '2025-03-21 23:46:00'),
(43, 73, 16, 'weqweqweq', '2025-03-21 23:46:33'),
(44, 73, 16, 'asdasd', '2025-03-21 23:47:02'),
(45, 73, 16, 'asda', '2025-03-21 23:47:05'),
(46, 10, 16, 'asdas', '2025-03-21 23:50:00'),
(47, 10, 16, 'asd', '2025-03-21 23:50:04'),
(48, 10, 16, 'asda', '2025-03-22 00:33:49'),
(49, 77, 16, 'ma no xau', '2025-03-22 00:34:04'),
(50, 77, 16, '1', '2025-03-22 00:37:24'),
(51, 54, 16, '1', '2025-03-22 00:39:12'),
(52, 54, 16, 'a', '2025-03-22 00:40:43'),
(53, 11, 16, '1', '2025-03-22 00:41:17'),
(54, 54, 16, '2', '2025-03-22 00:47:05'),
(55, 11, 16, '2', '2025-03-22 00:49:01'),
(56, 77, 20, '2', '2025-03-22 01:05:54'),
(57, 11, 16, 'asda', '2025-03-23 15:14:23'),
(58, 9, 16, 'ss', '2025-03-23 18:08:57'),
(59, 77, 16, 'duma no xau da man', '2025-03-23 18:09:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MaGH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TenSanPham` varchar(255) NOT NULL,
  `Img` varchar(255) NOT NULL,
  `GiaTien` int(11) NOT NULL,
  `TongTien` int(11) NOT NULL DEFAULT 0,
  `SoLuong` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  `MaMau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietgiohang`
--

INSERT INTO `chitietgiohang` (`MaGH`, `MaSP`, `TenSanPham`, `Img`, `GiaTien`, `TongTien`, `SoLuong`, `Size`, `MaMau`) VALUES
(29, 9, 'ADIDAS GAZELLE BOLD BLACK (HQ6912)', 'images/anh_nen/67d543e45a94c-ADIDAS_BE_2.jpg', 2650000, 2650000, 1, 39, 'Đen - Trắng'),
(29, 73, 'JORDAN 1 LOW WOLF GREY (DC0774-105)', 'images/anh_nen/67d5444f97954-ADIDAS_GREY_4.jpg', 2500000, 2500000, 1, 38, 'Đen ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaHD` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,0) NOT NULL,
  `ThanhTien` decimal(10,0) NOT NULL,
  `Size` int(11) NOT NULL,
  `MaMau` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`MaHD`, `MaSP`, `SoLuong`, `DonGia`, `ThanhTien`, `Size`, `MaMau`, `img`) VALUES
(70, 7, 3, 2449000, 7347000, 41, 'Trắng', ''),
(70, 11, 1, 4649000, 4649000, 39, 'none', ''),
(86, 4, 2, 3779000, 7558000, 37, 'none', ''),
(86, 53, 1, 1700000, 1700000, 42, 'none', ''),
(86, 70, 2, 1700000, 3400000, 41, 'Trắng', ''),
(87, 54, 2, 730000, 1460000, 42, 'Đen ', ''),
(88, 4, 2, 3779000, 7558000, 36, 'none', ''),
(88, 12, 1, 2019000, 2019000, 39, 'Vàng', ''),
(89, 4, 1, 3779000, 3779000, 37, 'Hồng', ''),
(92, 4, 3, 1490001, 4470003, 37, 'Đỏ', 'images/anh_nen/67d543a650c02-ADIDAS_2.jpg'),
(92, 4, 1, 1490001, 1490001, 39, 'Đỏ', 'images/anh_nen/67d543a650c02-ADIDAS_2.jpg'),
(92, 9, 1, 2650000, 2650000, 39, 'Đen - Trắng', 'images/anh_nen/67d543e45a94c-ADIDAS_BE_2.jpg'),
(92, 9, 1, 2650000, 2650000, 40, 'Đen - Trắng', 'images/anh_nen/67d543e45a94c-ADIDAS_BE_2.jpg'),
(93, 4, 2, 1490001, 2980002, 39, 'Hồng', 'images/anh_nen/67d543a650c02-ADIDAS_2.jpg'),
(93, 7, 2, 1800000, 3600000, 40, 'Đen - Trắng', 'images/anh_nen/67d543c819584-ADIDAS_BE.jpg'),
(93, 77, 1, 1400000, 1400000, 40, 'Đen - Trắng', 'images/anh_nen/67d544cf491f2-ADIDAS_BE_3.jpg'),
(94, 9, 1, 2650000, 2650000, 39, 'Đen - Trắng', 'images/anh_nen/67d543e45a94c-ADIDAS_BE_2.jpg'),
(95, 6, 1, 2150000, 2150000, 40, 'Đen ', 'images/anh_nen/67d544e1de93a-ADIDAS_GREEN.jpg'),
(96, 75, 1, 1400000, 1400000, 40, 'Đen ', 'images/anh_nen/67d5446bde1eb-ADIDAS_BLACK_2.jpg'),
(97, 4, 1, 1490001, 1490001, 37, 'Đỏ', 'images/anh_nen/67d543a650c02-ADIDAS_2.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietquyen`
--

CREATE TABLE `chitietquyen` (
  `manhomquyen` int(11) NOT NULL,
  `chucnang` int(11) NOT NULL,
  `hanhdong` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietquyen`
--

INSERT INTO `chitietquyen` (`manhomquyen`, `chucnang`, `hanhdong`) VALUES
(1, 1, 'add'),
(1, 1, 'delete'),
(1, 1, 'edit'),
(1, 1, 'view'),
(1, 2, 'add'),
(1, 2, 'delete'),
(1, 2, 'edit'),
(1, 2, 'view'),
(1, 3, 'add'),
(1, 3, 'delete'),
(1, 3, 'edit'),
(1, 3, 'view'),
(1, 4, 'add'),
(1, 4, 'delete'),
(1, 4, 'edit'),
(1, 4, 'view'),
(1, 5, 'add'),
(1, 5, 'delete'),
(1, 5, 'edit'),
(1, 5, 'view'),
(1, 6, 'add'),
(1, 6, 'delete'),
(1, 6, 'edit'),
(1, 6, 'view'),
(1, 7, 'add'),
(1, 7, 'delete'),
(1, 7, 'edit'),
(1, 7, 'view'),
(1, 9, 'add'),
(1, 9, 'delete'),
(1, 9, 'edit'),
(1, 9, 'view'),
(1, 10, 'add'),
(1, 10, 'delete'),
(1, 10, 'edit'),
(1, 10, 'view'),
(2, 1, 'add'),
(2, 1, 'edit'),
(2, 1, 'view'),
(2, 2, 'add'),
(2, 2, 'edit'),
(2, 2, 'view'),
(2, 13, 'add'),
(2, 13, 'edit'),
(2, 13, 'view'),
(3, 1, 'view'),
(3, 3, 'add'),
(3, 3, 'edit'),
(3, 3, 'view'),
(4, 1, 'add'),
(4, 1, 'delete'),
(4, 1, 'edit'),
(4, 1, 'export'),
(4, 1, 'view'),
(4, 2, 'export'),
(4, 2, 'view'),
(5, 10, 'add');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietsanpham`
--

CREATE TABLE `chitietsanpham` (
  `MaSP` int(11) NOT NULL,
  `MaSize` int(11) NOT NULL,
  `MaMau` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietsanpham`
--

INSERT INTO `chitietsanpham` (`MaSP`, `MaSize`, `MaMau`, `SoLuong`) VALUES
(4, 36, 'Đỏ', 100),
(4, 36, 'Hồng', 100),
(4, 36, 'none', 100),
(4, 37, 'Đỏ', 100),
(4, 37, 'Hồng', 99),
(4, 37, 'none', 100),
(4, 38, 'Đỏ', 100),
(4, 38, 'Hồng', 100),
(4, 38, 'none', 100),
(4, 39, 'Đỏ', 100),
(4, 39, 'Hồng', 100),
(4, 39, 'none', 100),
(4, 40, 'Đỏ', 100),
(4, 40, 'Hồng', 100),
(4, 40, 'none', 100),
(4, 41, 'Đỏ', 100),
(4, 41, 'Hồng', 100),
(4, 41, 'none', 100),
(4, 42, 'Đỏ', 100),
(4, 42, 'Hồng', 100),
(4, 42, 'none', 100),
(4, 43, 'Đỏ', 100),
(4, 43, 'Hồng', 100),
(4, 43, 'none', 100),
(5, 39, 'Xanh', 98),
(5, 40, 'Xanh', 98),
(5, 41, 'Xanh', 100),
(5, 42, 'Xanh', 100),
(6, 38, 'Đen ', 36),
(6, 39, 'Đen ', 40),
(6, 40, 'Đen ', 40),
(6, 41, 'Đen ', 40),
(6, 42, 'Đen ', 40),
(7, 39, 'Đen - Trắng', 16),
(7, 39, 'Trắng', 50),
(7, 40, 'Đen - Trắng', 15),
(7, 40, 'Trắng', 50),
(7, 41, 'Đen - Trắng', 20),
(7, 41, 'Trắng', 44),
(9, 38, 'Đen - Trắng', 39),
(9, 39, 'Đen - Trắng', 40),
(9, 40, 'Đen - Trắng', 40),
(9, 41, 'Đen - Trắng', 40),
(9, 42, 'Đen - Trắng', 40),
(10, 39, 'Trắng', 87),
(10, 40, 'Trắng', 100),
(10, 41, 'Trắng', 100),
(10, 42, 'Trắng', 95),
(11, 39, 'none', 90),
(11, 40, 'none', 95),
(11, 41, 'none', 95),
(11, 42, 'none', 100),
(12, 39, 'Vàng', 99),
(12, 40, 'Vàng', 99),
(12, 41, 'Vàng', 100),
(53, 42, 'none', 493),
(54, 36, 'Đen ', 500),
(54, 37, 'Đen ', 500),
(54, 38, 'Đen ', 500),
(54, 39, 'Đen ', 500),
(54, 40, 'Đen ', 500),
(54, 41, 'Đen ', 500),
(54, 42, 'Đen ', 496),
(54, 43, 'Đen ', 500),
(55, 39, 'Đen ', 194),
(55, 40, 'Đen ', 200),
(55, 41, 'Đen ', 200),
(56, 38, 'Đen - Trắng', 99),
(56, 39, 'Đen - Trắng', 99),
(56, 40, 'Đen - Trắng', 100),
(56, 41, 'Đen - Trắng', 100),
(68, 39, 'Đen ', 499),
(68, 39, 'Đen - Trắng', 29),
(68, 40, 'Đen ', 500),
(68, 40, 'Đen - Trắng', 30),
(68, 41, 'Đen ', 500),
(68, 41, 'Đen - Trắng', 30),
(69, 39, 'none', 100),
(69, 40, 'none', 100),
(69, 41, 'none', 100),
(70, 39, 'Đen - Trắng', 100),
(70, 39, 'Trắng', 98),
(70, 40, 'Đen - Trắng', 100),
(70, 40, 'Trắng', 100),
(70, 41, 'Đen - Trắng', 100),
(70, 41, 'Trắng', 100),
(71, 40, 'Đen ', 100),
(71, 41, 'Đen ', 95),
(71, 42, 'Đen ', 100),
(72, 39, 'Đen - Trắng', 100),
(72, 39, 'Trắng', 200),
(72, 40, 'Đen - Trắng', 99),
(72, 40, 'Trắng', 200),
(72, 41, 'Đen - Trắng', 100),
(72, 41, 'Trắng', 200),
(73, 36, 'Đen ', 100),
(73, 37, 'Đen ', 100),
(73, 38, 'Đen ', 100),
(73, 39, 'Đen ', 100),
(73, 40, 'Đen ', 100),
(73, 41, 'Đen ', 100),
(73, 42, 'Đen ', 100),
(73, 43, 'Đen ', 100),
(74, 38, 'Đen - Trắng', 100),
(74, 39, 'Đen - Trắng', 100),
(74, 40, 'Đen - Trắng', 100),
(74, 41, 'Đen - Trắng', 100),
(75, 38, 'Đen ', 95),
(75, 38, 'Đen - Trắng', 40),
(75, 38, 'Trắng', 50),
(75, 39, 'Đen ', 100),
(75, 39, 'Đen - Trắng', 40),
(75, 39, 'Trắng', 50),
(75, 40, 'Đen ', 100),
(75, 40, 'Đen - Trắng', 40),
(75, 40, 'Trắng', 50),
(75, 41, 'Đen ', 100),
(75, 41, 'Đen - Trắng', 40),
(75, 41, 'Trắng', 50),
(75, 42, 'Đen ', 100),
(75, 42, 'Đen - Trắng', 40),
(75, 42, 'Trắng', 50),
(76, 38, 'Đen ', 95),
(76, 38, 'Trắng', 40),
(76, 39, 'Đen ', 99),
(76, 39, 'Trắng', 40),
(76, 40, 'Đen ', 100),
(76, 40, 'Trắng', 40),
(76, 41, 'Đen ', 100),
(76, 41, 'Trắng', 40),
(76, 42, 'Đen ', 100),
(76, 42, 'Trắng', 40),
(77, 39, 'Đen - Trắng', 500),
(77, 40, 'Đen - Trắng', 500),
(77, 41, 'Đen - Trắng', 500),
(94, 36, 'Hồng', 0),
(94, 40, 'Hồng', 0),
(94, 41, 'Hồng', 0),
(95, 37, 'Đỏ', 0),
(95, 37, 'none', 0),
(95, 38, 'Đỏ', 0),
(95, 38, 'none', 0),
(95, 40, 'Đỏ', 0),
(95, 40, 'none', 0),
(95, 41, 'Đỏ', 0),
(111, 36, '9999', 0),
(111, 36, 'Đen - Trắng', 0),
(111, 36, 'Hồng', 0),
(111, 39, '9999', 0),
(111, 39, 'Đen - Trắng', 0),
(111, 39, 'Hồng', 0),
(111, 90, '9999', 0),
(111, 90, 'Đen - Trắng', 0),
(111, 90, 'Hồng', 0),
(113, 36, 'Trắng', 3),
(113, 36, 'Vàng', 3),
(113, 37, 'Trắng', 0),
(113, 37, 'Vàng', 0),
(114, 90, 'má mày', 10),
(114, 90, 'saaaa', 5),
(114, 123123, 'má mày', 15),
(114, 123123, 'saaaa', 152),
(115, 36, 'má mày', 90),
(115, 36, 'saaaa', 0),
(115, 36, 'tess\'', 0),
(115, 37, 'má mày', 0),
(115, 37, 'saaaa', 0),
(115, 37, 'tess\'', 0),
(115, 38, 'má mày', 0),
(115, 38, 'saaaa', 0),
(115, 38, 'tess\'', 0),
(115, 39, 'má mày', 0),
(115, 39, 'saaaa', 0),
(115, 39, 'tess\'', 0);

--
-- Bẫy `chitietsanpham`
--
DELIMITER $$
CREATE TRIGGER `tongsl` AFTER UPDATE ON `chitietsanpham` FOR EACH ROW UPDATE sanpham SET SoLuong= (SELECT SUM(SoLuong) from chitietsanpham WHERE MaSP = NEW.MaSP) WHERE MaSP = NEW.MaSP
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tongsl_del` AFTER DELETE ON `chitietsanpham` FOR EACH ROW UPDATE sanpham SET SoLuong= (SELECT SUM(SoLuong) from chitietsanpham WHERE MaSP = OLD.MaSP) WHERE MaSP = OLD.MaSP
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tongsl_insert` AFTER INSERT ON `chitietsanpham` FOR EACH ROW UPDATE sanpham SET SoLuong= (SELECT SUM(SoLuong) from chitietsanpham WHERE MaSP = NEW.MaSP) WHERE MaSP = NEW.MaSP
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int(11) NOT NULL,
  `TenDM` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDM`) VALUES
(1, 'Sản Phẩm Nổi Bật 123'),
(2, 'Sản Phẩm Mới'),
(3, 'Sản Phẩm bán chạy'),
(10, 'danh mục test 1213');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucchucnang`
--

CREATE TABLE `danhmucchucnang` (
  `chucnang` int(11) NOT NULL,
  `tenchucnang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucchucnang`
--

INSERT INTO `danhmucchucnang` (`chucnang`, `tenchucnang`) VALUES
(1, 'Quản lý danh mục '),
(2, 'Quản lý màu sắc'),
(3, 'Quản lý kích thước'),
(4, 'Quản lý nhà cung cấp'),
(5, 'Quản lý nhân viên'),
(6, 'Quản lý quyền'),
(7, 'Quản lý chi tiết quyền'),
(8, 'Quản lý danh mục chức năng'),
(9, 'Quản lý khuyến mãi'),
(10, 'Quản lý sản phẩm'),
(13, 'Quản lý hóa đơn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `TongSoLuong` int(11) DEFAULT 0,
  `TongTien` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGH`, `MaKH`, `TongSoLuong`, `TongTien`) VALUES
(29, 23, 2, 5150000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `NgayGiao` datetime DEFAULT NULL,
  `TinhTrang` varchar(20) DEFAULT NULL,
  `TongTien` decimal(10,0) NOT NULL,
  `MaNVGH` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`MaHD`, `MaKH`, `MaNV`, `NgayDat`, `NgayGiao`, `TinhTrang`, `TongTien`, `MaNVGH`) VALUES
(70, 6, 3, '2023-06-16 16:55:54', '2025-03-22 05:15:26', 'hoàn thành', 11996000, '3'),
(86, 1, 3, '2023-06-19 16:52:51', '2025-03-22 04:59:54', 'hoàn thành', 12658000, NULL),
(87, 1, 3, '2023-06-19 17:20:30', '2023-12-15 21:01:28', 'hoàn thành', 1460000, '3'),
(88, 1, 3, '2023-06-20 09:18:27', '2025-03-22 04:59:33', 'hoàn thành', 9577000, '3'),
(89, 1, 3, '2023-06-21 08:31:12', '2023-06-22 08:32:24', 'hoàn thành', 3679000, '3'),
(92, 16, NULL, '2025-03-23 19:12:37', NULL, 'Chờ xử lý', 11260004, NULL),
(93, 23, NULL, '2025-03-23 19:14:39', '2025-03-23 13:37:34', 'hoàn thành', 7980002, NULL),
(94, 23, NULL, '2025-03-23 19:21:50', NULL, 'Chờ xử lý', 2650000, NULL),
(95, 23, NULL, '2025-03-23 19:33:34', NULL, 'Chờ xử lý', 2150000, NULL),
(96, 23, NULL, '2025-03-23 19:33:50', NULL, 'Chờ xử lý', 1400000, NULL),
(97, 23, NULL, '2025-03-23 19:42:31', NULL, 'Chờ xử lý', 1490001, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `SDT` bigint(12) NOT NULL,
  `DiaChi` text NOT NULL,
  `MatKhau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `Email`, `SDT`, `DiaChi`, `MatKhau`) VALUES
(20, '123', '123@gmail.com', 123, '213', '123456'),
(21, 'abc', 'abc@gmail.com', 123456, '132456', '123456'),
(6, 'Nguyễn Nam Cường', 'cuong@gmail.com', 1228923743, 'diachi', '123456'),
(18, 'hahahha', 'haha@gmail.com', 1457895622, '1541651', '123456'),
(16, 'Nguyen123', 'hung@gmail.com', 787495636, 'tan chau tay ninh', '123456'),
(17, 'huy', 'huy@gmail.com', 0, '51616', '123456'),
(22, 'nguyen duy manh', 'manh@gmail.com', 1165165156, '6516516515', '123456'),
(19, 'oo', 'o@gmail.com', 1561651, '1', '1'),
(23, 'qeqweq', 'test@gmail.com', 123, '123', '123456'),
(1, 'Nguyễn Đình Trí', 'tringuyen25071998@gmail.com', 778923743, '62/32 trần thánh tông - tân bình - hcm', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` int(11) NOT NULL,
  `TenKM` varchar(50) DEFAULT NULL,
  `MoTa` varchar(11) DEFAULT NULL,
  `KM_PT` int(5) DEFAULT NULL,
  `TienKM` decimal(10,0) DEFAULT NULL,
  `NgayBD` date DEFAULT NULL,
  `NgayKT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenKM`, `MoTa`, `KM_PT`, `TienKM`, `NgayBD`, `NgayKT`) VALUES
(1, 'Tri Ân Khách Hàng', 'sale', NULL, 50000, '2020-01-01', '2024-05-31'),
(3, 'Vui Xuân - Đón Tết ', NULL, 30, NULL, '2019-12-19', '2020-02-29'),
(4, 'Khuyến Mãi Đặc Biệt', NULL, NULL, 100000, '2019-12-19', '2020-01-31'),
(5, 'khuyễn mãi đặc biệt trị giá 500.000 đ', 'ok', NULL, 500000, '2025-03-12', '2025-03-18'),
(7, 'test khuyễn mãi', '123456', NULL, 9999, '2025-03-16', '2025-03-31'),
(8, 'mai dinh', '123', 20, NULL, '2025-03-21', '2025-03-31'),
(9, 'vui ve k bun', '221651561', 20, NULL, '2025-03-22', '2025-04-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mau`
--

CREATE TABLE `mau` (
  `MaMau` varchar(50) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `mau`
--

INSERT INTO `mau` (`MaMau`) VALUES
('9999'),
('áda'),
('ádasdas'),
('Đen '),
('Đen - Trắng'),
('Đỏ'),
('Hồng'),
('má mày'),
('none'),
('saaaa'),
('tess\''),
('Trắng'),
('Vàng'),
('Xanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoinhan`
--

CREATE TABLE `nguoinhan` (
  `MaHD` int(11) NOT NULL,
  `TenNN` varchar(50) NOT NULL,
  `DiaChiNN` text NOT NULL,
  `SDTNN` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoinhan`
--

INSERT INTO `nguoinhan` (`MaHD`, `TenNN`, `DiaChiNN`, `SDTNN`) VALUES
(70, 'Nguyễn Nam Cường', 'diachi', 1228923743),
(86, 'Nguyễn Đình Trí', '62/32 trần thánh tông - tân bình - hcm', 778923743),
(87, 'Nguyễn Đình Trí', '62/32 trần thánh tông - tân bình - hcm', 778923743),
(88, 'Nguyễn Đình Trí', '62/32 trần thánh tông - tân bình - hcm', 778923743),
(89, 'Nguyễn Đình Trí', '62/32 trần thánh tông - tân bình - hcm', 778923743),
(92, 'Nguyen123', 'tan chau tay ninh ', 787495636),
(93, 'qeqweq', '123', 123),
(94, 'qeqweq', '123', 123),
(95, 'qeqweq', '123', 123),
(96, 'qeqweq', '123', 123),
(97, 'qeqweq', '123', 123);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacc`
--

CREATE TABLE `nhacc` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacc`
--

INSERT INTO `nhacc` (`MaNCC`, `TenNCC`) VALUES
(1, 'ADIDAS'),
(2, 'NIKE'),
(3, 'PUMA'),
(4, 'DÉP2'),
(28, '98'),
(29, '123'),
(30, 'ád'),
(31, 'áda'),
(98, 'hung'),
(99, 'huy'),
(100, 'hai');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `TenNV` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `SDT` int(12) NOT NULL,
  `DiaChi` text NOT NULL,
  `MatKhau` varchar(50) NOT NULL,
  `Quyen` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `TenNV`, `Email`, `SDT`, `DiaChi`, `MatKhau`, `Quyen`) VALUES
(3, 'Admin', 'admin@gmail.com', 905027527, 'Số 451 Hoàng Diệu - Thành phố Đà Nẵng', 'admin', 1),
(99, 'boss', 'boss@gmail.com', 905027527, 'Số 451 Hoàng Diệu - Thành phố Đà Nẵng', '123456', 2),
(6, 'kk', 'hung123@gmail.com', 895252521, 'sadsdasdasd', '123456', 1),
(4, 'Hương Nhung', 'nhung@gmail.com', 132465798, 'Số 451 Hoàng Diệu - Thành phố Đà Nẵng', '123456', 3),
(2, 'Nhân Viên Bán Hàng ', 'NVBH@gmail.com', 123456789, 'Đà Nẵng', '123456', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieugiamgia`
--

CREATE TABLE `phieugiamgia` (
  `id` varchar(200) NOT NULL,
  `TenPhieu` varchar(200) NOT NULL,
  `SoTien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieugiamgia`
--

INSERT INTO `phieugiamgia` (`id`, `TenPhieu`, `SoTien`) VALUES
('dinhtri', 'phiếu của đình trí ', 100000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPN` int(11) NOT NULL,
  `MaNV` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,0) DEFAULT NULL,
  `TongTien` decimal(10,0) NOT NULL,
  `NgayNhap` datetime NOT NULL DEFAULT current_timestamp(),
  `Note` varchar(100) DEFAULT NULL,
  `Size` int(11) NOT NULL,
  `Mau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`MaPN`, `MaNV`, `MaSP`, `SoLuong`, `DonGia`, `TongTien`, `NgayNhap`, `Note`, `Size`, `Mau`) VALUES
(28, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 36, 'none'),
(29, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 37, 'none'),
(30, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 38, 'none'),
(31, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 39, 'none'),
(32, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 40, 'none'),
(33, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 41, 'none'),
(34, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 42, 'none'),
(35, 3, 4, 100, 3500000, 350000000, '2020-01-10 13:35:56', '', 43, 'none'),
(36, 3, 5, 100, 3300000, 330000000, '2020-01-10 13:37:09', '', 39, 'Xanh'),
(37, 3, 5, 100, 3300000, 330000000, '2020-01-10 13:37:09', '', 40, 'Xanh'),
(38, 3, 5, 100, 3300000, 330000000, '2020-01-10 13:37:09', '', 41, 'Xanh'),
(39, 3, 5, 100, 3300000, 330000000, '2020-01-10 13:37:09', '', 42, 'Xanh'),
(40, 3, 6, 40, 3000000, 120000000, '2020-01-10 13:37:47', 'hàng hot', 38, 'Đen'),
(41, 3, 6, 40, 3000000, 120000000, '2020-01-10 13:37:47', 'hàng hot', 39, 'Đen'),
(42, 3, 6, 40, 3000000, 120000000, '2020-01-10 13:37:47', 'hàng hot', 40, 'Đen'),
(43, 3, 6, 40, 3000000, 120000000, '2020-01-10 13:37:47', 'hàng hot', 41, 'Đen'),
(44, 3, 6, 40, 3000000, 120000000, '2020-01-10 13:37:47', 'hàng hot', 42, 'Đen'),
(45, 3, 7, 50, 2000000, 100000000, '2020-01-10 13:38:29', '', 39, 'Trắng'),
(46, 3, 7, 50, 2000000, 100000000, '2020-01-10 13:38:29', '', 40, 'Trắng'),
(47, 3, 7, 50, 2000000, 100000000, '2020-01-10 13:38:29', '', 41, 'Trắng'),
(48, 3, 7, 20, 2000000, 40000000, '2020-01-10 13:39:19', 'màu giới hạn', 39, 'Đen - Trắng'),
(49, 3, 7, 20, 2000000, 40000000, '2020-01-10 13:39:19', 'màu giới hạn', 40, 'Đen - Trắng'),
(50, 3, 7, 20, 2000000, 40000000, '2020-01-10 13:39:19', 'màu giới hạn', 41, 'Đen - Trắng'),
(51, 3, 9, 40, 2000000, 80000000, '2020-01-10 13:39:40', 'custom', 38, 'Đen - Trắng'),
(52, 3, 9, 40, 2000000, 80000000, '2020-01-10 13:39:40', 'custom', 39, 'Đen - Trắng'),
(53, 3, 9, 40, 2000000, 80000000, '2020-01-10 13:39:40', 'custom', 40, 'Đen - Trắng'),
(54, 3, 9, 40, 2000000, 80000000, '2020-01-10 13:39:40', 'custom', 41, 'Đen - Trắng'),
(55, 3, 9, 40, 2000000, 80000000, '2020-01-10 13:39:40', 'custom', 42, 'Đen - Trắng'),
(56, 3, 10, 100, 5000000, 500000000, '2020-01-10 13:39:59', '', 39, 'Trắng'),
(57, 3, 10, 100, 5000000, 500000000, '2020-01-10 13:39:59', '', 40, 'Trắng'),
(58, 3, 10, 100, 5000000, 500000000, '2020-01-10 13:39:59', '', 41, 'Trắng'),
(59, 3, 10, 100, 5000000, 500000000, '2020-01-10 13:39:59', '', 42, 'Trắng'),
(60, 3, 11, 100, 3500000, 350000000, '2020-01-10 13:40:23', '', 39, 'none'),
(61, 3, 11, 100, 3500000, 350000000, '2020-01-10 13:40:23', '', 40, 'none'),
(62, 3, 11, 100, 3500000, 350000000, '2020-01-10 13:40:23', '', 41, 'none'),
(63, 3, 11, 100, 3500000, 350000000, '2020-01-10 13:40:23', '', 42, 'none'),
(64, 3, 12, 100, 1800000, 180000000, '2020-01-10 13:40:58', '', 39, 'Vàng'),
(65, 3, 12, 100, 1800000, 180000000, '2020-01-10 13:40:58', '', 40, 'Vàng'),
(66, 3, 12, 100, 1800000, 180000000, '2020-01-10 13:40:58', '', 41, 'Vàng'),
(67, 3, 53, 500, 1500000, 750000000, '2020-01-10 13:42:37', '', 42, 'none'),
(68, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 36, 'Đen'),
(69, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 37, 'Đen'),
(70, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 38, 'Đen'),
(71, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 39, 'Đen'),
(72, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 40, 'Đen'),
(73, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 41, 'Đen'),
(74, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 42, 'Đen'),
(75, 3, 54, 500, 500000, 250000000, '2020-01-10 13:43:07', 'Hàng F1', 43, 'Đen'),
(76, 3, 55, 200, 1000000, 200000000, '2020-01-10 13:43:25', '', 39, 'Đen'),
(77, 3, 55, 200, 1000000, 200000000, '2020-01-10 13:43:25', '', 40, 'Đen'),
(78, 3, 55, 200, 1000000, 200000000, '2020-01-10 13:43:25', '', 41, 'Đen'),
(80, 3, 56, 100, 1500000, 150000000, '2020-01-10 13:44:49', '', 38, 'Đen - Trắng'),
(81, 3, 56, 100, 1500000, 150000000, '2020-01-10 13:44:49', '', 39, 'Đen - Trắng'),
(82, 3, 56, 100, 1500000, 150000000, '2020-01-10 13:44:49', '', 40, 'Đen - Trắng'),
(83, 3, 56, 100, 1500000, 150000000, '2020-01-10 13:44:49', '', 41, 'Đen - Trắng'),
(84, 3, 69, 100, 1500000, 150000000, '2020-01-10 13:46:02', '', 39, 'none'),
(85, 3, 69, 100, 1500000, 150000000, '2020-01-10 13:46:02', '', 40, 'none'),
(86, 3, 69, 100, 1500000, 150000000, '2020-01-10 13:46:02', '', 41, 'none'),
(87, 3, 68, 500, 1000000, 500000000, '2020-01-10 13:46:39', '', 39, 'Đen'),
(88, 3, 68, 500, 1000000, 500000000, '2020-01-10 13:46:39', '', 40, 'Đen'),
(89, 3, 68, 500, 1000000, 500000000, '2020-01-10 13:46:39', '', 41, 'Đen'),
(90, 3, 68, 30, 1000000, 30000000, '2020-01-10 13:46:52', '', 39, 'Đen - Trắng'),
(91, 3, 68, 30, 1000000, 30000000, '2020-01-10 13:46:52', '', 40, 'Đen - Trắng'),
(92, 3, 68, 30, 1000000, 30000000, '2020-01-10 13:46:52', '', 41, 'Đen - Trắng'),
(93, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:31', '', 39, 'Đen - Trắng'),
(94, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:31', '', 40, 'Đen - Trắng'),
(95, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:31', '', 41, 'Đen - Trắng'),
(96, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:43', '', 39, 'Trắng'),
(97, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:43', '', 40, 'Trắng'),
(98, 3, 70, 100, 1500000, 150000000, '2020-01-10 13:47:43', '', 41, 'Trắng'),
(99, 3, 71, 100, 1000000, 100000000, '2020-01-10 13:47:59', '', 40, 'Đen'),
(100, 3, 71, 100, 1000000, 100000000, '2020-01-10 13:47:59', '', 41, 'Đen'),
(101, 3, 71, 100, 1000000, 100000000, '2020-01-10 13:47:59', '', 42, 'Đen'),
(102, 3, 72, 100, 1500000, 150000000, '2020-01-10 13:48:13', '', 39, 'Trắng'),
(103, 3, 72, 100, 1500000, 150000000, '2020-01-10 13:48:13', '', 40, 'Trắng'),
(104, 3, 72, 100, 1500000, 150000000, '2020-01-10 13:48:13', '', 41, 'Trắng'),
(105, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:48:22', '', 39, 'Trắng'),
(106, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:48:22', '', 40, 'Trắng'),
(107, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:48:22', '', 41, 'Trắng'),
(108, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 36, 'Đen'),
(109, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 37, 'Đen'),
(110, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 38, 'Đen'),
(111, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 39, 'Đen'),
(112, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 40, 'Đen'),
(113, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 41, 'Đen'),
(114, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 42, 'Đen'),
(115, 3, 73, 100, 1500000, 150000000, '2020-01-10 13:48:40', '', 43, 'Đen'),
(116, 3, 74, 100, 2000000, 200000000, '2020-01-10 13:49:03', '', 38, 'Đen - Trắng'),
(117, 3, 74, 100, 2000000, 200000000, '2020-01-10 13:49:03', '', 39, 'Đen - Trắng'),
(118, 3, 74, 100, 2000000, 200000000, '2020-01-10 13:49:03', '', 40, 'Đen - Trắng'),
(119, 3, 74, 100, 2000000, 200000000, '2020-01-10 13:49:03', '', 41, 'Đen - Trắng'),
(120, 3, 75, 100, 1000000, 100000000, '2020-01-10 13:49:20', '', 38, 'Đen'),
(121, 3, 75, 100, 1000000, 100000000, '2020-01-10 13:49:20', '', 39, 'Đen'),
(122, 3, 75, 100, 1000000, 100000000, '2020-01-10 13:49:20', '', 40, 'Đen'),
(123, 3, 75, 100, 1000000, 100000000, '2020-01-10 13:49:20', '', 41, 'Đen'),
(124, 3, 75, 100, 1000000, 100000000, '2020-01-10 13:49:20', '', 42, 'Đen'),
(125, 3, 75, 40, 1000000, 40000000, '2020-01-10 13:49:39', '', 38, 'Đen - Trắng'),
(126, 3, 75, 40, 1000000, 40000000, '2020-01-10 13:49:39', '', 39, 'Đen - Trắng'),
(127, 3, 75, 40, 1000000, 40000000, '2020-01-10 13:49:39', '', 40, 'Đen - Trắng'),
(128, 3, 75, 40, 1000000, 40000000, '2020-01-10 13:49:39', '', 41, 'Đen - Trắng'),
(129, 3, 75, 40, 1000000, 40000000, '2020-01-10 13:49:39', '', 42, 'Đen - Trắng'),
(130, 3, 75, 50, 1000000, 50000000, '2020-01-10 13:49:49', '', 38, 'Trắng'),
(131, 3, 75, 50, 1000000, 50000000, '2020-01-10 13:49:49', '', 39, 'Trắng'),
(132, 3, 75, 50, 1000000, 50000000, '2020-01-10 13:49:49', '', 40, 'Trắng'),
(133, 3, 75, 50, 1000000, 50000000, '2020-01-10 13:49:49', '', 41, 'Trắng'),
(134, 3, 75, 50, 1000000, 50000000, '2020-01-10 13:49:49', '', 42, 'Trắng'),
(135, 3, 76, 100, 1000000, 100000000, '2020-01-10 13:50:03', '', 38, 'Đen'),
(136, 3, 76, 100, 1000000, 100000000, '2020-01-10 13:50:03', '', 39, 'Đen'),
(137, 3, 76, 100, 1000000, 100000000, '2020-01-10 13:50:03', '', 40, 'Đen'),
(138, 3, 76, 100, 1000000, 100000000, '2020-01-10 13:50:03', '', 41, 'Đen'),
(139, 3, 76, 100, 1000000, 100000000, '2020-01-10 13:50:03', '', 42, 'Đen'),
(140, 3, 76, 40, 1000000, 40000000, '2020-01-10 13:50:10', '', 38, 'Trắng'),
(141, 3, 76, 40, 1000000, 40000000, '2020-01-10 13:50:11', '', 39, 'Trắng'),
(142, 3, 76, 40, 1000000, 40000000, '2020-01-10 13:50:11', '', 40, 'Trắng'),
(143, 3, 76, 40, 1000000, 40000000, '2020-01-10 13:50:11', '', 41, 'Trắng'),
(144, 3, 76, 40, 1000000, 40000000, '2020-01-10 13:50:11', '', 42, 'Trắng'),
(145, 3, 77, 500, 1000000, 500000000, '2020-01-10 13:50:22', '', 39, 'Đen - Trắng'),
(146, 3, 77, 500, 1000000, 500000000, '2020-01-10 13:50:22', '', 40, 'Đen - Trắng'),
(147, 3, 77, 500, 1000000, 500000000, '2020-01-10 13:50:22', '', 41, 'Đen - Trắng'),
(148, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:55:46', '', 39, 'Đen - Trắng'),
(149, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:55:46', '', 40, 'Đen - Trắng'),
(150, 3, 72, 100, 1000000, 100000000, '2020-01-10 13:55:46', '', 41, 'Đen - Trắng'),
(151, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 36, 'Đỏ'),
(152, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 37, 'Đỏ'),
(153, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 38, 'Đỏ'),
(154, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 39, 'Đỏ'),
(155, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 40, 'Đỏ'),
(156, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 41, 'Đỏ'),
(157, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 42, 'Đỏ'),
(158, 3, 4, 100, 3, 300, '2023-06-21 08:22:06', '', 43, 'Đỏ'),
(159, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 36, 'Hồng'),
(160, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 37, 'Hồng'),
(161, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 38, 'Hồng'),
(162, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 39, 'Hồng'),
(163, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 40, 'Hồng'),
(164, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 41, 'Hồng'),
(165, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 42, 'Hồng'),
(166, 3, 4, 100, 3, 300, '2023-06-21 08:22:31', '', 43, 'Hồng'),
(167, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 36, 'none'),
(168, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 37, 'none'),
(169, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 38, 'none'),
(170, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 39, 'none'),
(171, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 40, 'none'),
(172, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 41, 'none'),
(173, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 42, 'none'),
(174, 3, 4, 100, 3, 300, '2023-06-21 08:22:42', '', 43, 'none'),
(175, 3, 113, 3, 999, 2997, '2025-03-14 22:58:01', 'rẻ z ta', 36, 'Trắng'),
(176, 3, 113, 3, 999999, 2999997, '2025-03-14 22:58:21', 'đủ má nó mắc z', 36, 'Vàng'),
(177, 3, 114, 10, 99969, 999690, '2025-03-17 11:34:17', 'hahahah', 90, 'má mày'),
(178, 3, 114, 5, 150, 750, '2025-03-17 11:34:32', 'ádasd', 90, 'saaaa'),
(179, 3, 114, 15, 1560, 23400, '2025-03-17 11:34:47', '1515', 123123, 'má mày'),
(180, 3, 114, 152, 2032, 308864, '2025-03-17 11:34:55', '203', 123123, 'saaaa'),
(181, 3, 115, 90, 15000000, 1350000000, '2025-03-23 17:17:39', 'dssada', 36, 'má mày');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuat`
--

CREATE TABLE `phieuxuat` (
  `MaPX` int(11) NOT NULL,
  `MaNV` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `Mau` varchar(100) NOT NULL,
  `Size` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,0) NOT NULL,
  `TongTien` decimal(10,0) NOT NULL,
  `Note` varchar(500) NOT NULL,
  `NgayXuat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuxuat`
--

INSERT INTO `phieuxuat` (`MaPX`, `MaNV`, `MaSP`, `Mau`, `Size`, `SoLuong`, `DonGia`, `TongTien`, `Note`, `NgayXuat`) VALUES
(5, 3, 4, 'none', 36, 40, 1000000, 40000000, 'test', '2020-01-10 21:18:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `id` int(11) NOT NULL,
  `Ten` varchar(100) NOT NULL,
  `MoTa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`id`, `Ten`, `MoTa`) VALUES
(1, 'admin', 'full quyền'),
(2, 'Shipper', 'Ship hang cho khach hang nha ban yeu'),
(3, 'Quản lý Kho', ''),
(4, 'Nhân viên Bán Hàng', ''),
(5, 'Nhân viên giao hàng', ''),
(6, 'dime may', 'can cak');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(50) NOT NULL,
  `MaDM` int(11) DEFAULT NULL,
  `MaNCC` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT 0,
  `MoTa` text DEFAULT NULL,
  `DonGia` decimal(10,0) NOT NULL,
  `AnhNen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MaDM`, `MaNCC`, `SoLuong`, `MoTa`, `DonGia`, `AnhNen`) VALUES
(4, 'sản phầm a', 3, 1, 2399, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1500000, 'images/anh_nen/67d543a650c02-ADIDAS_2.jpg'),
(5, 'ADIDAS CAMPUS 00S BE (GY0042)', 3, 1, 396, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1800000, 'images/anh_nen/67d543b017ef7-ADIDAS_3.jpg'),
(6, 'ADIDAS CAMPUS 00S GREEN (HO3472)', 3, 1, 196, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2150000, 'images/anh_nen/67d544e1de93a-ADIDAS_GREEN.jpg'),
(7, 'ADIDAS FORUM PANDA (IF2649)', 1, 1, 195, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1800000, 'images/anh_nen/67d543c819584-ADIDAS_BE.jpg'),
(9, 'ADIDAS GAZELLE BOLD BLACK (HQ6912)', 1, 1, 199, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2650000, 'images/anh_nen/67d543e45a94c-ADIDAS_BE_2.jpg'),
(10, 'ADIDAS SAMBA OG WHITE GREEN (IG1024)', 1, 1, 382, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2600000, 'images/anh_nen/67d544096dbe9-ADIDAS_BE_3.jpg'),
(11, 'PUREBOOST 22 BLACK WHITE (GZ5174)', 1, 1, 380, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1700000, 'images/anh_nen/67d5441d5610a-ADIDAS_BLACK_2.jpg'),
(12, 'SAMBA OG HALO BLUE (ID2055)', 1, 1, 298, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 3000000, 'SAMBA_OG_HALO_BLUE.jpg'),
(53, 'ADIDAS ADICANE SLIDE GREY (ID7188)\n\n', 1, 4, 493, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 700000, 'ADIDAS_ADICANE_SLIDE_GREY.jpg'),
(54, 'ADILETTE 22 WHITE BLACK (IF3668)', 3, 4, 3996, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1000000, 'images/anh_nen/67d544f5ace39-ADIDAS_PANDA.jpg'),
(55, 'JORDAN 1 LOW QUILTED WHITE (DB6480-100)', 1, 2, 594, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2600000, 'JORDAN_1_LOW_QUILTED_WHITE.jpg'),
(56, 'NIKE DUNK LOW INDIGO HAZE (DD1503 500)', 3, 2, 398, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2800000, 'NIKE_DUNK_LOW_INDIGO_HAZE.jpg'),
(68, 'NIKE COURT BOROUGH WHITE PINK (DQ0492 100)', 1, 2, 1588, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1230000, 'NIKE_COURT_BOROUGH_WHITE_PINK.jpg'),
(69, 'NIKE DUNK LOW “MICA GREEN” (DV7212 300)', 1, 2, 300, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1700000, 'NIKE_DUNK_LOW.jpg'),
(70, 'AIR FORCE 1 LOW WHITE', 2, 2, 598, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2100000, 'images/anh_nen/67d54439349e0-ADIDAS_GREY_2.jpg'),
(71, 'DUNK LOW UNIVERSITY RED (CU1727-100)', 1, 2, 295, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2600000, 'DUNK_LOW_UNIVERSITY_RED.jpg'),
(72, 'JORDAN 1 LOW AQUATONE (553558-174)', 1, 2, 899, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2250000, 'JORDAN_1_LOW_AQUATONE.jpg'),
(73, 'JORDAN 1 LOW WOLF GREY (DC0774-105)', 2, 2, 800, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2500000, 'images/anh_nen/67d5444f97954-ADIDAS_GREY_4.jpg'),
(74, 'PUMA REBOUND HAZE CORAL (369866 19)', 1, 3, 400, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 2200000, 'PUMA_REBOUND_HAZE_CORAL.jpg'),
(75, 'PUMA REBOUND BLUE (369866 19)', 2, 3, 945, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'images/anh_nen/67d5446bde1eb-ADIDAS_BLACK_2.jpg'),
(76, 'PUMA MULE WHITE PINK (371318 04)', 1, 3, 694, 'Sản phẩm Full box tag chính hãng\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1500000, 'PUMA_MULE_WHITE_PINK.jpg'),
(77, 'PUMA RS-X3 PUZZLE WHITE (371570 05)', 2, 3, 1500, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'images/anh_nen/67d544cf491f2-ADIDAS_BE_3.jpg'),
(94, 'PUMA RS-X3 PUZZLE PINK (371570 06)', 2, 3, 200, 'Sản phẩm Full box chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1550000, 'PUMA_RS-X3_PUZZLE_PINK.jpg'),
(95, 'PUMA RS-X3 WHITE RED (372884 01)', 2, 3, 0, 'Sản phẩm Full box chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1550000, 'PUMA_RS-X3_WHITE_RED.jpg'),
(96, 'PUMA RS-X3 PUZZLE LIMESTONE (371570 01)', 3, 3, 0, 'Sản phẩm Full box chính hãng 1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác Hỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1550000, 'PUMA_RS-X3_PUZZLE_LIMESTONE.jpg'),
(97, 'PUMA RS-X3 PUZZLE BLACK WHITE (371570 13)', 2, 3, NULL, 'Sản phẩm Full box chính hãng 1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác Hỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1600000, 'PUMA_RS-X3_PUZZLE_BLACK_WHITE.jpg'),
(98, 'NIKE CALM SLIDE BLACK', 2, 4, NULL, 'Sản phẩm Full box tag chính hãng 1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác Hỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'NIKE_CALM_SLIDE_BLACK.jpg'),
(99, 'ADILETTE 22 GREY SILVER GREEN (IG8264)', 1, 4, NULL, 'Sản phẩm không thấm nước\r\nSản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1600000, 'ADILETTE_22_GREY_SILVER_GREEN.jpg'),
(100, 'NIKE CALM SLIDE WHITE', 2, 4, NULL, 'Sản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'NIKE_CALM_SLIDE_WHITE.jpg'),
(101, 'DÉP ADIFOM ADILETTE WHITE (HQ8748)', 1, 4, NULL, 'Sản phẩm không thấm nước\r\nSản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'DEP_ADIFOM_ADILETTE_WHITE.jpg'),
(102, 'NIKE CALM MULE BE (FB2185 200)', 1, 4, NULL, 'Sản phẩm không thấm nước\r\nSản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1400000, 'NIKE_CALM_MULE_BE.jpg'),
(103, 'ADIDAS ADICANE CLOGS BEGIE (HQ9916)', 2, 4, NULL, 'Adicane là dòng sản phẩm sử dụng ít nhất 50% vật liệu tái chế góp phần bảo vệ môi trường\r\nSản phẩm Full box tag chính hãng\r\n1 số sản phẩm giá sẽ thay đổi theo size vui lòng click vào size để xem giá chính xác\r\nHỗ trợ thanh toán trả góp 0% qua thẻ tín dụng', 1550000, 'ADIDAS_ADICANE_CLOGS_BEGIE.jpg'),
(104, 'abbbbbb', 1, 1, 0, 'ádasdasd', 999999, 'images/anh_nen/67d3be60e7605-mb_bank.jpg'),
(105, 'sadasdasd', 2, 3, 0, 'ádasdasd', 12123, 'PUMA_REBOUND_HAZE_CORAL_3.jpg'),
(106, 'ád', NULL, 1, 0, 'ád', 123123, 'PUMA_MULE_WHITE_PINK.jpg'),
(107, 'ádsda', NULL, 1, 0, 'ád', 123123, 'images/anh_nen/67d3c394a860f-ADIDAS_BLACK_4.jpg'),
(108, 'hùng đẹp trai', 1, 3, NULL, 'tâttatatatta', 9000, 'images/anh_nen/67d3dec88dee7-mb_bank.jpg'),
(109, 'oop', 2, 2, NULL, 'ádasdas', 1223, 'images/anh_nen/67d3e00017348-mb_bank.jpg'),
(110, 'khùng điên', NULL, 1, NULL, 'sá', 1234, ''),
(111, 'sản phẩm test1', NULL, 1, 0, 'ưq', 1212, 'images/anh_nen/67d3e1e29531f-mb_bank.jpg'),
(113, 'con gà con', 1, 1, 6, 'ads165as1d65as1d65as1d', 111111111, 'images/anh_nen/67d451c7c37e5-con_ga_con.png'),
(114, 'sản phầm b', 1, 1, 182, 'ádasdasdasd', 1500000, 'images/anh_nen/67d7a615d2713-ADIDAS_BE_2.jpg'),
(115, 'nguyen dinh hung', 3, 1, 90, 'dep vai ca lon', 99999999, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphamkhuyenmai`
--

CREATE TABLE `sanphamkhuyenmai` (
  `MaSP` int(11) NOT NULL,
  `MaKM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sanphamkhuyenmai`
--

INSERT INTO `sanphamkhuyenmai` (`MaSP`, `MaKM`) VALUES
(4, 7),
(111, 7),
(114, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `MaSize` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`MaSize`) VALUES
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(90),
(91),
(92),
(93),
(123123);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `anhsp`
--
ALTER TABLE `anhsp`
  ADD PRIMARY KEY (`Anh1`,`MaSP`);

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`MaBL`,`MaSP`,`MaKH`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MaGH`,`MaSP`,`Size`,`MaMau`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `Size` (`Size`),
  ADD KEY `MaMau` (`MaMau`);

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaHD`,`MaSP`,`Size`,`MaMau`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `Size` (`Size`),
  ADD KEY `MaMau` (`MaMau`);

--
-- Chỉ mục cho bảng `chitietquyen`
--
ALTER TABLE `chitietquyen`
  ADD PRIMARY KEY (`manhomquyen`,`chucnang`,`hanhdong`),
  ADD KEY `fk_chucnang` (`chucnang`);

--
-- Chỉ mục cho bảng `chitietsanpham`
--
ALTER TABLE `chitietsanpham`
  ADD PRIMARY KEY (`MaSP`,`MaSize`,`MaMau`),
  ADD KEY `MaSize` (`MaSize`),
  ADD KEY `MaMau` (`MaMau`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`);

--
-- Chỉ mục cho bảng `danhmucchucnang`
--
ALTER TABLE `danhmucchucnang`
  ADD PRIMARY KEY (`chucnang`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `mau`
--
ALTER TABLE `mau`
  ADD PRIMARY KEY (`MaMau`);

--
-- Chỉ mục cho bảng `nguoinhan`
--
ALTER TABLE `nguoinhan`
  ADD PRIMARY KEY (`MaHD`);

--
-- Chỉ mục cho bảng `nhacc`
--
ALTER TABLE `nhacc`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `MaNV` (`MaNV`),
  ADD KEY `Quyen` (`Quyen`);

--
-- Chỉ mục cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPN`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD PRIMARY KEY (`MaPX`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MauSP` (`MaSP`),
  ADD KEY `Mau` (`Mau`),
  ADD KEY `Size` (`Size`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaNCC` (`MaNCC`),
  ADD KEY `MaDM` (`MaDM`);

--
-- Chỉ mục cho bảng `sanphamkhuyenmai`
--
ALTER TABLE `sanphamkhuyenmai`
  ADD PRIMARY KEY (`MaSP`,`MaKM`),
  ADD KEY `MaKH` (`MaKM`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`MaSize`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `MaBL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `nhacc`
--
ALTER TABLE `nhacc`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  MODIFY `MaPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  MODIFY `MaPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `chitietgiohang_ibfk_1` FOREIGN KEY (`MaGH`) REFERENCES `giohang` (`MaGH`),
  ADD CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `chitietgiohang_ibfk_3` FOREIGN KEY (`Size`) REFERENCES `size` (`MaSize`),
  ADD CONSTRAINT `chitietgiohang_ibfk_4` FOREIGN KEY (`MaMau`) REFERENCES `mau` (`MaMau`);

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `chitiethoadon_ibfk_3` FOREIGN KEY (`Size`) REFERENCES `size` (`MaSize`),
  ADD CONSTRAINT `chitiethoadon_ibfk_4` FOREIGN KEY (`MaMau`) REFERENCES `mau` (`MaMau`);

--
-- Các ràng buộc cho bảng `chitietquyen`
--
ALTER TABLE `chitietquyen`
  ADD CONSTRAINT `fk_chucnang` FOREIGN KEY (`chucnang`) REFERENCES `danhmucchucnang` (`chucnang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_manhomquyen` FOREIGN KEY (`manhomquyen`) REFERENCES `quyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietsanpham`
--
ALTER TABLE `chitietsanpham`
  ADD CONSTRAINT `chitietsanpham_ibfk_1` FOREIGN KEY (`MaSize`) REFERENCES `size` (`MaSize`),
  ADD CONSTRAINT `chitietsanpham_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `chitietsanpham_ibfk_3` FOREIGN KEY (`MaMau`) REFERENCES `mau` (`MaMau`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `nguoinhan`
--
ALTER TABLE `nguoinhan`
  ADD CONSTRAINT `nguoinhan_ibfk_1` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`Quyen`) REFERENCES `quyen` (`id`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD CONSTRAINT `phieuxuat_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `phieuxuat_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `phieuxuat_ibfk_3` FOREIGN KEY (`Mau`) REFERENCES `mau` (`MaMau`),
  ADD CONSTRAINT `phieuxuat_ibfk_4` FOREIGN KEY (`Size`) REFERENCES `size` (`MaSize`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaNCC`) REFERENCES `nhacc` (`MaNCC`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`);

--
-- Các ràng buộc cho bảng `sanphamkhuyenmai`
--
ALTER TABLE `sanphamkhuyenmai`
  ADD CONSTRAINT `sanphamkhuyenmai_ibfk_1` FOREIGN KEY (`MaKM`) REFERENCES `khuyenmai` (`MaKM`),
  ADD CONSTRAINT `sanphamkhuyenmai_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
