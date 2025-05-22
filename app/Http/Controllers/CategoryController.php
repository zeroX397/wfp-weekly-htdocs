<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showTotalFoods()
    {
        $data = DB::table("categories")
            ->select(["categories.name", DB::raw("count(*) as count")])
            ->leftJoin("foods", "categories.id", "=", "foods.category_id")
            ->groupBy("categories.id")
            ->groupBy("categories.name")
            ->get();

        return response()->json($data);
    }
    public function index()
    {
        $categories = Category::all();
        return view("categories.index", ["categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Ini Show $id";

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("categories.update", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
        return redirect()->route("categories.index")->with("status", "Update success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route("categories.index")->with("status", "Delete success");
        } catch (\Exception $e) {
            return redirect()->route("categories.index")->with("status", "Please make sure that category does not have any food associated within it.");
        }

    }
    public function showListFoods()
    {
        $category = Category::find($_GET["idcat"]);
        return response()->json($category);
    }
}
