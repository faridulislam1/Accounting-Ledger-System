<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class LedgerService
{
    /**
     * @param Transaction $transaction
     * @return Account
     */
    public function updateBalance(Transaction $transaction): Account
    {
        $account = $transaction->account;

        $amount = $transaction->amount;
        $type = $transaction->type;

        DB::transaction(function () use ($account, $amount, $type) {
            $currentBalance = $account->balance;

            if ($type === 'debit') {
                $newBalance = $currentBalance + $amount;
            } elseif ($type === 'credit') {
                $newBalance = $currentBalance - $amount;
            } else {
                // Invalid type handling (optional: throw exception)
                $newBalance = $currentBalance;
            }

            $account->balance = $newBalance;
            $account->save();
        });

        return $account->refresh();
    }
    
    /**
     * @param int $accountId
     * @param string $type
     * @param float $amount
     * @param string|null $note
     * @return Transaction
     */
     public function addTransaction(int $accountId, string $type, float $amount, ?string $note = null): Transaction
     {
        $account = Account::findOrFail($accountId);
        
        $transaction = $account->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'note' => $note,
        ]);

        $this->updateBalance($transaction);

        return $transaction;
     }

     /**
     * @param int $accountId
     * @return array
     */
    public function generateReport(int $accountId): array
    {
        $account = Account::findOrFail($accountId);

        $totalDebit = $account->transactions()
            ->where('type', 'debit')
            ->sum('amount');

        $totalCredit = $account->transactions()
            ->where('type', 'credit')
            ->sum('amount');
        $currentBalance = $account->balance; 

        return [
            'account_id' => $account->id,
            'account_name' => $account->name,
            'total_debit' => (float) $totalDebit,
            'total_credit' => (float) $totalCredit,
            'current_balance' => (float) $currentBalance,
        ];
    }
}