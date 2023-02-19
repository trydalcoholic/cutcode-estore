@extends('layouts.auth')

@section('content')
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @method('DELETE')

            <button>Выйти</button>
        </form>
    @endauth
@endsection
