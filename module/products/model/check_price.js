function check_price() {
    var tipo = document.getElementById("tipo");
    var precio = document.getElementById("precio");
    if (tipo.value == "hamburguesa") {
        precio.innerHTML = "5";
    } else {
        precio.innerHTML = "10";
    }
}

var tipo = document.getElementById("tipo");
tipo.addEventListener('change', (event) => {
    check_price();
});

check_price();