<div class="navbar-ofw">
    <div class="navbar-ofw-logo">
        <a href="{{ route('dashboard') }}"><img src="/assets/db-ofw-navbar-logo.png" /></a>
    </div>
    <div class="navbar-ofw-links">
        <a href="{{ route('saving-goals') }}">Saving Goals</a>
        <a href="{{ route('investment-history') }}">Investments</a>
        <a href="{{ route('marketplace') }}">Marketplace</a>
    </div>
    <div class="navbar-ofw-buttons">
        <a href="{{ route('business-dashboard') }}"><img src="/assets/db-ofw-navbar-profile.png" /></a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="/assets/db-ofw-navbar-logout.png">
            </button>
        </form>
    </div>
</div>

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
        gap: 25px;
    }

    .navbar-ofw-buttons {
        width: 25%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 50px;
    }

    .navbar-ofw-buttons a img {
        width: 40px;
        height: auto;
        display: block;
    }
</style>