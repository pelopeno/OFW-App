<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Saving Goals - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <x-navbar-ofw/>

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <!-- Error Message Toast -->
    <div id="errorToast" class="error-toast">
        <span id="errorMessage"></span>
    </div>

    <div class="goals-ofw-main">
        <div class="goals-ofw-content-cont">
            <h2>Saving Goals</h2>
            <a href="#" id="addGoalBtn">
                <div class="ofw-add-goal-btn">
                    <img src="/assets/plus.png">
                </div>
            </a>
            
            @forelse($goals as $goal)
                <x-saving-goals-card :goal="$goal"/>
            @empty
                <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No saving goals yet. Create your first goal!</p>
            @endforelse
        </div>

        <div class="goals-ofw-img-cont">
            <img src="/assets/sg-ofw-img.png"/>
        </div>
    </div>

    <!-- Add Goal Modal -->
    <div id="addGoalModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeAddGoalModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2>Create Goal</h2>
            </div>
            <form class="goal-form" method="POST" action="{{ route('store-goal') }}">
                @csrf
                <label class="input-label">Name</label>
                <input type="text" name="name" placeholder="e.g. Travel Savings" class="goal-title-input" value="{{ old('name') }}" required />
                @error('name')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <label class="input-label">Target Saving Amount</label>
                <input type="number" name="target_amount" placeholder="Enter amount (₱)" class="goal-target-input" value="{{ old('target_amount') }}" required />
                @error('target_amount')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <label class="input-label">Initial Investment</label>
                <input type="number" name="current_amount" placeholder="Enter amount (₱)" class="goal-target-input" value="{{ old('current_amount') }}" />
                <small class="goal-target-desc">The entered value will be deducted from your wallet balance.</small>
                @error('current_amount')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <button type="submit" class="create-goal-btn">Create</button>
            </form>
        </div>
    </div>

    <!-- Allocate Funds Modal -->
    <div id="allocateFundsModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeAllocateFundsModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2 id="allocateGoalName">Allocate Funds</h2>
            </div>
            <form class="goal-form" id="allocateFundsForm" method="POST">
                @csrf
                <label class="input-label">Amount to Allocate</label>
                <input type="number" name="amount" placeholder="Enter amount (₱)" class="goal-allocated-input" min="0.01" step="0.01" required />
                <small class="goal-allocated-desc">The entered value will be deducted from your wallet balance.</small>

                <button type="submit" class="allocate-goal-btn">Allocate</button>
            </form>
        </div>
    </div>

    <!-- Withdraw Funds Modal -->
    <div id="withdrawFundsModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeWithdrawFundsModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2 id="withdrawGoalName">Withdraw Funds</h2>
            </div>
            <form class="goal-form" id="withdrawFundsForm" method="POST">
                @csrf
                <label class="input-label">Amount to Withdraw</label>
                <input type="number" name="amount" placeholder="Enter amount (₱)" class="goal-allocated-input" min="0.01" step="0.01" required />
                <small class="goal-allocated-desc" id="withdrawAvailable">Available: ₱0.00</small>

                <button type="submit" class="withdraw-goal-btn">Withdraw</button>
            </form>
        </div>
    </div>

    <style>
        .error-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            border: 2px solid #f5c6cb;
            font-family: "Varela Round", sans-serif;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 10000;
            max-width: 400px;
        }

        .error-toast.show {
            transform: translateX(0);
        }

        .error-text {
            display: block;
            color: #721c24;
            font-family: "Varela Round", sans-serif;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal elements
            const addGoalModal = document.getElementById('addGoalModal');
            const allocateFundsModal = document.getElementById('allocateFundsModal');
            const withdrawFundsModal = document.getElementById('withdrawFundsModal');
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');

            // Add Goal Modal
            document.getElementById('addGoalBtn').addEventListener('click', (e) => {
                e.preventDefault();
                addGoalModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            document.getElementById('closeAddGoalModal').addEventListener('click', () => {
                addGoalModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Allocate Funds Modal
            document.querySelectorAll('.allocate-funds-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const goalId = btn.dataset.goalId;
                    const goalName = btn.dataset.goalName;
                    document.getElementById('allocateGoalName').textContent = `Allocate Funds to: ${goalName}`;
                    document.getElementById('allocateFundsForm').action = `/goals/${goalId}/allocateFunds`;
                    allocateFundsModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            });

            document.getElementById('closeAllocateFundsModal').addEventListener('click', () => {
                allocateFundsModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Withdraw Funds Modal
            document.querySelectorAll('.withdraw-funds-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const goalId = btn.dataset.goalId;
                    const goalName = btn.dataset.goalName;
                    const currentAmount = btn.dataset.currentAmount;
                    document.getElementById('withdrawGoalName').textContent = `Withdraw Funds from: ${goalName}`;
                    document.getElementById('withdrawAvailable').textContent = `Available: ₱${parseFloat(currentAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    document.getElementById('withdrawFundsForm').action = `/goals/${goalId}/withdrawFunds`;
                    withdrawFundsModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            });

            document.getElementById('closeWithdrawFundsModal').addEventListener('click', () => {
                withdrawFundsModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Close modals on outside click
            [addGoalModal, allocateFundsModal, withdrawFundsModal].forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            // Show success message if exists
            @if(session('success'))
                successToast.querySelector('#successMessage').textContent = '{{ session('success') }}';
                successToast.classList.add('show');
                setTimeout(() => {
                    successToast.classList.remove('show');
                }, 5000);
            @endif

            // Show error messages if exist
            @if($errors->any())
                const errorMessages = [
                    @foreach($errors->all() as $error)
                        '{{ $error }}',
                    @endforeach
                ];
                errorToast.querySelector('#errorMessage').textContent = errorMessages.join(' ');
                errorToast.classList.add('show');
                setTimeout(() => {
                    errorToast.classList.remove('show');
                }, 5000);

                // Reopen the modal if there were errors in form submission
                @if(old('name') || old('target_amount') || old('current_amount'))
                    addGoalModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                @endif
            @endif
        });
    </script>

</body>

</html>