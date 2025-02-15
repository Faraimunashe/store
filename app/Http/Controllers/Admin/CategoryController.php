<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $categories = Category::paginate(10);
        if(isset($search))
        {
            $categories = Category::where('name', 'LIKE', '%'.$search.'%')->paginate(10);
        }
        return inertia('Admin/CategoriesPage',[
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/CreateCategoryPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.Category::class],
        ]);

        try{
            Category::create([
                'name' => $request->name
            ]);

            return back()->with('Category created successfully.');
        }catch(Exception $e){
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
            $category = Category::findOrFail($id);
            return inertia('Admin/EditCategory', [
                'category' => $category
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
            'name' => ['required', 'string', 'max:255', 'unique:'.Category::class],
        ]);

        try{
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return back()->with('Category updated successfully.');
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->delete();

            return back()->with('Category deleted successfully.');
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
