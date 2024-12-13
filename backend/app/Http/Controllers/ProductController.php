<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
                'product_name' => 'required',
                'price' => 'required|numeric',
                'product_description' => 'required',
                'category_id' => 'required|exists:categories,category_id',
                'supplier_name' => 'required',
                'supplier_contact' => 'required',
            ]);

            $supplier = Supplier::firstOrCreate(
                ['supplier_name' => $request['supplier_name']],
                ['supplier_contact' => $request['supplier_contact']]
            );

            // Gunakan create untuk Product
            return Product::create([
                'product_name' => $request['product_name'],
                'price' => $request['price'],
                'product_description' => $request['product_description'],
                'stock' => $request['stock'] ?? 0,
                'category_id' => $request['category_id'],
                'supplier_id' => $supplier->supplier_id,
            ]);


            return response()->json(['success' => true, 'message' => 'Products and suppliers added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // public function addProduct(Request $request)
    // {
    //     try {
    //         $validator = $request->validate([
    //             'product_name' => 'required',
    //             'price' => 'required',
    //             'product_description' => 'required',
    //             'stock' => 'required',
    //             'category_id' => 'required',
    //             'supplier_id' => 'required'
    //         ]);

    //         $product = Product::create([
    //             'product_name' => $request->product_name,
    //             'price' => $request->price,
    //             'product_description' => $request->product_description,
    //             'stock' => $request->stock,
    //             'category_id' => $request->category_id,
    //             'supplier_id' => $request->supplier_id
    //         ]);

    //         // Return the created product or a success message
    //         return response()->json(['success' => true, 'product' => $product], 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }


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
