<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function viewCategories(){
        $categories = Category::all();
        return view('admin.category')->with('categories',$categories);
    }
    public function addNewCategory(Request $request){
        $name = trim($request->name);
        $category = Category::where('name', $name)->first();
        if($category){
            return response()->json(['error'=>'The category is already!']);
        }
        $category = new Category();
        $category->name = $name;
        $category->save();
        return response()->json(['category'=>$category]);
    }
    public function editCategory(Request $request){
        $newName = $request->newName;
        $category = Category::where('id', $request->category_id)->first();
        if(!$category){
            return response()->json(['error'=>'Not found!'],404);
        }
        if (Category::where('name', $newName)->exists()) {
            return response()->json(['error' => 'The category is already exits'], 404);
        }
        $category->name = $newName;
        $category->save();
        return response()->json(['category'=>$category]);
    }
}
