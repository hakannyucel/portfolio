<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Post;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(){
        $total_post = Post::all()->count();
        $total_hit = Post::sum('hit');
        $total_category = Category::all()->count();
        return view('Back.Dashboard', compact('total_post', 'total_hit', 'total_category'));
    }

    // Default Route
    public function route(){
        return redirect()->route('admin.login');
    }
}
