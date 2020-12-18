<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Stripe\Customer;
use Stripe\Stripe;

class SendInvoiceMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $paypal_sub = null;
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $auth = Auth::user();
        $customer = Customer::retrieve($auth->stripe_id);
        $invoice = $customer->invoices();

        return $this->view('user.invoice', compact('invoice', 'paypal_sub'));
    }
}
