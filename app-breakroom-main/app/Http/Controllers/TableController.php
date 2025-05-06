<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tables = Table::with('activeBooking')->orderBy('number', 'asc')->get();
        foreach ($tables as $table) {
            $table->image_url = Storage::url($table->image);
        }
        return view('admin.table.index', ['tables' => $tables]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return view('admin.table.create_table');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $path = $request->file('image')->store('photos/tables');
        $ext = $request->file('image')->extension();
        $table = new Table();
        $table->number = $request->number;
        $table->status = $request->status;
        $table->capacity = $request->capacity;
        $table->price = $request->price;
        $table->image = $path;
        $table->save();
        return redirect('/admin/tables');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $table = Table::findOrFail($id);
        $image = Storage::url($table->image);
        return view('admin.table.show', [
            'table' => $table,
            'image' => $image
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $table = Table::findOrFail($id);
        $image = Storage::url($table->image);
        return view('admin.table.edit', ['table' => $table, 'image' => $image]);
    }

    public function changeImage($id)
    {
        //
        $table = Table::findOrFail($id);
        $image = Storage::url($table->image);
        return view('admin.table.change_image', ['table' => $table, 'image' => $image]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $table = Table::findOrFail($id);
        $table->number = $request->number;
        $table->capacity = $request->capacity;
        $table->price = $request->price;
        $table->save();

        return redirect('/admin/tables')->with('success', 'Table updated successfully!');
    }
    public function updateStatus(Request $request, $id)
    {
        $table = Table::findOrFail($id);
        $table->status = $request->input('status');
        $table->save();
    
        return redirect('/admin/tables')->with('success', 'Table updated successfully!');
    }

    public function updateImage(Request $request, $id){
        $table = Table::findOrFail($id);
        $path = $request->file('image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $table->image = $path;
        $table->save();
        return redirect('/admin/tables')->with('success', 'Table updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $table = Table::findOrFail($id);
        $table->delete();
        return redirect('/admin/tables');
    }
}
