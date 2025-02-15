<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use DB;
use Exception;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::with('images')->paginate(10);
        if(isset($search))
        {
            $products = Product::with('images')->where('name', 'LIKE', '%'.$search.'%')->paginate(10);
        }
        return inertia('Admin/ProductsPage',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return inertia('Admin/CreateProductPage', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        try{
            DB::beginTransaction();

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $unique_name = Str::uuid() . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('images', $unique_name, 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'file' => $path,
                    ]);

                }
            }

            DB::commit();

            return back()->with('Product created successfully.');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $product = Product::with('images')->findOrFail($id);
            $categories = Category::all();
            return inertia('Admin/EditProductPage', [
                'product' => $product,
                'categories' => $categories
            ]);
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        try{
            DB::beginTransaction();

            $product = Product::findOrFail($id)->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $unique_name = Str::uuid() . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('images', $unique_name, 'public');

                    ProductImage::create([
                        'product_id' => $id,
                        'file' => $path,
                    ]);

                }
            }

            DB::commit();

            return back()->with('Product updated successfully.');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Product::findOrFail($id)->delete();

            return back()->with('Product deleted successfully.');
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
