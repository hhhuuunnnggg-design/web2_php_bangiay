CREATE TABLE `hoadon` (
`MaHD` int(11) NOT NULL,
`MaKH` int(11) NOT NULL,
`MaNV` int(11) DEFAULT NULL,
`NgayDat` datetime DEFAULT current_timestamp(),
`NgayGiao` datetime DEFAULT NULL,
`TinhTrang` varchar(20) DEFAULT NULL,
`TongTien` decimal(10,0) NOT NULL,
`MaNVGH` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;.


INSERT INTO `hoadon` (`MaHD`, `MaKH`, `MaNV`, `NgayDat`, `NgayGiao`, `TinhTrang`, `TongTien`, `MaNVGH`) VALUES
(70, 6, 3, '2023-06-16 16:55:54', '2023-12-15 21:01:29', 'hoàn thành', 11996000, '3'),
(86, 1, 3, '2023-06-19 16:52:51', NULL, 'Hủy Bỏ', 12658000, NULL),


ALTER TABLE `hoadon`
ADD PRIMARY KEY (`MaHD`),
ADD KEY `MaKH` (`MaKH`),
ADD KEY `MaNV` (`MaNV`);

ALTER TABLE `hoadon`
MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;


ALTER TABLE `chitiethoadon`
ADD PRIMARY KEY (`MaHD`,`MaSP`,`Size`,`MaMau`),
ADD KEY `MaSP` (`MaSP`),
ADD KEY `Size` (`Size`),
ADD KEY `MaMau` (`MaMau`);

INSERT INTO `chitiethoadon` (`MaHD`, `MaSP`, `SoLuong`, `DonGia`, `ThanhTien`, `Size`, `MaMau`) VALUES
(70, 7, 3, 2449000, 7347000, 41, 'Trắng'),
(70, 11, 1, 4649000, 4649000, 39, 'none'),
(86, 4, 2, 3779000, 7558000, 37, 'none'),


ALTER TABLE `chitiethoadon`
ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`),
ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
ADD CONSTRAINT `chitiethoadon_ibfk_3` FOREIGN KEY (`Size`) REFERENCES `size` (`MaSize`),
ADD CONSTRAINT `chitiethoadon_ibfk_4` FOREIGN KEY (`MaMau`) REFERENCES `mau` (`MaMau`);