<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Sharety</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script "rel="stylesheet">
    </head>
<body>

<div class="chat-header">
{{ link_to_route('chat.index','<',[],['class'=>'back_to']) }}
  <h1 id="text">{{ $chat_room_user_name }}</h1>
</div>



<ul class="messages">
@foreach($chat_messages as $message)

<?php 
  
?>
  @if($message->user_id != Auth::id())
  <?php 
      if($message->read==0){
        $message->read=1;
        $message->save();
      }
  ?>
    <li class="left-side">
      <div class="chat-name-left">
      {{ $message->user->name }}
      </div>
      <div class="text">
      {{ $message->message}}
      </div>
      <div class="time" style="">
        <span>{{ $message->created_at->format("Y年m月d日 H時i分") }}</span>
        </div>
    </li>
    
  @else
    <li class="right-side">
        <div class="chat-name-right">
        {{ $message->user->name }}
        </div>
        <div class="text">
        {{ $message->message }}
        </div>
        <div class="time" style="">
        <span>{{ $message->created_at->format("Y年m月d日 H時i分") }}</span><br>
        @if($message->read ==0)
          <span>未読</span>
        @else 
        <span>既読</span>
        @endif
        </div>
    </li>
    
  @endif
@endforeach
</ul> 

<?php
  $day = new DateTime();
  $now_time=$day->format('Y年m月d日 H時i分');
  
?>
<form class="messageInputForm" style="">
      <input type="text" data-behavior="chat_message" class="messageInputForm_input form-control" placeholder="メッセージを入力..." style="margin:0 auto;display:inline-block;">
</form>
<?php
  #dd($chat_room_user_id);
?>

<script>
var chat_room_id = {{ $chat_room_id }};
var user_id = {{ Auth::user()->id }};
var chat_room_user_id = {{ $chat_room_user_id }};
var current_user_name = "{{ Auth::user()->name }}";
var chat_room_user_profile = "{{ $chat_room_user_profile }}";
var now_time = "{{ $now_time }}";
</script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
<script src="/js/app.js"></script>

</body>

