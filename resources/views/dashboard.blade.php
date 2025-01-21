<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-center">Welcome, {{ $user->name }} </h1>
        
        <!-- User Balance -->
        <div class="mt-6 p-4 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold">Balance</h2>
            <p class="text-xl text-green-600 font-bold">${{ number_format($balance->balance ?? 0, 2) }}</p>
        </div>

        <!-- Last 10 Invoices -->
        <div class="mt-6 p-4 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold">Last 10 Invoices</h2>
            <table class="w-full mt-3 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">ID</th>
                        <th class="border border-gray-300 p-2">Amount</th>
                        <th class="border border-gray-300 p-2">Status</th>
                        <th class="border border-gray-300 p-2">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr class="text-center">
                        <td class="border border-gray-300 p-2">{{ $invoice->id }}</td>
                        <td class="border border-gray-300 p-2">${{ number_format($invoice->amount, 2) }}</td>
                        <td class="border border-gray-300 p-2">{{ ucfirst($invoice->status) }}</td>
                        <td class="border border-gray-300 p-2">{{ $invoice->due_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Last 10 Transactions -->
        <div class="mt-6 p-4 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold">Last 10 Transactions</h2>
            <table class="w-full mt-3 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">ID</th>
                        <th class="border border-gray-300 p-2">Type</th>
                        <th class="border border-gray-300 p-2">Amount</th>
                        <th class="border border-gray-300 p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr class="text-center">
                        <td class="border border-gray-300 p-2">{{ $transaction->id }}</td>
                        <td class="border border-gray-300 p-2">{{ ucfirst($transaction->type) }}</td>
                        <td class="border border-gray-300 p-2">${{ number_format($transaction->amount, 2) }}</td>
                        <td class="border border-gray-300 p-2">{{ $transaction->transaction_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
