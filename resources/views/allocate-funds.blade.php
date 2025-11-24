<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Funds</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body" style="overflow: auto; height: auto;">
    <x-navbar-ofw />

    <div class="add-goal-main">
        <div class="add-goal-header" style="height: auto;">
            <h2 style="line-height: 32px;">
                Allocate Funds to: {{ $goal->title ?? $goal->name }}
            </h2>
        </div>

        {{-- Error message --}}
        @if ($errors->any())
            <div class="error-message">{{ $errors->first() }}</div>
        @endif

        <form class="goal-form" method="POST" action="{{ route('allocate-funds.post', $goal->id) }}">
            @csrf

            <label class="input-label">Amount to Allocate</label>

            <input 
                type="number"
                name="amount"
                placeholder="Enter amount (₱)" 
                class="goal-allocated-input"
                min="1"
                required
            />

            <small class="goal-allocated-desc">
                The entered value will be deducted from your wallet balance.
            </small>

            <button type="submit" class="allocate-goal-btn">Allocate</button>
        </form>
    </div>
</body>

</html>
