function set_menu() {
    $('#main_menu').html(
        '<li><a data-tr="Homepage" href="' + SITE_PATH + '"></a></li>' +
        '<li><a data-tr="Shop" id="shop-menu-button" href="' + SITE_PATH + 'shop/"></a></li>' +
        '<li><a data-tr="Contact" href="' + SITE_PATH + 'contact/"></a></li>' +
        '<li><a data-tr="Services" href="' + SITE_PATH + 'services/"></a></li>' +
        '<li><a data-tr="About Us" href="' + SITE_PATH + 'aboutus/"></a></li>'
    );
}

$(document).ready(function() {
    set_menu();
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function() {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $('#shop-menu-button').on('click', function() {
        localStorage.removeItem('shop_filter');
        localStorage.removeItem('shop_filter_id');
    });
});