<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('checkout');
    }

    /**
     * Process the checkout form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
            'card' => 'required|string|max:19',
            'expiry' => 'required|string|max:5',
            'cvv' => 'required|string|max:4',
        ]);

        // Process the payment (placeholder)
        // Here you would integrate with a payment gateway

        // For now, just redirect with success message
        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
