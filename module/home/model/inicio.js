function load_slider() {
    friendlyURL('?page=home&op=slider').then(function(data) {
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // console.log(response);
            for (row in response) {
                // console.log(response);
                $('<div></div>').attr({ 'class': 'item', 'style': 'background-image: url(' + SITE_PATH + 'view/img/uploads/' + response[row].img }).appendTo('.owl-carousel')
                    .html('<label id="' + response[row].cod_prod + '" class="title_prod">' + response[row].name + '</label>');
                // console.log(response.img);
            }

            $('.owl-carousel').owlCarousel({
                loop: true,
                autoplay: true,
                margin: 0,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                nav: true,
                autoplayHoverPause: true,
                items: 1,
                // navText: ["<span class='ion-md-arrow-back'></span>", "<span class='ion-chevron-right'></span>"],
                mouseDrag: true,
                touchDrag: false,
                responsive: {
                    0: {
                        items: 1,
                        mouseDrag: false,
                        touchDrag: true
                    },
                    600: {
                        items: 1,
                        mouseDrag: false,
                        touchDrag: true

                    },
                    1000: {
                        items: 1
                    }
                }
            });

            click_slider();
            // alert("hola");
            // console.log(response);
        }).fail(function(response) {
            // window.location.href = "?page=503";
            alert("fail2");
            console.log(response);
        });
    }).catch(function(data) {
        alert("fail");
        console.log(data);
    });
}

function load_categories() {
    friendlyURL('?page=home&op=categories').then(function(data) {
        $.ajax({
            type: "GET",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // console.log(response);
            $('#categories').attr({ 'class': 'row justify-content-around py-5' });
            for (row in response) {
                // console.log(response);
                $('<div></div>').attr({ 'id': response[row].name, 'class': 'categoria catego row align-items-center', 'style': 'background-image: url(' + SITE_PATH + 'view/img/uploads/' + response[row].img }).appendTo('#categories')
                    .html('<label class="title_catego mx-auto">' + response[row].name + '</label>');
                // console.log(response.img);
            }
            var cw = $('.categoria').width();
            cw = cw * 0.6
            $('.categoria').css({ 'height': cw + 'px' });

            click_categories();

            $(window).on('resize', function() {
                cw = $('.categoria').width();
                cw = cw * 0.6
                $('.categoria').css({ 'height': cw + 'px' });
            });

        }).fail(function(response) {
            console.log("ajaxerror");
            // window.location.href = "?page=503";
            // console.log(response);
        });
    }).catch(function(data) {
        alert("fail");
        console.log(data);
    });
}

function click_categories() {
    $('.catego').on("click", function() {
        var id_catego = this.id;
        // alert(id_catego);

        localStorage.setItem('shop_filter', 'catego');
        localStorage.setItem('shop_filter_id', id_catego);

        friendlyURL("?page=shop/").then(function(data) { window.location = data; });
    });
}

function click_slider() {
    $('.title_prod').on("click", function() {
        var id_prod = this.id;

        localStorage.setItem('shop_filter', 'prod');
        localStorage.setItem('shop_filter_id', id_prod);

        friendlyURL("?page=shop/").then(function(data) { window.location = data; });
    });
}

$(document).ready(function() {
    load_slider();
    load_categories();
});