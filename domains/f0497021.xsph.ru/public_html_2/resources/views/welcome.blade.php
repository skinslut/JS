@extends('layouts.app')

@section('title', 'Добро пожаловать!')

@section('content')
        <a class="mb-3" href="{{ route('login') }}">Войти</a>
        <a class="mb-3" href="{{ route('register') }}">Зарегистрироваться</a>
@endsection
