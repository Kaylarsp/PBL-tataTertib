-- CREATE DATABASE PBL;
CREATE TABLE role (
    id_role INT PRIMARY KEY,
    nama VARCHAR(32)
);

CREATE TABLE [user] (
    id_user INT PRIMARY KEY,
    username VARCHAR(32),
    password VARCHAR(12),
    role INT,
    FOREIGN KEY (role) REFERENCES role(id_role)
);


CREATE TABLE staff (
    id_staff INT PRIMARY KEY,
    id_user INT,
    nama VARCHAR(100),
    nip VARCHAR(15),
    tgl_lahir DATE,
    FOREIGN KEY (id_user) REFERENCES [user](id_user)
);

CREATE TABLE dosen (
    id_dosen INT PRIMARY KEY,
    id_user INT,
    nama VARCHAR(100),
    nidn VARCHAR(15),
    tgl_lahir DATE,
    FOREIGN KEY (id_user) REFERENCES [user](id_user)
);

CREATE TABLE prodi (
    id_prodi INT PRIMARY KEY,
    nama VARCHAR(32)
);

CREATE TABLE kelas (
    id_kelas INT PRIMARY KEY,
    nama VARCHAR(32),
    prodi INT,
    FOREIGN KEY (prodi) REFERENCES prodi(id_prodi)
);

CREATE TABLE mahasiswa (
    id_mahasiswa INT PRIMARY KEY,
    id_user INT,
    nama VARCHAR(100),
    nim VARCHAR(15),
    tgl_lahir DATE,
    kelas INT,
    status_akademik VARCHAR(15) CHECK (status_akademik IN ('Aktif', 'Tidak Aktif', 'Cuti')),
    FOREIGN KEY (id_user) REFERENCES [user](id_user),
    FOREIGN KEY (kelas) REFERENCES kelas(id_kelas)
);
CREATE TABLE pelanggaran (
    id_pelanggaran INT PRIMARY KEY,
    nama_pelanggaran VARCHAR(100),
    tingkat VARCHAR(4) CHECK (tingkat IN ('I', 'II', 'III', 'IV','V')),
    [desc] TEXT,
);

ALTER TABLE pelanggaran
ALTER COLUMN nama_pelanggaran VARCHAR(255);


CREATE TABLE transaksi_pelanggaran (
    id_transaksi_pelanggaran INT PRIMARY KEY,
    id_sanksi INT,
    id_pelapor INT,
    id_pelaku INT,
    id_pelanggaran INT,
    verify_by INT,
    verify_at DATETIME,
    status VARCHAR(20) CHECK (status IN ('Menunggu', 'Proses verifikasi', 'Selesai', 'Ditolak')),
    FOREIGN KEY (id_sanksi) REFERENCES [user](id_user),
    FOREIGN KEY (id_pelapor) REFERENCES [user](id_user),
    FOREIGN KEY (id_pelaku) REFERENCES [user](id_user),
    FOREIGN KEY (id_pelanggaran) REFERENCES [user](id_user),
);

CREATE TABLE sanksi (
    id_sanksi INT PRIMARY KEY,
    pelanggaran INT,
    tugas VARCHAR(100),
    verify_by INT,
    FOREIGN KEY (pelanggaran) REFERENCES pelanggaran(id_pelanggaran)
);

CREATE TABLE notifikasi (
    id_notifikasi INT PRIMARY KEY,
    nama VARCHAR(32),
    id_sender INT,
    id_recipient INT,
    content TEXT,
    sent_at DATETIME,
    read_at DATETIME,
    FOREIGN KEY (id_sender) REFERENCES [user](id_user),
    FOREIGN KEY (id_recipient) REFERENCES [user](id_user)
);
CREATE TABLE penolakan_pelanggaran (
    id_penolakan INT PRIMARY KEY,
    id_penolak INT,
    [desc] TEXT,
    FOREIGN KEY (id_penolak) REFERENCES [user](id_user)
);
