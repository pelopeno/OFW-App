<div class="navbar-ofw">
    <div class="navbar-ofw-logo">
        <a href="{{ route('dashboard') }}"><img src="/assets/db-ofw-navbar-logo.png" /></a>
    </div>
    <div class="navbar-ofw-links">
        <a href="{{ route('saving-goals') }}">Saving Goals</a>
        <a href="{{ route('investment-history') }}">Investments</a>
        <a href="{{ route('marketplace') }}">Marketplace</a>
        <a href="{{ route('history') }}">Transactions</a>
        <a href="{{ route('convert-currency') }}">Converter</a>
    </div>
    <div class="navbar-ofw-buttons">
        <button type="button" class="logout-btn" onclick="goToProfile()">
            <img src="/assets/db-ofw-navbar-settings.png">
        </button>
        <button type="button" class="logout-btn" onclick="confirmLogout()">
            <img src="/assets/db-ofw-navbar-logout.png">
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
    .navbar-ofw {
        width: 100%;
        height: 75px;
        background-image: url('/assets/db-ofw-navbar.png');
        border-bottom: 3px solid black;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .navbar-ofw-logo {
        width: 25%;
        display: flex;
        justify-content: center;
    }

    .navbar-ofw-logo a {
        width: 60%;
        display: flex;
        justify-content: center;
    }

    .navbar-ofw-logo a img {
        width: 175px;
        height: auto;
    }

    .navbar-ofw-links {
        width: 50%;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .navbar-ofw-links a {
        font-family: "Tilt Warp", sans-serif;
        font-size: 20px;
        color: #FFEBBD;
    }

    .navbar-ofw-buttons {
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

    function goToProfile() {
        window.location.href = '/user/profile';
    }
</script>