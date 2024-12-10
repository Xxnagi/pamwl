<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function addPurchase(Request $request)
    {
        try {
            $jenisTransaksi = $request->input('jenis_transaksi', 'Pembelian');

            // Inisialisasi total pembelian
            $totalTransaction = 0;

            // Array untuk menyimpan ID transaksi produk
            $transactionIds = [];

            // Proses setiap produk
            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);

                if (!$product) {
                    return response()->json(['message' => 'Product with ID ' . $productData['product_id'] . ' not found'], 404);
                }

                // Hitung total untuk produk tersebut
                $total = $product->price * $productData['quantity'];
                $totalTransaction += $total;

                // Update stok produk
                $product->increment('stock', $productData['quantity']);

                // Buat transaksi untuk setiap produk
                $transaction = Transaction::create([
                    'quantity' => $productData['quantity'],
                    'total' => $total,
                    'transaction_date' => $request->transaction_date,
                    'jenis_transaksi' => $jenisTransaksi,
                    'product_id' => $productData['product_id'],
                    'admin_id' => 1
                ]);

                // Simpan ID transaksi untuk nanti di tabel Purchase
                $transactionIds[] = $transaction->transaction_id;
            }

            // Buat purchase yang mengacu pada transaksi yang telah dibuat
            $purchase = Purchase::create([
                'supplier_id' => $request->purchase['supplier_id'],
                'tanggal_pembelian' => $request->transaction_date,
                'total_pembelian' => $totalTransaction,
            ]);

            // Return hasil pembelian
            return response()->json(['success' => true, 'purchase' => $purchase], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showAll()
    {
        $purchases = Purchase::all();
        return response()->json($purchases, 200);
    }

    public function getTotalPurchases()
    {
        $totalPurchase = Purchase::sum('total_pembelian');
        return response()->json(['total_pembelian' => $totalPurchase], 200);
    }
}
