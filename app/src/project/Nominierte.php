<?php

use SilverStripe\Admin\ModelAdmin;

class Nominierte extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-p-shield';

    private static $managed_models = array('Project'); 
    private static $url_segment = 'nominierte'; 
    private static $menu_title = "Nominierte";
    
    private static $menu_priority = -101;

    //public $showImportForm = false;

    public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            $list = $list->filter(array("Nominierte"=>"Ja"));

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }
        }

        return $list;
    }

    /*public function getExportFields() {
        return singleton($this->modelClass)->summaryFields();
    }*/
    
}
