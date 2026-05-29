<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Services\WalletService;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $wallet = $request->user()->wallet;

        $wallet = $this->walletService->deposit(
            $wallet,
            $request->amount
        );

        return response()->json([
            'success' => true,
            'message' => 'Depósito realizado com sucesso',
            'data' => $wallet
        ]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $wallet = $request->user()->wallet;

        $wallet = $this->walletService->withdraw(
            $wallet,
            $request->amount
        );

        return response()->json([
            'success' => true,
            'message' => 'Saque realizado com sucesso',
            'data' => $wallet
        ]);
    }
}
