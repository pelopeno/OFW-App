<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Funds</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body" style="overflow: auto; height: auto;">
    <x-navbar-ofw />

    <div class="add-goal-main">
        <div class="add-goal-header" style="height: auto;">
            <h2 style="line-height: 32px;">Withdraw Funds from: {{ $goal->name }}</h2>
        </div>
        <form class="goal-form" method="POST" action="{{ route('withdraw-funds.post', $goal->id) }}">
            @csrf
            <label class="input-label">Amount to Withdraw</label>
            <input type="number" name="amount" placeholder="Enter amount (₱)" class="goal-allocated-input" min="1" step="0.01" required />
            <small class="goal-allocated-desc">The entered value will be returned back to your wallet balance. Available: ₱{{ number_format($goal->current_amount, 2) }}</small>

            <button type="submit" class="withdraw-goal-btn">Withdraw</button>
        </form>
    </div>
</body>

</html>