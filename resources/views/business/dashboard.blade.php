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
        @include('business.update-view')
    </div>
    <x-navbar-business />

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <!-- Error Message Toast -->
    <div id="errorToast" class="error-toast">
        <span id="errorMessage"></span>
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
            project_status="{{ $project->status }}"
            project_id="{{ $project->id }}"
            archive_requested="{{ $project->archive_requested }}"
            is_business_dashboard="true" />
    </div>
    @empty
    <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No projects yet. Create your first project!</p>
    @endforelse

    <!-- Pagination for Projects -->
    @if($projects->hasPages())
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
    @endif
</div>
<!---------↑↑↑-Projects Tab-↑↑↑--------->
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
    background: #ab3f4c;
    color: white;
    cursor: pointer;
}

.pg-btn.active:hover {
    background: #ab3f4c;
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
    background: #ab3f4c;
    color: white;
    font-weight: bold;
    cursor: default;
    transform: scale(1.05);
}
</style>


            <!---------↓↓↓-Updates Tab-↓↓↓------->
            <div class="bus-updates" style="display: none;">
                <a href="#" class="add-project-exclusion-link" id="addUpdateBtn">
                    <div class="bus-add-project-btn">
                        <img src="/assets/plus.png">
                    </div>
                </a>

                <div id="updatesContainer">
                    @forelse($updates as $update)
                    <x-business-update-card
                        project_name="{{ $update->project ? $update->project->title : 'Unknown Project' }}"
                        update_date_posted="{{ $update->created_at->diffForHumans() }}"
                        update_content="{{ $update->content }}"
                        update_id="{{ $update->id }}"
                        update_image="{{ $update->image }}" />
                    @empty
                    <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No updates yet. Share your first update with your supporters!</p>
                    @endforelse
                </div>
                <!-- Pagination for Updates -->
@if($updates->hasPages())
<div class="pagination-wrapper">
    <nav class="pagination-nav select-none">

        {{-- Previous Button --}}
        @if ($updates->onFirstPage())
            <span class="pg-btn disabled">‹</span>
        @else
            <a href="{{ $updates->previousPageUrl() }}" class="pg-btn active">‹</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($updates->getUrlRange(1, $updates->lastPage()) as $page => $url)
            @if ($page == $updates->currentPage())
                <span class="pg-page current">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($updates->hasMorePages())
            <a href="{{ $updates->nextPageUrl() }}" class="pg-btn active">›</a>
        @else
            <span class="pg-btn disabled">›</span>
        @endif

    </nav>
</div>
@endif
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
    background: #ab3f4c;
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
    background: #ab3f4c;
    color: white;
    font-weight: bold;
    cursor: default;
    transform: scale(1.05);
}
</style>
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

    <!-- Create Update Modal -->
    <div id="createUpdateModal" class="modal-overlay">
        <div class="modal-content add-project-modal">
            <button class="modal-close" id="closeCreateUpdateModal">
                <img src="/assets/x-btn.png" alt="Close">
            </button>
            <div class="add-project-header">
                <h2>Create Update</h2>
            </div>
            <form class="modal-project-form" id="createUpdateForm" enctype="multipart/form-data">
                @csrf

                <label class="input-label">Select Project</label>
                <select name="project_id" id="updateProjectSelect" class="project-title-input" required>
                    <option value="">Choose a project...</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>

                <label class="input-label">Attachment (Optional)</label>
                <label class="add-post-image" id="updateImageUploadLabel">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                        <path d="M13 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V9M13 4L18 9M13 4V8C13 8.55228 13.4477 9 14 9H18" stroke="#282828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span id="updateFileName">Choose an image</span>
                    <input type="file" name="image" id="updateImage" style="display: none;" accept="image/*">
                </label>

                <label class="input-label">Update Message</label>
                <textarea id="updateContentModal" name="content" class="project-desc-input"
                    placeholder="Share an update with your supporters..."
                    oninput="autoResize(this)"
                    maxlength="1000"
                    required></textarea>

                <button type="submit" class="create-project-btn">Post Update</button>
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