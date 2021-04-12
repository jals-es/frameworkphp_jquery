<?php 

if($page === "bottom_page.html"){
	echo '
	<script src="view/js/jquery.min.js"></script>
	<script src="view/js/popper.min.js"></script>
	<script src="view/js/bootstrap.bundle.min.js"></script>
	<script src="view/js/owl.carousel.min.js"></script>
	<script src="view/js/custom.js"></script>
	<script src="view/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="view/js/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="view/js/menu.js"></script>
	<script type="text/javascript" src="view/js/translate.js"></script>
	<script type="text/javascript" src="view/js/checksession.js"></script>
	';
}

if(isset($_GET['page'])){
	switch($_GET['page']){
		case "login":
			include("module/login/view/".$page);
			break;
		case "homepage";
			include("module/inicio/view/".$page);
			break;
		case "controller_prod";
			include("module/products/view/".$page);
			break;
		case "shop";
			include("module/shop/view/".$page);
			break;
		case "services";
			include("module/services/view/".$page);
			break;
		case "aboutus";
			include("module/aboutus/view/".$page);
			break;
		case "contactus";
			include("module/contact/view/".$page);
			break;
		default;
			include("view/inc/".$page);
			break;
	}
}else{
	include("module/inicio/view/".$page);
}


?>