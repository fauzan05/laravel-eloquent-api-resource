<?php

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories-collection-custom', function(){
    $categories = Category::all();
    return new CategoryCollection($categories);
});

Route::get('/categories/{id}', function($id){
    $category = Category::findOrFail($id);
    return new CategoryResource($category);
});

Route::get('/categories', function(){
    $categories = Category::all();
    return CategoryResource::collection($categories);
});

Route::get('/products/{id}', function($id){
    $products = Product::findOrFail($id);
    $products->load('category');
    return new ProductResource($products);
});

Route::get('/products-debug/{id}', function($id){
    $products = Product::findOrFail($id);
    return new ProductDebugResource($products);
});

Route::get('/products-collections', function(){
    $products = Product::all();
    return new ProductCollection($products);
});

Route::get('/products-paging', function(Request $request){
    $page = $request->get('page', 1);
    $products = Product::paginate(perPage: 5,page: $page);
    return new ProductCollection($products);
});

 