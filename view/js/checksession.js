function interval_session() {
    if (localStorage.getItem("token")) {
        setInterval();
    }
}

function check_session(token) {
    friendlyURL("?page=general&op=checksession").then(function(data) {
        ajaxPromise(
            data,
            "POST",
            "TEXT", {
                "token": token
            }
        ).then(function(response) {
            // console.log("session true --> " + response);

            $(".button_user").empty();
            if (response === "true") {
                $(".button_user").html('<a class="button active" id="log-out">Log Out</a>' +
                    /*'<a class="button" id="cart-btn">Carrito</a>' +*/
                    '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Carrito</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div></div>');
                set_log_out();
                get_cart(token);
            } else {
                localStorage.removeItem("token");
                $(".button_user").html('<a class="button active" id="log-btn">Login</a><a class="button" id="reg-btn">Register</a>');
                set_log_reg_btn();
            }
        }).catch(function(response) {
            console.log("session false --> " + response);
        });
    });
}

function get_cart(token) {
    ajaxPromise(
        "module/general/controller/controller_general.php?op=get_cart",
        "POST",
        "JSON", {
            "token": token
        }
    ).then(function(response) {

    }).catch(function(response) {

    });
}

function set_log_out() {
    $('#log-out').on("click", function() {
        localStorage.removeItem("token");
        location.reload();
    });
}


function session_control() {
    var token = localStorage.getItem("token");
    if (token) {
        check_session(token);
    } else {
        $(".button_user").empty();
        $(".button_user").html('<a class="button active" id="log-btn">Login</a><a class="button" id="reg-btn">Register</a>');
        set_log_reg_btn();
    }
}