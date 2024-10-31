<?php

namespace App\Http\Controllers;

use App\Models\PartStock;
use App\Models\PrLogHistory;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //

    public function index()
    {
        // dd(PrLogHistory::find(18)->prTicket->ticketCode);
        return view('log', [
            'logs' => PrLogHistory::orderBy('created_at', 'desc')->get(),
            'partLogs' => PartStock::orderBy('created_at', 'desc')->get()
        ]);
    }
}
