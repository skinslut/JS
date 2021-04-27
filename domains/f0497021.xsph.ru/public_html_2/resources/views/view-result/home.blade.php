@extends('layouts.app')

@section('title', 'Мои результаты')

@section('content')
    <table class="table ">
        <thead>
            <tr class=" text-left text-muted" >
                <th style="vertical-align: top !important;">Верных ответов</th>
                <th style="vertical-align: top !important;">Статус</th>
                <th style="vertical-align: top !important;">Дата</th>
            </tr>
        </thead>
        @if($resultsPaginator->total())
            <tbody class="text-left">
                @foreach($resultsPaginator as $result)
                    <tr >
                        <td>{{ $result->rating }} \ 25</td>
                        <td>{{ $result->display_state }}</td>
                        <td>{{ $result->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <tbody class="text-left">
                <tr>
                    <td colspan="100%">У вас пока нет пройденных тестов</td>
                </tr>
            </tbody>
        @endif
    </table>
    @if($resultsPaginator->total())
        {{ $resultsPaginator->links('widgets.paginator') }}
    @endif
    <a href="{{ route('home') }}" class="mx-auto mt-4">На главную</a>
@endsection
