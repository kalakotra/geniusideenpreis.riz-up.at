<?php

use SilverStripe\Admin\ModelAdmin;

class SponsorAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-menu-reports';

    private static $managed_models = [
        'Sponsor'
    ];

    private static $url_segment = 'sponsor'; 
    private static $menu_title = "Sponsor";
    

    //public $showImportForm = false;

    /*public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            $list = $list->filter(array("Nominierte"=>1));
        }

        return $list;
    }*/

    /*public function getExportFields() {
        return singleton($this->modelClass)->summaryFields();
    }*/
    
}