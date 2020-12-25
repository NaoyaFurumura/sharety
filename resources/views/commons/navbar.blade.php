<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="/">Sharety</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    @if(Auth::check())
      <li class="nav-item active">
        {!! link_to_route('posts.create', '出品',[],['class'=>'nav-link']) !!}
      </li>
      <li class="nav-item active">
      {!! link_to_route('logout.get', 'ログアウト',[],['class'=>'nav-link']) !!}
      </li>
      <li class="nav-item active">
      {!! link_to_route('users.show', 'マイページ',['id'=>Auth::id()],['class'=>'nav-link']) !!}
      </li>
      <li class="nav-item active">
      {!! link_to_route('chat.index', 'トーク',[],['class'=>'nav-link']) !!}
      </li>
      <li class="nav-item active">
      {!! link_to_route('favorite.show', 'いいね一覧',[],['class'=>'nav-link']) !!}
      </li>
    @else 
      <li class="nav-item active">
      {!! link_to_route('login','ログイン',[],['class'=>'nav-link']) !!}
      </li>
      <li class="nav-item active">
      {!! link_to_route('signup.get','会員登録',[],['class'=>'nav-link']) !!}
      </li>
    @endif
    </ul>
    <button type="button" class="btn btn btn-outline-info" data-toggle="modal" data-target="#exampleModal">
      検索する
    </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">検索</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {!! Form::open(['route'=>'post.search']) !!}
            <div class="form-group">
              <label for="item">商品名</label>
               <input type="text" name ="item" class="form-control" value="">
            </div>

            <div class="form-group">
              <label>郵便番号(ハイフンもOK)から入力</label>
                    <input type="text" name="zip11" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref','addr');"  class="form-control" placeholder="ex 169-0051">
                    <!-- ▼住所入力フィールド(都道府県) -->
                    <label >都道府県</label>
                    <input type="text" name="pref" size="20" value="指定なし" class="form-control">
                    <!-- ▼住所入力フィールド(都道府県以降の住所) -->
                    <label for="">以降の住所</label>
                    <input type="text" name="addr" size="40" class="form-control" value="指定なし">
            </div>
                
          </div>
          <div class="modal-footer">
          {!! Form::submit('検索する', ['class' => 'btn btn-outline-info']) !!}
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</nav>
