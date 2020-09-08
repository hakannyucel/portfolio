<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Models
use App\Models\Post;
use App\Models\Category;
use App\Models\Contact;

class HomepageController extends Controller
{
    public function index(){
      $posts = Post::whereStatus(1)->orderBy('created_at', 'DESC')->paginate(5);
      return view('Front.Homepage', compact('posts'));
    }

    // Single Page
    public function single($category_slug, $post_slug){
      // Category Slug
      $category = Category::whereSlug($category_slug)->first() ?? abort(403, "Boyle bir kategori bulunmamakta");

      // Post Slug
      $post = Post::whereSlug($post_slug)->whereCategoryId($category->id)->first() ?? abort(403, "Boyle bir post bulunmamakta.");
      $post->increment('hit', 1);
      $data['posts'] = $post;
      return view('Front.Single', $data);
    }

    // Categories Page
    public function categories(){
      $category = Category::whereStatus(1)->orderBy('id', 'DESC')->paginate(5);
      $data['categories'] = $category;
      return view('Front.Categories', $data);
    }

    // Category Page
    public function category($slug){
        $category = Category::whereSlug($slug)->first();
        $data['posts'] = Post::whereCategoryId($category->id)->whereStatus(1)->orderBy('created_at', 'DESC')->paginate(5);
        $data['categories'] = $category;
        return view('Front.Category', $data);
    }

    // Contact
    public function contact(){
        return view('Front.Contact');
    }

    // Post Contact
    public function contactPost(Request $request){
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return redirect()->route('contact')->with('success','Mesaj basariyla gonderildi.');
    }
}
