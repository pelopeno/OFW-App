<!--BUSINESS ARCHIVED PROJECTS-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Archived Projects</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bus-body">
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
        <div class="bus-posts-cont" style="margin-top: 30px;">
            <div class="bus-tabs">
                <h3 class="tab-active">Archived Projects</h3>
            </div>

            <div class="bus-projects">
                @forelse($archivedProjects as $project)
                <div class="project-card-wrapper" style="opacity: 0.85;">
                    <div class="project-card">
                        <div class="project-card-content-archived">
                            <div class="project-card-header">
                                <h2>{{ $project->title }}</h2>
                                <span class="project-status-badge" style="background-color: #5277ddff;">
                                    ARCHIVED
                                </span>
                            </div>
                            <p>₱{{ number_format($project->current_amount, 2) }} of ₱{{ number_format($project->target_amount, 2) }}</p>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: {{ min(($project->current_amount / $project->target_amount) * 100, 100) }}%"></div>
                            </div>
                        </div>
                        <div class="project-card-actions">
                            <form id="restoreForm-{{ $project->id }}" action="{{ route('project.restore', $project->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" class="project-edit-btn" style="background-color: #10b981;" onclick="confirmRestore({{ $project->id }}, '{{ $project->title }}')">Restore</button>
                            </form>

                            <form id="permanentDeleteForm-{{ $project->id }}" action="{{ route('project.permanent-delete', $project->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="project-delete-btn" onclick="confirmPermanentDelete({{ $project->id }}, '{{ $project->title }}')">Permanently Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">No archived projects. Archived projects will appear here.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Show success/error messages
        @if(session('success'))
        const successToast = document.getElementById('successToast');
        const successMessage = document.getElementById('successMessage');
        successMessage.textContent = '{{ session('success') }}';
        successToast.classList.add('show');
        setTimeout(() => {
            successToast.classList.remove('show');
        }, 3000);
        @endif

        @if(session('error'))
        const errorToast = document.getElementById('errorToast');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = '{{ session('error') }}';
        errorToast.classList.add('show');
        setTimeout(() => {
            errorToast.classList.remove('show');
        }, 3000);
        @endif

        function confirmRestore(projectId, projectName) {
            Swal.fire({
                title: 'Restore Project?',
                text: `Restore "${projectName}"? This project will return to your active projects.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`restoreForm-${projectId}`).submit();
                }
            });
        }

        function confirmPermanentDelete(projectId, projectName) {
            Swal.fire({
                title: 'Permanently Delete?',
                text: `Delete "${projectName}" permanently? This action cannot be undone! All project data and images will be permanently deleted.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete permanently!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`permanentDeleteForm-${projectId}`).submit();
                }
            });
        }
    </script>

    <style>
        .project-card {
            display: flex;
            flex-direction: column;
            background-color: white;
            border: 3px solid black;
            border-radius: 25px;
            margin-bottom: 15px;
            position: relative;
        }

        .project-card-content-archived {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 15px;
            margin-right: 15px;
            margin-left: 30px;
            padding-right: 30px;
        }

        .project-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .project-card-header h2 {
            font-family: "Tilt Warp", sans-serif;
            font-size: 32px;
            color: #282828;
            margin: 0;
        }

        .project-status-badge {
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: "Varela Round", sans-serif;
            color: white;
        }

        .project-card-content-archived p {
            font-family: "Varela Round", sans-serif;
            font-size: 20px;
            color: #555;
            margin-bottom: 10px;
        }

        .progress-container {
            width: 100%;
            height: 12px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .progress-bar {
            height: 100%;
            background-color: #D4A574;
            transition: width 0.3s ease;
        }

        .project-card-actions {
            display: flex;
            gap: 10px;
            padding: 0 30px 20px 30px;
            justify-content: flex-start;
        }

        .project-edit-btn, .project-delete-btn {
            padding: 8px 20px;
            border-radius: 10px;
            font-family: "Varela Round", sans-serif;
            font-size: 16px;
            border: 2px solid #282828;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .project-edit-btn {
            background-color: #D4A574;
            color: #282828;
            text-decoration: none;
            display: inline-block;
        }

        .project-edit-btn:hover {
            background-color: #C89456;
            transform: scale(1.05);
        }

        .project-delete-btn {
            background-color: #E57373;
            color: white;
        }

        .project-delete-btn:hover {
            background-color: #D32F2F;
            transform: scale(1.05);
        }
    </style>

</body>

</html>
