function validate_name(name) {
    if (name.length > 0) {
        //console.log("true1");
        return true;
    }
    return false;
}

function validate_descripcion(descripcion) {
    if (descripcion.length > 0) {
        //console.log("true2");
        return true;
    }
    return false;
}

function validate_tipo(tipo) {
    if (tipo == "hamburguesa" || tipo == "pizza") {
        return true;
    }
    return false;
}

function validate_pan(pan) {
    var i;
    var check = false;
    for (i = 0; i < pan.length; i++) {
        if (pan[i].checked) {
            check = true;
        }
    }
    return check;
}

function validate_content(content) {
    var i;
    var check = false;
    for (i = 0; i < content.length; i++) {
        if (content[i].checked) {
            check = true;
        }
    }
    return check;
}

function validate_price(price) {
    var tipo = document.getElementById("tipo");
    var precio = 0;
    if (tipo.value == "hamburguesa") {
        precio = "5";
    } else {
        precio = "10";
    }

    if (precio == price) {
        return true;
    } else {
        return false;
    }
}

function validate(type) {
    var check = true;

    var v_name = document.getElementById("name").value;
    var v_descripcion = document.getElementById("descripcion").value;
    var v_tipo = document.getElementById("tipo").value;
    var v_pan = document.getElementsByName("pan");
    var v_content = document.getElementsByName("content[]");
    var v_price = document.getElementById("precio").innerHTML;

    var r_name = validate_name(v_name);
    var r_descripcion = validate_descripcion(v_descripcion);
    var r_tipo = validate_tipo(v_tipo);
    var r_pan = validate_pan(v_pan);
    var r_content = validate_content(v_content);
    var r_price = validate_price(v_price);

    if (r_name) {
        document.getElementById("error_name").innerHTML = "";
    } else {
        document.getElementById("error_name").innerHTML = " * El nombre no puede estar vacío.";
        check = false;
    }
    if (r_descripcion) {
        document.getElementById("error_descripcion").innerHTML = "";
    } else {
        document.getElementById("error_descripcion").innerHTML = " * La descripción no puede estar vacía.";
        check = false;
    }
    if (r_tipo) {
        document.getElementById("error_tipo").innerHTML = "";
    } else {
        document.getElementById("error_tipo").innerHTML = " * Error con el tipo de producto.";
        check = false;
    }
    if (r_pan) {
        ingredientes = "";
    } else {
        ingredientes = " * Selecciona uno de los 3 tipos de pan/masa disponibles.<br>";
        check = false;
    }
    if (r_content) {
        ingredientes = ingredientes + "";
    } else {
        ingredientes = ingredientes + " * Selecciona almenos 1 ingrediente.";
        check = false;
    }
    document.getElementById("error_ingredientes").innerHTML = ingredientes;
    if (r_price) {
        document.getElementById("error_price").innerHTML = "";
    } else {
        document.getElementById("error_price").innerHTML = " * Error con el precio del producto.";
        check = false;
    }

    if (check) {
        if (type == "create") {
            alta_prod = document.getElementById("alta_prod");
            document.alta_prod.action = "?page=controller_prod&op=create";
            document.alta_prod.submit();
        } else if (type == "update") {
            update_prod = document.getElementById("update_prod");
            prod_id = document.getElementById("prod_id").value;
            document.update_prod.action = "?page=controller_prod&op=update&id=" + prod_id;
            document.update_prod.submit();
        }
    } else {
        return check;
    }
}

function showModal(prod_title, prod_id) {
    //////
    $("#details_prod").show();
    $("#prod_modal").dialog({
        title: prod_title,
        width: 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "fold",
        show: "fold",
        buttons: {
            Update: function() {
                window.location.href = '?page=controller_prod&op=update&id=' + prod_id;
            },
            Delete: function() {
                window.location.href = '?page=controller_prod&op=delete&id=' + prod_id;
            }
        } // end_Buttons
    }); // end_Dialog
}

function loadContentModal() {
    $('.read_prod').on('click', function() {
        var id = this.getAttribute('id');

        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: "module/products/controller/controller_prod.php?op=read&id=" + id,
        }).done(function(response) {
            $('<div></div>').attr('id', 'details_prod', 'type', 'hidden').appendTo('#prod_modal');
            $('<div></div>').attr('id', 'container_prod').appendTo('#details_prod');
            $('#container_prod').empty();
            $('<div></div>').attr('id', 'Div1').appendTo('#container_prod');
            $('#Div1').html(function() {
                var content = "";
                var ingredientes = "";
                var ingre = "";
                for (row in response) {
                    if (row == "ingredientes") {
                        ingredientes = response[row].split(":");
                        for (ing in ingredientes) {
                            if (ing == 0) {
                                ingre = ingredientes[ing];
                            } else {
                                ingre += ", " + ingredientes[ing];
                            }
                        }
                        content += '<br><span>' + row + ': <span id =' + row + '>' + ingre + '</span></span>';
                    } else {
                        content += '<br><span>' + row + ': <span id =' + row + '>' + response[row] + '</span></span>';
                    }
                } // end_for
                //////
                return content;
            });
            //////
            showModal(prod_title = response.name, response.cod_prod);
            //////
        }).fail(function() {
            window.location.href = '?page=503';
        });
    });
}

$(document).ready(function() {
    // console.log("ready");
    loadContentModal();
    $('#table_crud').DataTable();
});