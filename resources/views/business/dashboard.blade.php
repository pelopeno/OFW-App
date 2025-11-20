<!--BUSINESS DASHBOARD-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Business Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bus-body">
    <div>
        @include('project')
    </div>
    <x-navbar-business />

    <div class="bus-main">
        <div class="bus-profile-card-cont">
            <x-business-profile-card 
                business_name="Café Kabayan" 
                business_description="Café Kabayan is a neighborhood café that serves traditional Filipino comfort food and specialty coffee. Our mission is to promote Filipino flavors while creating a cozy space for students and young professionals. We plan to expand our seating area and introduce delivery services to cater to a wider audience." />
        </div>

        <div class="bus-posts-cont">
            <div class="bus-tabs">
                <a href="" style="text-decoration: none;"><h3 class="tab-active">Projects</h3></a>
                <a href="" style="text-decoration: none;"><h3 class="">Updates</h3></a>
            </div>

            <!---------↓↓↓-Projects Tab-↓↓↓--------->
            <div class="bus-projects">
                <a href="{{ route('add-project') }}">
                    <div class="bus-add-project-btn">
                        <img src="/assets/plus.png">
                    </div>
                </a>
                <a href="/project/1" class="project-card-link">
                    <x-business-project-card 
                        project_name="Café Kabayan Expansion" 
                        project_current_raised_amt="50000" 
                        project_target_raised_amt="200000" />
                </a>
                <a href="/project/2" class="project-card-link">
                    <x-business-project-card 
                        project_name="Dapitan Branch" 
                        project_current_raised_amt="10000" 
                        project_target_raised_amt="500000" />
                </a>
                <a href="/project/3" class="project-card-link">
                    <x-business-project-card 
                        project_name="Makati Branch" 
                        project_current_raised_amt="25000" 
                        project_target_raised_amt="400000" />
                </a>
            </div>
            <!---------↑↑↑-Projects Tab-↑↑↑--------->

            <!---------↓↓↓-Updates Tab-↓↓↓--------->
            <div class="bus-updates">
                <div class="bus-add-update-cont">
                    <textarea placeholder="Write a new update"></textarea>
                    <a href=""><img src="/assets/send.png"/></a>
                </div>

                <x-business-update-card 
                    business_name="Café Kabayan"
                    update_date_posted="2 weeks ago"
                    update_content="We are thrilled to share an exciting milestone with all our valued investors and supporters: Café Kabayan has officially reached ₱50,000 in total investments! This achievement marks 25% of our ₱200,000 funding goal, and we could not have done it without your trust and belief in our vision."/>
                <x-business-update-card 
                    business_name="Café Kabayan"
                    update_date_posted="3 weeks ago"
                    update_content="Your contributions are more than just numbers on a progress bar—they represent real opportunities for growth and impact. With this initial funding, we have already taken the first steps toward our expansion. We recently finalized our renovation plans with a local contractor who shares our commitment to creating a welcoming space for the community. In addition, we have begun the procurement process for new coffee equipment, which will allow us to serve customers more efficiently and improve the overall café experience."/>
            </div>
            <!---------↑↑↑-Updates Tab-↑↑↑--------->
        </div>
    </div>
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const projectsTab = document.querySelector(".bus-tabs a:nth-child(1) h3");
    const updatesTab = document.querySelector(".bus-tabs a:nth-child(2) h3");
    const projectsDiv = document.querySelector(".bus-projects");
    const updatesDiv = document.querySelector(".bus-updates");

    // Tab switching
    if (projectsDiv) projectsDiv.style.display = "block";
    if (updatesDiv) updatesDiv.style.display = "none";

    projectsTab.addEventListener("click", function (e) {
        e.preventDefault();
        if (projectsDiv) projectsDiv.style.display = "block";
        if (updatesDiv) updatesDiv.style.display = "none";
        projectsTab.classList.add("tab-active");
        updatesTab.classList.remove("tab-active");
    });

    updatesTab.addEventListener("click", function (e) {
        e.preventDefault();
        if (updatesDiv) updatesDiv.style.display = "block";
        if (projectsDiv) projectsDiv.style.display = "none";
        updatesTab.classList.add("tab-active");
        projectsTab.classList.remove("tab-active");
    });

    // Overlay logic with History API
    const overlay = document.querySelector(".project-view-main");
    const projectLinks = document.querySelectorAll(".project-card-link");
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
            window.history.pushState({}, "", "/business");
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
        } else {
            if (overlay) overlay.style.display = "none";
        }
    });
});
</script>
