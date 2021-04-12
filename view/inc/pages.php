<?php
if(isset($_GET['page'])){
	switch($_GET['page']){
		case "login":
			include("module/login/view/login.html");
			break;
		case "homepage";
			include("module/inicio/view/inicio.html");
			break;
		case "controller_prod";
			include("module/products/controller/".$_GET['page'].".php");
			break;
		case "shop";
			include("module/shop/controller/controller_shop.php");
			break;
		case "services";
			include("module/services/".$_GET['page'].".php");
			break;
		case "aboutus";
			include("module/aboutus/view/about_us.html");
			break;
		case "contactus";
			include("module/contact/".$_GET['page'].".php");
			break;
		case "404";
			include("view/inc/error".$_GET['page'].".php");
			break;
		case "503";
			include("view/inc/error".$_GET['page'].".php");
			break;
		default;
			include("view/inc/error404.php");
			break;
	}
}else{
	include("module/inicio/view/inicio.html");
}
?>