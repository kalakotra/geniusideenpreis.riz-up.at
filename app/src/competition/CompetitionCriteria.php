<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DB;
use SilverStripe\Control\Session;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Security;

class CompetitionCriteria extends DataObject {

	private static $default_sort = "ID DESC";
	private static $db = array(
		'Title' => 'Varchar(100)',
		'InternalTitle' => 'Varchar(100)',
		'PointWeight' => 'Int',
		'Description' => 'HTMLText',
		'Point1Title' => 'Varchar',
		'Point1Text' => 'Text',
		'Point2Title' => 'Varchar',
		'Point2Text' => 'Text',
		'Point3Title' => 'Varchar',
		'Point3Text' => 'Text',
		'Point4Title' => 'Varchar',
		'Point4Text' => 'Text',
		'Sort' => 'Int'
	);

	private static $has_one = [
		//'Competition' => Competition::class
	];

	private static $has_many = [];

	private static $many_many = [
	];

	private static $belongs_many_many = [
		'Bewertung' => Bewertung::class,
		'Competition' => Competition::class
	];

	public function onBeforeWrite() {
		parent::onBeforeWrite();
	}

	private static $summary_fields = array(
		'Title',
		'InternalTitle',
		'PointWeight'
	);


	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab("Root.Main", "Sort");

		return $fields;
	}


	public function getMemberBewertung() {
		return $this->Bewertung()->filter([
			"JuryID" => Security::getCurrentUser()->ID, ///Member::currentUserID(),
			"ProjectID" => Controller::curr()->request->param("ID")
		])->First();
	}
}