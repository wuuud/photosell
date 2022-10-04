<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $posts = Post::with('user')->latest()->paginate(8);
        // 自分だけの作品一覧http://taustation.com/laravel-acquiring-data-of-logged-in-user/
        // $posts = Post::where('user_id', auth()->user()->id)->latest()->paginate(8);

        // $price1 = $posts->category_id[0];
        // $price2 = $posts->category_id[1];
        // $price3 = $posts->category_id[2];
        // $total = $price1*500 + $price2*1000 + $price3*2000; 
        // return view('posts.index')->with(compact('posts', 'total'));
        return view('posts.index')->with(compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post($request->all());
        $post->user_id = $request->user()->id;

        $file = $request->file('image');
        $post->image = self::createFileName($file);

        DB::beginTransaction();
        try {
            $post->save();
            if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                throw new \Exception('写真の保存に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'あなたの作品の販売を開始しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Post $post)
    // {
    //     // $post = new Post($request->all());
    //     // $post->category_id = $category->id;
    //     if (Auth::user()) {
    //         // $categories = Category::all();
    //         $purchase = Purchase::where('post_id', $post->id)
    //             ->where('user_id', auth()->user()->id)->first();
    //         return view('posts.show')
    //             ->with(compact('post', 'purchase'));
    //     } else {
    //         return view('posts.show')
    //             ->with(compact('post'));
    //     }
    // }
    public function show(Post $post)
    {
        if (Auth::user()) {
            // $post = Post::where('user_id', auth()->user()->id)->latest()->paginate(8);
            $purchase = Purchase::where('post_id', $post->id)
                ->where('user_id', auth()->user()->id)->first();
            return view('posts.show')
                ->with(compact('post', 'purchase'));
        } else {
            return view('posts.show')
                ->with(compact('post'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit')->with(compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post = new Post($request->all());

        if ($request->user()->cannot('update', $post)) {
            return redirect()
                ->route('posts.show', $post)
                ->withErrors('自分の作品は更新できません');
        }
        

        // $post->user_id = $request->user()->id;

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $post->image_path;
            $post->image = self::createFileName($file);
        }

        $post->fill($request->all());

        DB::beginTransaction();
        try {
            $post->save();
            if ($file) {
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    throw new \Exception('写真の保存に失敗しました。');
                }
                if (!Storage::delete($delete_file_path)) {
                    throw new \Exception('写真の削除に失敗しました。');
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'あなたの作品の販売が始まりました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            if (!Storage::delete($post->image_path)) {
                throw new \Exception('写真の削除に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()
            ->route('posts.index')
            ->with('notice', 'あなたの作品を削除しました');
    }
    private static function createFileName($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
