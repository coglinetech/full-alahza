<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::where('user_id', $request->user()->id)
            ->with('registration')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'registration_id' => 'required',
            'amount' => 'required|numeric',
            'payment_type' => 'required|in:dp,full_payment,remaining',
        ]);

        $registration = Registration::where('id', $request->registration_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $orderId = 'ALZ-PAY-' . $request->registration_id . '-' . time();

        // Midtrans config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $registration->full_name,
                'phone' => $registration->phone,
            ],
            'item_details' => [
                [
                    'id' => $registration->package_id,
                    'price' => $request->amount,
                    'quantity' => 1,
                    'name' => 'Pembayaran Umroh - ' . $request->payment_type,
                ]
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $redirectUrl = 'https://app.midtrans.com/snap/v2/vtweb/' . $snapToken;

        // Save payment record
        $payment = Payment::create([
            'registration_id' => $request->registration_id,
            'user_id' => $request->user()->id,
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'status' => 'pending',
            'midtrans_order_id' => $orderId,
            'snap_token' => $snapToken,
            'snap_redirect_url' => $redirectUrl,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'payment' => $payment,
                'snap_token' => $snapToken,
                'redirect_url' => $redirectUrl,
            ]
        ]);
    }
}