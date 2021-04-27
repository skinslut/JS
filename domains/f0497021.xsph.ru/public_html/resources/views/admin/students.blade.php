@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <div class="students">
        <!-- <form method="get" action=""> -->
            <form action="{{ route('students-filter') }}" method="get">
                @csrf
                <div class="students__search-line">
                    <input class="form-control" name="name" type="text" value="@if(isset($queryParams) && isset($queryParams['name'])){{ $queryParams['name'] }}@endif" placeholder="ФИО студента">
                    <select class="form-control students__select" name="group">
                        <option value="">Все группы</option>
                        @foreach($groups as $group)
                            <option @if(isset($queryParams) && isset($queryParams['group']) && ($queryParams['group'] == $group->name)) selected @endif value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <button class="primary-button students__button" type="submit">OK</button>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr class=" text-left text-muted" >
                        <th style="vertical-align: top !important; text-align: center;">Студент</th>
                        <th style="vertical-align: top !important; text-align: center;">Группа</th>
                        <th style="vertical-align: top !important; text-align: center;">Пройденых тестов</th>
                    </tr>
                </thead>
                @if($resultsPaginator->total())
                    <tbody class="text-left">
                        @foreach($resultsPaginator as $result)
                            <tr>
                                <td><a class="link" href="{{ route('tests-list', $result->id) }}">{{ $result->name }} {{ $result->surname }}</a></td>
                                <td>{{ $result->group }}</td>
                                <td style="text-align: center;">{{ count($result->results) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody class="text-left">
                        <tr>
                            <td style="text-align: center;" colspan="100%">Список студентов пуст</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        <!-- </form> -->
    </div>

    @if($resultsPaginator->total())
        {{ $resultsPaginator->links('widgets.second_paginator') }}
    @endif

    <a href="{{ route('admin-nav') }}" class="mx-auto mt-4 primary-button">Назад</a>
@endsection
