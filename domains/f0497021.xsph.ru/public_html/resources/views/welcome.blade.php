@extends('layouts.app')

@section('title', 'Добро пожаловать!')
@section('logo', 'js-logo')

@section('content')
        <a class="mb-3 primary-button" href="{{ route('login') }}">Войти</a>
        <a class="mb-3 primary-button" href="{{ route('register') }}">Зарегистрироваться</a>
@endsection
