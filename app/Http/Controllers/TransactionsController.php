<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'type' => 'required|in:payment,withdrawal',
        'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        'amount' => 'required|numeric|min:0.01',
        'invoice_id' => 'nullable|exists:invoices,id'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $userId = auth()->id();
    $amount = $request->amount;

    DB::beginTransaction();
    try {
        // Create the transaction
        $transaction = Transaction::create([
            'user_id' => $userId,
            'invoice_id' => $request->invoice_id,
            'type' => $request->type,
            'payment_method' => $request->payment_method,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        // Update the user's balance
        $balance = Balance::firstOrCreate(['user_id' => $userId]);

        if ($request->type === 'payment') {
            // For payments, increment balance and update invoice
            $balance->increment('balance', $amount);

            if ($request->invoice_id) {
                $invoice = Invoice::where('user_id', $userId)->findOrFail($request->invoice_id);

                // Ensure the payment covers the invoice
                if ($invoice->status === 'pending' && $amount >= $invoice->amount) {
                    $invoice->update(['status' => 'paid']);
                }
            }
        } elseif ($request->type === 'withdrawal') {
            // For withdrawals, decrement balance
            if ($balance->balance < $amount) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
            $balance->decrement('balance', $amount);
        }

        // Mark transaction as completed
        $transaction->status = 'completed';
        $transaction->save();

        DB::commit();
        return response()->json($transaction, 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Transaction failed'], 500);
    }
}

}
