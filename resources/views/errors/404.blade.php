@extends('layout-user.main')

@section('title', '404 Not Found')

@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
    <style>
        main {
            margin-top: 64px;
            height: 200px;
        }
    </style>
@stop
@section('content')
    <main id="products">
        <section class="properties bg-smooth">
            <div class="page-title">
                <div class="container">
                    <h1>Page Not Found</h1>
                </div>
            </div>
        </section>
    </main>
@stop