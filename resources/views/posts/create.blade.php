@extends('layout')

@section('content')

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        @include('posts._form')

        <button class="btn btn-primary btn-block" type="submit">Submit</button>
    </form>

@endsection('content')
