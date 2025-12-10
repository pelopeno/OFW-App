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
        <div class="kebab-menu">
            <button class="kebab-btn" onclick="toggleKebabMenu(event)">
                <img src="/assets/kebab.png">
            </button>
            <div class="kebab-dropdown" style="display: none;">
                <button class="kebab-option delete-option" onclick="deleteGoal({{ $goal->id }}, '{{ $goal->name }}')">
                    Delete Goal
                </button>
            </div>
        </div>
    </div>
</div>

<form id="deleteGoalForm-{{ $goal->id }}" action="{{ route('delete-goal', $goal->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .goals-card {
        display: flex;
        flex-direction: row;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        margin-bottom: 15px;
        transition: border-color 0.3s ease;
        position: relative;
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
        padding: 8px 0;
        transition: all 0.3s ease;
    }

    .goals-card-button a:hover {
        background-color: #d4d4d4;
        transform: translateY(-2px);
    }

    .goals-card-kebab {
        width: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .kebab-menu {
        position: relative;
    }

    .kebab-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .kebab-btn:hover {
        transform: scale(1.1);
    }

    .kebab-btn img {
        height: 25px;
        width: auto;
        transform: rotate(90deg);
    }

    .kebab-dropdown {
        position: absolute;
        top: 100%;
        right: -10px;
        background: white;
        border: 2px solid #282828;
        border-radius: 10px;
        min-width: 150px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        margin-top: 5px;
    }

    .kebab-option {
        display: block;
        width: 100%;
        padding: 12px 16px;
        border: none;
        background: none;
        text-align: left;
        cursor: pointer;
        font-family: "Varela Round", sans-serif;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .kebab-option:first-child {
        border-radius: 8px 8px 0 0;
    }

    .kebab-option:last-child {
        border-radius: 0 0 8px 8px;
    }

    .kebab-option:hover {
        background-color: #f5f5f5;
    }

    .kebab-option.delete-option {
        color: #d32f2f;
    }

    .kebab-option.delete-option:hover {
        background-color: #ffebee;
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

<script>
    function toggleKebabMenu(event) {
        event.preventDefault();
        const dropdown = event.target.closest('.kebab-btn').nextElementSibling;
        const isVisible = dropdown.style.display !== 'none';
        
        // Close all other dropdowns
        document.querySelectorAll('.kebab-dropdown').forEach(menu => {
            menu.style.display = 'none';
        });
        
        // Toggle current dropdown
        dropdown.style.display = isVisible ? 'none' : 'block';
    }

    function deleteGoal(goalId, goalName) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete Goal?',
            text: `Are you sure you want to delete "${goalName}"? This action cannot be undone.`,
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteGoalForm-${goalId}`).submit();
            }
        });
    }

    // Close kebab menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.kebab-menu')) {
            document.querySelectorAll('.kebab-dropdown').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
</script>