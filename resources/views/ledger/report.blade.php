<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ledger Report for ') . $reportData['account_name'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-indigo-800">Summary Report 📊</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-green-50 p-6 rounded-lg shadow">
                            <p class="text-sm font-medium text-gray-600">Total Debit (Increases) ⬆️</p>
                            <p class="text-3xl font-extrabold text-green-700 mt-1">${{ number_format($reportData['total_debit'], 2) }}</p>
                        </div>
                        <div class="bg-red-50 p-6 rounded-lg shadow">
                            <p class="text-sm font-medium text-gray-600">Total Credit (Decreases) ⬇️</p>
                            <p class="text-3xl font-extrabold text-red-700 mt-1">${{ number_format($reportData['total_credit'], 2) }}</p>
                        </div>
                        <div class="bg-blue-100 p-6 rounded-lg shadow">
                            <p class="text-sm font-medium text-gray-800">Current Balance 💰</p>
                            <p class="text-3xl font-extrabold text-blue-900 mt-1">${{ number_format($reportData['current_balance'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-8">

                <h3 class="text-lg font-bold mb-4">Transaction History 📜</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'debit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->note ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No transactions recorded for this account.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>