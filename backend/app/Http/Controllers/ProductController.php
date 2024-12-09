<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function getAvailableProducts()
    {
        $products = Product::where('stock', '>', 0)->get();
        return response()->json($products, 200);
    }

    public function getProductsByCategory($id)
    {
        try {
            $category = Category::with('products')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found.',
                ], 404);
            }

            return response()->json([
                'message' => 'Products retrieved successfully.',
                'category' => $category->category_name,
                'products' => $category->products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getProductsBySupplier($id)
    {
        try {
            $supplier = Supplier::with('products')->find($id);

            if (!$supplier) {
                return response()->json([
                    'message' => 'Supplier not found.',
                ], 404);
            }

            return response()->json([
                'message' => 'Products retrieved successfully.',
                'supplier' => $supplier->supplier_name,
                'products' => $supplier->products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function addProduct(Request $request)
    {
        try {
            $validator = $request->validate([
                'products' => 'required|array',
                'products.*.product_name' => 'required',
                'products.*.price' => 'required|numeric',
                'products.*.product_description' => 'required',
                'products.*.stock' => 'required|integer',
                'products.*.category_id' => 'required|exists:categories,category_id',
                'products.*.supplier_id' => 'required|exists:suppliers,supplier_id',
            ]);

            // Prepare the products for insertion
            $products = collect($request->products)->map(function ($product) {
                return [
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'product_description' => $product['product_description'],
                    'stock' => $product['stock'],
                    'category_id' => $product['category_id'],
                    'supplier_id' => $product['supplier_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            // Insert the products in bulk
            Product::insert($products->toArray());

            return response()->json(['success' => true, 'message' => 'Products added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'product_name' => 'required',
                'price' => 'required',
                'description' => 'required',
                'stock' => 'required',
                'category_id' => 'required',
                'supplier_id' => 'required'
            ]);

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $product->update([
                'product_name' => $request->product_name,
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id
            ]);

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        // Check if the product exists
        if ($product) {
            $product->delete(); // Delete the product
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }
}
