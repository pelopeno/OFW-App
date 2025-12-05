@props(['project_name', 'project_current_raised_amt', 'project_target_raised_amt', 'project_author' => null, 'project_id' => null, 'is_business_dashboard' => false])

<div class="project-card">
    @if($is_business_dashboard)
        <a href="/project/{{ $project_id }}" class="project-card-clickable">
            <div class="project-card-content">
                <h2>{{ $project_name }}</h2>
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
            <form action="{{ route('project.destroy', $project_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="project-delete-btn">Delete</button>
            </form>
        </div>
    @else
        <div class="project-card-row">
            <div class="project-card-content">
                <h2>{{ $project_name }}</h2>
                
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

    .project-card-content h2 {
        width: 100%;
        margin: 0;
        margin-bottom: 10px;
        font-family: "Tilt Warp", sans-serif;
        font-size: 42px;
        font-weight: 200;
        color: #282828;
        letter-spacing: -2px;
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