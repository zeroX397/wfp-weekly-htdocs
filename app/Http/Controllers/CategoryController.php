<?php

namespace App\Http\Controllers;

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

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Ini Insert";
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
    public function edit(string $id)
    {
        return "Ini Edit $id";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
