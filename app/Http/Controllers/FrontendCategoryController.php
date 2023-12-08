<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FrontendCategoryController extends Controller
{
    public function category($slug){
        $posts = Post::latest()
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name,profile'])
        ->wherehas('category', function($query) use ($slug){
            $query->where('slug',$slug);
        })
        ->orwherehas('subcategory', function($query) use ($slug){
            $query->where('slug',$slug);
        })
        ->where('status', true)
        ->select(['id','title','featured_image','slug','category_id','short_description','user_id','created_at'])
        ->paginate(10);

        return view('frontend.category', compact('posts'));
    }
}
