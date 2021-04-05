<script>
    window.user_id = '{{ \Auth::check() ? \Auth::user()->id : '' }}';
</script>
<script type="text/javascript" src="{{ staticUrl('js/app.js', true) }}"></script>
