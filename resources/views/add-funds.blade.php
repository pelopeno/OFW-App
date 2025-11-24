<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Funds</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body" style="overflow: auto; height: auto;">
    <x-navbar-ofw />

    <div class="add-goal-main">
        <div class="add-goal-header" style="height: auto;">
            <h2 style="line-height: 32px;">Add Funds</h2>
        </div>
        <form class="add-funds-form">
            <label class="input-label">Amount to Add</label>
            <input type="number" placeholder="Enter amount (₱)" class="add-funds-input" />
            <small class="add-funds-desc">The entered value will be added to your wallet balance. This cannot be undone.</small>

            <button type="submit" class="add-funds-btn">Add</p>
        </form>
    </div>
</body>