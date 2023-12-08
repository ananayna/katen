<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    Public function index(){
        $subcategories = Subcategory::with('category')->latest()->paginate(3);
        $categories = Category::latest()->select(['id', 'name'])->get();
        return view('backend.category.subcategory_list', compact('categories', 'subcategories'));
    }

    Public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:100',
            'category' => 'required|exists:categories,id'
        ]);

        $category_slug = str($request->name)->slug();
        $slug_count = Subcategory::where('slug','LIKE', '%'.$category_slug.'%')->count();
        if($slug_count > 0){
            $category_slug .= '-' . $slug_count + 1 ;
        }

        $category = new Subcategory();

        $category->name = $request->name;
        $category->category_id = $request->category;
        $category->slug = $category_slug;
        $category->save();
        return back();
    }

    Public function edit($id){
        $subcategories = Subcategory::with('category')->latest()->paginate(3);
        $categories = Category::latest()->select(['id', 'name'])->get();
        $editData = Subcategory::find($id, ['id','name']);
        return view('backend.category.subcategory_list', compact('subcategories', 'editData', 'categories'));
    }

    Public function update(Request $request, $id){
        $request->validate([
            'name'=> 'required|string|max:100'
        ]);

        $category_slug = str($request->name)->slug();
        $slug_count = category::where('slug','LIKE', '%'.$category_slug.'%')->count();
        if($slug_count > 0){
            $category_slug .= '-' . $slug_count + 1 ;
        }

        $category = Subcategory::find($id);

        $category->name = $request->name;
        $category->slug = $category_slug;
        $category->save();
        return back();
    }

    Public function delete($id){
        $category = Subcategory::find($id);
        $category->delete();
        return back();
    }

    public function getSubcategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category)->latest()->get(['id', 'name']);
        return $subcategories;
    }

    public function change_status(Request $request){
        $subcategory = Subcategory::find($request->subcategory_id);
        if($subcategory->status){
            $subcategory->status = false;
        }else{
            $subcategory->status = true;
        }
        $subcategory->save();
    }
}
