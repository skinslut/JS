@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
        <form action="{{ route('register') }}" class="form w-100" method="post" @if($errors->any()) style="margin-top: 70px" @endif>
            @csrf
            <div class="form-group">
                <input type="text" name="fio" id="fio" class="form-control @error('fio') is-invalid @enderror" placeholder="Ф.И.О." value="{{ old('fio') }}">
                @error('fio')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" name="group" id="group" class="form-control @error('group') is-invalid @enderror" placeholder="Группа" value="{{ old('group') }}">
                @error('group')
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
                <button class="mx-auto">Зарегистрироваться</button>
                <br>
                <button class="mx-auto">Назад</button>
            </div>
        </form>
@endsection
