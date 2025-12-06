<div class="project-view-main" style="display: none;">
    <a href="#" class="project-view-x-btn"><img src="/assets/x-btn.png"/></a>
    <div class="project-view-card">
        <h2 id="projectTitle">Cafe Kabayan Expansion</h2>
        <p class="project-view-author" id="projectAuthor">Project by Cafe Kabayan</p>
        <img src="/assets/cafe-img-sample.png" class="project-view-image" id="projectImage" />
        <p class="project-view-raised-amount" id="projectRaised">P50000 of P200000 Raised</p>
        <div class="progress-container" style="width: 100%;">
            <div class="progress-bar" id="projectProgress"></div>
        </div>
        
        @if(auth()->check() && auth()->user()->user_type === 'ofw')
            <button class="donate-btn" id="openDonateModal">Donate</button>
        @endif
        
        <hr class="dotted-hr" />
        <p class="project-view-desc" id="projectDescription">Café Kabayan has grown into a popular spot for students and professionals in Quezon City, thanks to its affordable meals and cozy atmosphere. However, due to limited seating and outdated equipment, the café struggles to accommodate peak-hour demand. Through this expansion project, we aim to renovate our space to add 20 more seats, upgrade our coffee machines to improve service efficiency, and launch an online ordering and delivery platform to reach customers beyond our immediate community. This expansion will not only increase revenue but also create new local job opportunities for baristas, kitchen staff, and delivery personnel.</p>
    </div>

</div>

<script>
// Global function to load project data
window.loadProjectData = function(projectId) {
    fetch(`/api/project/${projectId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('projectTitle').textContent = data.title;
            document.getElementById('projectAuthor').textContent = `Project by ${data.user.name}`;
            document.getElementById('projectImage').src = `/storage/${data.image}`;
            document.getElementById('projectRaised').textContent = `₱${Number(data.current_amount).toLocaleString()} of ₱${Number(data.target_amount).toLocaleString()} Raised`;
            
            const progressPercent = Math.min((data.current_amount / data.target_amount) * 100, 100);
            const progressBar = document.getElementById('projectProgress');
            
            // Reset progress bar to 0
            progressBar.style.width = '0%';
            
            setTimeout(() => {
                progressBar.style.width = `${progressPercent}%`;
            }, 500);
            
            document.getElementById('projectDescription').textContent = data.description;
            
            const donateBtn = document.getElementById('openDonateModal');
            if (donateBtn) {
                donateBtn.setAttribute('data-project-id', data.id);
                donateBtn.setAttribute('data-project-title', data.title);
            }
        })
        .catch(error => console.error('Error loading project:', error));
};

// Initialize project overlay close functionality
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('.project-view-main');
    const closeBtn = document.querySelector('.project-view-x-btn');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (overlay) {
                overlay.style.display = 'none';
            }
            // Update URL based on current page
            if (window.location.pathname.includes('/business')) {
                window.history.pushState({}, '', '/business');
            } else if (window.location.pathname.includes('/marketplace')) {
                window.history.pushState({}, '', '/marketplace');
            } else {
                window.history.pushState({}, '', '/dashboard');
            }
        });
    }
    
    // Handle browser back/forward
    window.addEventListener('popstate', () => {
        if (window.location.pathname.startsWith('/project/')) {
            const projectId = window.location.pathname.split('/').pop();
            window.loadProjectData(projectId);
            if (overlay) overlay.style.display = 'flex';
        } else {
            if (overlay) overlay.style.display = 'none';
        }
    });
    
    // Check if we're on a project page on load
    if (window.location.pathname.startsWith('/project/')) {
        const projectId = window.location.pathname.split('/').pop();
        window.loadProjectData(projectId);
        if (overlay) overlay.style.display = 'flex';
    }
});
</script>

<style>
    .project-view-main {
        width: 100%;
        height: 100%;
        position: absolute;
        background-color: rgba(0, 0, 0, 0.50);
        z-index: 5;
        display: flex;
        justify-content: center;
        overflow-y: scroll;
    }

    .project-view-card {
        width: 40%;
        height: fit-content;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        padding: 25px;
        margin: 30px;
    }

    .project-view-x-btn {
        position: absolute;
        right: 27%;
        top: 2%;
        z-index: 6;
    }

    .project-view-x-btn img {
        width: 60px;
        height: auto;
    }

    .project-view-card h2 {
        font-family: "Tilt Warp", sans-serif;
        font-size: 36px;
        font-weight: 200;
        color: #282828;
        letter-spacing: -2.5px;
        margin: 0;
    }

    .project-view-author {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        color: #737373;
        margin: 0;
        margin-bottom: 25px;
    }

    .project-view-image {
        border: 3px solid black;
        border-radius: 15px;
        margin-bottom: 10px;
    }

    .project-view-raised-amount {
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        font-weight: 600;
        letter-spacing: -1px;
        color: #282828;
        margin: 10px 0;
    }

    .donate-btn {
        display: block;
        padding: 15px;
        margin-top: 15px;
        background-color: #A68749;
        color: white;
        border: transparent;
        border-radius: 12px;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
    }

    .donate-btn:hover {
        background-color: #404040;
        transform: translateY(-2px);
    }

    .dotted-hr {
        width: 100%;
        border: none;
        border-top: 2.5px dotted #ccc;
        color: #828282;
        background-color: transparent;
        height: 3px;
        margin: 25px 0;
    }

    .project-view-desc {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        color: #282828;
        margin: 0;
        padding-bottom: 25px;
    }
</style>