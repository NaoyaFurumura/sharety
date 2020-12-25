@extends('layouts.app')

@section('content')

<?php



?>

<div class="request-wrapper">
  @foreach ($borrow_posts as $borrow_post)
  <div class="request-each">

    <div class="request-img">
      <?php 
      $photos=[];
      foreach ($borrow_post->post->photos as $photo){
        array_push($photos,$photo->item_img);
      }
      
      ?>
      <a href="{{ route('posts.show',['post'=>$borrow_post->post_id]) }}"><img src="/storage/{{ $photos[0] }}" alt="" style="width:80px; height:100px;" class="post-img"></a>
    </div>
   
    <?php 
      $now = date("Y-m-d");
      $date = $borrow_post->created_at->format('Y-m-d');
      $result = (strtotime($now)-strtotime($date))/(60*60*24);
    ?>

  <div class="request-body">

      <span>{{ link_to_route('users.show',$borrow_post->user->name,['id'=>$borrow_post->user_id],[]) }}さんがあなたの投稿にリクエストを送りました</span>
      @if($result==0)
        <span class="request-date">今日のリクエスト</span>
      @else
        <span class="request-date">{{ $result }}日前</span>
      @endif 

  </div>
</div>
@endforeach




  
@endsection
