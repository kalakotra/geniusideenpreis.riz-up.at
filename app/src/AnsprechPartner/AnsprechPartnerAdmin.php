<?php

use SilverStripe\Admin\ModelAdmin;

class AnsprechPartnerAdmin extends ModelAdmin {

	private static $menu_icon_class = 'font-icon-menu-security';

	private static $managed_models = array('AnsprechPartner'); 
	private static $url_segment = 'ansprechpartner'; 
	private static $menu_title = "Ansprechperson";

	
}