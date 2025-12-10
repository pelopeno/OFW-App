<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction History - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        table {
            border: 3px solid black;
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
            text-decoration: none;
            border: none;
        }

        .pg-btn.active {
            background: #A68749;
            color: white;
            cursor: pointer;
        }

        .pg-btn.active:hover {
            background: #8a6d3a;
            transform: translateY(-2px);
        }

        .pg-btn.disabled {
            background: #e6e6e6;
            color: #9e9e9e;
            cursor: not-allowed;
        }

        .pg-page {
            padding: 8px 14px;
            font-size: 16px;
            background: #f7f7f7;
            color: #555;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            transition: 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .pg-page:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .pg-page.current {
            background: #A68749;
            color: white;
            font-weight: bold;
            cursor: default;
            transform: scale(1.05);
        }

        .select-none {
            user-select: none;
        }
    </style>
</head>

<body class="ofw-body">
    <x-navbar-ofw />

    <!-- Success Message Toast -->
    <div id="successToast" class="success-toast">
        <span id="successMessage"></span>
    </div>

    <div class="goals-ofw-main">
        <div class="goals-ofw-content-cont">
            <h2>Transaction History</h2>

            @if($transactions->isEmpty())
            <p style="text-align: center; padding: 20px; color: #737373; font-family: 'Varela Round', sans-serif;">
                No transactions yet.
            </p>
            @else
            <div style="overflow-x:auto;">
                <table class="transactions-table" style="width:100%; border-collapse: collapse; font-family: 'Varela Round', sans-serif;">
                    <thead>
                        <tr style="background-color: #f0f0f0;">
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: center;">Date</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: center;">Type</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: center;">Amount (₱)</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: center;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr style="background-color: #f9f9f9;">
                            <td style="padding: 12px; border: 1px solid #ccc;">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            <td style="padding: 12px; border: 1px solid #ccc;">
                                <span style="padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; 
                                    @if($transaction->type === 'add')
                                        background-color: #e8f5e9; color: #2e7d32;
                                    @else
                                        background-color: #ffebee; color: #c62828;
                                    @endif
                                ">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ccc; text-align: right; font-weight: 600;
                                @if($transaction->type === 'add')
                                    color: #2e7d32;
                                @else
                                    color: #c62828;
                                @endif
                            ">
                                {{ $transaction->type === 'add' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                            </td>
                            <td style="padding: 12px; border: 1px solid #ccc;">{{ $transaction->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination links -->
            @if($transactions->hasPages())
            <div class="pagination-wrapper">
                <nav class="pagination-nav select-none">
                    {{-- Previous --}}
                    @if ($transactions->onFirstPage())
                        <span class="pg-btn disabled">‹</span>
                    @else
                        <a href="{{ $transactions->previousPageUrl() }}" class="pg-btn active">‹</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        @if ($page == $transactions->currentPage())
                            <span class="pg-page current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pg-page">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="pg-btn active">›</a>
                    @else
                        <span class="pg-btn disabled">›</span>
                    @endif
                </nav>
            </div>
            @endif
            @endif

        </div>

        <div class="trans-ofw-img-cont">
            <img src="/assets/tr-ofw-img.png" />
        </div>
    </div>

</body>

</html>