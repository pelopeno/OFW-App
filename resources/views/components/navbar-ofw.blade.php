<div class="navbar-ofw">
    <div class="navbar-ofw-logo">
        <img src="/assets/db-ofw-navbar-logo.png" />
    </div>
    <div class="navbar-ofw-links">
        <a href="">Saving Goals</a>
        <a href="">Investments</a>
        <a href="">Marketplace</a>
        <a href="">Proposals</a>
    </div>
    <div class="navbar-ofw-buttons">
        <a href=""><img src="/assets/db-ofw-navbar-profile.png" /></a>
        <a href=""><img src="/assets/db-ofw-navbar-logout.png" /></a>
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

    .navbar-ofw-logo img {
        width: 40%;
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

    .navbar-ofw-buttons a img {
        width: 60%;
        height: auto;
    }
</style>