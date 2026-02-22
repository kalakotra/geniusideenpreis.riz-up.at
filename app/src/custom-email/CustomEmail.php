<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Control\Email\Email;

class CustomEmail extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(100)',
		'Text' => 'HTMLText',
		'SendTo' => 'Enum("Jury,Nominierte,Einreicher,Sponsoren,NOT Nominierte", "Jury")',
		'SendEmails' => 'Boolean',
		'TestEmail' => 'Varchar(100)',
		'SendTest' => 'Boolean'
	);

	private static $has_many = array(
	);

	public function onBeforeWrite() {
		parent::onBeforeWrite();


		if ($this->SendTest == 1) {
			$this->SendEmails = 0;
			$this->SendTest = 0;

			$email = new Email();
				 
	        $email->setFrom("no-reply@riz.at"); 
	        $email->setSubject($this->Title); 
	        //$email->setBody($this->Text);
	        $myText = $this->Text;

	        $what = array("{ANREDE}", "{DEGREE}", "{VORNAME}", "{NACHNAME}", "{GRUSSFORMEL}");
	        $with = array("Herr", "prof.", "Max", "Mustermann", "Sehr geehrter Herr");

    		$email->setBody(str_replace($what, $with, $myText));


    		$email->setTo($this->TestEmail);
    		$email->send();

		} else {
			if ($this->SendEmails == 1) {
				$this->SendEmails = 0;

				$email = new Email();
				 
		        $email->setFrom("no-reply@riz.at"); 
		        $email->setSubject($this->Title); 
		        //$email->setBody($this->Text);
		        $myText = $this->Text;

		        $what = array("{ANREDE}", "{DEGREE}", "{VORNAME}", "{NACHNAME}", "{DEGREESUFIX}", "{GRUSSFORMEL}");

		        if ($this->SendTo == "Jury") {
		        	$list = Member::get()->innerJoin("Group_Members", "Group_Members.MemberID=Member.ID AND GroupID='3'");
	            	$list = $list->filter(array("ActiveForCompetition"=>"1"));

	            	

	            	foreach ($list as $key => $value) {
	            		$grussformel = "Sehr geehrter Herr";
	            		if ($value->Anrede == "Frau") {
	            			$grussformel = "Sehr geehrte Frau";
	            		}

	            		$with = array($value->Anrede, $value->AkademischerGrad, $value->FirstName, $value->Surname, "", $grussformel);

	            		$email->setBody(str_replace($what, $with, $myText));


	            		$email->setTo($value->Email);
	            		//$email->setTo("kalakotra@gmail.com");
	            		$email->setBCC("office@seeyou.at");
			    		$email->send();
	            	}
		        } elseif ($this->SendTo == "Nominierte") {
		        	# Nominies

		        	$list = Project::get()->filter(array("Nominierte"=>"Ja", "Status"=>"geprüft&freigegeben"));

		            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
		            if ($myCompetition->count() > 0) {
		                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
		            }

		            foreach ($list as $key => $value) {
		            	$grussformel = "Sehr geehrter Herr";
	            		if ($value->Anrede == "Frau") {
	            			$grussformel = "Sehr geehrte Frau";
	            		}

		            	$with = array($value->Anrede, $value->AkademischerGrad, $value->Vorname, $value->Nachname, $value->AkademischerGradSufix, $grussformel);

	            		$email->setBody(str_replace($what, $with, $myText));

	            		$email->setTo($value->Email);
	            		//$email->setTo("kalakotra@gmail.com");
	            		$email->setBCC("office@seeyou.at");
			    		$email->send();
	            	}

		        } elseif ($this->SendTo == "Einreicher") {
		        	# All project owners

		        	$list = Project::get();

		            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
		            if ($myCompetition->count() > 0) {
		                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
		            }

		            foreach ($list as $key => $value) {

		            	$grussformel = "Sehr geehrter Herr";
	            		if ($value->Anrede == "Frau") {
	            			$grussformel = "Sehr geehrte Frau";
	            		}

		            	$with = array($value->Anrede, $value->AkademischerGrad, $value->Vorname, $value->Nachname, $value->AkademischerGradSufix, $grussformel);

	            		$email->setBody(str_replace($what, $with, $myText));

	            		$email->setTo($value->Email);
			    		$email->send();
	            	}

		        } elseif ($this->SendTo == "Sponsoren") {
		        	# Sponsor
		        	$list = Sponsor::get();
	            	foreach ($list as $key => $value) {

	            		$grussformel = "Sehr geehrter Herr";
	            		if ($value->Anrede == "Frau") {
	            			$grussformel = "Sehr geehrte Frau";
	            		}

	            		$with = array($value->Anrede, $value->AkademischerGrad, $value->Vorname, $value->Nachname, "", $grussformel);

	            		$email->setBody(str_replace($what, $with, $myText));

	            		$email->setTo($value->Email);
			    		$email->send();
	            	}
		        } elseif ($this->SendTo == "NOT Nominierte") {
		        	# NOT Nominies

		        	$list = Project::get()->filter(array("Nominierte"=>"Nein", "Status"=>"geprüft&freigegeben"));

		            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
		            if ($myCompetition->count() > 0) {
		                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
		            }

		            foreach ($list as $key => $value) {

		            	$grussformel = "Sehr geehrter Herr";
	            		if ($value->Anrede == "Frau") {
	            			$grussformel = "Sehr geehrte Frau";
	            		}

		            	$with = array($value->Anrede, $value->AkademischerGrad, $value->Vorname, $value->Nachname, $value->AkademischerGradSufix, $grussformel);

	            		$email->setBody(str_replace($what, $with, $myText));
	            		
	            		$email->setTo($value->Email);
			    		$email->send();
	            	}
		        }
		        
			    
			}
		}
		
	}

	private static $summary_fields = array(
		'Title' => 'Title',
		'SendTo' => 'SendTo'
	);

	public function isOwner() {
		if ($this->MemberID == Member::currentUserID()) {
			return true;


		}

		return false;
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{GRUSSFORMEL} - 'Sehr geehrte Frau' bzw. 'Sehr geehrter Herr'<br ></div>"));
		$fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{ANREDE} - substitute for salutation (Frau/Herr)<br ></div>"));
		$fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{DEGREE} - substitute for title (prof., dr,...)<br ></div>"));
		$fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{DEGREESUFIX} - substitute for title after name (prof., dr,...)<br ></div>"));
        $fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{VORNAME} - substitute for firstname<br ></div>"));
        $fields->addFieldToTab("Root.Placeholders", LiteralField::create("placeholders", "<div>{NACHNAME} - substitute for lastname</div>"));

        $fields->addFieldToTab("Root.Test", TextField::create("TestEmail"));
        $fields->addFieldToTab("Root.Test", CheckboxField::create("SendTest"));

		return $fields;
	}

	
}