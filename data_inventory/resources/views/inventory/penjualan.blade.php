<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function updateTotalPrice() {
            var price = document.getElementById('price').value;
            var stock = document.getElementById('stock').value;
            var total_price = price * stock;

            document.getElementById('total_price').value = total_price;
            document.getElementById('formatted_total_price').innerText = formatRupiah(total_price, 'Rp.');
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-4">Penjualan</h2>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
            <form method="POST"
                action="{{ route('inventory.update', ['inventory' => old('inventory_id') ?: $inventory->first()->inventory_id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="inventory_id" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <select name="inventory_id" id="inventory_id"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300" onchange="updatePriceAndStock()"
                        required>
                        @foreach ($inventory as $inventories)
                            <option value="{{ $inventories->inventory_id }}" data-price="{{ $inventories->price }}"
                                data-stock="{{ $inventories->stock }}">
                                {{ $inventories->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="inventory_id" id="selected_inventory_id">
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300" required oninput="updateTotalPrice()">
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300" value="5" required
                        oninput="updateTotalPrice()">
                </div>
                <div class="mb-4">
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input type="number" name="total_price" id="total_price"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300" readonly>
                    <span id="formatted_total_price" class="block mt-2 text-lg text-gray-800 font-semibold"></span>
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Jual</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    function updatePriceAndStock() {
        var inventorySelect = document.getElementById('inventory_id');
        var selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        var stock = selectedOption.getAttribute('data-stock');
        var inventoryId = selectedOption.value;

        document.getElementById('price').value = price;
        document.getElementById('stock').max = stock;
        document.getElementById('selected_inventory_id').value = inventoryId;
        updateTotalPrice();
    }
</script>


</html>
