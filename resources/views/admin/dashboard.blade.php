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
    <x-navbar-admin/>

    <div class="admin-main">
        <h2>Dashboard</h2>
        <div class="admin-overview">
    <div class="admin-total-users">
        <img src="/assets/admin-users-card.png"/>
        <h3>Total Users</h3>
        <h4>{{ $totalUsers }}</h4>
    </div>

    <div class="admin-active-projects">
        <img src="/assets/admin-projects-card.png"/>
        <h3>Active Projects</h3>
        <h4>{{ $activeProjects }}</h4>
    </div>

    <div class="admin-pending-projects">
        <img src="/assets/admin-pending1-card.png"/>
        <h3>Pending Projects</h3>
        <h4>{{ $pendingProjects }}</h4>
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
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->user->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($project->description, 150) }}</td>

                <td>
                    <form method="POST" action="{{ route('admin.project.disable', $project->id) }}">
                        @csrf
                        <button class="dashboard-admin-disable-btn" type="submit">
                            Disable
                        </button>
                    </form>
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

</html>
    