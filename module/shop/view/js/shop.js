function show_content() {
    var type = localStorage.getItem('shop_filter');
    var filter_id = localStorage.getItem('shop_filter_id');
    $("#content-shop").empty();
    switch (type) {
        case "prod":
            // console.log("entra al prod");
            get_prod(filter_id);
            break;
        case "catego":
            get_catego(filter_id);
            break;
        case "search":
            // console.log("entra al search");
            make_search(filter_id);
            break;
        default:
            // console.log("entra al default");
            all_shop(0);
            break;
    }
}

function all_shop(offset) {
    var limit = 12;




    var filters = get_filters();
    var catego;
    var price_min;
    var price_max;
    var ingredientes;
    if (filters == false) {
        filters = "";
        catego = "";
        price_min = "";
        price_max = "";
        ingredientes = "";
    } else {
        filters = filters.split(";");
        for (i = 0; i < filters.length; i++) {
            switch (i) {
                case 0:
                    catego = filters[i];
                    break;
                case 1:
                    price_min = filters[i];
                    break;
                case 2:
                    price_max = filters[i];
                    break;
                case 3:
                    ingredientes = filters[i];
                    break;
            }
        }
    }
    friendlyURL("?page=shop&op=all_prod").then(function(data) {
        // alert(offset + " + " + limit + " + " + catego + " + " + price_min + " + " + price_max + " + " + ingredientes);
        // alert(data);
        $.ajax({
            type: "POST",
            url: data,
            data: { "offset": offset, "limit": limit, "catego": catego, "price_min": price_min, "price_max": price_max, "ingredientes": ingredientes },
            dataType: "JSON"
        }).done(function(response) {
            // alert("hola");
            // console.log(response);

            // set_catego(response);
            set_all_prods(response, limit, offset);

            show_prod();

            // slider();

        }).fail(function(response) {
            // console.log(response);
            // console.log(response.responseText);
            no_result();
            // window.location.href = "?page=503";
            // console.log(response);
        });
    });
}

function set_all_prods(response, limit, offset) {
    var i = 0;
    $("<div></div>").attr({ "id": "all_shop_content" }).appendTo("#content-shop");
    for (row in response) {
        if (row != 0) {
            $("<div></div>").attr({ "class": "prod_content" }).appendTo("#all_shop_content")
                .html('<div class="img-prod"><img src="' + SITE_PATH + 'view/img/uploads/' + response[row].img + '" alt="Generic placeholder image"></div>' +
                    '<h4>' + response[row].name + '</h4>' +
                    '<h5>' + response[row].precio + '€</h5>' +
                    '<p><a id="' + response[row].cod_prod + '" class="btn btn-default ver" role="button">Ver &raquo;</a></p>' +
                    '<div><a class="fav_btn" data-prod="' + response[row].cod_prod + '">&#60;3</a></div>');
            i++;
        }
    }
    set_favs();
    set_paginacio(response[0].total, limit, offset);
}

function set_favs() {
    var token = localStorage.getItem("token");
    if (token) {
        ajaxPromise(
            "module/shop/controller/controller_shop.php?op=get_favs",
            "POST",
            "JSON", {
                "token": token
            }
        ).then(function(response) {

            if (response === '"close_session"') {
                localStorage.removeItem("token");
                sessionStorage.setItem("comingfrom", "shop");
                window.location.href = "?page=login";
            } else {
                for (row in response) {
                    $("[data-prod='" + response[row].id_prod + "']").attr({ "class": "fav_btn active" });
                }
            }

        }).catch(function(response) {
            // console.log(response);
        });
    }
}

function set_paginacio(total, limit, offset) {
    $("<div></div>").attr({ "class": "paginacio" }).appendTo("#content-shop");
    var pag = Math.ceil(total / limit);
    var i = 1;
    var prods = 0;

    // alert(pag);
    // console.log(offset);
    $("<span>&#60;&#60;</span>").attr({ "class": "btn_nav", "id": "nav-arrere", "data-offset": offset }).appendTo(".paginacio");
    while (i <= pag) {
        if (offset >= prods && offset < prods + limit) {
            $("<span>" + i + "</span>").attr({ "class": "btn_paginacio btn_active", "data-offset": prods }).appendTo(".paginacio");
        } else {
            $("<span>" + i + "</span>").attr({ "class": "btn_paginacio", "data-offset": prods }).appendTo(".paginacio");
        }

        prods = prods + limit;
        i++;
    }
    $("<span>&#62;&#62;</span>").attr({ "class": "btn_nav", "id": "nav-avant", "data-offset": offset }).appendTo(".paginacio");

    $(".btn_paginacio").on("click", function() {
        var offset = this.getAttribute("data-offset");
        $('.loader_bg').fadeToggle();
        setTimeout(function() {
            $("#content-shop").empty();
            all_shop(offset);
            $('.loader_bg').fadeToggle();
        }, 500);
    });

    $(".btn_nav").on("click", function() {
        btn_nav(this.id, this.getAttribute("data-offset"), limit, pag);
    });

}

function btn_nav(action, offset, limit, pag) {

    if (action == "nav-arrere") {
        offset = parseInt(offset) - parseInt(limit);
    } else {
        offset = parseInt(offset) + parseInt(limit);
    }

    if (offset < 0) {
        offset = 0;
    } else if (offset > pag * limit - 1) {
        offset = pag * limit - limit;
    }

    $('.loader_bg').fadeToggle();
    setTimeout(function() {
        $("#content-shop").empty();
        all_shop(offset);
        $('.loader_bg').fadeToggle();
    }, 500);
}

function get_prod(id_prod) {
    friendlyURL("?page=shop&op=prod").then(function(data) {
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON",
            data: {
                id: id_prod
            }
        }).done(function(response) {
            // console.log(response);
            $("<div id='details'></div>").appendTo('#content-shop');
            var content = "";
            var ingredientes = "";
            var ingre = "";
            for (row in response[0]) {
                switch (row) {
                    case "cod_prod":
                        content += '<h1>' + row + ': <span id =' + row + '>' + response[0][row] + '</span></h1>';
                        break;
                    case "ingredientes":
                        ingredientes = response[0][row].split(":");
                        for (ing in ingredientes) {
                            if (ing == 0) {
                                ingre = ingredientes[ing];
                            } else {
                                ingre += ", " + ingredientes[ing];
                            }
                        }
                        content += '<div>' + row + ': <span id =' + row + '>' + ingre + '</span></div>';
                        break;
                    case "img":
                        content += '<div class="prod-img"><img src="' + SITE_PATH + 'view/img/uploads/' + response[0][row] + '"></div>';
                        break;
                    default:
                        content += '<div>' + row + ': <span id =' + row + '>' + response[0][row] + '</span></div>';
                        break;
                }
            }

            $("<div class='prod-info'></div>").appendTo('#details')
                .html(content);
            $("<div class='button_action go_shop' data-tr='Back'></div>").appendTo('.prod-info');
            change_lang();
            show_shop();
            set_visita(response[0].cod_prod);
            $("<p>Libros Relacionados:</p>").attr({ "class": "related-title" }).appendTo("#details");
            $("<div></div>").attr({ "id": "all_shop_content", "style": "width: 100% !important; display: flex-box !important;" }).appendTo("#details");
            show_related(0);

        }).fail(function(response) {
            console.log(response);
            no_result();
            // window.location.href = "?page=503";
            // console.log(response);
        });
    });
}

function set_visita(id_prod) {
    friendlyURL("?page=shop&op=visit_prod").then(function(data) {
        // alert(id_prod);
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON",
            data: { "id_prod": id_prod }
        }).done(function(response) {

            // console.log(response);

        }).fail(function(response) {

            console.log(response);

        });
    });
}

function get_catego(type) {
    friendlyURL("?page=shop&op=catego").then(function(data) {
        // alert(type);
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON",
            data: {
                id_prod: type
            }
        }).done(function(response) {
            // console.log(response);

            set_catego(response);

            slider();

            show_prod();

        }).fail(function(response) {
            no_result();
            // window.location.href = "?page=503";
            console.log(response);
        });
    });
}

function set_catego(response) {
    var i = 0;
    var catego = "";
    for (row in response) {
        if (response[row].type !== catego) {
            catego = response[row].type;
            $("<div id='slider-" + catego + "' class='slider-shop'></div>").appendTo('#content-shop')
                .html("<h2 class='slider-title'>" + catego + "</h2><div id='slider-" + catego + "-content' class='owl-carousel owl-theme'></div>");
        }
        if (response[row].type == catego) {
            $('<div></div>').attr({ 'class': 'item' }).appendTo("#slider-" + catego + "-content")
                .html('<img src="' + SITE_PATH + 'view/img/uploads/' + response[row].img + '" alt="Generic placeholder image">' +
                    '<h4>' + response[row].name + '</h4>' +
                    '<h5>' + response[row].precio + '€</h5>' +
                    '<p><a id="' + response[row].cod_prod + '" class="btn btn-default ver" role="button">Ver &raquo;</a></p>');
            i++;
        }
    }
}

function slider() {
    $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 10,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        autoplayHoverPause: true,
        items: 3,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })
}

function show_prod() {
    // console.log("carga show prod");
    $('.ver').on('click', function() {
        var id_prod = this.id;
        localStorage.setItem('shop_filter', 'prod');
        localStorage.setItem('shop_filter_id', id_prod);
        $('.loader_bg').fadeToggle();
        setTimeout(function() {
            show_content();
        }, 500);
        setTimeout(function() {
            $('.loader_bg').fadeToggle();
        }, 1000);

    });

    $('.fav_btn').on('click', function() {
        // this.attr({ "class": "active" });
        var btnclass = this.getAttribute("class").split(" ");

        var prod_id = this.getAttribute("data-prod");
        var token = localStorage.getItem("token");
        if (token) {
            if (btnclass[1] === "active") {
                // Favorito
                console.log("active");

                fav("unfav", prod_id, token);

                $(this).attr({ 'class': 'fav_btn' });
            } else {
                // No favorito
                console.log("no active");

                fav("fav", prod_id, token);

                $(this).attr({ "class": "fav_btn active" });
            }
        } else {
            sessionStorage.setItem("comingfrom", "shop");
            window.location.href = "?page=login";
        }
    });
}

function fav(type, prod, token) {
    ajaxPromise(
        "module/shop/controller/controller_shop.php?op=fav",
        "POST",
        "TEXT", {
            "token": token,
            "prod": prod,
            "type": type
        }
    ).then(function(response) {
        if (response === '"close_session"') {
            localStorage.removeItem("token");
            sessionStorage.setItem("comingfrom", "shop");
            window.location.href = "?page=login";
        } else {
            console.log(response);
        }
    }).catch(function(response) {
        console.log(response);
    });
}

function show_shop() {
    $('.go_shop').on('click', function() {
        localStorage.removeItem('shop_filter');
        localStorage.removeItem('shop_filter_id');
        $('.loader_bg').fadeToggle();
        setTimeout(function() {
            show_content();
            $('.loader_bg').fadeToggle();
        }, 500);
    });
}

function no_result(message) {
    var message = "No se encuentran resultados con estos parametros de busqueda.";
    $('<h1 class="no_result_error">' + message + '</h1>').appendTo('#content-shop');
}

function make_search(content) {
    // console.log("se dispone a hacer el ajax");
    $('<div class="shop_title">Buscando por "' + content + '"</div>').appendTo("#content-shop");
    friendlyURL("?page=shop&op=search").then(function(data) {
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON",
            data: { "content": content }
        }).done(function(response) {
            // console.log("realiza el ajax");
            // console.log(response);
            if (response.length == 1) {
                // console.log("solo 1 producto");
                localStorage.setItem('shop_filter', 'prod');
                localStorage.setItem('shop_filter_id', response[0].cod_prod);
                show_content();
            } else {
                // console.log("varios productos");
                set_catego(response);

                show_prod();

                slider();
            }

        }).fail(function(response) {
            console.log(response);
            no_result();

        });
    });
}

function show_related(limit) {

    limit = limit + 3;

    $.ajax({
        type: "GET",
        url: "https://www.googleapis.com/books/v1/volumes",
        data: { "q": "cooking" },
        dataType: "JSON"
    }).done(function(response) {
        // console.log(response);
        var item;
        var more = true;
        if (limit >= response.items.length) {
            limit = response.items.length;
            more = false;
        }
        for (row = 0; row < limit; row++) {
            item = response.items[row];
            // console.log(item);
            if (item !== null) {
                $("<div></div>").attr({ "id": item.id, "class": "prod_content" }).appendTo("#all_shop_content")
                    .html('<div class="img-prod"><img src="' + item.volumeInfo.imageLinks.thumbnail + '" alt="Generic placeholder image"></div>' +
                        '<h4>' + item.volumeInfo.title + '</h4>' +
                        '<p><a class="btn btn-default" href="' + item.volumeInfo.previewLink + '" role="button" target="_blank">Ver &raquo;</a></p>');
            }
        }

        if (more) {
            $("<div>Ver más...</div>").attr({ "id": "show_more" }).appendTo("#all_shop_content");

            event_show_more(limit);
        }


    }).fail(function(response) {
        console.log(response);
    });
}

function event_show_more(limit) {
    $("#show_more").on("click", function() {
        // console.log(limit);
        $('.loader_bg').fadeToggle();
        setTimeout(function() {
            $("#all_shop_content").empty();
            show_related(limit);
        }, 500);
        setTimeout(function() {
            $('.loader_bg').fadeToggle();
        }, 1000);
    });
}



$(document).ready(function() {
    show_content();
});