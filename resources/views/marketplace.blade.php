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
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Overlay logic with History API and AJAX
    const overlay = document.querySelector(".project-view-main");
    const projectLinks = document.querySelectorAll(".market-ofw-content-cont a.project-link");
    const closeBtn = document.querySelector(".project-view-x-btn");

    if (overlay) overlay.style.display = "none";

    // Function to load project dynamically
    function loadProjectPreview(projectId) {
        fetch(`/project/${projectId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            window.loadProject(projectId);
        })
        .catch(error => {
            console.error('Error loading project:', error);
        });
    }

    // When project is clicked
    projectLinks.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const projectId = link.getAttribute("data-project-id");
            const url = link.getAttribute("href");

            // Show overlay
            if (overlay) overlay.style.display = "flex";

            // Load project data
            loadProjectPreview(projectId);

            // Update URL without reload
            window.history.pushState({overlay: true, projectId}, "", url);
        });
    });

    // Close overlay
    if (closeBtn) {
        closeBtn.addEventListener("click", e => {
            e.preventDefault();
            if (overlay) overlay.style.display = "none";
            window.history.pushState({}, "", "/marketplace");
        });
    }

    // Close overlay when clicking outside
    if (overlay) {
        overlay.addEventListener("click", function(e) {
            if (e.target === overlay) {
                overlay.style.display = "none";
                window.history.pushState({}, "", "/marketplace");
            }
        });
    }

    // On page load: show overlay if directly at /project/{id}
    if (window.location.pathname.startsWith("/project/")) {
        const projectId = window.location.pathname.split('/').pop();
        if (overlay) {
            overlay.style.display = "flex";
            loadProjectPreview(projectId);
        }
    }

    // Handle browser back/forward
    window.addEventListener("popstate", (event) => {
        if (window.location.pathname.startsWith("/project/")) {
            const projectId = window.location.pathname.split('/').pop();
            if (overlay) {
                overlay.style.display = "flex";
                loadProjectPreview(projectId);
            }
        } else if (window.location.pathname === "/marketplace") {
            if (overlay) overlay.style.display = "none";
        }
    });
});
</script>

</html>