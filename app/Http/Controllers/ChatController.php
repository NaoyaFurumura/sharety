<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ChatRoom;
use App\ChatRoomUser;
use App\ChatMessage;
use App\User;
use Illuminate\Support\Facades\Auth;
use Log;

use App\Events\ChatPusher;

use App\Notifications\MessageNotification;


class ChatController extends Controller
{
    public static function show($id){

        $matching_user_id = $id;
        
        // 自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');

        
    
        // 自分の持っているチャットルームからチャット相手のいるルームを探す
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
            ->where('user_id', $matching_user_id)
            ->pluck('chat_room_id');
        
            
    
        // なければ作成する
        if ($chat_room_id->isEmpty()){
    
            ChatRoom::create(); //チャットルーム作成
            
            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first(); //最新チャットルームを取得
    
            $chat_room_id = $latest_chat_room->id;
    
            // 新規登録 モデル側 $fillableで許可したフィールドを指定して保存
            ChatRoomUser::create( 
            ['chat_room_id' => $chat_room_id,
            'user_id' => Auth::id()]);
    
            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => $matching_user_id]);
        }
    
        // チャットルーム取得時はオブジェクト型なので数値に変換
        if(is_object($chat_room_id)){
            $chat_room_id = $chat_room_id->first();
        }
        
        // チャット相手のユーザー情報を取得
        $chat_room_user = User::findOrFail($matching_user_id);

        $chat_room_user_id = $chat_room_user->id;
    
        // チャット相手のユーザー名を取得(JS用)
        $chat_room_user_name = $chat_room_user->name;
    
    //相手のプロフィール画像取得
    if(!(empty($chat_room_user->profile->user_profile))){
        $chat_room_user_profile = $chat_room_user->profile->user_profile;
    }else{
        $chat_room_user_profile = null;
    }

        $chat_messages = ChatMessage::where('chat_room_id', $chat_room_id)
        ->orderby('created_at')
        ->get();
        
        return view('chat.show', 
        compact('chat_room_id', 'chat_room_user_id',
        'chat_messages','chat_room_user_name','chat_room_user_profile'));
    
        }

        public function index(){
            
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())->pluck('chat_room_id');
            #dd($current_user_chat_rooms);
         
        // 自分が持っているチャットルームのユーザーを取り出す
        $users = ChatRoomUser::whereIn('chat_room_id',$current_user_chat_rooms)->get();
            #dd($users);
        return view('chat.index',[
            "users"=>$users,
            'current_user_chat_room'=>$current_user_chat_rooms,
        ]); 
        
        }

        public static function chat(Request $request){
            
            $chat = new ChatMessage();
            $chat->chat_room_id = $request->chat_room_id;
            $chat->user_id = $request->user_id;
            $chat->message = $request->message;
            $chat->read= 0;
            $chat->save();
            event(new ChatPusher($chat));
            
            $user = User::findOrFail($request->chat_room_user_id);
            $user->sendInvitation(Auth::user()->name);

           
            
        
        }

}
