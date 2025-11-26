<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bus-body" style="overflow: auto; height: auto;">
    <x-navbar-business />

    <div class="add-project-main">
        <div class="add-project-header">
            <h2>Edit Project</h2>
        </div>
        <form class="project-form" method="POST" action="{{ route('project.update', $project->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="input-label">Title</label>
            <input type="text" name="title" value="{{ $project->title }}" placeholder="e.g. Store Renovation" class="project-title-input" required>

            <label class="input-label">Current Image</label>
            @if($project->image)
            <div style="margin-bottom: 15px;">
                <img src="{{ Storage::url($project->image) }}" alt="Project Image" style="max-width: 300px; border-radius: 15px; border: 2px solid black;">
            </div>
            @endif

            <label class="input-label">Change Attachment (Optional)</label>
            <label class="add-post-image" id="imageUploadLabel">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                    <path d="M13 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V9M13 4L18 9M13 4V8C13 8.55228 13.4477 9 14 9H18" stroke="#282828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span id="fileName">Choose a new image (optional)</span>
                <input type="file" name="image" id="projectImage" style="display: none;" accept="image/*">
            </label>

            <label class="input-label">Fundraising Goal</label>
            <input type="number" name="target_amount" value="{{ $project->target_amount }}" placeholder="Enter amount (₱)" class="project-target-input" required>

            <label class="input-label">Description</label>
            <textarea name="description" class="project-desc-input"
                placeholder="Add a description to your proposal"
                oninput="autoResize(this)" required>{{ $project->description }}</textarea>

            <button type="submit" class="create-project-btn">Update Project</button>
            <a href="{{ route('business-dashboard') }}" class="create-project-btn" style="text-align: center; text-decoration: none; background-color: #666; margin-top: 10px;">Cancel</a>
        </form>

    </div>
</body>

<script>
    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    // Auto-resize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('.project-desc-input');
        if (textarea) {
            autoResize(textarea);
        }

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
    });
</script>
