
// Effect Focus Login and Register
if ($('#name').length != 0 && $('#name').parent().find('input').val() == '') {
    $('#name').parent().addClass("focus-input-login").find('input').focus();
} else if ($('#username').length != 0 && $('#username').parent().find('input').val() == ''){
    $('#username').parent().addClass("focus-input-login").find('input').focus();
} else if ($('#email').length != 0 && $('#email').parent().find('input').val() == ''){
    $('#email').parent().addClass("focus-input-login").find('input').focus();
}

let id = ['name', 'username', 'email', 'password', 'password_confirmation'];
$.each(id, function (i,v) {
    $(`#${v}`).on('focus', function () {
        if($(this).parent().hasClass('error-input')){
            $(this).parent().addClass("error-input");
        } else {
            $(this).parent().addClass("focus-input-login");
        }
    }).blur(function(){
        if(!$(`#${v}`).val()){
            $(this).parent().removeClass("focus-input-login");
        }
    })
    if($(`#${v}`).val() && $(`#${v}`).parent().hasClass('error-input')){
        $(`#${v}`).parent().addClass("error-input").find('input').focus();
    } else if ($(`#${v}`).val() && !$(`#${v}`).parent().hasClass('error-input')){
        $(`#${v}`).parent().addClass("focus-input-login");
    } else if (!$(`#${v}`).val() && $(`#${v}`).parent().hasClass('error-input')) {
        if ($('.error-input')[0] == $(`#${v}`).parent()[0]) {
            $(`#${v}`).parent().addClass("error-input").find('input').focus().parent().removeClass("focus-input-login");
        }
    }
});



// Change img
$(document).on('change', '#auth_wallpaper', function () {
    const file = $(this)[0].files[0];

    let img = $(`#wallpaper-auth`);
    const reader = new FileReader();

    if (file) {
        if(file.type.includes('video')) {
            $('#app').append(`
            <div class="flash-message-auth">
                <span>Cannot use files other than images.</span>
                <div class="close-flash-message ml-2.5 -mr-1 cursor-pointer">
                    <svg class="nav-burger w-4 h-4 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                    </svg>
                </div>
            </div>
            `);
            setTimeout(() => {
                $('.flash-message-auth').remove();
            }, 2000);
            return false;
        }
        reader.readAsDataURL(file);
    }
    reader.addEventListener("load", function () {
        img.css('background', ``);
        img.css('background-image', `url(${reader.result})`)

        if ($('.save-img-auth').length == 0) {
            $('.all-btn-auth').append(`
                <p class="save-img-auth px-4 rounded-full ml-2">Save</p>
                <div class="cancel-img-auth ml-2">
                    <svg class="w-6 h-6 cursor-pointer" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            `)
        }
        getImageLightness(reader.result, function(brightness){
            console.log(brightness);
            changeBtnDependsColor(brightness);
        });

    }, false);
});

// Save Image Changes
$(document).on('click', '.save-img-auth', function () {
    $('.form-auth-img').submit();
})

// Cancel Image Changes
$(document).on('click', '.cancel-img-auth', function () {
    $('#wallpaper-auth').css('background-image', BASE_URL_IMG_FOR_CSS);
    $('.save-img-auth').remove();
    $('.cancel-img-auth').remove();
    $('.form-auth-img input').val('');
    getImageLightness(BASE_URL_IMG_ASSET, function(brightness){
        changeBtnDependsColor(brightness);
    });
})

// Function change background and hover btn depends on img color
function changeBtnDependsColor(brightness) {
    if (brightness <= 130) {
        $('.all-btn-auth div, .all-btn-auth label, .all-btn-auth > p').removeClass('auto_brightness_black').addClass('auto_brightness_white');
        $('.login-img-item').removeClass('desc-auth-black').addClass('desc-auth-white');
    } else {
        $('.all-btn-auth div, .all-btn-auth label, .all-btn-auth > p').removeClass('auto_brightness_white').addClass('auto_brightness_black');
        $('.login-img-item').removeClass('desc-auth-white').addClass('desc-auth-black');
    }
}

// Change Btn edit from starting page
console.log(BASE_URL_IMG_ASSET)
getImageLightness(BASE_URL_IMG_ASSET, function(brightness){
    changeBtnDependsColor(brightness);
});

// Check color brightness
function getImageLightness(imageSrc,callback) {
    var img = document.createElement("img");
    img.src = imageSrc;
    img.style.display = "none";
    document.body.appendChild(img);

    var colorSum = 0;

    img.onload = function() {
        // create canvas
        var canvas = document.createElement("canvas");
        canvas.width = this.width;
        canvas.height = this.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(this,0,0);

        var imageData = ctx.getImageData(0,0,canvas.width,canvas.height);
        var data = imageData.data;
        var r,g,b,avg;

        for(var x = 0, len = data.length; x < len; x+=4) {
            r = data[x];
            g = data[x+1];
            b = data[x+2];

            avg = Math.floor((r+g+b)/3);
            colorSum += avg;
        }

        var brightness = Math.floor(colorSum / (this.width*this.height));
        callback(brightness);
    }
}



// FORM
// On max length input
$(document).on('input valuechange', '.form-auth-setting input[type="text"]', function () {
    let lengthVal = $(this).val().length;
    let maxLength = $(this).data('l');
    $(this).parent().find('label span').text(lengthVal);
    if (lengthVal > maxLength) {
        $(this).addClass('max').removeClass('focus:border-green-600').addClass('focus:border-red-600');
    } else {
        $(this).removeClass('max').removeClass('focus:border-red-600').addClass('focus:border-green-600');
    }
})
// Submit auth setting
$(document).on('click', '.submit-auth-setting', function () {
    $('.form-auth-setting').submit();
})

// Show edit profile panel
$(document).on('click', '.edit-txt-auth', function () {
    $('.fade-ef-auth').fadeIn();
    $('.panel-e-auth').addClass('active');
})

// Close edit profile panel
$(document).on('mousedown', function (e) {
    if ($(e.target).hasClass('fade-ef-auth') || $(e.target).hasClass('close-auth-setting')) {
        $('.fade-ef-auth').fadeOut();
        $('.panel-e-auth').removeClass('active');

        console.log(username)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/register`,
            method: 'get',
            success: function (response) {
                console.log('sukses')
                setTimeout(() => {
                    $('.panel-e-auth').replaceWith($(response).find('.panel-e-auth'));
                }, 500);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
})


// CLOSE ALERT SUCCESS N ERROR
$(document).on('click', '#closeAlertAuth', function () {
    $(this).parent().remove();
})


// Close flash message
$(document).on('click', '.close-flash-message', function () {
    $(this).parent().remove();
})