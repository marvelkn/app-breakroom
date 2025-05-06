@extends('admin.layout.app')

@section('title', 'Create New Voucher')

@section('content')

<div class="create-table-container w-75 mb-3" style="margin: auto; background-color:rgb(177, 159, 255); padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Voucher</h1>
    <form class="form" action="/admin/voucher/create_voucher" method="post">
        @csrf
        <label for="name" class="form-label">Voucher Name</label> 
        <input class="form-control" type="text" name="name" id="name" required><br />
    
        <label for="description" class="form-label">Description</label> 
        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
        <br />

        <label for="voucher_type" class="form-label">Voucher Type</label> 
        <select name="voucher_type" id="voucher_type" class="form-select" required>
            <option value="table_discount">Table Discount</option>
            <option value="food_discount">Food & Drink Discount</option>
            <option value="product_discount">Product Discount</option>
        </select>
        <br />

        <label for="discount_type" class="form-label">Discount Type</label> 
        <select name="discount_type" id="discount_type" class="form-select" required>
            <option value="percentage">Percentage (5%, 10%, ...)</option>
            <option value="fixed">Fixed Amount (Rp. 5000, Rp. 10000, ...)</option>
        </select>
        <br />

        <label for="discount_value" class="form-label">Discount Value</label> 
        <input class="form-control" type="number" name="discount_value" id="discount_value" required>
        <small class="text-muted">For percentage: enter number between 1-100. For fixed: enter amount in Rupiah</small>
        <br /><br />

        <label for="points_required" class="form-label">Points Required</label> 
        <input class="form-control" type="number" name="points_required" id="points_required" required><br />

        <label for="min_purchase" class="form-label">Minimum Purchase (optional)</label> 
        <input class="form-control" type="number" name="min_purchase" id="min_purchase"><br />

        <label for="max_discount" class="form-label">Maximum Discount (optional)</label> 
        <input class="form-control" type="number" name="max_discount" id="max_discount"><br />

        <label for="validity_days" class="form-label">Validity Period (days)</label> 
        <input class="form-control" type="number" name="validity_days" id="validity_days" required><br />

        <label for="stock" class="form-label">Stock</label> 
        <input class="form-control" type="number" name="stock" id="stock" value="-1" required>
        <small class="text-muted">Enter -1 for unlimited stock</small>
        <br /><br />

        <label for="is_active" class="form-label">Status</label> 
        <select name="is_active" id="is_active" class="form-select" required>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <br />
        
        <button class="btn btn-primary" type="submit">Create Voucher</button>
    </form>
    <a href="/admin/vouchers" class="btn btn-info mt-3">Back to Vouchers</a>
</div>

@endsection