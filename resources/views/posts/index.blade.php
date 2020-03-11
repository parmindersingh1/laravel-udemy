@extends('layout')

@section('content')

<div class="row">

    {{-- @foreach ($posts as $post)
        <p>
            <h3>{{ $post->title }}</h3>
        </p>
    @endforeach --}}
<div class="col-8">
@forelse ($posts as $post)
    <p>

        <h3>
            @if($post->trashed())
                <del>
            @endif
            <a class="{{ $post->trashed() ? 'text-muted': '' }}"
             href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            @if($post->trashed())
                </del>
            @endif
        </h3>

        @updated(['date' =>  $post->created_at , 'name' => $post->user->name])
        @endupdated


        @if($post->comments_count)
            <p>{{ $post->comments_count }} comments</p>
        @else
           <p>No comments yet!</p>
        @endif

        @can('update', $post)
            <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
        @endcan

        {{-- @cannot('delete', $post)
            <p>You can't delete this post</p>
        @endcannot --}}
        @auth
            @if(!$post->trashed())
                @can('delete', $post)
                    <form method="POST" class="fm-inline"
                        action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>

                    </form>
                @endcan
            @endif
        @endauth


    </p>
    @empty
        <p>No Blog Post yet!</p>
@endforelse
</div>
<div class="col-4">
    <div class="container">
        <div class="row">

            @card(['title' => 'Most Commented'])
                @slot('subtitle')
                    What people are currently talking about.
                @endslot
                @slot('items')
                    @foreach($mostCommented as $post)
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            <li class="list-group-item">{{ $post->title }}</li>
                        </a>
                    @endforeach
                @endslot
            @endcard

            <div class="card" style="width: 100%;">
                <div class="card-body">
                <h5 class="card-title">Most Commented</h5>
                <p class="card-subtitle mb-2 text-muted">What people are currently talking about.</p>
                </div>
                <ul class="list-group list-group-flush">

                </ul>
            </div>

        </div>

        <div class="row mt-4">

            @card(['title' => 'Most Active'])
                @slot('subtitle')
                    Users with most posts written
                @endslot
                @slot('items', collect($mostActive)->pluck('name'))
            @endcard

        </div>

        <div class="row mt-4">

            @card(['title' => 'Most Active Last Month'])
                @slot('subtitle')
                 Users with most posts written in the month
                @endslot
                @slot('items', collect($mostActiveLastMonth)->pluck('name'))
            @endcard

        </div>

    </div>

</div>
</div>
@endsection('content')
