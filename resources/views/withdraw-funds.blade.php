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
            <h2 style="line-height: 32px;">Withdraw Funds from: [GoalNameHere]</h2>
        </div>
        <form class="goal-form">
            <label class="input-label">Amount to Withdraw</label>
            <input type="number" placeholder="Enter amount (₱)" class="goal-allocated-input" />
            <small class="goal-allocated-desc">The entered value will be returned back to your wallet balance.</small>

            <button type="submit" class="withdraw-goal-btn">Withdraw</p>
        </form>
    </div>
</body>