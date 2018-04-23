@extends('layout.main-portable')

@section('css')
@stop

@section('title', '登録')

@section('content')
    <div class="login-page">
        <div class="form">
            <form class="register-form">
                <div class="ot-login-title">360コンテンツ管理システム</div>
                <input type="text" placeholder="ユーザー名"/>
                <input type="password" placeholder="パスワード"/>
                <input type="text" placeholder="メールアドレス"/>
                <button>登録</button>
                <p class="message">すでに登録していますか？<a href="/login">ログイン</a></p>
            </form>
        </div>
    </div>
@stop