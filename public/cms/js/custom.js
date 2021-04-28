
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


// add attr checked when checkbox is checked
$(document).on('click', '.form-checkbox', function() {
    if ($(this)[0].hasAttribute('checked')) {
        $(this).attr('checked', false);
    } else {
        $(this).attr('checked', true);
    }
})
// custom upload file
$(document).on('change', '#thumbnail', function () {
    var i = $(this).prev('label').clone();
    var file = $('#thumbnail')[0].files[0];
    if(file) {
        $(this).prev('label').text(file.name).attr('title', file.name).addClass('ac');
        if($(this).data('old')) {
            if($(this).next().find('input:checkbox')[0].hasAttribute('checked')) {
                $(this).next().find('input:checkbox').click();
            }
            $(this).next().toggle();
        }
    } else {
        if($(this).data('old')) {
            $(this).prev('label').text($(this).data('old')).attr('title', $(this).data('old')).addClass('ac');
            $(this).next().toggle();
        } else {
            $(this).prev('label').text('No thumbnail is selected').attr('title', 'No thumbnail is selected').removeClass('ac');
        }
    }
});
$(document).on('change', '#sub_thumbnail1', function () {
    var i = $(this).prev('label').clone();
    var file = $('#sub_thumbnail1')[0].files[0];
    if(file) {
        $(this).prev('label').text(file.name).attr('title', file.name).addClass('ac');
        $('#sub_thumbnail1').attr('data-value', 1);
        $('.sub_thumbnail1_warning').remove();

        if($(this).data('old')) {
            if($(this).next().find('input:checkbox')[0].hasAttribute('checked')) {
                $(this).next().find('input:checkbox').click();
            }
            $(this).next().toggle();
        }

        if ($('#sub_thumbnail2').get(0).files.length === 0 && !$('#sub_thumbnail2').data('value')) {
            $('.sub_thumbnail2_warning').remove();
            $('#sub_thumbnail2').after( `<p class="sub_thumbnail2_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail two in order to be seen in the post view</p>` );
        }
    } else {
        if($(this).data('old')) {
            $(this).prev('label').text($(this).data('old')).attr('title', $(this).data('old')).addClass('ac');
            $(this).next().toggle();
        } else {
            $(this).prev('label').text('No sub thumbnail one is selected').attr('title', 'No sub thumbnail one is selected').removeClass('ac');
            $('#sub_thumbnail1').removeAttr('data-value');
            if ($('#sub_thumbnail2').data('value')) {
                $('#sub_thumbnail1').after( `<p class="sub_thumbnail1_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail one in order to be seen in the post view</p>` );
            } else {
                $('.sub_thumbnail2_warning').remove();
                $('.sub_thumbnail1_warning').remove();
            }
        }
    }
});
$(document).on('change', '#sub_thumbnail2', function () {
    var i = $(this).prev('label').clone();
    var file = $('#sub_thumbnail2')[0].files[0];

    if(file) {
        $(this).prev('label').text(file.name).attr('title', file.name).addClass('ac');
        $('#sub_thumbnail2').attr('data-value', 1);
        $('.sub_thumbnail2_warning').remove();

        if($(this).data('old')) {
            if($(this).next().find('input:checkbox')[0].hasAttribute('checked')) {
                $(this).next().find('input:checkbox').click();
            }
            $(this).next().toggle();
        }

        if ($('#sub_thumbnail1').get(0).files.length === 0 && !$('#sub_thumbnail1').data('value')) {
            $('.sub_thumbnail1_warning').remove();
            $('#sub_thumbnail1').after( `<p class="sub_thumbnail1_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail one in order to be seen in the post view</p>` );
        }
    } else {
        if($(this).data('old')) {
            $(this).prev('label').text($(this).data('old')).attr('title', $(this).data('old')).addClass('ac');
            $(this).next().toggle();
        } else {
            $(this).prev('label').text('No sub thumbnail two is selected').attr('title', 'No sub thumbnail two is selected').removeClass('ac');
            $('#sub_thumbnail2').removeAttr('data-value');
            if ($('#sub_thumbnail1').data('value')) {
                $('#sub_thumbnail2').after( `<p class="sub_thumbnail2_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail two in order to be seen in the post view</p>` );
            } else {
                $('.sub_thumbnail2_warning').remove();
                $('.sub_thumbnail1_warning').remove();
            }
        }
    }
});


// Custom Alert
async function modalConfirm(message, textBtn, btnColor) {
    return new Promise((complete, failed) => {
        $('.cms-modal-alert').fadeIn();
        $('.cms-modal-body-c').addClass('on');

        $('.cms-modal-body-c').find('h2').text(message);
        let btn = $('.cms-modal-body-c').find('#cms-modalYes');
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

        $('#cms-modalYes').on('click', ()=> {
            $('.cms-modal-alert').fadeOut(); complete(true);
            $('.cms-modal-body-c').removeClass('on');
        });
        $('#cms-modalNo').on('click', ()=> { 
            $('.cms-modal-alert').fadeOut(); complete(false);
            $('.cms-modal-body-c').removeClass('on');
        });
    });
}

// ALL SINGLE DELETE MODAL
$(document).on('click', '.cms-delete-post, .cms-rm-category, .cms-rm-tags, .cms-rm-comment', async function() {
    // modal
    let confirm;
    if ($(this).hasClass('cms-delete-post')) {
        confirm = await modalConfirm('Are you sure to delete this post ? You will not be able to recover this post!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('cms-rm-category')) {
        confirm = await modalConfirm('Are you sure to delete this category ? You will not be able to recover this category!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('cms-rm-tags')) {
        confirm = await modalConfirm('Are you sure to delete this tag ? You will not be able to recover this tag!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('cms-rm-comment')) {
        confirm = await modalConfirm('Are you sure to delete this comment ? You will not be able to recover this comment!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    
    if(!confirm){
        return false;
    }
    // delete
    $(this).find('form').submit();
})

// ALL DELETE SELECTED MODAL
$(document).on('click', '.btn-rm-selected-posts, .btn-rm-selected-categories, .btn-rm-selected-tags, .btn-rm-selected-comments', async function() {
    // modal
    let confirm;
    if ($(this).hasClass('btn-rm-selected-posts')) {
        confirm = await modalConfirm('Are you sure to delete all the selected posts ? You will not be able to recover all of these posts!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('btn-rm-selected-categories')) {
        confirm = await modalConfirm('Are you sure to delete all the selected categories ? You will not be able to recover all of these categories!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('btn-rm-selected-tags')) {
        confirm = await modalConfirm('Are you sure to delete all the selected tags ? You will not be able to recover all of these tags!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if ($(this).hasClass('btn-rm-selected-comments')) {
        confirm = await modalConfirm('Are you sure to delete all the selected comments ? You will not be able to recover all of these comments!', 'Yes, do it!', 'bg-red-500 hover:bg-red-600');
    }
    if(!confirm){
        return false;
    }
    // delete
    $('#formMultipleSelect').submit();
})

// CLose Modal
$(document).on('click', '.cms-modal-alert, .close-cms-modal, .cms-rm-tag', function(e) {
    console.log($(e.target))
    if ($(e.target).hasClass('cms-modal-alert') || $(e.target).hasClass('close-cms-modal') || $(e.target).hasClass('cms-rm-tag')) {
        $('.cms-modal-alert').fadeOut();
        $('.cms-modal-body-c').removeClass('on');
    }
})

// Give effect border red if input reach the max limit value
$(document).on('input valuechange', '.form-category-cms input[type="text"]', function () {
    let lengthVal = $(this).val().length;
    let maxLength = $(this).data('l');
    if (lengthVal > maxLength) {
        $(this).addClass('max').removeClass('focus:border-green-600').addClass('focus:border-red-600');
    } else {
        $(this).removeClass('max').removeClass('focus:border-red-600').addClass('focus:border-green-600');
    }
})


// Show menu multiple delete
$("#formMultipleSelect input[type=checkbox]").on("click", function () {
    if ($("#formMultipleSelect input:checkbox:checked").length > 0) {
        // show menu
        const scrollHeight = $('#selectedPanel').prop('scrollHeight');
        $('#selectedPanel').css('maxHeight', `${scrollHeight}px`);

        // Remove alert if isset
        if ($('#selectedPanel').parent().prev().hasClass('alert')) {
            $('#selectedPanel').parent().prev().slideUp(function () {
                $(this).remove();
            });
        }

        // Select all and unselect all
        console.log($(this).hasClass('checked-all'));
        if ($(this).hasClass('checked-all')) {
            if ($(this).prop('checked')) {
                $("#formMultipleSelect input:checkbox").prop('checked', true);
            } else {
                $('#selectedPanel').css('maxHeight', '');
                $("#formMultipleSelect input:checkbox").prop('checked', false);
            }
        }

        // Change text
        $('#selectedPanel > div > div > div').text(`
            ${$('#formMultipleSelect input[class="checkboxArray"]:checked').length} ${$('#formMultipleSelect input[class="checkboxArray"]:checked').length > 1 ? 'items' : 'item'} selected
        `);

        // Check select all klo semua udh di check
        if ($('#formMultipleSelect input[class="checkboxArray"]:checked').length == $('#formMultipleSelect input[class="checkboxArray"]').length) {
            $('.checked-all').prop('checked', true);
        } else {
            $('.checked-all').prop('checked', false);
        }
    } else {
        $('#selectedPanel').css('maxHeight', '');
    }
});
// Close multiple delete
$(document).on('click', '.close-multiple-select', function () {
    $('#selectedPanel > div > div > div').text(`
        0 item selected
    `);
    $('#selectedPanel').css('maxHeight', '');
    $("#formMultipleSelect input:checkbox").prop('checked', false);
})



// GO View CU comment unapproved
$(document).on('click', '.goViewCU', function() {
    let commentId = $(this).data('comment-id');
    localStorage.setItem('viewCU', commentId);
})

// auto open comment
$(document).on('click', '.open-comment', function () {
    localStorage.setItem('comment-open', true);
})


// ACCORDIOIN
$(document).on('click', '.accordions-btn', function(e) {
    if (!$(this).hasClass('active') && $(this).next().hasClass('accordions-content')) {
        $(this).addClass('active');
        $(this).find('.icon-open').addClass('active');
        $(this).find('.ac-menu-icon').addClass('active');
        $(this).next().addClass('border border-t-0');

        // slide down
        const scrollHeight = $(this).next().prop('scrollHeight');
        $(this).next().css('maxHeight', `${scrollHeight+1}px`); // +1 untuk biar keliatan bordernya

        // slide up yang lain
        let thisBtn = $(this);
        slideDownAccordion(thisBtn);

    } else if ($(this).data('cb') == undefined) {
        $(this).removeClass('active');
        $(this).find('.icon-open').removeClass('active');
        $(this).find('.ac-menu-icon').removeClass('active');
        $(this).next().removeClass('border border-t-0');
        $(this).next().removeClass('active');
        $(this).next().css('maxHeight', '');
    }
})
function slideDownAccordion(thisBtn) {
    console.log(thisBtn)
    $('.accordions-btn').each(function (el) {
        if ($(this).attr('id') != thisBtn.attr('id')) {
            if ($(this).next().hasClass('accordions-content')) {
                $(this).removeClass('active');
                $(this).find('.icon-open').removeClass('active');
                $(this).find('.ac-menu-icon').removeClass('active');
                $(this).next().removeClass('border border-t-0');
                $(this).next().removeClass('active');
                $(this).next().css('maxHeight', '');
            }
        }
    })
}

// If click change email disable it
$(document).on('submit', '.accordions-content form', function () {
    $('.accordions-content form button').each(function () {
        if ($(this).hasClass('bg-green-500')) {
            $(this).removeClass('bg-green-500').addClass('bg-green-600').attr('disabled', true);
        } else {
            $(this).removeClass('bg-red-500').addClass('bg-red-600').attr('disabled', true);
        }
    })
})



