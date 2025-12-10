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
            <div class="admin-active-projects" style="width: 33%">
                <img src="/assets/admin-active-card.png"/>
                <h3>Active Projects</h3>
                <h4>{{ $activeProjects }}</h4>
            </div>

            <div class="admin-pending-projects" style="width: 33%">
                <img src="/assets/admin-pending2-card.png"/>
                <h3>Pending Projects</h3>
                <h4>{{ $pendingProjects }}</h4>
            </div>

            <div class="admin-archive-requests" style="width: 33%">
                <img src="/assets/admin-pending1-card.png"/>
                <h3>Archive Requests</h3>
                <h4>{{ $archiveRequests }}</h4>
            </div>
        </div>

        <div class="admin-table-cont">
            <p>Pending Projects</p>

            @if($projects->isEmpty())
                <p style="text-align:center; color:gray; padding:20px; font-size:18px;">
                    No pending projects at the moment.
                </p>
            @else
            <table>
                <thead>
                    <tr class="admin-th-row">
                        <th>PROJECT NAME</th>
                        <th>TITLE</th>
                        <th>DESCRIPTION</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->project_name }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->description }}</td>
                        <td>
                            <!-- Approve Form -->
                            <form action="{{ route('admin.project.approve', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="pa-admin-approve-btn">Approve</button>
                            </form>

                            <!-- Decline Form -->
                            <form action="{{ route('admin.project.decline', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="pa-admin-decline-btn">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>
</html>
