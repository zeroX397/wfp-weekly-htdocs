<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/hello', function () {
//     return view('hello');
// });

// Route::view('/hellolagi', "hello");

// Route::get("/user/{id?}", function($id = "") {
//     if (!$id) {
//         return "No ID";
//     } else {
//         return "User id: $id";
//     }
// });

// Cara 1
// Route::get("/", function() {
//     return "home page";
// });

// Route::get("/{tokoId}", function($tokoId) {
//     return "Halaman toko dengan id = $tokoId";
// });

// Route::get("/{tokoId}/{productId}", function($tokoId, $productId) {
//     return "Halaman produk dengan id = $productId dengan id toko = $tokoId";
// });

// Cara 2
// Route::get("/{tokoId?}/{productId?}", function($tokoId = "", $productId = "") {
//     if ($productId){
//         return "Halaman produk dengan id = $productId dengan id toko = $tokoId";
//     }
//     if ($tokoId) {
//         return "Halaman toko dengan id = $tokoId";
//     }
//     return "home page";
// });

Route::get("/search", function () {
    return "Halaman search";
});

Route::get("/register", function () {
    return "Halaman register";
});

Route::get("/welcome", [TestController::class,"welcome"])->name("home");

Route::get("/before_order", [TestController::class,"beforeOrder"]);

Route::get("/menu/{pemesanan?}", [TestController::class,"menu"])->name("menu");

Route::get("/admin/{administration?}", [TestController::class,"admin"]);

Route::resource("/categories", CategoryController::class);
Route::resource("/food", FoodController::class);

// Route::get("/category/show-total-foods", CategoryController::class);

// Route::get("/tes-query", [TestController::class,"tesQuery"]);
Route::get("/tes-template/home", function(){
    return view("tes-template.home");
});
Route::get("/tes-template/search", function(){
    return view("tes-template.search");
});
Route::get("/tes-template/product/{id}", function($id){
    return view("tes-template.product", ["id" => $id]);
});