<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CreateUpdateCategory;

class CategoriesController extends Controller
{
    /**
     * retorna todas as categorias
     */
    public function getCategories()
    {
        try {
            $categories = DB::table('categories')->get();
            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * retorna categoria pelo id
     */

    public function getCategory($id)
    {
        try {
            $category = DB::table('categories')->where('id', $id)->get();
            return response()->json($category, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Filtro avançado de categorias
     */

    public function searchCategory(Request $request)
    {
        try {
            $data = $request->all();
        $categories = DB::table('categories')
            ->where(function ($query) use ($data) {

                if (isset($data['title'])) {
                    $query->where('title', $data['title']);
                }

                if(isset($data['url'])){
                    $query->where('url', $data['url']);
                }

                if(isset($data['description'])){
                    $query->where('description', 'LIKE',"%{$data['description']}%");
                }
            })->orderBy('id','DESC')->paginate(10);

            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }

    }

    /**
     * cadastrando categorias
     */

    public function createCategory(CreateUpdateCategory $request)
    {
        try {
            DB::table('categories')->insert([
                'title'         => $request->title,
                'url'           => $request->url,
                'description'   => $request->description
            ]);
            return response()->json(['msg' => 'Categoria cadastrada'], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * remover category
     */

    public function deleteCategory($id)
    {
        try {
            DB::table('categories')->where('id', $id)->delete();
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * editar category
     */

    public function updateCategory(CreateUpdateCategory $request, $id)
    {
        try {
            DB::table('categories')->where('id', $id)->update([
                'title'         => $request->title,
                'url'           => $request->url,
                'description'   => $request->description
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
