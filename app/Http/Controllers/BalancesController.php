<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalancesController extends Controller
{
    public function show()
    {
        $balance = auth()->user()->balance;
        return response()->json([
            'balance' => $balance->balance ?? 0
        ]);
    }
}
