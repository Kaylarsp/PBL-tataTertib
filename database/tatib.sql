/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 16001135 (16.00.1135)
 Source Host           : LAPTOP-CCV6QK6I:1433
 Source Catalog        : tatib
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 16001135 (16.00.1135)
 File Encoding         : 65001

 Date: 29/12/2024 22:13:39
*/


-- ----------------------------
-- Table structure for dosen
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[dosen]') AND type IN ('U'))
	DROP TABLE [dbo].[dosen]
GO

CREATE TABLE [dbo].[dosen] (
  [id_dosen] int  IDENTITY(1,1) NOT NULL,
  [id_user] int  NULL,
  [nama] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [nidn] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [tgl_lahir] date  NULL,
  [id_kelas] int  NULL
)
GO

ALTER TABLE [dbo].[dosen] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of dosen
-- ----------------------------
SET IDENTITY_INSERT [dbo].[dosen] ON
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir], [id_kelas]) VALUES (N'1', N'4', N'biru', N'23459', N'1980-08-15', N'15')
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir], [id_kelas]) VALUES (N'6', N'18', N'popo', N'23460', N'1988-12-03', N'5')
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir], [id_kelas]) VALUES (N'9', N'11', N'caca', N'23412', N'1991-03-10', N'16')
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir], [id_kelas]) VALUES (N'10', N'21', N'fafa', N'123412', N'1995-06-22', N'10')
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir], [id_kelas]) VALUES (N'11', N'3', N'ani', N'21231', N'1975-01-06', N'12')
GO

SET IDENTITY_INSERT [dbo].[dosen] OFF
GO


-- ----------------------------
-- Table structure for kelas
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[kelas]') AND type IN ('U'))
	DROP TABLE [dbo].[kelas]
GO

CREATE TABLE [dbo].[kelas] (
  [id_kelas] int  IDENTITY(1,1) NOT NULL,
  [nama_kelas] varchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [prodi] int  NULL
)
GO

ALTER TABLE [dbo].[kelas] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of kelas
-- ----------------------------
SET IDENTITY_INSERT [dbo].[kelas] ON
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'1', N'TI-2A', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'2', N'TI-2B', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'3', N'TI-2C', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'4', N'TI-2D', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'5', N'TI-2E', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'6', N'TI-2F', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'7', N'TI-2G', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'8', N'TI-2H', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'9', N'TI-2I', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'10', N'SIB-2A', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'11', N'SIB-2B', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'12', N'SIB-2C', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'13', N'SIB-2D', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'14', N'SIB-2E', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'15', N'SIB-2F', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'16', N'SIB-2G', NULL)
GO

INSERT INTO [dbo].[kelas] ([id_kelas], [nama_kelas], [prodi]) VALUES (N'17', N'PPLS-2A', NULL)
GO

SET IDENTITY_INSERT [dbo].[kelas] OFF
GO


-- ----------------------------
-- Table structure for laporan
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[laporan]') AND type IN ('U'))
	DROP TABLE [dbo].[laporan]
GO

CREATE TABLE [dbo].[laporan] (
  [id_laporan] int  IDENTITY(1,1) NOT NULL,
  [id_tingkat] int  NULL,
  [id_pelapor] int  NULL,
  [id_pelaku] int  NULL,
  [id_pelanggaran] int  NULL,
  [verify_by] int  NULL,
  [verify_at] datetime  NULL,
  [deskripsi] text COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [bukti_filepath] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [penolakan_filepath] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [statusTolak] int  NULL,
  [sanksi] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [verifikasiMhs] int  NULL,
  [alasanMhsNolak] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[laporan] SET (LOCK_ESCALATION = TABLE)
GO

EXEC sp_addextendedproperty
'MS_Description', N'1=acc, 2=tolak',
'SCHEMA', N'dbo',
'TABLE', N'laporan',
'COLUMN', N'statusTolak'
GO

EXEC sp_addextendedproperty
'MS_Description', N'1=bener, 2=salah',
'SCHEMA', N'dbo',
'TABLE', N'laporan',
'COLUMN', N'verifikasiMhs'
GO


-- ----------------------------
-- Records of laporan
-- ----------------------------
SET IDENTITY_INSERT [dbo].[laporan] ON
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'37', N'4', N'15', N'7', N'6', N'23', N'2024-12-27 12:25:50.000', N'makan di laboratorium', N'../uploads/Screenshot 2023-12-13 194012.png', NULL, N'1', N'Teguran tertulis disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai', N'1', NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'38', N'4', N'24', N'10', N'3', N'23', N'2024-12-27 12:25:53.000', N'memakai kaus tidak berkerah di dalam kampus', N'../uploads/Screenshot 2024-04-19 123517.png', NULL, N'1', N'Teguran tertulis disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai', N'1', NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'39', N'4', N'24', N'37', N'4', NULL, NULL, N'berambut gondrong, sangat tidak pantas dan tidak rapi', N'../uploads/Screenshot 2024-04-23 103521.png', NULL, NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'40', N'2', N'6', N'42', N'15', NULL, NULL, N'memarkir kendaraan di area parkiran dosen', N'../uploads/Screenshot 2023-05-16 154745.png', NULL, NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'42', N'3', N'25', N'7', N'11', N'23', N'2024-12-28 09:42:44.000', N'bermain game online di dalam kelas, tepatnya saat mata kuliah sedang berlangsung', N'../uploads/Screenshot 2023-05-16 154745.png', NULL, N'1', N'Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai', N'1', NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'43', N'2', N'25', N'7', N'18', N'23', N'2024-12-28 09:42:47.000', N'membawa pistol dan benda-benda tajam seperti pisau', N'../uploads/Screenshot 2023-12-13 194012.png', NULL, N'1', N'Melakukan tugas layanan sosial dalam jangka waktu tertentu', N'1', NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'44', N'1', N'24', N'59', N'29', NULL, NULL, N'menjadi ketua organisasi xyz dan menghasut anggota tentang Ajaran Komunisme/Marxisme-Leninisme.', N'../uploads/Screenshot 2023-05-16 154745.png', NULL, NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'45', N'4', N'24', N'8', N'6', N'23', N'2024-12-29 14:00:57.000', N'makan di dalam laboratorium', N'../uploads/Screenshot 2024-09-25 083408.png', NULL, N'1', N'Teguran tertulis disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai', N'1', NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'46', N'1', N'4', N'36', N'31', NULL, NULL, N'plagiat laporan praktikum milik temannya', N'../uploads/Screenshot 2023-05-16 154745.png', NULL, NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'47', N'4', N'4', N'37', N'4', NULL, NULL, N'berambut gondrong', N'../uploads/Screenshot 2023-05-16 154745.png', NULL, NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[laporan] ([id_laporan], [id_tingkat], [id_pelapor], [id_pelaku], [id_pelanggaran], [verify_by], [verify_at], [deskripsi], [bukti_filepath], [penolakan_filepath], [statusTolak], [sanksi], [verifikasiMhs], [alasanMhsNolak]) VALUES (N'48', N'3', N'4', N'9', N'8', NULL, NULL, N'membuang sampah sembarangan', N'../uploads/Screenshot 2023-05-16 155048.png', NULL, N'2', NULL, NULL, NULL)
GO

SET IDENTITY_INSERT [dbo].[laporan] OFF
GO


-- ----------------------------
-- Table structure for mahasiswa
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[mahasiswa]') AND type IN ('U'))
	DROP TABLE [dbo].[mahasiswa]
GO

CREATE TABLE [dbo].[mahasiswa] (
  [id_mahasiswa] int  IDENTITY(1,1) NOT NULL,
  [id_user] int  NULL,
  [nama] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [nim] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [tgl_lahir] date  NULL,
  [kelas] int  NULL,
  [status_akademik] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [kontak] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[mahasiswa] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of mahasiswa
-- ----------------------------
SET IDENTITY_INSERT [dbo].[mahasiswa] ON
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'1', N'7', N'kayla', N'2341760103', N'2005-04-30', N'15', N'Aktif', N'08123112')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'2', N'8', N'fauziyyah', N'2341760145', N'2004-11-08', N'15', N'Aktif', N'08312323')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'3', N'9', N'bima', N'2341760027', N'2005-05-15', N'15', N'Aktif', N'08192394')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'4', N'10', N'farhan', N'2341760141', N'2005-06-30', N'15', N'Aktif', N'08123412')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'11', N'36', N'qweqwewe', N'1231313', NULL, N'17', N'Cuti', NULL)
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'12', N'37', N'tomas', N'123231', NULL, N'7', N'Cuti', NULL)
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'16', N'42', N'wiki', N'98347189', NULL, N'13', N'Aktif', NULL)
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'24', N'58', N'erika', N'23412984', NULL, N'4', N'Aktif', NULL)
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak]) VALUES (N'25', N'59', N'ying', N'932485', NULL, N'2', N'Cuti', NULL)
GO

SET IDENTITY_INSERT [dbo].[mahasiswa] OFF
GO


-- ----------------------------
-- Table structure for pelanggaran
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[pelanggaran]') AND type IN ('U'))
	DROP TABLE [dbo].[pelanggaran]
GO

CREATE TABLE [dbo].[pelanggaran] (
  [id_pelanggaran] int  IDENTITY(1,1) NOT NULL,
  [nama_pelanggaran] varchar(450) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [id_tingkat] int  NULL
)
GO

ALTER TABLE [dbo].[pelanggaran] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of pelanggaran
-- ----------------------------
SET IDENTITY_INSERT [dbo].[pelanggaran] ON
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'3', N'Berbusana tidak sopan dan tidak rapi Yaitu antara lain adalah:
berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak
berkerah), tank top, hipster, you can see, rok mini, backless, celana
pendek, celana tiga per empat, legging, model celana atau baju
koyak, sandal, sepatu sandal di lingkungan kampus.', N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'4', N'Mahasiswa laki-laki berambut tidak rapi.', N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'5', N'Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned.', N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'6', N'Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'7', N'Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'8', N'Tidak menjaga kebersihan di seluruh area Polinema.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'9', N'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'10', N'Merokok di luar area kawasan merokok.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'11', N'Bermain kartu, game online di area kampus.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'12', N'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'13', N'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'14', N'Merusak sarana dan prasarana yang ada di area Polinema.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'15', N'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll).', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'16', N'Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'17', N'Mengakses materi pornografi di kelas atau area kampus.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'18', N'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'19', N'Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'20', N'Melakukan kegiatan politik praktis di dalam kampus.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'21', N'Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'22', N'Melakukan penyalahgunaan identitas untuk perbuatan negatif.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'23', N'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'24', N'Mencuri dalam bentuk apapun.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'25', N'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'26', N'Melakukan pemerasan dan/atau penipuan.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'27', N'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'28', N'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'29', N'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'30', N'Melakukan pemalsuan data / dokumen / tanda tangan.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'31', N'Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'32', N'Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'33', N'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'34', N'Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'35', N'Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya.', N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [id_tingkat]) VALUES (N'36', N'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan.', N'1')
GO

SET IDENTITY_INSERT [dbo].[pelanggaran] OFF
GO


-- ----------------------------
-- Table structure for penolakan_pelanggaran
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[penolakan_pelanggaran]') AND type IN ('U'))
	DROP TABLE [dbo].[penolakan_pelanggaran]
GO

CREATE TABLE [dbo].[penolakan_pelanggaran] (
  [id_penolakan] int  IDENTITY(1,1) NOT NULL,
  [id_penolak] int  NULL,
  [desc] text COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[penolakan_pelanggaran] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of penolakan_pelanggaran
-- ----------------------------
SET IDENTITY_INSERT [dbo].[penolakan_pelanggaran] ON
GO

SET IDENTITY_INSERT [dbo].[penolakan_pelanggaran] OFF
GO


-- ----------------------------
-- Table structure for prodi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[prodi]') AND type IN ('U'))
	DROP TABLE [dbo].[prodi]
GO

CREATE TABLE [dbo].[prodi] (
  [id_prodi] int  IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[prodi] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of prodi
-- ----------------------------
SET IDENTITY_INSERT [dbo].[prodi] ON
GO

INSERT INTO [dbo].[prodi] ([id_prodi], [nama]) VALUES (N'1', N'D-IV Teknik Informatika')
GO

INSERT INTO [dbo].[prodi] ([id_prodi], [nama]) VALUES (N'2', N'D-IV Sistem Informasi Bisnis')
GO

INSERT INTO [dbo].[prodi] ([id_prodi], [nama]) VALUES (N'3', N'D-II PPLS')
GO

SET IDENTITY_INSERT [dbo].[prodi] OFF
GO


-- ----------------------------
-- Table structure for role
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[role]') AND type IN ('U'))
	DROP TABLE [dbo].[role]
GO

CREATE TABLE [dbo].[role] (
  [id_role] int  IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[role] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of role
-- ----------------------------
SET IDENTITY_INSERT [dbo].[role] ON
GO

INSERT INTO [dbo].[role] ([id_role], [nama]) VALUES (N'1', N'admin')
GO

INSERT INTO [dbo].[role] ([id_role], [nama]) VALUES (N'2', N'dosen')
GO

INSERT INTO [dbo].[role] ([id_role], [nama]) VALUES (N'3', N'staff')
GO

INSERT INTO [dbo].[role] ([id_role], [nama]) VALUES (N'4', N'mahasiswa')
GO

SET IDENTITY_INSERT [dbo].[role] OFF
GO


-- ----------------------------
-- Table structure for staff
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[staff]') AND type IN ('U'))
	DROP TABLE [dbo].[staff]
GO

CREATE TABLE [dbo].[staff] (
  [id_staff] int  IDENTITY(1,1) NOT NULL,
  [id_user] int  NULL,
  [nama] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [nip] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [tgl_lahir] date  NULL
)
GO

ALTER TABLE [dbo].[staff] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of staff
-- ----------------------------
SET IDENTITY_INSERT [dbo].[staff] ON
GO

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'1', N'6', N'maya', N'23457', N'1979-10-20')
GO

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'2', N'5', N'nanda', N'23456', N'1980-09-11')
GO

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'3', N'15', N'rara', N'23458', N'1981-09-10')
GO

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'4', N'25', N'varo', N'23459', N'1999-01-07')
GO

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'8', NULL, N'embuh', N'85854', N'2000-09-18')
GO

SET IDENTITY_INSERT [dbo].[staff] OFF
GO


-- ----------------------------
-- Table structure for tingkat
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[tingkat]') AND type IN ('U'))
	DROP TABLE [dbo].[tingkat]
GO

CREATE TABLE [dbo].[tingkat] (
  [id_tingkat] int  IDENTITY(1,1) NOT NULL,
  [tingkat] varchar(5) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [sanksi] varchar(500) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[tingkat] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of tingkat
-- ----------------------------
SET IDENTITY_INSERT [dbo].[tingkat] ON
GO

INSERT INTO [dbo].[tingkat] ([id_tingkat], [tingkat], [sanksi]) VALUES (N'1', N'I', N'a. Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester dan/atau;
b. Diberhentikan sebagai mahasiswa')
GO

INSERT INTO [dbo].[tingkat] ([id_tingkat], [tingkat], [sanksi]) VALUES (N'2', N'II', N'a. Dikenakan penggantian kerugian atau penggantian benda/barang semacamnya dan/atau;
b. Melakukan tugas layanan sosial dalam jangka waktu tertentu dan/atau;
c. Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran.')
GO

INSERT INTO [dbo].[tingkat] ([id_tingkat], [tingkat], [sanksi]) VALUES (N'3', N'III', N'a. Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi
materai, ditandatangani mahasiswa yang bersangkutan dan DPA;
b. Melakukan tugas khusus, misalnya bertanggungjawab untuk memperbaiki
atau membersihkan kembali, dan tugas-tugas lainnya.')
GO

INSERT INTO [dbo].[tingkat] ([id_tingkat], [tingkat], [sanksi]) VALUES (N'4', N'IV', N'Teguran tertulis disertai dengan surat pernyataan tidak mengulangi perbuatan
tersebut, dibubuhi materai, ditandatangani mahasiswa yang bersangkutan dan
DPA;')
GO

INSERT INTO [dbo].[tingkat] ([id_tingkat], [tingkat], [sanksi]) VALUES (N'5', N'V', N'Teguran lisan disertai dengan surat pernyataan tidak mengulangi perbuatan
tersebut, dibubuhi materai, ditandatangani mahasiswa yang bersangkutan dan
DPA;')
GO

SET IDENTITY_INSERT [dbo].[tingkat] OFF
GO


-- ----------------------------
-- Table structure for upload
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[upload]') AND type IN ('U'))
	DROP TABLE [dbo].[upload]
GO

CREATE TABLE [dbo].[upload] (
  [id_upload] int  IDENTITY(1,1) NOT NULL,
  [lokasi_file] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [submit_time] datetime  NULL,
  [statusSanksi] int  NULL,
  [id_mahasiswa] int  NULL,
  [id_laporan] int  NULL,
  [alasanTolak] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[upload] SET (LOCK_ESCALATION = TABLE)
GO

EXEC sp_addextendedproperty
'MS_Description', N'1=sudah oke, 
2=blm oke',
'SCHEMA', N'dbo',
'TABLE', N'upload',
'COLUMN', N'statusSanksi'
GO


-- ----------------------------
-- Records of upload
-- ----------------------------
SET IDENTITY_INSERT [dbo].[upload] ON
GO

INSERT INTO [dbo].[upload] ([id_upload], [lokasi_file], [submit_time], [statusSanksi], [id_mahasiswa], [id_laporan], [alasanTolak]) VALUES (N'14', N'../uploads/67715a4e8f9d4-Screenshot 2023-05-16 154745.png', N'2024-12-29 21:18:54.590', NULL, N'2', N'45', NULL)
GO

INSERT INTO [dbo].[upload] ([id_upload], [lokasi_file], [submit_time], [statusSanksi], [id_mahasiswa], [id_laporan], [alasanTolak]) VALUES (N'10', N'../uploads/676e9d3b28e7d-Screenshot 2024-04-24 082000.png', N'2024-12-27 19:27:39.173', N'1', N'1', N'37', NULL)
GO

INSERT INTO [dbo].[upload] ([id_upload], [lokasi_file], [submit_time], [statusSanksi], [id_mahasiswa], [id_laporan], [alasanTolak]) VALUES (N'12', N'../uploads/676fd883b30c4-Screenshot 2024-04-23 100848.png', N'2024-12-28 17:52:51.730', N'1', N'1', N'43', NULL)
GO

INSERT INTO [dbo].[upload] ([id_upload], [lokasi_file], [submit_time], [statusSanksi], [id_mahasiswa], [id_laporan], [alasanTolak]) VALUES (N'11', N'../uploads/676fd570ecf22-Screenshot 2023-05-16 154341.png', N'2024-12-28 17:39:44.963', NULL, N'1', N'42', NULL)
GO

INSERT INTO [dbo].[upload] ([id_upload], [lokasi_file], [submit_time], [statusSanksi], [id_mahasiswa], [id_laporan], [alasanTolak]) VALUES (N'13', N'../uploads/676fdb4cf1ffd-Screenshot 2023-05-16 154745.png', N'2024-12-28 18:04:44.983', N'1', N'4', N'38', NULL)
GO

SET IDENTITY_INSERT [dbo].[upload] OFF
GO


-- ----------------------------
-- Table structure for user
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND type IN ('U'))
	DROP TABLE [dbo].[user]
GO

CREATE TABLE [dbo].[user] (
  [id_user] int  IDENTITY(1,1) NOT NULL,
  [username] varchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [password] varchar(12) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [role] int  NULL
)
GO

ALTER TABLE [dbo].[user] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of user
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user] ON
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'1', N'tita', N'123', N'1')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'2', N'okta', N'123', N'1')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'3', N'ani', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'4', N'biru', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'5', N'nanda', N'123', N'3')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'6', N'maya', N'123', N'3')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'7', N'kayla', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'8', N'fauziyyah', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'9', N'bima', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'10', N'farhan', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'11', N'caca', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'15', N'rara', N'123', N'3')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'16', N'lalala', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'18', N'popo', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'21', N'fafa', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'23', N'admin', N'123', N'1')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'24', N'dosen', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'25', N'staff', N'123', N'3')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'36', N'qweqwewe', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'37', N'3324324', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'39', N'budi', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'42', N'wiki', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'43', N'lili', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'44', N'wewe', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'47', N'rere', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'48', N'tata', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'49', N'kay', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'50', N'kela', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'51', N'embuh', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'52', N'keke', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'53', N'wewe', N'123', N'2')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'58', N'erika', N'123', N'4')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'59', N'ying', N'123', N'4')
GO

SET IDENTITY_INSERT [dbo].[user] OFF
GO


-- ----------------------------
-- Auto increment value for dosen
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[dosen]', RESEED, 17)
GO


-- ----------------------------
-- Uniques structure for table dosen
-- ----------------------------
ALTER TABLE [dbo].[dosen] ADD CONSTRAINT [UQ__dosen__36F063DF6D262D91] UNIQUE NONCLUSTERED ([nidn] ASC)
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table dosen
-- ----------------------------
ALTER TABLE [dbo].[dosen] ADD CONSTRAINT [PK__dosen__A9AFDFA21C0DA3EE] PRIMARY KEY CLUSTERED ([id_dosen])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for kelas
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[kelas]', RESEED, 17)
GO


-- ----------------------------
-- Primary Key structure for table kelas
-- ----------------------------
ALTER TABLE [dbo].[kelas] ADD CONSTRAINT [PK__kelas__0801331FF82278C9] PRIMARY KEY CLUSTERED ([id_kelas])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for laporan
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[laporan]', RESEED, 48)
GO


-- ----------------------------
-- Checks structure for table laporan
-- ----------------------------
ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [CK_laporan_verifikasiMhs] CHECK ([verifikasiMhs]=(1) OR [verifikasiMhs]=(2))
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [CK_laporan_statusTolak] CHECK ([statusTolak]=(1) OR [statusTolak]=(2))
GO


-- ----------------------------
-- Primary Key structure for table laporan
-- ----------------------------
ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [PK__laporan__29BD8646A442ACFC] PRIMARY KEY CLUSTERED ([id_laporan])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for mahasiswa
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[mahasiswa]', RESEED, 25)
GO


-- ----------------------------
-- Uniques structure for table mahasiswa
-- ----------------------------
ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [UQ__mahasisw__DF97D0EB66C7C55A] UNIQUE NONCLUSTERED ([nim] ASC)
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Checks structure for table mahasiswa
-- ----------------------------
ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [CK__mahasiswa__statu__46E78A0C] CHECK ([status_akademik]='Tidak Aktif' OR [status_akademik]='Cuti' OR [status_akademik]='Aktif')
GO


-- ----------------------------
-- Primary Key structure for table mahasiswa
-- ----------------------------
ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [PK__mahasisw__9646DE536C4A353A] PRIMARY KEY CLUSTERED ([id_mahasiswa])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for pelanggaran
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[pelanggaran]', RESEED, 53)
GO


-- ----------------------------
-- Primary Key structure for table pelanggaran
-- ----------------------------
ALTER TABLE [dbo].[pelanggaran] ADD CONSTRAINT [PK__pelangga__0E066407FA8FABAE] PRIMARY KEY CLUSTERED ([id_pelanggaran])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for penolakan_pelanggaran
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[penolakan_pelanggaran]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table penolakan_pelanggaran
-- ----------------------------
ALTER TABLE [dbo].[penolakan_pelanggaran] ADD CONSTRAINT [PK__penolaka__C99F58407636A898] PRIMARY KEY CLUSTERED ([id_penolakan])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for prodi
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[prodi]', RESEED, 3)
GO


-- ----------------------------
-- Primary Key structure for table prodi
-- ----------------------------
ALTER TABLE [dbo].[prodi] ADD CONSTRAINT [PK__prodi__DFB638B69ABECD30] PRIMARY KEY CLUSTERED ([id_prodi])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for role
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[role]', RESEED, 5)
GO


-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE [dbo].[role] ADD CONSTRAINT [PK__role__3D48441D21742A29] PRIMARY KEY CLUSTERED ([id_role])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for staff
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[staff]', RESEED, 8)
GO


-- ----------------------------
-- Uniques structure for table staff
-- ----------------------------
ALTER TABLE [dbo].[staff] ADD CONSTRAINT [UQ__staff__DF97D0E8A17366F6] UNIQUE NONCLUSTERED ([nip] ASC)
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table staff
-- ----------------------------
ALTER TABLE [dbo].[staff] ADD CONSTRAINT [PK__staff__12FEDA3CC078E085] PRIMARY KEY CLUSTERED ([id_staff])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for tingkat
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[tingkat]', RESEED, 5)
GO


-- ----------------------------
-- Checks structure for table tingkat
-- ----------------------------
ALTER TABLE [dbo].[tingkat] ADD CONSTRAINT [cek_tingkat] CHECK ([tingkat]='V' OR [tingkat]='IV' OR [tingkat]='III' OR [tingkat]='II' OR [tingkat]='I')
GO


-- ----------------------------
-- Primary Key structure for table tingkat
-- ----------------------------
ALTER TABLE [dbo].[tingkat] ADD CONSTRAINT [PK__tingkat__BA0898ED7C8226FA] PRIMARY KEY CLUSTERED ([id_tingkat])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for upload
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[upload]', RESEED, 14)
GO


-- ----------------------------
-- Checks structure for table upload
-- ----------------------------
ALTER TABLE [dbo].[upload] ADD CONSTRAINT [CK_upload_statusSanksi] CHECK ([statusSanksi]=(1) OR [statusSanksi]=(2))
GO


-- ----------------------------
-- Auto increment value for user
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[user]', RESEED, 59)
GO


-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE [dbo].[user] ADD CONSTRAINT [PK__user__D2D1463708F17EEC] PRIMARY KEY CLUSTERED ([id_user])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table dosen
-- ----------------------------
ALTER TABLE [dbo].[dosen] ADD CONSTRAINT [FK__dosen__id_user__412EB0B6] FOREIGN KEY ([id_user]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[dosen] ADD CONSTRAINT [FK_dosen_id_kelas] FOREIGN KEY ([id_kelas]) REFERENCES [dbo].[kelas] ([id_kelas]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table kelas
-- ----------------------------
ALTER TABLE [dbo].[kelas] ADD CONSTRAINT [FK__kelas__prodi__3D5E1FD2] FOREIGN KEY ([prodi]) REFERENCES [dbo].[prodi] ([id_prodi]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table laporan
-- ----------------------------
ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_ting__4D94879B] FOREIGN KEY ([id_tingkat]) REFERENCES [dbo].[tingkat] ([id_tingkat]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__5070F446] FOREIGN KEY ([id_pelanggaran]) REFERENCES [dbo].[pelanggaran] ([id_pelanggaran]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__4E88ABD4] FOREIGN KEY ([id_pelapor]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__4F7CD00D] FOREIGN KEY ([id_pelaku]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__verify___5165187F] FOREIGN KEY ([verify_by]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table mahasiswa
-- ----------------------------
ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__id_us__44FF419A] FOREIGN KEY ([id_user]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__kelas__45F365D3] FOREIGN KEY ([kelas]) REFERENCES [dbo].[kelas] ([id_kelas]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table pelanggaran
-- ----------------------------
ALTER TABLE [dbo].[pelanggaran] ADD CONSTRAINT [FK_pelanggaran_tingkat] FOREIGN KEY ([id_tingkat]) REFERENCES [dbo].[tingkat] ([id_tingkat]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table penolakan_pelanggaran
-- ----------------------------
ALTER TABLE [dbo].[penolakan_pelanggaran] ADD CONSTRAINT [FK__penolakan__id_pe__59063A47] FOREIGN KEY ([id_penolak]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table staff
-- ----------------------------
ALTER TABLE [dbo].[staff] ADD CONSTRAINT [FK__staff__id_user__5CD6CB2B] FOREIGN KEY ([id_user]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table upload
-- ----------------------------
ALTER TABLE [dbo].[upload] ADD CONSTRAINT [FK_id_laporan] FOREIGN KEY ([id_laporan]) REFERENCES [dbo].[laporan] ([id_laporan]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[upload] ADD CONSTRAINT [FK_id_mhs] FOREIGN KEY ([id_mahasiswa]) REFERENCES [dbo].[mahasiswa] ([id_mahasiswa]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table user
-- ----------------------------
ALTER TABLE [dbo].[user] ADD CONSTRAINT [FK_role_user] FOREIGN KEY ([role]) REFERENCES [dbo].[role] ([id_role]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

