@extends('frontend.layout', [
  'title' => $post->title,
  'meta_description' => $post->meta_description ?: config('blog.description'),
])

@if ($post->page_image)
    @section('og-image')
        <meta property="og:image" content="{{ $post->page_image }}">
    @stop
@endif

@section('og-title')
    <meta property="og:title" content="{{ $post->title }}"/>
@stop

@section('og-description')
    <meta property="og:description" content="{{ $post->meta_description }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('title')
    <title>{{ $title or config('blog.title') }}</title>
@stop

@section('content')
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

                    @if ($post->page_image)
                        <div class="text-center">
                            <img src="{{ asset('uploads/' . $post->page_image) }}" class="post-hero">
                        </div>
                    @endif
                    <p class="post-page-meta">
                        {{ \Carbon\Carbon::parse($post->created_at)->toFormattedDateString() }}
                        @if ($post->tags->count())
                            in
                            {!! join(', ', $post->tagLinks()) !!}
                        @endif
                    </p>
                    <h1 class="post-page-title">{{ $post->title }}</h1>
                        <div class="meta">by {{ $post->user()->get()->pluck('display_name')[0] }}</div>
                        @if( Auth::check() && (Auth::user()->id != $post->user_id))
                            @if(Auth::user()->followees()->get()->pluck('id')->contains($post->user_id))
                                <button class="btn followButton following" rel="6">Follow</button>
                            @else
                                <button class="btn followButton" rel="6">Follow</button>
                            @endif
                        @endif

                    <hr>
                    {!! $post->content_html !!}
                </div>
            </div>
        </div>
    </article>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="pager">
                    @if ($tag && $tag->reverse_direction)
                        @if ($post->olderPost($tag))
                            <li class="previous">
                                <a href="{{ URL::to('/blog/'.Auth::user()->display_name.'/'.$post->olderPost($tag)->slug) }}">
                                    <i class="fa fa-angle-left fa-lg"></i>
                                    Previous {{ $tag->tag }}
                                </a>
                            </li>
                        @endif
                        @if ($post->newerPost($tag))
                            <li class="next">
                                <a href="{{ URL::to('/blog/'.Auth::user()->display_name.'/'.$post->newerPost($tag)->slug) }}">
                                    Next {{ $tag->tag }}
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        @endif
                    @else
                        @if ($post->newerPost($tag))
                            <li class="previous">
                                <a href="{{ URL::to('/blog/'.Auth::user()->display_name.'/'.$post->newerPost($tag)->slug) }}">
                                    <i class="fa fa-angle-left fa-lg"></i>
                                    Newer
                                </a>
                            </li>
                        @endif
                        @if ($post->olderPost($tag))
                            <li class="next">
                                <a href="{{ URL::to('/blog/'.Auth::user()->display_name.'/'.$post->olderPost($tag)->slug) }}">
                                    Older
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
@stop

@section('unique-js')

    @include('frontend.blog.partials.follow')

@stop