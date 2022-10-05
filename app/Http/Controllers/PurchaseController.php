<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Post $post)
    // {
    //     // $posts = Post::with('user')->latest()->paginate(8);
    //     $purchases = Purchase::all();
    //     return view('posts.purchases.index')
    //         ->with(compact('post', 'purchases'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $purchase = new Purchase;
        $purchase->user_id = $request->user()->id;
        $purchase->post_id = $post->id;
        $purchase->category_id = $post->category_id;
        $purchase->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request, $id)
    // {
    //     $purchase = new Purchase;
    //     $post = Post::find();
    //     $user = $request->user()->id;
    //     $purchase = Purchase::where('post_id',$post->id)
    //                 ->where('user_id', $user)
    //                 ->first();
    //     $purchase->delete();
    //     return back();
    // }
}
