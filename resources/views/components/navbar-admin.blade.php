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
        text-decoration: none;
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

    body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
        overflow: hidden !important;
    }
    
    body.swal2-height-auto {
        height: 100% !important;
    }
    
    /* Force proper container positioning */
    .swal2-container {
        z-index: 999999 !important;
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0.625em !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        background-color: transparent !important;
    }
    
    .swal2-popup {
        font-family: "Varela Round", sans-serif !important;
        position: relative !important;
        box-sizing: border-box !important;
        z-index: 999999 !important;
        margin: auto !important;
        background-color: transparent;
        color: white;
    }

    .swal2-title {
        font-family: "Tilt Warp", sans-serif;
        font-weight: 200;
    }

    .swal2-confirm, .swal2-cancel {
        font-family: "Varela Round";
        border: 3px solid white;
    }

    .swal2-confirm {
        background-color: #2a65c3 !important;
        color: white;
    }

    div:where(.swal2-icon).swal2-warning {
        border-color: #B4D1FF !important;
        color: #B4D1FF !important;
    }
    
    /* Ensure backdrop appears */
    .swal2-container.swal2-backdrop-show {
        background: rgba(0, 0, 0, 0.75) !important;
    }
    
    
    /* Fix for any body positioning conflicts */
    .landing-body {
        position: relative !important;
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