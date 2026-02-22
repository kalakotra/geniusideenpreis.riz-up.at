<?php

use SilverStripe\Admin\ModelAdmin;

class JurysitzungAdmin extends ModelAdmin {

    //private static $menu_icon = 'framework/admin/images/menu-icons/16x16/study.png';

	private static $managed_models = array('Project'); 
	private static $url_segment = 'jurysitzung'; 
	private static $menu_title = "Projekte - Jurysitzung";

	public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            $list = $list->filter(array("Jurysitzung"=>"Ja"));

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }
        }

        return $list;
    }

    public function getExportFields() 
    {
        return [
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
        ];
    }
}
