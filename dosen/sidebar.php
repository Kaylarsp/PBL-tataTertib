<style>
    .sidebar {
        width: 200px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -150px;
        background-color: #001f54;
        color: white;
        transition: all 0.3s ease;
        overflow-y: auto;
        z-index: 10;
        padding-top: 90px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 20px;
    }

    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }

    .sidebar:hover {
        left: 0;
    }
</style>

<div class="sidebar">
    <ul class="nav flex-column text-white">
        <li><a href="dosen.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
        <li><a href="dataMhs.php"><i class="bi bi-people me-2"></i>Data Mahasiswa</a></li>
        <li><a href="laporanPelanggaran.php"><i class="bi bi-exclamation-circle me-2"></i>Laporkan Pelanggaran</a></li>
        <li><a href="riwayatLaporan.php"><i class="bi bi-bar-chart-line me-2"></i>Riwayat Laporan</a></li>
    </ul>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
    }
</script>