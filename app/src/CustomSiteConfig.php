<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;

class CustomSiteConfig extends DataExtension {
     
    private static $db = array(
        'AdminNewProjectTitle' => 'Varchar(250)',
        'AdminNewProject' => 'HTMLText',
        'JuryNewMemberTitle' => 'Varchar(250)',
        'JuryNewProjectTitle' => 'Varchar(250)',
        'JuryProjectStatusTitle' => 'Varchar(250)',
        'JuryNewMember' => 'HTMLText',
        'JuryNewProject' => 'HTMLText',
        'JuryProjectStatus' => 'HTMLText',
 		'AdminProjectRejectedTitle' => 'Varchar(250)',
        'AdminProjectRejected' => 'HTMLText',
        'MemberNewProjectTitle' => 'Varchar(200)',
        'MemberNewProject' => 'HTMLText',
        'JugendNewProjectTitle' => 'Varchar(200)',
        'JugendNewProject' => 'HTMLText',
        'FooterText' => 'HTMLText'
    );
  
    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldToTab("Root.Main", HTMLEditorField::create('FooterText'));
        
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{PROJECT_NUMBER} - substitute project number in emails<br ></div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{PROJECT_TITLE} - substitute project title in emails<br ></div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{PROJECT_STATUS} - substitute project status in emails<br ></div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{PROJECT_DETAILS} - substitute project details in emails<br >(Herr/Frau, Vorname, Nachname Einreicher,...) FOR ADMIN MAILS ONLY!!!</div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{JURY_NAME} - substitute jury fullname in emails<br ></div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{JURY_EMAIL} - substitute jury email in emails (only for adding new jury)<br ></div>"));
        $fields->addFieldToTab("Root.EmailTextsPlaceholder", LiteralField::create("placeholders", "<div>{JURY_PASS} - substitute jury password in emails (only for adding new jury)</div>"));

        $fields->addFieldToTab("Root.EmailTextsAdmin", TextField::create('AdminNewProjectTitle', 'Admin email - new project uploaded - Subject'));
        $fields->addFieldToTab("Root.EmailTextsAdmin", HTMLEditorField::create('AdminNewProject', 'Admin email - new project uploaded'));

        $fields->addFieldToTab("Root.EmailTextsAdmin", TextField::create('AdminProjectRejectedTitle', 'Admin email - project rejected by jury - Subject'));
        $fields->addFieldToTab("Root.EmailTextsAdmin", HTMLEditorField::create('AdminProjectRejected', 'Admin email - project rejected by jury'));

        $fields->addFieldToTab("Root.EmailTextsJury", TextField::create('JuryNewProjectTitle', 'Jury email - new project asigned - Subject'));
        $fields->addFieldToTab("Root.EmailTextsJury", HTMLEditorField::create('JuryNewProject', 'Jury email - new project asigned'));

        $fields->addFieldToTab("Root.EmailTextsJury", TextField::create('JuryProjectStatusTitle', 'Jury email - project changed status - Subject'));
        $fields->addFieldToTab("Root.EmailTextsJury", HTMLEditorField::create('JuryProjectStatus', 'Jury email - project changed status'));

        $fields->addFieldToTab("Root.EmailTextsJury", TextField::create('JuryNewMemberTitle', 'Jury email - new jury added (account info) - Subject'));
        $fields->addFieldToTab("Root.EmailTextsJury", HTMLEditorField::create('JuryNewMember', 'Jury email - new jury added (account info)'));

        $fields->addFieldToTab("Root.EmailTextsEinreicher", TextField::create('MemberNewProjectTitle', 'Member email title - new project added'));
        $fields->addFieldToTab("Root.EmailTextsEinreicher", HTMLEditorField::create('MemberNewProject', 'Member email - new project added'));
      
    }
     
}
?>