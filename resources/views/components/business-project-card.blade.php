@props(['project_name', 'project_current_raised_amt', 'project_target_raised_amt', 'project_author' => null])

<a href="{{ route('project') }}" style="text-decoration: none;">
<div class="project-card">
    <div class="project-card-content">
        <h2>{{ $project_name }}</h2>
        
        @if(request()->is('marketplace') || request()->is('marketplace/*'))
            <p>Project by {{ $project_author }}</p>
        @else
            <p>₱{{ $project_current_raised_amt }} of ₱{{ $project_target_raised_amt }}</p>
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
        @endif
    </div>
    <div class="project-card-arrow">
        <img src="/assets/arrow.png" />
    </div>
</div>
</a>


<style>
    .project-card {
        display: flex;
        flex-direction: row;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        margin-bottom: 15px;
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
</style>