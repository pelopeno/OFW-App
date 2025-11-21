<div class="navbar-bus">
    <div class="navbar-bus-logo">
        <a href="{{ route('business-dashboard') }}"><img src="/assets/bus-navbar-logo.png" /></a>
    </div>
    <div class="navbar-bus-links">
        <!--If may lalagay kayo na redirect links, lagay nalang dito similar sa ofw navbar-->
    </div>
    <div class="navbar-bus-buttons">
       <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="/assets/bus-navbar-logout.png">
            </button>
        </form>
    </div>
</div>

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

    .navbar-bus-buttons a img {
        width: 40px;
        height: auto;
        display: block;
    }
</style>