
// Auto like post highlight
$(document).on('click', '.like-hs', function () {
    localStorage.setItem('like-hs', true);
})

// auto open comment
$(document).on('click', '.comment-ph', function () {
    localStorage.setItem('comment-open', true);
})

// auto play video
$(document).on('click', '#homeImgHighlight', function () {
    localStorage.setItem('play_video', true);
})


// Load More LIst Post
let pagePostList = 1;
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
            $('.list-p-all').removeClass('pb-18').addClass('pb-30');
            $('.btn-loadmore').remove();
            $('.ajax-load').show();
        }
    }).done(function(data) {
        // console.log(data)
        setTimeout(() => {
            $('.list-p-all').removeClass('pb-30').addClass('pb-18');
            $('.ajax-load').hide();
            console.log(pagePostList)
            $('.list-p-all').append($(data).find('.list-p-all').html());
            console.log(lastPage)
            if(pagePostList == lastPage){
                $('.list-p-all').removeClass('pb-18').addClass('pb-0');
                $('.list-post')[$('.list-post').length-1].classList.remove('border-b');
                $('.btn-loadmore').remove();
                return false;
            }
        }, 1000);
    }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
    });
}


// submit form set password
$(document).on('click', '.btn-save-spu', function () {
    $('.form-setpassword form').submit();
})

$(document).on('input valuechange', 'input', function () {
    let lengthVal = $(this).val().length;
    let maxLength = $(this).data('l');
    $(this).parent().find('label span').text(lengthVal);
    if (lengthVal > maxLength) {
        $(this).addClass('max').removeClass('focus:border-green-600').addClass('focus:border-red-600');
    } else {
        $(this).removeClass('max').removeClass('focus:border-red-600').addClass('focus:border-green-600');
    }
})