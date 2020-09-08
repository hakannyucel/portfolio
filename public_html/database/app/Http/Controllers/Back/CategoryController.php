<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// Models
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('Back.pages.categories.index', compact('categories'));
    }

    public function trash(){
        $categories = Category::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('Back.pages.categories.trash', compact('categories'));
    }

    public function create(Request $request){
        $isExists = Category::whereSlug(Str::slug($request->category))->first();
        if($isExists){
            toastr()->error('Böyle bir kategori zaten mevcut!');
            return redirect()->back();
        }
        $category = new Category;
        $category->title = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori Başarıyla Oluşturuldu.');
        return redirect()->back();
    }

    public function edit($slug){
        $category = Category::whereSlug($slug)->first();
        return view('Back.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $slug){
        $category = Category::whereSlug($slug)->first();
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->status = $request->status;
        $category->save();
        return redirect()->route('admin.category.index');
    }

    // Delete
    public function delete($id){
        $category = Category::findOrFail($id);
        toastr()->success($category->title.' Kategorisi Geri Dönüşüme Taşındı');
        $category->delete();
        return redirect()->back();
    }

    public function hardDelete($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        toastr()->success($category->title.' Kategorisi Silindi');
        $category->forceDelete();
        return redirect()->back();
    }

    public function recover($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        toastr()->success($category->title.' Kategorisi Kurtarıldı');
        $category->restore();
        return redirect()->back();
    }
}
