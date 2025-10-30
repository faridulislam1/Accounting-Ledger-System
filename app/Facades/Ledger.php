<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Transaction addTransaction(int $accountId, string $type, float $amount, string|null $note = null)
 * @see \App\Services\LedgerService
 */
class Ledger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ledger';
    }
}