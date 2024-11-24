INSERT INTO role (id_role, nama)
VALUES
    (1001, 'admin'),
    (1002, 'dosen'),
    (1003, 'staff') ,
    (1004, 'mahasiswa');

SELECT * FROM role;

INSERT INTO [user] (id_user, username, password, role)
VALUES
    (2001, 'titis','123',1001),
    (2002, 'okta','123',1001 ),
    (2003, 'farid','123', 1002),
    (2004, 'elok','123', 1002),
    (2005, 'nanda','123',1003),
    (2006, 'maya','123',1003),
    (2007, 'kayla','123', 1004),
    (2008, 'fauziyyah','123',1004),
    (2009, 'bima','123', 1004),
    (2010, 'farhan','123', 1004);

SELECT * FROM [user];

ALTER TABLE staff
ADD CONSTRAINT UniqueNumber UNIQUE (nip);

INSERT INTO staff (id_staff, id_user,nama, nip, tgl_lahir)
VALUES
    (3001, 2005,'nanda','23456','1980-09-11'),
    (1002, 2006,'maya','23457','1979-10-20');

SELECT * FROM staff;

ALTER TABLE dosen
ADD CONSTRAINT NumberUnique UNIQUE (nidn);

INSERT INTO dosen (id_dosen, id_user,nama, nidn, tgl_lahir)
VALUES
    (4001, 2003,'farid','23458','1985-10-07'),
    (4002, 2004,'elok','23459','1980-08-15');

SELECT * FROM dosen;

INSERT INTO prodi (id_prodi, nama)
VALUES
    (5001, 'D-IV Teknik Informatika'),
    (5002, 'D-IV Sistem Informasi Bisnis'),
    (5003, 'D-II PPLS');

SELECT * FROM prodi;

INSERT INTO kelas (id_kelas, nama, prodi)
VALUES
    (6001, 'TI-2A',5001),
    (6002, 'TI-2B',5001),
    (6003, 'TI-2C',5001),
    (6004, 'TI-2D',5001),
    (6005, 'TI-2E',5001),
    (6006, 'TI-2F',5001),
    (6007, 'TI-2G',5001),
    (6008, 'TI-2H',5001),
    (6009, 'TI-2I',5001),
    (6010, 'SIB-2A',5002),
    (6011, 'SIB-2B',5002),
    (6012, 'SIB-2C',5002),
    (6013, 'SIB-2D',5002),
    (6014, 'SIB-2E',5002),
    (6015, 'SIB-2F',5002),
    (6016, 'SIB-2G',5002),
    (6017, 'PPLS-2A',5003);

SELECT * FROM kelas;

ALTER TABLE mahasiswa
ADD CONSTRAINT NamaUnik UNIQUE (nim);

INSERT INTO mahasiswa (id_mahasiswa, id_user,nama, nim, tgl_lahir, kelas, status_akademik)
VALUES
    (7001,2007,'kayla','2341760103','2005-04-30',6015,'Aktif'),
    (7002,2008,'fauziyyah','2341760145','2005-04-30',6015,'Aktif'),
    (7003,2009,'bima','2341760027','2005-05-15',6015,'Aktif'),
    (7004,2010,'farhan','2341760141','2005-06-30',6015,'Aktif');

SELECT * FROM mahasiswa;

INSERT INTO pelanggaran (id_pelanggaran, nama_pelanggaran, tingkat)
VALUES 
(8001, 'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', 'I'),
(8002, 'Berbusana tidak sopan dan tidak rapi', 'IV'),
(8003, 'Mahasiswa laki-laki berambut tidak rapi', 'IV'),
(8004, 'Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned.', 'IV'),
(8005, 'Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', 'IV'),
(8006, 'Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi', 'III'),
(8007, 'Tidak menjaga kebersihan di seluruh area Polinema', 'III'),
(8008, 'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', 'III'),
(8009, 'Merokok di luar area kawasan merokok', 'III'),
(8010, 'Bermain kartu, game online di area kampus', 'III'),
(8011, 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', 'III'),
(8012, 'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', 'III'),
(8013, 'Merusak sarana dan prasarana yang ada di area Polinema', 'II'),
(8014, 'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll)', 'II'),
(8015, 'Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang', 'II'),
(8016, 'Mengakses materi pornografi di kelas atau area kampus', 'II'),
(8017, 'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal', 'II'),
(8018, 'Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', 'II'),
(8019, 'Melakukan kegiatan politik praktis di dalam kampus', 'II'),
(8020, 'Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', 'II'),
(8021, 'Melakukan penyalahgunaan identitas untuk perbuatan negatif', 'II'),
(8022, 'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', 'II'),
(8023, 'Mencuri dalam bentuk apapun', 'I'),
(8024, 'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', 'I'),
(8025, 'Melakukan pemerasan dan/atau penipuan', 'I'),
(8026, 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 'I'),
(8027, 'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema', 'I'),
(8028, 'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 'I'),
(8029, 'Melakukan pemalsuan data / dokumen / tanda tangan.', 'I'),
(8030, 'Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah', 'I'),
(8031, 'Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun', 'I'),
(8032, 'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema.', 'I'),
(8033, 'Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I'),
(8034, 'Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I'),
(8035, 'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan', 'I');

SELECT * FROM pelanggaran;

INSERT INTO sanksi (id_sanksi, pelanggaran, tugas)
VALUES
(9001,8001,'I'),
(9002,8002, 'IV'),
(9003,8003,'IV'),
(9004,8004, 'IV'),
(9005,8005, 'IV'),
(9006,8006, 'III'),
(9007,8007, 'III'),
(9008,8008, 'III'),
(9009,8009, 'III'),
(9010, 8010, 'III'),
(9011, 8011, 'III'),
(9012, 8012, 'III'),
(9013,8013, 'II'),
(9014,8014, 'II'),
(9015,8015, 'II'),
(9016,8016, 'II'),
(9017, 8017,'II'),
(9018, 8018, 'II'),
(9019, 8019, 'II'),
(9020, 8020, 'II'),
(9021, 8021, 'II'),
(9022, 8022, 'II'),
(9023, 8023, 'I'),
(9024,8024, 'I'),
(9025,8025, 'I'),
(9026,8026, 'I'),
(9027,8027, 'I'),
(9028,8028, 'I'),
(9029,8029,'I'),
(9030, 8030, 'I'),
(9031,8031, 'I'),
(9032,8032, 'I'),
(9033,8033, 'I'),
(9034,8034, 'I'),
(9035, 8035, 'I');

SELECT * FROM sanksi;
