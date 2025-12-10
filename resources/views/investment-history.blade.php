@php
$isInvestmentPage = true;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <div id="project-overlay">
        @include('project')
    </div>
    <x-navbar-ofw />

    <div class="invh-ofw-main">
        <div class="invh-ofw-content-cont">
            <h2>Investment History</h2>

            @forelse($investments as $investment)
            @if($investment->project)
            <a href="/project/{{ $investment->project->id }}"
                style="text-decoration: none; color: inherit;"
                data-project-id="{{ $investment->project->id }}">
                <x-investment-card
                    image="{{ $investment->project->image ? asset('storage/'.$investment->project->image) : '/assets/default-project-pic.png' }}"
                    project_name="{{ $investment->project->title }}"
                    invested_amt="{{ $investment->amount }}" />
            </a>
            @else
            <div style="padding: 20px; background: #fff3cd; border: 2px solid #ffc107; border-radius: 10px; margin-bottom: 15px;">
                <p style="font-family: 'Varela Round', sans-serif; color: #856404;">
                    Project no longer available
                </p>
            </div>
            @endif
            @empty
            <div style="text-align: center; padding: 50px; color: #737373; font-family: 'Varela Round', sans-serif;">
                <p style="font-size: 18px;">You haven't made any investments yet.</p>
                <p>Explore the marketplace to find projects to invest in!</p>
            </div>
            @endforelse
        </div>
        <!-- Pagination -->
@if ($investments->hasPages())
    <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
        <nav class="pagination-nav select-none">
            {{-- Previous --}}
            @if ($investments->onFirstPage())
                <span class="pg-btn disabled">‹</span>
            @else
                <a href="{{ $investments->previousPageUrl() }}" class="pg-btn active">‹</a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($investments->getUrlRange(1, $investments->lastPage()) as $page => $url)
                @if ($page == $investments->currentPage())
                    <span class="pg-page current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($investments->hasMorePages())
                <a href="{{ $investments->nextPageUrl() }}" class="pg-btn active">›</a>
            @else
                <span class="pg-btn disabled">›</span>
            @endif
        </nav>
    </div>
@endif
<style>
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

.pg-page.current {
    background: #A68749;
    color: white;
    font-weight: bold;
    cursor: default;
    transform: scale(1.05);
}
</style>

        <div class="invh-ofw-img-cont">
            <img src="/assets/ih-ofw-img.png" />
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.querySelector(".project-view-main");
            const investmentLinks = document.querySelectorAll(".invh-ofw-content-cont a[data-project-id]");
            const closeBtn = document.querySelector(".project-view-x-btn");

            console.log('Investment page loaded');
            console.log('Overlay found:', !!overlay);
            console.log('Investment links found:', investmentLinks.length);
            console.log('loadProjectData available:', typeof window.loadProjectData);

            // Debug: Log each link
            investmentLinks.forEach((link, index) => {
                console.log(`Link ${index}:`, {
                    href: link.getAttribute('href'),
                    dataProjectId: link.getAttribute('data-project-id'),
                    html: link.outerHTML.substring(0, 200)
                });
            });

            if (overlay) overlay.style.display = "none";

            // When investment card is clicked
            investmentLinks.forEach(link => {
                link.addEventListener("click", e => {
                    e.preventDefault();

                    console.log('Investment card clicked!');

                    // Get project ID from data attribute
                    const projectId = link.getAttribute("data-project-id");
                    console.log('Project ID:', projectId);

                    // Load project data
                    if (typeof window.loadProjectData === 'function' && projectId) {
                        console.log('Loading project data...');
                        window.loadProjectData(projectId);

                        // Show overlay
                        if (overlay) {
                            console.log('Showing overlay');
                            overlay.style.display = "flex";
                        } else {
                            console.error('Overlay element not found!');
                        }

                        // Update URL without reloading
                        window.history.pushState({
                            overlay: true
                        }, "", `/project/${projectId}`);
                    } else {
                        console.error('Cannot load project:', {
                            hasLoadFunction: typeof window.loadProjectData === 'function',
                            projectId: projectId
                        });
                    }
                });
            });

            // Close overlay
            if (closeBtn) {
                closeBtn.addEventListener("click", e => {
                    e.preventDefault();
                    if (overlay) overlay.style.display = "none";
                    window.history.pushState({}, "", "/investment-history");
                });
            }

            // Show overlay if already on /project/{id}
            if (window.location.pathname.startsWith("/project/")) {
                const projectId = window.location.pathname.split("/").pop();

                if (typeof window.loadProjectData === 'function' && projectId) {
                    window.loadProjectData(projectId);
                    if (overlay) overlay.style.display = "flex";
                }
            }

            // Handle back/forward navigation
            window.addEventListener("popstate", () => {
                if (window.location.pathname.startsWith("/project/")) {
                    const projectId = window.location.pathname.split("/").pop();

                    if (typeof window.loadProjectData === 'function' && projectId) {
                        window.loadProjectData(projectId);
                        if (overlay) overlay.style.display = "flex";
                    }
                } else {
                    if (overlay) overlay.style.display = "none";
                }
            });
        });
    </script>

</body>

</html>