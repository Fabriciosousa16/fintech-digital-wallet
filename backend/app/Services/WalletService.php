<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Exception;

class WalletService
{
    public function deposit(Wallet $wallet, float $amount): Wallet
    {
        if ($amount <= 0) {
            throw new Exception("Valor de depósito inválido");
        }

        return DB::transaction(function () use ($wallet, $amount) {

            $wallet->balance += $amount;
            $wallet->save();

            $wallet->transactions()->create([
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $wallet->balance,
            ]);

            return $wallet;
        });
    }

    public function withdraw(Wallet $wallet, float $amount): Wallet
    {
        if ($amount <= 0) {
            throw new Exception("Valor de saque inválido");
        }

        if ($wallet->balance < $amount) {
            throw new Exception("Saldo insuficiente");
        }

        return DB::transaction(function () use ($wallet, $amount) {

            $wallet->balance -= $amount;
            $wallet->save();

            $wallet->transactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $wallet->balance,
            ]);

            return $wallet;
        });
    }
}
