<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use App\ItemPhoto;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::orderBy('id','desc')->paginate(10);
        $photos = ItemPhoto::orderBy('id','desc')->paginate(10);

        return view('posts.index',[
            'posts'=>$posts,
            'photos'=>$photos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price_per_day'=>'required|min:0|numeric',
            'state'=>'required',
            'item_img'=>"required|",
            'user_address'=>'required',
        ],[
            'name.required'=>'商品名は必須です',
            'description.required'=>'商品説明は必須です',
            'price_per_day.required'=>'料金の登録を行ってください',
            'state.required'=>'状態を選択してください',
            'price_per_day.min'=>'0円以上の設定にしてください',
            'price_per_day.numeric'=>'0円以上の設定にしてください',
            'item_img.required'=>"商品画像の登録は必須です",
            'user_address.required'=>'取引場所の入力をしてください',
            'item_img.mimes'=>"jpeg,png,jpg,gifの中から投稿してください"
        ]);

       

        $user = \Auth::user();
     
       
       $post = $user->posts()->create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price_per_day'=>$request->price_per_day,
            'state'=>$request->state,
            'user_address'=>$request->user_address,
       ]);
       
    
       
       

       foreach($request->item_img as $index => $e){
        
       $upload_info=Storage::disk('s3')->putFile('/item_img', $e, 'public');
       $path = Storage::disk('s3')->url($upload_info);
        $photo = new ItemPhoto;
        $photo->item_img = $path;
        $photo->post_id= $post->id;
        $photo->save();
       }

      return redirect('/');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $photos = $post->photos()->orderBy('created_at', 'desc')->get();

        return view('posts.show',[
            'post'=>$post,
            "photos"=>$photos,
        ]);
    }

    public function search(Request $request){
       
        $query = Post::query();
        $item = $request->input('item');
        $pref = $request->input('pref');
        $addr = $request->input('addr');

            

            if($request->has('item')&& $item!=null){
                $query->where('name', $item)->paginate(10);
            }
           

            if($request->has('pref')&& $pref!='指定なし'){
                $query->where('user_address','like','%'.$pref.'%')->paginate(10);
            }
        

            if($request->has('addr')&& $addr!='指定なし'){
                $query->where('user_address','like','%'.$addr.'%')->paginate(10);
            }
          
            $posts = $query->paginate(10);

            if($item==null && $pref=='指定なし' &&  $addr =='指定なし'){
                $posts = collect([]);
            }
       

       

        return view('posts.search',[
            "posts"=>$posts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price_per_day'=>'required|min:0|numeric',
            'state'=>'required',
            'item_img'=>"required|",
            'user_address'=>'required',
        ],[
            'name.required'=>'商品名は必須です',
            'description.required'=>'商品説明は必須です',
            'price_per_day.required'=>'料金の登録を行ってください',
            'state.required'=>'状態を選択してください',
            'price_per_day.min'=>'0円以上の設定にしてください',
            'price_per_day.numeric'=>'0円以上の設定にしてください',
            'item_img.required'=>"商品画像の登録は必須です",
            'user_address.required'=>'取引場所の入力をしてください',
            'item_img.mimes'=>"jpeg,png,jpg,gifの中から投稿してください"
        ]);
       
        
        $post = Post::findOrFail($id);
        $post->name = $request->name;
        $post->description= $request->description;
        $post->state = $request->state;
        $post->price_per_day = $request->price_per_day;
        $post->user_id= Auth::id();
        $post->save();

      
        if(!($request->item_img[0]===null)){
            
            $photos=ItemPhoto::where('post_id',$id)->get();

           foreach($photos as $photo){
                $photo->delete();
           }

          

            foreach($request->item_img as $index => $e){
        
                $upload_info=Storage::disk('s3')->putFile('/item_img', $e, 'public');
                $path = Storage::disk('s3')->url($upload_info);
                 $photo = new ItemPhoto;
                 $photo->item_img = $path;
                 $photo->post_id= $id;
                 $photo->save();
                }
        }

        return back();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
       
        $post->delete();

        return redirect('/');

    }

   
}
