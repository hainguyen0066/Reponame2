import alertify from 'alertifyjs';
alertify.set('notifier','position', 'top-right');
$(document).ready(() => {
    $('.coming-soon').click((e) => {
        e.preventDefault();
        alertify.notify("Coming Soon! Vui lòng quay lại vào 28-12-2018");
    });
})
