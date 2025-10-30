<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white-900 leading-tight">
            {{ __('Mini Ledger System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-bold text-gray-900 mb-6">Account Balances 💰</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @foreach ($accounts as $account)
                        <div class="bg-indigo-100 p-6 rounded-lg shadow hover:bg-indigo-200 transition duration-300">
                            <p class="font-bold text-black text-lg">{{ $account->name }}</p>
                            <p class="text-2xl font-extrabold text-indigo-900 mt-2">
                                ${{ number_format($account->balance, 2) }}
                            </p>
                            <a href="{{ route('ledger.report', $account->id) }}" class="text-sm text-indigo-700 hover:text-indigo-900 mt-2 inline-block font-semibold">View Report</a>
                        </div>
                    @endforeach
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-4">Record New Transaction 📝</h3>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                <form action="{{ route('ledger.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="account_id" class="font-bold text-black block mb-1">{{ __('Account') }}</label>
                        <select name="account_id" id="account_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                    </div>

                    <div>
                        <label for="type" class="font-bold text-black block mb-1">{{ __('Transaction Type') }}</label>
                        <select name="type" id="type" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <option value="debit">Debit (Increase Balance ⬆)</option>
                            <option value="credit">Credit (Decrease Balance ⬇)</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <label for="amount" class="font-bold text-black block mb-1">{{ __('Amount') }}</label>
                        <x-text-input id="amount" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="number" step="0.01" name="amount" :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div>
                        <label for="note" class="font-bold text-black block mb-1">{{ __('Note') }}</label>
                        <x-text-input id="note" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="note" :value="old('note')" />
                        <x-input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Record Transaction') }}
                        </x-primary-button>
                    </div>

                </form>

                <hr class="my-8 border-gray-300">

                <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Transactions 📜</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Account</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Note</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $transaction->account->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'debit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $transaction->note ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
