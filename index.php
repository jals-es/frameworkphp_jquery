<?php
    // if ((isset($_GET['page'])) && ($_GET['page']==="controller_prod") ){
	// 	include("view/inc/top_page_prod.html");
	// }else{
	// 	include("view/inc/top_page.html");
	// }
	$page = "top_page.html";
	include("view/inc/top_bottom.php");

	session_start();
?>
<div id="wrapper" class="warpper">
	<?php
	    include("view/inc/menu.html");
	?>	
    <div id="content">    	
    	<?php
    	    include("view/inc/header.html");
		?>
    	<?php 
		    include("view/inc/pages.php"); 
		?>        
        <!-- <br style="clear:both;" /> -->
		<div id="footer" class="footer">   	   
			<?php
				include("view/inc/footer.html");
			?>        
		</div>
	</div>
</div>
<?php
	echo "<script src='view/js/credentials.js'></script>";
?>
<?php
	// if ((isset($_GET['page'])) && ($_GET['page']==="controller_prod") ){
	// 	include("view/inc/bottom_page_prod.html");
	// }else{
	// 	include("view/inc/bottom_page.html");
	// }
	$page = "bottom_page.html";
    include("view/inc/top_bottom.php");
?> 