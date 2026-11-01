<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Kalakotra\DuplicateDataObject\Forms\GridField\GridFieldDuplicateAction;

class CompetitionAdmin extends ModelAdmin {

	private static $menu_icon_class = 'font-icon-block-file-list';
	
	private static $managed_models = [
		Competition::class,
		CompetitionCriteria::class
	]; 
	private static $url_segment = 'competition'; 
	private static $menu_title = "Competition";

	private static $menu_priority = -80;

	protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        //$config->addComponent(new GridFieldDuplicateAction());

        return $config;
    }
	
}