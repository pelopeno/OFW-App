<!--BUSINESS DASHBOARD-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Business Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bus-body">
    <div>
        @include('project')
    </div>
    <x-navbar-business />

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <div class="bus-main">
        <div class="bus-profile-card-cont">
            <x-business-profile-card
                business_name="{{ Auth::user()->name }}"
                business_description="{{ Auth::user()->business_description ?? 'No description yet. Click Edit Profile to add one!' }}"
                profile_picture="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : '/assets/pfp-default.png' }}" />
        </div>

        <div class="bus-posts-cont">
            <div class="bus-tabs">
                <a href="#" id="projectsTabLink" style="text-decoration: none;">
                    <h3 class="tab-active">Projects</h3>
                </a>
                <a href="#" id="updatesTabLink" style="text-decoration: none;">
                    <h3 class="">Updates</h3>
                </a>
            </div>

            <!---------↓↓↓-Projects Tab-↓↓↓--------->
            <div class="bus-projects">
                <a href="#" class="add-project-exclusion-link" id="addProjectBtn">
                    <div class="bus-add-project-btn">
                        <img src="/assets/plus.png">
                    </div>
                </a>

                @forelse($projects as $project)
                <div class="project-card-wrapper">
                    <x-business-project-card
                        project_name="{{ $project->title }}"
                        project_current_raised_amt="{{ $project->current_amount }}"
                        project_target_raised_amt="{{ $project->target_amount }}"
                        project_id="{{ $project->id }}"
                        is_business_dashboard="true" />
                </div>
                @empty
                <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No projects yet. Create your first project!</p>
                @endforelse
            </div>
            <!---------↑↑↑-Projects Tab-↑↑↑--------->

            <!---------↓↓↓-Updates Tab-↓↓↓--------->
            <div class="bus-updates" style="display: none;">
                <div class="bus-add-update-cont">
                    <textarea id="updateContent" placeholder="Write a new update" maxlength="1000"></textarea>
                    <a href="#" id="postUpdateBtn"><img src="/assets/send.png" /></a>
                </div>

                <div id="updatesContainer">
                    @forelse($updates as $update)
                    <x-business-update-card
                        business_name="{{ Auth::user()->name }}"
                        update_date_posted="{{ $update->created_at->diffForHumans() }}"
                        update_content="{{ $update->content }}"
                        update_id="{{ $update->id }}" />
                    @empty
                    <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No updates yet. Share your first update with your supporters!</p>
                    @endforelse
                </div>
            </div>
            <!---------↑↑↑-Updates Tab-↑↑↑--------->
        </div>
    </div>

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="modal-overlay">
        <div class="modal-content add-project-modal">
            <button class="modal-close" id="closeAddProjectModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-project-header">
                <h2>Create Post</h2>
            </div>
            <form class="modal-project-form" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                @csrf

                <label class="input-label">Title</label>
                <input type="text" name="title" placeholder="e.g. Store Renovation" class="project-title-input" required>

                <label class="input-label">Attachment</label>
                <label class="add-post-image" id="imageUploadLabel">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                        <path d="M13 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V9M13 4L18 9M13 4V8C13 8.55228 13.4477 9 14 9H18" stroke="#282828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span id="fileName">Choose an image</span>
                    <input type="file" name="image" id="projectImage" style="display: none;" accept="image/*" required>
                </label>

                <label class="input-label">Fundraising Goal</label>
                <input type="number" name="target_amount" placeholder="Enter amount (₱)" class="project-target-input" required>

                <label class="input-label">Description</label>
                <textarea name="description" class="project-desc-input"
                    placeholder="Add a description to your proposal"
                    oninput="autoResize(this)" required></textarea>

                <button type="submit" class="create-project-btn">Create</button>
            </form>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal-overlay">
        <div class="modal-content edit-profile-modal">
            <button class="modal-close" id="closeEditProfileModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-project-header">
                <h2>Edit Profile</h2>
            </div>
            <form class="modal-project-form" id="editProfileForm">
                @csrf

                <label class="input-label">Profile Picture</label>
                <div class="profile-picture-upload">
                    <img id="profilePreview" src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : '/assets/pfp-default.png' }}" alt="Profile Picture">
                    <label for="profilePictureInput" class="upload-btn">Change Picture</label>
                    <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                </div>

                <label class="input-label">Business Description</label>
                <textarea name="business_description" class="project-desc-input"
                    placeholder="Tell your supporters about your business"
                    oninput="autoResize(this)"
                    maxlength="1000">{{ Auth::user()->business_description }}</textarea>

                <button type="submit" class="create-project-btn">Save Changes</button>
            </form>
        </div>
    </div>

    @include('business.dashboard-scripts')
</body>

</html>