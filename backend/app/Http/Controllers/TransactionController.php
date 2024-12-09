<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getAllTransaction()
    {
        $transaction = Transaction::all();
        return response()->json($transaction, 200);
    }
}
