$(function () {

  var count_likes = $('.c').text();
  num_likes = Number(count_likes);
  console.log(num_likes);


  $('.toggle_wish').on('click', function () {
    post_id = $(this).attr("post_id");
    like_post = $(this).attr("like_post");

    click_button = $(this);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/favorite',
      type: 'POST',
      data: {
        'post_id': post_id,
        'like_post': like_post
      }
    })
      .done(function (data) //コントローラーからのリターンされた値をdataとして指定
      {
        console.log(data);
        if (data[0] == 0) {


          //クリックしたタグのステータスを変更
          click_button.attr("like_post", "1");
          //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
          click_button.next('.c').html(data[1]);

          click_button.children().attr("class", "fas fa-heart");
        }
        if (data[0] == 1) {

          //クリックしたタグのステータスを変更
          click_button.attr("like_post", "0");
          //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
          click_button.next('.c').html(data[1]);

          click_button.children().attr("class", "far fa-heart");
        }
      })

  });

});
