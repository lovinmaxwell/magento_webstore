<?php
    header('Content-type: text/css; charset: UTF-8');
    header('Cache-Control: must-revalidate');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    $url = $_REQUEST['url'];
?>

.mobilemenu>li.first {
	-webkit-border-radius: 4px 4px 0 0;
	-moz-border-radius: 4px 4px 0 0;
	border-radius: 4px 4px 0 0;
	behavior: url(<?php echo $url; ?>css/css3.htc);
	position: relative;
}
.mobilemenu>li.last {
	-webkit-border-radius:0 0 4px 4px;
	-moz-border-radius: 0 0 4px 4px;
	border-radius: 0 0 4px 4px;
	behavior: url(<?php echo $url; ?>css/css3.htc);
	position: relative;
}
#Example_F {
	-moz-box-shadow: 0 0 5px 5px #888;
	-webkit-box-shadow: 0 0 5px 5px #888;
	box-shadow: 0 0 5px 5px #888;
}
.header .currency-header ul li a {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    behavior: url(<?php echo $url; ?>css/css3.htc);
}


.top-cart-content {
    box-shadow:0 0 6px 0 rgba(0,0,0,0.2);
}
#pt_menu_home a,#pt_menu_home a:hover { border-radius:5px 0 0 5px; }
#pt_custommenu,.block-tags .block-content a,.pt_custommenu div.pt_menu,.breadcrumbs,#search_price span {border-radius:5px; }
.megamenu-title h2,.banner-subscribe .footer-static-title h3 { text-shadow:1px 1px rgba(0,0,0,0.1);}
.megamenu-title { border-radius:5px 5px 0 0;}
.header .search-container .form-search,.block-subscribe button.button span,.top-cart-content { border-radius:5px;}
button.button span,.link-wishlist,.link-compare,.product-view .email-friend a { border-radius:5px; }

.drop-lang .drop-trigger .sub-lang,.drop-currency .currency-trigger .sub-currency { border-radius: 0 0 10px 10px;}
a,.drop-lang li a,.drop-currency li a,.header .links a{
    -moz-transition: color 0.1s ease-in-out 0s;
    transition: color 0.1s ease-in-out;
}
a:hover,.drop-lang li a:hover,.drop-currency li a:hover,.header .links a:hover{
    -moz-transition: color 0.1s ease 0s;
}
.footer-static-content ul li a {
    -moz-transition: all 0.1s ease-in-out 0s;
    transition: padding 0.1s ease-in-out;
}
.footer-static-content ul li a:hover{
    -moz-transition: padding 0.1s ease 0s;
}
.footer-icon a,.link-wishlist,.link-compare,.featuredproductslider-item .actions .button span,.block-tags .block-content a,.products-grid .actions .button span
,.pt_custommenu div.pt_menu.act a, .pt_custommenu div.pt_menu.active .parentMenu a,.pager .view-mode strong.grid, .pager .view-mode a.grid:hover
,.pager .view-mode a.list,.pager .view-mode strong.list, .pager .view-mode a.list:hover,.pager .view-mode a.grid,
.pager .pages a,.product-view .email-friend a,
.pt_custommenu .itemSubMenu h4.level2, .pt_custommenu .itemSubMenu a.level2, .pt_custommenu .itemSubMenu h4.level3, .pt_custommenu .itemSubMenu a.level3, .pt_custommenu .itemMenu a.level1.nochild,
button.button span,.bx-wrapper .bx-controls a,.ma-mostview-products .item .label-pro-sale,
.currency-language a,.top-link ul.links li a,.pt_custommenu div.pt_menu.act a, .pt_custommenu div.pt_menu.active .parentMenu a,#pt_menu_home a:hover,#pt_menu_home.act a,.pt_custommenu div.pt_menu .parentMenu span.block-title:hover,.categorytab-slider .item .label-pro-new,
.categorytab-slider .item .label-pro-sale,.ma-mostview-products .item .label-pro-new,.category-products .item .label-pro-sale,.category-products .item .label-pro-new,
.drop-lang .sub-lang li a,.drop-currency .sub-currency li a,.wrapper_box #shopping_cart, .wrapper_box #continue_shopping,#back-top{
    -moz-transition: all 0.1s ease-in-out 0s;
    transition: all 0.1s ease-in-out;
}
.footer-icon a:hover,button.btn-cart:hover span,.link-wishlist:hover,.link-compare:hover,.block-tags .block-content a:hover,.products-grid .actions .button:hover span,
.featuredproductslider-item .actions .button:hover span,.pager .view-mode strong.grid, .pager .view-mode a.grid:hover
,.pager .view-mode a.list,.pager .view-mode strong.list, .pager .view-mode a.list:hover,.pager .view-mode a.grid,
button.button:hover span,.pager .pages a:hover,.product-view .email-friend a:hover,.bx-wrapper .bx-controls a:hover,.currency-language a:hover,
.top-link ul.links li a:hover,.pt_vmegamenu div.pt_menu .parentMenu span.block-title:hover,
.pt_vmegamenu div.pt_menu .parentMenu a:hover,.categorytab-slider .item:hover .label-pro-new,.categorytab-slider .item:hover .label-pro-sale,
.pt_custommenu div.pt_menu .parentMenu a:hover,.ma-mostview-products .item:hover .label-pro-sale,.ma-mostview-products .item:hover .label-pro-new,
.category-products .item:hover .label-pro-sale,.category-products .item:hover .label-pro-new,.drop-lang .sub-lang li a:hover,
.drop-currency .sub-currency li a:hover,.wrapper_box #shopping_cart:hover, .wrapper_box #continue_shopping:hover,#back-top:hover{
     -moz-transition: all 0.1s ease 0s;
}

.header .search-container button.button span {
    transition:background 0s ease-in-out 0s;
}
.categorytab-slider .box-price,.ma-mostview-products .box-price,.box-price-hover  {border-radius: 100%;}

.custom img,.brands img,.catgrid img {
    -webkit-transition-duration: 0.2s;
    -moz-transition-duration: 0.2s;
    -ms-transition-duration: 0.2s;
    -o-transition-duration: 0.2s;
    transition-duration: 0.2s;
}
.custom img:hover,.brands img:hover,.catgrid img:hover{
    transform: scale(0.95); /* opera not support rotateX */
    -ms-transform: scale(0.95); 
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
}

.static-left .google {
    -moz-transition: all 0.3s ease-in-out 0s;
    transition: all 0.3s ease-in-out;
}
.static-left .google:hover{
    -moz-transition: all 0.3s ease 0s;
}
#sequence .controls{
    -moz-transition: bottom 0.3s ease-in-out 0s;
    transition: bottom 0.3s ease-in-out;
}
#sequence:hover .controls{
    -moz-transition: bottom 0.3s ease 0s;
}
#sequence-theme .controls a,.home-banner-static .banner-box img,.banner_center_one img,.custom-menu-right img,.custom-menu-bottom img{
    -moz-transition: opacity 0.3s ease-in-out 0s;
    transition: opacity 0.3s ease-in-out;
}
#sequence-theme .controls a:hover,.home-banner-static .banner-box img:hover,.banner_center_one img:hover,.custom-menu-right img:hover,.custom-menu-bottom img:hover{
    -moz-transition: opacity 0.3s ease 0s;
    cursor: pointer;
    opacity: 0.8;
}
/*==========================================================================================*/