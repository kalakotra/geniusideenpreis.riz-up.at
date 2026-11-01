<?php

use SilverStripe\Admin\ModelAdmin;

class BewertungAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-menu-reports';

	private static $managed_models = array('Bewertung'); 
	private static $url_segment = 'bewertung'; 
	private static $menu_title = "Bewertung";

	private static $menu_priority = -99;
 
	public function getList() {
        $list = parent::getList();

        if($this->modelClass == 'Bewertung') {
            $myProject = Project::get();

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $myProject = $myProject->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }

            $myIds = "0";
            foreach ($myProject as $key => $value) {
                $myIds .= ",".$value->ID;
            }

            $list = $list->where("ProjectID IN (".$myIds.")");
        }


        
        return $list;
    }

    //public function getExportFields() {
        //if($this->modelClass == 'Project') {
            //return singleton($this->modelClass)->CSVExportFields();
        //}
    //}
}

