const loadIntro = (videoId) => {
    let tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    let player;
    window.onYouTubeIframeAPIReady = () => {
        player = new YT.Player('intro', {
            version: 3,
            height: '1920',
            width: '1080',
            videoId: 'A4PYNJdbxnk',
            playerVars: {
                playlist: 'A4PYNJdbxnk',
                enablejsapi: 1,
                modestbranding: 1,
                fs: 0,
                playsinline: 1,
                controls: 0,
                loop: 1,
                autoplay: 1,
                disablekb: 1,
                showinfo: 0,
                vq: 'hd1080',
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': showIntro,
            }
        });
    }
    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
    }
    function showIntro(state) {
        if (state.data === 3) {
            $('#intro-container').removeClass('active');
        }
        if (state.data === 1) {
            setTimeout(() => {
                $('#intro-container').addClass('active');
            }, 500);
        }
    }
};

export default loadIntro;
