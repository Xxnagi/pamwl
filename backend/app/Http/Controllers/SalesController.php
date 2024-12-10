<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class SalesController extends Controller
{

    public function addSales(Request $request)
    {
        try {
            $jenisTransaksi = $request->input('jenis_transaksi', 'Penjualan');

            // Inisialisasi total penjualan
            $totalTransaction = 0;

            // Array untuk menyimpan ID transaksi produk
            $transactionIds = [];

            // Proses setiap produk yang dibeli
            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);

                if (!$product) {
                    return response()->json(['message' => 'Product with ID ' . $productData['product_id'] . ' not found'], 404);
                }

                // Cek apakah stok cukup
                if ($product->stock < $productData['quantity']) {
                    return response()->json([
                        'message' => 'Stok tidak cukup untuk produk dengan ID ' . $productData['product_id']
                    ], 400);
                }

                // Hitung total untuk produk tersebut
                $total = $product->price * $productData['quantity'];
                $totalTransaction += $total;

                // Kurangi stok produk
                $product->decrement('stock', $productData['quantity']);

                // Buat transaksi untuk setiap produk
                $transaction = Transaction::create([
                    'quantity' => $productData['quantity'],
                    'total' => $total,
                    'transaction_date' => $request->transaction_date,
                    'jenis_transaksi' => $jenisTransaksi,
                    'product_id' => $productData['product_id'],
                    'admin_id' => 1
                ]);

                // Simpan ID transaksi untuk nanti di tabel Sales
                $transactionIds[] = $transaction->transaction_id;
            }

            // Buat sales yang mengacu pada transaksi yang telah dibuat
            $sales = Sales::create([
                'customer_id' => $request->sales['customer_id'],
                'tanggal_penjualan' => $request->transaction_date,
                'total_penjualan' => $totalTransaction,
            ]);

            // Return hasil penjualan
            return response()->json(['success' => true, 'sales' => $sales], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showSales()
    {
        $sales = Sales::all();
        return response()->json($sales, 200);
    }
}
