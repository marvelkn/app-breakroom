<?php

// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::where('status', 'Available')
        ->orderBy('created_at', 'desc')
        ->paginate(12); // 12 items per page
        
    foreach ($products as $product) {
        $product->image_url = Storage::url($product->image);
    }
    
    return view('user.products.index', compact('products'));
}

    public function details($id)
    {
        //mencari produk berdasarkan id
        $product = Product::findOrFail($id);

        //mengambil url gambar dari storage
        $image = Storage::url($product->image);

        //mengirim data ke view user
        return view('user.products.details', [
            'product' => $product,
            'image' => $image
        ]);
    }

    public function adminIndex()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->image_url = Storage::url($product->image);
        }
        return view('admin.product.index', compact('products'));
    }

    public function show($id)
    {
        //
        $product = Product::findOrFail($id);
        $image = Storage::url($product->image);
        return view('admin.product.show', [
            'product' => $product,
            'image' => $image
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            // 'category' => 'required|in:food,drink,merchandise',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $path = $request->file(key: 'image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $validatedData['image'] = $path;
        Product::create($validatedData);

        return redirect()->route('admin.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        $image = Storage::url($product->image);
        return view('admin.product.edit', ['product' => $product, 'image' => $image]);
    }

    public function changeImage($id)
    {
        //
        $product = Product::findOrFail($id);
        $image = Storage::url($product->image);
        return view('admin.product.change_image', ['product' => $product, 'image' => $image]);
    }
    public function update(Request $request, $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $request->input('status');
        $product->save();

        return redirect('/admin/products')->with('success', 'Product status updated successfully!');
    }

    public function updateImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $path = $request->file('image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $product->image = $path;
        $product->save();
        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/admin/products');
    }


    public function order(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'Available') {
            return back()->with('error', 'Sorry, this product is currently out of stock.');
        }

        // Calculate total price
        $totalPrice = $product->price * $request->quantity;

        // Here you would create the purchase record
        // For now, just return success message
        return back()->with('success', 'Purchase completed successfully!');
    }
}
?>