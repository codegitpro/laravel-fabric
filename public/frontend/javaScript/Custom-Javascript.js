$(document).ready(function () {

    /* -------------------- Lazy Load Setting -------------------- */

    $(function () {
        $('img').lazy({
            effect: "fadeIn",
            effectTime: 1000,
            threshold: 10,
        });
    });
});

$(window).on('load', function () {

    /* -------------------- Navbar Scroll Setting -------------------- */

    $(window).scroll(function () {
        $(".navbar").toggleClass("scroll", $(this).scrollTop() > 50)
    });

    /* -------------------- Select Box Setting -------------------- */

    $(".custom-select-box").each(function () {
        var classes = $(this).attr("class"),
            id = $(this).attr("id"),
            name = $(this).attr("name");

        let template = '<div class="custom-options">';
        let textTemplateBegging = $(this).attr("placeholder");
        $(this).find("option").each(function () {
            template += '<div id="OptText" class="option-text" data-value="' + $(this).attr("value") + '" >' + $(this).html() + '</div>';
            if ($(this).attr("selected") !== undefined) {
                textTemplateBegging = $(this).html();
            }
        });
        template += '</div></div>';
        let finalTemplate = '<div class="' + classes + '">' +
            '<span class="custom-select-box-trigger">' + textTemplateBegging + '</span>' + template;

        $(this).wrap('<div class="custom-select-box-wrapper"></div>');
        $(this).hide();
        $(this).after(finalTemplate);
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
        var selectedFamily = $(this).attr('data-value');
        /*var activeObject = canvas.getActiveObject();
          if (activeObject && activeObject.type === 'text') {
              activeObject.set('fontFamily',selectedFamily)
            canvas.renderAll();
          }*/

        var myfont = new FontFaceObserver(selectedFamily)
        myfont.load(null, 10000)
            .then(function () {
                // when font is loaded, use it.
                canvas.getActiveObject().set("fontFamily", selectedFamily);
                if (fontSlugPathMap[selectedFamily]) {
                    fabric.fontPaths[selectedFamily] = fontSlugPathMap[selectedFamily];
                }
                canvas.requestRenderAll();
            }).catch(function (e) {
            console.log(e)
            alert('font loading failed ' + selectedFamily);
        });
    });


});


