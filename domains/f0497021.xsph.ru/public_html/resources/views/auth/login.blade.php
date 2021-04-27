@extends('layouts.app')

@section('title', 'Вход')
@section('logo', 'js-logo')

@section('content')
    <form action="{{ route('login') }}" class="form w-100" method="post">
        @csrf
        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{ old('email') }}">
            <!-- @error('email')
            <span style="text-align: center;" class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror -->
        </div>
        <div class="form-group mb-4">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
            <!-- @error('password')
            <span style="text-align: center;" class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror -->
        </div>
       
        @if($errors->any())
            <div style="text-align: center; color: red;">
                {{ $errors->first() }}
            </div>
            <br />
        @endif
       
        <div class="form-group">
            <button class="mx-auto primary-button">Войти</button>
        </div>
    </form>
    <a href="{{ route('welcome') }}"><button class="mx-auto primary-button">Назад</button></a>
@endsection
