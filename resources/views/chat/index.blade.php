@extends('layouts.app')

@section('content') 

<h1 style="font-weight:bold;">Direct-talk</h1>

<?php
  #dd($users);
?>
 
<div class="talk-wrapper">

    @foreach ($users as $user)

    <?php
    $messages=[];
    $message=[];
    if($user->chatroom->chatMessages->isNotEmpty()){
        foreach($user->chatroom->chatMessages as $message){
          array_push($messages,$message->message);
        }
        $message = end($messages);
       
        $message_time = App\ChatMessage::where('message',$message)->orderBy('created_at', 'desc')->first();
        $now = date("Y-m-d");
        $date = $message_time->created_at->format('Y-m-d');
        
        $result = (strtotime($now)-strtotime($date))/(60*60*24);
        $today_date = $message_time->created_at->format('H時i分');
    };
    ?>
      @if($user->user_id == Auth::id())
          @continue
      @else
        <ul>
      <li>
        <div class="chat-box">
          
          <div class="chat-user-img">
            @if(isset($user->user->profile->user_profile))
            
              <img src="{{ $user->user->profile->user_profile }}" alt="" class="chat-img">
            @else 
              <img class="chat-img" src="{{ Gravatar::get($user->user->email, ['size' => 50]) }}" alt="">
            @endif 
          </div>

          <div class="chat-user-name">
            {{ link_to_route('chat.show',$user->user->name,['id'=>$user->user_id],['class'=>'user-name'])}}
              @if(!(empty($message)))
                  <span class="new_message">{{ $message }}</span>
                  @if($result == 0)
                    <span class="new-message-time">{{ $today_date }}</span>
                  @else 
                    <span class="new-message-time">{{ $result }}日前</span>
                  @endif
                  @if($user->chatroom->chatMessages->isNotEmpty())
                   <?php 
                      $query = App\Chatmessage::query();
                      $query->where('chat_room_id',$user->id);
                      $query->where('read',0);
                      $not_read_messages=$query->get()->count();
                      
                   ?>
                    @if($not_read_messages!=0)
                    <span style="color:#F06060;">未読:{{ $not_read_messages }}件</span>
                    @endif
                    
                   @endif
              @endif
          </div>

        </div>
        
      </li>
        </ul>
      @endif
    @endforeach

</div>

@endsection
