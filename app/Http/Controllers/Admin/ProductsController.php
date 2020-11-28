<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductFormRequest;

class ProductsController extends Controller
{
    public function getProducts(Product $product)
    {
        try {
            $products = $product->with('category')->get();
            return response()->json($products, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getProduct(Product $product, $id)
    {
        try {
            $product = $product->with('category')->find($id);
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function createProduct(ProductFormRequest $request, Product $product)
    {
        try {
            $product->create($request->all());
            return response()->json(["msg" => "Produto cadastrado"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function deleteProduct(Product $product,$id)
    {
        try {
            $product = $product->find($id); 
            $product->delete();
            return response()->json(["msg" => "Produto removido"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function updateProduct(ProductFormRequest $request,Product $product,$id){
        try {
            $product = $product->find($id); 
            $product->update($request->all());
            return response()->json(["msg" => "Produto autalizado"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
