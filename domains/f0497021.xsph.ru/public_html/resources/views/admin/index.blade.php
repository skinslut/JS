@extends('layouts.app')

@section('title', 'Админ-панель')
@section('logo', 'js-logo')

@section('content')
    <a class="mb-3 primary-button" href="{{ route('confirmation-form') }}">Подтверждение заявок на регистрацию</a>
    <a class="mb-3 primary-button" href="{{ route('results-form') }}">Результаты студентов</a>

    <a href="{{ route('home') }}" class="mx-auto mt-4 primary-button">Назад</a>
@endsection
