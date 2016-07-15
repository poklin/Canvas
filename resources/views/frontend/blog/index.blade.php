@extends('frontend.layout')

@section('title')
    <title>{{ $tag->title or config('blog.title') }}</title>
@stop

@section('content')

    <div id="container"></div>
    <script type="text/x-handlebars-template" id="waterfall-tpl">
        {{#result}}
        <div class="item">
            <a href="#"><img src="{{image}}" width="{{width}}" height="{{height}}" /></a>
            <div>
                <p>{{desp}}</p>
            </div>
        </div>
        {{/result}}
    </script>
    <script>
        $('#container').waterfall({
            itemCls: 'item',
            colWidth: 222,
            gutterWidth: 15,
            gutterHeight: 15,
            checkImagesLoaded: false,
            path: function(page) {
                return 'data/data1.json?page=' + page;
            }
        });
    </script>
@stop