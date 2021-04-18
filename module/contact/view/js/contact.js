function validate_name(name) {
    if (name.length != 0) {
        return true;
    }
    return false;
}

function validate_email(email) {
    var example = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
    if (email.length != 0 && email.match(example)) {
        return true;
    }
    return false;
}

function validate_text(text) {
    if (text.length != 0) {
        return true;
    }
    return false;
}

function check_email() {
    var get_name = $("#contact-form-name").val();
    var get_email = $("#contact-form-email").val();
    var get_text = $("#contact-form-text").val();

    var val_name = validate_name(get_name);
    var val_email = validate_email(get_email);
    var val_text = validate_text(get_text);

    var check = true;

    if (val_name) {
        $('#error-name').empty();
    } else {
        $('#error-name').html(" * Pon tu nombre");
        check = false;
    }
    if (val_email) {
        $('#error-email').empty();
    } else {
        $('#error-email').html(" * Pon tu email");
        check = false;
    }
    if (val_text) {
        $('#error-text').empty();
    } else {
        $('#error-text').html(" * Escribe un mensaje");
        check = false;
    }

    if (check) {
        send_email(get_name, get_email, get_text);
    }
}

function send_email(name, email, text) {
    friendlyURL("?page=contact&op=send_email").then(function(data) {
        ajaxPromise(
            data,
            "POST",
            "TEXT", {
                "name": name,
                "email": email,
                "text": text
            }
        ).then(function(response) {
            // console.log(response);

            if (response) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success("Gracias por contactar con nosotros.", "Correo Enviado");
            } else {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.error("No se ha podido enviar el correo de contacto.", "ERROR AL ENVIAR");
            }
            clear_form();
        }).catch(function(response) {
            console.log(response);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.error("No se ha podido enviar el correo de contacto.", "ERROR AL ENVIAR");
            clear_form();
        });
    });
}

function clear_form() {
    $("#contact-form-name").empty();
    $("#contact-form-email").empty();
    $("#contact-form-text").empty();
}

$(document).ready(function() {
    $("#contact-form-send").on("click", function() {
        check_email();
    });
});