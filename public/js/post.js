
// Auto like post Highlight
if (localStorage.getItem('like-hs')) {
    let thisEl = $('.like-m');
    thisEl[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
    setTimeout(() => {
        if (thisEl.find('.post-like-main')) {
            thisEl.find('.post-like-main').click();
        }
        if (thisEl.find('.m-hover-lp')) {
            thisEl.find('.m-hover-lp').addClass('on');
        }
        setTimeout(() => {
            thisEl.find('.m-hover-lp').removeClass('on');
        }, 2000);
        localStorage.removeItem('like-hs');
    }, 700);
}

// Auto Play Youtube Video
if (localStorage.getItem('play_video')){
    runYT();
    setTimeout(() => {
        localStorage.removeItem('play_video');
    }, 0);
}

// Auto open Comment
if (localStorage.getItem('comment-open')){
    $('.comment-post').addClass('on');
    $('.fade-effect-comment').addClass('on');
}

// Play Youtube Video
$('.show-post-img').on('click', function() {
    runYT();
})

function runYT() {
    $('.open-yt').addClass('show');
    $('.show-post-title-img i, .show-post-title-img p, .show-post-icon-play i, .show-post-img img').addClass('on');
    $('.open-yt-content iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
}

// close yt
$('.close-content-yt, .fade-effect-yt').on('click', function() {
    $('.open-yt').removeClass('show');
    $('.show-post-title-img i, .show-post-title-img p, .show-post-icon-play i, .show-post-img img').removeClass('on');
    $('.open-yt-content iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
})


// LEFT SIDE SHOW POST CONTENT SCROLLED
$(window).scroll(function() {    
    let scroll = $(window).scrollTop();
    if (scroll >= 130) {
        //clearHeader, not clearheader - caps H
        $(".show-post-left-content").addClass("scrolled");
    } else {
        $(".show-post-left-content").removeClass("scrolled");
    }
    if (scroll + 450 >= $('.show-post-body').offset().top + $('.show-post-body').height()) {
        //clearHeader, not clearheader - caps H
        $(".show-post-left-content").removeClass("scrolled");
    }
})

// POST Like System
$(document).on('click', '.post-like-side, .post-like-main', function() {
    let dataId = $(this).data('postid');
    let thisBtnParent = $(this).parent();
    $(this).removeClass('post-like-side').removeClass('post-like-main');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/post-like/${dataId}`,
        method: 'post',
        success: function (response) {
            $('.like-s').children(':nth-child(1)').replaceWith(response.likeSide);
            $('.like-m').children(':nth-child(1)').replaceWith(response.likeMain);
        
            // Efek pop up like
            console.log(thisBtnParent);
            if (thisBtnParent.hasClass('like-s')){
                console.log('side')
                thisBtnParent.children('.effect-liked-post').next().find('svg').addClass('effect-clicked');
                thisBtnParent.children('.effect-liked-post').addClass('effect-popup-liked');
                setTimeout(() => {
                    thisBtnParent.children('.effect-liked-post').remove();
                    thisBtnParent.children('.effect-liked-post').next().find('svg').removeClass('effect-clicked');
                }, 1700);
            } else if (thisBtnParent.hasClass('like-m')) {
                console.log('main')
                thisBtnParent.children('.effect-liked-post').next().find('svg').addClass('effect-clicked');
                thisBtnParent.children('.effect-liked-post').addClass('effect-popup-liked');
                setTimeout(() => {
                    thisBtnParent.children('.effect-liked-post').remove();
                    thisBtnParent.children('.effect-liked-post').next().find('svg').removeClass('effect-clicked');
                }, 1700);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
});


// Hide and Show Menu Comment
$(document).on('click', '.btn-open-comment', function() {
    localStorage.setItem('comment-open', true);
    $('.comment-post').addClass('on');
    $('.fade-effect-comment').addClass('on');
})
$(document).on('click', '.fade-effect-comment, svg.btn-close-comment', function() {
    $('.comment-post').removeClass('on');
    $('.fade-effect-comment').removeClass('on');
    localStorage.removeItem('comment-open');
    if (localStorage.getItem('viewCU')){
        localStorage.removeItem('viewCU');
    }

    // hapus new select text
    if ($('.new-select-txt')){
        setTimeout(() => {
            $('.new-select-txt').remove();
        }, 1000);
    }

    if($('.selectable-text-area').find('mark')) {
        let parent = $('.selectable-text-area').find("mark").parent();
        $("mark").contents().unwrap();
        parent.html(function(i, html) {
            return html;
        });
    }
})

// change all text area height
$("textarea").each(function(){
    var lineHeight = parseFloat($(this).css("line-height"));
    var lines = $(this).attr("rows")*1 || $(this).prop("rows")*1;
    $(this).css("height", lines*lineHeight);
});

// Comment Layout
var tx = $('.input-comment');
for (var i = 0; i < tx.length; i++) {
    tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
    tx[i].addEventListener("input", OnInput, false);
}
$(document).on('focus', '.input-comment-reply', function() {
    let aw = $(this);
    for (var i = 0; i < aw.length; i++) {
        aw[i].setAttribute('style', 'height:' + (aw[i].scrollHeight) + 'px;overflow-y:hidden;');
        aw[i].addEventListener("input", OnInput, false);
    }
})
function OnInput() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
}

// Hide and show comment
$(document).on('focus', '.input-comment', function() {
    let thisForm = $(this).parent();
    thisForm.find('.form-header-comment').slideDown(500);
    thisForm.find('.btn-comment').slideDown(500);

    // tutup semua replies comment
    $('.form-reply-comment').each(function() {
        $(this).slideUp();
    })
    // changes all comment reply text content
    $(document).find('.reset-reply-txt p, .show-form-reply p').each(function() {
        $(this).html('Reply');
    })

    // hide all error comment reply
    $('.eror-form-reply-comment').each(function() {
        if($(this).hasClass('on')) {
            $(this).removeClass('on');
        }
    })
})
$(document).on('click', '.btn-cancel-comment', function() {
    let thisForm = $(this).parent().parent().parent();
    hideComment(thisForm);
    thisForm.find('.btn-add-link').append('<span>Add your website</span>');
    thisForm.find('.input-user-link').slideUp(500, function() {
        $(this).val('');
    });
    if (thisForm.find('.new-select-txt')){
        // thisForm.find('.new-select-txt').slideUp('slow', function() {
            thisForm.find('.new-select-txt').remove();
        // });
    }
    thisForm.find('.btn-add-link').find('i').replaceWith(`<i class="fas fa-plus"></i>`);
})
function hideComment(thisForm) {
    thisForm.find('.form-header-comment').slideUp(500);
    thisForm.find('.reset-val-main-form input').val('');
    thisForm.find('.input-comment').val('');
    thisForm.find('.btn-comment').slideUp(500);
    thisForm.find('.input-comment').each(function(){
        var lineHeight = parseFloat($(this).css("line-height"));
        var lines = $(this).attr("rows")*1 || $(this).prop("rows")*1;
        $(this).css("height", lines*lineHeight);
    });
    if($('.eror-form-comment').hasClass('on')) {
        $('.eror-form-comment').removeClass('on')
    }
}

// Show and hide input link user
$(document).on('click', '.btn-add-link', function() {
    let thisInputLink = $(this).parent().parent().parent().find('.input-user-link');
    thisInputLink.toggle().focus();
    $(this).find('span').remove();
    if ($(this).find('i').hasClass('fas fa-plus')) {
        $(this).find('i').replaceWith(`<i class="fas fa-minus"></i>`);
    } else {
        $(this).find('i').replaceWith(`<i class="fas fa-plus"></i>`);
        thisInputLink.val('');
    }
})



// Store Comment
$(document).on('submit', '.form-comment', function(e) {

    let formData = $(this).serialize();
    let btnSubmit = $(this).find('button');
    let thisForm = $(this);
    btnSubmit.attr('disabled', 'true');
    btnSubmit.addClass('cursor-not-allowed');
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/store`,
        method: 'post',
        data: formData,
        success: function (response) {
            console.log(response)
            $('.btn-cancel-comment').click();
            // remove comment and hr before
            if ($(document).find('.list-comment-new').next().is('hr')) {
                $(document).find('.list-comment-new').next().remove();
            }
            $(document).find('.list-comment-new').remove();
            
            // remove message empty comment
            $('.empty-comment').removeClass('flex').addClass('hidden');

            // prepend new comment
            $('.all-comment').prepend(response.html);
            $(document).find('.new-c-hr').each(function() {
                if (!$(this).next().is('hr')) {
                    $(this).after('<hr>');
                }
            })
            // replace new sizeof comment
            $('.responses-comment').html(`
                Responses (${response.sizeOfComment})
            `);
            $('.content-responses').html(`${response.sizeOfComment}`);
            // remove error class if isset
            if($('.eror-form-comment').hasClass('on')) {
                $('.eror-form-comment').removeClass('on')
            }

            btnSubmit.removeAttr('disabled');
            btnSubmit.removeClass('cursor-not-allowed');
        },
        error: function(error) {
            if (!thisForm.next().hasClass('eror-form-comment')) {
                thisForm.after(`
                    <div class="eror-form-comment -mt-5 mb-5">
                        <div class="message-error-comment">
                            <p class="text-xs ">Please input your name!</p>
                            <div class="triangle-up"></div>
                        </div>
                    </div>
                `);
            }
            let errorElement = thisForm.parent().find('.eror-form-comment').first();
            let errorText = errorElement.children().children('p');
            errorMessageComment(error, errorText);

            // add effect
            $('.eror-form-comment').addClass('on shake');
            setTimeout(() => {
                $('.eror-form-comment').removeClass('shake');
            }, 500);

            btnSubmit.removeAttr('disabled');
            btnSubmit.removeClass('cursor-not-allowed');
        }
    })
})
// Function alert error message comment
function errorMessageComment(error, errorText) {
    let errorComment = error.responseJSON.errors;
    console.log(errorComment);
    if(error.status == 422 || error.status == 429) {
        if (errorComment.name) {
            errorText.html(errorComment.name[0]);
        } else if (errorComment.email) {
            errorText.html(errorComment.email[0]);
        } else if (errorComment.body) {
            errorText.html(errorComment.body[0]);
        } else if (errorComment.user_link) {
            errorText.html(errorComment.user_link[0]);
        } else if (errorComment.attempts) {
            errorText.html(`Too many attempts. Please try again in ${errorComment.attempts[0]} seconds.`);
            function startTimer(time, display) {
                let timer = time;
                var x = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);
                    minutes = minutes;
                    seconds = seconds-1;
                    display.html(`Too many attempts. Please try again in ${seconds} seconds.`);
                    if (--timer < 0) {
                        $('.eror-form-comment').removeClass('on shake');
                        clearInterval(x);
                    }
                }, 1000);
            }
    
            let time = errorComment.attempts[0];
            let display = errorText;
            startTimer(time, display);
        }
    } else {
        errorText.html(`Oops, something went wrong, please <a href="${window.location.href}" class="underline">reload</a> the page`);
    }
}

// Show and hide Replies Comment
$(document).on('click', '.show-replies-comment', function() {
    let thisParentComment = $(this).parent();
    let thisShowReplies = $(this);
    if (thisShowReplies.parent().find('.all-cmnt-replies').first().hasClass('hidden')) {
        thisShowReplies.find('span').html('Hide Replies');
        thisParentComment.find('.all-cmnt-replies').first().removeClass('hidden');
    } else {
        thisShowReplies.find('span').html('Show Replies');
        thisParentComment.find('.all-cmnt-replies').first().addClass('hidden');
    }
    
})

// Show and Hide Reply Form
$(document).on('click', '.show-form-reply', function() {
    let dataIdFormReply = $(this).parent().parent().data('comment-id');

    $('.form-reply-comment').each(function() {
        if ($(this).parent().data('comment-id') == dataIdFormReply) {
            $('.btn-cancel-comment').click();
            $(this).slideToggle();
            let btnReply = $(this).parent().find('.text-reply-comment');
            if (btnReply.html() == 'Reply') {
                btnReply.html('Cancel');
                setTimeout(() => {
                    $(this).find('textarea').focus();
                }, 500);
            } else {
                btnReply.html('Reply');
                $(this).find('.btn-add-link').append('<span>Add your website</span>');
            }
        } else {
            $(this).slideUp();
            $('.eror-form-reply-comment').removeClass('on');
            let btnReply = $(this).parent().find('.text-reply-comment');
            if (btnReply.html() == 'Cancel') {
                btnReply.html('Reply');
            }
        }
    });
})

// Store Reply
$(document).on('submit', '.form-reply-comment', function(e) {

    let formDataReply = $(this).serialize();
    let thisFormReply = $(this);
    let thisParentFormReply = $(this).parent();
    let btnSubmit = $(this).find('button');
    btnSubmit.attr('disabled', 'true');
    btnSubmit.addClass('cursor-not-allowed');
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/reply`,
        method: 'post',
        data: formDataReply,
        success: function (response) {

            // hide top/main comment
            $('.btn-cancel-comment').click();
            // remove comment sebelumnya
            if ($(document).find('.list-comment-new').next().is('hr')) {
                $(document).find('.list-comment-new').next().remove();
            }
            // remove show reply comment sebelumnya
            if ($(document).find('.list-comment-new').prev().length == 0) {
                if ($(document).find('.list-comment-new').parent().prev().hasClass('show-replies-comment')) {
                    $(document).find('.list-comment-new').parent().prev().remove();
                }
            }
            $(document).find('.list-comment-new').remove();

            // append new comment and open all comment replies
            if (thisParentFormReply.find('.all-cmnt-replies').length == 0) {
                thisParentFormReply.append(`
                    <div class="show-replies-comment inline-block font-semibold text-0.5sm text-blue-500 mt-5 cursor-pointer">
                        <span>Hide Replies</span>
                        <div class="el-tambahan"></div>
                    </div>
                    <div class="all-cmnt-replies"></div>
                `);
                // append
                thisParentFormReply.find('.all-cmnt-replies').first().append(response.html);
            } else {
                if (!thisParentFormReply.find('.all-cmnt-replies').children().length) {
                    thisParentFormReply.find('.all-cmnt-replies').first().before(`
                        <div class="show-replies-comment inline-block font-semibold text-0.5sm text-blue-500 mt-5 cursor-pointer">
                            <span>Hide Replies</span>
                            <div class="el-tambahan"></div>
                        </div>
                    `);
                } else {
                    thisParentFormReply.find('.show-replies-comment span').html('Hide Replies')
                }
                // append
                thisParentFormReply.find('.all-cmnt-replies').first().removeClass('hidden').append(response.html);
            }
            
            // KODE UNTUK GUEST
            const newCommentGuest = thisParentFormReply.find('.list-comment-new').last();
            if (newCommentGuest.length) {
                // add elment create to new comment
                if (thisParentFormReply.find('.list-comment-new').last().prev().length == 0) {
                    thisParentFormReply.find('.list-comment-new').last().addClass('el-create');
                }
            } else {
                // KODE UNTUK USER
                const newCommentUser = thisParentFormReply.find('.replies-comment-parent').last();
                if (newCommentUser.prev().length == 0) {
                    if (thisParentFormReply.hasClass('replies-comment-parent') || thisParentFormReply.hasClass('new-c-hr')) {
                        newCommentUser.addClass('el-create1');
                    } else {
                        newCommentUser.addClass('el-create2');
                    }
                    // add margin jika ada show reply
                    if (newCommentUser.parent().prev().hasClass('show-replies-comment')) {
                        newCommentUser.addClass('mt-5');
                    }
                }
    
                // if parentnya adalah ajax untuk user login
                if (thisParentFormReply.hasClass('replies-comment-parent') || thisParentFormReply.hasClass('new-c-hr')) {
                    // benerin bg elemen baru show replies
                    thisParentFormReply.find('.show-replies-comment .el-tambahan').first().addClass('ajax');
                    // benerin padding
                    if (newCommentUser.prev().length) {
                        newCommentUser.prev().addClass('pb-5');
                        newCommentUser.prev().append(`
                            <div class="absolute bottom-0 left-0 w-100% px-6">
                                <hr>
                            </div>
                        `);
                        newCommentUser.removeClass('py-5').addClass('pt-5');
                    } else {
                        newCommentUser.removeClass('py-5');
                    }
                } else {
                    if (newCommentUser.prev().length) {
                        if (newCommentUser.prev().hasClass('replies-comment-parent')) {
                            newCommentUser.prev().append(`
                                <div class="absolute bottom-0 left-0 w-100% px-6">
                                    <hr>
                                </div>
                            `);
                        } else {
                            newCommentUser.prev().addClass('pb-5');
                        }
                    }
                }
            }

            // show new comment for user
            let thisNewComment;
            if (thisParentFormReply.find('.list-comment-new').length) {
                thisNewComment = thisParentFormReply.find('.list-comment-new').last();
            } else {
                thisNewComment = thisParentFormReply.find('.replies-comment-parent').last();
            }
            thisNewComment[0].scrollIntoView({behavior: "smooth", block: "end", inline: "end"});

            // Do something after new comment appear
            thisFormReply.slideUp();
            thisFormReply.find('.form-header-reply').find("input:text").val('');
            thisFormReply.find("textarea").val('');
            thisParentFormReply.find('.text-reply-comment').html('Reply');

            // replace size of comment
            $('.responses-comment').html(`
                Responses (${response.sizeOfComment})
            `);
            $('.content-responses').html(`${response.sizeOfComment}`);

            // message error
            let errorMessage = thisParentFormReply.find('.eror-form-reply-comment');
            if (errorMessage.hasClass('on')) {
                errorMessage.removeClass('on');
            }

            btnSubmit.removeAttr('disabled');
            btnSubmit.removeClass('cursor-not-allowed');
        },
        error: function(error) {
            console.log();
            if (!thisFormReply.next().hasClass('eror-form-comment')) {
                thisFormReply.after(`
                    <div class="eror-form-comment">
                        <div class="message-error-comment">
                            <p class="text-xs">Please input your name!</p>
                            <div class="triangle-up"></div>
                        </div>
                    </div>
                `);
            }
            let errorElement = thisParentFormReply.find('.eror-form-comment').first();
            let errorText = errorElement.children().children('p');

            // change message
            errorMessageComment(error, errorText);
            // add effect error this form
            errorElement.addClass('on shake');
            setTimeout(() => {
                errorElement.removeClass('shake');
            }, 500);

            btnSubmit.removeAttr('disabled');
            btnSubmit.removeClass('cursor-not-allowed');
        }
    })
})


// Likes Comment
$(document).on('click', '.clap-comment', function() {

    // untuk membuat array like
    let dataIdComment = $(this).parent().parent().data('comment-id');
    let dataCookie = $('#dataCookie').data('cookie');

    let thisComment = $(this);
    let thisParent = $(this).parent();
    $(this).removeClass('clap-comment');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comment-like/update`,
        method: 'post',
        data: {
            'commentId': dataIdComment,
            'cookie': dataCookie,
        },
        success: function (response) {

            // ubah data cookie untuk array yg sudah terlike
            $('#dataCookie').data('cookie', response.cookie);
            // ubah icon menjadi liked
            thisComment.replaceWith(response.clapped);

            setTimeout(() => {
                $('.icon-clicked').removeClass('effect-clicked');
            }, 1000);

            // efek liked comment pop up
            thisParent.children('.effect-liked-comment').addClass('on');
            setTimeout(() => {
                thisParent.children('.effect-liked-comment').remove();
            }, 1700);
        },
        error: function(error) {
            console.log(error);
        }
    })
})


// Readmore Comment and copy
$(document).on('click', '.btn-readmore-comment', function() {
    let changeCommentText = $(this).parent()[0].children[0];
    let readMoreId = $(this).parent().parent().data('comment-id');
    let thisBtn = $(this);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comment/read-more/${readMoreId}`,
        method: 'post',
        success: function (response) {
            changeCommentText.innerHTML = response;
            thisBtn.remove();
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// Delete Comment
$(document).on('click', '.btn-delete', async function() {
    let commentId = $(this).data('comment-id');
    let thisComment = $(this).parent().parent().parent().parent();
    
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
        data: {'commentId': commentId},
        success: function (response) {

            // refresh list CU
            $(document).find('.c-list-unapproved').replaceWith(response.viewListCU);

            // append empty comment if empty on List CU
            if ($(document).find('.all-list-cu').children().length == 0) {
                setTimeout(() => {
                    $(document).find('.empty-cu').removeClass('hidden').addClass('flex');
                    $(document).find('.nav-notif-bullet').remove();
                }, 600);
            }
            // replace size of comment
            $('.nav-notif-bullet').html(response.sizeOfAllCU);
            $('.t-cu-size').html(`
                Comment Unapproved (${response.sizeOfAllCU})
            `);

            // delete storeage item
            if (localStorage.getItem('viewCU') == thisComment.data('comment-id')){
                localStorage.removeItem('viewCU');
            }

            // remove show replies comment if no comment
            const thisShowReplies = thisComment.parent().parent().find('.show-replies-comment').first();
            let delBtnReplies;
            if (thisComment.parent().hasClass('all-cmnt-replies')) {
                if (thisComment.parent().children().length == 1 || thisComment.parent().children().length == 0) {
                    delBtnReplies = true;
                }
            }

            // Remove border bottom kalo perlu
            const prevComment = thisComment.prev();
            const nextComment = thisComment.next();
            let delBorder;
            let setMarginTop;
            if (thisComment.prev().length) {
                if (thisComment.next().length) {
                    delBorder = false;
                } else {
                    delBorder = true;
                }
            } else {
                if (thisComment.next().length) {
                    setMarginTop = true;
                } else {
                    setMarginTop = false;
                }
            }
            
            // append empty comment
            const allComment = $(document).find('.all-comment');
            const emptyComment = $(document).find('.empty-comment');

            // delete this comment and do al the needs
            thisComment.fadeOut('slow', function() {
                if (thisComment.next().is('hr')) {
                    thisComment.next().remove();
                }
                thisComment.remove();
                if (delBtnReplies) {
                    thisShowReplies.remove();
                }
                if (delBorder) {
                    // gatau kenapa penelusuran dibawah mau
                    if (thisComment.prev().hasClass('list-comment-new')) {
                        prevComment.addClass('noborder-b');
                    } else {
                        prevComment.find('hr').first().parent().remove();
                    }
                }
                if (setMarginTop) {
                    nextComment.addClass('mt-5');
                }
                if (allComment.children().length == 0) {
                    emptyComment.removeClass('hidden').addClass('flex');
                }
            });
            
            // replace size of comment
            $('.responses-comment').html(`
                Responses (${response.sizeOfCA})
            `);
            $('.content-responses').html(`${response.sizeOfCA}`);

            // Send alert flash message
            $('#app').append(`
            <div class="flash-message">
                <span>Successfully deleted the comment.</span>
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
        },
        error: function(error) {
            console.log(error);
        }
    })
})

// set empty comment
$(document).ready(function() {
    if ($(document).find('.empty-comment').prev().children().length == 0) {
        $(document).find('.empty-comment').addClass('flex').removeClass('hidden');
    }
    if (localStorage.getItem('viewCU')) {
        $(document).find('.empty-comment').addClass('hidden').removeClass('flex');
    }
})


// Show Comment Unapproved atau Go view CU
if (localStorage.getItem('viewCU')){
    let commentId = localStorage.getItem('viewCU');
    let dataCookie = $('#dataCookie').data('cookie');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/comments/viewCUnapproved/${commentId}`,
        method: 'post',
        data: {'dataCookie': dataCookie},
        success: function (response) {
            // view comment unapproved
            $('.all-comment').html(response.viewComment);

            const thisCU = $(document).find('.view-CUnapproved');
            // Loop show Parent
            if (!thisCU.parent().hasClass('all-comment')) {
                thisCU.parent().removeClass('hidden');
                loopParent(thisCU.parent());
            }
            function loopParent(thisEl) {
                if (!thisEl.parent().hasClass('all-comment')) {
                    thisEl.parent().removeClass('hidden');
                    loopParent(thisEl.parent());
                }
            }

            if (thisCU.prev().length) {
                if (!thisCU.prev().hasClass('noborder-b')) {
                    thisCU.removeClass('mt-5');
                }
            }

            if (thisCU.last().prev().length == 0) {
                if (thisCU.last().next().length == 0) {
                    thisCU.parent().before(`
                        <div class="show-replies-comment inline-block font-semibold text-0.5sm text-blue-500 mt-5 cursor-pointer">
                            <span>Hide Replies</span>
                            <div class="el-tambahan"></div>
                        </div>
                    `);
                }
            }

            // add elment create to new comment
            if (thisCU.last().prev().length == 0) {
                thisCU.last().addClass('el-create');
            }

            setTimeout(() => {
                let thisCU = $('.view-CUnapproved')[0];
                thisCU.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
            }, 500);
        },
        error: function(error) {
            console.log(error);
        }
    })

    $('.comment-post').addClass('on');
    $('.fade-effect-comment').addClass('on');
}


// approve comment in list
$(document).on('click', '.btn-approve', async function() {
    let commentId = $(this).data('comment-id');
    let thisComment = $(this).parent().parent().parent().parent();
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
        data: {'commentId': commentId},
        success: function (response) {
            // add margin jika ada show reply
            let responAjax;
            if (thisComment.prev().length == 0) {
                if (thisComment.parent().prev().hasClass('show-replies-comment')) {
                    responAjax = $(response.viewAjax).addClass('mt-5');
                }
            } else {
                responAjax = response.viewAjax;
            }

            // Replace comment
            thisComment.fadeOut("slow", function() {
                if (thisComment.next().is('hr')) {
                    thisComment.next().remove();
                }
                thisComment.replaceWith(responAjax);
            });

            // delete storage item
            if (localStorage.getItem('viewCU') == thisComment.data('comment-id')){
                localStorage.removeItem('viewCU');
            }

            // refresh list CU
            $(document).find('.c-list-unapproved').replaceWith(response.viewListCU);

            // append empty comment in list CU
            if ($(document).find('.all-list-cu').children().length == 0) {
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


// approve comment without link in list 
$(document).on('click', '.btn-approve-cwl', async function() {
    let commentId = $(this).data('comment-id');
    let thisComment = $(this).parent().parent().parent().parent();
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
        data: {'commentId': commentId, 'withoutLink': true},
        success: function (response) {
            // add margin jika ada show reply
            let responAjax;
            if (thisComment.prev().length == 0) {
                if (thisComment.parent().prev().hasClass('show-replies-comment')) {
                    responAjax = $(response.viewAjax).addClass('mt-5');
                }
            } else {
                if (thisComment.prev().hasClass('noborder-b')) {
                    esponAjax = $(response.viewAjax).addClass('mt-5');
                } else {
                    responAjax = response.viewAjax;
                }
            }

            // Replace comment
            thisComment.fadeOut("slow", function() {
                if (thisComment.next().is('hr')) {
                    thisComment.next().remove();
                }
                thisComment.replaceWith(responAjax);
            });

            // delete storage item
            if (localStorage.getItem('viewCU') == thisComment.data('comment-id')){
                localStorage.removeItem('viewCU');
            }

            // refresh list CU
            $(document).find('.c-list-unapproved').replaceWith(response.viewListCU);

            // append empty comment in list CU
            if ($(document).find('.all-list-cu').children().length == 0) {
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


// Share Selected text event
$(document).on('mouseup', '.selectable-text-area', function(e) {
    const shareBtn = $('#btn-share-txt');
    setTimeout(() => {
        const selectedText = window.getSelection().toString().trim();
        if (selectedText.length) {
            const range = window.getSelection().getRangeAt(0);
            const start = range.startContainer.length;
            const end = range.endContainer.length;

            let parent = range.startContainer.parentElement;
            let parentEl = range.endContainer.parentElement;

            let key;
            if($(parent).hasClass('selectable-text-area')){
                key = parent;
            } else {
                getKey(parent);
            }
            function getKey(parent) {
                if(parent.parentElement) {
                    let newParent = parent.parentElement;
                    if ($(newParent).hasClass('selectable-text-area')) {
                        key = parent;
                        return false;
                    } else {
                        getKey(newParent);
                    }
                }
            }
                    
            if (parentEl != parent) {
                checkParent(parentEl, key);
            } else {
                showBtnShare();
            }

            function checkParent(parentEl, key) {
                console.log(parentEl)
                if(parentEl.parentElement) {
                    let newParentEl = parentEl.parentElement;
                    if(!$(newParentEl).hasClass('selectable-text-area')) {
                        if($(newParentEl).hasClass('content') || $(newParentEl).hasClass('post')) {
                            return false;
                        } else {
                            checkParent(newParentEl, key);
                        }
                    } else if($(newParentEl).hasClass('selectable-text-area')) {
                        if (parentEl != key) {
                            return false;
                        } else {
                            console.log(parentEl)
                            console.log(key)
                            showBtnShare();
                        }
                    }
                }
            }

            function showBtnShare() {
                let selection = window.getSelection();
                let getRange = selection.getRangeAt(0);
                let selectionRect = getRange.getBoundingClientRect();

                btnHalfWidth = $("#btn-share-txt").width()/2;

                shareBtn.css('left', `${selectionRect.left - btnHalfWidth + (selectionRect.width * 0.5)}px`);
                shareBtn.css('top', document.documentElement.scrollTop + selectionRect.top - 52 + 'px');
                shareBtn.css('display', 'block');
                shareBtn.addClass('btnEntrance');
            }
        }
    }, 0);
})
$(document).on('mousedown', function (e) {
    const shareBtn = $('#btn-share-txt');
    $(document).on('click', function() {
        if(shareBtn.css('display') == 'block') {
            if (e.target.id != 'btn-s-twitter' || e.target.id != 'btn-s-facebook' || e.target.id != 'btn-s-comment') {
                // console.log(selectedText.length);
                setTimeout(() => {
                    const selectedText = window.getSelection().toString().trim();
                    if(!selectedText.length) {
                        shareBtn.css('display', 'none');
                        shareBtn.removeClass('btnEntrance');
                        window.getSelection().empty();
                    } else {
                        const range = window.getSelection().getRangeAt(0);
                        let parent = range.startContainer.parentElement;
                        let parentEl = range.endContainer.parentElement;
                        
                        if (parent != parentEl) {
                            shareBtn.removeClass('btnEntrance');
                            shareBtn.css('display', 'none');
                        }
                    }
                }, 0);
            }
        }
    })
})
// text on share with twitter
$(document).on('click', '#btn-s-twitter', function () {
    const twitterShareUrl = 'https://twitter.com/intent/tweet';
    const text = encodeURIComponent(window.getSelection().toString().trim());
    const fullURL = encodeURI(window.location.href);
    let explodeURL = fullURL.split("-");
    let codePostURL = explodeURL[explodeURL.length - 1];
    let url = `${window.location.origin}/${codePostURL}`;
    let via = $(this).data('user');
    const tags = $(this).data('tags');

    window.open(`${twitterShareUrl}?text="${text}" ${via}&url=${url}&hashtags=${tags}`);
})
// text on share with facebook
$(document).on('click', '#btn-s-facebook', function () {
    const facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php';
    const text = encodeURIComponent(window.getSelection().toString().trim());
    const url = encodeURI(window.location.href);
    let href = `${facebookShareUrl}?u=${url}&quote=${text}`;

    let w = 500, h = 420;
    let left = (screen.width/2)-(w/2);
    let top = (screen.height/2)-(h/2)-40; //khusus facebook benernya defaul middle -10
    window.open(href, '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left).focus();
})
// text on share to reply comment
$(document).on('click', '#btn-s-comment', function () {
    const text = window.getSelection().toString().trim();
    // error hanling when nothing selected
    if (!text) {
        $('.btn-open-comment').click();
        $('.new-select-txt').remove();
        $('#btn-share-txt').css('display', 'none');
        return false;
    }

    let range = window.getSelection().getRangeAt(0);
    let mark = document.createElement('mark');
    mark.className = 'selected-text-highlight';
    mark.appendChild(range.extractContents());
    range.insertNode(mark);
    
    // ketika di select tapi input sebelumnya udh ada
    if ($('.new-select-txt')){
        $('.new-select-txt').remove();
    }
    // bukan panel cmt dan focus input area
    $('.btn-open-comment').click();
    $('.input-comment').focus().before(
        `<div class="block new-select-txt show-current-selected-text mb-3 p-3 rounded-sm border">
            <span class="text-base">${text}</span>
            <input type="hidden" name="selected_text" value="${text}">
        </div>`
    );
})


// Find selected text Marked
$(document).on('click', '.show-current-selected-text', function() {
    const thisEl = $(this);

    // disable
    thisEl.addClass('border-effect-selected-button');
    thisEl.removeClass('show-current-selected-text');

    if($('.selectable-text-area').find('mark').length) {
        const el = $('.selectable-text-area').find('mark');
        el[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
        setTimeout(() => {
            el.addClass('blinkingText');
        }, 300);
        setTimeout(() => {
            el.removeClass("blinkingText");
            thisEl.addClass('show-current-selected-text').removeClass('border-effect-selected-button');
        }, 3000);
    }
});
// Find selected text Not Marked
$(document).on('click', '.show-text-selected', function() {
    const text = $(this).find('span').text();
    console.log(text)
    let splitText = text.split(' ');
    const thisEl = $(this);
    const elResult = $('.selectable-text-area').find(`*:contains("${text}")`);
    
    // disable for awhile
    thisEl.addClass('border-effect-selected-button');
    thisEl.removeClass('show-text-selected');

    console.log(elResult)
    if (elResult.length > 1) {
        console.log('first inloop')
        loopChild(elResult, text);
    } else if (elResult.length == 1) {
        console.log('length = 1 (validate1)')
        elResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
        setEffect(elResult[0], thisEl);
        return false;
    } else {
        console.log('else first')
        let newText = `${splitText[0]} ${splitText[1]} ${splitText[2]}`;
        let newResult = $('.selectable-text-area').find(`*:contains("${newText}")`);

        if (newResult.length > 1) {
            loopChild(newResult, newText);
        } else if (newResult.length == 1) {
            console.log('length = 1 (validate2)')
            newResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
            setEffect(newResult[0], thisEl);
            return false;
        } else {
            let newText2 = `${splitText[splitText.length-3]} ${splitText[splitText.length-2]} ${splitText[splitText.length-1]}`;
            let newResult2 = $('.selectable-text-area').find(`*:contains("${newText2}")`);

            if (newResult2.length > 1) {
                loopChild(newResult2, newText2);
            } else if (newResult2.length == 1) {
                console.log('length = 1 (validate3)')
                newResult2[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                setEffect(newResult2[0], thisEl);
                return false;
            } else {
                setTimeout(() => {
                    thisEl.addClass('show-selected-text-comment').removeClass('border-effect');
                }, 2400);
                console.log('not found!');
            }
        }
    }

    function loopChild(elResult, text) {
        let splitTextLoop = text.split(' ');
        console.log('join loop')
        elResult.each(function (i) {
            let nextElResult = $(this).find(`*:contains("${text}")`);
            let tf = true;

            if (nextElResult.length > 1) {
                console.log('length > 1')
                loopChild(nextElResult, text);
            } else if (nextElResult.length == 1) {
                console.log('length = 1 (validate looped 1)')
                nextElResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                setEffect(nextElResult[0], thisEl);
                return tf =  false;
            } else {
                // console.log('loop else');
                // elResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                // setEffect(elResult[0], thisEl);

                let newTextLoop = `${splitTextLoop[0]} ${splitTextLoop[1]} ${splitTextLoop[2]}`;
                console.log(newTextLoop)
                let newResult = $(this).find(`*:contains("${newTextLoop}")`);
                console.log(newResult.length)

                if (newResult.length > 1) {
                    console.log('length > 1 (validate looped 2)')
                    loopChild(newResult, newTextLoop);
                } else if (newResult.length == 1) {
                    console.log('length = 1 (looped)')
                    newResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                    setEffect(newResult[0], thisEl);
                    return tf =  false;
                } else {
                    console.log('loop else')
                    elResult[0].scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                    setEffect(elResult[0], thisEl);
                }
            }
            return tf;
        });
    }

    // effext blinking dan border
    function setEffect(el, mainEl) {
        setTimeout(() => {
            $(el).addClass('blinkingText2');
        }, 300);
        setTimeout(() => {
            $(el).removeClass("blinkingText2");
            mainEl.addClass('show-text-selected').removeClass('border-effect-selected-button');
        }, 2000);
    }
});


// Pagination Go link
$(document).on('click', '.paginate-c-page', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    console.log(url);
    paginateLink(url);
})

function paginateLink(url){
    console.log('MANTAp')
    $.ajax({
        url: url,
        type: "get",
        datatype: "html",
    }).done(function(data) {
        console.log($(data).find('.list-p-all'));
        $('.list-p-all').replaceWith($(data).find('.list-p-all'));
        $('.paginate-links-panel').replaceWith($(data).find('.paginate-links-panel'));

        // Go scroll back
        if ($( window ).width() <= 576) {
            let listPost = $('.like-m')[0];
            listPost.scrollIntoView({behavior: "smooth", block: "start", inline: "center"});
        } else {
            let listPost = $('.list-p-all')[0];
            listPost.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
        }
    }).fail(function(jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}


// Shortcut Edit Profile
$(document).on('click', '.shortcut-ep', function () {
    localStorage.setItem('active_edit_profile', true);
})