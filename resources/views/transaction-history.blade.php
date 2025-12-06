<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction History - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: #282828;
            font-family: 'Varela Round', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #A68749;
            color: white;
            border-color: #A68749;
        }

        .pagination .active span {
            background-color: #A68749;
            color: white;
            border-color: #A68749;
        }

        .pagination .disabled span {
            color: #ccc;
            cursor: not-allowed;
        }

        .pagination .disabled:hover {
            background-color: transparent;
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
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Date</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Type</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: right;">Amount (₱)</th>
                            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr style="hover: background-color: #f9f9f9;">
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
            <div class="pagination">
                {{-- Previous Page Link --}}
                @if ($transactions->onFirstPage())
                    <span class="disabled">
                        <span>← Previous</span>
                    </span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}" rel="prev">← Previous</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                    @if ($page == $transactions->currentPage())
                        <span class="active">
                            <span>{{ $page }}</span>
                        </span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}" rel="next">Next →</a>
                @else
                    <span class="disabled">
                        <span>Next →</span>
                    </span>
                @endif
            </div>
            @endif
            @endif

        </div>

        <div class="goals-ofw-img-cont">
            <img src="/assets/sg-ofw-img.png" />
        </div>
    </div>

</body>

</html>