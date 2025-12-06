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
        <h2>Monitoring</h2>
        <div class="admin-table-cont">
            <p>Pending Actions: Projects to be Approved</p>

            <table>
    <tr class="admin-th-row">
        <th>LOG ID</th>
        <th>USER ID</th>
        <th>ACTION TYPE</th>
        <th>REMARKS</th>
        <th>TIMESTAMP</th>
    </tr>

    @forelse ($logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_id }}</td>
            <td>{{ $log->action_type }}</td>
            <td>{{ $log->remarks }}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No logs found.</td>
        </tr>
    @endforelse
</table>

        </div>
</body>

</html>
    