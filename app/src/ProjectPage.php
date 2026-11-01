<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\CheckboxField;

class ProjectPage extends Page {

	private static $db = array(
		'ProjectUploadFormTitle' => 'Varchar(255)',
		'ProjectPreviewText' => 'HTMLText',
		'ProjectFinishedText' => 'HTMLText',

		'Step1Text' => 'HTMLText',
		'Step2Text' => 'HTMLText',
		'Step3Text' => 'HTMLText',
		'Step4Text' => 'HTMLText',

		'Inactive' => 'Boolean',
		'InactiveText' => 'HTMLText'
	);

	private static $has_one = array(
	);

	function getCMSFields() { 
		$fields = parent::getCMSFields();
		$fields->removeByName('Content');
		$fields->addFieldToTab('Root.Main', CheckboxField::create(
			'Inactive',
			'Inactive'
		));
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create(
			'InactiveText',
			'Inactive Text'
		));
		//$fields->addFieldToTab("Root.Main", new TextField("ProjectUploadFormTitle", "Title of the upload form"));
		//$fields->addFieldToTab("Root.SubmissionTexts", new HTMLEditorField("ProjectPreviewText", "Text on preview"));
		$fields->addFieldToTab("Root.SubmissionTexts", HTMLEditorField::create("ProjectFinishedText", "Text on finish")->addExtraClass("stacked"));
		$fields->addFieldToTab("Root.Form", HTMLEditorField::create("Step1Text", "Text for Step 1")->addExtraClass("stacked"));
		$fields->addFieldToTab("Root.Form", HTMLEditorField::create("Step2Text", "Text for Step 2")->addExtraClass("stacked"));
		$fields->addFieldToTab("Root.Form", HTMLEditorField::create("Step3Text", "Text for Step 3")->addExtraClass("stacked"));
		$fields->addFieldToTab("Root.Form", HTMLEditorField::create("Step4Text", "Text for Step 4")->addExtraClass("stacked"));

		return $fields; 
	}

}
