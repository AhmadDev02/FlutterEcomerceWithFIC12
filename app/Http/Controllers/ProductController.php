<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //index halaman utama
    public function index()
    {
        $products = \App\Models\Product::paginate(5);
        return view('pages.product.index', compact('products'));
    }

    //create
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request)
{
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
    } else {
        $filename = 'default.jpg';
    }

    $product = new \App\Models\Product;

    if ($request->filled('name')) {
        $product->name = $request->name;
    } else {
        return redirect()->back()->withErrors(['name' => 'Name is required']);
    }

    if ($request->filled('price')) {
        $product->price = (int) $request->price;
    } else {
        return redirect()->back()->withErrors(['price' => 'Price is required']);
    }

    if ($request->filled('stock')) {
        $product->stock = (int) $request->stock;
    } else {
        return redirect()->back()->withErrors(['stock' => 'Stock is required']);
    }

    if ($request->filled('category_id')) {
        $product->category_id = $request->category_id;
    } else {
        return redirect()->back()->withErrors(['category_id' => 'Category ID is required']);
    }

    $product->image = $filename;
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product successfully');
}



    //edit
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    //update
    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        //if image is not empty, then update the image
        if ($request->image) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }
        $product->update($request->all());

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
