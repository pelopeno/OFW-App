@props(['project_name', 'project_current_raised_amt', 'project_target_raised_amt', 'project_author' => null, 'project_id' => null, 'project_status' => 'active', 'is_business_dashboard' => false])

<div class="project-card">
    @if($is_business_dashboard)
        <a href="/project/{{ $project_id }}" class="project-card-clickable">
            <div class="project-card-content">
                <div class="project-card-header">
                    <h2>{{ $project_name }}</h2>
                    <span class="project-status-badge status-{{ $project_status }}">
                        {{ ucfirst($project_status) }}
                    </span>
                </div>
                <p>₱{{ number_format($project_current_raised_amt, 2) }} of ₱{{ number_format($project_target_raised_amt, 2) }}</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: {{ min(($project_current_raised_amt / $project_target_raised_amt) * 100, 100) }}%"></div>
                </div>
            </div>
            <div class="project-card-arrow">
                <img src="/assets/arrow.png" />
            </div>
        </a>
        <div class="project-card-actions">
            <a href="{{ route('project.edit', $project_id) }}" class="project-edit-btn">Edit</a>
            <form id="deleteForm-{{ $project_id }}" action="{{ route('project.destroy', $project_id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="project-delete-btn" onclick="confirmDelete({{ $project_id }}, '{{ $project_name }}')">Delete</button>
            </form>
        </div>
    @else
        <div class="project-card-row">
            <div class="project-card-content">
                <div class="project-card-header">
                    <h2>{{ $project_name }}</h2>
                    <span class="project-status-badge status-{{ $project_status }}">
                        {{ ucfirst($project_status) }}
                    </span>
                </div>
                
                @if(request()->is('marketplace') || request()->is('marketplace/*'))
                    <p>Project by {{ $project_author }}</p>
                @else
                    <p>₱{{ number_format($project_current_raised_amt, 2) }} of ₱{{ number_format($project_target_raised_amt, 2) }}</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: {{ min(($project_current_raised_amt / $project_target_raised_amt) * 100, 100) }}%"></div>
                    </div>
                @endif
            </div>
            <div class="project-card-arrow">
                <img src="/assets/arrow.png" />
            </div>
        </div>
    @endif
</div>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    .project-card-clickable {
        display: flex;
        flex-direction: row;
        text-decoration: none;
        color: inherit;
        flex: 1;
    }

    .project-card-row {
        display: flex;
        flex-direction: row;
        flex: 1;
    }

    .project-card-clickable:hover .project-card-content h2 {
        color: #A93D3D;
        transition: color 0.3s ease;
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

    .project-card-content h2 {
        margin: 0;
        font-family: "Tilt Warp", sans-serif;
        font-size: 42px;
        font-weight: 200;
        color: #282828;
        letter-spacing: -2px;
        flex: 1;
    }

    /* Status Badge Styles */
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
        flex-shrink: 0;
    }

    .status-pending {
        background-color: #FFF3CD;
        color: #856404;
        border: 1px solid #FFEAA7;
    }

    .status-approved {
        background-color: #D4EDDA;
        color: #155724;
        border: 1px solid #C3E6CB;
    }

    .status-active {
        background-color: #D1ECF1;
        color: #0C5460;
        border: 1px solid #BEE5EB;
    }

    .status-rejected {
        background-color: #F8D7DA;
        color: #721C24;
        border: 1px solid #F5C6CB;
    }

    .status-completed {
        background-color: #C1E4DD;
        color: #0F5F55;
        border: 1px solid #A7D8D0;
    }

    .project-card-content p {
        font-family: "Varela Round", sans-serif;
        font-size: 24px;
        letter-spacing: -1px;
        color: #848484;
        margin: 0;
        margin-bottom: 10px;
    }

    .project-card-arrow {
        width: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .project-card-arrow img {
        height: 25px;
        width: auto;
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

        .project-status-badge {
            font-size: 12px;
            padding: 6px 12px;
        }

        .project-card-content p {
            font-size: 18px;
        }
    }
</style>

<script>
    function confirmDelete(projectId, projectName) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete Project?',
            text: `Are you sure you want to delete "${projectName}"? This action cannot be undone.`,
            showCancelButton: true,
            confirmButtonColor: '#D32F2F',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${projectId}`).submit();
            }
        });
    }
</script>