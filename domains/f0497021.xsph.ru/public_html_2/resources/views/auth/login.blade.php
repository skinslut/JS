@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <form action="{{ route('login') }}" class="form w-100" method="post">
        @csrf
        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{ old('email') }}">
            @error('email')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-group mb-4">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
            @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-group">
            <button class="mx-auto">Войти</button>
            <br>
            <button class="mx-auto">Назад</button>
        </div>
    </form>
@endsection
