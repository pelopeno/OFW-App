@props(['project_name', 'invested_amt', 'image' => '/assets/default-project-pic.png'])

@php
    $image = $image ? (str_starts_with($image, 'http') || str_starts_with($image, '/') 
        ? $image 
        : asset($image)) 
        : asset('/assets/default-project-pic.png');
@endphp

<div class="investment-card">
    <div class="investment-card-pfp">
        <img src="{{ asset($image) }}" alt="{{ $project_name }} image" />
    </div>
    <div class="investment-card-content">
        <h2>{{ $project_name }}</h2>
        <p>₱{{ $invested_amt }} Allocated</p>
    </div>
    <div class="investment-card-arrow">
        <img src="/assets/arrow.png" />
    </div>
</div>

<style>
    .investment-card {
        display: flex;
        flex-direction: row;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        margin-bottom: 15px;
    }

    .investment-card-pfp {
        width: 20%;
        padding: 10px;
    }

    .investment-card-pfp img {
        border: 2px solid black;
        border-radius: 15px;
        width: 100%;
        height: auto;
    }



    .investment-card-content {
        width: 75%;
        display: flex;
        flex-direction: column;
        margin-top: 10px;
        margin-left: 15px;
    }

    .investment-card-content h2 {
        margin-bottom: 0;
    }

    .investment-card-content p {
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        letter-spacing: -1px;
        color: #848484;
        margin: 0;
        margin-bottom: 10px;
    }

    .investment-card-arrow {
        width: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .investment-card-arrow img {
        height: 25px;
        width: auto;
    }
</style>