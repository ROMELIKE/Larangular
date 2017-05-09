@extends('admin.master')
@section('title','404 page not found!')
@section('content')
    <div class="about">
        <div class="container">
            <div class="page-not-found">
                <h1>404</h1>
                <a href="{!! url('dashboard') !!}">Back </a>
            </div>
        </div>
    </div>
@endsection