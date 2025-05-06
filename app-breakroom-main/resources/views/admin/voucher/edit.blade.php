@extends('admin.layout.app')

@section('title', 'Edit Voucher - ' . $voucher->name)

@section('content')
<div class="edit-table-container w-50" style="margin: auto; background-color: #BDCBFF; padding: 20px; border-radius: 10px">
    <h1 class="text-center font-bold text-2xl">Edit Voucher: {{$voucher->name}}</h1>
    <br />
    <form class="form" method="POST" action="/admin/voucher/{{ $voucher->id }}">
        @csrf
        @method('PUT')

        <label for="name" class="form-label">Voucher Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="{{ $voucher->name }}" required>
        <br />

        <label for="description" class="form-label">Description</label> 
        <textarea class="form-control" name="description" id="description" rows="3" required>{{ $voucher->description }}</textarea>
        <br />

        <label for="voucher_type" class="form-label">Voucher Type</label> 
        <select name="voucher_type" id="voucher_type" class="form-select" required>
            <option value="table_discount" {{ $voucher->voucher_type === 'table_discount' ? 'selected' : '' }}>Table Discount</option>
            <option value="food_discount" {{ $voucher->voucher_type === 'food_discount' ? 'selected' : '' }}>Food & Drink Discount</option>
            <option value="product_discount" {{ $voucher->voucher_type === 'product_discount' ? 'selected' : '' }}>Product Discount</option>
        </select>
        <br />

        <label for="discount_type" class="form-label">Discount Type</label> 
        <select name="discount_type" id="discount_type" class="form-select" required>
            <option value="percentage" {{ $voucher->discount_type === 'percentage' ? 'selected' : '' }}>Percentage</option>
            <option value="fixed" {{ $voucher->discount_type === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
        </select>
        <br />

        <label for="discount_value" class="form-label">Discount Value</label> 
        <input class="form-control" type="number" name="discount_value" id="discount_value" value="{{ $voucher->discount_value }}" required>
        <small class="text-muted">For percentage: enter number between 1-100. For fixed: enter amount in Rupiah</small>
        <br /><br />

        <label for="points_required" class="form-label">Points Required</label> 
        <input class="form-control" type="number" name="points_required" id="points_required" value="{{ $voucher->points_required }}" required>
        <br />

        <label for="min_purchase" class="form-label">Minimum Purchase (optional)</label> 
        <input class="form-control" type="number" name="min_purchase" id="min_purchase" value="{{ $voucher->min_purchase }}">
        <br />

        <label for="max_discount" class="form-label">Maximum Discount (optional)</label> 
        <input class="form-control" type="number" name="max_discount" id="max_discount" value="{{ $voucher->max_discount }}">
        <br />

        <label for="validity_days" class="form-label">Validity Period (days)</label> 
        <input class="form-control" type="number" name="validity_days" id="validity_days" value="{{ $voucher->validity_days }}" required>
        <br />

        <label for="stock" class="form-label">Stock</label> 
        <input class="form-control" type="number" name="stock" id="stock" value="{{ $voucher->stock }}" required>
        <small class="text-muted">Enter -1 for unlimited stock</small>
        <br /><br />

        <button type="submit" class="btn btn-primary">Update Voucher</button>
    </form>
    <a href="/admin/vouchers" class="btn btn-info mt-3">Back to Vouchers List</a>
</div>
@endsection