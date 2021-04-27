@extends('layouts.app')

@section('title', 'Домашняя страница')
@section('logo', 'js-logo')

@section('content')
        <a class="mb-3 primary-button" href="{{ route('test.init') }}">Пройти тест</a>
        <a class="mb-3 primary-button" href="{{ route('view-result.home') }}">Мои результаты</a>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
            <a class="mb-3 primary-button" href="{{ route('admin-nav') }}">Админ-панель</a>
        @endif
        <form action="{{ route('logout') }}" class="w-100 d-flex justify-content-center" method="POST">
            @csrf
            <button class="mb-3 primary-button">Выйти</button>
        </form>
@endsection
