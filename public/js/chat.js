
$(document).ready(function () {


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#submit').click(function () {

    $.ajax({
      type: 'POST',
      url: '/chat/chat',
      data: {
        chat_room_id: chat_room_id,
        user_id: user_id,
        chat_room_user_id: chat_room_user_id,
        message: $('.messageInputForm_input').val(),
      },

    })





      .done(function (data) {
        console.log(data);

      });

    return false;
  });


  window.Echo.channel('ChatRoomChannel')
    .listen('ChatPusher', (e) => {


      let appendText;
      console.log(e);
      if (e.message.user_id != user_id) {
        appendText =
          '<li class="left-side"><div class="chat-name-left">' + chat_room_user_name + '</div><div class="text">' + e.message.message + '</div><div class="time" style=""><span>' + now_time + '</span></div></li>';
      } else {
        appendText =
          ' <li class="right-side"><div class="chat-name-right">' + current_user_name + ' </div><div class="text">' + e.message.message +
          '</div><div class="time" style=""><span>' +
          now_time + '</span><br><span>未読<span></div></li>';
      }
      $(".messages").append(appendText);
    });

});
