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
        $this->middleware('auth'); // adding middleware auth for make sure user is login
    }

    // Method for showing form create inventory
    public function index()
    {
        $inventory = Inventory::all();
        return view('inventory.index', compact('inventory'));
    }

    public function showFormBuying()
    {
        return view('inventory.pembelian');
    }

    public function showFormSelling()
    {
        $inventory = Inventory::all();
        return view('inventory.penjualan', compact('inventory'));
    }



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

    public function update(Request $request, $inventory_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'price' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        try {
            $inventory = Inventory::findOrFail($inventory_id);

            $newStock = $inventory->stock - $request->stock;

            // make sure stock not become is negative value
            if ($newStock < 0) {
                return back()->withErrors(['error' => 'Stock tidak mencukupi.']);
            }

            // Update Inventory
            $inventory->update([
                'stock' => $newStock,
            ]);

            Log::info('Penjualan berhasil diupdate.');

            return redirect()->route('inventory.index')->with('success', 'Data penjualan berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengupdate penjualan:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate penjualan.']);
        }
    }




    // delete data inventory from database
    public function destroy($id)
    {
        // Validate Auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Delete inventaris
        Inventory::find($id)->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}
