<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <x-navbar-ofw />

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <!-- Error Message Toast -->
    <div id="errorToast" class="error-toast">
        <span id="errorMessage"></span>
    </div>

    <div class="dashboard-ofw-main">
        <h2>Dashboard</h2>
        <div class="dashboard-ofw-wallet-goals-cont">
            <div class="dashboard-ofw-wallet-card">
                <img src="/assets/db-ofw-wallet-card.png" />
                <div class="dashboard-ofw-wallet-card-content">
                    <h3>Wallet Balance</h3>
                    <h4>P{{ number_format(auth()->user()->wallet->balance, 2) }}</h4>
                    <a href="#" id="addFundsBtn" style="margin-top: 12px;">Add Funds</a>
                    <a href="#" id="withdrawWalletBtn">Withdraw Funds</a>
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
                        @if($latestInvestment)
                        <h3>Recent Investments</h3>
                        <h4>{{ $latestInvestment->project_title ?? 'Deleted Project' }}</h4>
                        <h5>₱{{ number_format($latestInvestment->amount, 2) }} Allocated</h5>
                        @else
                        <h3>No Investments Yet</h3>
                        <h4>Start investing in projects today!</h4>
                        @endif
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

    <!-- Add Funds Modal -->
    <div id="addFundsModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeAddFundsModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2>Add Funds to Wallet</h2>
            </div>
            <form class="add-funds-form" method="POST" action="{{ route('wallet.add-funds') }}">
                @csrf
                <label class="input-label">Amount to Add</label>
                <input type="number" name="amount" placeholder="Enter amount (₱)" class="add-funds-input" min="0.01" step="0.01" required />
                <small class="add-funds-desc">Enter the amount you want to add to your wallet.</small>

                <button type="submit" class="add-funds-btn">Add Funds</button>
            </form>
        </div>
    </div>

    <!-- Withdraw Wallet Modal -->
    <div id="withdrawWalletModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeWithdrawWalletModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2>Withdraw Funds from Wallet</h2>
            </div>
            <form class="add-funds-form" method="POST" action="{{ route('wallet.withdraw-funds') }}">
                @csrf

                <label class="input-label">Available Balance</label>
                <div style="background-color: #f0f0f0; padding: 15px; border-radius: 10px; font-family: 'Varela Round', sans-serif; font-size: 18px; font-weight: 600; color: #282828;">
                    ₱{{ number_format(auth()->user()->wallet->balance, 2) }}
                </div>

                <label class="input-label">Amount to Withdraw</label>
                <input 
                    type="number" 
                    name="amount" 
                    placeholder="Enter amount (₱)" 
                    class="add-funds-input" 
                    min="0.01" 
                    max="{{ auth()->user()->wallet->balance }}"
                    step="0.01" 
                    required />
                <label class="input-label">Enter Password to Confirm</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Enter your password"
                    class="goal-allocated-input"
                    required />
                <small class="goal-allocated-desc">For your security, please confirm your password.</small>
                <button type="submit" class="add-funds-btn">Withdraw</button>
            </form>
        </div>
    </div>

    <!-- Donate Modal -->
    <div id="donateModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeDonateModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2 id="donateProjectTitle">Donate to Project</h2>
            </div>
            <form class="donate-form" id="donateForm" method="POST">
                @csrf
                <label class="input-label">Amount to Donate</label>
                <input type="number" name="amount" placeholder="Enter amount (₱)" class="donate-input" min="1" step="0.01" required />
                <small class="donate-desc">The entered value will be deducted from your wallet balance.</small>

                <button type="submit" class="withdraw-goal-btn">Donate</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addFundsModal = document.getElementById('addFundsModal');
            const withdrawWalletModal = document.getElementById('withdrawWalletModal');
            const donateModal = document.getElementById('donateModal');
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');

            // Add Funds Modal
            document.getElementById('addFundsBtn').addEventListener('click', (e) => {
                e.preventDefault();
                addFundsModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            document.getElementById('closeAddFundsModal').addEventListener('click', () => {
                addFundsModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Withdraw Wallet Modal
            document.getElementById('withdrawWalletBtn').addEventListener('click', (e) => {
                e.preventDefault();
                withdrawWalletModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            document.getElementById('closeWithdrawWalletModal').addEventListener('click', () => {
                withdrawWalletModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Donate Modal
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'openDonateModal') {
                    e.preventDefault();
                    const projectId = e.target.getAttribute('data-project-id');
                    const projectTitle = e.target.getAttribute('data-project-title');
                    
                    document.getElementById('donateProjectTitle').textContent = `Donate to: ${projectTitle}`;
                    document.getElementById('donateForm').action = `/project/${projectId}/donate`;
                    
                    donateModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            });

            document.getElementById('closeDonateModal').addEventListener('click', () => {
                donateModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Close modals on outside click
            [addFundsModal, withdrawWalletModal, donateModal].forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successToast = document.querySelector('.success-toast');
            successToast.querySelector('#successMessage').textContent = '{{ session('success') }}';
            successToast.classList.add('show');
            setTimeout(() => {
                successToast.classList.remove('show');
            }, 3000);
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorToast = document.querySelector('.error-toast');
            const withdrawWalletModal = document.getElementById('withdrawWalletModal');
            errorToast.querySelector('#errorMessage').textContent = '{{ $errors->first() }}';
            errorToast.classList.add('show');
            withdrawWalletModal.classList.add('show');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                errorToast.classList.remove('show');
            }, 5000);
        });
    </script>
    @endif
</body>

</html>