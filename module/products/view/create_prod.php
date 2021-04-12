<div id="contenido">
    <form autocomplete="on" name="alta_prod" id="alta_prod" method="post">
        <h1 class="title" data-tr="CreateProd"></h1>
        <table border='0'>
            <tr>
                <td><b>Nombre: </b></td>
                <td><input type="text" id="name" name="name" placeholder="Nombre del producto"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <font color="red">
                        <span id="error_name" class="error">
                            <?php
                                if(isset($error_name)){echo $error_name;}
                            ?>
                        </span>
                    </font>
                </td>
            </tr>
            <tr>
                <td><b>Descripción: </b></td>
                <td><textarea id="descripcion" name="descripcion" placeholder="Descripción del producto"></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <font color="red">
                        <span id="error_descripcion" class="error">
                            <?php
                                if(isset($error_descripcion)){echo $error_descripcion;}
                            ?>
                        </span>
                    </font>
                </td>
            </tr>
            
            <tr>
                <td><b>Tipo: </b></td>
                <td>
                    <select name="tipo" id="tipo">
                        <option value="hamburguesa">Hamburguesa</option>
                        <option value="pizza">Pizza</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font color="red">
                        <span id="error_tipo" class="error">
                            <?php
                                if(isset($error_tipo)){echo $error_tipo;}
                            ?>
                        </span>
                    </font>
                </td>
            </tr>
            
            <tr>
                <td><b>Ingredientes: </b></td>
                <td>
                    Pan/Masa:<br>
                    <input type="radio" name="pan" value="normal" checked>Normal
                    <input type="radio" name="pan" value="sin_gluten">Sin Gluten
                    <input type="radio" name="pan" value="integral">Integral
                    
                    <br>Contenido:<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="queso"/>Queso
                    <input type="checkbox" id= "content[]" name="content[]" value="jserrano"/>Jamón Serrano
                    <input type="checkbox" id= "content[]" name="content[]" value="jyork"/>Jamón York
                    <input type="checkbox" id= "content[]" name="content[]" value="tomate"/>Tomate
                    <input type="checkbox" id= "content[]" name="content[]" value="aceitunas"/>Aceitunas
                    <input type="checkbox" id= "content[]" name="content[]" value="bacon"/>Bacon
                    <input type="checkbox" id= "content[]" name="content[]" value="pinya"/>Piña<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="huevo"/>Huevo
                    <input type="checkbox" id= "content[]" name="content[]" value="peperoni"/>Peperoni
                    <input type="checkbox" id= "content[]" name="content[]" value="ketchup"/>Ketchup
                    <input type="checkbox" id= "content[]" name="content[]" value="mayonesa"/>Mayonesa
                    <input type="checkbox" id= "content[]" name="content[]" value="sbarbacoa"/>Salsa Barbacoa
                    <input type="checkbox" id= "content[]" name="content[]" value="syogurt"/>Salsa Yogurt
                    <input type="checkbox" id= "content[]" name="content[]" value="mostaza"/>Mostaza<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="sbrava"/>Salsa Brava
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font color="red">
                        <span id="error_ingredientes" class="error">
                            <?php
                                if(isset($error_ingredientes)){echo $error_ingredientes;}
                            ?>
                        </span>
                    </font>
                </td>
            </tr>
            
            <tr>
                <td><b>Precio: </b></td>
                <td><label id="precio">0</label>€</td>
            </tr>

            <tr>
                <td colspan="2">
                    <font color="red">
                        <span id="error_price" class="error">
                            <?php
                                if(isset($error_precio)){echo $error_precio;}
                            ?>
                        </span>
                    </font>
                </td>
            </tr>
            
            <tr class="botonera">
                <td><button class="button_action" onclick="return validate('create');" name="create" data-tr="enviar"></button></td>
                <td align="right"><a class="button_action" href="?page=controller_prod&op=list" data-tr="Back"></a></td>
            </tr>
        </table>
    </form>
    <script src="module/products/model/check_price.js"></script>
</div>