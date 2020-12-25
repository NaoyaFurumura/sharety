<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Borrow;
use App\Post;

use Illuminate\Support\Facades\Auth;

class BorrowsController extends Controller
{
    public function store($id){
            $borrow = new Borrow;
            $borrow->post_id = $id;
            $borrow->user_id = Auth::id();
            $borrow->save();
            return back();
    }


    public function index($id){
        $borrow_posts = Borrow::where('user_id',$id)->orderBy('created_at','desc')->get();

        return view('borrow.index',
        [
            "borrow_posts"=>$borrow_posts,
        ]
        );
    }



}
