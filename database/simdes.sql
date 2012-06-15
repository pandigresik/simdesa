-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 03. Juni 2012 jam 10:57
-- Versi Server: 5.1.61
-- Versi PHP: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simdes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `det_keluarga`
--

CREATE TABLE IF NOT EXISTS `det_keluarga` (
  `id_keluarga` varchar(20) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  KEY `id_warga` (`no_ktp`,`id_keluarga`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluarga`
--

CREATE TABLE IF NOT EXISTS `keluarga` (
  `id_keluarga` varchar(20) NOT NULL,
  `kepala_keluarga` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `dusun` varchar(30) NOT NULL,
  `rt` varchar(2) DEFAULT NULL,
  `rw` varchar(2) DEFAULT NULL,
  `ekonomi` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_keluarga`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Trigger `keluarga`
--
DROP TRIGGER IF EXISTS `hapus_detail_klg`;
DELIMITER //
CREATE TRIGGER `hapus_detail_klg` AFTER DELETE ON `keluarga`
 FOR EACH ROW begin

delete  from det_keluarga where det_keluarga.id_keluarga = old.id_keluarga;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_warga`
--

CREATE TABLE IF NOT EXISTS `mutasi_warga` (
  `id_mutasi` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_warga` varchar(20) NOT NULL,
  `jenis_mutasi` varchar(15) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_mutasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat`
--

CREATE TABLE IF NOT EXISTS `surat` (
  `id_surat` int(8) NOT NULL AUTO_INCREMENT,
  `jenis_surat` varchar(4) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `nama_surat` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `isi_surat` text,
  `tanda_tangan` varchar(50) NOT NULL,
  `id_warga` varchar(20) NOT NULL,
  `nama_warga` varchar(50) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detail_warga`
--
CREATE TABLE IF NOT EXISTS `v_detail_warga` (
`id_keluarga` varchar(20)
,`no_ktp` varchar(20)
,`nama` varchar(50)
,`agama` varchar(20)
,`t_lahir` varchar(20)
,`tgl_lahir` varchar(10)
,`j_kel` varchar(11)
,`gol_darah` varchar(2)
,`w_negara` varchar(20)
,`pendidikan` varchar(10)
,`pekerjaan` varchar(30)
,`s_nikah` varchar(20)
,`alamat` text
,`rt` varchar(2)
,`rw` varchar(2)
,`dusun` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_mutasi_warga`
--
CREATE TABLE IF NOT EXISTS `v_mutasi_warga` (
`id_warga` varchar(20)
,`j_kel` enum('L','W')
,`jenis_mutasi` varchar(15)
,`periode` varchar(7)
,`keterangan` text
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE IF NOT EXISTS `warga` (
  `no_ktp` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `agama` varchar(20) NOT NULL,
  `t_lahir` varchar(20) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `j_kel` enum('L','W') NOT NULL,
  `gol_darah` varchar(2) NOT NULL,
  `w_negara` varchar(20) NOT NULL,
  `pendidikan` varchar(10) DEFAULT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `s_nikah` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`no_ktp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `v_detail_warga`
--
DROP TABLE IF EXISTS `v_detail_warga`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detail_warga` AS select `a`.`id_keluarga` AS `id_keluarga`,`c`.`no_ktp` AS `no_ktp`,`c`.`nama` AS `nama`,`c`.`agama` AS `agama`,`c`.`t_lahir` AS `t_lahir`,date_format(`c`.`tgl_lahir`,'%d-%m-%Y') AS `tgl_lahir`,if((`c`.`j_kel` = 'L'),'Laki - laki','Wanita') AS `j_kel`,`c`.`gol_darah` AS `gol_darah`,`c`.`w_negara` AS `w_negara`,`c`.`pendidikan` AS `pendidikan`,`c`.`pekerjaan` AS `pekerjaan`,`c`.`s_nikah` AS `s_nikah`,`a`.`alamat` AS `alamat`,`a`.`rt` AS `rt`,`a`.`rw` AS `rw`,`a`.`dusun` AS `dusun` from ((`keluarga` `a` join `det_keluarga` `b`) join `warga` `c`) where ((`a`.`id_keluarga` = `b`.`id_keluarga`) and (`b`.`no_ktp` = `c`.`no_ktp`) and (`c`.`status` = '1'));

-- --------------------------------------------------------

--
-- Structure for view `v_mutasi_warga`
--
DROP TABLE IF EXISTS `v_mutasi_warga`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mutasi_warga` AS select `mutasi_warga`.`id_warga` AS `id_warga`,`warga`.`j_kel` AS `j_kel`,`mutasi_warga`.`jenis_mutasi` AS `jenis_mutasi`,date_format(`mutasi_warga`.`tanggal`,'%m-%Y') AS `periode`,`mutasi_warga`.`keterangan` AS `keterangan` from (`mutasi_warga` join `warga` on((`warga`.`no_ktp` = `mutasi_warga`.`id_warga`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
