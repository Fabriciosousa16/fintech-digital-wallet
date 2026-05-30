<?php

namespace App\Services;

use App\Models\User;

class DashboardService
{

    public function getDashboardData(User $user)
    {
        $wallet = $user->wallet;

        $monthlyDeposits = $wallet->transactions()
            ->where('type', 'credit')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $monthlyWithdrawals = $wallet->transactions()
            ->where('type', 'debit')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $lastTransactions = $wallet->transactions()
            ->latest()
            ->take(5)
            ->get();

        return [
            'current_balance' => $wallet->balance,
            'monthly_deposits' => number_format($monthlyDeposits, 2, '.', ''),
            'monthly_withdrawals' => number_format($monthlyWithdrawals, 2, '.', ''),
            'last_transactions' => $lastTransactions,
        ];
    }

}
