-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2019 at 05:48 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rockrydersdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_karyawan`, `uname`, `pass`, `level`) VALUES
(1, 1, 'superadmin', 'd4395a5856617fa4afe8c5cd2eed3912', 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `codetransaction`
--

CREATE TABLE `codetransaction` (
  `Id` int(11) NOT NULL,
  `Prefix` varchar(255) NOT NULL,
  `Year` varchar(2) DEFAULT NULL,
  `Month` varchar(2) DEFAULT NULL,
  `Increment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `codetransaction`
--

INSERT INTO `codetransaction` (`Id`, `Prefix`, `Year`, `Month`, `Increment`) VALUES
(6, 'GR', '19', '8', 4),
(7, 'DO', '19', '8', 9),
(8, 'SR', '19', '8', 11);

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `Id` int(11) NOT NULL,
  `Code` varchar(12) DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`Id`, `Code`, `Name`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'MRH', 'Merah', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(2, 'HJU', 'Hijau', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(3, 'BRU', 'Biru', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(4, 'KNG', 'Kuning', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(5, 'ABU', 'Abu-Abu', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `Id` int(11) NOT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Color` varchar(12) DEFAULT NULL,
  `Size` varchar(6) DEFAULT NULL,
  `Type` varchar(12) DEFAULT NULL,
  `BasePrice` decimal(10,0) DEFAULT NULL,
  `LargeUOM` varchar(32) DEFAULT NULL,
  `MediumUOM` varchar(32) DEFAULT NULL,
  `SmallUOM` varchar(32) DEFAULT NULL,
  `LargeConversion` int(11) DEFAULT NULL,
  `MediumConversion` int(11) DEFAULT NULL,
  `SmallConversion` int(11) DEFAULT NULL,
  `LargeQty` int(11) DEFAULT NULL,
  `MediumQty` int(11) DEFAULT NULL,
  `SmallQty` int(11) DEFAULT NULL,
  `LargePrice` decimal(10,0) DEFAULT NULL,
  `MediumPrice` decimal(10,0) DEFAULT NULL,
  `SmallPrice` decimal(10,0) DEFAULT NULL,
  `MinStock` int(11) DEFAULT NULL,
  `Aging` int(11) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Id`, `Name`, `Color`, `Size`, `Type`, `BasePrice`, `LargeUOM`, `MediumUOM`, `SmallUOM`, `LargeConversion`, `MediumConversion`, `SmallConversion`, `LargeQty`, `MediumQty`, `SmallQty`, `LargePrice`, `MediumPrice`, `SmallPrice`, `MinStock`, `Aging`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(15, 'Kaos Polos', 'MRH', 'S', NULL, '15000', 'Partai', 'Lusin', 'Pcs', 1200, 12, 1, 1, 116, 1300, '25000', '25500', '27500', 1, 30, 0, '2019-08-20 23:34:29', NULL, NULL, NULL, NULL),
(16, 'Kaos Polos', 'MRH', 'L', NULL, '15000', 'Partai', 'Lusin', 'Pcs', 1200, 12, 1, 1, 50, 600, '25000', '25500', '27500', 1, 30, 0, '2019-08-20 23:34:29', NULL, NULL, NULL, NULL),
(17, 'Kaos Polos', 'MRH', 'M', NULL, '15000', 'Partai', 'Lusin', 'Pcs', 1200, 12, 1, 1, 67, 800, '25000', '25500', '27500', 1, 30, 0, '2019-08-20 23:34:29', NULL, NULL, NULL, NULL),
(18, 'Kaos Polos', 'ABU', 'S', NULL, '15000', 'Partai', 'Lusin', 'Pcs', 1200, 12, 1, 0, 10, 120, '25000', '25500', '27500', 1, 30, 0, '2019-08-20 23:35:50', NULL, NULL, NULL, NULL),
(19, 'Kaos Polos', 'MRH', 'XL', NULL, '15000', 'Partai', 'Lusin', 'Pcs', 1200, 12, 1, 0, 5, 40, '25000', '25500', '27500', 1, 30, 0, '2019-08-20 23:35:50', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `jekel` text NOT NULL,
  `jabatan` text NOT NULL,
  `alamat` text NOT NULL,
  `foto` text,
  `ktp` varchar(12) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `hutang` int(11) DEFAULT NULL,
  `tgl_gaji` date DEFAULT NULL,
  `jum_gaji` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `jekel`, `jabatan`, `alamat`, `foto`, `ktp`, `nohp`, `hutang`, `tgl_gaji`, `jum_gaji`) VALUES
(1, 'Super Admin', 'Pria', 'Super Administrator', 'Bandung', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `Id` int(11) NOT NULL,
  `jum_minimal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`Id`, `jum_minimal`) VALUES
(1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `receiving`
--

CREATE TABLE `receiving` (
  `Id` int(11) NOT NULL,
  `Code` varchar(32) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receiving`
--

INSERT INTO `receiving` (`Id`, `Code`, `Date`, `Description`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(22, 'GR19080001', '2019-08-20 00:00:00', 'Penerimaan Dari Konveksi Warna Merah Ukuran S , M , L', 1, '2019-08-20 23:34:28', NULL, NULL, NULL, NULL),
(23, 'GR19080002', '2019-08-20 00:00:00', 'Penerimaan Dari Konveksi Warna Merah XL , Abu Ukuran S', 1, '2019-08-20 23:35:50', NULL, NULL, NULL, NULL),
(25, 'GR19080004', '2019-08-20 00:00:00', 'Penerimaan Dari Konveksi Warna Merah Ukuran S', 1, '2019-08-20 23:39:55', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `receivingdetail`
--

CREATE TABLE `receivingdetail` (
  `Id` int(11) NOT NULL,
  `ReceivingId` int(11) DEFAULT NULL,
  `ItemId` int(11) DEFAULT NULL,
  `UOM` varchar(32) DEFAULT NULL,
  `ReceivingQty` int(11) DEFAULT NULL,
  `Conversion` int(11) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receivingdetail`
--

INSERT INTO `receivingdetail` (`Id`, `ReceivingId`, `ItemId`, `UOM`, `ReceivingQty`, `Conversion`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(12, 22, 15, 'Pcs', 1200, 1, 1, '2019-08-20 23:34:29', NULL, NULL, NULL, NULL),
(13, 22, 16, 'Pcs', 600, 1, 1, '2019-08-20 23:34:29', NULL, NULL, NULL, NULL),
(14, 22, 17, 'Pcs', 800, 1, 1, '2019-08-20 23:34:30', NULL, NULL, NULL, NULL),
(15, 23, 18, 'Pcs', 120, 1, 1, '2019-08-20 23:35:50', NULL, NULL, NULL, NULL),
(16, 23, 19, 'Pcs', 60, 1, 1, '2019-08-20 23:35:51', NULL, NULL, NULL, NULL),
(18, 25, 15, 'Pcs', 100, 1, 1, '2019-08-20 23:39:55', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `return`
--

CREATE TABLE `return` (
  `Id` int(11) NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Customer` varchar(32) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `CreatedBy` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` varchar(255) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` varchar(255) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return`
--

INSERT INTO `return` (`Id`, `Code`, `Date`, `Customer`, `Phone`, `Address`, `Description`, `Total`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(6, 'SR19080010', '2019-08-21 00:00:00', 'Robby', '08112271271', 'Jalan Desa No 50 F RT 06', 'tewtew', NULL, '1', '2019-08-22 01:31:45', NULL, NULL, NULL, NULL),
(7, 'SR19080011', '2019-08-21 00:00:00', 'Robby', '08112271271', 'Jalan Desa No 50 F RT 06', 'tewtew', NULL, '1', '2019-08-22 01:33:28', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `returndetail`
--

CREATE TABLE `returndetail` (
  `Id` int(11) NOT NULL,
  `ReturnId` int(11) DEFAULT NULL,
  `ItemId` int(11) DEFAULT NULL,
  `UOM` varchar(255) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `CreatedBy` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` varchar(255) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returndetail`
--

INSERT INTO `returndetail` (`Id`, `ReturnId`, `ItemId`, `UOM`, `Qty`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(2, 6, 17, 'Pcs', 13, '1', '2019-08-22 01:31:45', NULL, NULL),
(3, 7, 17, 'Pcs', 13, '1', '2019-08-22 01:33:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `Id` int(11) NOT NULL,
  `Code` varchar(12) DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`Id`, `Code`, `Name`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'M', 'M', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(2, 'S', 'S', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(3, 'L', 'L', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(4, 'XL', 'XL', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(5, 'XXL', 'XXL', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL),
(6, 'XXXL', 'XXXL', 1, '2019-08-01 00:00:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stockcard`
--

CREATE TABLE `stockcard` (
  `Id` int(11) NOT NULL,
  `TransactionCode` varchar(32) NOT NULL,
  `Date` datetime NOT NULL,
  `ItemId` int(11) NOT NULL,
  `InitialValue` int(11) NOT NULL,
  `In` int(11) NOT NULL,
  `Out` int(11) NOT NULL,
  `NewValue` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stockcard`
--

INSERT INTO `stockcard` (`Id`, `TransactionCode`, `Date`, `ItemId`, `InitialValue`, `In`, `Out`, `NewValue`, `Description`) VALUES
(65, 'GR19080001', '2019-08-20 00:00:00', 15, 0, 1200, 0, 1200, '#Stock Awal Kaos Polos MRH S Tanggal 19-08-20'),
(66, 'GR19080001', '2019-08-20 00:00:00', 16, 0, 600, 0, 600, '#Stock Awal Kaos Polos MRH L Tanggal 19-08-20'),
(67, 'GR19080001', '2019-08-20 00:00:00', 17, 0, 800, 0, 800, '#Stock Awal Kaos Polos MRH M Tanggal 19-08-20'),
(68, 'GR19080002', '2019-08-20 00:00:00', 18, 0, 120, 0, 120, '#Stock Awal Kaos Polos ABU S Tanggal 19-08-20'),
(69, 'GR19080002', '2019-08-20 00:00:00', 19, 0, 60, 0, 60, '#Stock Awal Kaos Polos MRH XL Tanggal 19-08-20'),
(71, 'GR19080004', '2019-08-20 00:00:00', 15, 1200, 100, 0, 1300, 'Penerimaan Barang Kaos Polos MRH S Tanggal 19-08-20'),
(82, 'DO19080009', '2019-08-20 00:00:00', 15, 1300, 0, 300, 1000, 'Penjualan Barang Kaos Polos MRH S Tanggal 19-08-20'),
(83, 'DO19080009', '2019-08-20 00:00:00', 18, 120, 0, 20, 100, 'Penjualan Barang Kaos Polos ABU S Tanggal 19-08-20'),
(88, 'DO19080009', '2019-08-21 00:40:54', 15, 1000, 300, 0, 1300, 'Pembatalan Penjualan Barang Kaos Polos MRH S Tanggal 19-08-20'),
(89, 'DO19080009', '2019-08-21 00:40:55', 18, 100, 20, 0, 120, 'Pembatalan Penjualan Barang Kaos Polos ABU S Tanggal 19-08-20');

-- --------------------------------------------------------

--
-- Table structure for table `stockreturn`
--

CREATE TABLE `stockreturn` (
  `Id` int(11) NOT NULL,
  `TransactionCode` varchar(32) DEFAULT NULL,
  `ItemId` int(11) NOT NULL,
  `Qty` int(11) DEFAULT NULL,
  `UOM` varchar(12) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stockreturn`
--

INSERT INTO `stockreturn` (`Id`, `TransactionCode`, `ItemId`, `Qty`, `UOM`, `CreatedBy`, `CreatedDate`) VALUES
(1, 'SR19080010', 17, 13, 'Pcs', 1, '2019-08-22 01:31:45'),
(2, 'SR19080011', 17, 13, 'Pcs', 1, '2019-08-22 01:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Id` int(11) NOT NULL,
  `Code` varchar(32) NOT NULL,
  `Date` datetime NOT NULL,
  `Customer` varchar(32) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Province` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `SubDistrict` varchar(255) DEFAULT NULL,
  `Courier` varchar(10) DEFAULT NULL,
  `Service` varchar(32) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `TotalPrice` decimal(10,0) DEFAULT NULL,
  `AdditionalPrice` decimal(10,0) DEFAULT NULL,
  `IsConfirm` tinyint(1) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  `ConfirmBy` int(11) DEFAULT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Id`, `Code`, `Date`, `Customer`, `Phone`, `Address`, `Province`, `City`, `District`, `SubDistrict`, `Courier`, `Service`, `Weight`, `Description`, `TotalPrice`, `AdditionalPrice`, `IsConfirm`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`, `ConfirmBy`, `ConfirmDate`, `Reason`) VALUES
(11, 'DO19080009', '2019-08-20 00:00:00', 'Robby', '08112271271', 'Jalan Desa No 50 F RT 06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pembelian Pertama', '8160000', '0', 0, 1, '2019-08-21 00:00:32', NULL, NULL, 1, '2019-08-21 00:40:55', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactiondetail`
--

CREATE TABLE `transactiondetail` (
  `Id` int(11) NOT NULL,
  `TransactionId` int(11) DEFAULT NULL,
  `ItemId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `UOM` varchar(32) DEFAULT NULL,
  `Conversion` int(11) DEFAULT NULL,
  `UnitPrice` decimal(10,0) DEFAULT NULL,
  `SubTotalPrice` decimal(10,0) DEFAULT NULL,
  `Discount` decimal(10,0) DEFAULT NULL,
  `TotalPrice` decimal(10,0) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactiondetail`
--

INSERT INTO `transactiondetail` (`Id`, `TransactionId`, `ItemId`, `Qty`, `UOM`, `Conversion`, `UnitPrice`, `SubTotalPrice`, `Discount`, `TotalPrice`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(12, 11, 15, 300, 'Pcs', 1, '25500', '7650000', '0', '7650000', 1, '2019-08-21 00:00:32', NULL, NULL, 1, '2019-08-21 00:40:55'),
(13, 11, 18, 20, 'Pcs', 1, '25500', '510000', '0', '510000', 1, '2019-08-21 00:00:32', NULL, NULL, 1, '2019-08-21 00:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `Id` int(11) NOT NULL,
  `Code` varchar(12) DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `codetransaction`
--
ALTER TABLE `codetransaction`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `receiving`
--
ALTER TABLE `receiving`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `receivingdetail`
--
ALTER TABLE `receivingdetail`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `return`
--
ALTER TABLE `return`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `returndetail`
--
ALTER TABLE `returndetail`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `stockcard`
--
ALTER TABLE `stockcard`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `stockreturn`
--
ALTER TABLE `stockreturn`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `codetransaction`
--
ALTER TABLE `codetransaction`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `receiving`
--
ALTER TABLE `receiving`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `receivingdetail`
--
ALTER TABLE `receivingdetail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `return`
--
ALTER TABLE `return`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `returndetail`
--
ALTER TABLE `returndetail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stockcard`
--
ALTER TABLE `stockcard`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `stockreturn`
--
ALTER TABLE `stockreturn`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
