<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OFW Contributions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bus-main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            min-height: 100vh;
        }

        .contributions-container {
            width: 100%;
            max-width: 1000px;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin: 20px auto 40px;
            height: fit-content;
        }

        .contributions-container h2 {
            font-family: "Tilt Warp", sans-serif;
            font-size: 32px;
            font-weight: 200;
            color: #282828;
            letter-spacing: -1.5px;
            margin-bottom: 30px;
            text-align: center;
        }

        .contributions-table-container {
            overflow-x: auto;
            margin-bottom: 0;
        }

        .contributions-table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Varela Round", sans-serif;
        }

        .contributions-table thead {
            background: linear-gradient(135deg, #A68749 0%, #8B7139 100%);
            color: white;
        }

        .contributions-table thead th {
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .contributions-table tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .contributions-table tbody tr:hover {
            background-color: #f5f5f5;
            box-shadow: inset 0 0 10px rgba(166, 135, 73, 0.1);
        }

        .contributions-table tbody tr:last-child {
            border-bottom: none;
        }

        .contributions-table tbody td {
            padding: 16px;
            color: #282828;
            font-size: 15px;
        }

        /* Investor Name Style */
        .investor-name {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .investor-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #A68749 0%, #8B7139 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* Project Name Style */
        .project-badge {
            display: inline-block;
            padding: 8px 14px;
            background-color: #f0f0f0;
            border-left: 4px solid #A68749;
            border-radius: 4px;
            font-weight: 500;
        }

        /* Amount Style */
        .amount-cell {
            font-weight: 600;
            color: #2e7d32;
            font-size: 16px;
        }

        /* Date Style */
        .date-cell {
            color: #737373;
            font-size: 14px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #737373;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-family: "Varela Round", sans-serif;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .empty-state-subtext {
            font-family: "Varela Round", sans-serif;
            font-size: 14px;
            color: #999;
        }

        /* Stats Section */
        .contributions-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            padding: 25px;
            background: linear-gradient(135deg, #A68749 0%, #8B7139 100%);
            border-radius: 12px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .contributions-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .bus-main {
                padding: 10px;
            }

            .contributions-container {
                padding: 25px;
                margin: 15px auto;
            }

            .contributions-container h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .contributions-stats {
                grid-template-columns: 1fr;
                gap: 15px;
                margin-bottom: 25px;
            }

            .contributions-table-container {
                margin-bottom: 30px;
            }

            .contributions-table thead th {
                padding: 12px 8px;
                font-size: 14px;
            }

            .contributions-table tbody td {
                padding: 12px 8px;
                font-size: 13px;
            }

            .investor-avatar {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .amount-cell {
                font-size: 14px;
            }
        }
    </style>
</head>

<body class="bus-body">
    <x-navbar-business />

    <div class="bus-main">
        <div class="contributions-container">
            <h2>OFW Investment Contributions</h2>

            @if(!$contributions->isEmpty())
            <!-- Stats Section -->
            <div class="contributions-stats">
                <div class="stat-card">
                    <div class="stat-value">{{ $contributions->count() }}</div>
                    <div class="stat-label">Total Contributions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">₱{{ number_format($contributions->sum('amount'), 2) }}</div>
                    <div class="stat-label">Total Amount Raised</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">₱{{ number_format($contributions->avg('amount'), 2) }}</div>
                    <div class="stat-label">Average Contribution</div>
                </div>
            </div>
            @endif

            <div class="contributions-table-container">
                @if($contributions->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <div class="empty-state-text">No Contributions Yet</div>
                    <div class="empty-state-subtext">Start promoting your projects to receive OFW investments</div>
                </div>
                @else
                <table class="contributions-table">
                    <thead>
                        <tr>
                            <th>Investor</th>
                            <th>Project</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contributions as $contribution)
                        <tr>
                            <td>
                                <div class="investor-name">
                                    <div class="investor-avatar">{{ substr($contribution->user->name, 0, 1) }}</div>
                                    <span>{{ $contribution->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="project-badge">{{ $contribution->project->title }}</span>
                            </td>
                            <td>
                                <span class="amount-cell">₱{{ number_format($contribution->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="date-cell">{{ $contribution->created_at->format('M d, Y') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

</body>

</html>