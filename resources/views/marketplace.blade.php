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

            <!-- Pagination -->
            @if ($projects->hasPages())
            <div style="margin-top: 20px;">
                <div class="pagination-wrapper">
                    <nav class="pagination-nav select-none">

                        {{-- Previous Button --}}
                        @if ($projects->onFirstPage())
                            <span class="pg-btn disabled">‹</span>
                        @else
                            <a href="{{ $projects->previousPageUrl() }}" class="pg-btn active">‹</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                            @if ($page == $projects->currentPage())
                                <span class="pg-page current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($projects->hasMorePages())
                            <a href="{{ $projects->nextPageUrl() }}" class="pg-btn active">›</a>
                        @else
                            <span class="pg-btn disabled">›</span>
                        @endif

                    </nav>
                </div>
            </div>
            @endif
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

    <style>
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 25px;
        margin-bottom: 20px;
    }
    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Varela Round', sans-serif;
    }
    .pg-btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 16px;
        background: #e6e6e6;
        color: #9e9e9e;
        cursor: not-allowed;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: 0.2s ease;
    }
    .pg-btn.active {
        background: #A68749;
        color: white;
        cursor: pointer;
    }
    .pg-btn.active:hover {
        background: #A68749;
        transform: translateY(-2px);
    }
    .pg-page {
        padding: 8px 14px;
        font-size: 16px;
        background: #f7f7f7;
        color: #555;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: 0.2s ease;
    }
    .pg-page:hover {
        background: #e6e6e6;
        transform: translateY(-2px);
    }
    .pg-page.current {
        background: #A68749;
        color: white;
        font-weight: bold;
        cursor: default;
        transform: scale(1.05);
    }
    </style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.querySelector(".project-view-main");
    const projectLinks = document.querySelectorAll(".market-ofw-content-cont a.project-link");
    const donateModal = document.getElementById('donateModal');
    const successToast = document.getElementById('successToast');
    const errorToast = document.getElementById('errorToast');

    if (overlay) overlay.style.display = "none";

    projectLinks.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const projectId = link.getAttribute("data-project-id");
            const url = link.getAttribute("href");
            window.loadProjectData(projectId);
            if (overlay) overlay.style.display = "flex";
            window.history.pushState({ overlay: true }, "", url);
        });
    });

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

    donateModal.addEventListener('click', (e) => {
        if (e.target === donateModal) {
            donateModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    });

    @if(session('success'))
        successToast.querySelector('#successMessage').textContent = '{{ session('success') }}';
        successToast.classList.add('show');
        setTimeout(() => { successToast.classList.remove('show'); }, 3000);
    @endif

    @if($errors->any())
        errorToast.querySelector('#errorMessage').textContent = '{{ $errors->first() }}';
        errorToast.classList.add('show');
        donateModal.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => { errorToast.classList.remove('show'); }, 5000);
    @endif
});
</script>

</body>
</html>
