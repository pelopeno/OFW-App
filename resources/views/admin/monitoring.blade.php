<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Monitoring</title>
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

            <!-- Pagination -->
            @if ($logs->hasPages())
            <div style="margin-top: 20px;">
                <div class="pagination-wrapper">
                    <nav class="pagination-nav select-none">

                        {{-- Previous Button --}}
                        @if ($logs->onFirstPage())
                            <span class="pg-btn disabled">‹</span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}" class="pg-btn active">‹</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <span class="pg-page current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}" class="pg-btn active">›</a>
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
