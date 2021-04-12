<div id="contenido">
    <form autocomplete="on" method="post" name="update_prod" id="update_prod" onsubmit="return validate();">
        <input type="hidden" id="prod_id" value="<?= $_GET['id'];?>">
        <h1 class="title" data-tr="UpdateProd"></h1>
        <table border='0'>
            <tr>
                <td><b>Nombre: </b></td>
                <td><input type="text" id="name" name="name" placeholder="Nombre del producto" value="<?= $prod['name'];?>"/></td>
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
                <td><textarea id="descripcion" name="descripcion" placeholder="Descripción del producto"><?= $prod['descripcion'];?></textarea></td>
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
                        <option value="hamburguesa" <?php if($prod['type'] === "hamburguesa"){echo "selected";}?>>Hamburguesa</option>
                        <option value="pizza" <?php if($prod['type'] === "pizza"){echo "selected";}?>>Pizza</option>
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
                    <?php 
                    
                    $ing = explode(":", $prod['ingredientes']);

                    ?>
                    <input type="radio" name="pan" value="normal" <?php if(in_array("normal", $ing)){echo "checked";}?>>Normal
                    <input type="radio" name="pan" value="sin_gluten" <?php if(in_array("sin_gluten", $ing)){echo "checked";}?>>Sin Gluten
                    <input type="radio" name="pan" value="integral" <?php if(in_array("integral", $ing)){echo "checked";}?>>Integral
                    
                    <br>Contenido:<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="queso" <?php if(in_array("queso", $ing)){echo "checked";}?>/>Queso
                    <input type="checkbox" id= "content[]" name="content[]" value="jserrano" <?php if(in_array("jserrano", $ing)){echo "checked";}?>/>Jamón Serrano
                    <input type="checkbox" id= "content[]" name="content[]" value="jyork" <?php if(in_array("jyork", $ing)){echo "checked";}?>/>Jamón York
                    <input type="checkbox" id= "content[]" name="content[]" value="tomate" <?php if(in_array("tomate", $ing)){echo "checked";}?>/>Tomate
                    <input type="checkbox" id= "content[]" name="content[]" value="aceitunas" <?php if(in_array("aceitunas", $ing)){echo "checked";}?>/>Aceitunas
                    <input type="checkbox" id= "content[]" name="content[]" value="bacon" <?php if(in_array("bacon", $ing)){echo "checked";}?>/>Bacon
                    <input type="checkbox" id= "content[]" name="content[]" value="piña" <?php if(in_array("piña", $ing)){echo "checked";}?>/>Piña<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="huevo" <?php if(in_array("huevo", $ing)){echo "checked";}?>/>Huevo
                    <input type="checkbox" id= "content[]" name="content[]" value="peperoni" <?php if(in_array("peperoni", $ing)){echo "checked";}?>/>Peperoni
                    <input type="checkbox" id= "content[]" name="content[]" value="ketchup" <?php if(in_array("ketchup", $ing)){echo "checked";}?>/>Ketchup
                    <input type="checkbox" id= "content[]" name="content[]" value="mayonesa" <?php if(in_array("mayonesa", $ing)){echo "checked";}?>/>Mayonesa
                    <input type="checkbox" id= "content[]" name="content[]" value="sbarbacoa" <?php if(in_array("sbarbacoa", $ing)){echo "checked";}?>/>Salsa Barbacoa
                    <input type="checkbox" id= "content[]" name="content[]" value="syogurt" <?php if(in_array("syogurt", $ing)){echo "checked";}?>/>Salsa Yogurt
                    <input type="checkbox" id= "content[]" name="content[]" value="mostaza" <?php if(in_array("mostaza", $ing)){echo "checked";}?>/>Mostaza<br>
                    <input type="checkbox" id= "content[]" name="content[]" value="sbrava" <?php if(in_array("sbrava", $ing)){echo "checked";}?>/>Salsa Brava
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
            
            <tr>
                <td><button class="button_action" onclick="return validate('update');" name="update" data-tr="enviar"></button></td>
                <td align="right"><a class="button_action" href="?page=controller_prod&op=list" data-tr="Back"></a></td>
            </tr>
        </table>
    </form>
    <script src="module/products/model/check_price.js"></script>
</div>