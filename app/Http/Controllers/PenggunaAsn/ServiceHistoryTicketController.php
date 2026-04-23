<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceHistoryTicketController extends Controller
{
    
    public function index(Request $request)
    {
        
        $query = Tiket::with('layanan')
            ->where('users_id', Auth::id())
            ->where('status', 'selesai');

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('no_tiket', 'like', '%' . $search . '%')
                  ->orWhereHas('layanan', function($qLayanan) use ($search) {
                      $qLayanan->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        $tickets = $query->latest('updated_at')->paginate(10);

        return view('pages.pengguna-asn.history_ticket.index', compact('tickets'));
    }
}