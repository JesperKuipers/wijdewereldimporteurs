// Enables the button to send mail at about_wwi.php
function recaptchacallback(){
    console.log("The user has solved the captcha.");
    $('#submit_button').removeClass('disabled');
}

// All JS for overview.php and searchbar.php
$(document).ready(function () {
    $('select').formSelect();
    init();
});

function init() {
    $('.pagination').remove();
    var show_per_page = $('#productsPerPage').val();
    var number_of_items = $('.products').children('.product').length;
    var number_of_pages = Math.ceil(number_of_items / show_per_page);

    $('.content').append('<ul class="pagination"></ul><input id=current_page type=hidden><input id=show_per_page type=hidden>');
    $('#current_page').val(0);
    $('#show_per_page').val(show_per_page);

    var navigation_html = '<li class="waves-effect" onclick="previous()"><a href="#!"><i class="material-icons">chevron_left</i></a></li></li>';
    var current_link = 0;
    while (number_of_pages > current_link) {
        navigation_html += '<li class="page" onclick="go_to_page(' + current_link + ')" longdesc="' + current_link + '"><a href="#!">' + (current_link + 1) + '</a></li>';
        current_link++;
    }
    navigation_html += '<li class="waves-effect" onclick="next()"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';

    $('.pagination').html(navigation_html);
    $('.pagination .page:first').addClass('active blue darken-1');

    $('.products').css('display', 'none');
    $('.products').slice(0, show_per_page / 4).css('display', 'block');
}

function go_to_page(page_num) {
    var show_per_page = parseInt($('#show_per_page').val(), 0);

    start_from = page_num * (show_per_page / 4);

    end_on = start_from + (show_per_page / 4);

    $('.products').css('display', 'none').slice(start_from, end_on).css('display', 'block');

    $('.page[longdesc=' + page_num + ']').addClass('active blue darken-1').siblings('.active').removeClass('active blue darken-1');

    $('#current_page').val(page_num);
}


function previous() {

    new_page = parseInt($('#current_page').val(), 0) - 1;
    //if there is an item before the current active link run the function
    if ($('.active').prev('.page').length == true) {
        go_to_page(new_page);
    }

}

function next() {
    new_page = parseInt($('#current_page').val(), 0) + 1;
    //if there is an item after the current active link run the function
    if ($('.active').next('.page').length == true) {
        go_to_page(new_page);
    }

}

function setFilter() {
    var url = window.location.toString();
    if (url.indexOf("&tags[]") > 0) {
        console.log('klopt');
        url = url.substring(0, url.indexOf("&tags[]"));
    }
    var tags = $("#selectFilter").val();
    url = url.replace('#!', '');
    $(tags).each(function (val, key) {
        url += "&tags[]=" + key;
    });
    document.location = url;
}
