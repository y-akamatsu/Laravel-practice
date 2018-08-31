<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PostController;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('company_id', $user->company_id)->latest()->get();
     
     return view('posts.index', ['posts' => $posts]);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePost $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $user = Auth::user();
        $name = $request->file('thefile')->getClientOriginalName();
        $request->file('thefile')->storeAs('images', $name);
        $post = Post::create([
            'title'      => $request->title,
            'body'       => $request->body,
            'company_id' => $user->company_id,
            'user_id'    => $user ->id,
        ]);
        
       return redirect('posts/' .$post->id);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StorePost $request, Post $post)
    {
        if ($post->company_id !== Auth::user()->company_id) {
            abort(404);
        }
        $name = $request->file('thefile')->getClientOriginalName();
        $request->file('thefile')->storeAs('images', $name);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePost $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, Post $post)
    {
        if ($post->company_id !== Auth::user()->company_id) {
            abort(404);
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return redirect('posts/' . $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->company_id !== Auth::user()->company_id) {
            abort(404);
        }
        $post->delete();
        return redirect('posts');
    }
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png',
                'dimensions:min_height=120,max_width=400,height=400',
            ]
        ]);
        
        if($requst->file('file')->isValid([])){
            $filename = $request->file->store('public/images');
            
            $user = User::find(auth()->id());
            $user->image_filename = basename($filename);
            $user->save();
            
            return redirect('/home')->with('success', '保存しました。');
        }else{
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。']);
                
        }
    }
}
