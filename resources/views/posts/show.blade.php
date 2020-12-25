@extends('layouts.app')

@section('content')

@include('commons.error_messages')
<div class="container">
  <div class="responsive-margin" style="">
  <br >
  </div>
  <div class="box">
    <div class="title" style="text-align:center">
      <span>{{ $post->name }}</span>
      <i class="fa fa-edit" aria-hidden="true" data-toggle="modal" data-target="#editModal" style=""></i>
    </div>
    
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $post->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
        {{ Form::model($post,['route'=>['posts.update',$post->id],'files'=>true]) }}

            {{ csrf_field() }}
                <div class="form-group">
                    {!! Form::label('item_img', '商品画像') !!}
                    <input type="file" accept='image/*' multiple="multiple" onchange="loadImage(this);" name="item_img[]">
                    <p id="preview"></p>
                    <style>
                    #preview img {
                      width:100px;
                      border:1px solid #cccccc;
                      margin-right:10px;
                    }
                    #preview{
                      margin-top:10px;
                    }

                    </style>
                  </div>

                <div class="form-group">
                    {!! Form::label('name', '商品名') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description', '商品の説明') !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                <label for="state">商品状態</label>
                <select class="form-control" id="" name="state">
                  <option>新品に近い</option>
                  <option>普通</option>
                  <option>まぁまぁ使われてる</option>
                </select>
                </div>

                <div class="form-group">
                    <label for="price_per_day">料金</label>
                    <input type="number" name ="price_per_day"class="form-control">円
                </div>



                <div class="form-group">
                    <label>郵便番号(ハイフンもOK)</label>
                    <input type="text" name="zip11" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','user_address','user_address');"  class="form-control" placeholder="ex 169-0051">
                    <label for="user_address">都道府県と以降の住所</label>
                    {{ Form::text('user_address',old('user_address'),['class'=>'form-control','placeholder'=>'ex 東京都新宿区西早稲田']) }}
                </div>


                {!! Form::submit('編集する', ['class' => 'btn btn-primary btn-block']) !!}
            {{ Form::close() }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {!! Form::model($post,['route'=>['posts.destroy',$post->id],'method'=>"delete"]) !!}
              {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
   
    <?php
    $src=[];
   
      foreach ($photos as $photo){
      
      array_push($src,$photo->item_img);
      }
      
    ?>

    <div class="explanation-product">
    <div class="table-product">
            <table>
                <tr>
                  <th>商品名</th>
                  <td>{{ $post->name }}</td>
                </tr>
                <tr>
                  <th>商品の状態</th>
                  <td>{{ $post->state }}</td>
                </tr>
                <tr>
                  <th>料金</th>
                  <td>{{ $post->price_per_day }}円</td>
                </tr>
                <tr>
                  <th>取引場所</th>
                  <td>{{ $post->user_address }}</td>
                </tr>
                <tr>
                  <th>出品者</th>
                  <td>{{ link_to_route('users.show',$post->user->name,['id'=>$post->user->id]) }}</td>
                </tr>
            </table>
      </div>

      <div class="photo-product">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            @for ($i=0;$i< count($src);$i++)
              @if($i==0)
              <div class="carousel-item active">
              <img class="d-block w-100" src="{{ $src[$i] }}" alt="" style="height:400px;">
              </div>
              @else
              <div class="carousel-item">
              <img class="d-block w-100" src="{{$src[$i]}}" alt="" style="height:400px;">
              </div>
              @endif
            @endfor 
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      </div>
      
      
    </div>
    <div class="price_product">
      <span class="item-price bold">￥{{ $post->price_per_day }}円</span>
      <span class="shipping-fee">送料などはご相談ください</span>
  
    @if($post->borrows->isEmpty())
    {{ Form::open(['route' => ['borrow.store', 'id' => $post->id], 'method' => 'post']) }}
        {!! Form::submit('取引済み',['class'=>'btn btn-danger']) !!}
    {{ Form::close() }}
    @else 
      <h2 style="font-weight:bold;color:#F06060;">取引済み</h2>
    @endif
    </div>
    

    
    

    <div class="item-description">
      <h2>商品の説明</h2>
      <p>{!! nl2br($post->description) !!}</p>
    </div>

    @if(!(empty($post->comments)))
      <span class="comment-header">コメント</span>
      @foreach ($post->comments as $comment)
      <div class="balloon">
      <span>{{ link_to_route('users.show',$comment->user->name,['id'=>$comment->user_id]) }}
      </span>
      <p>{{ $comment->comment }}</p>
      </div>
      @endforeach
    @endif
    
    @if(Auth::check())
      {!! Form::model($post, ['route' => ['comments.store', $post->id], 'method' => 'post']) !!}
      <div class="form-group-comment">
          {!! Form::textarea('comment', old('comment'), ['class' => 'form-control comment', 'rows' => '2']) !!}
          {!! Form::submit('コメントする', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}

    @endif
    </div>


  </div>
    </div>
  
  <script>
function loadImage(obj)
{
	document.getElementById('preview').innerHTML = '<p>プレビュー</p>';
	for (i = 0; i < obj.files.length; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('preview').innerHTML += '<img src="' + e.target.result + '">';
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}
</script>





@endsection
