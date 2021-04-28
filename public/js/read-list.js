
// Remove saved list
$(document).on('click', '.remove-bookmark', function () {
    let postId = $(this).data('ip');
    let thisParent = $(this).parent().parent().parent();

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
                let cookie = getCookie('bookmark');
                let arrCookie = cookie.split('/');

                // Check in bookmark cookie
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
                    // Remove, show empty list, set value submenu
                    thisParent.fadeOut(function () {
                        $(this).remove();
                        if ($('.post-rl').length == 0) {
                            // Change text
                            $('.show-bm-rl').text(`Saved`);
                            // Change empty list
                            $('hr').append(`
                                <div class="empty-rl mt-8 flex flex-col md:flex-row items-center rounded-sm text-sm md:text-base py-5 px-3 xs:px-5 md:px-13">
                                    <img class="w-25 h-25 mr-0 md:mr-10" src="/img/undraw_empty.png" alt="">
                                    <div class="mt-4 md:mt-0">
                                        <p class="text-center md:text-left">You haven’t saved anything yet.</p>
                                        <div class="flex items-center justify-center md:justify-start">Tap the 
                                            <svg class="w-5 md:w-6 h-5 md:h-6 mx-1" viewBox="0 0 25 25" fill="currentColor">
                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                            </svg>
                                            icon on posts to save them for later.
                                        </div>
                                    </div>
                                </div>
                            `);
                        } else {
                            sizeOfArray = $('.post-rl').length;
                            $('.show-bm-rl').text(`Saved (${sizeOfArray})`);
                        }
                    });
                }
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Remove archived list
$(document).on('click', '.remove-archive', function () {
    let postId = $(this).data('ip');
    let thisParent = $(this).parent().parent().parent();

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
                let archive = getCookie('archive');
                let arrArchive = archive.split('/');

                // cek cookie archive
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

                // Remove, show empty list, set value submenu
                thisParent.fadeOut(function () {
                    $(this).remove();
                    if ($('.post-rl').length == 0) {
                        // Change text
                        $('.show-ar-rl').text(`Archived`);
                        // Add empty list
                        $('hr').append(`
                            <div class="empty-rl mt-8 flex flex-col md:flex-row items-center rounded-sm text-sm md:text-base py-5 px-3 xs:px-5 md:px-13">
                                <img class="w-25 h-25 mr-0 md:mr-10" src="/img/undraw_blank_canvas.png" alt="">
                                <div class="mt-4 md:mt-0">
                                    <p class="text-center md:text-left">After you’re finished with a saved story,</p>
                                    <div class="flex items-center justify-center md:justify-start">Tap the 
                                        <svg class="w-5 md:w-6 h-5 md:h-6 mx-1" viewBox="0 1 25 25" fill="currentColor">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.47 9.95h17v-3h-17v3zm16 1h1a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-17a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v9a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-9zm-1 0h-13v9h13v-9z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M9.47 12.45c0-.28.21-.5.48-.5h6.04c.27 0 .48.22.48.5 0 .27-.21.5-.48.5H9.95a.49.49 0 0 1-.48-.5z"></path>
                                        </svg>
                                        icon to store it here.
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        sizeOfArray = $('.post-rl').length;
                        $('.show-ar-rl').text(`Archived (${sizeOfArray})`);
                    }
                });
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Archivev Post Reading list Bookmarked
$(document).on('click', '.archive-rl', function () {
    let postId = $(this)[0].dataset.ip;
    let thisParent = $(this).parent().parent().parent();

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
                // tambahin post id ke archive cookie
                if (getCookie('archive')) {
                    let cookie = getCookie('archive');
                    let arrCookie = cookie.split('/');
                    if (arrCookie.indexOf(`${postId}`) == -1) {
                        let value = postId + '/' + cookie;
                        setCookie('archive', value, 7);
                    }
                } else {
                    setCookie('archive', postId, 7);
                }

                // remove from bookmarked list cookie
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
                }

                // Remove, show empty list, set value submenu
                thisParent.fadeOut(function () {
                    $(this).remove();
                    if ($('.post-rl').length == 0) {
                        // Set text
                        $('.show-bm-rl').text(`Saved`);
                        // Set empty list
                        $('hr').append(`
                            <div class="empty-rl mt-8 flex flex-col md:flex-row items-center rounded-sm text-sm md:text-base py-5 px-3 xs:px-5 md:px-13">
                                <img class="w-25 h-25 mr-0 md:mr-10" src="/img/undraw_empty.png" alt="">
                                <div class="mt-4 md:mt-0">
                                    <p class="text-center md:text-left">You haven’t saved anything yet.</p>
                                    <div class="flex items-center justify-center md:justify-start">Tap the 
                                        <svg class="w-5 md:w-6 h-5 md:h-6 mx-1" viewBox="0 0 25 25" fill="currentColor">
                                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                        </svg>
                                        icon on posts to save them for later.
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        sizeOfArray = $('.post-rl').length;
                        $('.show-bm-rl').text(`Saved (${sizeOfArray})`);
                    }
                    // Set text archived
                    let cookie = getCookie('archive');
                    let arrCookie = cookie.split('/');
                    let sizeArchive = arrCookie.length;
                    $('.show-ar-rl').text(`Archived (${sizeArchive})`);
                });
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Btn show bookmark/saved post
$(document).on('click', '.show-bm-rl', function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/list/saved`,
        method: 'get',
        success: function (response) {
            let allContentRL = $(response).find('.all-content-rl');
            $('.all-content-rl').replaceWith(allContentRL);

            if (document.location.pathname != '/list/saved') {
                window.history.pushState('', 'Adityaptrp', '/list/saved');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Btn show Archived post
$(document).on('click', '.show-ar-rl', function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/list/archived`,
        method: 'get',
        success: function (response) {
            let allContentRL = $(response).find('.all-content-rl');
            $('.all-content-rl').replaceWith(allContentRL);

            if (document.location.pathname != '/list/archived') {
                window.history.pushState('', 'Adityaptrp', '/list/archived');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Popstate / Back btn browser
$(window).on('popstate', function() {
    if (document.location.pathname == '/list/saved') {
        $(document).find('.show-bm-rl').click();
    }
    if (document.location.pathname == '/list/archived') {
        $(document).find('.show-ar-rl').click();
    }
});