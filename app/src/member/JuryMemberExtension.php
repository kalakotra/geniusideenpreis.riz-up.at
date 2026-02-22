<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;

class JuryMemberExtension extends DataExtension {

    private static $db = array(
        'Anrede' => 'Enum("Frau,Herr", "Frau")',
        'AkademischerGrad' => 'Varchar(100)',
        'Kuerzel' => 'Varchar(3)',
        'Firma' => 'Varchar(100)',
        'Strasse' => 'Varchar(200)',
        'PLZ' => 'Varchar(10)',
        'Ort' => 'Varchar(100)',
        'Telefon' => 'Varchar(100)',
        'Anmerkungen' => 'Text',
        /*'p2' => 'Varchar(100)',*/
        'EmailSended' => 'Boolean',
        'ActiveForCompetition' => 'Boolean',

        'NoAdminEmails' => 'Boolean'
    );

    private static $has_one = array(
    );
  
    public function updateCMSFields(FieldList $fields) {
        
        
        $fields->removeFieldFromTab("Root", "EmailSended");

        $fields->removeFieldFromTab("Root", "Permissions");
        $fields->removeFieldFromTab("Root.Main", "LastVisited");
        $fields->removeFieldFromTab("Root.Main", "Locale");
        $fields->removeFieldFromTab("Root.Main", "FailedLoginCount");
        //$fields->removeFieldFromTab("Root.Main", "DirectGroups");
        $fields->removeFieldFromTab("Root.Main", "DateFormat");
        $fields->removeFieldFromTab("Root.Main", "TimeFormat");
        //$fields->removeFieldFromTab("Root.Main", "Locale");
        
        //$anredDropdown = new DropdownField('Anrede', 'Anrede', singleton('Member')->dbObject('Anrede')->enumValues());
        //$fields->addFieldToTab("Root.Main", $anredDropdown, "FirstName");
        $fields->addFieldToTab("Root.Main", new TextField("AkademischerGrad"), "FirstName");

        $fields->addFieldToTab("Root.Main", new TextField("Kuerzel", "Kürzel (max. 3 Zeichen)"), "Email");
        $fields->addFieldToTab("Root.Main", new TextField("Firma"), "Email");
        $fields->addFieldToTab("Root.Main", new TextField("Strasse"), "Email");
        $fields->addFieldToTab("Root.Main", new TextField("PLZ", "Postleitzahl"), "Email");
        $fields->addFieldToTab("Root.Main", new TextField("Ort"), "Email");
        $fields->addFieldToTab("Root.Main", new TextField("Telefon"), "Email");
        $fields->addFieldToTab("Root.Main", new TextareaField("Anmerkungen"), "Email");

        if ($this->owner->ID > 0) {
            //$readonly = new CheckboxSetField("Projekti", "", $this->getCompetitionProjects()->map(), $this->getCompetitionProjects()->map("ID", "ID"));
            //$readonly->performDisabledTransformation( );
            $myHtml = "";
            $i = 1;
            foreach ($this->getCompetitionProjects() as $key => $value) {
                $myHtml .= $i.". ".$value->IdeenTitle."<br />";
                $i++;
            }
            $fields->addFieldToTab("Root.ZugeteilteProjekte", LiteralField::create("projectList", $myHtml));
            //$fields->addFieldToTab("Root.ZugeteilteProjekte", $readonly);        
        }
      
    }

    function onBeforeWrite() {
        parent::onBeforeWrite();

        

        //if ($this->owner->ID > 0) {

        //} else {
            /*$config = SiteConfig::current_site_config(); 

            $email = new Email();
             
            $email->setFrom("no-reply@riz.at"); 
            $email->setSubject("RIZ Bewertungsportal - account info"); 
            $messageBody = str_replace("{JURY_EMAIL}", $this->owner->Email, $config->JuryNewMember);
            //print_r($this);
            $messageBody = str_replace("{JURY_PASS}", $this->owner->Password["_Password"], $messageBody);
            $messageBody .= "<--->".$this->owner->Password;
            $email->setBody($messageBody);

            //$email->setTo($this->Email);
            $email->setTo("kalakotra@gmail.com");
            $email->send();*/
        //}

    }

    function onAfterWrite() {
        parent::onAfterWrite();
        if (strpos($_SERVER['REQUEST_URI'],'jury') !== false) {
            $this->owner->addToGroupByCode("Jury");
        }
    }

    private static $summary_fields = array(
        'Anrede' => 'Anrede',
        'AkademischerGrad' => 'Title',
        'FirstName' => 'Vorname',
        'Surname' => 'Nachname',
        'Kuerzel' => 'Kürzel',
        'Firma' => 'Firma',
        'Email' => 'e-Mail/BN'/*,
        'myProjectCount' => 'Projekte',
        'myProjectPercent' => 'bewertet in %'*/
    );

    public function myProjectCount() {
        return $this->getCompetitionProjects()->count();
    }

    public function myProjectPercent() {
        $myVotes = $this->getCompetitionBewertung();
        
        $myPercent = "--";
        if ($this->myProjectCount() > 0) {
            $myPercent = $myVotes->count()*100 / $this->myProjectCount();
            $myPercent = number_format($myPercent);
        }
        
        return  $myPercent; //"100%";
    }

    public function getCompetitionProjects() {
        $myProjects = Project::get()->where("Jury1ID='".$this->owner->ID."' OR Jury2ID='".$this->owner->ID."' OR Jury3ID='".$this->owner->ID."'");

        $myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $myProjects = $myProjects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }

        return $myProjects;
    }


    public function getBewertungByProject($projectID) {
        return $myVotes = Bewertung::get()->where("ProjectID IN (".$projectID.")")->filter(array("JuryID"=>$this->owner->ID, "Status"=>"3"));
        
    }

    public function getCompetitionBewertung () {
        $myProjects = "0";
        foreach ($this->getCompetitionProjects() as $key => $value) {
            $myProjects .= ",". $value->ID;
        }
        return $myVotes = Bewertung::get()->where("ProjectID IN (".$myProjects.")")->filter(array("JuryID"=>$this->owner->ID, "Status"=>"3"));
    }

    public function generatedKurzel() {
        if ($this->owner->Kuerzel != "") {
            $myShort = $this->owner->Kuerzel; 
        } else {
            $firstNameLetter = "";
            if ($this->owner->FirstName != "") {
                $firstNameLetter = $this->owner->FirstName[0];
            }

            $SurnameLetter = "";
            if ($this->owner->Surname != "") {
                $SurnameLetter = $this->owner->Surname[0];
            }
            $myShort = $firstNameLetter.$SurnameLetter."-".$this->owner->ID;    
        }
        

        return $myShort;
    }
     
}
?>