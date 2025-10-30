<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mini Ledger System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">Account Balances 💰</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @foreach ($accounts as $account)
                        <div class="bg-indigo-100 p-4 rounded-lg shadow">
                            <p class="font-semibold text-indigo-700">{{ $account->name }}</p>
                            <p class="text-2xl font-extrabold text-indigo-900">
                                ${{ number_format($account->balance, 2) }}
                            </p>
                            <a href="{{ route('ledger.report', $account->id) }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">View Report</a>
                        </div>
                    @endforeach
                </div>

                <h3 class="text-lg font-bold mb-4">Record New Transaction 📝</h3>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                <form action="{{ route('ledger.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="account_id" :value="__('Account')" />
                        <select name="account_id" id="account_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Transaction Type')" />
                        <select name="type" id="type" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <option value="debit">Debit (Increase Balance ⬆️)</option>
                            <option value="credit">Credit (Decrease Balance ⬇️)</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="note" :value="__('Note')" />
                        <x-text-input id="note" class="block mt-1 w-full" type="text" name="note" :value="old('note')" />
                        <x-input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Record Transaction') }}
                        </x-primary-button>
                    </div>
                </form>

                <hr class="my-8">

                <h3 class="text-lg font-bold mb-4">Recent Transactions 📜</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->account->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'debit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->note ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>