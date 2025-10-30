<?php

namespace App\Http\Controllers;

use App\Facades\Ledger;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $transactions = Transaction::with('account')->latest()->limit(10)->get();

        return view('ledger.index', compact('accounts', 'transactions'));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        Ledger::addTransaction(
            $validated['account_id'],
            $validated['type'],
            $validated['amount'],
            $validated['note']
        );

        return redirect()->route('ledger.index')->with('success', 'Transaction successful and balance updated!');
    }

    public function report($accountId)
    {
        try {
            $reportData = Ledger::getFacadeRoot()->generateReport((int) $accountId);
            $transactions = Account::findOrFail($accountId)->transactions()->latest()->get(); // সব Transaction
            return view('ledger.report', compact('reportData', 'transactions'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Account not found'], 404);
        }
    }
}