-- nambah tingkat biar sampe 5 
ALTER TABLE [dbo].[pelanggaran] ALTER COLUMN [tingkat] varchar(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
UPDATE [dbo].[pelanggaran] SET [tingkat] = 'V' WHERE [id_pelanggaran] = 8001

-- update info 
UPDATE [dbo].[mahasiswa] SET [tgl_lahir] = '2004-11-8' WHERE [id_mahasiswa] = 7002

-- change nama --> nama_kelas 
EXEC sp_rename '[dbo].[kelas].[nama]', 'nama_kelas', 'COLUMN'