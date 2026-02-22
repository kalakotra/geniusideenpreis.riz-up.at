<?php

use SilverStripe\ORM\DataObject;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Member;


class Bewertung extends DataObject {

	private static $menu_icon_class = 'font-icon-menu-reports';

	private static $db = array(
		'InnovationsKommentar' => 'Text',
		'InnovationsBewertung' => 'Enum("0,1,2,3,4,5", "0")',
		'InnovationsPunkte' => 'Decimal(9,2)',

		'MarktKommentar' => 'Text',
		'MarktBewertung' => 'Enum("0,1,2,3,4,5", "0")',
		'MarktPunkte' => 'Decimal(9,2)',

		'UmsetzungsrelevanzKommentar' => 'Text',
		'UmsetzungsrelevanzBewertung' => 'Enum("0,1,2,3,4,5", "0")',
		'UmsetzungsrelevanzPunkte' => 'Decimal(9,2)',

		'WirtschaftsrelevanzKommentar' => 'Text',
		'WirtschaftsrelevanzBewertung' => 'Enum("0,1,2,3,4,5", "0")',
		'WirtschaftsrelevanzPunkte' => 'Decimal(9,2)',

		'QualitatKommentar' => 'Text',
		'QualitatBewertung' => 'Enum("0,1,2,3,4,5", "0")',
		'QualitatPunkte' => 'Decimal(9,2)',

		'ProjektbezugKommentar' => 'Text',
		'GesamtKommentar' => 'Text',

		
		'Status' => 'Int'

	);

	private static $has_one = array(
		'Jury' => Member::class,
		'Project' => Project::class
		
	);

	private static $many_many = array(
		'CompetitionCriteria' => CompetitionCriteria::class
	);

	private static $many_many_extraFields = [
		'CompetitionCriteria' => [
			'CriteriaKommentar' => 'Text',
			'CriteriaBewertung' => 'Enum("0,1,2,3,4,5", "0")',
			'CriteriaPunkte' => 'Decimal(9,2)'
		]
	];

	public function sumAllPunkte() {
		$myPoints = 0;
		foreach ($this->CompetitionCriteria() as $key => $value) {
			$myPoints = $myPoints + $value->CriteriaPunkte;
			//$myPoints .= ", ". $value->CriteriaPunkte;
		}
		return $myPoints;
		//return ($this->InnovationsPunkte + $this->MarktPunkte + $this->UmsetzungsrelevanzPunkte + $this->WirtschaftsrelevanzPunkte + $this->QualitatPunkte);
	}

	private static $summary_fields = array(
		'ID' => 'ID',
		'Project.ProjectNumber' => 'Projekt Nr',
		'Project.IdeenTitle' => 'Projekttitel',
					//'myPointsForPreview' => 'Punkte',
		//'InnovationsPunkte' => 'Innovation',
		//'MarktPunkte' => 'Markt',
		//'UmsetzungsrelevanzPunkte' => 'Umsetzung',
		//'WirtschaftsrelevanzPunkte' => 'Wirtsch./ges.pol. Rel.',
		//'QualitatPunkte' => 'Qualitat',
		'sumAllPunkte' => 'Gesamtpunkte',
		'Jury.Kuerzel' => 'Juror'
	);

	public function myPointsForPreview() {
		$myHTML = "I: ".$this->InnovationsPunkte."<br />". "M: ". $this->MarktPunkte."<br />". "U: ". $this->UmsetzungsrelevanzPunkte."<br />". "W: ". $this->WirtschaftsrelevanzPunkte."<br />" ."Q: ". $this->QualitatPunkte."<br />";

		return DBField::create_field('HTMLVarchar', $myHTML);
	}

	public function onBeforeWrite() {
		parent::onBeforeWrite();

		$this->InnovationsKommentar = strip_tags($this->InnovationsKommentar??'');
	}

	public function onAfterWrite() {
		parent::onAfterWrite();

		$myPoints = $this->countMyPoints($this->ProjectID);
		$myPoints5 = $myPoints/$this->Project()->juryMemberCount();
		
		DB::query("UPDATE Project SET JuryPoints='".$myPoints5."', AdminPoints='".$myPoints5."' WHERE ID='".$this->ProjectID."'");

		$myPlace = $this->countMyPosition($this->ProjectID);
	}


	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldsFromTab("Root.Main", [
			'InnovationsKommentar',
			'InnovationsBewertung',
			'InnovationsPunkte',

			'MarktKommentar',
			'MarktBewertung',
			'MarktPunkte',

			'UmsetzungsrelevanzKommentar',
			'UmsetzungsrelevanzBewertung',
			'UmsetzungsrelevanzPunkte',

			'WirtschaftsrelevanzKommentar',
			'WirtschaftsrelevanzBewertung',
			'WirtschaftsrelevanzPunkte',

			'QualitatKommentar',
			'QualitatBewertung',
			'QualitatPunkte',

			'ProjectID'
		]);

		return $fields;
	}



	public function countMyPoints($myID) {
		$myBewertungs = Bewertung::get()->where("ProjectID='".$myID."'  AND JuryID IN (".$this->Project()->Jury1ID.", ".$this->Project()->Jury2ID.", ".$this->Project()->Jury3ID.")");
		/*$innoPoints = $marktPoints = $UmsetzungPoints = $WirtschaftsPoints = $QualitatPoints = 0;

		foreach ($myBewertungs as $key => $value) {
			$innoPoints += $value->InnovationsPunkte;
			$marktPoints += $value->MarktPunkte;
			$UmsetzungPoints += $value->UmsetzungsrelevanzPunkte;
			$WirtschaftsPoints += $value->WirtschaftsrelevanzPunkte;
			$QualitatPoints += $value->QualitatPunkte;
		}

		$myPoints = array($innoPoints, $marktPoints, $UmsetzungPoints, $WirtschaftsPoints, $QualitatPoints);*/

		$myPoints = 0;
		//$myPoints[1] = 0;
		foreach ($myBewertungs as $key => $value) {
			foreach ($value->CompetitionCriteria() as $CriteriaKey => $CriteriaValue) {
				$myPoints += $CriteriaValue->CriteriaPunkte;

				/*if ($CriteriaValue->AdminPunkte > 0) {
					$myPoints[1] += $CriteriaValue->AdminPunkte;
				} else {
					$myPoints[1] += $CriteriaValue->CriteriaPunkte;
				}*/
			}
			
		}

		return $myPoints;
	}

	public function countMyPosition($myID) {
		/*$myProject = Project::get()->where("Project.ID='".$myID."'")->first();
		//$projects = Project::get()->where("JuryPoints>'".$myProject->JuryPoints."' AND Kategorie='".$myProject->Kategorie."'");

		$projects = Project::get()->where("KategoriesID='".$myProject->KategoriesID."'");
		
		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $projects = $projects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }

        $projects = $projects->innerJoin("Bewertung", "Bewertung.ProjectID=Project.ID")->sort("Project.JuryPoints DESC");

		$i = 1;
		foreach ($projects as $key => $value) {
			DB::query("UPDATE Project SET JuryPlace='".$i."', AdminPlace='".$i."' WHERE ID='".$value->ID."'");
			$i++;
		}
		return $projects->count() +1;*/
	}

}