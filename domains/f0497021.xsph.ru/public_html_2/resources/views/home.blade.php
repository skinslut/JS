@extends('layouts.app')

@section('title', 'Домашняя страница')

@section('content')
        <a class="mb-3" href="{{ route('test.init') }}">Пройти тест</a>
        <a class="mb-3" href="{{ route('view-result.home') }}">Мои результаты</a>
        <form action="{{ route('logout') }}" class="w-100 d-flex justify-content-center" method="POST">
            @csrf
            <button class="mb-3">Выйти</button>
        </form>
@endsection
