@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | New Post</title>
@stop

@section('content')
    <section id="main">

        @include('backend.partials.sidebar-navigation')

        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li><a href="/admin/post">Posts</a></li>
                            <li class="active">New Post</li>
                        </ol>

                        @include('shared.errors')

                        @include('shared.success')

                        <h2>Create a New Post</h2>
                    </div>
                    <div class="card-body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="postCreate" action="{{ route('admin.post.store') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            @include('backend.post.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
                                &nbsp;
                                <a href="/admin/post"><button type="button" class="btn btn-link">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.post.partials.editor')

    {!! JsValidator::formRequest('App\Http\Requests\PostCreateRequest', '#postCreate'); !!}

    @include('backend.shared.notifications.protip')

    <script>
        $(function () {
            $('.datetime-picker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                defaultDate: Date.now()
            });
            $('input[name="title"]').keyup(function(){
                $('input[name="slug"]').val(slugify($(this).val()));
            });
            function slugify(text) // https://gist.github.com/mathewbyrne/1280286
            {
                return text.toString().toLowerCase()
                        .replace(/\s+/g, '-')           // Replace spaces with -
                        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                        .replace(/^-+/, '')             // Trim - from start of text
                        .replace(/-+$/, '');            // Trim - from end of text
            }
        });
    </script>
@stop
