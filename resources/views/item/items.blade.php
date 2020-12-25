<?php
  if(isset($user->posts)){
  $posts = $user->posts;
  } 
  $user1 = App\User::find(Auth::id());
?>

<div class="top-wrapper">
  <div class="">
  <a class="navbar-brand" href="/" style="color:white;font-size:30px;">Sharety</a>
  </div>
  <div class="cp_iptxt">
    {!! Form::open(['route'=>'post.search']) !!}
    <label class="ef">
      <input type="text" placeholder="何かお探しですか" name="item">
      </label>
     
      <input type="submit" class="btn btn-danger" value="検索する">
    {!!  Form::close() !!}
  </div>
  <h1 class="index-message">身軽に歩こう</h1>
  <h1 class="index-message">人生を爽やかに</h1>
</div>


<div class="item-wrapper">

@if(isset($user))
  <div class="headings" >
    <h2 style="font-weight:bold; margin-top:10px;" class="heading-header">投稿一覧</h2>
  </div>
@else
<?php 


?>
  @if(\Route::current() -> getName() == 'favorite.show')
  <div class="heading" style="text-align:center;">
      <h2 style="font-weight:bold; margin-top:10px;" class="heading-header">いいね一覧</h2>
  </div>
  @else 
  <div class="heading" style="text-align:center;">
      <h2 style="font-weight:bold; margin-top:10px;margin-bottom:20px;" class="heading-header">アイテム一覧</h2>
  </div>
  @endif
@endif

  
    <div class="item">

    
    <div class="grid-container">
      @foreach ($posts as $post)

  
      <div class="grid">

        <a href='/posts/{!! $post->id !!}'><img class="" src="{{ $post->photos[0]->item_img }}" alt="Card image cap" style="width:200px;max-height:300px;"></a>
       <p>{{ $post->price_per_day }}円</p>

    @if(Auth::check())

     


      @if(Auth::user()->is_favorite($post->id))

      <a class="toggle_wish" post_id="{{ $post->id }}" like_post="1">
              <i class="fas fa-heart" style="font-size:20px;"></i>
        </a>
        @else 
        <a class="toggle_wish" post_id="{{ $post->id }}" like_post="0">
            <i  class="far fa-heart" style="font-size:20px;"></i>
        </a> 
        @endif
             
   
  @endif
<?php
 
?>
  @if(Auth::check())
    <span class="c">{{ $post->favorites()->count() }}</span>
  @else 
    <span>{{ $post->favorites()->count() }}likes</span>
  @endif
      
       @if($post->borrows->isNotEmpty())
       <span style="color:#F06060;">取引済み</span>
       @endif
       <span>取引場所：{{ $post->user_address }}</span>
      </div>
  <script>
  
  </script>
    
    @endforeach
    </div>
    
   
    </div>
</div>

