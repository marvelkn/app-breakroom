<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function adminIndex()
    {
        //
        $vouchers = Voucher::orderBy('id', 'asc')->get();
        return view('admin.voucher.index', ['vouchers' => $vouchers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function create_voucher()
    {
        //
        return view('admin.voucher.create_voucher');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'voucher_type' => 'required|in:table_discount,food_discount,product_discount',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|integer|min:1',
            'points_required' => 'required|integer|min:0',
            'min_purchase' => 'nullable|integer|min:0',
            'max_discount' => 'nullable|integer|min:0',
            'validity_days' => 'required|integer|min:1',
            'stock' => 'required|integer|min:-1',
            'is_active' => 'required|boolean'
        ]);

        // Additional validation for percentage discount
        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()
                ->withInput()
                ->withErrors(['discount_value' => 'Percentage discount cannot be more than 100%']);
        }

        try {
            // Create voucher
            $voucher = Voucher::create($validatedData);

            return redirect('/admin/vouchers')
                ->with('success', 'Voucher created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create voucher. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher, $id)
    {
        //
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', ['voucher' => $voucher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'voucher_type' => 'required|in:table_discount,food_discount,product_discount',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|integer|min:1',
            'points_required' => 'required|integer|min:0',
            'min_purchase' => 'nullable|integer|min:0',
            'max_discount' => 'nullable|integer|min:0',
            'validity_days' => 'required|integer|min:1',
            'stock' => 'required|integer|min:-1',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);

            // Additional validation for percentage discount
            if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
                return back()
                    ->withInput()
                    ->withErrors(['discount_value' => 'Percentage discount cannot be more than 100%']);
            }

            // Update voucher with validated data
            $voucher->update($validatedData);

            return redirect('/admin/vouchers')
                ->with('success', 'Voucher updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update voucher. Please try again.']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->is_active = $request->is_active;
            $voucher->save();

            return redirect()->back()->with('success', 'Voucher status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update voucher status.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
