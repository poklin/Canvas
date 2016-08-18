<script>

    $('button.followButton').on('click', function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        e.preventDefault();
        $button = $(this);
        if($button.hasClass('following')){

            //Do Unfollow
            $.ajax({
                method: "POST",
                url: "{{ url('auth/unfollow') }}", // This is what I have updated
                data: {id: "{{ $post->user_id }}"},
                success: function (data) {
                    alert(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $button.removeClass('following');
            $button.removeClass('unfollow');
            $button.text('Follow');
        } else {
            // Do follow
            $.ajax({
                method: "POST",
                url: "{{ url('auth/follow') }}", // This is what I have updated
                data: {id: "{{ $post->user_id }}"},
                success: function (data) {
                    alert(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $button.addClass('following');
            $button.text('Following');
        }
    });

    $('button.followButton').hover(function(){
        $button = $(this);
        if($button.hasClass('following')){
            $button.addClass('unfollow');
            $button.text('Unfollow');
        }
    }, function(){
        if($button.hasClass('following')){
            $button.removeClass('unfollow');
            $button.text('Following');
        }
    });
</script>