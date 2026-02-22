<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;

class ProjectAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-menu-pages';

	private static $managed_models = [
        'Project', 
        'Kategorie'
    ]; 

	private static $url_segment = 'projects'; 
	private static $menu_title = "Projekte";

	private static $menu_priority = -99;
 
	public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            $list = $list->filter(array("Completed"=>"1"))->sort("Status DESC");

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }

        }


        /*if($this->modelClass == 'Bewertung') {
            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $myProject = Project::get()->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }

            $myIds = "0";
            foreach ($myProject as $key => $value) {
                $myIds .= ",".$value->ID;
            }

            $list = $list->where("ProjectID IN (".$myIds.")");
        }*/


        
        return $list;
    }


    /*public function getExportFields() {
        if($this->modelClass == 'Project') {
            return singleton($this->modelClass)->CSVExportFields();
        }
    }*/
}