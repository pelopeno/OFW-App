<!DOCTYPE html>
<html lang="en">

<!--Kinopya ko nalang layout ng admin para consistent-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OFW Contributions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">
    <x-navbar-business />

    <div class="admin-main">
        <h2>OFW Investment Contributions</h2>
        
        @if(!$contributions->isEmpty())
        <div class="admin-overview">
            <div class="admin-total-users">
                <h3>Total Contributions</h3>
                <h4>{{ $contributions->count() }}</h4>
            </div>

            <div class="admin-active-projects">
                <h3>Total Amount Raised</h3>
                <h4>₱{{ number_format($contributions->sum('amount'), 2) }}</h4>
            </div>

            <div class="admin-pending-projects">
                <h3>Average Contribution</h3>
                <h4>₱{{ number_format($contributions->avg('amount'), 2) }}</h4>
            </div>
        </div>
        @endif

        <div class="admin-table-cont">
            <p>Contribution History</p>

            @if($contributions->isEmpty())
            <table>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 60px 20px; color: #737373;">
                        <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;">📊</div>
                        <div style="font-size: 18px; margin-bottom: 10px; font-weight: 500;">No Contributions Yet</div>
                        <div style="font-size: 14px; color: #999;">Start promoting your projects to receive OFW investments</div>
                    </td>
                </tr>
            </table>
            @else
            <table>
                <tr class="admin-th-row">
                    <th>INVESTOR</th>
                    <th>PROJECT</th>
                    <th>AMOUNT</th>
                    <th>DATE</th>
                </tr>

                @foreach($contributions as $contribution)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #AB3F4C; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px;">
                                {{ substr($contribution->user->name, 0, 1) }}
                            </div>
                            <span>{{ $contribution->user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $contribution->project->title }}</td>
                    <td style="font-weight: 600; color: #2e7d32;">₱{{ number_format($contribution->amount, 2) }}</td>
                    <td style="color: #737373;">{{ $contribution->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </table>
                      <!-- Pagination -->
            @if($contributions->hasPages())
            <div class="pagination-wrapper">
                <nav class="pagination-nav select-none">
                    {{-- Previous --}}
                    @if ($contributions->onFirstPage())
                        <span class="pg-btn disabled">‹</span>
                    @else
                        <a href="{{ $contributions->previousPageUrl() }}" class="pg-btn active">‹</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($contributions->getUrlRange(1, $contributions->lastPage()) as $page => $url)
                        @if ($page == $contributions->currentPage())
                            <span class="pg-page current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($contributions->hasMorePages())
                        <a href="{{ $contributions->nextPageUrl() }}" class="pg-btn active">›</a>
                    @else
                        <span class="pg-btn disabled">›</span>
                    @endif
                </nav>
            </div>
            @endif
            @endif
        </div>
    </div>

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
            background: #ab3f4c;
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
            background: #ab3f4c;
            color: white;
            font-weight: bold;
            cursor: default;
            transform: scale(1.05);
        }
        .bus-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .bus-table th, .bus-table td {
            padding: 12px 15px;
            text-align: left;
        }
        .bus-table th {
            background-color: #f3f3f3;
        }
        .bus-table tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</body>


</html>