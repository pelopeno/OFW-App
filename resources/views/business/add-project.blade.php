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
        <form class="project-form">
            <label class="input-label">Title</label>
            <input type="text" placeholder="e.g. Store Renovation" class="project-title-input" />

            <label class="input-label">Attachment</label>
            <label class="add-post-image">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M23 4C23 2.34315 21.6569 1 20 1H4C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4ZM21 4C21 3.44772 20.5523 3 20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4Z" fill="#484848"></path> <path d="M4.80665 17.5211L9.1221 9.60947C9.50112 8.91461 10.4989 8.91461 10.8779 9.60947L14.0465 15.4186L15.1318 13.5194C15.5157 12.8476 16.4843 12.8476 16.8682 13.5194L19.1451 17.5039C19.526 18.1705 19.0446 19 18.2768 19H5.68454C4.92548 19 4.44317 18.1875 4.80665 17.5211Z" fill="#484848"></path> <path d="M18 8C18 9.10457 17.1046 10 16 10C14.8954 10 14 9.10457 14 8C14 6.89543 14.8954 6 16 6C17.1046 6 18 6.89543 18 8Z" fill="#484848"></path> </g></svg> <!--SVG na tinamad ako i-download-->
                <input type="file" style="display: none;">
            </label>

            <label class="input-label">Fundraising Goal</label>
            <input type="number" placeholder="Enter amount (₱)" class="project-target-input" />

            <label class="input-label">Description</label>
            <textarea class="project-desc-input" placeholder="Add a description to your proposal" oninput="autoResize(this)"></textarea>

                <button type="submit" class="create-project-btn">Create</p>
        </form>
    </div>
</body>

<script>
function autoResize(textarea) {
    textarea.style.height = "auto";     
    textarea.style.height = textarea.scrollHeight + "px"; 
}
</script>