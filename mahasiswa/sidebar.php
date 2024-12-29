<style>
    .sidebar {
        width: 200px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -150px;
        /* background-color: #001f54; */
        background: rgb(14, 11, 38);
        background: linear-gradient(180deg, rgba(14, 11, 38, 1) 0%, rgba(0, 31, 84, 1) 50%, rgba(165, 191, 204, 1) 100%);
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
    <ul class="nav flex-column">
        <li><a href="listTatib.php"><i class="bi bi-list-check me-2"></i>List Tata Tertib</a></li>
        <li><a href="notifikasi.php"><i class="bi bi-bell me-2"></i>Notifikasi</a></li>
    </ul>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
    }
</script>