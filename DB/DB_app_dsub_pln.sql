-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2020 at 02:58 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DB_app_dsub_pln`
--

-- --------------------------------------------------------

--
-- Table structure for table `atasan`
--

CREATE TABLE `atasan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `atasan`
--

INSERT INTO `atasan` (`id`, `nama`) VALUES
(1, 'Administrator'),
(2, 'Apar'),
(3, 'FASOP AM'),
(4, 'FASOP SPV'),
(5, 'HAR 20 KV AM'),
(6, 'HAR 20 KV SPV'),
(7, 'K3L Administrator'),
(8, 'KSA AM'),
(9, 'KSA SPV'),
(10, 'Manager'),
(11, 'OPSISDIS AM'),
(12, 'OPSISDIS SPV'),
(13, 'Pengadaan SPV'),
(14, 'Perencanaan AM'),
(15, 'Perencanaan SPV');

-- --------------------------------------------------------

--
-- Table structure for table `atk`
--

CREATE TABLE `atk` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `no_notadinas` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `atk`
--

INSERT INTO `atk` (`id`, `tanggal`, `id_user`, `no_notadinas`) VALUES
(6, '2020-03-19 13:00:43', 1, 'DSUB-00001'),
(7, '2020-03-19 14:36:35', 1, 'DSUB-00002');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `satuan` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `satuan`) VALUES
(1, 'Pena', 'Pcs'),
(2, 'Bedak', 'Pcs'),
(3, 'Penghapus', 'Box');

-- --------------------------------------------------------

--
-- Table structure for table `buku_tamu`
--

CREATE TABLE `buku_tamu` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `no_identitas` varchar(20) DEFAULT NULL,
  `no_polisi` varchar(20) DEFAULT NULL,
  `id_atasan` int(11) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `id_petugas_masuk` int(11) DEFAULT NULL,
  `id_petugas_keluar` int(11) DEFAULT NULL,
  `term` int(11) DEFAULT NULL,
  `tanggal_kunjungan` datetime DEFAULT NULL,
  `tanggal_keluar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `is_head_office` tinyint(1) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id`, `nama`, `telp`, `fax`, `email`, `keterangan`, `alamat`, `is_head_office`, `logo`, `status`, `created_by`, `created_date`, `modified_date`) VALUES
(3, 'UPT Banten Utara', '', '', '', '', '', 1, '', 1, NULL, '2020-02-11 23:01:46', '2020-02-11 23:41:41'),
(4, 'ULP Serang', '', '', '', '', '', 1, '', 1, NULL, '2020-02-11 23:02:03', '2020-02-11 23:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `ceklis_kendaraan`
--

CREATE TABLE `ceklis_kendaraan` (
  `id` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `id_jenis_kendaraan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kondisi` varchar(1) DEFAULT NULL COMMENT '1 = ''Terima'' 2 = ''Pengembalian''',
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ceklis_kendaraan_detail`
--

CREATE TABLE `ceklis_kendaraan_detail` (
  `id` int(11) NOT NULL,
  `id_ceklis_kendaraan` int(11) NOT NULL,
  `cek_value` varchar(1) DEFAULT NULL COMMENT '1 = ''Baik'' 2 = ''Buruk'' 3 = ''Tidak Tersedia''',
  `id_list_komponen_ceklis` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_hadir`
--

CREATE TABLE `daftar_hadir` (
  `id` int(11) NOT NULL,
  `id_peminjaman_ruangan` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL COMMENT '''Hadir'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `daftar_hadir`
--

INSERT INTO `daftar_hadir` (`id`, `id_peminjaman_ruangan`, `id_users`, `waktu`, `status`) VALUES
(1, 14, 1, '2020-03-02 23:31:24', 'Hadir'),
(2, 22, 1, '0000-00-00 00:00:00', 'Hadir');

-- --------------------------------------------------------

--
-- Table structure for table `detail_atk`
--

CREATE TABLE `detail_atk` (
  `id` int(11) NOT NULL,
  `id_atk` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `qty_request` double DEFAULT NULL,
  `qty_approval` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_atk`
--

INSERT INTO `detail_atk` (`id`, `id_atk`, `id_barang`, `qty_request`, `qty_approval`) VALUES
(1, 6, 1, 30, 30),
(2, 6, 2, 25, 20),
(3, 6, 3, 15, 10),
(4, 7, 1, 5, 3),
(5, 7, 2, 20, 10);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_atasan` int(11) DEFAULT NULL,
  `id_kategori_divisi` int(11) NOT NULL,
  `is_allow_login` tinyint(1) DEFAULT NULL,
  `is_need_approval` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama`, `id_atasan`, `id_kategori_divisi`, `is_allow_login`, `is_need_approval`, `created_by`, `created_date`, `modified_date`) VALUES
(1, 'Administrator', NULL, 1, 1, 1, NULL, '2020-02-12 00:56:43', '2020-02-13 22:04:08'),
(25, 'Travel Admin', NULL, 1, 1, 1, 1, '2020-03-05 21:48:01', NULL),
(26, 'Koordinator Driver', NULL, 1, 1, 1, 1, '2020-03-05 21:51:10', '2020-03-19 05:50:11'),
(27, 'Keuangan', NULL, 1, 1, 1, 1, '2020-03-12 22:02:26', NULL),
(28, 'SDM dan Umum', NULL, 1, 1, 1, 1, '2020-03-12 22:02:49', NULL),
(29, 'Perencanaan', NULL, 1, 1, 1, 1, '2020-03-12 22:03:02', NULL),
(30, 'Niaga dan Pelayanan Pelanggan', NULL, 1, 1, 1, 1, '2020-03-12 22:03:26', NULL),
(31, 'Distribusi', NULL, 1, 1, 1, 1, '2020-03-12 22:03:43', NULL),
(32, 'K3L dan KAM', NULL, 1, 1, 1, 1, '2020-03-12 22:04:09', NULL),
(33, 'Driver', NULL, 1, 1, 1, 1, '2020-03-12 22:04:42', '2020-03-12 22:21:00'),
(34, 'Security', NULL, 1, 1, 1, 1, '2020-03-12 22:04:53', '2020-03-12 22:21:14'),
(35, 'User', NULL, 5, NULL, 1, 1, '2020-03-12 22:10:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kendaraan`
--

CREATE TABLE `jenis_kendaraan` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `jenis_kendaraan`
--

INSERT INTO `jenis_kendaraan` (`id`, `kode`, `nama`, `status`, `created_date`, `modified_date`) VALUES
(1, 'RD', 'Roda Dua', NULL, '2020-02-11 23:03:53', NULL),
(2, 'RE', 'Roda Empat', NULL, '2020-02-11 23:04:01', NULL),
(3, 'RT', 'Roda Tiga', NULL, '2020-02-11 23:04:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_divisi`
--

CREATE TABLE `kategori_divisi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kategori_divisi`
--

INSERT INTO `kategori_divisi` (`id`, `nama`) VALUES
(1, 'Administrator'),
(2, 'Manager'),
(3, 'Assistant Manager'),
(4, 'Supervisor'),
(5, 'User'),
(6, 'Driver'),
(7, 'Security');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `nopol` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `id_jenis_kendaraan` int(11) DEFAULT NULL,
  `kapasitas` int(10) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `nopol`, `nama`, `id_jenis_kendaraan`, `kapasitas`, `foto`, `id_users`, `created_date`, `modified_date`) VALUES
(2, 'B 2853 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(3, 'B 1622 BJW', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(4, 'B 2045 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(5, 'B 2862 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(6, 'B 2537 SKI', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(7, 'B 2766 BID', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(8, 'B 2748 BID', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(9, 'B 2086 BIG', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(10, 'B 2205 BOR', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(11, 'B 2851 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(12, 'B 2839 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(13, 'B 2886 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(14, 'B 2872 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(15, 'B 2868 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(16, 'B 2843 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(17, 'B 2864 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(18, 'B 2845 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(19, 'B 2821 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(20, 'B 2537 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(21, 'B 2857 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(22, 'B 2848 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL),
(23, 'B 2870 BIF', 'Avanza', 1, 8, 'avanza.png', 1, '2020-02-16 13:51:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `list_komponen_ceklis`
--

CREATE TABLE `list_komponen_ceklis` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `list_komponen_ceklis`
--

INSERT INTO `list_komponen_ceklis` (`id`, `nama`) VALUES
(1, 'Bumper Depan'),
(2, 'Bumber Belakang'),
(3, 'Lampu Depan Kanan'),
(4, 'Lampu Depan Kiri'),
(5, 'Lampu Stop Belakang Kanan'),
(6, 'Lampu Stop Belakang Kiri'),
(7, 'Fender Depan Kanan'),
(8, 'Fender Depan Kiri'),
(9, 'Fender Belakang Kanan'),
(10, 'Fender Belakang Kiri'),
(11, 'Kap Mesin'),
(12, 'Kab Belakang / Pintu'),
(13, 'Roda Depan Kanan'),
(14, 'Roda Depan Kiri'),
(15, 'Roda Belakang Kanan'),
(16, 'Roda Belakang Kiri'),
(17, 'Pintu Depan Kanan'),
(18, 'Pintu Depan Kiri'),
(19, 'Pintu Belakang Kanan'),
(20, 'Pintu Belakang Kiri'),
(21, 'Atap'),
(22, 'AC'),
(23, 'Oli'),
(24, 'Tekanan Ban'),
(25, 'Klakson'),
(26, 'Radiator'),
(27, 'Radio/Tape/CD'),
(28, 'Wiper'),
(29, 'Kebersihan Dalam Mobil'),
(30, 'Kebersihan Luar Mobil'),
(31, 'Karpet Depan'),
(32, 'Karpet Belakang'),
(33, 'KM Awal'),
(34, 'KM Akhir');

-- --------------------------------------------------------

--
-- Table structure for table `makan_siang`
--

CREATE TABLE `makan_siang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_kendaraan`
--

CREATE TABLE `peminjaman_kendaraan` (
  `id` int(11) NOT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `voucher` varchar(15) DEFAULT NULL,
  `is_use_driver` varchar(1) DEFAULT NULL,
  `id_driver` int(11) DEFAULT NULL,
  `tujuan` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_start_peminjaman` datetime NOT NULL,
  `tgl_end_peminjaman` datetime NOT NULL,
  `no_dokumen` varchar(100) DEFAULT NULL,
  `dokumen_status` enum('Menunggu','Disetujui','Ditolak','Selesai','Kadaluarsa','Pending','Batal') DEFAULT 'Menunggu',
  `id_atasan` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `km_awal` varchar(10) DEFAULT NULL,
  `tgl_input_km_awal` datetime DEFAULT NULL,
  `km_akhir` varchar(10) DEFAULT NULL,
  `tgl_input_km_akhir` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `peminjaman_kendaraan`
--

INSERT INTO `peminjaman_kendaraan` (`id`, `id_kendaraan`, `voucher`, `is_use_driver`, `id_driver`, `tujuan`, `keterangan`, `tgl_start_peminjaman`, `tgl_end_peminjaman`, `no_dokumen`, `dokumen_status`, `id_atasan`, `id_users`, `created_date`, `modified_date`, `km_awal`, `tgl_input_km_awal`, `km_akhir`, `tgl_input_km_akhir`) VALUES
(36, 2, '10', '1', 399, 'Tangerang', 'test', '2020-03-19 05:44:00', '2020-03-20 14:40:00', 'FM-SMK3-VHC-0003', 'Selesai', 1, 1, '2020-03-19 05:45:02', '2020-03-19 06:31:25', '20', '2020-03-19 07:58:26', '25', '2020-03-19 08:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_kendaraan_persetujuan`
--

CREATE TABLE `peminjaman_kendaraan_persetujuan` (
  `id` int(11) NOT NULL,
  `id_peminjaman_kendaraan` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `status_dokumen` enum('Menunggu','Disetujui','Ditolak','Selesai') DEFAULT 'Menunggu',
  `signature` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `peminjaman_kendaraan_persetujuan`
--

INSERT INTO `peminjaman_kendaraan_persetujuan` (`id`, `id_peminjaman_kendaraan`, `id_users`, `label`, `status_dokumen`, `signature`, `keterangan`, `status`, `created_date`, `modified_date`) VALUES
(39, 36, 394, NULL, 'Selesai', 'data:image/png;base64,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', 'testt', NULL, '2020-03-19 05:45:02', '2020-03-19 06:31:25'),
(40, 36, 1, NULL, 'Selesai', NULL, NULL, NULL, '2020-03-19 05:45:02', NULL),
(41, 36, 395, NULL, 'Selesai', 'data:image/png;base64,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', 'test', NULL, '2020-03-19 05:45:02', '2020-03-19 06:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_kendaraan_personil`
--

CREATE TABLE `peminjaman_kendaraan_personil` (
  `id` int(11) NOT NULL,
  `id_peminjaman_kendaraan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `peminjaman_kendaraan_personil`
--

INSERT INTO `peminjaman_kendaraan_personil` (`id`, `id_peminjaman_kendaraan`, `nama`, `divisi`, `jabatan`, `telp`) VALUES
(12, 36, 'dfsd', 'asdas', 'sdsad', '42423');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_ruangan`
--

CREATE TABLE `peminjaman_ruangan` (
  `id` int(11) NOT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `nama_kegiatan` varchar(100) DEFAULT NULL,
  `id_makan_siang` int(11) DEFAULT NULL,
  `makan_siang` varchar(10) DEFAULT NULL COMMENT '''Ada'' / ''Tidak''',
  `jumlah_orang_makan_siang` varchar(15) DEFAULT NULL,
  `snack` varchar(10) DEFAULT NULL COMMENT '''Ada'' / ''Tidak''',
  `jumlah_orang_snack` varchar(15) DEFAULT NULL,
  `id_snack` int(11) DEFAULT NULL,
  `jumlah_orang` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_start` datetime DEFAULT NULL,
  `tgl_end` datetime DEFAULT NULL,
  `no_dokumen` varchar(100) DEFAULT NULL,
  `status_dokumen` enum('Menunggu','Disetujui','Ditolak','Selesai') DEFAULT 'Menunggu',
  `id_users` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `peminjaman_ruangan`
--

INSERT INTO `peminjaman_ruangan` (`id`, `id_ruangan`, `nama_kegiatan`, `id_makan_siang`, `makan_siang`, `jumlah_orang_makan_siang`, `snack`, `jumlah_orang_snack`, `id_snack`, `jumlah_orang`, `keterangan`, `tgl_start`, `tgl_end`, `no_dokumen`, `status_dokumen`, `id_users`, `created_by`, `created_date`, `modified_date`) VALUES
(22, 1, 'Rapat', NULL, 'Ada', '10', 'Tidak', NULL, NULL, '10', '', '2020-03-19 09:23:00', '2020-03-20 10:20:00', 'FM-SMK3-BLD-0001', 'Disetujui', 1, 1, '2020-03-19 09:25:00', '2020-03-19 09:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_ruangan_persetujuan`
--

CREATE TABLE `peminjaman_ruangan_persetujuan` (
  `id` int(11) NOT NULL,
  `id_peminjaman_ruangan` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_dokumen` enum('Menunggu','Disetujui','Ditolak','Selesai') DEFAULT 'Menunggu',
  `signature` text DEFAULT NULL,
  `tipe_persetujuan` enum('Wajib','Optional') DEFAULT 'Wajib',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `peminjaman_ruangan_persetujuan`
--

INSERT INTO `peminjaman_ruangan_persetujuan` (`id`, `id_peminjaman_ruangan`, `id_users`, `keterangan`, `status_dokumen`, `signature`, `tipe_persetujuan`, `created_date`, `modified_date`) VALUES
(6, 22, 1, 'test', 'Disetujui', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAooAAAD6CAYAAAAmyWZkAAAdwUlEQVR4Xu3dD7BkWV0f8HN6980MuhhZJ25Ydnanb092i4nyx0GQJPiPBAOKJWVQoDBgSq3A4p8YS1MxuLtoKmr+KBGxCioRogUm0YISw2pcwIQgf2RhIWb2j9OnHzvr6JJlTXCR2ZmdPqkz9KOa59uZ+96c97r73k9XTc3OvHt/9/w+v172y+2+98bgRYAAAQIECBAgQGALgUiFAAECBAgQIECAwFYCgqL3BQECBAgQIECAwJYCgqI3BgECBAgQIECAgKDoPUCAAAECBAgQINBewBnF9la2JECAAAECBAj0SkBQ7NW4NUuAAAECBAgQaC8gKLa3siUBAgQIECBAoFcCgmKvxq1ZAgQIECBAgEB7AUGxvZUtCRAgQIAAAQK9EhAUezVuzRIgQIAAAQIE2gsIiu2tbEmAAAECBAgQ6JWAoNircWuWAAECBAgQINBeQFBsb2VLAgQIECBAgECvBATFXo1bswQIECBAgACB9gKCYnsrWxIgQIAAAQIEeiUgKPZq3JolQIAAAQIECLQXEBTbW9mSAAECBAgQINArAUGxV+PWLAECBAgQIECgvYCg2N7KlgQIECBAgACBXgkIir0at2YJECBAgAABAu0FBMX2VrYkQIAAAQIECPRKQFDs1bg1S4AAAQIECBBoLyAotreyJQECBAgQIECgVwKCYq/GrVkCBAgQIECAQHsBQbG9lS0JECBAgAABAr0SEBR7NW7NEiBAgAABAgTaCwiK7a1sSYAAAQIECBDolYCg2Ktxa5YAAQIECBAg0F5AUGxvZUsCBAgQIECAQK8EBMVejVuzBAgQIECAAIH2AoJieytbEiBAgAABAgR6JSAo9mrcmiVAgAABAgQItBcQFNtb2ZIAAQIECBAg0CsBQbFX49YsAQIECBAgQKC9gKDY3sqWBAgQIECAAIFeCQiKvRq3ZgkQIECAAAEC7QUExfZWtiRAgAABAgQI9EpAUOzVuDVLgAABAgQIEGgvICi2t7IlAQIECBAgQKBXAoJir8atWQIECBAgQIBAewFBsb2VLQkQIECAAAECvRIQFHs1bs0SIECAAAECBNoLCIrtrWxJgAABAgQIEOiVgKDYq3FrlgABAgQIECDQXkBQbG9lSwIECBAgQIBArwQExV6NW7MECBAgQIAAgfYCgmJ7K1sSIECAAAECBHolICj2atyaJUCAAAECBAi0FxAU21vZkgABAgQIECDQKwFBsVfj1iwBAgQIECBAoL2AoNjeypYECBAgQIAAgV4JCIq9GrdmCRAgQIAAAQLtBQTF9la2JECAAAECBAj0SkBQ7NW4NUuAAAECBAgQaC8gKLa3siUBAgQIECBAoFcCgmKvxq1ZAgQIECBAgEB7AUGxvZUtCRAgQIAAAQK9EhAUezVuzRIgQIAAAQIE2gsIiu2tbEmAAAECBAgQ6JWAoNircWuWAAECBAgQINBeQFBsb2VLAgQIECBAgECvBATFXo1bswQIECBAgACB9gKCYnsrWxIgQIAAAQIEeiUgKPZq3JolQIAAAQIECLQXEBTbW9mSAAECBAgQINArAUGxV+PWLAECBAgQIECgvYCg2N7KlgQIECBAgACBXgkIir0at2aXVaBpmptTSjcv6/qsiwABAgT6KSAo9nPuul4SgaZpXh9C+GQI4aaUkn8fl2QulkGAAAECnxPwHybvBAILFChnEktInFvCLc4sLnAgDk2AAAECXyAgKHpDEFiQwBYhsaxEUFzQPByWAAECBP6ygKDoXUFgQQKC4oLgHZYAAQIEWgsIiq2pbEigrsAWQfFjIYQ3pJTK9xa9CBAgQIDAwgUExYWPwAL6KrDVGcWzZ88+4eTJk6f6aqJvAgQIEFguAUFxueZhNT0S2CIo3pZS+rs9ItAqAQIECCy5gKC45AOyvO4KzAfFnPNnYoy3ppRe2N2OdUaAAAECqyYgKK7axKy3MwJbnFF8Vkrpf3amQY0QIECAwMoLCIorP0INrKrAcDj8qRjjj2+s//Tp01986tSpv1jVfqybAAECBLonICh2b6Y6WhGBpmn+fQjhH86W+8mU0lUrsnTLJECAAIGeCAiKPRm0NpdPoGmaPwohHCkryznfMZlMnrp8q7QiAgQIEOizgKDY5+nrfWECw+Hw+THG35xbwFtTSi9Z2IIcmAABAgQIbCEgKHpbENhjgUOHDl29trb24RDC4+cO7dF9ezwHhyNAgACBiwsIihc3sgWBqgJN07wjhPAtm4oKilWVFSNAgACBGgKCYg1FNQi0FBiNRq8OITw75/x1gmJLNJsRIECAwMIEBMWF0Ttw3wRGo9E35JzfPev7fSGEcyGEr539+eaU0i19M9EvAQIECCy3gKC43POxuo4IHD16dN/DDz98R875iaWlGOPv5JzfH0K4WVDsyJC1QYAAgQ4KCIodHKqWlk9gNBq9Ief8vbOVPRRjfGrO+aUhhJtmf+c7iss3NisiQIBA7wUExd6/BQDstsBoNHpZzvlNG8eJMb58PB6/edMj/ATF3R6E+gQIECCwbQFBcdtkdiDQXmA0Gh3JOX80hHBF2SvG+MbxePx95Z9XNSjO1h1SShsfm7cHsSUBAgQIrJSAoLhS47LYVRMYjUa/nXP+pllIvHP//v1POX78+JlVDIpN07w+hHD/xvcqc84vDCEcnkwm/3rV5mK9BAgQINBOQFBs52QrAtsWaJrmrSGEr5j9KmcTv3E8Hr9no9CmM4q3ppSet+2D7NEOTdP8Ys75aIzx6zcd8nSM8frxeHxyj5biMAQIECCwhwKC4h5iO1Q/BMqTV/bt2/eWjXsl5pz/02Aw+N/j8fgn5wVGo9E/mF3g8rdDCB9PKT15GYVmZxJfUdaWc/69GGP5GP0JG0+WyTm/eTKZvHwZ125NBAgQIHBpAoLipfnZm8AXCDRN89UhhHImcTT3g59JKf3TzVSHDx8+MBgMPhlCeOzsZ9+SUvqvy0Q6HxJn63p9SunG0Wj03JzzOzfWGmN83ng8vnWZ1m4tBAgQIHDpAoLipRuqQOC8wGg0ekHO+S0hhAMbJDnnH5hMJr/waERN0/zbEMI/nv387SmlFywD59GjR684ffp0uVL7UAjh6bM1/VJK6ZUb6xsOh2+KMb5s9ufbU0pPW4a1WwMBAgQI1BMQFOtZqtRjgeFw+P0xxn83R1C+u/eS8Xj8tguxXHfddU+87LLLjm9sc+7cuaOf+MQn7lwkZdM0JfD98sZ3K0MI5Uzh+nxInAXjQznne0owjjF+YDqdvncymfzoItfu2AQIECBQV0BQrOupWo8EhsPhcyaTyX9rmuanQwg/Ntf6OITw4pTSH7ThaJqmhMlvm237cymlH26z325sMxwOXzoYDH4553z5Rv0Y478Yj8f/fKvjDYfDnw0hPCvG+DUhBBe27MZQ1CRAgMACBQTFBeI79GoLzG59UwLSvSGEryzdxBj/+5kzZ15y8uTJU227a5rmm0MIv1W2zzl/Jud8cH19/XTb/WttNxwO3xhj/J65gPjIdDr97slk8qsXOkbTNB8OIRybrd+FLbUGog4BAgSWQEBQXIIhWMLqCZSzieV5zXMr/0wI4X0ppfP3TNzuq2maj4UQnhRCeCCEUB7x98q9ujikaZpvnz1KMM/WUJb/hyGE704plRB4wZcLWy4m5OcECBBYXQFBcXVnZ+ULFGiapnw8XD5yXtu0jH+WUvqX213acDh81WAweFzO+TUb+5bbzgwGg1fv1j0KR6PRsZxzedb08+fWW65k/uyBAwdefvz48Yfa9uHClrZStiNAgMBqCQiKqzUvq10SgdFo9IbZPRA3r6h83/BPN1/40WbZw+HwR2KM5V6Ln79qunzvL+f8uyGEN06n0xMHDx48cfvtt59tU+/Rtrn++usPnjt37idyzt+/aZtPl6A6mUz+zXbrj0ajz1/YEkIoF+d8LKX0ku3WsT0BAgQILJeAoLhc87CaFRAYjUYvyzmXW8dsvG4qT13JOT9u7qPbL7iVTNu2SuCaTqc/OXfbmbLrn8/da7F8jzHFGE+EEE7knPfFGP+4bf0QwjNDCOV7lV8yv0+M8Rcuu+yy19xzzz3lo+8dvUrQDSF8dYzxO2YFdmSwo4PbiQABAgR2RUBQ3BVWRbsqMBqNjuScPxpCKE8nKRevvHE8Hn9f+eemaf5D+V7fXO87Dkqz7/2VwPjHOedv3UXPd8QYbxmPx7fXOMYWN+jesUGN9ahBgAABApcmIChemp+9eyYwu9L5/AUrMcY79+/f/5Tjx4+f2WCoHZQOHz78nYPB4GtDCCWgHokxNhvHyjl/Ksb4ZTsYwdtnT465JaX0GzvY/4K71DaovT71CBAgQKC9gKDY3sqWPRaYPankV2KMN+ScnzgLit84Ho/fs5llN4PSsWPH1h544IEjg8GghMYjIYS/st2xTKfTt6+vr9+x3f22s/1mg/kzr9upY1sCBAgQWKyAoLhYf0dfAYEtnlTylhjjXePxuFx4suVrN8PiCpCdX+K8Qfm4fvZc61eNx+Py/UovAgQIEFgBAUFxBYZkiYsT2O6TSuZXuiks3hpj/MijPeFkcR3u7pGLQYzxCXPfsyz3iCxh8c27e2TVCRAgQKCGgKBYQ1GNTgqMRqOfyjn/+EZzMcZWTyrZIiyWp5Y8vfx9zvm7Lvakk65hjkajV8/fH7L0Vz6K3r9//6vmv9/Ztb71Q4AAgS4ICIpdmKIeqgsMh8MbB4PB4+eCYusnlWxeTNM0vx5CKE8/KQHpkZzzM9s88aR6UwssOBqNviGE8Isb3++cWdwZQrhxq+95LnCpDk2AAAECcwKCorcDgS0EmqYpTyh5bs75wfIs58c85jHP2s6TSuZLzi6EeX8I4Stmf/+HBw4ceOZO663qwI4ePbrv4Ycfft0WNyp/Z875lslk8qFV7c26CRAg0FUBQbGrk9XXjgVuuOGGx549e/bTGwWm0+lwfX19fccFP3dhx9NijO/POV8+q/MbKaW/fyk1V3Xf2Q3LXzd3L8pP5ZzLbX5Oxxg/mHP+QPn9zJkzHzx58uSpVe3TugkQINAFAUGxC1PUQ1WB0Wj0opzzW2dFP5RSekaNA5QLY2KMvzKr9e4Y4+9d6MrpGsdc1hrlxuUhhBIW/1/OeeNJLlstdxxC+EAI4eHpdPqv1tfX71rWnqyLAAECXRQQFLs4VT1dkkDTNCXMvXRW5KaU0msuqeDczkeOHPnpc+fOfV2MsTxGr3xncct7MdY63rLXmYXn54YQShgfXWC9kxDCsDy2MITwrpzzu86ePfuu++67r3w1wIsAAQIEdklAUNwlWGVXV6BpmhI+ynObS5B7Wq3H222IXOzpLqsrd2krP3To0NVra2slQD8jxviMnHMJjwdijKdyzlc/SvXfL6ExhHDbZDL5H5e2AnsTIECAwGYBQdF7gsCcwHA4fE6M8Xdmf3UipfTXawNd6HnRtY+16vWGw+HTB4PBP8k57wshPDuE8NgL9PTn5WzjLOCXC2QejDE+OJ1OHxwMBg8+9NBDD95///2fWXUT6ydAgMBeCgiKe6ntWEsvMBwOXxtj/IHZQl+bUvqh3Vj07IKON23UjjG+3E2oLy59+PDh8rH9s8uvEMLffJQ9TpczkY/ys8+GEMoZ4/MhcnZV+/nfY4yfjTF+dDqdpn379k3uvvvuEjy9CBAg0GsBQbHX49f8ZoGmaf4ohFAutCg3x37OZDL53d1SGo1Gb5i7VUx5YslTPd6uvfY111xz5dra2kZoLMGxzK3Mb6dngUuAvHJuBffnnCcxxpRzTuX36XQ6GQwGKaV0b/uV2pIAAQKrKyAoru7srLyywGg0OpZz/vCs7J+llOZDQ+WjhTC7r+AdGzehLh95j8fjv1f9QD0peN111z1xMBh8e4yxfDxdbrdzZYzxypxzmePGr8fs4CzkVrucCSGkEEK5yKb8Xv5822AwuPvEiRPlSm0vAgQIdEJAUOzEGDVRQ6Bpmp8IIdwyq/WrKaXvqlH3QjXKE0tyzu8u28QYfzPn/J6U0s/v9nH7Wv+qq6764iuuuOLK6XR65WAwOB8iy6/BYPCknHP538NmdnV1+b18L7LVK+f8qRhjCaflVULj3eVXjPHu6XR6d875nvLn9fX1/9uqoI0IECCwJAKC4pIMwjIWL9A0zQc3nskcY3zxeDz+tb1YVdM0vxVCODoLKL+fUvpbe3Fcx7iwQNM0106n02YwGAxzzk2Msck5D8vvIYSr5vb+s42r5C9mWq7gnk6n95QAmXN+uJxFdhbyYmp+ToDAIgUExUXqO/bSCBw+fPjwYDAoHyOef62trX3JXl3McO211z7u8ssv//z9AHPOT5lMJh9bGhwL+UsC5ek9Z86cGQ4Gg2Y6nZbvSa6FEK6PMd5wgVv5fEGdZToLeezYsbUHHnjgyGAwOBJjPJJS+jljJ0CAQBEQFL0PCJRTecPhjTHGV4QQ/kYI4daU0vP2EqZpmvIkmBfNjvmzKaUf28vjO1Y9gcOHD39pjPH6EMINg8GgBMcbyj/Pfp3/OHtTSLzgwefPQpb/DxNCOFlhtdeUp92UC4ByziUclrOk519lbZPJ5GCFYyhBgEAHBATFDgxRC5cu0DTNzSGEm2aV3plS+uZLr9q+wnA4fH75juJsj/tSSofa723LVRE4cuTIaDqdlvD4TTHG/ds9C7lXfe7bt+/gXXfd9am9Op7jECCwvAKC4vLOxsr2UGBTULwlpVSC456+mqYpZ4rKmZ5yVudbJ5PJO/Z0AQ62MIE2ZyFDCP8nhPBXay1y81nN2S2AyiMST0yn0/+4vr5evrPrRYBAzwUExZ6/AbT/OYElCYo/E0L40dlMfi2l9GLzIbBxFrKcfQwhfGkFkTyr8emccwmFJw4ePHji9ttvP1uhthIECHRMQFDs2EC1szOBZQiKw+HwyTHGOzY6eOSRR6689957yxW1XgQIECBAYCECguJC2B102QSWISjOzmy+b/ZounLfvY+nlF64bFbWQ4AAAQL9ERAU+zNrnV5AYFmC4nA4fN1gMChPiPmaEMK9KaXrDI4AAQIECCxKQFBclLzjLpXAfFDMOf/2ZDJ57qIW2DTNJ0II186O/0Mppdcuai2OS4AAAQL9FhAU+z1/3c8EhsPhcwaDwQ+X25Ys+kxe0zQ/GELYeIyfs4repQQIECCwMAFBcWH0DrxsAst0Jm9uLe/NOX9oMpn8yLJ5WQ8BAgQIdF9AUOz+jHXYUmCZzuQ1TfPrs4taHh9C+C8ppe9o2YbNCBAgQIBANQFBsRqlQl0QmDuTNw4h3JlSev4i+hoOh0+KMW487/lPU0olMHoRIECAAIE9FRAU95TbwZZdYHZW8WkhhJfO1vpLKaVXLmLdTdP8SQjhr5Vj55yfPJlMPr6IdTgmAQIECPRXQFDs7+x1/igCTdO8PoTwirkfLyQsNk3zn0MI5T6K45zzz08mk9cZGgECBAgQ2EsBQXEvtR1rZQSWISw2TfO2EMK3zdAW8vzplRmYhRIgQIDArggIirvCqmgXBBYdFpflJuBdmKUeCBAgQGBnAoLiztzs1ROBLcLie8+ePfuikydPntptAkFxt4XVJ0CAAIGLCQiKFxPy894LbAqL94cQrgoh3JZzfvsjjzzytpqh8eqrr/6iAwcOfFWM8aum0+kLYoxf76Pn3r8FARAgQGBhAoLiwugdeJUEZmGx/Pvyj7ZY920hhDMhhD/YYU/X55zPlHAYQvjKWY37QgjXzNXzHcUd4tqNAAECBHYuICju3M6ePRMYDoc3xhjLxSV/Zy9bTyn593QvwR2LAAECBD4v4D9A3gwEtilw6NChq9fW1kpgfMEsNJYbYz95m2U2bz5/BvF/5Zw/EmPcH0K4O6V08yXWtjsBAgQIENiRgKC4IzY7EficwFxo/PJLMYkxPljC4enTpz9y6tSpv7iUWvYlQIAAAQK1BATFWpLqECBAgAABAgQ6JiAodmyg2iFAgAABAgQI1BIQFGtJqkOAAAECBAgQ6JiAoNixgWqHAAECBAgQIFBLQFCsJakOAQIECBAgQKBjAoJixwaqHQIECBAgQIBALQFBsZakOgQIECBAgACBjgkIih0bqHYIECBAgAABArUEBMVakuoQIECAAAECBDomICh2bKDaIUCAAAECBAjUEhAUa0mqQ4AAAQIECBDomICg2LGBaocAAQIECBAgUEtAUKwlqQ4BAgQIECBAoGMCgmLHBqodAgQIECBAgEAtAUGxlqQ6BAgQIECAAIGOCQiKHRuodggQIECAAAECtQQExVqS6hAgQIAAAQIEOiYgKHZsoNohQIAAAQIECNQSEBRrSapDgAABAgQIEOiYgKDYsYFqhwABAgQIECBQS0BQrCWpDgECBAgQIECgYwKCYscGqh0CBAgQIECAQC0BQbGWpDoECBAgQIAAgY4JCIodG6h2CBAgQIAAAQK1BATFWpLqECBAgAABAgQ6JiAodmyg2iFAgAABAgQI1BIQFGtJqkOAAAECBAgQ6JiAoNixgWqHAAECBAgQIFBLQFCsJakOAQIECBAgQKBjAoJixwaqHQIECBAgQIBALQFBsZakOgQIECBAgACBjgkIih0bqHYIECBAgAABArUEBMVakuoQIECAAAECBDomICh2bKDaIUCAAAECBAjUEhAUa0mqQ4AAAQIECBDomICg2LGBaocAAQIECBAgUEtAUKwlqQ4BAgQIECBAoGMCgmLHBqodAgQIECBAgEAtAUGxlqQ6BAgQIECAAIGOCQiKHRuodggQIECAAAECtQQExVqS6hAgQIAAAQIEOiYgKHZsoNohQIAAAQIECNQSEBRrSapDgAABAgQIEOiYgKDYsYFqhwABAgQIECBQS0BQrCWpDgECBAgQIECgYwKCYscGqh0CBAgQIECAQC0BQbGWpDoECBAgQIAAgY4JCIodG6h2CBAgQIAAAQK1BATFWpLqECBAgAABAgQ6JiAodmyg2iFAgAABAgQI1BIQFGtJqkOAAAECBAgQ6JiAoNixgWqHAAECBAgQIFBLQFCsJakOAQIECBAgQKBjAoJixwaqHQIECBAgQIBALQFBsZakOgQIECBAgACBjgkIih0bqHYIECBAgAABArUEBMVakuoQIECAAAECBDomICh2bKDaIUCAAAECBAjUEhAUa0mqQ4AAAQIECBDomICg2LGBaocAAQIECBAgUEtAUKwlqQ4BAgQIECBAoGMCgmLHBqodAgQIECBAgEAtAUGxlqQ6BAgQIECAAIGOCQiKHRuodggQIECAAAECtQQExVqS6hAgQIAAAQIEOiYgKHZsoNohQIAAAQIECNQSEBRrSapDgAABAgQIEOiYgKDYsYFqhwABAgQIECBQS0BQrCWpDgECBAgQIECgYwKCYscGqh0CBAgQIECAQC0BQbGWpDoECBAgQIAAgY4JCIodG6h2CBAgQIAAAQK1BATFWpLqECBAgAABAgQ6JiAodmyg2iFAgAABAgQI1BIQFGtJqkOAAAECBAgQ6JiAoNixgWqHAAECBAgQIFBLQFCsJakOAQIECBAgQKBjAoJixwaqHQIECBAgQIBALQFBsZakOgQIECBAgACBjgkIih0bqHYIECBAgAABArUEBMVakuoQIECAAAECBDomICh2bKDaIUCAAAECBAjUEhAUa0mqQ4AAAQIECBDomICg2LGBaocAAQIECBAgUEtAUKwlqQ4BAgQIECBAoGMCgmLHBqodAgQIECBAgEAtAUGxlqQ6BAgQIECAAIGOCQiKHRuodggQIECAAAECtQQExVqS6hAgQIAAAQIEOiYgKHZsoNohQIAAAQIECNQSEBRrSapDgAABAgQIEOiYgKDYsYFqhwABAgQIECBQS0BQrCWpDgECBAgQIECgYwKCYscGqh0CBAgQIECAQC0BQbGWpDoECBAgQIAAgY4JCIodG6h2CBAgQIAAAQK1BATFWpLqECBAgAABAgQ6JiAodmyg2iFAgAABAgQI1BIQFGtJqkOAAAECBAgQ6JiAoNixgWqHAAECBAgQIFBLQFCsJakOAQIECBAgQKBjAoJixwaqHQIECBAgQIBALQFBsZakOgQIECBAgACBjgkIih0bqHYIECBAgAABArUEBMVakuoQIECAAAECBDomICh2bKDaIUCAAAECBAjUEhAUa0mqQ4AAAQIECBDomMD/B7vG/UY3fvPRAAAAAElFTkSuQmCC', 'Wajib', '2020-03-19 09:25:00', '2020-03-19 09:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kapasitas` int(5) DEFAULT NULL,
  `panjang` int(5) DEFAULT NULL,
  `lebar` int(5) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `kode`, `nama`, `kapasitas`, `panjang`, `lebar`, `foto`, `status`, `created_date`, `modified_date`) VALUES
(1, 'R01-01', 'NAWAWI', 15, 3, 3, '', 1, '2020-02-11 23:06:38', '2020-03-05 20:44:02'),
(2, 'R01-02', 'HASANUDIN', 20, 3, 3, '', 1, '2020-02-11 23:07:24', '2020-03-05 20:44:26'),
(3, 'R01-03', 'SP', 10, 3, 3, '', 1, '2020-02-11 23:07:59', '2020-03-05 20:44:48'),
(4, 'R02-01', 'AL-AMIN', 10, 3, 3, '', 1, '2020-02-11 23:08:27', '2020-03-05 20:45:14'),
(5, 'R02-02', 'LOBBY', 35, 3, 3, '', 1, '2020-03-05 20:46:03', NULL),
(6, 'R03-01', 'TIRTAYASA', 50, 3, 3, '', 1, '2020-03-05 20:46:29', NULL),
(7, 'R03-02', 'ARSYAD', 25, 3, 3, '', 1, '2020-03-05 20:46:45', NULL),
(8, 'R03-03', 'ASNAWI', 15, 3, 3, '', 1, '2020-03-05 20:47:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_persetujuan`
--

CREATE TABLE `setting_persetujuan` (
  `id` int(11) NOT NULL,
  `tipe_dokumen` enum('ruangan','kendaraan') DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `filter_divisi` enum('1','2') DEFAULT NULL COMMENT '1 = Divisi 2 = Kategori Divisi',
  `value` varchar(150) NOT NULL,
  `tipe_approval` enum('wajib','optional','menunggu') DEFAULT 'wajib',
  `id_divisi` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `setting_persetujuan`
--

INSERT INTO `setting_persetujuan` (`id`, `tipe_dokumen`, `label`, `filter_divisi`, `value`, `tipe_approval`, `id_divisi`, `id_users`, `order`, `status`, `created_by`, `created_date`, `modified_date`) VALUES
(1, 'kendaraan', 'Travel Admin', '1', '', 'wajib', 25, 394, 1, 1, 1, '2020-03-18 22:30:44', '0000-00-00 00:00:00'),
(2, 'kendaraan', 'Atasan Travel', '1', '', 'wajib', 1, 1, 2, 1, 1, '2020-03-18 22:30:44', '0000-00-00 00:00:00'),
(3, 'kendaraan', 'Koordinator Driver', '1', '', 'wajib', 26, 395, 3, 1, 1, '2020-03-18 22:30:44', '0000-00-00 00:00:00'),
(4, 'ruangan', 'Administrator', '1', '', 'wajib', 1, 1, 1, 1, 1, '2020-03-18 22:30:44', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `snack`
--

CREATE TABLE `snack` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp_wa` varchar(15) DEFAULT '0',
  `telp` varchar(15) DEFAULT '0',
  `telp_atasan` varchar(15) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_divisi`, `nik`, `username`, `password`, `nama`, `kelamin`, `email`, `telp_wa`, `telp`, `telp_atasan`, `foto`, `last_login`, `token`, `status`, `created_date`, `modified_date`) VALUES
(1, 1, NULL, 'admin', '$2y$10$7jTsBqyj7akN.n7bqiB2H.m8c0pkQAXF6lS0WCF.IVNOVceOOzPTe', 'Administrator', 'L', 'admin@gmail.com', '081808023424', '', NULL, 'avatar.png', '2020-03-19 13:53:15', NULL, 1, '2020-02-13 18:51:48', '2020-02-15 11:12:27'),
(213, 35, NULL, 'hadi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HADI', 'L', 'hadi@pln.co.id', '081388295687', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(214, 35, NULL, 'liza.julianti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'LIZA JULIANTI', 'L', 'liza.julianti@pln.co.id', '089622936924', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(215, 35, NULL, 'sri.sujiyanti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SRI SUJIYANTI', 'L', 'sri.sujiyanti@pln.co.id', '08158719860', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(216, 35, NULL, 'joko.prastyo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'JOKO PRASTYO', 'L', 'joko.prastyo@pln.co.id', '087878666633', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(217, 35, NULL, 'apriawan.pambudi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'APRIAWAN SATRIO PAMBUDI', 'L', 'apriawan.pambudi@pln.co.id', '089616145053', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(218, 35, NULL, 'aminah.gusniati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AMINAH UTAMI GUSNIATI', 'L', 'aminah.gusniati@pln.co.id', '08129020806', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(219, 35, NULL, 'christiani.pasaribu', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'CHRISTIANI NATALIA BR PASARIBU', 'L', 'christiani.pasaribu@pln.co.id', '082361134742', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(220, 35, NULL, '', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'YENI IRIYANTINI', 'L', 'yeni.iryantini@pln.co.id', '085215965778', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(221, 35, NULL, 'wida.kusuma', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'WIDA KUSUMA', 'L', 'wida.kusuma@pln.co.id', '081938761619', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(222, 35, NULL, 'satrya.gunawan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SYATRIA GUNAWAN', 'L', 'satrya.gunawan@pln.co.id', '085296069078', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(223, 35, NULL, 'abdul.aris', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ABDUL ARIS', 'L', 'abdul.aris@pln.co.id', '085728999249', '0', NULL, '', NULL, NULL, 1, '2020-03-01 09:40:26', '2020-03-12 22:31:56'),
(224, 35, NULL, 'saduarsa', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'IDA BAGUS SADUARSA', 'L', 'saduarsa@pln.co.id', '081908291764', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(225, 35, NULL, 'lintang.eka.pi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'LINTANG EKA PRITASARI IRAWAN', 'L', 'lintang.eka.pi@pln.co.id', '0816584643', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(226, 35, NULL, 'mohamad.nanjar', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOHAMAD NANJAR', 'L', 'mohamad.nanjar@pln.co.id', '08111741353', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(227, 35, NULL, 'argetra.halleiny', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARGETRA HALLEINY', 'L', 'argetra.halleiny@pln.co.id', '081372875025', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(228, 35, NULL, 'mayamonarika', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MAYA MONARIKA', 'L', 'mayamonarika@pln.co.id', '0811164099', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(229, 35, NULL, 'dian.fatimah', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DIAN FATIMAH', 'L', 'dian.fatimah@pln.co.id', '08569870740', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(230, 35, NULL, 'djuheri', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DJUHERI', 'L', 'djuheri@pln.co.id', '08157002639', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(231, 35, NULL, 'donni.oktavian', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DONNI OCTAVIAN', 'L', 'donni.oktavian@pln.co.id', '081365752432', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(232, 35, NULL, 'randika.prabowo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'RANDIKA PRABOWO', 'L', 'randika.prabowo@pln.co.id', '081617168082', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(233, 35, NULL, 'mirza.rahma', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MIRZA AULIA RAHMA', 'L', 'mirza.rahma@pln.co.id', '081228530294', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(234, 35, NULL, 'arifatulhuda', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARIFATUL HUDA', 'L', 'arifatulhuda@pln.co.id', '082113465213', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(235, 35, NULL, 'lala.fadila', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'LALA ARIEF FADILA', 'L', 'lala.fadila@pln.co.id', '0811936054', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(236, 35, NULL, 'james_harry', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'JAMES HARRY SIMANJUNTAK', 'L', 'james_harry@pln.co.id', '0811453101', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(237, 35, NULL, 'azis.rusdaya', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AZIS RUSDAYA', 'L', 'azis.rusdaya@pln.co.id', '081366662046', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(238, 35, NULL, 'heni.oktafiani', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HENI OKTAFIANI', 'L', 'heni.oktafiani@pln.co.id', '082213233570', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(239, 35, NULL, 'jajang', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'JAJANG SUHENDAR', 'L', 'jajang@pln.co.id', '081288910783', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(240, 28, NULL, 'mirnadewi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MIRNA KUSUMA DEWI', 'L', 'mirnadewi@pln.co.id', '085649379510', '0', NULL, '', NULL, NULL, 1, '2020-03-01 09:40:26', '2020-03-12 22:13:01'),
(241, 35, NULL, 'nur.oktaviana', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'NUR ANNISA OKTAVIANA', 'L', 'nur.oktaviana@pln.co.id', '082233005538', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(242, 35, NULL, 'bekti.setiaji', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BEKTI SETIAJI', 'L', 'bekti.setiaji@pln.co.id', '081271823745', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(243, 35, NULL, 'dian.sukandar', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DIAN SUNDAYANA SUKANDAR', 'L', 'dian.sukandar@pln.co.id', '085398911104', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(244, 28, NULL, 'ikbar.nugraha', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOCHAMMAD IKBAR NUGRAHA', 'L', 'ikbar.nugraha@pln.co.id', '081214402304', '0', NULL, '', NULL, NULL, 1, '2020-03-01 09:40:26', '2020-03-12 22:13:15'),
(245, 35, NULL, 'krisni.kusrini', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'KRISNI KUSRINI ', 'L', 'krisni.kusrini@pln.co.id', '081289285067', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(246, 35, NULL, 'doni.miran', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DONI MIRAN ', 'L', 'doni.miran@pln.co.id', '081938278827', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(247, 35, NULL, 'vebri.suhendra', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'VEBRI SUHENDRA', 'L', 'vebri.suhendra@pln.co.id', '', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(248, 28, NULL, 'lina.hermawati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'LINA HERMAWATI', 'L', 'lina.hermawati@pln.co.id', '089604705628', '0', NULL, '', NULL, NULL, 1, '2020-03-01 09:40:26', '2020-03-12 22:13:34'),
(249, 35, NULL, 'basuki2', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BASUKI ', 'L', 'basuki2@pln.co.id', '082124711447', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(250, 35, NULL, 'zubaidah.malik', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ZUBAIDAH MALIK', 'L', 'zubaidah.malik@pln.co.id', '', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(251, 35, NULL, 'alfian.mahardika', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ALFIAN MAHARDHIKA ', 'L', 'alfian.mahardika@pln.co.id', '087824014751', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(252, 35, NULL, 'eman', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EMAN', 'L', 'eman@pln.co.id', '081318647083', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(253, 35, NULL, 'cepi.triyana', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'CEPI TRIYANA', 'L', 'cepi.triyana@pln.co.id', '085878667797', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(254, 35, NULL, 'melva', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MELVA YUSMAWATI MANURUNG', 'L', 'melva@pln.co.id', '081439851823', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(255, 35, NULL, 'bernanto.lubis', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BERNANTO LUBIS', 'L', 'bernanto.lubis@pln.co.id', '08128303820', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(256, 35, NULL, 'adi.sasongko', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ADI SASONGKO', 'L', 'adi.sasongko@pln.co.id', '082111785788', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(257, 35, NULL, 'dimas.kusumo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DIMAS KUSUMONINGPRANG', 'L', 'dimas.kusumo@pln.co.id', '081382380607', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(258, 35, NULL, 'dhea.safli', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DHEA VANI SAFLI', 'L', 'dhea.safli@pln.co.id', '081374944569', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(259, 35, NULL, 'pitrianingsih', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'PITRIANINGSIH', 'L', 'pitrianingsih@pln.co.id', '081809731222', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(260, 35, NULL, 'rekky.salfischberger', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'REKKY SALFISCHBERGER', 'L', 'rekky.salfischberger@pln.co.id', '081281618007', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(261, 35, NULL, 'artha.tambunan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARTHA ULY DUMA SARI TAMBUNAN', 'L', 'artha.tambunan@pln.co.id', '081370525048', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(262, 35, NULL, 'ii.mariam', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'II MARIAM', 'L', 'ii.mariam@pln.co.id', '08161951921', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(263, 35, NULL, 'efri.yendri', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EFRI YENDRI', 'L', 'efri.yendri@pln.co.id', '08126758906', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(264, 35, NULL, 'yulian', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'YULIAN', 'L', 'yulian@pln.co.id', '08558551920', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(265, 35, NULL, 'apriani.nurul.suci', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'APRIANI NURUL SUCI', 'L', 'apriani.nurul.suci@pln.co.id', '089685873784', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(266, 35, NULL, 'marita.utami', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MARITA UTAMI', 'L', 'marita.utami@pln.co.id', '081294110800', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(267, 35, NULL, 'eka.sulistianingsih', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EKA SULISTIANINGSIH', 'L', 'eka.sulistianingsih@pln.co.id', '085697551764', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(268, 35, NULL, 'rosahaya.silaban', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ROSAHAYA SILABAN', 'L', 'rosahaya.silaban@pln.co.id', '082368540321', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(269, 35, NULL, 'priyanto3', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'PRIYANTO', 'L', 'priyanto3@pln.co.id', '085892989292', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(270, 35, NULL, 'galih.saputra', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'GALIH BAYU SYAHPUTRA', 'L', 'galih.saputra@pln.co.id', '082282949618', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(271, 35, NULL, 'dwi.saputro3', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DWI SAPUTRO', 'L', 'dwi.saputro3@pln.co.id', '085799585790', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(272, 35, NULL, 'ari.gintara', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARI GINTARA ', 'L', 'ari.gintara@pln.co.id', '082239979929', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(273, 35, NULL, 'andesta', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ANDESTA', 'L', 'andesta@pln.co.id', '081368252684', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(274, 35, NULL, 'erni.tuti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ERNI TUTI HARTATI DAMANIK', 'L', 'erni.tuti@pln.co.id', '08111463242', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(275, 35, NULL, 'zulfahmi.lubis', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ZULFAHMI SYAPUTRA LUBIS', 'L', 'zulfahmi.lubis@pln.co.id', '082165021270', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(276, 35, NULL, 'fadela.noermeilita', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'FADELA NOERMEILITA', 'L', 'fadela.noermeilita@pln.co.id', '081212145548', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(277, 35, NULL, 'devy.rachdianti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DEVY RACHDIANTI LAKSMI', 'L', 'devy.rachdianti@pln.co.id', '081910268587', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(278, 35, NULL, 'bastian.siahaan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BASTIAN SIAHAAN', 'L', 'bastian.siahaan@pln.co.id', '085270890548', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(279, 35, NULL, 'masutiah.susilowati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MASUTIAH SUSILOWATI', 'L', 'masutiah.susilowati@pln.co.id', '085642705704', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(280, 35, NULL, 'annisa.permatasari', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ANNISA PUTRI PERMATASARI', 'L', 'annisa.permatasari@pln.co.id', '081390305296', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(281, 35, NULL, 'adisulistyo.indrawan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'INDRAWAN ADISULISTYO', 'L', 'adisulistyo.indrawan@pln.co.id', '085229177719', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(282, 35, NULL, 'bambang.lesmono', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BAMBANG LESMONO', 'L', 'bambang.lesmono@pln.co.id', '08128855638', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(283, 35, NULL, 'sri.samsactriati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SRI SAMSACTRIATI PUTRI PAMUNGKAS', 'L', 'sri.samsactriati@pln.co.id', '08119444244', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(284, 35, NULL, 'eko.sulistyono', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'F EKO SULISTYONO', 'L', 'eko.sulistyono@pln.co.id', '081246007885', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(285, 35, NULL, 'm.hermansyah', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MUHAMMAD HERMANSYAH', 'L', 'm.hermansyah@pln.co.id', '08115001332', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(286, 35, NULL, 'donna.sinatra', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DONNA SINATRA', 'L', 'donna.sinatra@pln.co.id', '0818818996', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(287, 35, NULL, 'pungut.suryadi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'PUNGUT SURYADI', 'L', '', '081310094694', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(288, 35, NULL, 'satiri.ahmad', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AHMAD SATIRI', 'L', 'satiri.ahmad@pln.co.id', '081282270918', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(289, 35, NULL, 'selvia.marlika', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SELVIA MARLIKA', 'L', 'selvia.marlika@pln.co.id', '08122895259', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(290, 35, NULL, 'asep.qolibi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ASEP EL QOLIBI', 'L', 'asep.qolibi@pln.co.id', '08127524658', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(291, 35, NULL, 'andi.setiabudi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ANDI SETIABUDI', 'L', 'andi.setiabudi@pln.co.id', '081383604219', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(292, 35, NULL, 'irna.transista', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'IRNA TRANSISTA', 'L', 'irna.transista@pln.co.id', '081261058224', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(293, 35, NULL, 'destiany.p', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DESTIANY PRAWIDYASARI', 'L', 'destiany.p@pln.co.id', '085220624607', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(294, 35, NULL, 'febry.sinaga', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'FEBRY RAMOS SINAGA', 'L', 'febry.sinaga@pln.co.id', '085769879415', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(295, 35, NULL, 'dayinta.pramaharsi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DAYINTA PRAMAHARSI', 'L', 'dayinta.pramaharsi@pln.co.id', '085399962676', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(296, 35, NULL, 'mokhamad.irfan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOKHAMAD IRFAN', 'L', 'mokhamad.irfan@pln.co.id', '081233326696', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(297, 35, NULL, 'm.rizky.kurniawan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOHAMAD RIZKI KURNIAWAN', 'L', 'm.rizky.kurniawan@pln.co.id', '089679311662', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(298, 35, NULL, 'winda.aprilia', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'WINDA APRILIA', 'L', 'winda.aprilia@pln.co.id', '081381588426', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(299, 35, NULL, 'moch.andy', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOCH. ANDY ADCHAMINOERDIN', 'L', 'moch.andy@pln.co.id', '0811402711', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(300, 35, NULL, 'siti.nurhasanah1', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SITI NUR IRODATUL HASANAH', 'L', 'siti.nurhasanah1@pln.co.id', '08998610406', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(301, 35, NULL, 'puspita.yulia', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'YULIA PUSPITA INDRIANI', 'L', 'puspita.yulia@pln.co.id', '087886337856', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(302, 35, NULL, 'neni.suryani', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'NENI SURYANI', 'L', 'neni.suryani@pln.co.id', '081298378274', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(303, 35, NULL, 'fitri.irmawati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'FITRI IRMAWATI', 'L', 'fitri.irmawati@pln.co.id', '085810246294', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(304, 35, NULL, 'asiyah.nurmahmudah', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ASIYAH NUR MAHMUDAH', 'L', 'asiyah.nurmahmudah@pln.co.id', '085692686955', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(305, 35, NULL, 'meldawati', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MELDAWATI', 'L', 'meldawati@pln.co.id', '082386419920', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(306, 35, NULL, 'teguhsutomo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'TEGUH SATRYO UTOMO', 'L', 'teguhsutomo@pln.co.id', '081399299242', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(307, 35, NULL, 'anton.teguh', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ANTON TEGUH SUWARTONO', 'L', 'anton.teguh@pln.co.id', '0811249003', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(308, 35, NULL, 'gina.nurfitriani', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'GINA NURFITRIANI', 'L', 'gina.nurfitriani@pln.co.id', '085223800966', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(309, 35, NULL, 'yulian.nugroho', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'YULIAN NUGROHO', 'L', 'yulian.nugroho@pln.co.id', '081282819619', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(310, 35, NULL, 'aulia.salsabila', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AULIA HADIN SALSABILA', 'L', 'aulia.salsabila@pln.co.id', '085655581811', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(311, 35, NULL, 'darmawan.arief', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARIEF DARMAWAN', 'L', 'darmawan.arief@pln.co.id', '0811473106', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(312, 35, NULL, 'alvin', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ALVIN', 'L', 'alvin@pln.co.id', '08121079371', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(313, 35, NULL, 'ays.rahmadian', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AYS RAHMADIAN SUBHI', 'L', 'ays.rahmadian@pln.co.id', '085786131818', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(314, 35, NULL, 'samuel.susilo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SAMUEL KRESNA SUSILO', 'L', 'samuel.susilo@pln.co.id', '081332055867', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(315, 35, NULL, 'tasripin', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'TASRIPIN', 'L', 'tasripin@pln.co.id', '08118581964', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(316, 35, NULL, 'muhamad.firsada', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MUHAMAD FIRSADA', 'L', 'muhamad.firsada@pln.co.id', '089506184470', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(317, 35, NULL, 'miftahulkhair14', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MIFTAHULKHAIR ADIANTO', 'L', 'miftahulkhair14@gmail.com', '081365481446', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(318, 35, NULL, 'tatu.maftuha', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'TATU MAFTUHA', 'L', 'tatu.maftuha@pln.co.id', '087887749233', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(319, 35, NULL, 'setyo.hariyanto', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SETYO HARIYANTO', 'L', 'setyo.hariyanto@pln.co.id', '081380896042', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(320, 35, NULL, 'rodif.hilman', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'RODIF HILMAN', 'L', 'rodif.hilman@pln.co.id', '081244228400', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(321, 35, NULL, 'yusti.widhapratama', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'YUSTI WIDHA PRATAMA', 'L', 'yusti.widhapratama@pln.co.id', '081328537571', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(322, 35, NULL, 'ridwan.djamily', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'RIDWAN DJAMILY', 'L', 'ridwan.djamily@pln.co.id', '087772516191', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(323, 35, NULL, 'dwi.ardiansyah', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DWI ARDIANSYAH', 'L', 'dwi.ardiansyah@pln.co.id', '082123562306', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(324, 35, NULL, 'eka.ari', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EKA ARI PRASETIYA', 'L', 'eka.ari@pln.co.id', '082166666363', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(325, 35, NULL, 'sari.kusno', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ERLINA MULIYASARI KUSNO', 'L', 'sari.kusno@pln.co.id', '081240588840', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(326, 35, NULL, 'widya.astuti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'WIDYA ASTUTI', 'L', 'widya.astuti@pln.co.id', '085787066898', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(327, 35, NULL, 'syafaat.pradipta', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SYAFAAT PRADIPTA', 'L', 'syafaat.pradipta@pln.co.id', '081317249595', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(328, 35, NULL, 'adityo.reinaldi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ADITYO REINALDI', 'L', 'adityo.reinaldi@pln.co.id', '082129198899', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(329, 35, NULL, 'joharifin', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOHAMMAD JOHARIFIN', 'L', 'joharifin@pln.co.id ', '081318555103', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(330, 35, NULL, 'lilik.harsono', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'LILIK HARSONO', 'L', 'lilik.harsono@pln.co.id', '087783262018', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(331, 35, NULL, 'darsono72', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DARSONO', 'L', 'darsono72@pln.co.id', '0816880218', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(332, 35, NULL, 'dina.maisailina', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DINA MAISAILINA', 'L', 'dina.maisailina@pln.co.id', '081389192081', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(333, 35, NULL, 'mahadhir', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MAHADHIR', 'L', 'mahadhir@pln.co.id', '081380205128', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(334, 35, NULL, 'ependi.dinata', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EPENDI DINATA', 'L', 'ependi.dinata@pln.co.id', '0818687963', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(335, 35, NULL, 'eka.aprianti', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'EKA APRIANTI P.S', 'L', 'eka.aprianti@pln.co.id', '085959504828', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(336, 35, NULL, 'henry.parluhutan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HENRY PARLUHUTAN', 'L', 'henry.parluhutan@pln.co.id', '081298596851', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(337, 35, NULL, 'lestari.siagian', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'NYIMAS RAHMAWATI', 'L', 'lestari.siagian@pln.co.id', '08126900135', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(338, 35, NULL, 'irham', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'IRHAM', 'L', 'irham@pln.co.id', '08557851000', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(339, 35, NULL, 'novridayanti.gultom', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'NOVRIDAYANTI GULTOM', 'L', 'novridayanti.gultom@pln.co.id', '081210882475', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(340, 35, NULL, 'rosikin', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ROSIKIN', 'L', 'rosikin@pln.co.id', '081281093709', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(341, 35, NULL, 'sukanda', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SUKANDA', 'L', 'sukanda.pln.co.id', '081385102427', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(342, 35, NULL, 'sriharyati.barlian', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SRI HARYATI B', 'L', 'sriharyati.barlian@pln.co.id', '082348857610', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(343, 35, NULL, 'budi.widodo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BUDI WIDODO', 'L', 'budi.widodo@pln.co.id', '081388996788', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(344, 35, NULL, 'arif.yulianto', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ARIF YULIYANTO', 'L', 'arif.yulianto@pln.co.id', '081380662585', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(345, 35, NULL, 'zulkarnain', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ZULKARNAIN', 'L', 'zulkarnain@pln.co.id', '081314123405', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(346, 35, NULL, 'hidayat68m', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HIDAYAT', 'L', 'hidayat68m@pln.co.id', '081318112792', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(347, 35, NULL, 'hamdhi.pratama', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HAMDHI PRATAMA', 'L', 'hamdhi.pratama@pln.co.id', '081250030441', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(348, 35, NULL, 'syaekhul.wardi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SYAEKHUL WARDI', 'L', 'syaekhul.wardi@pln.co.id', '08129638802', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(349, 35, NULL, 'alam.setiawan', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'ALAM SETIAWAN', 'L', 'alam.setiawan@pln.co.id', '083838685712', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(350, 35, NULL, 'wiedhyarno.arief', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'WIEDHYARNO ARIEF WICAKSONO', 'L', 'wiedhyarno.arief@pln.coid', '08563045314', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(351, 35, NULL, 'bambang.nurdiansyah', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'BAMBANG NURDIANSYAH', 'L', 'bambang.nurdiansyah@pln.co.id', '082124479551', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(352, 35, NULL, 'sukendar.tjahtjo', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SUKENDAR TJAHJO MURTIADI', 'L', 'sukendar.tjahtjo@pln.co.id', '081320289883', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(353, 35, NULL, 'supardi69m', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SUPARDI', 'L', 'supardi69m@pln.co.id', '087809661519', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(354, 35, NULL, 'henny.fahma', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'HENNY IPI FAHMA', 'L', 'henny.fahma@pln.co.id', '081232271389', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(355, 35, NULL, 'nurwandi', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'NURWANDI', 'L', 'nurwandi@pln.co.id', '081380754606', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(356, 35, NULL, 'mohamad.yusuf', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MOHAMAD YUSUF', 'L', 'mohamad.yusuf@pln.co.id', '081294415199', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(357, 35, NULL, 'utoro', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'UTORO', 'L', 'utoro@pln.co.id', '08119478907', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(358, 35, NULL, 'rizda.noverita', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'RIZDA NOVERITA', 'L', 'rizda.noverita@pln.co.id', '085268492009', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(359, 35, NULL, 'inez.carissa', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'INEZ CARISSA ABYATI', 'L', 'inez.carissa@pln.co.id', '08170746226', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(360, 35, NULL, 'muhammad.madani', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MUHAMMAD ZAKI MADANI', 'L', 'muhammad.madani@pln.co.id', '081261970916', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(361, 35, NULL, 'wahyu.nugroho93', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'WAHYU NUGROHO', 'L', 'wahyu.nugroho93@pln.co.id', '085273338807', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(362, 35, NULL, 'muhlas', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MUHLAS', 'L', 'muhlas@pln.co.id', '081319783345', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(363, 35, NULL, 'agus.sw', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AGUS SAPTO WIDODO', 'L', 'agus.sw@pln.co.id', '08122876091', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(364, 35, NULL, 'siswandi2', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SISWANDI', 'L', 'siswandi2@pln.co.id', '08170080506', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(365, 35, NULL, 'sriwiyono', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'SRIWIYONO', 'L', 'sriwiyono@pln.co.id', '08557120170', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(366, 35, NULL, 'mulyadi68m', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MULYADI', 'L', 'mulyadi68m@pln.co.id', '08121086089', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(367, 35, NULL, 'desi.ulfa', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'DESI ULFA SUKRIANI', 'L', 'desi.ulfa@pln.co.id', '08127688380', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(368, 35, NULL, 'muhammad.ansori', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'MUHAMMAD FAUZI ANSORI', 'L', 'muhammad.ansori@pln.co.id', '081258489066', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(369, 35, NULL, 'akmal.ilyasa', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'AKMAL ILYASA', 'L', 'akmal.ilyasa@pln.co.id', '082138999875', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(370, 35, NULL, 'vanessa.brata', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'VANESSA BRATA ATMAJA', 'L', 'vanessa.brata@pln.co.id', '08179200670', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(371, 35, NULL, 'rizky.amalia', '$2y$10$ooI5zGEYhQMu2iP7RH8X6u8kv2agAmyJjF1bF3Ao0F9eugPbSKQCq', 'RIZKY DHIAN AMALIA', 'L', 'rizky.amalia@pln.co.id', '08127208370', '0', NULL, NULL, NULL, NULL, 1, '2020-03-01 09:40:26', NULL),
(394, 25, '', 'traveladmin', '$2y$10$K3dm.0RWbTCKP/xoK4AT9.GIIbwYbAb.WnABMbnRKnjmqGXcUjZ.W', 'TRAVEL ADMIN', 'L', 'traveladmin@pln.co.id', '085966622963', '', '', '', '2020-03-19 00:43:33', NULL, 1, '2020-03-07 09:45:33', '2020-03-19 05:50:53'),
(395, 26, '', 'koordriver', '$2y$10$cglRu5rsJXIf3C5eWpKgsOdLGWE4httDUQ7W3UVGvrPSJTPFAJu6e', 'KOORDINATOR DRIVER', 'L', 'koordinatordriver@pln.co.id', '085966622963', '', '', '', '2020-03-18 22:51:08', NULL, 1, '2020-03-07 09:46:04', '2020-03-19 05:50:26'),
(396, 33, NULL, 'muhamad.sidik', '$2y$10$z94jjodbuQ22T7AqsXCWiu/uDU2Oyu/PyFXn0HDNHuKJEEN20TPRO', 'MUHAMAD SIDIK', 'L', 'x@x.x', '082110744053', '', NULL, '', NULL, NULL, 1, '2020-03-12 22:21:58', NULL),
(399, 33, '', 'driver', '$2y$10$Us4SbFe.MKNsigB32B6NL.P57FXbhtf9HOW72.1b9JK0dazUm5RCS', 'DRIVER', 'L', 'driver@pln.co.id', '085156252059', '', '', '', '2020-03-19 00:44:30', NULL, 1, '2020-03-19 06:06:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atasan`
--
ALTER TABLE `atasan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `atk`
--
ALTER TABLE `atk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ceklis_kendaraan`
--
ALTER TABLE `ceklis_kendaraan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ceklis_kendaraan_detail`
--
ALTER TABLE `ceklis_kendaraan_detail`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_ceklis_kendaraan` (`id_ceklis_kendaraan`) USING BTREE,
  ADD KEY `id_list_komponen_ceklis` (`id_list_komponen_ceklis`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `daftar_hadir`
--
ALTER TABLE `daftar_hadir`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `detail_atk`
--
ALTER TABLE `detail_atk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_atasan` (`id_atasan`) USING BTREE,
  ADD KEY `id_kategori_divisi` (`id_kategori_divisi`) USING BTREE,
  ADD KEY `is_allow_login` (`is_allow_login`) USING BTREE,
  ADD KEY `is_need_approval` (`is_need_approval`) USING BTREE;

--
-- Indexes for table `jenis_kendaraan`
--
ALTER TABLE `jenis_kendaraan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `kode` (`kode`) USING BTREE;

--
-- Indexes for table `kategori_divisi`
--
ALTER TABLE `kategori_divisi`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `nopol` (`nopol`) USING BTREE,
  ADD KEY `id_jenis_kendaraan` (`id_jenis_kendaraan`) USING BTREE,
  ADD KEY `id_users` (`id_users`) USING BTREE;

--
-- Indexes for table `list_komponen_ceklis`
--
ALTER TABLE `list_komponen_ceklis`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `makan_siang`
--
ALTER TABLE `makan_siang`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `peminjaman_kendaraan`
--
ALTER TABLE `peminjaman_kendaraan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_kendaraan` (`id_kendaraan`) USING BTREE,
  ADD KEY `id_driver` (`id_driver`) USING BTREE,
  ADD KEY `id_atasan` (`id_atasan`) USING BTREE,
  ADD KEY `id_users` (`id_users`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `peminjaman_kendaraan_persetujuan`
--
ALTER TABLE `peminjaman_kendaraan_persetujuan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_peminjaman_kendaraan` (`id_peminjaman_kendaraan`) USING BTREE,
  ADD KEY `id_users` (`id_users`) USING BTREE;

--
-- Indexes for table `peminjaman_kendaraan_personil`
--
ALTER TABLE `peminjaman_kendaraan_personil`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_peminjaman_kendaraan` (`id_peminjaman_kendaraan`) USING BTREE;

--
-- Indexes for table `peminjaman_ruangan`
--
ALTER TABLE `peminjaman_ruangan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_ruangan` (`id_ruangan`) USING BTREE,
  ADD KEY `id_makan_siang` (`id_makan_siang`) USING BTREE,
  ADD KEY `id_snack` (`id_snack`) USING BTREE,
  ADD KEY `id_users` (`id_users`) USING BTREE,
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `peminjaman_ruangan_persetujuan`
--
ALTER TABLE `peminjaman_ruangan_persetujuan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_peminjaman_ruangan` (`id_peminjaman_ruangan`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_users` (`id_users`) USING BTREE;

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `kode` (`kode`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

--
-- Indexes for table `setting_persetujuan`
--
ALTER TABLE `setting_persetujuan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `snack`
--
ALTER TABLE `snack`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `id_divisi` (`id_divisi`) USING BTREE,
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `password` (`password`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atasan`
--
ALTER TABLE `atasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `atk`
--
ALTER TABLE `atk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ceklis_kendaraan`
--
ALTER TABLE `ceklis_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ceklis_kendaraan_detail`
--
ALTER TABLE `ceklis_kendaraan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daftar_hadir`
--
ALTER TABLE `daftar_hadir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_atk`
--
ALTER TABLE `detail_atk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `jenis_kendaraan`
--
ALTER TABLE `jenis_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_divisi`
--
ALTER TABLE `kategori_divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `list_komponen_ceklis`
--
ALTER TABLE `list_komponen_ceklis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `makan_siang`
--
ALTER TABLE `makan_siang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjaman_kendaraan`
--
ALTER TABLE `peminjaman_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `peminjaman_kendaraan_persetujuan`
--
ALTER TABLE `peminjaman_kendaraan_persetujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `peminjaman_kendaraan_personil`
--
ALTER TABLE `peminjaman_kendaraan_personil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `peminjaman_ruangan`
--
ALTER TABLE `peminjaman_ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peminjaman_ruangan_persetujuan`
--
ALTER TABLE `peminjaman_ruangan_persetujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `setting_persetujuan`
--
ALTER TABLE `setting_persetujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `snack`
--
ALTER TABLE `snack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ceklis_kendaraan_detail`
--
ALTER TABLE `ceklis_kendaraan_detail`
  ADD CONSTRAINT `ceklis_kendaraan_detail_ibfk_1` FOREIGN KEY (`id_ceklis_kendaraan`) REFERENCES `ceklis_kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ceklis_kendaraan_detail_ibfk_2` FOREIGN KEY (`id_list_komponen_ceklis`) REFERENCES `list_komponen_ceklis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `divisi`
--
ALTER TABLE `divisi`
  ADD CONSTRAINT `divisi_ibfk_1` FOREIGN KEY (`id_atasan`) REFERENCES `atasan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `divisi_ibfk_2` FOREIGN KEY (`id_kategori_divisi`) REFERENCES `kategori_divisi` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `kendaraan_ibfk_1` FOREIGN KEY (`id_jenis_kendaraan`) REFERENCES `jenis_kendaraan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kendaraan_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_kendaraan`
--
ALTER TABLE `peminjaman_kendaraan`
  ADD CONSTRAINT `peminjaman_kendaraan_ibfk_3` FOREIGN KEY (`id_atasan`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_kendaraan_ibfk_4` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_kendaraan_ibfk_5` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_kendaraan_ibfk_6` FOREIGN KEY (`id_driver`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_kendaraan_persetujuan`
--
ALTER TABLE `peminjaman_kendaraan_persetujuan`
  ADD CONSTRAINT `peminjaman_kendaraan_persetujuan_ibfk_1` FOREIGN KEY (`id_peminjaman_kendaraan`) REFERENCES `peminjaman_kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_kendaraan_persetujuan_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_kendaraan_personil`
--
ALTER TABLE `peminjaman_kendaraan_personil`
  ADD CONSTRAINT `peminjaman_kendaraan_personil_ibfk_1` FOREIGN KEY (`id_peminjaman_kendaraan`) REFERENCES `peminjaman_kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_ruangan`
--
ALTER TABLE `peminjaman_ruangan`
  ADD CONSTRAINT `peminjaman_ruangan_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ruangan_ibfk_2` FOREIGN KEY (`id_makan_siang`) REFERENCES `makan_siang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ruangan_ibfk_3` FOREIGN KEY (`id_snack`) REFERENCES `snack` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ruangan_ibfk_4` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_ruangan_persetujuan`
--
ALTER TABLE `peminjaman_ruangan_persetujuan`
  ADD CONSTRAINT `peminjaman_ruangan_persetujuan_ibfk_1` FOREIGN KEY (`id_peminjaman_ruangan`) REFERENCES `peminjaman_ruangan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ruangan_persetujuan_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
