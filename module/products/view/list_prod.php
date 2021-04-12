<div id="contenido">
    <div class="container">
    	<div class="row">
    			<h3 data-tr="ListProd"></h3>
    	</div>
    	<div class="row">
    		<p><a href="?page=controller_prod&op=create"><img src="view/img/anadir.png"></a></p>
    		<br><br>
    		<table id="table_crud">
                <thead>
                    <tr>
                        <td width=125><b>NOMBRE</b></th>
                        <td width=125><b>TIPO</b></th>
                        <td width=125><b>PRECIO</b></th>
                        <th width=350><b>Accion</b></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($rdo->num_rows === 0){
                        echo '<tr>';
                        echo '<td align="center"  colspan="3" data-tr="NoProducts"></td>';
                        echo '</tr>';
                    }else{
                        foreach ($rdo as $row) {
                       		echo '<tr>';
                    	   	echo '<td width=125>'. $row['name'] . '</td>';
                    	   	echo '<td width=125>'. $row['type'] . '</td>';
                    	   	echo '<td width=125>'. $row['precio'] . '€</td>';
                    	   	echo '<td width=350>';
                    	   	echo '<div class="button_action button read_prod" id="'.$row['cod_prod'].'" data-tr="Read">Read</div>';
                    	   	echo '&nbsp;';
                    	   	echo '<a class="button_action" href="?page=controller_prod&op=update&id='.$row['cod_prod'].'" data-tr="Update">Update</a>';
                    	   	echo '&nbsp;';
                    	   	echo '<a class="button_action" href="?page=controller_prod&op=delete&id='.$row['cod_prod'].'" data-tr="Delete">Delete</a>';
                    	   	echo '</td>';
                    	   	echo '</tr>';
                        }
                    }
                ?>
                </tbody>
            </table>
    	</div>
    </div>
</div>

<section id="prod_modal"></section>