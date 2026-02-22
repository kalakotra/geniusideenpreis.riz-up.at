<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\ORM\ArrayList;

class UnfinishedAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-p-blocked';

	private static $managed_models = array('Project'); 
	private static $url_segment = 'unfinishedprojects'; 
	private static $menu_title = "Jury unfinished";

	private static $menu_priority = -99;
 
	public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Project') {
            
            $set = new ArrayList;
            
            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }
            
            $list2 = $list; // $list->where("Project.Status='geprüft&freigegeben'");
            if ($list2->count() > 0) {
                $added = array();
                foreach($list2 as $obj) {
                    $myJury = 0;
                    if ($obj->Jury1ID) {
                        $myBewertung = Bewertung::get()->where("JuryID='".$obj->Jury1ID."' AND ProjectID='".$obj->ID."' AND Status='3'");
                        if ($myBewertung->count() > 0) {
                            
                        } else {
                            if (!in_array($obj->ID, $added)) {
                                $set->push($obj);
                                $added[] = $obj->ID;
                            }
                        }
                    }

                    if ($obj->Jury2ID) {
                        $myBewertung = Bewertung::get()->where("JuryID='".$obj->Jury2ID."' AND ProjectID='".$obj->ID."' AND Status='3'");
                        if ($myBewertung->count() > 0) {
                            
                        } else {
                            if (!in_array($obj->ID, $added)) {
                                $set->push($obj);
                                $added[] = $obj->ID;
                            }
                        }
                    }

                    /*if ($obj->Jury3ID) {
                        $myBewertung = Bewertung::get()->where("JuryID='".$obj->Jury3ID."' AND ProjectID='".$obj->ID."' AND Status='3'");
                        if ($myBewertung->count() > 0) {
                            
                        } else {
                            if (!in_array($obj->ID, $added)) {
                                $set->push($obj);
                                $added[] = $obj->ID;
                            }
                        }
                    }*/
                    
                    
                }

                //echo count($added)."<----";
                if (count($added) > 0 ) {
                    return $list->filter(array("ID" => $added));
                }
                
            }
        }
        return $list->filter(array("ID"=> 0));
        //return $set;
    }
}