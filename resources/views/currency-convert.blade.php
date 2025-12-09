@php
$converted = $converted ?? null;
$rate = $rate ?? null;
$error = $error ?? null;
$amount = $amount ?? '';
$from = $from ?? '';
$to = $to ?? '';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Currency Converter - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <x-navbar-ofw />
    <div class="currency-converter">
        <h1>Currency Converter</h1>

        <form method="POST" action="{{ route('convert-currency.post') }}" class="converter-form">
            @csrf

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" step="0.01" min="0.01"
                    value="{{ old('amount', $amount ?? '') }}" required>
                @error('amount')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="from">From</label>
                    <select id="from" name="from" required>
                        <option value="">Select currency</option>
                        <option value="PHP" {{ old('from', $from ?? '') === 'PHP' ? 'selected' : '' }}>PHP - Philippine
                            Peso
                        </option>
                        <option value="USD" {{ old('from', $from ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar
                        </option>
                        <option value="EUR" {{ old('from', $from ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro
                        </option>
                        <option value="GBP" {{ old('from', $from ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British
                            Pound
                        </option>
                        <option value="JPY" {{ old('from', $from ?? '') === 'JPY' ? 'selected' : '' }}>JPY - Japanese
                            Yen
                        </option>
                        <option value="AUD" {{ old('from', $from ?? '') === 'AUD' ? 'selected' : '' }}>AUD - Australian
                            Dollar
                        </option>
                    </select>
                    @error('from')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="to">To</label>
                    <select id="to" name="to" required>
                        <option value="">Select currency</option>
                        <option value="PHP" {{ old('to', $to ?? '') === 'PHP' ? 'selected' : '' }}>PHP - Philippine Peso
                        </option>
                        <option value="USD" {{ old('to', $to ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar
                        </option>
                        <option value="EUR" {{ old('to', $to ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro
                        </option>
                        <option value="GBP" {{ old('to', $to ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British
                            Pound
                        </option>
                        <option value="JPY" {{ old('to', $to ?? '') === 'JPY' ? 'selected' : '' }}>JPY - Japanese
                            Yen
                        </option>
                        <option value="AUD" {{ old('to', $to ?? '') === 'AUD' ? 'selected' : '' }}>AUD - Australian
                            Dollar
                        </option>
                    </select>
                    @error('to')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="convert-btn">Convert</button>
        </form>

        <!-- Display Results -->
        @if($converted !== null && !$error)
        <div class="result-box success">
            <h3>Conversion Result</h3>
            <p class="result-amount">
                <strong>{{ number_format($amount, 2) }} {{ $from }}</strong>
                <strong class="converted-amount">{{ number_format($converted, 2) }} {{ $to }}</strong>
            </p>
            <p class="exchange-rate">Exchange Rate: 1 {{ $from }} = {{ number_format($rate, 4) }} {{ $to }}</p>
        </div>
        @elseif($error)
        <div class="result-box error">
            <p>{{ $error }}</p>
        </div>
        @endif
    </div>

    <style>
        .currency-converter {
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border: 3px solid black;
            border-radius: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .currency-converter h1 {
            text-align: center;
            color: black;
            margin-bottom: 30px;
            font-family: "Tilt Warp", sans-serif;
            font-size: 48px;
            font-weight: 200;
            letter-spacing: -1.5px;
        }

        .converter-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: #282828;
            font-family: "Varela Round", sans-serif;
        }

        .form-group input,
        .form-group select {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-family: "Varela Round", sans-serif;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #A68749;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
        }

        .convert-btn {
            padding: 12px 30px;
            background-color: #A68749;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: "Varela Round", sans-serif;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .convert-btn:hover {
            background-color: #8a6f3a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(166, 135, 73, 0.3);
        }

        .result-box {
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .result-box.success {
            background-color: #D4EDDA;
            border: 2px solid #C3E6CB;
            color: #155724;
        }

        .result-box.error {
            background-color: #F8D7DA;
            border: 2px solid #F5C6CB;
            color: #721C24;
        }

        .result-box h3 {
            margin: 0 0 15px 0;
            font-family: "Varela Round", sans-serif;
        }

        .result-amount {
            font-size: 20px;
            font-weight: 600;
            margin: 10px 0;
        }

        .converted-amount {
            color: #A68749;
            font-size: 24px;
        }

        .exchange-rate {
            font-size: 14px;
            opacity: 0.8;
            margin: 10px 0 0 0;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .currency-converter {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</body>

</html>