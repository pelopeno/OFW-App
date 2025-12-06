<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <div id="project-overlay">
        @include('project')
    </div>
    <x-navbar-ofw/>

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <!-- Error Message Toast -->
    <div id="errorToast" class="error-toast">
        <span id="errorMessage"></span>
    </div>

    <div class="market-ofw-main">
        <div class="market-ofw-content-cont">
            <h2>Marketplace</h2>

            @forelse($projects as $project)
                <a href="/project/{{ $project->id }}" class="project-link" data-project-id="{{ $project->id }}">
                    <x-business-project-card 
                        project_name="{{ $project->title }}" 
                        project_current_raised_amt="{{ $project->current_amount }}"
                        project_target_raised_amt="{{ $project->target_amount }}"
                        project_author="{{ $project->user->name }}" />
                </a>
            @empty
                <div style="text-align: center; padding: 50px; color: #737373; font-family: 'Varela Round', sans-serif;">
                    <p style="font-size: 18px;">No projects available at the moment.</p>
                    <p>Check back soon for new opportunities!</p>
                </div>
            @endforelse
        </div>

        <div class="market-ofw-img-cont">
            <img src="/assets/mp-ofw-img.png"/>
        </div>
    </div>

    <!-- Donate Modal -->
    <div id="donateModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="closeDonateModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-goal-header">
                <h2 id="donateProjectTitle">Invest to Project</h2>
            </div>
            <form class="donate-form" id="donateForm" method="POST">
                @csrf
                <label class="input-label">Amount to Invest</label>
                <input type="number" name="amount" placeholder="Enter amount (₱)" class="donate-input" min="1" step="0.01" required />
                <small class="donate-desc">The entered value will be deducted from your wallet balance.</small>

                <button type="submit" class="withdraw-goal-btn">Invest</button>
            </form>
        </div>
    </div>
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.querySelector(".project-view-main");
    const projectLinks = document.querySelectorAll(".market-ofw-content-cont a.project-link");
    const donateModal = document.getElementById('donateModal');
    const successToast = document.getElementById('successToast');
    const errorToast = document.getElementById('errorToast');

    if (overlay) overlay.style.display = "none";

    // When project is clicked
    projectLinks.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const projectId = link.getAttribute("data-project-id");
            const url = link.getAttribute("href");

            // Load project data and show overlay
            window.loadProjectData(projectId);
            if (overlay) overlay.style.display = "flex";
            
            // Update URL
            window.history.pushState({ overlay: true }, "", url);
        });
    });

    // Donate Modal Functionality
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

    // Close modal on outside click
    donateModal.addEventListener('click', (e) => {
        if (e.target === donateModal) {
            donateModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    });

    // Show success message if exists
    @if(session('success'))
        successToast.querySelector('#successMessage').textContent = '{{ session('success') }}';
        successToast.classList.add('show');
        setTimeout(() => {
            successToast.classList.remove('show');
        }, 3000);
    @endif

    // Show error message if exists
    @if($errors->any())
        errorToast.querySelector('#errorMessage').textContent = '{{ $errors->first() }}';
        errorToast.classList.add('show');
        donateModal.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            errorToast.classList.remove('show');
        }, 5000);
    @endif
});
</script>

</html>