<!--BUSINESS ARCHIVED PROJECTS-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Archived Project</title>
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
        <div class="bus-posts-cont">
                <h2 style="padding-left: 15px;">Archived Projects</h2>

            <div class="bus-projects" style="padding-top: 10px;">
                @forelse($archivedProjects as $project)
                <div class="project-card">
                    <div class="project-card-content">
                        <div class="project-card-header">
                            <h2>{{ $project->title }}</h2>

                            <span class="project-status-badge status-archived">
                                ARCHIVED
                            </span>
                        </div>

                        <p>₱{{ number_format($project->current_amount, 2) }} of ₱{{ number_format($project->target_amount, 2) }}</p>

                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ min(($project->current_amount / $project->target_amount) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="project-card-actions">
                        <!-- Restore -->
                        <form id="restoreForm-{{ $project->id }}" action="{{ route('project.restore', $project->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="button" class="project-edit-btn" style="background-color: #10b981; color: white;" onclick="confirmRestore({{ $project->id }}, '{{ $project->title }}')">Restore</button>
                        </form>

                        <!-- Permanent Delete -->
                        <form id="permanentDeleteForm-{{ $project->id }}" action="{{ route('project.permanent-delete', $project->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="project-delete-btn" onclick="confirmPermanentDelete({{ $project->id }}, '{{ $project->title }}')">Permanently Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; padding: 30px; color: #737373; font-family: 'Varela Round', sans-serif;">
                    No archived projects. Archived projects will appear here.
                </p>
                @endforelse
            </div>

             <!-- Pagination for Archived Projects -->
                @if($archivedProjects->hasPages())
                <div class="pagination-wrapper">
                    <nav class="pagination-nav select-none">

                        {{-- Previous Button --}}
                        @if ($archivedProjects->onFirstPage())
                            <span class="pg-btn disabled">‹</span>
                        @else
                            <a href="{{ $archivedProjects->previousPageUrl() }}" class="pg-btn active">‹</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($archivedProjects->getUrlRange(1, $archivedProjects->lastPage()) as $page => $url)
                            @if ($page == $archivedProjects->currentPage())
                                <span class="pg-page current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($archivedProjects->hasMorePages())
                            <a href="{{ $archivedProjects->nextPageUrl() }}" class="pg-btn active">›</a>
                        @else
                            <span class="pg-btn disabled">›</span>
                        @endif

                    </nav>
                </div>
                @endif
            </div>
        </div>

        <div class="bus-arch-img-cont">
            <img src="/assets/ar-bus-img.png"/>
        </div>
    </div>

    <script>
        @if(session('success'))
        const successToast = document.getElementById('successToast');
        const successMessage = document.getElementById('successMessage');
        successMessage.textContent = '{{ session('success') }}';
        successToast.classList.add('show');
        setTimeout(() => successToast.classList.remove('show'), 3000);
        @endif

        @if(session('error'))
        const errorToast = document.getElementById('errorToast');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = '{{ session('error') }}';
        errorToast.classList.add('show');
        setTimeout(() => errorToast.classList.remove('show'), 3000);
        @endif

        function confirmRestore(id, name) {
            Swal.fire({
                title: 'Restore Project?',
                text: `Restore "${name}"? This project will return to your active list.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore'
            }).then(r => r.isConfirmed && document.getElementById(`restoreForm-${id}`).submit());
        }

        function confirmPermanentDelete(id, name) {
            Swal.fire({
                title: 'Permanently Delete?',
                text: `This will permanently remove "${name}". This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete Permanently'
            }).then(r => r.isConfirmed && document.getElementById(`permanentDeleteForm-${id}`).submit());
        }
    </script>

    <style>
        /* --- MATCHED TO NEW PROJECT CARD DESIGN --- */

        .project-card {
            display: flex;
            flex-direction: column;
            background-color: white;
            border: 3px solid black;
            border-radius: 25px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            transition: .2s;
        }

        .project-card:hover {
            transform: scale(1.025);
        }

        .project-card-content {
            width: 90%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 25px;
            margin-right: 15px;
            margin-left: 30px;
        }

        .project-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .project-card-header h2 {
            margin: 0;
            font-family: "Tilt Warp", sans-serif;
            font-size: 42px;
            font-weight: 200;
            color: #282828;
            letter-spacing: -2px;
            flex: 1;
        }

        .project-status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-family: "Varela Round", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .status-archived {
            background-color: #5277ddff;
            color: white;
            border: 1px solid #3b5dc9;
        }

        .project-card-content p {
            font-family: "Varela Round", sans-serif;
            font-size: 24px;
            letter-spacing: -1px;
            color: #848484;
            margin: 0 0 10px 0;
        }

        .progress-container {
            width: 100%;
            height: 15px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background-color: #D4A574;
            transition: width .3s ease;
        }

        .project-card-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .project-edit-btn,
        .project-delete-btn {
            padding: 8px 20px;
            border: 2px solid black !important;
            border-radius: 10px;
            font-family: "Varela Round", sans-serif;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .project-delete-btn {
            background-color: #ab3f4c;
            color: white;
        }

        .project-delete-btn:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }

        .project-edit-btn:hover {
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .project-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .project-card-content h2 {
                font-size: 28px;
            }

            .project-card-content p {
                font-size: 18px;
            }
        }

        /* Pagination */
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
</body>
</html>
