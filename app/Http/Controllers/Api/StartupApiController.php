<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Storage;

class StartupApiController extends Controller
{
    // GET /api/startups
    public function index()
    {
        $startups = Startup::all();
        return response()->json($startups);
    }

    // POST /api/startups
    public function store(Request $request)
    {
        $data = $request->validate([
            'startup_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:startups,email',
            'phone'        => 'required|string|max:20',
            'website'      => 'nullable|url',
            'sector'       => 'required|string',
            'pitch_deck'   => 'required|file|mimes:pdf|max:20480',
        ]);

        // Store PDF
        $path = $request->file('pitch_deck')->store('pitch_decks', 'public');

        $startup = Startup::create([
            'startup_name' => $data['startup_name'],
            'founder_name' => $data['founder_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],
            'website'      => $data['website'] ?? null,
            'sector'       => $data['sector'],
            'pitch_deck_path' => $path,
            'payment_status'  => 'pending',
        ]);

        // Razorpay order
        $amountPaise = 499 * 100;
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'startup_rcpt_'.$startup->id,
            'amount' => $amountPaise,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $startup->update(['razorpay_order_id' => $order['id']]);

        return response()->json([
            'status' => 'success',
            'startup_id' => $startup->id,
            'razorpay_order_id' => $order['id'],
            'amount' => $amountPaise,
            'currency' => 'INR',
            'razorpay_key' => env('RAZORPAY_KEY')
        ], 201);
    }

    // GET /api/startups/{id}
    public function show($id)
    {
        $startup = Startup::findOrFail($id);
        return response()->json($startup);
    }

    // PUT /api/startups/{id}
    public function update(Request $request, $id)
    {
        $startup = Startup::findOrFail($id);

        $data = $request->validate([
            'startup_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:startups,email,'.$id,
            'phone'        => 'required|string|max:20',
            'website'      => 'nullable|url',
            'sector'       => 'required|string',
            'pitch_deck'   => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('pitch_deck')) {
            if ($startup->pitch_deck_path) {
                Storage::disk('public')->delete($startup->pitch_deck_path);
            }
            $data['pitch_deck_path'] = $request->file('pitch_deck')->store('pitch_decks', 'public');
        }

        $startup->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Startup updated successfully',
            'startup' => $startup
        ]);
    }

    // DELETE /api/startups/{id}
    public function destroy($id)
    {
        $startup = Startup::findOrFail($id);

        if ($startup->pitch_deck_path) {
            Storage::disk('public')->delete($startup->pitch_deck_path);
        }

        $startup->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Startup deleted successfully'
        ]);
    }

    // POST /api/startups/verify-payment
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'startup_id' => 'required|integer|exists:startups,id',
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $startup = Startup::findOrFail($request->startup_id);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            $startup->update([
                'payment_status' => 'paid',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'amount_paid' => 499 * 100
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment verified successfully']);
        } catch (\Exception $e) {
            $startup->update(['payment_status' => 'failed']);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
