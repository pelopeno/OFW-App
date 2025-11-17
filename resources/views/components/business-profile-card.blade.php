@props(['business_name', 'business_description'])

<div class="bus-profile-card">
    <div class="bus-profile-header">
        <div class="bus-pfp"> <img src="/assets/pfp-default.png" /> </div>
        <div class="bus-name">
            <h2>{{ $business_name }}</h2> <button>Edit Profile</button>
        </div>
    </div>
    <div class="bus-desc">
        <h3>About the Business</h3>
        <p>{{ $business_description }}</p>
    </div>
</div>
<style>
    .bus-profile-card {
        background-image: url('/assets/bus-profile-bg.png');
        border: 3px solid black;
        border-radius: 25px;
        padding: 25px;
        position: relative;
    }

    .bus-profile-header {
        width: 100%;
        display: flex;
        flex-direction: row;
        margin-bottom: 15px;
        margin-top: -60px;
    }

    .bus-pfp {
        width: 30%;
        display: flex;
        align-items: flex-end;
    }

    .bus-pfp img {
        width: 100%;
        border: 3px solid black;
        border-radius: 15px;
    }

    .bus-name {
        width: 70%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        margin-left: 20px;
    }

    .bus-name h2 {
        font-family: "Tilt Warp", sans-serif;
        font-size: 42px;
        font-weight: 200;
        color: white;
        letter-spacing: -1.5px;
        line-height: 38px;
    }

    .bus-name button {
        width: 60%;
        background-color: white;
        margin-top: 5px;
        border: 2px solid black;
        border-radius: 10px;
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        letter-spacing: -1px;
        cursor: pointer;
    }

    .bus-desc {
        max-height: 45vh;
        background-image: url('/assets/bus-profile-desc-bg.png');
        background-color: rgba(255, 255, 255, 0.5);
        background-blend-mode: lighten;
        border: 3px solid black;
        border-radius: 15px;
        padding: 20px;
        overflow-y: auto;
    }

    .bus-desc h3 {
        font-family: "Tilt Warp", sans-serif;
        font-size: 30px;
        font-weight: 200;
        letter-spacing: -1.5px;
        color: #282828;
        margin: 0;
    }

    .bus-desc p {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        color: black;
        line-height: 24px;
        margin-top: 10px;
    }
</style>