-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2023 pada 05.05
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jumantik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `nik_user` varchar(20) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `tanggal_laporan` datetime NOT NULL,
  `tanggal_pemantauan` datetime DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `nik_user`, `id_admin`, `foto`, `deskripsi`, `tanggal_laporan`, `tanggal_pemantauan`, `status`) VALUES
(83, '0000000000000000', NULL, '/upload/1698807221_2136080873.jpg', 'testttt', '2023-11-10 08:32:09', '2023-11-10 09:07:39', '0'),
(85, '0909878765654345', NULL, '/upload/1698807221_2136080873.jpg', 'testt', '2023-11-10 08:36:44', '2023-11-10 09:07:48', '1'),
(89, '5654426351425362', NULL, '/upload/1698807221_2136080873.jpg', '', '2023-11-10 09:33:48', '2023-11-10 09:34:16', '0'),
(90, '0987987654657654', NULL, '/upload/1698807221_2136080873.jpg', 'test', '2023-11-10 09:41:21', '2023-11-13 08:44:51', '0'),
(137, '8989898989898922', NULL, '/upload/1698807221_2136080873.jpg', NULL, '2023-11-22 02:22:54', '2023-11-22 08:27:42', '0'),
(138, '5643189763421594', NULL, '/upload/1698807221_2136080873.jpg', 'bebas', '2023-11-22 02:42:26', '2023-11-22 23:24:30', '0'),
(141, '7777777777777777', 16, '/upload/1698807221_2136080873.jpg', 'bebas', '2023-11-22 17:25:03', '2023-11-24 11:02:59', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_admin`
--

CREATE TABLE `tabel_admin` (
  `id_admin` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_masuk` datetime DEFAULT NULL,
  `tanggal_update_password` datetime DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `tugas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_admin`
--

INSERT INTO `tabel_admin` (`id_admin`, `nik`, `nama_lengkap`, `username`, `password`, `tanggal_masuk`, `tanggal_update_password`, `role`, `tugas`) VALUES
(3, '3506200989872614', 'Dwi', 'admindwi', '$2y$10$P5lvQWKm6RvjAKwPJ4pdj.Kkm4ASR8dYvN4PCc.dw1LsM.dV2w1g6', '2023-11-17 04:00:58', NULL, 'super_admin', ''),
(4, '3209897870008901', 'amelia putri fitria', 'adminamelia', '$2y$10$A0qe/7Ef0Z2B5P7FHf8wLO9SfBXf5Tq09MmEZdM9xwPz8a3oC5bTO', '2023-11-17 04:02:31', NULL, 'super_admin', ''),
(5, '1122334455667788', 'Super Admin', 'siantikbulusari', '$2y$10$AHr6WcwRSwbQkDiyVrY82uZl9mSBPRRSq.a38sJxSGrguTr7ZxNVa', '2023-11-17 04:02:31', NULL, 'super_admin', ''),
(16, '1234567890123456', 'Johan Indra Maulana', 'admin', '$2y$10$t9gVabB0TjTe4E7HzMig0OxWH0acFB1r.NFoUEpald/WjvAKd1kB6', '2023-11-22 22:11:22', '2023-11-22 23:37:15', 'admin', 'desa_bulusari'),
(17, '1234567890123457', 'Farid Kurniawan', 'admin2', '$2y$10$fAp26GwAZlK1dXa0MIrUmeV/cuX1BWlOgXxj/Idq41KHdfwv8hbZO', '2023-11-22 22:11:44', '2023-11-22 23:37:40', 'admin', 'dusun_pojok'),
(18, '1234567890123458', 'Muhammad Reza Fadillah', 'admin3', '$2y$10$9.FpC1/l4oa8vLvjIZdvd.ZnpIFVsl4cOcIvZg0z2WjkAG.iANatG', '2023-11-22 22:12:11', NULL, 'admin', 'dusun_bulusari_utara'),
(19, '1234567890123459', 'Ananda Dwi Ariano', 'admin4', '$2y$10$SSnNW8cV1.R5IN6SAHvsDe5vv1HRT4uY0SbIuIY7bWp2bIftmZsP2', '2023-11-22 22:12:36', NULL, 'admin', 'dusun_bulusari_selatan'),
(20, '1234567890123450', 'Siti Septia', 'admin5', '$2y$10$w/JhXfNKaw7dw0TuYtR47el7eTRTeSgo.Y3gOyip.s.jfFU.PplPe', '2023-11-22 22:13:34', NULL, 'admin', 'dusun_selang'),
(21, '1234567890123451', 'Refi Eka', 'admin6', '$2y$10$f7Zvtv1zuZjBf7.0bD4oO.QH/CctPG/fWSHmrMlYv6JiW7BwVTOl.', '2023-11-22 22:14:08', NULL, 'admin', 'dusun_gunung_butak'),
(22, '1234567890123452', 'Admin Selang', 'admin7', '$2y$10$vFHa7OekrTzeVcsiPaobteAVpuGaMQkeLSp6zhJ6zWPR.EvlJ61VS', '2023-11-22 22:14:37', NULL, 'admin', 'dusun_sawur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nik_user` varchar(20) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `rt_rw` varchar(5) NOT NULL,
  `no_rumah` varchar(3) DEFAULT NULL,
  `password_user` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nik_user`, `nama_user`, `rt_rw`, `no_rumah`, `password_user`, `created_at`) VALUES
('0000000000000000', 'test3', '01/01', '09', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:01:06'),
('0909878765654345', 'test4', '03/02', '06', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:37:19'),
('0987987654657654', 'test7', '03/05', '05', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:01:27'),
('5248852136452165', 'test13', '01/03', '08', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:23:53'),
('5643189763421594', 'test11', '11/03', '08', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 14:51:50'),
('5654426351425362', 'test6', '01/04', '07', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:37:35'),
('5655345243565654', '  spasi  ', '09/03', '07', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:23:08'),
('6597845235697523', 'test12', '08/06', '08', '25d55ad283aa400af464c76d713c07ad', '2023-11-13 01:27:54'),
('7676565634526388', 'spasi', '06/01', '08', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:23:01'),
('7777777777777777', 'test2', '07/06', '07', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:22:49'),
('8667666637367367', 'hoho', '04/03', '09', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:22:38'),
('8989898989898922', 'aku', '01/03', '08', '25d55ad283aa400af464c76d713c07ad', '2023-11-22 15:22:29');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `nik_user` (`nik_user`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `tabel_admin`
--
ALTER TABLE `tabel_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nik_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `tabel_admin`
--
ALTER TABLE `tabel_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`nik_user`) REFERENCES `user` (`nik_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `tabel_admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
