<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Ini Index";
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
