<script>
    document.addEventListener("DOMContentLoaded", function() {
        const projectsTab = document.getElementById("projectsTabLink");
        const updatesTab = document.getElementById("updatesTabLink");
        const projectsDiv = document.querySelector(".bus-projects");
        const updatesDiv = document.querySelector(".bus-updates");

        // Tab switching with smooth transition
        projectsTab.addEventListener("click", function(e) {
            e.preventDefault();
            updatesDiv.classList.remove('fade-in');
            updatesDiv.classList.add('fade-out');
            setTimeout(() => {
                updatesDiv.style.display = "none";
                projectsDiv.style.display = "block";
                projectsDiv.classList.remove('fade-out');
                projectsDiv.classList.add('fade-in');
            }, 150);
            projectsTab.querySelector('h3').classList.add("tab-active");
            updatesTab.querySelector('h3').classList.remove("tab-active");
        });

        updatesTab.addEventListener("click", function(e) {
            e.preventDefault();
            projectsDiv.classList.remove('fade-in');
            projectsDiv.classList.add('fade-out');
            setTimeout(() => {
                projectsDiv.style.display = "none";
                updatesDiv.style.display = "block";
                updatesDiv.classList.remove('fade-out');
                updatesDiv.classList.add('fade-in');
            }, 150);
            updatesTab.querySelector('h3').classList.add("tab-active");
            projectsTab.querySelector('h3').classList.remove("tab-active");
        });

        // Modal functionality
        const addProjectModal = document.getElementById('addProjectModal');
        const addProjectBtn = document.getElementById('addProjectBtn');
        const closeAddProjectModal = document.getElementById('closeAddProjectModal');

        addProjectBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addProjectModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        closeAddProjectModal.addEventListener('click', () => {
            addProjectModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });

        addProjectModal.addEventListener('click', (e) => {
            if (e.target === addProjectModal) {
                addProjectModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        // Image upload preview
        const projectImage = document.getElementById('projectImage');
        const fileName = document.getElementById('fileName');
        const imageUploadLabel = document.getElementById('imageUploadLabel');

        projectImage.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                fileName.textContent = this.files[0].name;
                imageUploadLabel.style.borderColor = '#A68749';
                imageUploadLabel.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    imageUploadLabel.style.transform = 'scale(1)';
                }, 200);
            }
        });

        // Edit Profile Modal
        const editProfileModal = document.getElementById('editProfileModal');
        const editProfileBtn = document.querySelector('.bus-name button');
        const closeEditProfileModal = document.getElementById('closeEditProfileModal');

        editProfileBtn.addEventListener('click', (e) => {
            e.preventDefault();
            editProfileModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        closeEditProfileModal.addEventListener('click', () => {
            editProfileModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });

        editProfileModal.addEventListener('click', (e) => {
            if (e.target === editProfileModal) {
                editProfileModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        // Profile picture preview
        const profilePictureInput = document.getElementById('profilePictureInput');
        const profilePreview = document.getElementById('profilePreview');

        profilePictureInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                    profilePreview.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        profilePreview.style.transform = 'scale(1)';
                    }, 200);
                };
                reader.readAsDataURL(this.files[0]);
                
                // Upload profile picture
                uploadProfilePicture(this.files[0]);
            }
        });

        // Edit Profile Form Submit
        const editProfileForm = document.getElementById('editProfileForm');
        editProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
            submitBtn.style.opacity = '0.6';

            fetch('{{ route("business.profile.update") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    document.querySelector('.bus-desc p').textContent = data.business_description || 'No description yet. Click Edit Profile to add one!';
                    editProfileModal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.style.opacity = '1';
                alert('An error occurred. Please try again.');
            });
        });

        // Upload profile picture
        function uploadProfilePicture(file) {
            const formData = new FormData();
            formData.append('profile_picture', file);

            fetch('{{ route("business.profile.picture") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    document.querySelector('.bus-pfp img').src = data.profile_picture_url;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to upload profile picture');
            });
        }

        // Post Update
        const postUpdateBtn = document.getElementById('postUpdateBtn');
        const updateContent = document.getElementById('updateContent');

        postUpdateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const content = updateContent.value.trim();
            if (!content) {
                alert('Please write something before posting');
                return;
            }

            this.style.opacity = '0.5';
            this.style.pointerEvents = 'none';

            fetch('{{ route("business.updates.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    updateContent.value = '';
                    updateContent.style.height = 'auto';
                    addUpdateToList(data.update);
                }
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            })
            .catch(error => {
                console.error('Error:', error);
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
                alert('Failed to post update');
            });
        });

        // Add update to list
        function addUpdateToList(update) {
            const updatesContainer = document.getElementById('updatesContainer');
            const emptyMessage = updatesContainer.querySelector('p');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            const updateCard = document.createElement('div');
            updateCard.className = 'bus-update-card fade-in';
            updateCard.setAttribute('data-update-id', update.id);
            updateCard.innerHTML = `
                <div class="bus-update-header">
                    <h3>{{ Auth::user()->name }}</h3>
                    <span>${update.created_at}</span>
                    <button class="delete-update-btn" onclick="deleteUpdate(${update.id})">×</button>
                </div>
                <p>${update.content}</p>
            `;
            updatesContainer.insertBefore(updateCard, updatesContainer.firstChild);
        }

        // Project overlay logic
        const overlay = document.querySelector(".project-view-main");
        const projectLinks = document.querySelectorAll(".project-card-clickable");
        const closeBtn = document.querySelector(".project-view-x-btn");

        if (overlay) overlay.style.display = "none";

        projectLinks.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                const projectId = link.getAttribute("href").split("/").pop();
                loadProjectData(projectId);
                if (overlay) overlay.style.display = "flex";
                window.history.pushState({ overlay: true }, "", link.getAttribute("href"));
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener("click", e => {
                e.preventDefault();
                if (overlay) overlay.style.display = "none";
                window.history.pushState({}, "", "/business");
            });
        }

        // Function to load project data dynamically
        function loadProjectData(projectId) {
            fetch(`/api/project/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.project-view-card h2').textContent = data.title;
                    document.querySelector('.project-view-author').textContent = `Project by ${data.user.name}`;
                    document.querySelector('.project-view-image').src = `/storage/${data.image}`;
                    document.querySelector('.project-view-raised-amount').textContent = `₱${Number(data.current_amount).toLocaleString()} of ₱${Number(data.target_amount).toLocaleString()} Raised`;
                    const progressPercent = Math.min((data.current_amount / data.target_amount) * 100, 100);
                    document.querySelector('.project-view-card .progress-bar').style.width = `${progressPercent}%`;
                    document.querySelector('.project-view-desc').textContent = data.description;
                    
                    // Update donate button link if it exists
                    const donateBtn = document.querySelector('.donate-btn');
                    if (donateBtn) {
                        donateBtn.href = `/donate-project?project_id=${data.id}`;
                    }
                })
                .catch(error => console.error('Error loading project:', error));
        }

        if (window.location.pathname.startsWith("/project/")) {
            const projectId = window.location.pathname.split("/").pop();
            loadProjectData(projectId);
            if (overlay) overlay.style.display = "flex";
        }

        window.addEventListener("popstate", () => {
            if (window.location.pathname.startsWith("/project/")) {
                const projectId = window.location.pathname.split("/").pop();
                loadProjectData(projectId);
                if (overlay) overlay.style.display = "flex";
            } else {
                if (overlay) overlay.style.display = "none";
            }
        });

        // Success Toast
        function showSuccessToast(message) {
            const toast = document.getElementById('successToast');
            const messageSpan = document.getElementById('successMessage');
            messageSpan.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    });

    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    // Delete update function
    function deleteUpdate(updateId) {
        if (!confirm('Are you sure you want to delete this update?')) {
            return;
        }

        fetch(`/business/updates/${updateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const updateCard = document.querySelector(`[data-update-id="${updateId}"]`);
                updateCard.style.opacity = '0';
                updateCard.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    updateCard.remove();
                    const updatesContainer = document.getElementById('updatesContainer');
                    if (!updatesContainer.querySelector('.bus-update-card')) {
                        updatesContainer.innerHTML = '<p style="text-align: center; padding: 30px; color: #737373; font-family: \'Varela Round\', sans-serif;">No updates yet. Share your first update with your supporters!</p>';
                    }
                }, 300);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete update');
        });
    }
</script>
