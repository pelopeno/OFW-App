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
                    <h4>P50,000</h4>
                    <button>Add Funds</button>
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
                        <h4>House Renovation</h4>
                        <h5>₱50,000 of ₱100,000</h5>
                        <div class="progress-container">
                            <div class="progress-bar"></div>
                        </div>
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
                        <h4>NEW: Makati Branch</h4>
                        <h5>Project by Seeds and Scholars</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>