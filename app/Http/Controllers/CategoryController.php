<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     // Barcha kategoriyalarni olish (nested ko'rinishda)
     public function index()
     {
         // Barcha kategoriyalarni parent-children aloqasi bilan olish
         $categories = Category::with('children')->whereNull('parent_id')->whereNull('parent_id')->paginate(10);  // Root kategoriyalarni olish;  // Root kategoriyalarni olish

         return $this->responsePagination($categories, CategoryResource::collection($categories));
        }


     // Yangi kategoriya yaratish
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required',
             'parent_id' => 'nullable|exists:categories,id',
         ]);

         $category = Category::create($request->all());

         return $this->success(new CategoryResource($category), 'Category created successfully');
     }

     // Kategoriyani yangilash
     public function update(Request $request, $id)
     {
         $category = Category::find($id);
            if (!$category) {
                return $this->error('Category not found', 404);
            }
            $category->update($request->all());
            return $this->success(new CategoryResource($category), 'Category updated successfully');

     }

     // Kategoriyani o‘chirish
     public function destroy($id)
     {
        $category = Category::find($id);
        if (!$category) {
            return $this->error('Category not found', 404);
        }
        $category->delete();
        return $this->success([], 'Category deleted successfully', 204);
    }

}

