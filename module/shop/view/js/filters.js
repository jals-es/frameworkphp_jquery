function show_filters() {
    show_filter_categories();
    show_price_range();
    show_filter_ingredientes();
}

function show_filter_categories() {
    $("<h3>Categorías:</h3>").attr({ "id": "title_filter_categories" }).appendTo("#options-bar");
    $("<select></select>").attr({ "id": "filter_categories" }).appendTo("#options-bar");
    $("<option>Todas</option>").attr({ "value": "all" }).appendTo("#filter_categories");

    friendlyURL("?page=shop&op=get_catego").then(function(data) {
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // console.log(response);
            for (row in response) {
                $("<option><span>" + response[row].name + "</span></option>").attr({ "value": response[row].name }).appendTo("#filter_categories");
            }
        });
    });

    event_filter_categories();
}

function show_price_range() {

    $("<h3>Precio:</h3>").attr({ "style": "margin-top: 25px;" }).appendTo("#options-bar");

    print_range_inp("#options-bar");
    friendlyURL("?page=shop&op=get_range_prices").then(function(data) {
        $.ajax({
            type: "GET",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // alert("hola");
            // console.log(response);
            set_price_range(response[0]);

        }).fail(function(response) {
            var price = { "min": "0", "max": "9999999" }
            set_price_range(price);
        });
    });

}

function show_filter_ingredientes() {
    $("<h3>Ingredientes:</h3>").attr({ "id": "title_filter_ingredientes" }).appendTo("#options-bar");
    $("<div></div").attr({ "id": "filter_ingredientes" }).appendTo("#options-bar");

    friendlyURL("?page=shop&op=get_ingredientes").then(function(data) {
        $.ajax({
            type: "GET",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // console.log(response);
            for (row in response) {
                $('<input type="checkbox" checked/>').attr({ "value": response[row], "name": "filter_ing[]" }).appendTo("#filter_ingredientes");
                $('<label>' + response[row] + '</label><br>').attr({ "class": "ml-1" }).appendTo("#filter_ingredientes");
            }

            event_filter_ingredientes();

        }).fail(function(response) {
            console.log(response);

        });
    });
}

function set_price_range(price) {
    $('.noUi-handle').on('click', function() {
        $(this).width(50);
    });
    var rangeSlider = document.getElementById('slider-range');
    var moneyFormat = wNumb({
        decimals: 0,
        thousand: ''
    });
    noUiSlider.create(rangeSlider, {
        start: [price.min, price.max],
        step: 1,
        range: {
            'min': [price.min],
            'max': [price.max]
        },
        format: moneyFormat,
        connect: true
    });

    // Set visual min and max values and also update value hidden form inputs
    rangeSlider.noUiSlider.on('update', function(values, handle) {
        document.getElementById('slider-range-value1').innerHTML = values[0];
        document.getElementById('slider-range-value2').innerHTML = values[1];
        document.getElementsByName('min-value').value = moneyFormat.from(
            values[0]);
        document.getElementsByName('max-value').value = moneyFormat.from(
            values[1]);
    });

    // event_filter_price();
}

function event_filter_categories() {
    $("#filter_categories").on("change", function() {
        change_filters();
    });
}

function event_filter_ingredientes() {
    $("input[name='filter_ing[]']").on("change", function() {
        change_filters();
    });
}

function change_filters() {

    var categories = $("#filter_categories").val();
    var price_min = $("#slider-range-value1").text();
    var price_max = $("#slider-range-value2").text();

    var get_ing = $("input[name='filter_ing[]']:checked");
    if (get_ing.length > 0) {
        for (i = 0; i < get_ing.length; i++) {
            if (i == 0) {
                var ing = get_ing[i].value;
            } else {
                ing = ing + ":" + get_ing[i].value;
            }
        }

        var filters = categories + ";" + price_min + ";" + price_max + ";" + ing;



        if (localStorage.getItem("filters_shop") !== null) {
            localStorage.setItem("filters_shop", filters);
            $('.loader_bg').fadeToggle();
            setTimeout(function() {
                $("#content-shop").empty();
                all_shop(0);
                $('.loader_bg').fadeToggle();
            }, 500);
        } else {
            localStorage.setItem("filters_shop", filters);
        }
    } else if (localStorage.getItem("filters_shop") !== null) {
        $('.loader_bg').fadeToggle();
        setTimeout(function() {
            $("#content-shop").empty();
            no_result();
            $('.loader_bg').fadeToggle();
        }, 500);
    }
}

function get_filters() {

    var filters = localStorage.getItem("filters_shop");
    if (filters === null) {
        change_filters();
        return false;
    } else {
        return filters;
    }
}

$(document).ready(function() {
    show_filters();
});

localStorage.removeItem("filters_shop");