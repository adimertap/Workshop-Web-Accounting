<?php

namespace App\Http\Middleware;

use App\Model\SingleSignOn\PaymentBengkel;
use Closure;
use Illuminate\Support\Facades\Auth;

class isAdminInventoryAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $payment_bengkel = PaymentBengkel::where('id_bengkel', Auth::user()->bengkel->id_bengkel)->orderBy('id_payment_bengkel', 'DESC')->first();
        if (Auth::user() && Auth::user()->hasRole('Aplikasi Gudang') || Auth::user()->hasRole('Aplikasi Purchasing') || Auth::user()->hasRole('Aplikasi Accounting') || Auth::user()->role == 'owner' && $payment_bengkel->status == 'lunas') {
            return $next($request);
        }
        abort(403);
    }
}
