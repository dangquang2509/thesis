@extends('layout.main-portable')

@section('css')
@stop

@section('title', 'Register')

@section('content')
    <div class="login-page">
        <div class="form">
            <form class="register-form">
                <div class="ot-login-title">House Management</div>
                <input type="text" placeholder="username"/>
                <input type="password" placeholder="password"/>
                <input type="text" placeholder="email"/>
                <button>Register</button>
                <p class="message">Already registered?<a href="/login">Login</a></p>
            </form>
        </div>
    </div>
@stop