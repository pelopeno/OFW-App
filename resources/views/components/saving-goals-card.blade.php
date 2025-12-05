@props(['goal'])

<div class="goals-card">
    <div class="goals-card-content">
        <h2>{{ $goal->name }}</h2>
        <p>₱{{ number_format($goal->current_amount, 2) }} of ₱{{ number_format($goal->target_amount, 2) }}</p>
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $goal->target_amount > 0 ? ($goal->current_amount / $goal->target_amount) * 100 : 0 }}%"></div>
        </div>
    </div>
    <div class="goals-card-button">
        <a href="#" class="allocate-funds-btn" 
           data-goal-id="{{ $goal->id }}" 
           data-goal-name="{{ $goal->name }}">Allocate Funds</a>
        <a href="#" class="withdraw-funds-btn" 
           data-goal-id="{{ $goal->id }}" 
           data-goal-name="{{ $goal->name }}"
           data-current-amount="{{ $goal->current_amount }}">Withdraw Funds</a>
    </div>
    <div class="goals-card-kebab">
        <a href=""><img src="/assets/kebab.png"></a>
    </div>
</div>

<style>
    .goals-card {
        display: flex;
        flex-direction: row;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        margin-bottom: 15px;
    }

    .goals-card-content {
        width: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: 15px;
        margin-bottom: 25px;
        margin-right: 15px;
        margin-left: 30px;
    }

    .goals-card-content h2 {
        margin-bottom: 0;
    }

    .goals-card-content p {
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        letter-spacing: -1px;
        color: #848484;
        margin: 0;
        margin-bottom: 10px;
    }

    .goals-card-button {
        width: 40%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .goals-card-button a {
        width: 100%;
        background-color: white;
        border: 2px solid black;
        border-radius: 10px;
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        color: #282828;
    }

    .goals-card-kebab {
        width: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .goals-card-kebab img {
        height: 25px;
        width: auto;
        transform: rotate(90deg);
    }

    .progress-container {
        width: 100%;
        height: 10px;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background-color: #4caf50;
        transition: width 0.3s ease;
    }
</style>