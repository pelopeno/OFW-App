@props(['business_name', 'update_date_posted', 'update_content'])

<div class="update-card">
    <div class="update-pfp-cont">
        <img src="/assets/pfp-default.png" />
    </div>

    <div class="update-content-cont">
        <div class="update-info">
            <div class="update-name-date">
                <h3>{{ $business_name }}</h3>
                <p>{{ $update_date_posted}}</p>
            </div>
            <a href=""><img src="/assets/kebab.png"></a>
        </div>

        <div class="update-desc">
            <p>
                {{ $update_content }}
            </p>
        </div>
    </div>
</div>

<style>
    .update-card {
        display: flex;
        flex-direction: row;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        box-sizing: border-box;
        padding: 20px;
        margin-bottom: 15px;
    }

    .update-pfp-cont {
        width: 10%;
        height: 100%;
        margin-right: 15px;
    }

    .update-pfp-cont img {
        width: 100%;
        height: auto;
        border: 2px solid black;
        border-radius: 50px;
    }

    .update-content-cont {
        width: 90%;
        height: 100%;
    }

    .update-info {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .update-name-date {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        margin-bottom: 7.5px;
    }

    .update-name-date h3 {
        font-family: "Tilt Warp", sans-serif;
        font-size: 24px;
        font-weight: 200;
        color: #282828;
        letter-spacing: -0.5px;
        margin: 0;
        margin-right: 20px;
    }

    .update-name-date p {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        color: #666666;
        letter-spacing: -0.5px;
        margin: 0;
    }

    .update-info a img {
        width: auto;
        height: 25px;
        transform: rotate(90deg);
        margin-right: 10px;
    }

    .update-desc {
        width: 90%;
    }

    .update-desc p {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        letter-spacing: -0.5px;
        margin: 0;
    }
</style>