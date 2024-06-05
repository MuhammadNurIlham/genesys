<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function formatRupiah(angka, prefix) {
            let number_string = angka.toString().replace(/^0+/, '').replace(/[^0-9]/g, '');
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return (prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : ''));
        }

        function updateTotalPrice() {
            let price = document.getElementById('price').value;
            let stock = document.getElementById('stock').value;
            let total_price = price * stock;

            document.getElementById('total_price').value = total_price;
            document.getElementById('formatted_total_price').innerText = formatRupiah(total_price, 'Rp.');
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-4">Penjualan</h2>
        @if (empty($inventories))
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Data tidak ditemukan</h3>
            </div>
        @else
            @foreach ($inventories as $inventory)
                @if ($inventory->exists())
                    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                        <form method="POST" action="{{ route('update', ['id' => $inventory->id]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label for="inventory_id" class="block text-sm font-medium text-gray-700">Nama
                                    Produk</label>
                                <select name="inventory_id" id="inventory_id"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300" required disabled>
                                    <option value="{{ $inventory->id }}" selected>{{ $inventory->name }}</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="current_stock" class="block text-sm font-medium text-gray-700">Stok Saat
                                    Ini</label>
                                <input type="number" name="current_stock" id="current_stock"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300" readonly
                                    value="{{ $inventory->stock }}">
                            </div>
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Harga
                                    Satuan</label>
                                <input type="number" name="price" id="price"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300" readonly
                                    value="{{ $inventory->price }}">
                            </div>
                            <div class="mb-4">
                                <label for="stock" class="block text-sm font-medium text-gray-700">Jumlah
                                    Penjualan</label>
                                <input type="number" name="stock" id="stock"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300" required
                                    oninput="updateTotalPrice()" value="1" min="1">
                            </div>
                            <div class="mb-4">
                                <label for="total_price" class="block text-sm font-medium text-gray-700">Total
                                    Harga</label>
                                <input type="number" name="total_price" id="total_price"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300" readonly>
                                <span id="formatted_total_price"
                                    class="block mt-2 text-lg text-gray-800 font-semibold"></span>
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Jual</button>
                            </div>
                        </form>
                    </div>
                @endif
            @endforeach
        @endif

    </div>

    <script>
        const inventorySelect = document.getElementById('inventory_id');
        const priceInput = document.getElementById('price');

        inventorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            priceInput.value = selectedOption.dataset.price;
            updateTotalPrice();
        });
    </script>
</body>

</html>
