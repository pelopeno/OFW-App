<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">
    <x-navbar-admin />

    <div class="admin-main">
        <h2>Dashboard</h2>
        <div class="admin-overview">
            <div class="admin-total-users">
                <img src="/assets/admin-users-card.png" />
                <h3>Total Users</h3>
                <h4>{{ $totalUsers }}</h4>
            </div>

            <div class="admin-active-projects">
                <img src="/assets/admin-projects-card.png" />
                <h3>Active Projects</h3>
                <h4>{{ $activeProjects }}</h4>
            </div>

            <div class="admin-pending-projects">
                <img src="/assets/admin-pending1-card.png" />
                <h3>Pending Projects</h3>
                <h4>{{ $pendingProjects }}</h4>
            </div>

            <div class="admin-archive-requests">
                <img src="/assets/admin-pending2-card.png" />
                <h3>Archive Requests</h3>
                <h4>{{ $archiveRequests }}</h4>
            </div>
        </div>

        <div class="admin-table-cont">
            <p>Active Projects</p>

            <table>
                <tr class="admin-th-row">
                    <th>PROJECT NAME</th>
                    <th>OWNER</th>
                    <th>DESCRIPTION</th>
                    <th>ACTIONS</th>
                </tr>

                @forelse ($projects as $project)
                <tr class="{{ $project->archive_requested ? 'archive-requested-row' : '' }}">
                    <td>
                        {{ $project->title }}
                        @if($project->archive_requested)
                            <span class="archive-request-badge">📦 Archive Requested</span>
                        @endif
                    </td>
                    <td>{{ $project->user->name ?? 'N/A' }}</td>
                    <td>{{ Str::limit($project->description, 150) }}</td>

                    <td>
                        @if($project->status === 'approved')
                        <form method="POST" action="{{ route('admin.project.disable', $project->id) }}">
                            @csrf
                            <button class="dashboard-admin-disable-btn" type="submit">
                                {{ $project->archive_requested ? 'Allow Archive' : 'Disable' }}
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('admin.project.enable', $project->id) }}">
                            @csrf
                            <button class="dashboard-admin-disable-btn" type="submit">
                                Enable
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No active projects found.</td>
                </tr>
                @endforelse
            </table>

            <!-- Pagination -->
            @if ($projects->hasPages())
            <div style="margin-top: 20px;">
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
            </div>
            @endif

        </div>
    </div>

</body>

<style>
.archive-requested-row {
    background-color: #FFF9E6 !important;
    border-left: 4px solid #FF9800;
}

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
    background: #2a65c3;
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
.pg-page:hover {
    background: #e6e6e6;
    transform: translateY(-2px);
}
.pg-page.current {
    background: #2a65c3;
    color: white;
    font-weight: bold;
    cursor: default;
    transform: scale(1.05);
}
</style>

</html>
