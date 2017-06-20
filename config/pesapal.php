<?php
return [
    /*
     * Pesapal consumer key
     */
    'consumer_key'    => env('PESAPAL_CONSUMER_KEY','hD4FirKu1Ct09nfUeB+J7LJrg/Kt1Bbc'),
    /*
     * Pesapal consumer secret
     */
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET','5GFGPw8J+68ibOTlUETcuw7n26U='),
    /*
     * ISO code for the currency
     */
    'currency'        => env('PESAPAL_CURRENCY', 'KES'),
    /*
     * controller method to call for instant notifications IPN as relative path from App\Http\Controllers\
     * eg "TransactionController@confirmation"
     */
    'ipn'             => env('PESAPAL_IPN'),
    /*
     * Pesapal environment
     */
    'live'            => env('PESAPAL_LIVE', false),
    /*
     * Route name to handle the callback
     * eg Route::get('donepayment', ['as' => 'paymentsuccess', 'uses'=>'PaymentsController@paymentsuccess']);
     * The route name is "paymentsuccess"
     */
    'callback_route'  => env('PESAPAL_CALLBACK_ROUTE','www.yourdomain.com'),
];