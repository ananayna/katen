<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Post;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with(['user:id,name','category:id,name'])
        ->latest()
        ->select(['id','title', 'user_id','category_id', 'featured_image','status','is_featured','created_at'])
        ->paginate(3);
        return view('backend.post.list', compact('posts'));
    }

    public function create(){
        $categories = Category::latest()->get(['id', 'name']);
        return view('backend.post.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'required|mimes:jpg,png,jpeg,webp'
        ]);

        $post_slug = str($request->title)->slug();
        $slug_count = Post::where('slug','LIKE', '%'.$post_slug.'%')->count();
        if($slug_count > 0){
            $post_slug .= '-' . $slug_count + 1 ;
        }


        if($request->hasFile('featured_image')){
            $featured_image = str()->random(5).time().'.'.$request->featured_image->extension();
            $request->featured_image->storeAs('post',$featured_image, 'public');
        }

        $post = new Post();

        $post->title = $request->title;
        $post->slug = $post_slug;
        $post->user_id = auth()->id();
        $post->category_id = $request->category;
        $post->subcategory_id = $request->subcategory;
        $post->featured_image = $featured_image;
        $post->short_description = $request->short_description;
        $post->description = $request->description;
        $post->save();
        return back();
    }

    public function change_status(Request $request){
        $post = Post::find($request->post_id);
        if($post->status){
            $post->status = false;
        }else{
            $post->status = true;
        }
        $post->save();
    }

    // public function change_featured(Request $request){
    //     $post = Post::find($request->featured_id);
    //     if($post->is_featured){
    //         $post->is_featured = false;
    //     }else{
    //         $post->is_featured = true;
    //     }
    //     $post->save();
    // }
}
