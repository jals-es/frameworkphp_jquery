function get_content() {
    $(".login-page").empty();
    var type = sessionStorage.getItem("login_page");
    switch (type) {
        case "2":
            show_register();
            break;
        case "1":
        default:
            show_login();
            get_click_social();
            break;
    }
}

function show_login() {

    if (sessionStorage.getItem('val_return')) {
        var val_return = JSON.parse(sessionStorage.getItem('val_return'));
        sessionStorage.removeItem('val_return');
        // console.log(val_return);
        if (val_return.type === "true") {
            alerta("success", "CORRECTO", val_return.msg);
        } else {
            alerta(val_return.type, "ALGO NO VA BIEN", val_return.msg);
        }
    }

    show_content();
}

function show_register() {
    show_content();
    $('.form form').animate({ height: "toggle", opacity: "toggle" }, "slow");
}

function show_content() {
    $('<div class="form"></div>').appendTo(".login-page")
        .html('<form class="register-form">' +
            '<input id="reg-user" type="text" placeholder="username"/><div class="error_form" id="error-reg-user"></div>' +
            '<input id="reg-pass" type="password" placeholder="password"/><div class="error_form" id="error-reg-pass"></div>' +
            '<input id="reg-rpass" type="password" placeholder="repeat password"/><div class="error_form" id="error-reg-rpass"></div>' +
            '<input id="reg-email" type="text" placeholder="email address"/><div class="error_form" id="error-reg-email"></div>' +
            '<button>create</button>' +
            '<p class="message">Already registered? <a href="">Sign In</a></p>' +
            '</form>' +
            '<form class="login-form">' +
            '<input id="log-user" type="text" placeholder="username"/>' +
            '<input id="log-pass" type="password" placeholder="password"/><div class="error_form" id="error-log"></div>' +
            '<button>login</button>' +
            '<div id="log-gmail" class="button">Entra con Gmail</div>' +
            '<div id="log-github" class="button">Entra con GitHub</div>' +
            '<p class="message">Not registered? <a href="">Create an account</a></p>' +
            '</form>');

    $('.message a').on("click", function() {
        var type = sessionStorage.getItem("login_page");
        switch (type) {
            case "2":
                sessionStorage.setItem("login_page", "1");
                $('.form form').animate({ height: "toggle", opacity: "toggle" }, "slow");
                break;
            case "1":
            default:
                sessionStorage.setItem("login_page", "2");
                $('.form form').animate({ height: "toggle", opacity: "toggle" }, "slow");
                break;
        }
    });

    $(".login-form").on("submit", function() {
        event.preventDefault();
        login();
    });

    $(".register-form").on("submit", function() {
        event.preventDefault();
        register();
    });
}

function register() {
    var user = $("#reg-user").val();
    var pass = $("#reg-pass").val();
    var rpass = $("#reg-rpass").val();
    var email = $("#reg-email").val();

    // console.log(user + " " + pass + " " + rpass + " " + email);

    var c_user = val_username(user);
    var c_pass = val_password(pass);
    var c_rpass = check_same_password(pass, rpass);
    var c_email = val_email(email);

    var check = true;
    if (!c_user) {
        $("#error-reg-user").html(" * Nombre de usuario no valido");
        check = false;
    } else {
        $("#error-reg-user").empty();
    }
    if (!c_pass) {
        $("#error-reg-pass").html(" * Contraseña invalida<br>-De 8 a 15 carácteres<br>-Mayúsculas y minusculas<br>-Números<br>-Algun carácter especial<br>-Sin espacios");
        check = false;
    } else {
        $("#error-reg-pass").empty();
    }
    if (!c_rpass) {
        $("#error-reg-rpass").html(" * Las contraseñas no coinciden");
        check = false;
    } else {
        $("#error-reg-rpass").empty();
    }
    if (!c_email) {
        $("#error-reg-email").html(" * Email invalido");
        check = false;
    } else {
        $("#error-reg-email").empty();
    }

    if (check) {
        go_register(user, pass, rpass, email);
    }
}

function go_register(user, pass, rpass, email) {
    // alert(user + " " + pass + " " + rpass + " " + email);

    friendlyURL("?page=login&op=reg").then(function(data) {
        ajaxPromise(
            data,
            'POST',
            'JSON', {
                "user": user,
                "pass": pass,
                "rpass": rpass,
                "email": email
            }
        ).then(function(response) {
            // console.log(response);

            if (response[0] === "error") {
                set_errors_reg(response[1]);
                alerta("error", "ERROR AL REGISTRAR", "No se ha podido registrar el usuario.");
            } else {
                $('.form form').animate({ height: "toggle", opacity: "toggle" }, "slow");
                alerta("success", "REGISTRADO", "Usuario registrado correctamente");
            }
        }).catch(function(response) {
            console.log(response);
        });
    });
}

function login() {
    var user = $("#log-user").val();
    var pass = $("#log-pass").val();

    var c_user = val_username(user);
    var c_pass = val_password(pass);

    var check = true;
    if (!c_user) {
        check = false;
    }
    if (!c_pass) {
        check = false;
    }

    if (check) {
        $('#error-log').empty();
        go_login(user, pass);
    } else {
        $('#error-log').html(" * Usuario o contraseña incorrectos");
    }
}

function go_login(user, pass) {
    friendlyURL("?page=login&op=log").then(function(data) {
        ajaxPromise(
            data,
            'POST',
            'JSON', {
                "user": user,
                "pass": pass
            }
        ).then(function(response) {
            console.log(response);

            alerta(response.type, "", response.msg);

            if (response.type === "success") {
                localStorage.setItem("token", response.data);
                var comingfrom = sessionStorage.getItem("comingfrom");
                // console.log(comingfrom);
                setTimeout(function() {
                    if (comingfrom !== null) {
                        sessionStorage.removeItem("commingfrom");
                        friendlyURL("?page=" + comingfrom + "/").then(function(data) { window.location.href = data; });
                    } else {
                        friendlyURL("?page=home/").then(function(data) { window.location.href = data; });
                    }
                }, 2000);
            }
        }).catch(function(response) {
            console.log(response);
        });
    });
}

function set_errors_reg(errors) {
    if (errors.user) {
        $("#error-reg-user").html(errors.user);
    } else {
        $("#error-reg-user").empty();
    }
    if (errors.pass) {
        $("#error-reg-pass").html(errors.pass);
    } else {
        $("#error-reg-pass").empty();
    }
    if (errors.email) {
        $("#error-reg-email").html(errors.email);
    } else {
        $("#error-reg-email").empty();
    }
}

function set_firebase() {
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = get_firebase();
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    // console.log(firebaseConfig);
}

function get_click_social() {
    set_firebase();
    // console.log("get_click");
    $("#log-gmail").on("click", function() {
        social_gmail();
    });
    $("#log-github").on("click", function() {
        social_github();
    });
}

function social_gmail() {
    // console.log("gmail");

    var provider = new firebase.auth.GoogleAuthProvider();
    provider.addScope('email');

    firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {

            var user = result.user;

            var uid = user.uid;
            var username = user.displayName;
            var email = user.email;
            var avatar = user.photoURL;


            login_social(uid, username, email, avatar);
            // ...
        }).catch((error) => {
            // console.log('Se ha encontrado un error:', error);
            alerta("error", "ERROR", error.message);
            // ...
        });
}

function social_github() {
    // console.log("github");

    var provider = new firebase.auth.GithubAuthProvider();

    firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {

            var user = result.user;

            var uid = user.uid;
            var username = user.displayName;
            var email = user.email;
            var avatar = user.photoURL;


            login_social(uid, username, email, avatar);
            // ...
        }).catch((error) => {
            // console.log('Se ha encontrado un error:', error);

            alerta("error", "ERROR", error.message);
            // ...
        });
}

function login_social(uid, user, email, avatar) {
    friendlyURL("?page=login&op=social").then(function(data) {
        ajaxPromise(
            data,
            'POST',
            'JSON', {
                "uid": uid,
                "user": user,
                "email": email,
                "avatar": avatar
            }
        ).then(function(response) {
            console.log(response);

            alerta(response.type, "", response.msg);

            if (response.type === "success") {
                localStorage.setItem("token", response.data);
                var comingfrom = sessionStorage.getItem("comingfrom");
                // console.log(comingfrom);
                setTimeout(function() {
                    if (comingfrom !== null) {
                        sessionStorage.removeItem("commingfrom");
                        friendlyURL("?page=" + comingfrom + "/").then(function(data) { window.location.href = data; });
                    } else {
                        friendlyURL("?page=home/").then(function(data) { window.location.href = data; });
                    }
                }, 2000);
            }
        }).catch(function(response) {
            // console.log(response);
            alerta("error", "ERROR", "Algo ha fallado");
        });
    });
}

$(document).ready(function() {
    get_content();
});