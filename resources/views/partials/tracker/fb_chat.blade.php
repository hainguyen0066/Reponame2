@if(config("tracker.fb.chat_popup.enabled") && config("site.fb.page_id") && env('APP_ENV') == 'prod')
    <div class="fb-customerchat"
         page_id="{{ config("site.fb.page_id") }}"
         theme_color="{{ config("tracker.fb.chat_popup.theme_color") }}"
         logged_in_greeting="{{ config("tracker.fb.chat_popup.logged_in_greeting") }}"
         logged_out_greeting="{{ config("tracker.fb.chat_popup.logged_out_greeting") }}"
         locale="{{ config("tracker.fb.chat_popup.locale") }}"
    ></div>
@endif
