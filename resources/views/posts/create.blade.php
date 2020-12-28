@extends('layouts.app')

@section('content')

@include('commons.error_messages')
<div class="container" style="margin-top:20px; margin-bottom:20px;">

<div class="single-container"> 
  <div class="text-center">
        <h1 style="font-weight:bold;">出品する</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {{ Form::open(['route' => 'posts.store','files'=>true]) }}
            {{ csrf_field() }}
                <div class="form-group">
                    {!! Form::label('item_img', '商品画像') !!}
                    <input type="file" accept='image/*' multiple="multiple" onchange="loadImage(this);" name="item_img[]" >
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
                    {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder'=>'ex Tシャツ']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description', '商品の説明') !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder'=>'ex この商品は~です。支払い方法など気になることがございましたらメッセージしてください。']) !!}
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
                    <label >都道府県と以降の住所</label>
                    {{ Form::text('user_address',old('user_address'),['class'=>'form-control','placeholder'=>'ex 東京都新宿区西早稲田']) }}
                </div>

                {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
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


