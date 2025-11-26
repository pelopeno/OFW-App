<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <x-navbar-ofw />

    <div class="dashboard-ofw-main">
        <h2>Dashboard</h2>
        <div class="dashboard-ofw-wallet-goals-cont">
            <div class="dashboard-ofw-wallet-card">
                <img src="/assets/db-ofw-wallet-card.png" />
                <div class="dashboard-ofw-wallet-card-content">
                    <h3>Wallet Balance</h3>
                    <h4>P{{ number_format(auth()->user()->wallet->balance, 2) }}</h4>
                    <a href="{{ route('add-funds') }}">Add Funds</a>
                    <a href="{{route('withdraw-wallet')}}">Withdraw Funds</a>
                </div>
            </div>

            <div class="dashboard-ofw-goals-card">
                <a href="{{ route('saving-goals') }}" class="dashboard-card-anchor">
                    <img src="/assets/db-ofw-goals-card.png" />
                    <div class="dashboard-ofw-cards-arrow">
                        <img src="/assets/arrow.png" />
                    </div>
                    <div class="dashboard-ofw-goals-card-content">
                        <h3>Saving Goals</h3>
                        @if($latestGoal)
                        <h4>{{ $latestGoal->name }}</h4>
                        <h5>₱{{ number_format($latestGoal->current_amount, 2) }} of ₱{{ number_format($latestGoal->target_amount, 2) }}</h5>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $latestGoal->target_amount > 0 ? ($latestGoal->current_amount / $latestGoal->target_amount) * 100 : 0 }}%"></div>
                        </div>
                        @else
                        <h4>No goals yet</h4>
                        <h5>Create your first saving goal!</h5>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <div class="dashboard-ofw-investments-marketplace-cont">
            <div class="dashboard-ofw-investments-card">
                <a href="{{ route('investment-history') }}" class="dashboard-card-anchor">
                    <img src="/assets/db-ofw-investments-card.png" />
                    <div class="dashboard-ofw-cards-arrow">
                        <img src="/assets/arrow.png" />
                    </div>
                    <div class="dashboard-ofw-investments-card-content">
                        <h3>Recent Investments</h3>
                        <h4>Small Cafe Startup</h4>
                        <h5>₱15,000 Allocated</h5>
                    </div>
                </a>
            </div>

            <div class="dashboard-ofw-marketplace-card">
                <a href="{{ route('marketplace') }}" class="dashboard-card-anchor">
                    <img src="/assets/db-ofw-marketplace-card.png" />
                    <div class="dashboard-ofw-cards-arrow">
                        <img src="/assets/arrow.png" />
                    </div>
                    <div class="dashboard-ofw-marketplace-card-content">
                        <h3>Marketplace</h3>
                        @if($projects)
                        <h4>NEW: {{ $projects->title }}</h4>
                        <h5>Project by {{ $projects->user->name }}</h5>
                        @else
                        <h4>No projects available</h4>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>