<?php

namespace App\Services;

use App\Models\User;

class TransactionService
{
    public function getUserTransactions(User $user, array $filters = [])
    {
        $query = $user->wallet->transactions();

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query->latest()->paginate(10);
    }

}
