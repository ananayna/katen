<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class FrontendHomeController extends Controller
{
    public function index(){
        $featured_posts = Post::latest()
        ->where('is_featured', true)
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name'])
        ->select(['id','title','featured_image','category_id','user_id','created_at'])
        ->take(3)
        ->get();

        $posts = Post::latest()
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name,profile'])
        ->select(['id','title','featured_image','category_id','short_description','user_id','created_at'])
        ->paginate(2);

        return view('frontend.index',compact('featured_posts','posts'));
    }

    public function showPost($slug){
        $post = Post::where('slug', $slug)
        ->with(['category:id,name,slug','user:id,name,profile'])
        ->first();
        return view('frontend.post_single', compact('post'));
    }
}
