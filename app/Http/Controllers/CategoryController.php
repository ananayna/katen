<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    Public function index(){

        $categories = Category::latest()->paginate(3);
        return view('backend.category.list', compact('categories'));
    }

    Public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:100'
        ]);

        $category_slug = str($request->name)->slug();
        $slug_count = category::where('slug','LIKE', '%'.$category_slug.'%')->count();
        if($slug_count > 0){
            $category_slug .= '-' . $slug_count + 1 ;
        }

        $category = new category();

        $category->name = $request->name;
        $category->slug = $category_slug;
        $category->save();
        return back();
    }

    Public function edit($id){
        $categories = Category::paginate(3);
        $editData = Category::find($id, ['id','name']);
        return view('backend.category.list', compact('categories', 'editData'));
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

        $category = Category::find($id);

        $category->name = $request->name;
        $category->slug = $category_slug;
        $category->save();
        return back();
    }

    Public function delete($id){
        $category = Category::find($id);
        $category->delete();
        return back();
    }

    public function change_status(Request $request){
        $category = Category::find($request->category_id);
        if($category->status){
            $category->status = false;
        }else{
            $category->status = true;
        }
        $category->save();
    }
}
