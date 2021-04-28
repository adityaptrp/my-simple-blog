

// Page
let pagePostSearch = 1;

// auto like post
$(document).on('click', '.like-hs', function () {
    localStorage.setItem('like-hs', true);
})

// auto focus input search
if($(document).find('.search-i').val() == '') {
    $(document).find('.search-i').focus();
}

// auto open comment
$(document).on('click', '.comment-ph', function () {
    localStorage.setItem('comment-open', true);
})

// btn serach all posts
$(document).on('click', '.search-ap', function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/search/all-posts`,
        method: 'get',
        success: function (response) {
            let allSearchResult = $(response).find('.search-mc');
            let navSearch = $(response).find('.nav-search');
            $('.search-mc').replaceWith(allSearchResult);
            $('.nav-search').replaceWith(navSearch);

            $(document).find('.search-i').val('');
            // reset page
            pagePostSearch = 1;

            if ($('.list-p-all').data('paginate') == 1) {
                $('.list-p-all').find('.list-post').last().removeClass('border-b');
                $('.list-p-all').removeClass('pb-30');
            }
            
            if (document.location.pathname != '/search/all-posts') {
                window.history.pushState('', 'Search and find - Adityaptrp', '/search/all-posts');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// btn popular posts
$(document).on('click', '.search-pp', function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/search/popular-posts`,
        method: 'get',
        success: function (response) {
            let allSearchResult = $(response).find('.search-mc');
            let navSearch = $(response).find('.nav-search');
            $('.search-mc').replaceWith(allSearchResult);
            $('.nav-search').replaceWith(navSearch);

            $(document).find('.search-i').val('');
            // reset page
            pagePostSearch = 1;

            if ($('.list-p-all').data('paginate') == 1) {
                $('.list-p-all').find('.list-post').last().removeClass('border-b');
                $('.list-p-all').removeClass('pb-30');
            }

            if (document.location.pathname != '/search/popular-posts') {
                window.history.pushState('', 'Search and find - Adityaptrp', '/search/popular-posts');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// btn popular Tags
$(document).on('click', '.search-pct', function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/search/popular-categories-tags`,
        method: 'get',
        success: function (response) {
            let allSearchResult = $(response).find('.search-mc');
            let navSearch = $(response).find('.nav-search');
            $('.search-mc').replaceWith(allSearchResult);
            $('.nav-search').replaceWith(navSearch);

            $(document).find('.search-i').val('');
            // reset page
            pagePostSearch = 1;

            if ($('.list-p-all').data('paginate') == 1) {
                $('.list-p-all').find('.list-post').last().removeClass('border-b');
                $('.list-p-all').removeClass('pb-30');
            }

            if (document.location.pathname != '/search/popular-categories-tags') {
                window.history.pushState('', 'Search and find - Adityaptrp', '/search/popular-categories-tags');
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// btn view post Tags
$(document).on('click', '.s-posttag-v', function(e) {
    e.preventDefault();
    let tagSlug = $(this).data('tag-s');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/tag/${tagSlug}`,
        method: 'get',
        success: function (response) {
            let allSearchResult = $(response).find('.search-mc');
            let navSearch = $(response).find('.nav-search');
            $('.search-mc').replaceWith(allSearchResult);
            $('.nav-search').replaceWith(navSearch);

            $(document).find('.search-i').val('');
            // reset page
            pagePostSearch = 1;

            if ($('.list-p-all').data('paginate') == 1) {
                $('.list-p-all').find('.list-post').last().removeClass('border-b');
                $('.list-p-all').removeClass('pb-30');
            }

            if (document.location.pathname != `/tag/${tagSlug}`) {
                window.history.pushState('', 'Search and find - Adityaptrp', `/tag/${tagSlug}`);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// btn view post category
$(document).on('click', '.s-category-v', function(e) {
    e.preventDefault();
    let categorySlug = $(this).data('category-s');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/category/${categorySlug}`,
        method: 'get',
        success: function (response) {
            let allSearchResult = $(response).find('.search-mc');
            let navSearch = $(response).find('.nav-search');
            $('.search-mc').replaceWith(allSearchResult);
            $('.nav-search').replaceWith(navSearch);

            $(document).find('.search-i').val('');
            // reset page
            pagePostSearch = 1;

            if ($('.list-p-all').data('paginate') == 1) {
                $('.list-p-all').find('.list-post').last().removeClass('border-b');
                $('.list-p-all').removeClass('pb-30');
            }

            if (document.location.pathname != `/category/${categorySlug}`) {
                window.history.pushState('', 'Search and find - Adityaptrp', `/category/${categorySlug}`);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Popstate / Back btn browser
$(window).on('popstate', function() {
    if (document.location.pathname == '/search/all-posts') {
        $(document).find('.search-ap').click();
        // reset page
        pagePostSearch = 1;
    }
    if (document.location.pathname == '/search/popular-posts') {
        $(document).find('.search-pp').click();
        // reset page
        pagePostSearch = 1;
    }
    if (document.location.pathname == '/search/popular-categories-tags') {
        $(document).find('.search-pct').click();
        // reset page
        pagePostSearch = 1;
    }

    // back search tag
    let pathname = document.location.pathname;
    if (pathname.includes('/tag/')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: pathname,
            method: 'get',
            success: function (response) {
                let resVal = $(response).find('.search-i').val();
                $(document).find('.search-i').val(resVal);

                let allSearchResult = $(response).find('.search-mc');
                let navSearch = $(response).find('.nav-search');
                $('.search-mc').replaceWith(allSearchResult);
                $('.nav-search').replaceWith(navSearch);

                // reset page
                pagePostSearch = 1;

                if ($('.list-p-all').data('paginate') == 1) {
                    $('.list-p-all').find('.list-post').last().removeClass('border-b');
                    $('.list-p-all').removeClass('pb-30');
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    // back search category
    if (pathname.includes('/category/')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: pathname,
            method: 'get',
            success: function (response) {
                let resVal = $(response).find('.search-i').val();
                $(document).find('.search-i').val(resVal);

                let allSearchResult = $(response).find('.search-mc');
                let navSearch = $(response).find('.nav-search');
                $('.search-mc').replaceWith(allSearchResult);
                $('.nav-search').replaceWith(navSearch);

                // reset page
                pagePostSearch = 1;

                if ($('.list-p-all').data('paginate') == 1) {
                    $('.list-p-all').find('.list-post').last().removeClass('border-b');
                    $('.list-p-all').removeClass('pb-30');
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    // back search
    if (document.location.pathname == '/search') {
        let req = document.location.search;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/search${req}`,
            method: 'get',
            success: function (response) {
                let resVal = $(response).find('.search-i').val();
                $(document).find('.search-i').val(resVal);

                let allSearchResult = $(response).find('.search-mc');
                let navSearch = $(response).find('.nav-search');
                $('.search-mc').replaceWith(allSearchResult);
                $('.nav-search').replaceWith(navSearch);

                // reset page
                pagePostSearch = 1;

                if ($('.list-p-all').data('paginate') == 1) {
                    $('.list-p-all').find('.list-post').last().removeClass('border-b');
                    $('.list-p-all').removeClass('pb-30');
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
});


// Auto Search Engine
let delaySearch;
$(document).on('input', '.search-i', function () {
    clearTimeout(delaySearch);
    delaySearch = setTimeout(function() {
        let inputVal = $(document).find('.search-i').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/search`,
            method: 'get',
            data: {'s': inputVal},
            success: function (response) {
                let allSearchResult = $(response).find('.search-mc');
                let navSearch = $(response).find('.nav-search');
                $('.search-mc').replaceWith(allSearchResult);
                $('.nav-search').replaceWith(navSearch);

                // reset page
                pagePostSearch = 1;

                if ($('.list-p-all').data('paginate') == 1) {
                    $('.list-p-all').find('.list-post').last().removeClass('border-b');
                    $('.list-p-all').removeClass('pb-30');
                }

                if (document.location.pathname != `/search?s=${inputVal}`) {
                    window.history.pushState('', 'Search and find - Adityaptrp', `/search?s=${inputVal}`);
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }, 1000);
})




// Load More List
$(window).scroll(function() {
    if(Math.ceil($(window).scrollTop() + $(window).height()) >= $(document).height()) {
        let lastPage = $('.list-p-all').data('paginate');
        pagePostSearch++;
        let url = '?postSearch=' + pagePostSearch;
        if (window.location.href.indexOf("search?s=") > -1) {
            url = window.location.href + '&postSearch=' + pagePostSearch;
        }
        if (pagePostSearch <= lastPage) {
            loadMoreData(url, pagePostSearch, lastPage);
        }
    }
});

function loadMoreData(url, pagePostSearch, lastPage){
    $.ajax({
        url: url,
        type: "get",
        datatype: "html",
        beforeSend: function()
        {
            $('.ajax-load').show();
        }
    }).done(function(data) {
        setTimeout(() => {
            $('.ajax-load').hide();
            $('.list-p-all').append($(data).find('.list-p-all').html());
            
            if (pagePostSearch == lastPage) {
                $('.list-post')[$('.list-post').length-1].classList.remove('border-b');
                $('.list-p-all').removeClass('pb-30').addClass('pb-10');
            }
        }, 1000);
    }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
    });
}


// Remove border List posts
if($('.list-p-all')) {
    if ($('.list-p-all').data('paginate') == 1) {
        $('.list-p-all').removeClass('pb-30');
    }
}