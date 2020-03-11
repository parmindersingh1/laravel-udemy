@extends('layout')

@section('content')
    <h1>
       {{ $post->title }}

        @badge(['show' => now()->diffInMinutes($post->created_at) < 20])
            New!
        @endbadge
    </h1>
    <p>{{ $post->content }}</p>

    @updated(['date' =>  $post->created_at , 'name' => $post->user->name])
    @endupdated

    @updated(['date' =>  $post->updated_at ])
        Updated
    @endupdated

    <p>Currently read by {{ $counter }} people</p>

    {{-- @if ( $post->id === 1)
        Post One
    @elseif ( $post->id === 2)
        Post Two
    @else
        Something else
    @endif --}}




    <h4>Comments</h4>
    @forelse ($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        @updated(['date' =>  $comment->created_at ])
        @endupdated
    @empty
        <p>No Comments yet!</p>
    @endforelse
@endsection('content')
