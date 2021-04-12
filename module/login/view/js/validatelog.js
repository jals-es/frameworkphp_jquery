function val_username(user) {
    var reg = /^[a-zA-Z]+$/;
    if (user.match(reg)) {
        return true;
    }
    return false;
}

function val_password(pass) {
    var reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    // console.log(pass.length);
    if (pass.match(reg)) {
        return true;
    }
    return false;
}

function check_same_password(pass, rpass) {
    if (pass === rpass) {
        return true;
    }
    return false;
}

function val_email(email) {
    var reg = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
    if (email.match(reg)) {
        return true;
    }
    return false;
}