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
            $product = Product::find($request->product_id);

            // Cek apakah stok produk cukup
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'message' => 'Stok tidak cukup untuk transaksi ini.'
                ], 400);
            }
            $product->decrement('stock', $request->quantity);

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'total' => $request->total,
                'transaction_date' => $request->transaction_date,
                'jenis_transaksi' => $jenisTransaksi,
                'product_id' => $request->product_id,
                'admin_id' => 1
            ]);
            $transactionId = $transaction->transaction_id;
            $sales = Sales::create([
                'transaction_id' => $transactionId,
                'customer_id' => $request->sales['customer_id'],
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'total_penjualan' => $request->total,
            ]);

            $product = Product::find($request->product_id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $product->update([
                'stock' => $product->stock - $request->quantity
            ]);

            // Return the created sales or a success message
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
