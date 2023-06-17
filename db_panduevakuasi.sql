-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 01:32 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_panduevakuasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `noHp` varchar(24) NOT NULL DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `nama`, `email`, `noHp`, `username`, `password`) VALUES
(2, 'Administrator', 'admingis.bpbd@gmail.com', '082348530538', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `kawasan`
--

CREATE TABLE `kawasan` (
  `id` int(4) NOT NULL,
  `namaKawasan` varchar(35) NOT NULL DEFAULT '',
  `jenis` enum('Banjir','Kebakaran','Angin','Tsunami','Gempa Bumi') DEFAULT 'Banjir',
  `file` varchar(100) DEFAULT NULL,
  `aktif` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kawasan`
--

INSERT INTO `kawasan` (`id`, `namaKawasan`, `jenis`, `file`, `aktif`) VALUES
(4, 'Kec. Manggala', 'Banjir', '948be7078bbf0a1132ff1229f68eeb49.kml', '1');

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE `link` (
  `kode_1` varchar(5) DEFAULT NULL,
  `kode_2` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`kode_1`, `kode_2`) VALUES
('D2', 'D1'),
('D3', 'D2'),
('D4', 'D3'),
('D5', 'D2'),
('D6', 'D5'),
('D7', 'D6'),
('D7', 'D4'),
('D8', 'D7'),
('D9', 'D8'),
('D10', 'D9'),
('D11', 'D8'),
('D12', 'D11'),
('D13', 'D12'),
('D14', 'D13'),
('D15', 'D14'),
('D16', 'D15'),
('D17', 'D16'),
('D18', 'D15'),
('D19', 'D16'),
('D19', 'D18'),
('D20', 'D17'),
('D20', 'D19'),
('D21', 'D17'),
('D21', 'D20'),
('D22', 'D20'),
('D22', 'D21'),
('D23', 'D11'),
('D23', 'D10'),
('D24', 'D23'),
('D25', 'D24'),
('S1', 'D16'),
('S1', 'D17'),
('S1', 'D20'),
('S1', 'D19'),
('D26', 'D21'),
('D27', 'D26'),
('D27', 'D22'),
('D28', 'D27'),
('D29', 'D28'),
('D30', 'D29'),
('D31', 'D30'),
('D32', 'D31'),
('D33', 'D32'),
('D33', 'D28'),
('D34', 'D33'),
('D35', 'D34'),
('D36', 'D35'),
('D36', 'D26'),
('D37', 'D36'),
('D38', 'D37'),
('D39', 'D35'),
('D39', 'D38'),
('D40', 'D34'),
('D41', 'D32'),
('D41', 'D40'),
('D42', 'D31'),
('D43', 'D40'),
('D43', 'D39'),
('D44', 'D43'),
('D45', 'D44'),
('D45', 'D41'),
('D46', 'D39'),
('D47', 'D46'),
('D48', 'D46'),
('D49', 'D47'),
('D49', 'D48'),
('D50', 'D47'),
('D50', 'D44'),
('D51', 'D17'),
('D52', 'D36'),
('D52', 'D51'),
('S2', 'D46'),
('S2', 'D48'),
('S2', 'D49'),
('S2', 'D47');

-- --------------------------------------------------------

--
-- Table structure for table `waypoint`
--

CREATE TABLE `waypoint` (
  `kode` varchar(5) DEFAULT NULL,
  `latitude` varchar(30) NOT NULL DEFAULT '',
  `longitude` varchar(30) NOT NULL DEFAULT '',
  `jenis` enum('waypoint','shelter') DEFAULT 'waypoint',
  `keterangan` text DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waypoint`
--

INSERT INTO `waypoint` (`kode`, `latitude`, `longitude`, `jenis`, `keterangan`, `id`) VALUES
('D1', '-5.175768584539938', '119.48809852034557', 'waypoint', NULL, 1),
('D2', '-5.17501365616647', '119.48840247326638', 'waypoint', NULL, 2),
('D3', '-5.174666212065603', '119.48856130312163', 'waypoint', NULL, 3),
('D4', '-5.1745249038867485', '119.48837450662236', 'waypoint', NULL, 4),
('D5', '-5.174726895192762', '119.48799838390615', 'waypoint', NULL, 5),
('D6', '-5.1746566680869535', '119.48802678201635', 'waypoint', NULL, 6),
('D7', '-5.174429764854068', '119.48818338476174', 'waypoint', NULL, 7),
('D8', '-5.17417387010083', '119.48783955871981', 'waypoint', NULL, 8),
('D9', '-5.1739052000341275', '119.48797227332476', 'waypoint', NULL, 9),
('D10', '-5.173704430733608', '119.48767514640258', 'waypoint', NULL, 10),
('D11', '-5.173838248975102', '119.48730579233637', 'waypoint', NULL, 11),
('D12', '-5.173703960663673', '119.4870859391126', 'waypoint', NULL, 12),
('D13', '-5.173567158305332', '119.48685371242475', 'waypoint', NULL, 13),
('D14', '-5.173616208927754', '119.48682158596083', 'waypoint', NULL, 14),
('D15', '-5.17347389617872', '119.4866302973739', 'waypoint', NULL, 15),
('D16', '-5.173362647481483', '119.4864802465962', 'waypoint', NULL, 16),
('D17', '-5.173194188476501', '119.48627176445223', 'waypoint', NULL, 17),
('D18', '-5.173153405312206', '119.48682270374815', 'waypoint', NULL, 18),
('D19', '-5.173043295410196', '119.48667077361674', 'waypoint', NULL, 19),
('D20', '-5.1729273616413565', '119.48654088362859', 'waypoint', NULL, 20),
('D21', '-5.1730154299832805', '119.48609019025', 'waypoint', NULL, 21),
('D22', '-5.172740365291574', '119.48636693605249', 'waypoint', NULL, 22),
('D23', '-5.173589827497651', '119.48746891370733', 'waypoint', NULL, 23),
('D24', '-5.173352613717384', '119.4875865654708', 'waypoint', NULL, 24),
('D25', '-5.173317887120476', '119.48755540297068', 'waypoint', NULL, 25),
('S1', '-5.1731547223001115', '119.48648435753204', 'shelter', 'Mesjid 1', 26),
('D26', '-5.172870457561174', '119.48593654938273', 'waypoint', NULL, 27),
('D27', '-5.17258536380298', '119.48623129392976', 'waypoint', NULL, 28),
('D28', '-5.172417488491462', '119.48638370339525', 'waypoint', NULL, 29),
('D29', '-5.172251638520194', '119.48656101006387', 'waypoint', NULL, 30),
('D30', '-5.172036421686073', '119.48675391165128', 'waypoint', NULL, 31),
('D31', '-5.171857676481622', '119.48659331559459', 'waypoint', NULL, 32),
('D32', '-5.172020629710204', '119.48643711110618', 'waypoint', NULL, 33),
('D33', '-5.17226062497987', '119.48622697360793', 'waypoint', NULL, 34),
('D34', '-5.172354172066804', '119.48612892610217', 'waypoint', NULL, 35),
('D35', '-5.172529277099983', '119.4859564817179', 'waypoint', NULL, 36),
('D36', '-5.172712527333914', '119.48578366675629', 'waypoint', NULL, 37),
('D37', '-5.172538638405058', '119.48561669911291', 'waypoint', NULL, 38),
('D38', '-5.1723580594486265', '119.485452737558', 'waypoint', NULL, 39),
('D39', '-5.1721972479541165', '119.48560293308711', 'waypoint', NULL, 40),
('D40', '-5.172163093536781', '119.48595302471732', 'waypoint', NULL, 41),
('D41', '-5.171861237931722', '119.48626311570703', 'waypoint', NULL, 42),
('D42', '-5.171651274592037', '119.48639077564147', 'waypoint', NULL, 43),
('D43', '-5.171994041439035', '119.4857819881999', 'waypoint', NULL, 44),
('D44', '-5.171833229852027', '119.48591715997192', 'waypoint', NULL, 45),
('D45', '-5.171679897844214', '119.48608774487974', 'waypoint', NULL, 46),
('D46', '-5.172016094767542', '119.48541848901236', 'waypoint', NULL, 47),
('D47', '-5.171829638792971', '119.48558585451447', 'waypoint', NULL, 48),
('D48', '-5.171866502592536', '119.48525314405131', 'waypoint', NULL, 49),
('D49', '-5.17167897807424', '119.48541621703968', 'waypoint', NULL, 50),
('D50', '-5.171668218990533', '119.48574342268377', 'waypoint', NULL, 51),
('D51', '-5.173365502692818', '119.48609927674661', 'waypoint', NULL, 52),
('D52', '-5.172890548460288', '119.48561096329558', 'waypoint', NULL, 54),
('S2', '-5.171849518728152', '119.48541602698752', 'shelter', 'Mesjid 2', 55);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kawasan`
--
ALTER TABLE `kawasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waypoint`
--
ALTER TABLE `waypoint`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kawasan`
--
ALTER TABLE `kawasan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `waypoint`
--
ALTER TABLE `waypoint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
