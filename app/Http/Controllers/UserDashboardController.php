<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Balance;
use Illuminate\Http\Request;


class UserDashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        // Fetch user balance
        $balance = Balance::where('user_id', $user->id)->first();

        // Fetch last 10 invoices
        $invoices = Invoice::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Fetch last 10 transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact('user', 'balance', 'invoices', 'transactions'));
    }

}
