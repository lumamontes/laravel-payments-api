<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{user_id}/invoices', function ($user_id) {
    $invoices = App\Models\Invoice::where('user_id', $user_id)->get();
    return response()->json($invoices);
});
