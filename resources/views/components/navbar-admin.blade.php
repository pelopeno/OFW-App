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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="/assets/admin-navbar-logout.png">
            </button>
        </form>
    </div>
</div>

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

    .navbar-admin-buttons {
        width: 25%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 50px;
    }

    .navbar-admin-buttons a img {
        width: 40px;
        height: auto;
        display: block;
    }
</style>