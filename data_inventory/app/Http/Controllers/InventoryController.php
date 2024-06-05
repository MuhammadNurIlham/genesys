<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Menambahkan middleware auth untuk memastikan pengguna sudah login
    }

    // Method untuk menampilkan form create inventory
    public function index()
    {
        $inventory = Inventory::all();
        return view('inventory.index', compact('inventory'));
    }

    public function showFormBuying()
    {
        return view('inventory.pembelian');
    }

    // public function showFormSelling()
    // {
    //     return view('inventory.penjualan');
    // }

    public function showFormSelling($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.penjualan', compact('inventory'));
    }

    // Menyimpan inventaris baru ke database
    public function store(Request $request)
    {
        // Validasi Auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        Log::info('Store Pembelian Request:', $request->all());

        // Validasi Form
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        // Hitung total price di server
        $total_price = $request->price * $request->stock;

        try {
            // Simpan inventaris baru
            Inventory::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'total_price' => $total_price,
            ]);

            Log::info('Pembelian berhasil ditambahkan.');

            return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menambahkan pembelian:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan pembelian.']);
        }
    }

    // Memperbarui inventaris di database
    public function update(Request $request, $id)
    {
        // Validasi Auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi Form
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'total_price' => 'required|integer',
        ]);

        try {
            // Cari inventaris berdasarkan id
            $inventory = Inventory::findOrFail($id);

            // Kurangi stok sesuai dengan jumlah penjualan
            $newStock = $inventory->stock - $request->stock;

            // Pastikan stok tidak menjadi negatif
            if ($newStock < 0) {
                return back()->withErrors(['error' => 'Stok tidak mencukupi.']);
            }

            // Update inventaris
            $inventory->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $newStock,
                'total_price' => $request->total_price,
            ]);

            Log::info('Penjualan berhasil diupdate.');

            return redirect()->route('inventory.index')->with('success', 'Data penjualan berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengupdate penjualan:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate penjualan.']);
        }
    }

    // Menghapus inventaris dari database
    public function destroy($id)
    {
        // Validasi Auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Hapus inventaris
        Inventory::find($id)->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}
