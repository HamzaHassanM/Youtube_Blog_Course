<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category = $category->load('children');
        $posts = Post::where('category_id' , $category->id)->paginate(15);
        
        return view('website.category' , compact('category','posts'));
    }
}
