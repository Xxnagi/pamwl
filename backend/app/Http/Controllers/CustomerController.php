<?php

namespace App\Http\Controllers;

use App\Models\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAllCustomer(){
        $customer = Customer::all();
        return response()->json($customer, 200);
    }
    public function addCustomer(Request $request) {
        try {
            $validator = $request->validate([
                'customer_name'=> 'required',
                'address'=> 'required',
                'contact'=> 'required'
            ]);

            $customer = Customer::create([
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'contact' => $request->contact
            ]);

            // Return the created supplier or a success message
            return response()->json(['success' => true, 'customer' => $customer], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function updateCustomer(Request $request,$id) {
        try {
            $validator = $request->validate([
                'customer_name'=> 'required',
                'address'=> 'required',
                'contact'=> 'required'
            ]);
            $customer= Customer::find($id);
            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $customer->update([
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'contact' => $request->contact
            ]);

            // Return the created supplier or a success message
            return response()->json(['success' => true, 'customer' => $customer], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteCustomer($id) {
        $customer = Customer::find($id);

        // Check if the customer exists
        if ($customer) {
            $customer->delete(); // Delete the customer
            return response()->json(['message' => 'customer deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'customer not found.'], 404);
        }
    }
}
