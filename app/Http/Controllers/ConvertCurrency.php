<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConvertCurrency extends Controller
{
    public function showCurrency()
    {
        return view('currency-convert');
    }

    public function convertCurrency(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
        ], [
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be at least 0.01.',
            'from.required' => 'Source currency is required.',
            'to.required' => 'Target currency is required.',
        ]);

        $amount = $request->amount;
        $from = strtoupper($request->from);
        $to = strtoupper($request->to);

        $converted = null;
        $rate = null;
        $error = null;

        if ($from === $to) {
            $converted = $amount;
            $rate = 1;
        } else {
            // Fetch EUR-based rates
            $response = Http::get("https://data.fixer.io/api/latest", [
                'access_key' => env('FIXER_API_KEY'),
                'symbols' => "$from,$to",
            ]);

            if (!$response->successful() || !$response['success']) {
                $error = 'Failed to fetch exchange rates.';
            } else {
                $rates = $response['rates'];

                // Validate currency support
                if (!isset($rates[$from]) || !isset($rates[$to])) {
                    $error = "One of the currencies ($from or $to) is not supported.";
                } else {
                    // Get EUR → PHP and EUR → USD
                    $eurToFrom = $rates[$from];
                    $eurToTo = $rates[$to];

                    // Convert using cross-rate
                    $inEur = $amount / $eurToFrom;
                    $converted = round($inEur * $eurToTo, 2);
                    $rate = round($eurToTo / $eurToFrom, 4);
                }
            }
        }

        return view('currency-convert', compact('amount', 'from', 'to', 'converted', 'rate', 'error'));
    }
}