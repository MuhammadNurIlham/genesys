<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Master Data Inventory</h2>
            <div>
                <a href="{{ route('buying') }}"
                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg">Pembelian</a>
                <a href="{{ route('selling') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Penjualan</a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($inventory->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Data not found</h3>
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                total_price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($inventory as $inventories)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventories->inventory_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventories->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventories->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventories->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventories->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>

</html>
