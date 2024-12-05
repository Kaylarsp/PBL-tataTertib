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

 Date: 05/12/2024 15:49:35
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
  [tgl_lahir] date  NULL
)
GO

ALTER TABLE [dbo].[dosen] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of dosen
-- ----------------------------
SET IDENTITY_INSERT [dbo].[dosen] ON
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir]) VALUES (N'1', N'4', N'biru', N'23459', N'1980-08-15')
GO

INSERT INTO [dbo].[dosen] ([id_dosen], [id_user], [nama], [nidn], [tgl_lahir]) VALUES (N'2', N'11', N'caca', N'23460', N'1988-03-12')
GO

SET IDENTITY_INSERT [dbo].[dosen] OFF
GO


-- ----------------------------
-- Table structure for DPA
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[DPA]') AND type IN ('U'))
	DROP TABLE [dbo].[DPA]
GO

CREATE TABLE [dbo].[DPA] (
  [id_dpa] int  IDENTITY(1,1) NOT NULL,
  [nama_dpa] varchar(50) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [id_kelas] int  NULL,
  [id_user] int  NULL
)
GO

ALTER TABLE [dbo].[DPA] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of DPA
-- ----------------------------
SET IDENTITY_INSERT [dbo].[DPA] ON
GO

INSERT INTO [dbo].[DPA] ([id_dpa], [nama_dpa], [id_kelas], [id_user]) VALUES (N'1', N'anto', N'15', N'12')
GO

INSERT INTO [dbo].[DPA] ([id_dpa], [nama_dpa], [id_kelas], [id_user]) VALUES (N'2', N'jaya', N'2', N'13')
GO

INSERT INTO [dbo].[DPA] ([id_dpa], [nama_dpa], [id_kelas], [id_user]) VALUES (N'3', N'sasa', N'14', N'14')
GO

SET IDENTITY_INSERT [dbo].[DPA] OFF
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
  [status] varchar(20) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [deskripsi] text COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[laporan] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of laporan
-- ----------------------------
SET IDENTITY_INSERT [dbo].[laporan] ON
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
  [kontak_ortu] varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[mahasiswa] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of mahasiswa
-- ----------------------------
SET IDENTITY_INSERT [dbo].[mahasiswa] ON
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak_ortu]) VALUES (N'1', N'7', N'kayla', N'2341760103', N'2005-04-30', N'15', N'Aktif', N'08123112')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak_ortu]) VALUES (N'2', N'8', N'fauziyyah', N'2341760145', N'2004-11-08', N'15', N'Aktif', N'08312323')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak_ortu]) VALUES (N'3', N'9', N'bima', N'2341760027', N'2005-05-15', N'15', N'Aktif', N'08192394')
GO

INSERT INTO [dbo].[mahasiswa] ([id_mahasiswa], [id_user], [nama], [nim], [tgl_lahir], [kelas], [status_akademik], [kontak_ortu]) VALUES (N'4', N'10', N'farhan', N'2341760141', N'2005-06-30', N'15', N'Aktif', N'08123412')
GO

SET IDENTITY_INSERT [dbo].[mahasiswa] OFF
GO


-- ----------------------------
-- Table structure for notifikasi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[notifikasi]') AND type IN ('U'))
	DROP TABLE [dbo].[notifikasi]
GO

CREATE TABLE [dbo].[notifikasi] (
  [id_notifikasi] int  IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [id_sender] int  NULL,
  [id_recipient] int  NULL,
  [content] text COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [sent_at] datetime  NULL,
  [read_at] datetime  NULL
)
GO

ALTER TABLE [dbo].[notifikasi] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of notifikasi
-- ----------------------------
SET IDENTITY_INSERT [dbo].[notifikasi] ON
GO

SET IDENTITY_INSERT [dbo].[notifikasi] OFF
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
  [deskripsi] text COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [tingkat] int  NULL
)
GO

ALTER TABLE [dbo].[pelanggaran] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of pelanggaran
-- ----------------------------
SET IDENTITY_INSERT [dbo].[pelanggaran] ON
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'2', N'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', NULL, N'5')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'3', N'Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah:
berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak
berkerah), tank top, hipster, you can see, rok mini, backless, celana
pendek, celana tiga per empat, legging, model celana atau baju
koyak, sandal, sepatu sandal di lingkungan kampus', NULL, N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'4', N'Mahasiswa laki-laki berambut tidak rapi', NULL, N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'5', N'Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned.', NULL, N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'6', N'Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', NULL, N'4')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'7', N'Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'8', N'Tidak menjaga kebersihan di seluruh area Polinema', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'9', N'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'10', N'Merokok di luar area kawasan merokok', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'11', N'Bermain kartu, game online di area kampus', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'12', N'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'13', N'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', NULL, N'3')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'14', N'Merusak sarana dan prasarana yang ada di area Polinema', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'15', N'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll)', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'16', N'Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'17', N'Mengakses materi pornografi di kelas atau area kampus', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'18', N'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'19', N'Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'20', N'Melakukan kegiatan politik praktis di dalam kampus', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'21', N'Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'22', N'Melakukan penyalahgunaan identitas untuk perbuatan negatif', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'23', N'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', NULL, N'2')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'24', N'Mencuri dalam bentuk apapun', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'25', N'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'26', N'Melakukan pemerasan dan/atau penipuan', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'27', N'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'28', N'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'29', N'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'30', N'Melakukan pemalsuan data / dokumen / tanda tangan.', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'31', N'Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'32', N'Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'33', N'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema.', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'34', N'Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'35', N'Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', NULL, N'1')
GO

INSERT INTO [dbo].[pelanggaran] ([id_pelanggaran], [nama_pelanggaran], [deskripsi], [tingkat]) VALUES (N'36', N'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan', NULL, N'1')
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

INSERT INTO [dbo].[role] ([id_role], [nama]) VALUES (N'5', N'dpa')
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

INSERT INTO [dbo].[staff] ([id_staff], [id_user], [nama], [nip], [tgl_lahir]) VALUES (N'3', N'15', N'rara', N'23458', N'1981-09-05')
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
  [nama_file] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [lokasi_file] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [waktu] datetime  NULL
)
GO

ALTER TABLE [dbo].[upload] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of upload
-- ----------------------------
SET IDENTITY_INSERT [dbo].[upload] ON
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

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'12', N'anto', N'123', N'5')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'13', N'jaya', N'123', N'5')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'14', N'sasa', N'123', N'5')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'15', N'rara', N'123', N'3')
GO

INSERT INTO [dbo].[user] ([id_user], [username], [password], [role]) VALUES (N'16', N'lalala', N'123', N'4')
GO

SET IDENTITY_INSERT [dbo].[user] OFF
GO


-- ----------------------------
-- Auto increment value for dosen
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[dosen]', RESEED, 2)
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
-- Auto increment value for DPA
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[DPA]', RESEED, 3)
GO


-- ----------------------------
-- Primary Key structure for table DPA
-- ----------------------------
ALTER TABLE [dbo].[DPA] ADD CONSTRAINT [PK__DPA__D5EABA0198644918] PRIMARY KEY CLUSTERED ([id_dpa])
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
DBCC CHECKIDENT ('[dbo].[laporan]', RESEED, 1)
GO


-- ----------------------------
-- Checks structure for table laporan
-- ----------------------------
ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [CK__laporan__status__52593CB8] CHECK ([status]='Menunggu' OR [status]='Proses verifikasi' OR [status]='Selesai' OR [status]='Ditolak')
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
DBCC CHECKIDENT ('[dbo].[mahasiswa]', RESEED, 4)
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
-- Auto increment value for notifikasi
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[notifikasi]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table notifikasi
-- ----------------------------
ALTER TABLE [dbo].[notifikasi] ADD CONSTRAINT [PK__notifika__8FD1662AC6572DEE] PRIMARY KEY CLUSTERED ([id_notifikasi])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for pelanggaran
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[pelanggaran]', RESEED, 36)
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
DBCC CHECKIDENT ('[dbo].[staff]', RESEED, 3)
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
DBCC CHECKIDENT ('[dbo].[upload]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table upload
-- ----------------------------
ALTER TABLE [dbo].[upload] ADD CONSTRAINT [PK__upload__3F684A04D92278AD] PRIMARY KEY CLUSTERED ([id_upload])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for user
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[user]', RESEED, 16)
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


-- ----------------------------
-- Foreign Keys structure for table DPA
-- ----------------------------
ALTER TABLE [dbo].[DPA] ADD CONSTRAINT [FK__DPA__id_kelas__5535A963] FOREIGN KEY ([id_kelas]) REFERENCES [dbo].[kelas] ([id_kelas]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[DPA] ADD CONSTRAINT [FK__DPA__id_user__5629CD9C] FOREIGN KEY ([id_user]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
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

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__4E88ABD4] FOREIGN KEY ([id_pelapor]) REFERENCES [dbo].[mahasiswa] ([id_mahasiswa]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__4F7CD00D] FOREIGN KEY ([id_pelaku]) REFERENCES [dbo].[mahasiswa] ([id_mahasiswa]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__id_pela__5070F446] FOREIGN KEY ([id_pelanggaran]) REFERENCES [dbo].[pelanggaran] ([id_pelanggaran]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[laporan] ADD CONSTRAINT [FK__laporan__verify___5165187F] FOREIGN KEY ([verify_by]) REFERENCES [dbo].[dosen] ([id_dosen]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table mahasiswa
-- ----------------------------
ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__id_us__44FF419A] FOREIGN KEY ([id_user]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__kelas__45F365D3] FOREIGN KEY ([kelas]) REFERENCES [dbo].[kelas] ([id_kelas]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table notifikasi
-- ----------------------------
ALTER TABLE [dbo].[notifikasi] ADD CONSTRAINT [FK__notifikas__id_se__619B8048] FOREIGN KEY ([id_sender]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[notifikasi] ADD CONSTRAINT [FK__notifikas__id_re__628FA481] FOREIGN KEY ([id_recipient]) REFERENCES [dbo].[user] ([id_user]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table pelanggaran
-- ----------------------------
ALTER TABLE [dbo].[pelanggaran] ADD CONSTRAINT [FK_pelanggaran_tingkat] FOREIGN KEY ([tingkat]) REFERENCES [dbo].[tingkat] ([id_tingkat]) ON DELETE NO ACTION ON UPDATE NO ACTION
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

