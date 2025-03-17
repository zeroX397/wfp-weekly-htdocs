<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    function welcome()
    {
        return "Welcome Message";
    }
    function beforeOrder()
    {
        return view("before");
    }
    function menu($pemesanan = "")
    {
        if ($pemesanan == "dine-in") {
            return "tampilan menu dine-in";
        } else if ($pemesanan == "take-away") {
            return "tampilan menu take-away";
        } else {
            return "Pilih Dine-in atau Take-away";
        }
    }
    function admin($administration = "")
    {
        if ($administration == "categories") {
            $manajemen = "Kategori";
        } else if ($administration == "order") {
            $manajemen = "Order";
        } else if ($administration == "members") {
            $manajemen = "Member";
        } else {
            return "Portal Manajemen Admin";
        }
        return "Portal Manajemen: Daftar $manajemen.";
    }
    function tesQuery() {
        // raw query
        // $data = DB::select("select * from foods where price > 50000");

        // query builder
        // $data = DB::table("foods")
        // -> where("price", ">", 50000)
        // -> get();

        // Eloquent
        // $data = Food::all()->where("price",">","50000");

        // Limit Offset
        // raw query
        $data = DB::select("select * from foods limit 5");
        return response()->json($data);
    }
}
