<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Upload;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Versioned\Versioned;


class JuryPageController extends PageController {

    protected $actCompetition;

    private static $allowed_actions = array (
		'projectDetailsJury',
        'projectAcept',
        'projectReject',
        'projectRate',
        'saveRatings',
        'projectRateAdmin',
        'documentLinkUpload',
        'documentsUploadForm',
        'deleteDocument',
        'deleteJuryLink',        
        'juryLinksForm',
        'juryProjectInfoForm',
        'deleteProjectInfoLink',
        'changeCompetition'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements


        if ($this->getCurrentUser()) {
            $this->actCompetition = $this->MySession()->get("CompetitionID");
            if ($this->actCompetition < 1) {
                $myCompetition = $this->getAllCompetitions()->filter(array("Active"=>"1"));
                if ($myCompetition->exists() ) {
                    $this->actCompetition = $myCompetition->First()->ID;
                    $this->MySession()->set("CompetitionID", $myCompetition->First()->ID);
                    $this->redirect($this->Link());
                }
            }
        }
	}

    public function setCompetition($CompetitionID) {
        $this->MySession()->set("CompetitionID", $CompetitionID);
    }

    public function changeCompetition() {
        $myID = $this->request->param("ID");
        $this->setCompetition($myID);

        $this->redirect($this->Link());
    }

	public function getJuryProjects() {
        $myProjects = Project::get()->where("Status='geprüft&freigegeben' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");

        
        $myProjects = $myProjects->filter(array("CompetitionID"=>$this->actCompetition));


        return $myProjects;
    }

    public function projectDetailsJury() {
        $myID = $this->request->param("ID");
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");
        if ($myProject->exists()) {
            return $this->customise($myProject->first())->renderWith(array('ProjectDetailsJury', 'Page'));
        } else {
            return $this->redirect($this->Link());
        }
        
    }

    public function projectAcept() {
        $myID = $this->request->param("ID");
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");
        if ($myProject->exists()) {
            $myProject = $myProject->first();
            $checkBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$myID."'");
            if ($checkBewertung->exists()) {
                return $this->redirectBack();
            }
            $myBewertung = new Bewertung();
            $myBewertung->JuryID = $this->getCurrentUser()->ID;
            $myBewertung->ProjectID = $myID;
            $myBewertung->Status = 1;
            $myBewertung->write();

            if ($this->request->param("OtherID") == "rate") {
                return $this->redirect($this->Link()."/projectRate/".$myProject->ID);
            }
        }

        return $this->redirect($this->Link());
    }

    public function projectReject($data) {
        /* forbiden function since 2024; if needed remove first return */
        return $this->redirect($this->Link());


        $myID = $this->request->param("ID");
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");
        if ($myProject->exists()) {
            $myProject = $myProject->first();
            $checkBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$myID."'");
            if ($checkBewertung->exists()) {
                return $this->redirectBack();
            }
            $myBewertung = new Bewertung();
            $myBewertung->JuryID = $this->getCurrentUser()->ID;
            $myBewertung->ProjectID = $myID;
            $myBewertung->Status = 4;
            $myBewertung->GesamtKommentar = $data["rejectionText"];
            $myBewertung->write();

            $config = SiteConfig::current_site_config(); 
            $email = new Email();
             
            $email->setFrom("genius@riz-up.at"); 
            $email->setSubject($config->AdminProjectRejectedTitle); 
            $messageBody = str_replace("{PROJECT_NUMBER}", (string)($myProject->myProjectNumber() ?? ''), (string)($config->AdminProjectRejected ?? ''));
            $messageBody = str_replace("{PROJECT_TITLE}", (string)($myProject->IdeenTitle ?? ''), $messageBody);
            $messageBody = str_replace("{JURY_NAME}", (string)($this->getCurrentUser()->Name ?? ''), $messageBody);
            $messageBody .= "<br><br>Begründung: ".(string)($data["rejectionText"] ?? '');
            $email->setBody($messageBody);

            //$email->setTo("kalakotra@gmail.com");
            //$email->send();
            $getMembers = Member::get()->exclude(["Email"=>"admin", "Email"=>"admin1"])->innerJoin("Group_Members", "MemberID=Member.ID AND GroupID='2'");
            if ($getMembers->count() > 0) {
                foreach ($getMembers as $key => $value) {
                    //$email->setTo($value->Email);
                    //$email->send();
                    if (in_array($value->Email, array("admin", "admin1"))) {

                    } else {
                        if(filter_var($value->Email, FILTER_VALIDATE_EMAIL)) {
                            $email->setTo($value->Email);
                            $email->send();
                        }
                    }
                }
            }
        }

        return $this->redirect($this->Link());

    }
    
    
    public function projectRate() {
        $myID = $this->request->param("ID");
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");
        if ($myProject->exists()) {
            $checkBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$myID."'");
            if ($checkBewertung->exists()) {
                $checkBewertung = $checkBewertung->first();
                if ($checkBewertung->Status == "3") {
                    return $this->customise($myProject->first())->renderWith(array('ProjectRateJury_readonly', 'Page'));
                }
            }

            return $this->customise($myProject->first())->renderWith(array('ProjectRateJury', 'Page'));
        }

        return $this->redirect($this->Link());
    }

    public function projectRateAdmin() {
        $myID = $this->request->param("ID");
        $myUserID = $this->request->param("OtherID");
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$myUserID."' OR Jury2ID='".$myUserID."' OR Jury3ID='".$myUserID."')");
        if ($myProject->exists()) {
            $checkBewertung = Bewertung::get()->where("JuryID='".$myUserID."' AND ProjectID='".$myID."'");
            if ($checkBewertung->exists()) {
                $checkBewertung = $checkBewertung->first();
                if ($checkBewertung->Status == "3") {
                    return $this->customise($myProject->first())->renderWith(array('ProjectRateJury_readonly', 'Page'));
                }
            }

            return $this->customise($myProject->first())->renderWith(array('ProjectRateJury', 'Page'));
        }

        return $this->redirect($this->Link());
    }

    public function saveRatings($data) {
        $myID = $data["projectID"];
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$this->getCurrentUser()->ID."' OR Jury2ID='".$this->getCurrentUser()->ID."' OR Jury3ID='".$this->getCurrentUser()->ID."')");
        
        if ($myProject->exists()) {
            $myProject = $myProject->first();
            
            $checkBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$myID."'");
            if ($checkBewertung->exists()) {
                $checkBewertung = $checkBewertung->first();
                
                $myActiveComp = $this->getActiveCompetition();

                foreach ($this->getActiveCompetition()->CompetitionCriteria() as $keyCriteria => $valueCriteria) {
                    $checkBewertung->CompetitionCriteria()->add($valueCriteria, [
                        'CriteriaKommentar' => $data["CriteriaKommentar"][$valueCriteria->ID],
                        'CriteriaBewertung' => $data["CriteriaPoints"][$valueCriteria->ID],
                        'CriteriaPunkte' => $data["CriteriaPointValue"][$valueCriteria->ID]
                    ]);
                }

                $checkBewertung->ProjektbezugKommentar = str_replace("<br />", "", $data["ProjektbezugKommentar"]);
                $checkBewertung->GesamtKommentar = str_replace("<br />", "", $data["GesamtKommentar"]);
                if ($data["rateFormUpdate"] == "0") {
                    $checkBewertung->Status = 2;
                } else {
                    $checkBewertung->Status = 3;
                }
                $checkBewertung->write();
            }
        }
        

        if ($data["rateFormUpdate"] == "0") {
            return $this->redirectBack();
        } else {
            return $this->redirect($this->Link());
        }
    }


    // add documents and link to project
    public function documentLinkUpload() {
        $myID = $this->request->param("ID");
        $myUserID = $this->getCurrentUser()->ID;
        $myProject = Project::get()->where("Status='geprüft&freigegeben' AND Project.ID='".$myID."' AND (Jury1ID='".$myUserID."' OR Jury2ID='".$myUserID."' OR Jury3ID='".$myUserID."')");
        if ($myProject->exists()) {

            return $this->customise($myProject->First())->renderWith(array('ProjectDocumentsJury', 'Page'));
        } else {
            $this->redirectBack();
        }
    }


    public function documentsUploadForm() {
        $myFields = new FieldList(
            //$myUploadField = new FileAttachmentField("Document", "Document"),
            FileField::create("DocumentUpload", "Document"),
            TextareaField::create("Description", "Beschreibung (Optional)"),
            HiddenField::create("MemberID", "", $this->getCurrentUser()->ID),
            HiddenField::create("ProjectID", "", $this->request->param("ID"))
        );

        //$myUploadField->setAllowedExtensions(array('pdf'));
        $sizeMB = 6; // 2 MB
        $size = $sizeMB * 1024 * 1024; // 2 MB in bytes
        //$myUploadField->getValidator()->setAllowedMaxFileSize($size);
        //$myUploadField->setFolderName("projects/jurydocuments/".Member::currentUserID()."/");
        //$myUploadField->setCanAttachExisting(true);
        //$myUploadField->setCanPreviewFolder(false);
        //$myUploadField->setAutoUpload(true);
        //$myUploadField->setAllowedMaxFileNumber(1);


        $myReqFields = new RequiredFieldsValidator(array("Document"));
        
        
        $actions = new FieldList( 
            FormAction::create('saveDocument', 'Speichern & Weitere Datei hochladen')->addExtraClass("btn btn-warning")
        ); 
        return new Form($this, 'documentsUploadForm', $myFields, $actions, $myReqFields);
    }

    public function saveDocument($data, $form) {
        $myObject = new Document();
        $form->saveInto($myObject);
        $myObject->write();
        
        if (isset($data["DocumentUpload"])) {
            $document = $data['DocumentUpload'];
            if ($document['tmp_name'] != ""){
                $currentUser = Security::getCurrentUser();
                $myFolder = Folder::find_or_make("projects/jurydocuments/".$currentUser->ID."/");
                
                
                /*$content = file_get_contents($document['tmp_name']);
                $file = File::create();
                
                $file->setFromString($content, $document['name']);
                

                $file->ParentID = $myFolder->ID;
                $file->write();*/

                $tmpFile = array(
                        'name' => $document['name'],
                        'type' => $document['type'],
                        'tmp_name' => $document['tmp_name'],
                        'error' => $document['error'],
                        'size' => $document['size']
                    );
                $file = self::doUpload($tmpFile, $myFolder);

                //$myObject->Document()->add($file);
                $myObject->DocumentID = $file->ID;
                $myObject->write();
            }
                    
        }
        $this->redirectBack();
    }

    private static function doUpload($tmpFile, $folder) {
        $upload = Upload::create();
        $fileClass = File::get_class_for_file_extension(File::get_file_extension($tmpFile['name']));
        $file = Injector::inst()->create($fileClass);
        $uploadResult = $upload->loadIntoFile($tmpFile, $file, $folder->getFilename());

        if (!$uploadResult) {
            return false;
        } else {
            $file->ParentID = $folder->ID;
            $FileID = $file->writeWithoutVersion();
            $file->publishSingle();
            $record = Versioned::get_by_stage($fileClass, Versioned::LIVE)->byID($FileID);
            $record->writeWithoutVersion();
            $record->publishSingle();

            return $file;
        }
    }

    public function deleteDocument() {
        $myID = $this->request->param("ID");
        $myDocument = Document::get()->byId($myID);
        $currentUser = Security::getCurrentUser();
        if ($myDocument->MemberID == $currentUser->ID) {
            $myDocument->delete();
        }

        $this->redirectBack();
    }


    public function juryLinksForm() {
        $myFields = new FieldList(
            TextField::create("URL", "Link", "http://"),
            TextField::create("Title", "Bezeichnung"),
            TextareaField::create("Description", "Beschreibung (Optional)"),
            HiddenField::create("MemberID", "", $this->getCurrentUser()->ID),
            HiddenField::create("ProjectID", "", $this->request->param("ID"))
        );


        $myReqFields = new RequiredFieldsValidator(array("URL", "Title"));
        
        
        $actions = new FieldList( 
            FormAction::create('saveJuryLink', 'Speichern & Weitere Link erfassen')->addExtraClass("btn btn-warning")
        ); 
        return new Form($this, 'juryLinksForm', $myFields, $actions, $myReqFields);
    }

    public function saveJuryLink($data, $form) {
        $myObject = new JuryLink();
        $form->saveInto($myObject);
        $myObject->write();
        $this->redirectBack();
    }

    public function deleteJuryLink() {
        $myID = $this->request->param("ID");
        $myDocument = JuryLink::get()->byId($myID);
        $currentUser = Security::getCurrentUser();
        if ($myDocument->MemberID == $currentUser->ID) {
            $myDocument->delete();
        }

        $this->redirectBack();
    }




    public function juryProjectInfoForm() {
        $myJuryProjectInfo = JuryProjectInfo::get()->filter(array("MemberID"=>$this->getCurrentUser()->ID, "ProjectID"=>$this->request->param("ID")));
        if ($myJuryProjectInfo->count() == 0) {
            $myJuryProjectInfo = new JuryProjectInfo();
            $myJuryProjectInfo->MemberID = $this->getCurrentUser()->ID;
            $myJuryProjectInfo->ProjectID = $this->request->param("ID");
            $myJuryProjectInfo->write();
        } else {
            $myJuryProjectInfo = $myJuryProjectInfo->first();
        }

        $myFields = new FieldList(
            TextareaField::create("Text", "", $myJuryProjectInfo->Text),
            

            HiddenField::create("ID", "", $myJuryProjectInfo->ID)
        );


        $myReqFields = new RequiredFieldsValidator(array("Text"));
        
        
        $actions = new FieldList( 
            FormAction::create('saveProjectInfo', 'Speichern')->addExtraClass("btn btn-warning")
        ); 
        return new Form($this, 'juryProjectInfoForm', $myFields, $actions, $myReqFields);
    }

    public function saveProjectInfo($data, $form) {
        $myObject = JuryProjectInfo::get()->byId($data["ID"]);
        $form->saveInto($myObject);
        $myObject->write();
        $this->redirectBack();
    }

    public function deleteProjectInfoLink() {
        $myID = $this->request->param("ID");
        $myDocument = JuryProjectInfo::get()->byId($myID);
        $currentUser = Security::getCurrentUser();
        if ($myDocument->MemberID == $currentUser->ID) {
            $myDocument->delete();
        }

        $this->redirectBack();
    }
    

}
