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
        <h2>Monitoring</h2>

        <div class="admin-table-cont">
            <p>System Activity Logs</p>

            <table>
                <tr class="admin-th-row">
                    <th>LOG ID</th>
                    <th>USER</th>
                    <th>ROLE</th>
                    <th>MODULE</th>
                    <th>ACTION</th>
                    <th>REFERENCE ID</th>
                    <th>DETAILS</th>
                    <th>TIMESTAMP</th>
                </tr>

                @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user?->name ?? 'Unknown User' }}</td>
                    <td>{{ strtoupper($log->user?->user_type ?? 'N/A') }}</td>
                    <td>{{ strtoupper($log->module) }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->reference_id ?? '-' }}</td>
                    <td>
                        <span
                            style="display: inline-block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;"
                            title="{{ $log->details }}">
                            {{ $log->details ?? '-' }}
                        </span>
                    </td>

                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No logs found.</td>
                </tr>
                @endforelse
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $logs->links() }}
            </div>

        </div>
    </div>
</body>

</html>