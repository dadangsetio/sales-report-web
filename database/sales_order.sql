-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jul 2021 pada 04.01
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_order`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kdBarang` char(8) NOT NULL,
  `idKategori` int(11) NOT NULL,
  `idUser` char(8) NOT NULL,
  `namaBarang` varchar(64) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `isAccept` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kdBarang`, `idKategori`, `idUser`, `namaBarang`, `harga`, `stok`, `isAccept`) VALUES
('B2000002', 2, '', 'Genting Makmur', 3000, 2870, 1),
('B2000003', 2, '', 'Asbes FFW', 50000, 100, 1),
('B2000004', 6, '', 'Semen Tiga Roda', 100000, 100, 1),
('B2000005', 3, '', 'Nippon Paint', 82000, 100, 1),
('B2000006', 3, '', 'No Drop Paint', 750000, 120, 0),
('B2100001', 3, 'U002', 'ayamku', 2000, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idKategori` int(11) NOT NULL,
  `namaKategori` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idKategori`, `namaKategori`) VALUES
(2, 'Atap'),
(3, 'Cat Tembok'),
(4, 'Cat Kayu'),
(6, 'Semen'),
(7, 'Pemadam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `keranjang`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `keranjang` FOR EACH ROW UPDATE barang SET stok = stok - NEW.qty WHERE barang.kdBarang = NEW.kdBarang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reset_stok` BEFORE DELETE ON `keranjang` FOR EACH ROW UPDATE barang SET stok = stok + OLD.qty WHERE barang.kdBarang = OLD.kdBarang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `idkunjungan` int(11) NOT NULL,
  `nama_cv` varchar(200) NOT NULL,
  `nama_client` varchar(200) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `nama_sales` varchar(100) NOT NULL,
  `tgl_kunjungan` varchar(100) NOT NULL,
  `jam_kunjungan` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kunjungan`
--

INSERT INTO `kunjungan` (`idkunjungan`, `nama_cv`, `nama_client`, `no_hp`, `alamat`, `nama_sales`, `tgl_kunjungan`, `jam_kunjungan`) VALUES
(4, 'Pertamina', 'Agus', '0895366653107', 'Jl.Lakarsantri No.25A Surabaya', 'feriyan', '23/06/2021', '09:13:18'),
(6, 'belajarbareng', 'abdul', '+628135857737', 'RT.03 RW.05 Semanding, Sumber Mulyo', 'Dadang Bagus Setiyobudi', '27/07/2021', '13:56:06'),
(7, 'surya', 'prapto', '23434', 'ajnjadn', 'Dadang Bagus Setiyobudi', '27/07/2021', '13:56:28'),
(8, 'Cipta', 'karyanyo', '1231', 'amdad', 'budi', '27/07/2021', '13:56:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `idTransaksi` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `idUser` char(4) NOT NULL,
  `namaPelanggan` varchar(64) NOT NULL,
  `alamatPelanggan` varchar(128) NOT NULL,
  `totalHarga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `tanggal`, `idUser`, `namaPelanggan`, `alamatPelanggan`, `totalHarga`) VALUES
('T210623001', '2021-06-23', 'U002', 'Umum', '-', 1500000),
('T210623002', '2021-06-23', 'U002', 'Umum', '-', 1500000),
('T210623003', '2021-06-23', 'U002', 'Umum', '-', 1500000),
('T210623004', '2021-06-23', 'U002', 'Umum', 'malang', 3100000),
('T210624001', '2021-06-24', 'U002', 'Umum', '-', 750000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `idTransaksi` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`idTransaksi`, `kdBarang`, `qty`, `subtotal`) VALUES
('T210623001', 'B2000006', 20, 1500000),
('T210623002', 'B2000006', 20, 1500000),
('T210623003', 'B2000006', 20, 1500000),
('T210623004', 'B2000002', 10, 30000),
('T210623004', 'B2000003', 10, 500000),
('T210623004', 'B2000004', 10, 1000000),
('T210623004', 'B2000005', 10, 820000),
('T210623004', 'B2000006', 10, 750000),
('T210624001', 'B2000006', 10, 750000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `idUser` char(4) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL,
  `level` enum('administrator','sales') NOT NULL,
  `nama` varchar(64) NOT NULL,
  `noTelp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `level`, `nama`, `noTelp`) VALUES
('U002', 'admin2', '$2y$10$bvKo6g4g91BoXO81PuW3Eufsiq5Jy4QkydSLQMFyjbEFG2BH3GRgO', 'administrator', 'feriyan', '0895366653107'),
('U003', 'sales2', '$2y$10$.zVL2nLfbOM84WDMO4.R9OOof6GvsCPVqr7MfVEETjb/LUzEcFBHm', 'sales', 'Yohanes', '0895678987567'),
('U004', 'dadang', '$2y$10$ahMQbR36qjhZg9xwVgCyxObrsbNTX6J.da.6SDhYViAZsi3Bxn.8u', 'sales', 'Dadang Bagus Setiyobudi', '01277328723'),
('U005', 'budi', '$2y$10$wZcZXi2YUyyD5lSif0msQ.5PW18ZgCzLuqnHb.xd7P5jXO9g/zBx.', 'sales', 'budi', '23445');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kdBarang`),
  ADD KEY `idKategori` (`idKategori`),
  ADD KEY `idUser_2` (`idUser`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idKategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`idkunjungan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idTransaksi`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD KEY `idTransaksi` (`idTransaksi`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idKategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `idkunjungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idKategori`) REFERENCES `kategori` (`idKategori`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`),
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`idTransaksi`) REFERENCES `transaksi` (`idTransaksi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
