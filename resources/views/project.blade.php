<div class="project-view-main" style="display: none;">
    <a href="#" class="project-view-x-btn"><img src="/assets/x-btn.png" /></a>
    <div class="project-view-card">
        <!-- Scroll hint indicator -->
        <div class="scroll-hint" id="scrollHint">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 13l5 5 5-5M7 6l5 5 5-5"/>
            </svg>
        </div>
        
        <h2 id="projectTitle">Cafe Kabayan Expansion</h2>
        <p class="project-view-author" id="projectAuthor">Project by Cafe Kabayan</p>

        <!-- Tabs -->
        <div class="project-tabs">
            <button class="project-tab-btn active" data-tab="details">Details</button>
            <button class="project-tab-btn" data-tab="updates">Updates</button>
        </div>

        <!-- Details Tab -->
        <div class="project-tab-content active" id="detailsTab">
            <img src="/assets/cafe-img-sample.png" class="project-view-image" id="projectImage" />
            <p class="project-view-raised-amount" id="projectRaised">P50000 of P200000 Raised</p>
            <div class="progress-container" style="width: 100%;">
                <div class="progress-bar" id="projectProgress"></div>
            </div>

            @if(auth()->check() && auth()->user()->user_type === 'ofw' && empty($isInvestmentPage))
            <button class="donate-btn" id="openDonateModal">Donate</button>
            @endif

            <hr class="dotted-hr" />
            <p class="project-view-desc" id="projectDescription">Café Kabayan has grown into a popular spot for students and professionals in Quezon City, thanks to its affordable meals and cozy atmosphere. However, due to limited seating and outdated equipment, the café struggles to accommodate peak-hour demand. Through this expansion project, we aim to renovate our space to add 20 more seats, upgrade our coffee machines to improve service efficiency, and launch an online ordering and delivery platform to reach customers beyond our immediate community. This expansion will not only increase revenue but also create new local job opportunities for baristas, kitchen staff, and delivery personnel.</p>
        </div>

        <!-- Updates Tab -->
        <div class="project-tab-content" id="updatesTab" style="display: none;">
            <div id="projectUpdatesContainer">
                <p style="text-align: center; padding: 30px; color: #737373;">Loading updates...</p>
            </div>
        </div>
    </div>

</div>

<script>
    // Global variable to store current project ID
    let currentProjectId = null;

    // Global function to load project data
    window.loadProjectData = function(projectId) {
        currentProjectId = projectId;
        console.log('Loading project data for ID:', projectId);

        fetch(`/api/project/${projectId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Project data loaded:', data);
                const titleElement = document.getElementById('projectTitle');
                titleElement.textContent = data.title;
                titleElement.setAttribute('data-project-id', data.id);
                console.log('Set data-project-id to:', data.id);

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

                // Reset to details tab
                document.querySelectorAll('.project-tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.project-tab-content').forEach(content => {
                    content.classList.remove('active');
                    content.style.display = 'none';
                });
                document.querySelector('[data-tab="details"]').classList.add('active');
                const detailsTab = document.getElementById('detailsTab');
                detailsTab.classList.add('active');
                detailsTab.style.display = 'block';
            })
            .catch(error => console.error('Error loading project:', error));
    };

    // Function to load project updates
    function loadProjectUpdates(projectId) {
        const container = document.getElementById('projectUpdatesContainer');
        container.innerHTML = '<p style="text-align: center; padding: 30px; color: #737373;">Loading updates...</p>';

        console.log('Fetching updates from:', `/api/project/${projectId}/updates`);

        fetch(`/api/project/${projectId}/updates`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Updates data:', data);
                console.log('Updates array:', data.updates);
                console.log('Updates length:', data.updates ? data.updates.length : 'undefined');
                
                if (data.updates && Array.isArray(data.updates) && data.updates.length > 0) {
                    container.innerHTML = '';
                    data.updates.forEach(update => {
                        console.log('Adding update:', update);
                        const updateCard = document.createElement('div');
                        updateCard.className = 'project-update-item';
                        updateCard.innerHTML = `
                        <img src="/storage/${update.image}" class="project-update-image" />
                        <p class="project-update-date">${update.created_at}</p>
                        <p class="project-update-content">${update.content}</p>
                        <hr class="dotted-hr" />
                    `;
                        container.appendChild(updateCard);
                    });
                } else {
                    console.log('No updates found - showing empty message');
                    container.innerHTML = '<p style="text-align: center; padding: 30px; color: #737373;">No updates yet for this project.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading updates:', error);
                container.innerHTML = '<p style="text-align: center; padding: 30px; color: #737373;">Failed to load updates.</p>';
            });
    }

    // Initialize project overlay close functionality
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.querySelector('.project-view-main');
        const closeBtn = document.querySelector('.project-view-x-btn');
        const projectCard = document.querySelector('.project-view-card');
        const scrollHint = document.getElementById('scrollHint');

        // Scroll hint functionality
        if (projectCard && scrollHint) {
            // Check if content is scrollable and show/hide hint
            const checkScrollable = () => {
                const isScrollable = projectCard.scrollHeight > projectCard.clientHeight;
                if (isScrollable) {
                    scrollHint.style.display = 'flex';
                    // Auto-hide after 3 seconds
                    setTimeout(() => {
                        scrollHint.classList.add('fade-out');
                    }, 3000);
                } else {
                    scrollHint.style.display = 'none';
                }
            };

            // Click hint to scroll down
            scrollHint.addEventListener('click', () => {
                projectCard.scrollTo({
                    top: projectCard.scrollHeight,
                    behavior: 'smooth'
                });
                scrollHint.classList.add('fade-out');
            });

            // Hide hint when user scrolls
            projectCard.addEventListener('scroll', () => {
                if (projectCard.scrollTop > 50) {
                    scrollHint.classList.add('fade-out');
                }
            });

            // Check scrollable on content load
            const observer = new MutationObserver(checkScrollable);
            observer.observe(projectCard, { childList: true, subtree: true });
            
            // Initial check
            setTimeout(checkScrollable, 100);
        }

        // Tab switching
        const tabButtons = document.querySelectorAll('.project-tab-btn');
        const tabContents = document.querySelectorAll('.project-tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab');
                console.log('Tab clicked:', tabName);

                // Remove active class from all tabs
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    content.style.display = 'none';
                });

                // Add active class to clicked tab
                button.classList.add('active');
                const activeTab = document.getElementById(`${tabName}Tab`);
                activeTab.classList.add('active');
                activeTab.style.display = 'block';

                // Load updates if updates tab is clicked
                if (tabName === 'updates') {
                    let projectId = document.getElementById('projectTitle').getAttribute('data-project-id');

                    // Fallback to global variable if attribute is null
                    if (!projectId && currentProjectId) {
                        projectId = currentProjectId;
                        console.log('Using global currentProjectId:', projectId);
                    }

                    console.log('Loading updates for project:', projectId);
                    if (projectId) {
                        loadProjectUpdates(projectId);
                    } else {
                        console.error('No project ID found');
                    }
                }
            });
        });

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
        align-items: center;
        overflow-y: hidden;
    }

    .project-view-card {
        width: 40%;
        max-height: 90vh;
        height: fit-content;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        padding: 25px;
        margin: 30px;
        overflow-y: auto;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
        scroll-behavior: smooth;
    }

    .project-view-card::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }

    /* Scroll hint indicator */
    .scroll-hint {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        background: rgba(166, 135, 73, 0.9);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        animation: bounceHint 2s infinite;
        cursor: pointer;
        transition: opacity 0.5s ease, transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .scroll-hint:hover {
        background: rgba(64, 64, 64, 0.9);
        transform: translateX(-50%) scale(1.1);
    }

    .scroll-hint.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    @keyframes bounceHint {
        0%, 20%, 50%, 80%, 100% {
            transform: translateX(-50%) translateY(0);
        }
        40% {
            transform: translateX(-50%) translateY(-10px);
        }
        60% {
            transform: translateX(-50%) translateY(-5px);
        }
    }

    .project-view-x-btn {
        position: absolute;
        right: 27%;
        top: 0;
        z-index: 6;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .project-view-x-btn:hover {
        transform: scale(1.1) rotate(90deg);
    }

    .project-view-x-btn:active {
        transform: scale(0.95) rotate(90deg);
    }

    .project-view-x-btn img {
        width: 60px;
        height: auto;
        filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.3));
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

    .project-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
    }

    .project-tab-btn {
        padding: 10px 20px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #737373;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: -2px;
        position: relative;
    }

    .project-tab-btn::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 100%;
        height: 3px;
        background: #A68749;
        transition: transform 0.3s ease;
    }

    .project-tab-btn:hover::after {
        transform: translateX(-50%) scaleX(0.5);
    }

    .project-tab-btn.active {
        color: #282828;
        border-bottom-color: #A68749;
    }

    .project-tab-btn.active::after {
        transform: translateX(-50%) scaleX(1);
    }

    .project-tab-btn:hover {
        color: #282828;
        transform: translateY(-2px);
    }

    .project-tab-btn:active {
        transform: translateY(0);
    }

    .project-tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .project-tab-content.active {
        display: block !important;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .project-update-item {
        margin-bottom: 30px;
    }

    .project-update-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border: 3px solid black;
        border-radius: 15px;
        margin-bottom: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .project-update-image:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .project-update-date {
        font-family: "Varela Round", sans-serif;
        font-size: 16px;
        color: #848484;
        margin: 10px 0;
    }

    .project-update-content {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        line-height: 1.6;
        color: #282828;
        margin: 15px 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .project-view-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border: 3px solid black;
        border-radius: 15px;
        margin-bottom: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .project-view-image:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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