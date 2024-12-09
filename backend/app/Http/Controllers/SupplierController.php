<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function getAllSuppliers()
    {
        $supplier = Supplier::all();
        return response()->json($supplier, 200);
    }

    public function addSupplier(Request $request)
    {
        try {
            $request->validate([
                'supplier_name' => 'required',
                'supplier_contact' => 'required',
            ]);

            $supplier = Supplier::create([
                'supplier_name' => $request->supplier_name,
                'supplier_contact' => $request->supplier_contact,

            ]);

            // Return the created supplier or a success message
            return response()->json(['success' => true, 'supplier' => $supplier], 201);
        } catch (\Exception $e) {
            return response()->json(['fail' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateSupplier(Request $request, $id)
    {
        try {
            $request->validate([
                'supplier_name' => 'required',
                'supplier_contact' => 'required',
            ]);

            $supplier = Supplier::find($id);

            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }

            $supplier->update([
                'supplier_name' => $request->supplier_name,
                'supplier_contact' => $request->supplier_contact,
            ]);

            return response()->json([
                'message' => 'Supplier updated successfully',
                'supplier' => $supplier,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);

        // Check if the supplier exists
        if ($supplier) {
            $supplier->delete(); // Delete the supplier
            return response()->json(['message' => 'supplier deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'supplier not found.'], 404);
        }
    }
}
