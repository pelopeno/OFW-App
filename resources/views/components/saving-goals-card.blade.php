@props(['goal'])

@php
    $percentage = $goal->target_amount > 0 ? ($goal->current_amount / $goal->target_amount) * 100 : 0;
    $isCompleted = $percentage >= 100;
@endphp

<div class="goals-card {{ $isCompleted ? 'completed' : '' }}">
    <div class="goals-card-content">
        <div class="goals-header">
            <h2>{{ $goal->name }}</h2>
            @if($isCompleted)
                <span class="status-badge completed">✓ Completed</span>
            @else
                <span class="status-badge in-progress">{{ number_format($percentage, 0) }}%</span>
            @endif
        </div>
        <p>₱{{ number_format($goal->current_amount, 2) }} of ₱{{ number_format($goal->target_amount, 2) }}</p>
        <div class="progress-container">
            <div class="progress-bar {{ $isCompleted ? 'completed' : '' }}" style="width: {{ min($percentage, 100) }}%"></div>
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
        transition: border-color 0.3s ease;
    }

    .goals-card.completed {
        border-color: #4caf50;
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

    .goals-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
        line-height: 36px;
    }

    .goals-card-content h2 {
        margin: 0;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-family: "Varela Round", sans-serif;
        font-size: 14px;
        font-weight: bold;
        white-space: nowrap;
    }

    .status-badge.completed {
        background-color: #4caf50;
        color: white;
    }

    .status-badge.in-progress {
        background-color: #f0f0f0;
        color: #666;
        border: 1px solid #ddd;
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
        background-color: #eeeeee;
        border: 2px solid #cccccc;
        border-radius: 10px;
        font-family: "Varela Round", sans-serif;
        font-size: 20px;
        font-weight: 600;
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

    .progress-bar.completed {
        background-color: #2e7d32;
    }
</style>