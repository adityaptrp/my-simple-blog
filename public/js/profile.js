
// auto like post
$(document).on('click', '.like-hs', function () {
    localStorage.setItem('like-hs', true);
})

// auto open comment
$(document).on('click', '.comment-ph', function () {
    localStorage.setItem('comment-open', true);
})

// auto open edit profile
if(localStorage.getItem('active_edit_profile')) {
    $('.edit-profile-panel').fadeIn();
    $('.content-edit-profile').addClass('active');
    $('body').css('overflow', 'hidden');
}

// Show edit profile panel
$(document).on('click', '.edit-profile-p', function () {
    $('.edit-profile-panel').fadeIn();
    $('.content-edit-profile').addClass('active');
    $('body').css('overflow', 'hidden');
})

// Close edit profile panel
$(document).on('click', '.edit-profile-panel, .close-e-profile',function (e) {
    if ($(e.target).hasClass('edit-profile-panel') || $(e.target).hasClass('close-e-profile')) {
        $('.edit-profile-panel').fadeOut();
        $('.content-edit-profile').removeClass('active');
        $('body').css('overflow', 'auto');
        localStorage.removeItem('active_edit_profile');

        let encrypted = $('.edit-profile-panel').data('u');
        let username = window.atob(encrypted).slice(2, -2);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/profile/@${username}`,
            method: 'get',
            success: function (response) {
                $('.edit-profile-panel').replaceWith($(response).find('.edit-profile-panel'));
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
})

// LIke profile
$(document).on('click', '.like-profile', function () {
    let idEncrypted = $(this).data('u');
    let userId = window.atob(idEncrypted).slice(2, -2);
    let thisBtn = $(this);
    thisBtn.removeClass('like-profile');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/likes-profile/${userId}`,
        method: 'post',
        success: function (response) {
            $('.profile-c-likes').html(response);
            thisBtn.addClass('text-red-500').prepend(`<div class="liked-profile-effect text-1.5xl effect-liked-profile text-red-500"><i class="fas fa-heart"></i></div>`);
            thisBtn.find('.far.fa-heart').replaceWith(`<i class="fas fa-heart"></i>`);
            setTimeout(() => {
                thisBtn.find('div').remove();
            }, 1700);
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// load preview loadmore post
let pagePostList = 1;
$(document).ready(function (e) {
	appendPrevLoadMore(pagePostList);
})
function appendPrevLoadMore(pagePostList){
    let nextPage = pagePostList + 1;
    $.ajax({
        url: '?postList=' + nextPage,
        type: "get",
        datatype: "html"
    }).done(function(data) {
        if($(data).find('.list-post').first().length != 0) {
            $('.list-p-all').append($(data).find('.list-post').first().removeClass('border-b').addClass('load-more-pv'));
        }
    }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
    });
}
// Btn Load More
$(document).on('click', '.btn-loadmore', function (e) {
    let lastPage = $('.list-p-all').data('paginate');
    pagePostList++;
	loadMoreData(pagePostList, lastPage);
})
function loadMoreData(pagePostList, lastPage){
    $.ajax({
        url: '?postList=' + pagePostList,
        type: "get",
        datatype: "html",
        beforeSend: function()
        {
            $('.btn-loadmore').remove();
            $('.ajax-load').show();
        }
    }).done(function(data) {
        setTimeout(() => {
            $('.ajax-load').hide();
            $('.load-more-pv').remove();
            $('.list-p-all').append($(data).find('.list-p-all').html());
            appendPrevLoadMore(pagePostList);
            if(pagePostList == lastPage){
                $('.list-p-all').removeClass('pb-25').addClass('pb-5');
                $('.list-post')[$('.list-post').length-1].classList.remove('border-b');
                $('.btn-loadmore').remove();
                $('.dd-sosmed-atas').last().removeClass('dd-sosmed-atas').addClass('dd-sosmed-bawah');
                $('.triangle-sosmed-atas').last().removeClass('triangle-sosmed-atas').addClass('triangle-sosmed-bawah');
                $('.dd-setting-atas').last().removeClass('dd-setting-atas').addClass('dd-setting-bawah');
                $('.triangle-setting-atas').last().removeClass('triangle-setting-atas').addClass('triangle-setting-bawah');
                return false;
            }
        }, 1000);
    }).fail(function(jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}

// Remove border List posts
if($('.list-p-all')) {
    if ($('.list-p-all').data('paginate') == 1) {
        $('.dd-sosmed-atas').last().removeClass('dd-sosmed-atas').addClass('dd-sosmed-bawah');
        $('.triangle-sosmed-atas').last().removeClass('triangle-sosmed-atas').addClass('triangle-sosmed-bawah');
        $('.dd-setting-atas').last().removeClass('dd-setting-atas').addClass('dd-setting-bawah');
        $('.triangle-setting-atas').last().removeClass('triangle-setting-atas').addClass('triangle-setting-bawah');
    }
}

// Show  All Posts
$(document).on('click', '.profile-s-ap', function (e) {
    e.preventDefault();
    let idEncrypted = $(this).data('u');
    let username = window.atob(idEncrypted).slice(2, -2);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/profile/@${username}/all-posts`,
        method: 'get',
        success: function (response) {
            $('.profile-mc').replaceWith($(response).find('.profile-mc'));
            $('.menu-panel-profile').replaceWith($(response).find('.menu-panel-profile'));
            
            if (document.location.pathname != `/profile/@${username}/all-posts`) {
                window.history.pushState('', `${username} - Adityaptrp`, `/profile/@${username}/all-posts`);
            }
            // reset page
            pagePostList = 1;
            appendPrevLoadMore(pagePostList);
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Show Most Popular Posts 
$(document).on('click', '.profile-s-pm', function (e) {
    e.preventDefault();
    let idEncrypted = $(this).data('u');
    let username = window.atob(idEncrypted).slice(2, -2);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/profile/@${username}/most-popular`,
        method: 'get',
        success: function (response) {
            $('.profile-mc').replaceWith($(response).find('.profile-mc'));
            $('.menu-panel-profile').replaceWith($(response).find('.menu-panel-profile'));

            if (document.location.pathname != `/profile/@${username}/most-popular`) {
                window.history.pushState('', `${username} - Adityaptrp`, `/profile/@${username}/most-popular`);
            }

            // reset page
            pagePostList = 1;
            appendPrevLoadMore(pagePostList);
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Show Social media
$(document).on('click', '.profile-s-sm', function (e) {
    e.preventDefault();
    let idEncrypted = $(this).data('u');
    let username = window.atob(idEncrypted).slice(2, -2);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/profile/@${username}/social-media`,
        method: 'get',
        success: function (response) {
            $('.profile-mc').replaceWith($(response).find('.profile-mc'));
            $('.menu-panel-profile').replaceWith($(response).find('.menu-panel-profile'));

            if (document.location.pathname != `/profile/@${username}/social-media`) {
                window.history.pushState('', `${username} - Adityaptrp`, `/profile/@${username}/social-media`);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Popstate / Back btn browser
$(window).on('popstate', function() {
    let idEncrypted = $('.desc-profile').data('u');
    let username = window.atob(idEncrypted).slice(2, -2);

    if (document.location.pathname == `/profile/@${username}/all-posts`) {
        $(document).find('.profile-s-ap').click();
    }
    if (document.location.pathname == `/profile/@${username}/most-popular`) {
        $(document).find('.profile-s-pm').click();
    }
    if (document.location.pathname == `/profile/@${username}/social-media`) {
        $(document).find('.profile-s-sm').click();
    }
})








// Form Edit Profile
// On max length input
$(document).on('input valuechange', 'input[type="text"]', function () {
    let lengthVal = $(this).val().length;
    let maxLength = $(this).data('l');
    $(this).parent().find('label span').text(lengthVal);
    if (lengthVal > maxLength) {
        $(this).addClass('max').removeClass('focus:border-green-600').addClass('focus:border-red-600');
    } else {
        $(this).removeClass('max').removeClass('focus:border-red-600').addClass('focus:border-green-600');
    }
})

// change img edit profile
$(document).on('change', '#profile_picture, #banner', function () {
    const file = $(this)[0].files[0];
    const id = $(this).attr('id');
    // $('label[for="profile_picture"] img').attr('src', (window.URL || window.webkitURL).createObjectURL(file));
    let img = $(`label[for="${id}"] img`);
    const reader = new FileReader();

    if (file) {
        reader.readAsDataURL(file);
    }
    reader.addEventListener("load", function () {
        // convert image file to base64 string
        img.attr('src', reader.result)
    }, false);
});
$(document).on('click', '.btn-save-ep', function () {
    $('.form-e-profile form').submit();
})

// Banner edit profile
$(document).on('change', '#banner', function () {
    const file = $(this)[0].files[0];

    let img = $(`.banner-profile .banner-img`);
    const reader = new FileReader();

    if (file) {
        if(file.type.includes('video')) {
            $('#app').append(`
            <div class="flash-message">
                <span>Cannot use files other than images.</span>
                <div class="close-flash-message ml-3.5 -mr-1 cursor-pointer">
                    <svg class="nav-burger w-4 h-4 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                    </svg>
                </div>
            </div>
            `);
            setTimeout(() => {
                $('.flash-message').remove();
            }, 2000);
            return false;
        }
        reader.readAsDataURL(file);
    }
    reader.addEventListener("load", function () {
        // convert image file to base64 string
        img.css('background', ``);
        img.css('background-image', `url(${reader.result})`)

        $('.btn-rm-banner').removeClass('hidden').addClass('flex');
        $('.form-ep-banner input[type="checkbox"]').attr('checked', false);
        $('.btn-menu-profile').html(`
            <p class="save-ep-banner mr-1 px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Save Cover</p>
            <a class="close-ep-banner px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Cancel</a>
        `)
    }, false);
});
// Cancel edit banner
$(document).on('click', '.close-ep-banner', function () {
    if (BASE_URL_IMG) {
        $('.banner-img').css('background', '');
        $('.banner-img').css('background-image', BASE_URL_IMG);
        $('.btn-rm-banner').removeClass('hidden').addClass('flex');
    } else {
        $('.banner-img').css('background', BASE_CSS_BG);
        $('.banner-img').css('background-image', '');
        $('.btn-rm-banner').removeClass('flex').addClass('hidden');
    }
    $('.form-ep-banner input[type="checkbox"]').attr('checked', false);
    $('.form-ep-banner input[type="file"]').val('');
    $('.btn-menu-profile').html(`
        <a class="edit-profile-p px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Edit profile</a>
    `);
})

// submit form banner
$(document).on('click', '.save-ep-banner', function () {
    $('.form-ep-banner').submit();
})

// Remove banner
$(document).on('click', '.btn-rm-banner', function () {
    $('.form-ep-banner input[type="checkbox"]').attr('checked', true);
})

// Remove Banner edit clicked
$(document).on('click', '.btn-rm-banner', function () {
    $(this).removeClass('flex').addClass('hidden');
    $('.banner-img').css('background-image', ``);
    $('.banner-img').css('background', `#B2B2B2`);
    if ($('.save-ep-banner').length == 0) {
        $('.btn-menu-profile').html(`
            <p class="save-ep-banner mr-1 px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Save Cover</p>
            <a class="close-ep-banner px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Cancel</a>
        `)
    }
});