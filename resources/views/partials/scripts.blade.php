<script>
    window.user_id = '{{ \Auth::check() ? \Auth::user()->id : '' }}';
</script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
{{--<script type="text/javascript" src="{{ mix('js/account.js') }}"></script>--}}
