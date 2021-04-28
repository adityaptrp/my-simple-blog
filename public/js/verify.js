// Nprogress Run
// LOADER
NProgress.start();
NProgress.configure({ minimum: 0.1 });
NProgress.configure({ easing: 'ease', speed: 800 });
NProgress.configure({ trickleSpeed: 500 });
$(window).on('load', function(){
    NProgress.done();
});


// back home button position
// setTimeout(() => {
//     if($( window ).width() >=  768) {
//         let titleHeight = $('.message-verify h1').position().top;
//         $('.verify-back-btn').attr('style', `top: ${titleHeight}px;`);
//     }
// }, 100);

// $(window).on('resize', function(){
//     if($( window ).width() >=  768) {
//         let titleHeight = $('.message-verify h1').position().top;
//         console.log(titleHeight)
//         $('.verify-back-btn').attr('style', `top: ${titleHeight}px;`);
//     } else if ($( window ).width() <=  768 && $( window ).width() >=  360) {
//         $('.verify-back-btn').attr('style', `top: 25px; left:25px`);
//     } else {
//         $('.verify-back-btn').attr('style', `top: 15px; left:24px`);
//     }
// });

// Submit verify email form
$(document).on('click', '.verify-resend-email', function () {
    $(this).attr("disabled", true);
    $(this).css("background-color", 'rgba(72, 187, 120, .9)');
    $('.form-verify-resend').submit();
})

// Conntact support
$(document).on('click', '.verify-contact-supp', function () {
    let emailSetting = $(this).data('e');
    let href = checkWIndows(emailSetting);
    sendEmail(href);
})
function checkWIndows(emailSetting) {
    if ($( window ).width() <= 1023) {
        // mailto:someone@yoursite.com?cc=someoneelse@theirsite.com, another@thatsite.com, me@mysite.com&bcc=lastperson@theirsite.com&subject=Big%20News&body=Body-goes-here
        return `mailto:${emailSetting}`;
    } else {
        // https://mail.google.com/mail/?view=cm&fs=1&to=someone@example.com&su=SUBJECT&body=BODY&bcc=someone.else@example.com
        return `https://mail.google.com/mail/?view=cm&source=mailto&to=${emailSetting}`;
    }
}
function sendEmail(href) {
    if ($( window ).width() <= 1023) {
        window.location.href = href;
    } else {
        let w = 500, h = 420;
        let left = (screen.width/2)-(w/2);
        let top = (screen.height/2)-(h/2)-10;
        window.open(href, '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left).focus();
    }
}