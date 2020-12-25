@extends('layouts.app')

@section('content')



  <div class="prof_wrapper">
  {{ Form::open(['route'=>'profile.store','files'=>true]) }}
      <div class="form-group">
        <h1>プロフィール画像</h1>
        <p><img id="file-preview"></p>
        <input id="file-sample" type="file" name="prf_img">
        {!! Form::submit('送信する', ['class' => 'btn btn-primary']) !!}
        <p>{{ link_to_route("users.show","戻る",['id'=>Auth::id()],[]) }}</p>
        <style>
          #file-preview{
            margin-top:20px;
            height:200px;
            width:200px;
          }
        </style>
      </div>
  {{ Form::close() }}
  </div>
  

  <script>
    document.getElementById('file-sample').addEventListener('change', function (e) {
    // 1枚だけ表示する
    var file = e.target.files[0];

    // ファイルのブラウザ上でのURLを取得する
    var blobUrl = window.URL.createObjectURL(file);

    // img要素に表示
    var img = document.getElementById('file-preview');
    img.src = blobUrl;
    }); 

    
    

  </script>

@endsection
