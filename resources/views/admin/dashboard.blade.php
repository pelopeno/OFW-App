<!--ADMIN DASHBOARD-->
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
        </div>

</body>

<style>
    .archive-requested-row {
        background-color: #FFF9E6 !important;
        border-left: 4px solid #FF9800;
    }
</style>

</html>