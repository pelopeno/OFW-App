<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Business Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bus-body" style="overflow: auto; height: auto;">
    <x-navbar-business />

    <div class="add-project-main">
        <div class="add-project-header">
            <h2>Create Post</h2>
        </div>
        <form class="project-form" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
            @csrf

            <label class="input-label">Title</label>
            <input type="text" name="title" placeholder="e.g. Store Renovation" class="project-title-input" required>

            <label class="input-label">Attachment</label>
            <label class="add-post-image">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"></svg>
                <input type="file" name="image" style="display: none;">
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
</body>

<script>
    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }
</script>