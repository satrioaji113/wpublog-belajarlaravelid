<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id);

        if (request('keyword')) {
            $posts->where('title', 'like', '%' . request('keyword') . '%');
        }

        return view('dashboard.index', ['posts' => $posts->paginate(7)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validate
        // $request->validate([
        //     'title' => 'required|unique:posts',
        //     'category_id' => 'required',
        //     'body' => 'required|min:50',
        // ]);

        //customisasi validasi
        Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'category_id' => 'required',
            'body' => 'min:20',
        ], [
            'title.required' => 'field :attribute harus diisi',
            'category_id.required' => 'pilih salah satu :attribute',
            'body.min' => ':attribute harus lebih dari :min karakter',
        ], [
            'title' => 'judul',
            'category_id' => 'kategori',
            'body' => 'tulisan'
        ])->validate();

        Post::create([
            'title' => $request->title,
            'author_id' => Auth::user()->id,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'body' => $request->body,
        ]);

        return redirect('/dashboard')->with(['success' => 'Your post has been added!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //validate
        $request->validate([
            'title' => 'required|unique:posts,title' . $post->id,
            'category_id' => 'required',
            'body' => 'required',
        ]);

        //update post
        $post->update([
            'title' => $request->title,
            'author_id' => Auth::user()->id,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
        ]);

        //redirect
        return redirect('/dashboard')->with(['success' => 'Your post had been updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/dashboard')->with(['success' => 'Your post has been removed!']);
    }
}
