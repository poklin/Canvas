<style type="text/css">
    button.show-password{
        background-color: #2196f3;
        border: 1px solid #128ef1;
        border-radius: 2px;
        color: #fff;
        font-size: 0.9em;
        opacity: .5;
        position: absolute;
        right: 0;
        top: 0;
    }
    button.show-password:hover{
        background-color: #128ef1;
        transition: all .8s linear;
    }
</style>

<script>
    (function(){
        $('input[name="password"], input[name="new_password"], input[name="new_password_confirmation"]').parent().append('<button type="button" class="show-password"><i class="zmdi zmdi-eye"></i></button>');
        function toggleIcon (elem) {
            if ( elem.hasClass ( 'zmdi-eye' ) ) {
                return elem.removeClass ( 'zmdi-eye' ).addClass ( 'zmdi-eye-off' );
            }
            return elem.removeClass ( 'zmdi-eye-off' ).addClass ( 'zmdi-eye' );
        }
        function toggleType (elem) {
            return (elem.attr ( 'type' ) === 'password') ? 'text' : 'password';
        }
        $('body').on('click', '.show-password', function (e) {
            var password_field = $(this).siblings('input');
            var new_type = toggleType( password_field );
            var current_icon = $(this).children('i');
            toggleIcon(current_icon);
            password_field.attr('type', new_type);
            e.preventDefault();
        });
    })();
</script>