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
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class Competition extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(100)',
		'Active' => 'Boolean',
		'ShortCode' => 'Varchar(5)',
		'HideFromMenu' => 'Boolean',
		'SendEmailAfterSubmission' => 'Boolean',
		'EmailSubject' => 'Varchar(200)',
		'EmailText' => 'HTMLText',
		'MaxPoints' => 'Int'
	);

	private static $has_many = array(
		/*'Project' => 'Project'*/
		//'CompetitionCriteria' => CompetitionCriteria::class
	);

	private static $many_many = [
		'CompetitionCriteria' => CompetitionCriteria::class,
		'Kategorie' => Kategorie::class
	];

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		if ($this->Active == "1") {
			DB::query("UPDATE Competition SET Active='0' ");

			if ( $this->ID > 0) {
				DB::query("UPDATE Competition SET Active='1' WHERE ID='".$this->ID."'");
			}
		}
	}

	private static $summary_fields = array(
		'Title' => 'Title',
		'myStatus' => 'Active'
	);

	private static $cascade_duplicates = array(
		'CompetitionCriteria',
		'Kategorie'
	);

	public function isOwner() {
		if ($this->MemberID == Member::currentUserID()) {
			return true;
		}

		return false;
	}

	public function myStatus() {
		if ($this->Active) {
			return "Active";
		}

		return "";
	}

	public function menuActiveCompetition() {
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		if ($session->get("CompetitionID") == $this->ID ) {
			return true;
		}

		return false;
	}


	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab("Root.Main", "SendEmailAfterSubmission");
		//$fields->addFieldToTab("Root.Email", CheckboxField::create("SendEmailAfterSubmission"));
		$fields->addFieldToTab("Root.Email", TextField::create("EmailSubject"));
		$fields->addFieldToTab("Root.Email", HTMLEditorField::create("EmailText"));

		$fields->addFieldToTab("Root.Kategorie", CheckboxSetField::create("Kategorie", "Kategorie", Kategorie::get()->map()));

		/*$gridConfig = GridFieldConfig_RecordEditor::create();
		$gridConfig->addComponent(GridFieldOrderableRows::create("Sort"));
		$gridField = GridField::create("CompetitionCriteria", "CompetitionCriteria", $this->CompetitionCriteria(), $gridConfig);*/

		$myCriteria = CompetitionCriteria::get()->where('InternalTitle IS NOT NULL');
		$fields->addFieldsToTab("Root.CompetitionCriteria", [
			TextField::create("MaxPoints"),
			//$gridField
			CheckboxSetField::create("CompetitionCriteria", "CompetitionCriteria", $myCriteria->map('ID', 'InternalTitle'))
		]);

		return $fields;
	}
}