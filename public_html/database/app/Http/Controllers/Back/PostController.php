<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Post;
use App\Models\Category;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', "ASC")->get();
        return view('Back.pages.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('Back.pages.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $post = new Post;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->content = $request->content;
        $post->category_id = $request->category;
        $post->keywords = $request->keywords;
        $post->status = $request->status;

        if($request->hasFile('image')){
            $image_name = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$image_name);
            $post->image = 'uploads/'.$image_name;
        }
        $post->save();
        toastr()->success('Post Başarıyla Oluşturuldu');
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'Here is Show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('Back.pages.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->content = $request->content;
        $post->category_id = $request->category;
        $post->status = $request->status;

        if($request->hasFile('image')){
            $image_name = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$image_name);
            $post->image = 'uploads/'.$image_name;
        }
        $post->save();
        toastr()->success('Post Başarıyla Güncellendi');
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return 'Here is destroy';
    }

    public function deletePost($id){
        Post::find($id)->delete();
        toastr()->success('Post Geri Dönüşüme Taşındı');
        return redirect()->route('admin.posts.index');
    }

    public function hardDeletePost($id){
        Post::onlyTrashed()->find($id)->forceDelete();
        toastr()->success('Post Başarıyla Silindi');
        return redirect()->back();
    }

    public function recover($id){
        Post::onlyTrashed()->find($id)->restore();
        toastr()->success('Post Başarıyla Kurtarıldı');
        return redirect()->back();
    }

    public function recycle(){
        $posts = Post::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('Back.pages.posts.trash', compact('posts'));
    }
}
