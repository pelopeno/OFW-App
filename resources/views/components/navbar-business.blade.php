<div class="navbar-bus">
    <div class="navbar-bus-logo">
        <a href="{{ route('business-dashboard') }}"><img src="/assets/bus-navbar-logo.png" /></a>
    </div>
    <div class="navbar-bus-links">
        <!--If may lalagay kayo na redirect links, lagay nalang dito similar sa ofw navbar-->
        <a href="{{ route('contributions') }}">Captial Contributions</a>
    </div>
    <div class="navbar-bus-buttons">
       <button type="button" class="logout-btn" onclick="confirmLogout()">
            <img src="/assets/bus-navbar-logout.png">
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
    .navbar-bus {
        width: 100%;
        height: 75px;
        background-image: url('/assets/bus-navbar.png');
        border-bottom: 3px solid black;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .navbar-bus-logo {
        width: 25%;
        display: flex;
        justify-content: center;
    }

    .navbar-bus-logo a {
        width: 60%;
        display: flex;
        justify-content: center;
    }

    .navbar-bus-logo a img {
        width: 175px;
        height: auto;
    }

    .navbar-bus-links {
        width: 50%;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .navbar-bus-links a {
        font-family: "Tilt Warp", sans-serif;
        font-size: 20px;
        color: #FFEBBD;
    }

    .navbar-bus-buttons {
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