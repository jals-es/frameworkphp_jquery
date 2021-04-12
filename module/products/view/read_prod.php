<div id="contenido">
    <h1>Informacion del Usuario</h1>
    <p>
    <table border='2'>
        <tr>
            <td>Nombre: </td>
            <td>
                <?= $prod['name'];?>
            </td>
        </tr>
    
        <tr>
            <td>Descripción: </td>
            <td>
                <?= $prod['descripcion'];?>
            </td>
        </tr>
        
        <tr>
            <td>Tipo: </td>
            <td>
                <?= $prod['type'];?>
            </td>
        </tr>
        
        <tr>
            <td>Ingredientes: </td>
            <td>
                <?php 
                $i=0;
                $ingredientes = explode(":",$prod['ingredientes']);
                foreach($ingredientes as $ing){
                    if($i == 0){
                        echo "Pan " . $ing;
                    }else{
                        echo " - $ing";
                    }
                    $i++;
                }
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Precio: </td>
            <td>
                <?= $prod['precio'];?>
            </td>
        </tr>
        
        <tr>
            <td>Estado: </td>
            <td>
                <?= $prod['estado'];?>
            </td>
        </tr>
        
    </table>
    </p>
    <p><a href="?page=controller_prod&op=list">Volver</a></p>
</div>