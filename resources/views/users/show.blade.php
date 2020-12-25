@extends('layouts.app')

@section('content')

<?php
#dd($user->profile->user_profile);
?>

@include('commons.error_messages')

<div class="profile_user">
  <div class="user-header">
    @if(isset($user->profile->user_profile))
        <img src="{{ $user->profile->user_profile}}" alt="" class="prf_img" style="margin-bottom:10px;"><br>
    @else 
    <img class="mr-2 rounded" src="{{ Gravatar::get($user->email, ['size' => 250]) }}" alt="" style="margin-top:20px;"><br>
      @if(Auth::id()==$user->id)
        <p style="margin-top:20px;">プロフィール画像が設定されていません。</p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
        登録する
      </button>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">プロフィール登録</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="prof_wrapper">
    {{ Form::open(['route'=>'profile.store','files'=>true]) }}
      <div class="form-group">
       
        <p><img id="file-preview"></p>
        <input id="file-sample" type="file" name="prf_img">
</br>
        {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>
      @endif
    @endif
    @if(isset($user->profile->user_profile))
    
      <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal3" value="画像変更"　style="display:block;">
      
      <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">プロフィール変更</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="prof_wrapper">
    {{ Form::open(['route'=>'profile.update','files'=>true]) }}
      <div class="form-group">
       
        <p><img id="file-preview"></p>
        <input id="file-sample" type="file" name="prf_img">
</br>
        {!! Form::submit('変更する', ['class' => 'btn btn-primary']) !!}
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>
    @endif
   
    
    <h1>{{ $user->name }}</h1>
    
   
    <form action="{{ route('user.destroy' ,['id'=>\Auth::user()->id]) }} " method="delete">
    <input type="submit" value="アカウント削除" class="btn btn-outline-danger" onClick='disp()' style="margin-top:10px;">
    </form>
    
    @if(Auth::id()!=$user->id)
    {{ link_to_route('chat.show','チャットをする',['id'=>$user->id])}}
    @endif
  </div>

  <div class="user_posts">
    @include('item.user-item')
  </div>
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

    function disp(){

window.alert('本当に削除してよろしいですか？');

}

  </script>

@endsection
