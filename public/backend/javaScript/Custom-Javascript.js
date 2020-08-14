
$(document).ready(function () {

    /* -------------------- AOS Setting -------------------- */

    AOS.init();

    /* -------------------- Lazy Load Setting -------------------- */

    $(function () {
        $('img').lazy({
            effect: "fadeIn",
            effectTime: 1000,
            threshold: 10,
        });
    });

    /* -------------------- Image Pop Up Setting -------------------- */

    $('.image-pop-up').magnificPopup({ type: 'image' });

    /* -------------------- Toggle Setting -------------------- */

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $(".page").toggleClass("toggled");
        $(".sidebar").toggleClass("toggled");
    });

    /* -------------------- Tooltip Setting -------------------- */

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    /* -------------------- Input File Setting -------------------- */

    'use strict';

    ; (function ($, window, document, undefined) {
        $('.inputfile').each(function () {
            var $input = $(this),
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';

                if (this.files && this.files.length > 1)
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                else if (e.target.value)
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    $label.find('span').html(fileName);
                else
                    $label.html(labelVal);
            });

            // Firefox bug fix

            $input
            .on('focus', function () { $input.addClass('has-focus'); })
            .on('blur', function () { $input.removeClass('has-focus'); });
        });
    })(jQuery, window, document);
});

$(window).on('load', function () {

    /* -------------------- Navbar Scroll Setting -------------------- */

    $(window).scroll(function () {
        $(".navbar").toggleClass("scroll", $(this).scrollTop() > 50)
        $("#scroll-top").toggleClass("scroll", $(this).scrollTop() > 50)
    });

    /* -------------------- Select Box Setting -------------------- */

    $(".custom-select-box").each(function () {
        var classes = $(this).attr("class"),
            id = $(this).attr("id"),
            name = $(this).attr("name");
        var template = '<div class="' + classes + '">';
        template += '<span class="custom-select-box-trigger">' + $(this).attr("placeholder") + '</span>';
        template += '<div class="custom-options">';
        $(this).find("option").each(function () {
            template += '<div id="OptText" class="option-text" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</div>';
        });
        template += '</div></div>';

        $(this).wrap('<div class="custom-select-box-wrapper"></div>');
        $(this).hide();
        $(this).after(template);
    });

    $(".custom-option:first-of-type").hover(function () {
        $(this).parents(".option-text").addClass("option-hover");
    }, function () {
        $(this).parents(".custom-options").removeClass("option-hover");
    });

    $(".custom-select-box-trigger").on("click", function () {
        $('html').one('click', function () {
            $(".custom-select-box").removeClass("opened");
        });
        $(this).parents(".custom-select-box").toggleClass("opened");
        event.stopPropagation();
    });

    $(".option-text").on("click", function () {
        $(this).parents(".custom-select-box-wrapper").find("select").val($(this).data("value"));
        $(this).parents(".custom-options").find(".option-text").removeClass("selection");
        $(this).addClass("selection");
        $(this).parents(".custom-select-box").removeClass("opened");
        $(this).parents(".custom-select-box").find(".custom-select-box-trigger").text($(this).text());
    });
});