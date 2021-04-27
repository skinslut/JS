@extends('layouts.app')

@section('title', $question->theme->name)
@section('content-wrapper-class', 'content-wrapper_test-bg')

@section('content')
    <form action="{{ route('test.answer', $question) }}" class="form" method="post" name="test-form">
        @csrf
        <input type="hidden" name="ANSWER">
        <div class="timer mb-5" id="timer">
            <span>02</span>:<span>00</span>
        </div>
        <div class="test__info mb-5">
            <h1 class="mb-4">Тема: "{{ $question->theme->name }}"</h1>
            <h2>{{ $question->text }}</h2>
        </div>

        @php
            $answers = $question->answers;
            shuffle($answers)
        @endphp

        @foreach($answers as $index => $answer)
            <div class="form-group">
                <input type="radio" name="answer" id="{{ $index }}" value="{{ $answer }}" {{ $index === 0 ? 'checked' : '' }}/>
                <label for="{{ $index }}">{{ $answer }}</label>
            </div>
        @endforeach
        <div class="mb-5"></div>
        <div class="form-group">
            <input type="submit" class="mx-auto" name="SUBMITTED" value="Отправить ответ">
        </div>
    </form>

    <script>
        let target_date = new Date();
        let days, hours, minutes, seconds;
        let countdown = document.getElementById("timer");


        target_date = target_date.getTime() + 1000 * 120;

        getCountdown();

        setInterval(function () { getCountdown(); }, 1000);

        function getCountdown(){

            let current_date = new Date().getTime();
            let seconds_left = (target_date - current_date) / 1000;

            minutes = parseInt(seconds_left / 60);
            seconds = parseInt( seconds_left % 60 );

            if (!minutes && !seconds) {
                let form = document.forms['test-form'];

                form.submit();
            }

            countdown.innerHTML = "<span>" + pad(minutes) + "</span>:<span>" + pad(seconds) + "</span>";
        }

        function pad(n) {
            return (n < 10 ? '0' : '') + n;
        }
    </script>
@stop

