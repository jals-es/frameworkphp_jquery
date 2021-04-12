<div id="contenido">
    <form autocomplete="on" method="post" name="delete_prod" id="delete_prod" action="?page=controller_prod&op=delete&id=<?= $_GET['id']; ?>">
        <table border='0'>
            <tr>
                <td align="center"  colspan="2"><h3>¿Desea seguro borrar el producto <?= $_GET['id']; ?>?</h3></td>
                
            </tr>
            <tr>
                <td align="center"><button class="button_action" type="submit" name="delete" id="delete">Aceptar</button></td>
                <td align="center"><a class="button_action" href="?page=controller_prod&op=list">Cancelar</a></td>
            </tr>
        </table>
    </form>
</div>