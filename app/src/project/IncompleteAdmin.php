<?php

use SilverStripe\Admin\ModelAdmin;

class IncompleteAdmin extends ModelAdmin {

	private static $menu_icon_class = 'font-icon-menu-pages';

	private static $managed_models = array('Project'); 
	private static $url_segment = 'incompletedprojects'; 
	private static $menu_title = "Einreichung unfinished";

	private static $menu_priority = -99;
 
	public function getList() {
        $list = parent::getList();

        $myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }

        return $list->filter(array("Completed"=>"0"));
    }
}