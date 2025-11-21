<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Goal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body" style="overflow: auto; height: auto;">
    <x-navbar-ofw />

    <div class="add-goal-main">
        <div class="add-goal-header">
            <h2>Create Goal</h2>
        </div>
        <form class="goal-form">
            <label class="input-label">Name</label>
            <input type="text" placeholder="e.g. Travel Savings" class="goal-title-input" />

            <label class="input-label">Target Saving Amount</label>
            <input type="number" placeholder="Enter amount (₱)" class="goal-target-input" />

            <label class="input-label">Initial Investment</label>
            <input type="number" placeholder="Enter amount (₱)" class="goal-target-input" />
            <small class="goal-target-desc">The entered value will be deducted to your wallet balance.</small>

            <button type="submit" class="create-goal-btn">Create</p>
        </form>
    </div>
</body>