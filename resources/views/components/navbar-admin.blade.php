<div class="navbar-admin">
    <div class="navbar-admin-logo">
        <a href="{{ route('admin-dashboard') }}"><img src="/assets/admin-navbar-logo.png" /></a>
    </div>
    <div class="navbar-admin-links">
        <a href="{{ route('admin-monitoring') }}">Monitoring</a>
        
        <a href="{{ route('admin.project-approval') }}">Project Approval</a>

        <a href="{{ route('admin-user-management') }}">User Management</a>
    </div>
    <div class="navbar-admin-buttons">
        <button type="button" class="logout-btn" onclick="confirmLogout()">
            <img src="/assets/admin-navbar-logout.png">
        </button>
    </div>
</div>

<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
    @csrf
</form>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .navbar-admin {
        width: 100%;
        height: 75px;
        background-image: url('/assets/admin-navbar.png');
        border-bottom: 3px solid black;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .navbar-admin-logo {
        width: 25%;
        display: flex;
        justify-content: center;
    }

    .navbar-admin-logo a {
        width: 60%;
        display: flex;
        justify-content: center;
    }

    .navbar-admin-logo a img {
        width: 175px;
        height: auto;
    }

    .navbar-admin-links {
        width: 50%;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .navbar-admin-links a {
        font-family: "Tilt Warp", sans-serif;
        font-size: 20px;
        color: #B4D1FF;
    }

    .navbar-admin-links a:hover {
        color: white;
        transition: 0.2s;
    }

    .navbar-admin-buttons {
        width: 25%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 50px;
    }

    .logout-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .logout-btn img {
        width: 40px;
        height: auto;
        display: block;
        transition: transform 0.2s;
    }

    .logout-btn:hover img {
        transform: scale(1.1);
    }
</style>

<script>
    function confirmLogout() {
        Swal.fire({
            icon: 'warning',
            title: 'Logout?',
            text: 'Are you sure you want to logout?',
            showCancelButton: true,
            confirmButtonColor: '#A68749',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }
</script>