<?php

namespace App\Http\Controllers;

use App\Models\FoodAndDrink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodAndDrinkController extends Controller
{
    //
    public function adminIndex()
    {
        $foods = FoodAndDrink::orderBy('name', 'asc')->get();
        $categories = [
            'Food' => [],
            'Drink' => [],
            'Dessert' => [],
            'Other' => []
        ];
        foreach ($foods as $food) {
            $food->image_url = Storage::url($food->image);

            if (isset($categories[$food->category])) {
                $categories[$food->category][] = $food;
            } else {
                $categories['Other'][] = $food;
            }
        }
        return view('admin.food.index', compact('categories'));
    }

    public function show($id)
    {
        //
        $food = FoodAndDrink::findOrFail($id);
        $image = Storage::url($food->image);
        return view('admin.food.show', [
            'food' => $food,
            'image' => $image
        ]);
    }

    public function edit($id)
    {
        //
        $food = FoodAndDrink::findOrFail($id);
        $image = Storage::url($food->image);
        return view('admin.food.edit', ['food' => $food, 'image' => $image]);
    }

    public function changeImage($id)
    {
        //
        $food = FoodAndDrink::findOrFail($id);
        $image = Storage::url($food->image);
        return view('admin.food.change_image', ['food' => $food, 'image' => $image]);
    }

    public function update(Request $request, $id)
    {
        //
        $food = FoodAndDrink::findOrFail($id);
        $food->name = $request->name;
        $food->description = $request->description;
        $food->price = $request->price;
        $food->category = $request->category;
        $food->save();

        return redirect('/admin/foods')->with('success', 'Food updated successfully!');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $path = $request->file(key: 'image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $validatedData['image'] = $path;
        FoodAndDrink::create($validatedData);
        return redirect('/admin')->with('success', 'Food added successfully!');

        // return redirect()->route('food.index')
        //     ->with('success', 'Produk berhasil ditambahkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $food = FoodAndDrink::findOrFail($id);
        $food->status = $request->input('status');
        $food->save();

        return redirect('/admin/foods')->with('success', 'Table updated successfully!');
    }

    public function updateImage(Request $request, $id)
    {
        $food = FoodAndDrink::findOrFail($id);
        $path = $request->file('image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $food->image = $path;
        $food->save();
        return redirect('/admin/foods')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        //
        $food = FoodAndDrink::findOrFail($id);
        $food->delete();
        return redirect('/admin/foods');
    }

    public function index()
{
    $items = FoodAndDrink::where('status', 'Available')
        ->orderBy('category', 'asc')
        ->orderBy('name', 'asc')
        ->paginate(12); // 12 items per page, consistent with your products page

    foreach ($items as $item) {
        $item->image_url = Storage::url($item->image);
    }

    return view('user.food-drinks.index', compact('items'));
}

    public function details($id)
    {
        $food = FoodAndDrink::findOrFail($id);
        $image = Storage::url($food->image);

        return view('user.food-drinks.details', [
            'food' => $food,
            'image' => $image
        ]);
    }

    public function order(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food_and_drinks,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255'
        ]);

        $food = FoodAndDrink::findOrFail($request->food_id);

        if ($food->status !== 'Available') {
            return back()->with('error', 'Sorry, this item is currently unavailable.');
        }

        // Calculate total price
        $totalPrice = $food->price * $request->quantity;

        // Here you would create the order record
        // For now, just return success message
        return back()->with('success', 'Order placed successfully!');
    }
}
