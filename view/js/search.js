function set_search(response) {
    $('#autocomplete').empty();
    // console.log(response.length);
    if (response.length != null && response != "no_text") {

        for (row in response) {
            $('<div class="itemdrop" id="' + response[row].cod_prod + '"><span>' + response[row].name + '</span><span>' + response[row].precio + '€</span></div>').appendTo("#autocomplete");
        }
    } else if (response.length == null) {
        $('<div>No items found</div>').attr({ "class": "itemdrop" }).appendTo("#autocomplete");
    }

    events_drop();

}



function events_search() {
    // console.log("entra a myFunctions");
    $(".dropbtn").on("click", function() {
        // console.log("click search");
        document.getElementById("myDropdown").classList.toggle("show");
    });

    $("#myInput").on("keyup", function() {
        // console.log(this.value);
        valueInp = this.value;
        if (valueInp !== "") {
            friendlyURL("?page=general&op=search").then(function(data) {
                // console.log(valueInp);
                $.ajax({
                    type: "POST",
                    url: data,
                    data: { "search": valueInp },
                    dataType: "JSON"
                }).done(function(response) {
                    // console.log(response);
                    set_search(response);
                }).fail(function(response) {
                    // console.log(response);
                    set_search({ "name": "No items found" });
                });
            });
        } else {
            set_search("no_text");
        }
        // set_search(this.value);
    });

    $("#myDropdown").on("submit", function() {
        event.preventDefault();
        var inp_val = $("#myInput").val();
        action_search(inp_val);
    });

    $(".searchdropbtn").on("click", function() {
        var inp_val = $("#myInput").val();
        action_search(inp_val);
    });

}

function action_search(search) {
    localStorage.setItem("shop_filter", "search");
    localStorage.setItem("shop_filter_id", search);
    friendlyURL("?page=shop/").then(function(data) { window.location.href = data; });
}

function events_drop() {
    $(".itemdrop").on("click", function() {
        localStorage.setItem("shop_filter", "prod");
        localStorage.setItem("shop_filter_id", this.id);
        friendlyURL("?page=shop/").then(function(data) { window.location.href = data; });
    });
}

function show_search(where) {
    // console.log("entra a show_search");
    $("<div class='inputdrop'><input autocomplete='off' type='text' placeholder='Search..'' id='myInput'/><span class='searchdropbtn'></span></div>").appendTo(where);
    $('<div></div>').attr({ "id": "autocomplete" }).appendTo("#myDropdown");
    events_search();
}