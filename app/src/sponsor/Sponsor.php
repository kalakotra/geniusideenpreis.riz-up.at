<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;

class Sponsor extends DataObject {

	private static $db = array(
		'Firma' => 'Varchar(100)',
		'Strasse' => 'Varchar(200)',
		'Ort' => 'Varchar(100)',
		
		
		'Preisgeld' => 'Varchar(100)',

		'Anrede' => 'Enum("Frau,Herr", "Frau")',
        'AkademischerGrad' => 'Varchar(100)',
        'Vorname' => 'Varchar(100)',
        'Nachname' => 'Varchar(100)',
        'Email' => 'Varchar(100)'

	);

	private static $has_one = array(
		
	);

	private static $many_many = array(
		
	);
	private static $summary_fields = array(
		'Firma' => 'Firma',
		'Strasse' => 'Stra&szlig;e',
		'Ort'=>'Ort',
		'myAnsprechPartner'=>'AnsprechPartner',
		'Email' => 'E-Mail',
		'Preisgeld'=>'Preisgeld'
		
	);

	public function onAfterWrite() {
		parent::onAfterWrite();

		
	}

	public function myAnsprechPartner() {
		return DBField::create_field('HTMLVarchar', $this->Anrede. " ".$this->AkademischerGrad." ".$this->Vorname." ".$this->Nachname);
	}

	public function PreisgeldVergeben() {

		$projects = Project::get();

		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $projects = $projects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }

		$projects = $projects->where("Sponsor1ID='".$this->ID."' OR Sponsor2ID='".$this->ID."' OR Sponsor3ID='".$this->ID."'");
		$mySum = 0;
		foreach ($projects as $key => $value) {
			if ($value->Sponsor1ID == $this->ID) {
				$mySum += (float)$value->Preisgeld1;
			} else if ($value->Sponsor2ID == $this->ID) {
				$mySum += (float)$value->Preisgeld2;
			} else if ($value->Sponsor3ID == $this->ID) {
				$mySum += (float)$value->Preisgeld3;
			}
		}

		return $mySum;
	}

	public function PreisgeldOffen() {
		return $this->Preisgeld-$this->PreisgeldVergeben();
	}

}