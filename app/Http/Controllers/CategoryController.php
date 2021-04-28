<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function show(Category $category) {
        $posts = Post::where("category_id", $category->id)->paginate(4);
        return view('search', [
            'posts' => $posts,
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'tags' => Tag::first()->get(),
            'category' => $category
            ]);
    }

    public function index() {
        return view('cms.categories.index', [
            'categories' => Category::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function categoryPosts(Category $category)
    {
        return view('cms.posts.all_posts', [
            'posts' => Post::where('category_id', $category->id)->latest()->get(),
            'category_posts' => $category->name
        ]);
    }

    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        Post::whereCategoryId($category->id)->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'You have successfully deleted the category!');
    }

    public function multipleDelete(Request $request)
    {
        $checked = $request->input('checked',[]);
        $categories = Category::whereIn('id', $checked)->get();
        foreach ($categories as $category) {
            Post::whereCategoryId($category->id)->update(['category_id' => null]);
            $category->delete();
        }
        return redirect()->route('categories.index')->with('success', 'You have successfully deleted the selected categories!');
    }

    public function create()
    {
        return view('cms.categories.create', [
            'categories' => Category::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // Validate
        $this->validateRequest($request);
        
        $attr = $request->all();
        $slug = Str::slug(request('name'));
        $attr['slug'] = $slug;
        Category::create($attr);

        session()->flash('success', 'You have successfully created the category!');
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('cms.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Category $category, Request $request)
    {
        // Validate
        $this->validateRequest($request);
        
        $attr = $request->all();
        $slug = Str::slug(request('name'));
        $attr['slug'] = $slug;
        $category->update($attr);

        session()->flash('success', 'You have successfully updated the category!');
        return redirect()->route('categories.index');
    }

    private function validateRequest(Request $request) {
        $request->validate([
            'name' => 'required|min:3|max:20',
        ], [
            'name.required' => 'Please enter category name.',
        ]);
    }
}
