
// Nprogress Run
// LOADER
NProgress.start();
NProgress.configure({ minimum: 0.1 });
NProgress.configure({ easing: 'ease', speed: 800 });
NProgress.configure({ trickleSpeed: 500 });
$(window).on('load', function(){
    NProgress.done();
});

// Auto like post highlight
$(document).on('click', '.auto-like', function () {
    console.log('sukses')
    localStorage.setItem('like-hs', true);
})

// auto open comment
$(document).on('click', '.auto-op-comment', function () {
    console.log('sukses')
    localStorage.setItem('comment-open', true);
})

// Navigation Slide Down
$('.nav-burger').on('click', function() {
    $('.nav-burger path:first-child, .nav-burger path:nth-child(2)').toggleClass('block').toggleClass('hidden');

    const scrollHeightNavMenu = $('.navigation-menu').prop('scrollHeight');
    if ($('.nav-burger path:first-child').hasClass('hidden')) {
            $('.navigation-menu').css('maxHeight', `${scrollHeightNavMenu+1}px`); // +1 untuk biar keliatan bordernya
    } else {
        $('.navigation-menu').css('maxHeight', '');
    }
})

// Dropdown Navigation



// ketika submit Footer
$('#formFooterWa').submit(function() {
    let valInputMessage = $('#footerInput').val();

    if (valInputMessage) {
        // var href = `https://wa.me/62895352432667?text=${val}`;
        // var href = `mailto:sp.adityaptrp@gmail.com?subject=${val}`;

        // https://mail.google.com/mail/?view=cm&fs=1&tf=1
        // and add &to=ADDY for the address
        // and &su=SUBJECT for the subject
        // and &body=MESSAGE for the body
        // var href = `https://mail.google.com/mail/?view=cm&source=mailto&to=sp.adityaptrp@gmail.com&su=${val}`;
        
        let href = checkWIndows(valInputMessage);
        sendEmail(href);
    }
    else {
        $('#footerInput').focus();
    }
    return false;
})

function checkWIndows(valInputMessage) {
    if ($( window ).width() <= 768) {
        return `mailto:sp.adityaptrp@gmail.com?subject=${valInputMessage}`;
    } else {
        return `https://mail.google.com/mail/?view=cm&source=mailto&to=sp.adityaptrp@gmail.com&su=${valInputMessage}`;
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


// Scroll to top btn
$(".scroll-top").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
});
// show btn scroll to top
$(document).scroll(function () {
    let body = $('#contentPage');
    if ($(document).scrollTop() > 200) {
        $(".scroll-top").css('bottom', '50px');
        if ($(document).scrollTop() > (body.height() - 350)) {
            $(".scroll-top").css('bottom', '-50px');
        } else {
            $(".scroll-top").css('bottom', '50px');
        }
    } else {
        $(".scroll-top").css('bottom', '-50px');
    }
});

// Custom Alert
async function modalConfirm(message, textBtn, btnColor) {
    return new Promise((complete, failed) => {
        
        $('.modal-body-c').find('h2').text(message);
        let btn = $('.modal-body-c').find('#modalYes');
        btn.text(textBtn);

        if (btn.hasClass('bg-red-500 hover:bg-red-600')) {
            btn.removeClass('bg-red-500 hover:bg-red-600');
            btn.addClass(btnColor);
        }
        if (btn.hasClass('bg-green-500 hover:bg-green-600')) {
            btn.removeClass('bg-green-500 hover:bg-green-600');
            btn.addClass(btnColor);
        }
        if (btn.hasClass('bg-yellow-500 hover:bg-yellow-600')) {
            btn.removeClass('bg-yellow-500 hover:bg-yellow-600');
            btn.addClass(btnColor);
        }

        $('.modal-alert').fadeIn(500);
        $('.modal-body-c').addClass('on');

        $('#modalYes').on('click', ()=> {
            $('.modal-alert').fadeOut(500); complete(true);
            $('.modal-body-c').removeClass('on');
        });
        $('#modalNo').on('click', ()=> { 
            $('.modal-alert').fadeOut(500); complete(false);
            $('.modal-body-c').removeClass('on');
        });
    });
}
$(document).on('click', '.fade-effect-modal, .close-modal', function() {
    $('.modal-body-c').removeClass('on');
    $('.modal-alert').fadeOut(500);
})


// Show and hide Comment Unapproved
$(document).on('click', '.open-nav-notif', function() {
    $('.c-list-unapproved').fadeIn();
    $('.content-lu').addClass('on');
})
$(document).on('click', '.fade-list-unapproved, .close-cu', function() {
    $('.c-list-unapproved').fadeOut();
    $('.content-lu').removeClass('on');
})


// Delete Comment Unapproved
$(document).on('click', '.delete-cu', async function() {
    let commentId = $(this).data('comment-id');
    let isHome = $(this).data('is-home');
    let thisComment = $(this).parent().parent().parent();
    let dataCookie = $('#dataCookie').data('cookie');

    // modal
    const confirm = await modalConfirm('Are you sure to delete this response ? You will not be able to recover this response!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    if(!confirm){
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/delete`,
        method: 'delete',
        data: {'commentId': commentId, 'dataCookie': dataCookie, 'isHome': isHome},
        success: function (response) {
        
            // refresh all comment approved
            $(document).find('.all-comment').html(response.viewListCA);

            // remove this comment with hr
            thisComment.fadeOut("slow", function() {
                thisComment.remove();
            });

            // append empty comment in list CU
            console.log($(document).find('.all-list-cu').children().length)
            if ($(document).find('.all-list-cu').children().length == 1) {
                setTimeout(() => {
                    $(document).find('.empty-cu').removeClass('hidden').addClass('flex');
                    $(document).find('.nav-notif-bullet').remove();
                }, 600);
            }

            // append empty comment in list all comment
            console.log($(document).find('.all-comment').children().length);
            if ($(document).find('.all-comment').children().length == 0) {
                setTimeout(() => {
                    $(document).find('.empty-comment').removeClass('hidden').addClass('flex');
                }, 700);
            }

            // replace size of comment
            $('.nav-notif-bullet').html(response.sizeOfAllCU);
            $('.t-cu-size').html(`
                Comment Unapproved (${response.sizeOfAllCU})
            `);
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// set empty comment
$(document).ready(function () {
    if ($(document).find('.empty-cu').prev().children().length == 0) {
        $(document).find('.empty-cu').addClass('flex');
        $(document).find('.empty-cu').removeClass('hidden');
    }
})

// Go to comment unapproved
$(document).on('click', '.goViewCU', function() {
    let commentId = $(this).data('comment-id');
    localStorage.setItem('viewCU', commentId);
})

// Approve Comment in List CU
$(document).on('click', '.approve-comment-l', async function() {
    let commentId = $(this).data('comment-id');
    let isHome = $(this).data('is-home');
    let thisComment = $(this).parent().parent().parent();
    let dataCookie = $('#dataCookie').data('cookie');
    // modal
    const confirm = await modalConfirm('Are you sure to approve this response ?', 'Approve', 'bg-green-500 hover:bg-green-600');
    if(!confirm){
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/approve`,
        method: 'post',
        data: {'commentId': commentId, 'dataCookie': dataCookie, 'isHome': isHome},
        success: function (response) {
            thisComment.fadeOut("slow", function() {
                thisComment.remove();
            });

            if ($('.all-comment').length != 0) {
                $('.all-comment').html(response.viewComment);
            }

            // append empty comment
            if ($(document).find('.all-list-cu').children().length == 1) {
                setTimeout(() => {
                    $(document).find('.empty-cu').removeClass('hidden').addClass('flex');
                    $(document).find('.nav-notif-bullet').remove();
                }, 600);
            }

            // replace size of comment unapproved
            $('.nav-notif-bullet').html(response.sizeOfAllCU);
            $('.t-cu-size').html(`
                Comment Unapproved (${response.sizeOfAllCU})
            `);

            // replace size of comment approved
            $('.responses-comment').html(`
                Responses (${response.sizeOfAllCA})
            `);
            $('.content-responses').html(`${response.sizeOfAllCA}`);
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Approve Whithout Link
$(document).on('click', '.approve-cwl-l', async function () {
    let commentId = $(this).data('comment-id');
    let thisComment = $(this).parent().parent().parent();
    let dataCookie = $('#dataCookie').data('cookie');
    // modal
    const confirm = await modalConfirm('Are you sure to approve this response without link ?', 'Approve', 'bg-green-500 hover:bg-green-600');
    if(!confirm){
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/approve`,
        method: 'post',
        data: {'commentId': commentId, 'dataCookie': dataCookie, 'withoutLink': true},
        success: function (response) {
            thisComment.fadeOut("slow", function() {
                if (thisComment.next().is('hr')) {
                    thisComment.next().remove();
                }
                thisComment.remove();
            });

            if ($('.all-comment').length != 0) {
                $('.all-comment').html(response.viewComment);
            }

            // append empty comment
            if ($(document).find('.all-list-cu').children().length == 2) {
                setTimeout(() => {
                    $(document).find('.empty-cu').removeClass('hidden').addClass('flex');
                    $(document).find('.nav-notif-bullet').remove();
                }, 600);
            }

            // replace size of comment unapproved
            $('.nav-notif-bullet').html(response.sizeOfAllCU);
            $('.t-cu-size').html(`
                Comment Unapproved (${response.sizeOfAllCU})
            `);

            // replace size of comment approved
            $('.responses-comment').html(`
                Responses (${response.sizeOfAllCA})
            `);
            $('.content-responses').html(`${response.sizeOfAllCA}`);
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// check notif new post clicked
$(document).ready(function() {
    let postId = $('.notif-n-post').data('ip');
    if (localStorage.getItem('alertNewPost') != postId) {
        $('.nav-bullet-np').addClass('on');
    }
})
// Open Alert Notif New Post
$(document).on('click', '.nav-notif-np', function () {
    $(document).find('.notif-n-post').fadeIn();
    $('.c-notif-np').addClass('on');
    let postId = $('.notif-n-post').data('ip');
    localStorage.setItem('alertNewPost', postId);

    $('.nav-bullet-np').removeClass('on');
})

// Close fade effect
let alertNewPost = document.querySelector('.notif-n-post');
$(document).on('mousedown', '.close-panel', function(e) {
    if (e.target == alertNewPost) {
        $(alertNewPost).fadeOut();
        $('.c-notif-np').removeClass('on');
    }
})
$(document).on('click', '.close-notif-np', function () {
    $(alertNewPost).fadeOut();
    $('.c-notif-np').removeClass('on');
})


// btn bookmark post
$(document).on('click', '.bookmark-post', function () {
    let postId = $(this)[0].dataset.ip;

    if ($(this).find('svg').hasClass('bookmarked')) {
        $(`.bookmark-post[data-ip="${postId}"]`).find('svg').replaceWith(`
            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
            </svg>
        `);
        $(`.bookmark-post[data-ip="${postId}"]`).attr('title', 'Save post');
        if (getCookie('bookmark')) {
            let cookie = getCookie('bookmark');
            let arrCookie = cookie.split('/');
            const index = arrCookie.indexOf(`${postId}`);
            if (index > -1) {
                let nCookie;
                arrCookie.splice(index, 1);
                nCookie = arrCookie.join('/');
                if (nCookie == '') {
                    eraseCookie('bookmark');
                } else {
                    setCookie('bookmark', nCookie, 7);
                }
            }
        } else {
            return false;
        }
    } else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/checkPostId`,
            method: 'post',
            data: {'postId': postId},
            success: function (response) {
                console.log(response)
                if (response != 0) {
                    console.log('sukses')
                    console.log(postId)
                    $(`.bookmark-post[data-ip="${response.id}"], .bookmark-post[data-ip="${postId}"]`).find('svg').replaceWith(`
                        <svg class="bookmarked w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13c.2.18.52.17.71-.03a.5.5 0 0 0 .12-.29H19V6z"></path>
                        </svg>
                    `);
                    $(`.bookmark-post[data-ip="${response.id}"], .bookmark-post[data-ip="${postId}"]`).attr('title', 'Unsave post');
                    if (getCookie('bookmark')) {
                        let cookie = getCookie('bookmark');
                        let arrCookie = cookie.split('/');
                        if (arrCookie.indexOf(`${postId}`) == -1) {
                            let value = postId + '/' + cookie;
                            setCookie('bookmark', value, 7);
                        }
                    } else {
                        console.log('buat cookie')
                        setCookie('bookmark', postId, 7);
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
})

// Btn Remove post in archived list
$(document).on('click', '.remove-ar-p', function () {
    let postId = $(this).data('ip');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/checkPostId`,
        method: 'post',
        data: {'postId': postId},
        success: function (response) {
            if (response != 0) {
                // cek archive cookie
                let archive = getCookie('archive');
                let arrArchive = archive.split('/');
                const indexAr = arrArchive.indexOf(`${postId}`);
                if (indexAr > -1) {
                    let nCookie;
                    arrArchive.splice(indexAr, 1);
                    nCookie = arrArchive.join('/');
                    if (nCookie == '') {
                        eraseCookie('archive');
                    } else {
                        setCookie('archive', nCookie, 7);
                    }
                }
                // change button to normal
                $(`.p-archived[data-ip="${postId}"]`).parent().attr('title', 'Save post');
                $(`.p-archived[data-ip="${postId}"]`).replaceWith(`
                    <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                        <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                    </svg>
                `);
                // set class untuk bisa bookmark lagi langsung
                $(`.remove-ar-p[data-ip="${postId}"]`).removeClass('remove-ar-p').addClass('bookmark-post');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Show dropdown social media and setting
$(document).on('click', '.open-dd-post', function (e) {
    console.log($(this))
    let thisParent = $(this).parent();
    if (thisParent.find('.show-dd-post').length != 0) {
        if (thisParent.find('.show-dd-post').hasClass('active')) {
            thisParent.find('.show-dd-post').removeClass('active');
        } else {
            $('.show-dd-post').removeClass('active');
            thisParent.find('.show-dd-post').addClass('active');
        }
    }
})
// Auto close Dropdown
$(document).on('click', function (e) {
    let thisEl = $(e.target);
    // auto close dropdown sosmed and setting
    if (!thisEl.hasClass('open-dd-post') && !thisEl.hasClass('show-dd-post')) {
        $('.show-dd-post').removeClass('active');
    }
})
// Copy URL of current page
$(document).on('click', '.copy-url', function() {
    const link = $(this).data('url');

    // navigator.clipboard.writeText(link);
    var input = document.createElement('textarea');
    input.innerHTML = link;
    document.body.appendChild(input);

    input.select();
    input.setSelectionRange(0, 99999); /* For mobile devices */

    document.execCommand('copy');
    document.body.removeChild(input);
    $('#app').append(`
    <div class="flash-message">
        <p>Successfully copied the link.</p>
    </div>
    `);
    setTimeout(() => {
        $('.flash-message').remove();
    }, 2000);
})
// Share to facebook
$(document).on('click', '.share-to-facebook', function () {
    let url = $(this).data('url');
    let w = 500, h = 420;
    let left = (screen.width/2)-(w/2);
    let top = (screen.height/2)-(h/2)-40; //khusus facebook benernya defaul middle -10
    window.open(url, '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left).focus();
})

// Remove border List posts
if($('.list-p-all')) {
    if ($('.list-p-all').data('paginate') == 1) {
        $('.list-p-all').find('.list-post').last().removeClass('border-b');
    }
}


// close alert flash message
$(document).on('click', '.close-flash-message', function () {
    $(this).parent().remove();
})




























// Functional __construct

// Force Reload Page when back and forward button clicked
var perfEntries = performance.getEntriesByType("navigation");

if (perfEntries[0].type === "back_forward") {
    localStorage.removeItem('viewCU');
    localStorage.removeItem('comment-open');
    localStorage.removeItem('play_video');
    localStorage.removeItem('active_edit_profile');
    location.reload();
}

// Set Get Cookie
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

// EVENT BINDING BUATAN KETIKA EL DELETE JALANKAN SESUATU
(function($){
    // destroyed nama event bindingnya jadi bisa buat event apapun
    $.event.special.destroyed = {
    remove: function(o) {
        if (o.handler) {
        o.handler()
        }
    }
    }
})(jQuery)