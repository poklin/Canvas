@extends('frontend.layout')

@section('title')
    <title>{{ $tag->title or config('blog.title') }}</title>
@stop

@section('content')

    {{-- Empty Search --}}
    @if(sizeof($posts) == 0 && strlen(trim(\Input::get('search', ''))) != 0)
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>No Search Results</h2>
            </div>
        </div>
    @endif

    <div class="wf-container">
        @foreach($posts as $post)
        <div class="wf-box">
            <a href=" {{url('blog/'.$post->user()->get()->pluck('display_name')[0].'/'.$post->slug)}} "><img src="{{ asset('/uploads/'.$post->page_image)}}" /></a>
            <div class="item-details">
                <h4>{{$post->title}}</h4>
                <div class="item-meta">{{ $post->user()->get()->pluck('display_name')[0]  }} -- {{$post->published_at}}</div>
                <div class="item-tag">
                    @foreach($post->tags()->get()->pluck('tag') as $tags)
                        <a>{{ $tags }}&nbsp;</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
@stop
