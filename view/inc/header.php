<header class="sticky-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="full d-flex">
                    <a class="logo col align-self-center" href="<?= SITE_PATH?>"><img src="<?= IMG_PATH?>logo.png" alt="#" /></a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="full">
                    <div class="right_header_info">
                        <ul>
                            <li class="dinone"><label data-tr="Contact"></label>: <img style="margin-right: 15px;margin-left: 15px;" src="<?= IMG_PATH?>phone_icon.png" alt="#"><a href="#">987-654-3210</a></li>
                            <li class="dinone"><img style="margin-right: 15px;" src="<?= IMG_PATH?>mail_icon.png" alt="#"><a href="#">demo@gmail.com</a></li>
                            <li class="dinone"><img style="margin-right: 15px;height: 21px;position: relative;top: -2px;" src="<?= IMG_PATH?>location_icon.png" alt="#"><a href="#">104 New york , USA</a></li>
                            <li class="button_user">
                                <!-- <a class="button active" id="log-btn">Login</a>
                                <a class="button" id="reg-btn">Register</a> -->
                            </li>
                            <li class="search_li">
                                <img style="margin-right: 15px;" src="<?= IMG_PATH?>search_icon.png" alt="#" class="dropbtn">
                                <form id="myDropdown" class="dropdown-content">
                                </form>
                            </li>
                            <li>
                                <select id="lang-btn">
                                    <option id="op-val" value="val">VAL</option>
                                    <option id="op-es" value="es">ES</option>
                                    <option id="op-en" value="en">EN</option>
                                </select>
                            </li>
                            <li>
                                <button type="button" id="sidebarCollapse">
                                    <img src="<?= IMG_PATH?>menu_icon.png" alt="#">
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= JS_PATH?>search.js"></script>
</header>