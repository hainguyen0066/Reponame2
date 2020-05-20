const loadIntro = (videoId) => {
    let video = document.getElementById(videoId);
    const videoUrl = video.getAttribute('data-url');
    if (!videoUrl) {
        console.log(`No video url defined in data-url attribute. ${videoUrl}`);
        return;
    }
    let req = new XMLHttpRequest();
    req.open('GET', videoUrl, true);
    req.responseType = 'blob';
    req.onload = function() {
        // Onload is triggered even on 404
        // so we need to check the status code
        if (this.status === 200) {
            let videoBlob = this.response;
            // Video is now downloaded
            // and we can set it as source on the video element

            video.src = URL.createObjectURL(videoBlob);
            video.className += ' active';
            video.play();
        }
    };
    req.onerror = function() {
        console.log(`Error on loading video ${videoUrl}`);
    };
    req.send();
};

export default loadIntro;
