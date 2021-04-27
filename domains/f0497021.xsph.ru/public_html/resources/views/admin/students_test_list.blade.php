@extends('layouts.app')

<!-- Имя студента в тайтл -->
@section('title', $student->surname)

@section('content')
    <div class="students">
        <div class="student-data">
            <div>{{ $student->name }} {{ $student->surname }} <br /> {{ $student->patronymic }}</div>
            <div>{{ $student->group }}</div>
        </div>

        <table class="table">
            <thead>
                <tr class=" text-left text-muted" >
                    <th style="vertical-align: top !important; text-align: center;">Верных ответов</th>
                    <th style="vertical-align: top !important; text-align: center;">Статус</th>
                    <th style="vertical-align: top !important; text-align: center;">Дата</th>
                </tr>
            </thead>
            @if(count($testResults) > 0)
                <tbody class="text-left">
                    @foreach($testResults as $testResult)
                        <tr >
                            <td>{{ $testResult->rating }} / 25</td>
                            <td>

                                <form method="post" action="{{ route('confirm-test') }}">
                                    @csrf
                                    <input type="hidden" value="{{$testResult->id}}" name="result_id" />
                                    <button style="cursor: pointer;" class="primary-button small-button" type="submit" @if($testResult->state != 0) disabled @endif>
                                        @if($testResult->state != 0) Подтверждён @else Подтвердить @endif 
                                    </button>
                                </form>
                            </td>
                            <td>
                                25.02.2021
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody class="text-left">
                    <tr>
                        <td style="text-align: center;" colspan="100%">У студента нет пройденых тестов</td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>

    @if($testResults->total() > $testResults->count())
        {{ $testResults->links('widgets.paginator') }}
    @endif
    <a href="@if(url()->current() == url()->previous()) route('students-filter') @else {{ url()->previous() }} @endif" class="mx-auto mt-4 primary-button">Назад</a>
@endsection
