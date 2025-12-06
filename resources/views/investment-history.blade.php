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
    <x-navbar-ofw/>

    <div class="invh-ofw-main">
        <div class="invh-ofw-content-cont">
            <h2>Investment History</h2>

            @forelse($investments as $investment)
            <a href="/project/{{ $investment->project->id }}" style="text-decoration: none; color: inherit;">
                <x-investment-card 
                    project_name="{{ $investment->project->title }}" 
                    invested_amt="{{ $investment->amount }}"/>
            </a>
            @empty
            <div style="text-align: center; padding: 50px; color: #737373; font-family: 'Varela Round', sans-serif;">
                <p style="font-size: 18px;">You haven't made any investments yet.</p>
                <p>Explore the marketplace to find projects to invest in!</p>
            </div>
            @endforelse
        </div>

        <div class="invh-ofw-img-cont">
            <img src="/assets/ih-ofw-img.png"/>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const overlay = document.querySelector(".project-view-main");
        const investmentLinks = document.querySelectorAll(".invh-ofw-content-cont a");
        const closeBtn = document.querySelector(".project-view-x-btn");

        if (overlay) overlay.style.display = "none";

        // When investment card is clicked
        investmentLinks.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                const url = link.getAttribute("href");

                // Show overlay
                if (overlay) overlay.style.display = "flex";

                // Update URL without reloading
                window.history.pushState({overlay: true}, "", url);
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
            if (overlay) overlay.style.display = "flex";
        }

        // Handle back/forward navigation
        window.addEventListener("popstate", () => {
            if (window.location.pathname.startsWith("/project/")) {
                if (overlay) overlay.style.display = "flex";
            } else {
                if (overlay) overlay.style.display = "none";
            }
        });
    });
    </script>

</body>
</html>
