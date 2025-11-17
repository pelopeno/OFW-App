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

    <div class="market-ofw-main">
        <div class="market-ofw-content-cont">
            <h2>Marketplace</h2>

            <a href="/project/1">
                    <x-business-project-card 
                        project_name="Café Kabayan Expansion" 
                        project_author="Café Kabayan" />
                </a>
                <a href="/project/2">
                    <x-business-project-card 
                        project_name="Dapitan Branch" 
                        project_author="Café Kabayan" />
                </a>
                <a href="/project/3">
                    <x-business-project-card 
                        project_name="Makati Branch" 
                        project_author="Seeds and Scholars" />
                </a>
        </div>

        <div class="market-ofw-img-cont">
            <img src="/assets/mp-ofw-img.png"/>
        </div>
    </div>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Overlay logic with History API
    const overlay = document.querySelector(".project-view-main");
    const projectLinks = document.querySelectorAll(".market-ofw-content-cont a");
    const closeBtn = document.querySelector(".project-view-x-btn");
    

    if (overlay) overlay.style.display = "none";

    // When project is clicked
    projectLinks.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const url = link.getAttribute("href");

            // Show overlay
            if (overlay) overlay.style.display = "flex";

            // Update URL without reload
            window.history.pushState({overlay: true}, "", url);
        });
    });

    // Close overlay
    if (closeBtn) {
        closeBtn.addEventListener("click", e => {
    e.preventDefault();
    if (overlay) overlay.style.display = "none";
    window.history.pushState({}, "", "/marketplace"); // Changed from "/business"
});
    }

    // On page load: show overlay if directly at /project/{id}
    if (window.location.pathname.startsWith("/project/")) {
        if (overlay) overlay.style.display = "flex";
    }

    // Handle browser back/forward
    window.addEventListener("popstate", () => {
    if (window.location.pathname.startsWith("/project/")) {
        if (overlay) overlay.style.display = "flex";
    } else if (window.location.pathname === "/marketplace") { 
        if (overlay) overlay.style.display = "none";
    }
});
});
</script>
