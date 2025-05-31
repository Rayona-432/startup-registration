<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use Razorpay\Api\Api;

class RegistrationController extends Controller
{
     public function index()
    {
        //$startup_list = Startup::select('startup_name')->get()->toArray();

       $startup_list = Startup::pluck('startup_name')->toArray();
$collection = collect($startup_list);
//dd($startup_list);
        if($collection->isNotEmpty()){
            $startupOptions = $startup_list;
        }else{
            $startupOptions = '';
        }

         
        $sectors = ['FinTech', 'HealthTech', 'EdTech', 'E-commerce', 'SaaS', 'AI/ML', 'Other'];

        //return view('startup.create', compact('startupOptions', 'sectors'));
        return view('registration', compact('startupOptions', 'sectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'startup_name' => 'required|string',
            'founder_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'website' => 'nullable|url',
            'sector' => 'required|string',
            'deck' => 'required|mimes:pdf|max:2048',
        ]);

        $deckPath = $request->file('deck')->store('decks', 'public');

        Startup::create([
            'startup_name' => $request->startup_name,
            'founder_name' => $request->founder_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'sector' => $request->sector,
            'deck' => $deckPath,
        ]);

        //return back()->with('success', 'Startup registered successfully!');


        // Razorpay config
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $orderData = [
                'receipt'         => 'order_rcptid_11',
                'amount'          => 49900, // amount in paise (₹499)
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ];

            $razorpayOrder = $api->order->create($orderData);

            // Pass this data to view for Razorpay checkout
            return view('payment.checkout', [
                'order' => $razorpayOrder,
                'startup' => $startup,  // optional, pass startup info
                'razorpayKey' => config('services.razorpay.key'),
                'amount' => 49900,
                'currency' => 'INR',
            ]);
    }

    public function success(Request $request)
        {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $payment = $api->payment->fetch($request->payment_id);

            // OPTIONAL: Verify payment signature here if using `checkout.js` with signature verification
            // For now, assume test environment with success callback

            // Save payment to DB
            Payment::create([
                'razorpay_payment_id' => $payment['id'],
                'razorpay_order_id'   => $payment['order_id'],
                'status'              => $payment['status'],
                'amount'              => $payment['amount'],
                'currency'            => $payment['currency'],
                'email'               => $payment['email'],
                'contact'             => $payment['contact'],
                'startup_id'          => auth()->check() ? auth()->id() : null, // Or however you relate startup
            ]);

            return view('payment.success', ['payment' => $payment]);
        }
}
