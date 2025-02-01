<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dapatkan semua category
        $categories = Category::all();

        //ringkas data
        $categorys = $categories->map(function ($category) {
            return [
                'name'   => $category->name,
                'value'  => $category->name,
                'label'  => $category->name,
            ];
        });

        return response()->json($categorys);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'  => 'required',
        ]);

        //buat category
        $category = Category::create($validate);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //dapatkan category
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validasi       
        $validate = $request->validate([
            'name'  => 'required',
        ]);

        $category = Category::find($id);

        $category->update($validate);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        $category->delete();
    }
}
