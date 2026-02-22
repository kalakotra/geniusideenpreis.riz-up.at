<?php

use SilverStripe\Admin\ModelAdmin;

class Auswertungen extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-checklist';

    private static $managed_models = array('Project'); 
    private static $url_segment = 'auswertungen'; 
    private static $menu_title = "Jury finished";
    

    //public $showImportForm = false;

    public function getList() {
        $list = parent::getList();

        


        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            $list = $list->innerJoin("Bewertung", "Bewertung.ProjectID=Project.ID");

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }

            foreach ($list as $key => $value) {
                $myBewertung = Bewertung::get()->filter(array("ProjectID"=>$value->ID, "Status"=>"3"));
                if ($myBewertung->count() != $value->juryMemberCount()) {
                    $list = $list->exclude( array("ID"=> $value->ID) );
                } 
            }
        }

        return $list;
    }

    public function getExportFields() {
        //return singleton($this->modelClass)->summaryFields();
        return array(
            'ProjectNumber' => 'Pr. nr.',
            'IdeenTitle' => 'Projekttitel',
            'Nominierte' => 'Nominierte',
            'myFullNameExport' => 'Name',
            'Firma' => 'Firma',
            'Kategories.Title' => 'Kategorie',
            'getJuryStatusExport' => 'Juror 1',
            'getJuryStatusExport2' => 'Juror 2',
            /*'getJuryStatus3' => 'Juror 3',*/
            'getJuryPointsExport' => 'Vorl. Punk',
            'JuryPlace' => 'Vorl. Platz',
            'getAdminPointsExport' => 'Fin. Punkte',
            'AdminPlace' => 'Fin. Platz',
            'myKurzBeschreibung' => 'Projektbeschreibung'
        );
    }

    private static $menu_priority = -100;
    
}