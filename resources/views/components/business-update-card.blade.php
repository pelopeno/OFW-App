@props(['business_name', 'update_date_posted', 'update_content', 'update_id' => null, 'update_image' => null])

<div class="bus-update-card update-card-clickable" @if($update_id) data-update-id="{{ $update_id }}" data-full-content="{{ $update_content }}" data-update-image="{{ $update_image }}" @endif>
    <div class="bus-update-header">
        <h3>{{ $business_name }}</h3>
        <span>{{ $update_date_posted}}</span>
        @if($update_id)
        <button class="delete-update-btn" onclick="event.stopPropagation(); deleteUpdate({{ $update_id }})">×</button>
        @endif
    </div>
    <p>{{ Str::limit($update_content, 150) }}</p>
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

    .update-card-clickable {
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .update-card-clickable:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .update-card-clickable:hover h3 {
        color: #A93D3D;
        transition: color 0.3s ease;
    }
</style>