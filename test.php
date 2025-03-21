<!-- hình như logic database của tao còn hơi thiếu, tao thấy là nếu ấn thêm vào giỏ hàng thì nó sẽ đựng dữ liệu giỏ hàng của user đó ở đâu, và chi tiết giỏ hàng sẽ ở đâu, và khi ấn vào thêm vào giỏ hàng thì làm sao để giỏ hàng nhảy số, báo hiệu đã thêm đc 1 cái,nếu mày thấy thiếu thì hãy thêm vào cho đúng logic -->

CREATE TABLE `giohang` (
`MaGH` int(11) NOT NULL AUTO_INCREMENT,
`MaKH` int(11) NOT NULL,
`NgayTao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`TongSoLuong` int(11) DEFAULT 0,
PRIMARY KEY (`MaGH`),
KEY `MaKH` (`MaKH`),
CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

CREATE TABLE `chitietgiohang` (
`MaGH` int(11) NOT NULL,
`MaSP` int(11) NOT NULL,
`SoLuong` int(11) NOT NULL,
`Size` int(11) NOT NULL,
`MaMau` varchar(50) NOT NULL,
PRIMARY KEY (`MaGH`, `MaSP`, `Size`, `MaMau`),
KEY `MaSP` (`MaSP`),
KEY `Size` (`Size`),
KEY `MaMau` (`MaMau`),
CONSTRAINT `chitietgiohang_ibfk_1` FOREIGN KEY (`MaGH`) REFERENCES `giohang` (`MaGH`),
CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
CONSTRAINT `chitietgiohang_ibfk_3` FOREIGN KEY (`Size`) REFERENCES `size` (`MaSize`),
CONSTRAINT `chitietgiohang_ibfk_4` FOREIGN KEY (`MaMau`) REFERENCES `mau` (`MaMau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;