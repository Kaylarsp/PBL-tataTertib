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
        <li><a href="admin.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
        <li class="mb-1 text-white">
            <div class=" d-flex flex-row">
                <i class="bi bi-person-lines-fill mt-3 ms-3"></i>
                <button class="btn btn-toggle rounded collapsed text-white btn-sm" style="width: 100px" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Kelola User
                </button>
            </div>
            <div class="collapse" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="kelolaMahasiswa.php" class="link-dark rounded text-white">Mahasiswa</a></li>
                    <li><a href="kelolaStaff.php" class="link-dark rounded text-white">Staff</a></li>
                    <li><a href="kelolaDosen.php" class="link-dark rounded text-white">Dosen</a></li>
                </ul>
            </div>
        </li>
        <li><a href="lihatPelanggaran.php"><i class="bi bi-clipboard-check me-2"></i>Lihat<br>Pelanggaran</a></li>
        <li><a href="kelolaPelanggaran.php"><i class="bi bi-journal-check me-2"></i>Kelola <br> Pelanggaran</a></li>

    </ul>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
    }
</script>