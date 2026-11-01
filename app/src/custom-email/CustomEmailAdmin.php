<?php

use SilverStripe\Admin\ModelAdmin;

class CustomEmailAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-edit-list';

	private static $managed_models = [
		'CustomEmail'
	]; 
	private static $url_segment = 'emails'; 
	private static $menu_title = "Emails";

	//private static $showImportForm = false;

	
}