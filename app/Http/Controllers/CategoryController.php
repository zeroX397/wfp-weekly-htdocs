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

    public function getEditFormA(Request $request)
    {

        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(["status" => "error", "message" => "Category not found"]);
        }
        return view("categories.updateCategoryModalA", compact("category"));
    }
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $category = Category::find($request->id);
        return view("categories.updateCategoryModalB", compact("category"));
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return response()->json(array("status" => "Oke", "mag" => "data is up to date"), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        if (!$category) {
            return response()->json(["status" => "error", "message" => "Category not found"]);
        }
        try {
            $category->delete();
            return response()->json(["status" => "success", "message" => "Category deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => "Category cannot be deleted because it has food associated with it"]);
        }
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
