@extends('layouts.app')

@section('content')


<h1 class="search-heading">検索結果</h1>

<div class="items">
  <div class="item">
  @if(!($posts->isEmpty()))
  <div class="item">

    
<div class="grid-container">
  @foreach ($posts as $post)


  <div class="grid">

    <a href='/posts/{!! $post->id !!}'><img class="" src="{{ $post->photos[0]->item_img }}" alt="Card image cap" style="width:200px;max-height:300px;"></a>
   <p>{{ $post->price_per_day }}円</p>
   <span>取引場所：{{ $post->user_address }}</span>
  </div>


@endforeach
</div>


</div>
</div>

    
    @else
    <h2 class="search-message">該当するアイテムはありません</h2>
  </div>
  @endif
</div>


@endsection
