<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingInvoice
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            
            // Cek apakah ada invoice pending
            $pendingInvoice = Invoice::whereHas('transaksi.membership', function($query) use ($user) {
                    $query->where('id_akun', $user->id_akun);
                })
                ->where(function($query) {
                    $query->whereDoesntHave('pembayaran')
                        ->orWhereHas('pembayaran', function($q) {
                            $q->where('status_pembayaran', 'pending');
                        });
                })
                ->whereHas('transaksi', function($query) {
                    $query->where('status_transaksi', 'pending');
                })
                ->latest()
                ->first();
            
            if ($pendingInvoice && !$request->routeIs('pelanggan.invoice.*')) {
                return redirect()->route('pelanggan.invoice.show', $pendingInvoice->id_invoice)
                    ->with('info', 'Anda memiliki invoice yang belum diselesaikan.');
            }
        }
        
        return $next($request);
    }
}