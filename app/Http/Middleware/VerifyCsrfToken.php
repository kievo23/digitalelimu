<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	'api/payments','api/readBook','api/registerUser','api/stkpush','api/stkresponse/*','/api/stkloadwalletresponse','/api/walletstkpush'
        //
    ];
}
