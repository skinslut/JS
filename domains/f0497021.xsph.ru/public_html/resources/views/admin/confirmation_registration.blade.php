@extends('layouts.app')

@section('title', 'Подтверждение заявок на регистрацию')

@section('content')
<table class="table">
        <thead>
            <tr class=" text-left text-muted" >
                <th style="vertical-align: top !important;">Имя</th>
                <th style="vertical-align: top !important;">Группа</th>
                <th style="vertical-align: top !important;">Статус</th>
            </tr>
        </thead>
        @if(count($students) > 0)
            <tbody class="text-left">
                @foreach($students as $student)
                    <tr >
                        <td>{{ $student->name }} {{ $student->surname }}</td>
                        <td>{{ $student->group }}</td>
                        <td>
                            <form method="post" action="{{ route('confirmation-registration') }}">
                                @csrf
                                <input type="hidden" value="{{$student->id}}" name="user_id" />
                                <button style="cursor: pointer;" class="primary-button" type="submit">Подтвердить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <tbody class="text-left">
                <tr>
                    <td style="text-align: center;" colspan="100%">Пока нет студентов с неподтвержденной регистрацией</td>
                </tr>
            </tbody>
        @endif
    </table>
    @if($students->total())
        {{ $students->links('widgets.paginator') }}
    @endif

    <a href="{{ route('admin-nav') }}" class="mx-auto mt-4 primary-button">Назад</a>
@endsection
