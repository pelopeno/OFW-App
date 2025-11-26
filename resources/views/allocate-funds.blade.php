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
            <h2 style="line-height: 32px;">Allocate Funds to: {{ $goal->name }}</h2>
        </div>
        <form class="goal-form" method="POST" action="{{ route('allocate-funds.post', $goal->id) }}">
            @csrf
            

            @if ($errors->any())
                <div class="alert alert-danger" style="background-color: #f44336; color: white; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label class="input-label">Wallet Balance</label>
            <div style="background-color: #f0f0f0; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-family: 'Varela Round', sans-serif; font-size: 18px; font-weight: 600; color: #282828;">
                ₱{{ number_format($wallet->balance, 2) }}
            </div>

            <label class="input-label">Amount to Allocate</label>
            <input 
                type="number" 
                name="amount" 
                placeholder="Enter amount (₱)" 
                class="goal-allocated-input" 
                min="0.01" 
                max="{{ $wallet->balance }}"

                step="0.01" 
                required />
            <small class="goal-allocated-desc">Maximum available: ₱{{ number_format($wallet->balance, 2) }}</small>

            <button type="submit" class="allocate-goal-btn">Allocate Funds</button>
        </form>
    </div>
</body>

</html>
