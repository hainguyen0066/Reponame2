@if(config("site.fb.app_id"))
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '{{ config('site.fb.app_id') }}',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.2'
            });
        };
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif
