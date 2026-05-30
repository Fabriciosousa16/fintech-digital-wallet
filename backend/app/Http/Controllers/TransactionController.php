<?php

namespace App\Http\Controllers;
use App\Services\TransactionService;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionService->getUserTransactions(
            $request->user(),
            $request->only([
                'type',
                'start_date',
                'end_date'
            ])
        );

        return response()->json($transactions);
    }
}
