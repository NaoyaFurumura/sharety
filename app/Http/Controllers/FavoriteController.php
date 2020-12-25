<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
            \Auth::user()->favorite($id);
            return back();
    }

    public function destroy($id)
    {
            \Auth::user()->unfavorite($id);
            return back();
    }

    public function like_post(Request $request)
    {
         if ( $request->input('like_post') == 0) {
             //ステータスが0のときはデータベースに情報を保存
             
             \Auth::user()->favorite($request->input('post_id'));
            //ステータスが1のときはデータベースに情報を削除
         } elseif ( $request->input('like_post')  == 1 ) {
                \Auth::user()->unfavorite($request->input('post_id'));
        }
        $post = Post::find($request->input('post_id'));
        $likes_count=$post->favorites()->count();
        
        $likes_post=$request->input('like_post');
        
         return [$likes_post,$likes_count];
    } 

    public function show(){
        
        $favorite_posts = \Auth::user()->favorites()->get();

        return view('favorites.show',[
        'posts'=>$favorite_posts,
        ]);
    }
    
}
