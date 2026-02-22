<?php

namespace {

use app\RegistrationForm\RegistrationForm;
use app\RegistrationForm\RegistrationFormFiles;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Upload;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\Session;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\MultiForm\Models\MultiFormSession;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\Versioned\Versioned;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;
use UncleCheese\Dropzone\FileAttachmentField;


    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [
            'myProjectForm',
            'myProjectUploadForm',
            'dosaveProject',
            'projectDetails',
            'projectAdded',
            'projectDetailsAdmin',
            'checkLoginForFile',
            'deleteDocument',
            'fileStatus',
            'projectNumbernig',
            'changeCompetition',

            // new registration form logic (multi step form)
            'RegistrationForm',
            'deleteRegistrationDocument',   
            'registrationfinished'
        ];

        public function ThemeDir() {
            $myThemes = SSViewer::get_themes();
            $myThemePath = "/_resources/themes/".$myThemes[1]."/";
            return $myThemePath;
        }

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/

            if ($this->URLSegment != "Security") {
                $myThemes = SSViewer::get_themes();
                $myThemePath = "themes/".$myThemes[1]."/";

                //Requirements::css($myThemePath.'css/scss/bootstrap.scss');

                //Requirements::css($myThemePath.'css/editor.scss');

                Requirements::backend()->setWriteHeaderComment(false);
                $css = [];

                $css[] = $myThemePath.'css/bootstrap.css';
                $css[] = $myThemePath.'css/all.min.css';
                $css[] = $myThemePath.'css/datatables.min.css';
                $css[] = $myThemePath.'css/fonts.css';
                $css[] = $myThemePath.'css/jquery-ui.css';
                $css[] = $myThemePath.'css/layout.css';

                Requirements::combine_files('styles.css', $css);
                Requirements::process_combined_files();

                /*$js = [];
                $js[] = $myThemePath.'javascript/empty2.js';
                Requirements::combine_files('emp.js', $js);
                Requirements::process_combined_files();*/

                // Load jQuery (without defer, needed immediately)
                $js = [];
                $js[] = $myThemePath.'javascript/jquery-3.6.0.min.js';
                Requirements::combine_files('jquery.js', $js);
                Requirements::process_combined_files();

                // Load entwine for display-logic if needed (on ProjectPage)
                if ($this instanceof ProjectPageController) {
                    Requirements::javascript('silverstripe/admin: thirdparty/jquery-entwine/jquery.entwine.js');
                }

                // Other JS libraries - can be deferred
                $js = [];
                $js[] = $myThemePath.'javascript/jquery-ui.min.js';
                $js[] = $myThemePath.'javascript/popper.min.js';
                $js[] = $myThemePath.'javascript/bootstrap.min.js';
                $js[] = $myThemePath.'javascript/datatables.min.js';
                $js[] = $myThemePath.'javascript/script.js';
                
                // Don't defer on ProjectPage so display-logic can initialize properly
                if ($this instanceof ProjectPageController) {
                    Requirements::combine_files('javascripts.js', $js);
                } else {
                    Requirements::combine_files('javascripts.js', $js, ["defer" => true]);
                }
                Requirements::process_combined_files();
            }
        }

        public function getCurrentUser() {
            //return Member::currentUser();
            return Security::getCurrentUser();
        }

        public function MySession() {
            return $this->getRequest()->getSession();
        }

        public function changeCompetition() {
            $myID = $this->request->param("ID");
            $myCompetition = Competition::get()->byId($myID);
            if ($myCompetition) {
                $this->MySession()->set("CompetitionID", $myID);
            }

            return $this->redirectBack();
        }

        public function projectNumbernig() {
            /*$myProjects = Project::get()->sort("ID");
            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $myProjects = $myProjects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
                $competitionExtension = " ".$myCompetition->first()->ShortCode;

                $i = 1;
                foreach ($myProjects as $key => $value) {
                    if ($value->Completed == 1) {
                        $value->CompetitionOrder = $i;
                        //
                        $myHtml = sprintf("%'.03d", $i);
                        $myHtml .= $competitionExtension;
                        $value->ProjectNumber = $myHtml;
                        $value->write();
                        $i++;
                    } else {
                        $value->ProjectNumber = "";
                        $value->write();
                    }

                    //$value->ProjectNumber = "";
                    //$value->write();

                    //$value->ProjectNumber = "";
                    echo $value->ID. " <--> " . $value->Completed. " <--> " . $value->OldProjectNumber . " <--> " . $value->ProjectNumber."<br />";
                    
                }
            }*/
        }


        public function projectDetailsAdmin() {

            if ($this->getCurrentUser()->ID > 0) {
                $myID = $this->request->param("ID");
                $myProject = Project::get()->where("Project.ID='".$myID."'");
                
                return $this->customise($myProject)->renderWith(array('ProjectDetailsAdmin', 'Page'));
            }
            
        }

        public function projectDetails() {
            
            $myID = $this->MySession()->get("myProjectID");
            $myProject = Project::get()->where("Project.ID='".$myID."'");
            
            return $this->customise($myProject)->renderWith(array('ProjectDetails', 'Page'));
        }

        public function projectAdded() {
            if ( $actualInfoSwitch = $this->request->param("ID") ) {
                $actualInfoSwitch = 1;
            } else {
                $actualInfoSwitch = 0;
            }

            $myID = $this->MySession()->get("myProjectID");
            if ($myID > 0) {
                $myProject = Project::get()->byId($myID);
                $myProject->ActuallInfo = $actualInfoSwitch;
                $myProject->Completed = 1;
                $myProject->write();

                $config = SiteConfig::current_site_config();
                
                $email = new Email();
                $email->setFrom("genius@riz-up.at");

                $email->setSubject($config->MemberNewProjectTitle); 
                $messageBody = str_replace("{PROJECT_TITLE}", $myProject->IdeenTitle, $config->MemberNewProject);

                $messageBody = str_replace("{PROJECT_STATUS}", $myProject->Status, $messageBody);
                
                $email->setBody($messageBody);
                
                
                $email->setTo($myProject->Email);
                $email->send();

                $this->MySession()->clear("myProjectID");
                return $myData = [
                    'Content' => DBField::create_field('HTMLText',$this->ProjectFinishedText),
                    'myProjectForm' => ''
                ];
            } else {
                $this->redirect($this->Link());
            }
        }

        public function getMyStep() {
            $myStep = 0;
            if (isset($_GET["myStep"])) {
                $myStep = 1;
            }

            return $myStep;
        }

        public function myProjectUploadForm() {
            $randomString = time();//substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
            $myCompetition = $this->getActiveCompetition();
            if ($myCompetition) {
                $myFolder = "projects1/".$myCompetition->ShortCode."/"; //.$randomString."/";
            } else {
                $myFolder = "projects1/no-competition/"; //.$randomString."/";
            }

            $upload1 = new FileField('Dokumente[]', ' ');
            $upload1->setFolderName($myFolder."/doc/");
            //$upload1->setConfig('allowedMaxFileNumber', 10);
            //$upload1->setAcceptedFiles(array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'gif', 'mp3', 'mp4', 'xls', 'xlsx', 'ppt', 'pps') );
            $upload1->getValidator()->allowedExtensions = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'gif', 'mp3', 'mp4', 'xls', 'xlsx', 'ppt', 'pps', 'pptx');
            //$upload1->setMaxFilesize(5);
            //$upload1->setTrackFiles(true);
            //$upload1->setView('grid');
            $upload1->getValidator()->setAllowedMaxFileSize('5m');

            $upload2 = new FileField('Lebenslaufs[]', ' ');
            //$upload2->setConfig('allowedMaxFileNumber', 1);
            //$upload2->setAllowedMaxFileNumber(10);
            //$upload2->setFolderName($myFolder."/cv/");
            //$upload2->setAcceptedFiles( array('pdf', 'doc', 'docx', 'ppt') );
            $upload2->getValidator()->allowedExtensions = array('pdf', 'doc', 'docx', 'ppt', 'pptx');
            //$upload2->setMaxFilesize(5);
            //$upload2->setTrackFiles(true);
            //$upload2->setView('grid');

            $fields = new FieldList($upload1, $upload2, HiddenField::create("ProjectStep", "ProjectStep", 1));
            $upload1->setAttribute("multiple", "multiple");
            $upload2->setAttribute("multiple", "multiple");
            $upload2->getValidator()->setAllowedMaxFileSize('5m');

            $actions = new FieldList(
                $mySubmit = FormAction::create('dosaveProjectFiles', 'Hochladen')->addExtraClass("btn btn-warning btn-block"),
                $mySubmit2 = FormAction::create('dosaveProjectAndPreview', 'Einreichung überprüfen')->addExtraClass("btn btn-warning btn-block")
                
            );

            $required = new RequiredFields(/*array('Dokumente', 'Lebenslauf')*/);
         
            $form = new Form($this, 'myProjectUploadForm', $fields, $actions, $required);

            $myID = $this->MySession()->get("myProjectID");
            if ($myID > 0) {
                $myProject = Project::get()->where("Project.ID='".$myID."'")->First();
                $myHiddenID = HiddenField::create("ProjectID", "projectid", $myID);
                $fields->push($myHiddenID);
                
                $myHtml = '<div class="row">';
                if ($myProject->Lebenslaufs()->count() > 0) {
                    foreach ($myProject->Lebenslaufs() as $key => $value) {
                        $myHtml .= '<div class="pt-2 pb-2 col-12 col-md-6 mt-3 uploadedFileHolder">
                                        <div class="p-3 h100">
                                            <div class="row h100">
                                                <div class="col-4">
                                                    <div class="text-center "><img src="'.$this->ThemeDir().'/images/file-icons/'.$value->getExtension().'.png" /></div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="fileName smallTextInForm">
                                                        '.$value->Title.'
                                                        <br />
                                                        '.$value->getSize().'
                                                    </div>
                                                </div>
                                                <div class=" smallTextInForm col-12 text-right align-self-bottom">
                                                    Löschen <a href="'.$this->Link("deleteDocument/".$myID."/".$value->FileHash).'" class="youSure"><img src="'.$this->ThemeDir().'/images/delete.png" alt="Delete" /></a>
                                                </div>
                                            </div>
                                        </div>
                                </div>';
                    }
                }
                $myHtml .= '</div>';

                $myCvs = LiteralField::create("myCvs", $myHtml);//$this->ThemeDir()
                $fields->push($myCvs);

                $myHtml = '<div class="row">';
                if ($myProject->Dokumente()->count() > 0) {
                    foreach ($myProject->Dokumente() as $key => $value) {
                        $myHtml .= '<div class="pt-2 pb-2 col-12 col-md-6 mt-3 uploadedFileHolder">
                                        <div class="p-3 h100">
                                            <div class="row h100">
                                                <div class="col-4">
                                                    <div class="text-center "><img src="'.$this->ThemeDir().'/images/file-icons/'.$value->getExtension().'.png" /></div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="fileName smallTextInForm">
                                                        '.$value->Title.'
                                                        <br />
                                                        '.$value->getSize().'
                                                    </div>
                                                </div>
                                                <div class=" smallTextInForm col-12 text-right align-self-bottom">
                                                    Löschen <a href="'.$this->Link("deleteDocument/".$myID."/".$value->FileHash).'" class="youSure"><img src="'.$this->ThemeDir().'/images/delete.png" alt="Delete" /></a>
                                                </div>
                                            </div>
                                        </div>
                                </div>';
                    }
                }
                $myHtml .= '</div>';

                $myDoc = LiteralField::create("myDoc", $myHtml);//$this->ThemeDir()
                $fields->push($myDoc);

                $form->loadDataFrom( $myProject );

                if ($myProject->Lebenslaufs()->count() == 0 || $myProject->Dokumente()->count() == 0) {
                    $mySubmit2->setDisabled(true);
                }

                
            } else {
                $myHiddenID = HiddenField::create("ProjectID", "projectid", 0);
                $fields->push($myHiddenID);
                //$mySubmit->setTitle('Speichern und die Dateien hochladen');
                return $this->redirect($this->Link("?myStep=0"));
            }
            

            $form->setTemplate('ProjectForm');

            return $form;
        }

        public function deleteDocument() {
            $projectID = $this->request->param("ID");
            $fileHash = $this->request->param("OtherID");

            $myProject = Project::get()->byId($projectID);
            $myFile = File::get()->filter( array("FileHash" => $fileHash) )->First();

            
            if ( $myProject->Lebenslaufs()->filter( array("ID"=>$myFile->ID) ) || $myProject->Dokumente()->filter( array("ID"=>$myFile->ID) ) ) {
                
                if ( $myProject->Lebenslaufs()->filter( array("ID"=>$myFile->ID) ) ) {
                    echo "Lebenslaufs";
                    $myProject->Lebenslaufs()->remove($myFile);
                }

                if ( $myProject->Dokumente()->filter( array("ID"=>$myFile->ID) ) ) {
                    echo "Dokumente";
                    $myProject->Dokumente()->remove($myFile);
                }
                $myFile->delete();

                $myProject->write();


            }

            $this->redirectBack();
        }

        public function dosaveProjectFiles($data, $form) {
            if ($data["ProjectID"] != 0) {
                $myProjectForm = Project::get()->where("Project.ID='".$data["ProjectID"]."'")->First();

                $randomString = $data["ProjectID"]."-".substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
                $myCompetition = $this->getActiveCompetition();

                if ($myCompetition) {
                    $myFolder = "projects/".$myCompetition->ShortCode."/" .$randomString."/";
                } else {
                    $myFolder = "projects/no-competition/" .$randomString."/";
                }


                if (isset($data["Lebenslaufs"])) {
                    /*$document = $data['Lebenslaufs'];
                    if ($document['tmp_name'][0] != ""){ 
                        $myFolder = Folder::find_or_make($myFolder."/cv/");                        
                        foreach ($document['tmp_name'] as $key => $value) {
                            $content = file_get_contents($value);
                            $file = File::create();
                            
                            $file->setFromString($content, $document['name'][$key]);
                            

                            $file->ParentID = $myFolder->ID;
                            $file->write();

                            $myProjectForm->Lebenslaufs()->add($file);
                        }
                    }*/

                    $document = $data['Lebenslaufs'];
                    if ($document['tmp_name'][0] != ""){ 
                        $myFolderClass = Folder::find_or_make($myFolder."/cv/");
                        $i = 0;

                        foreach ($document['name'] as $key => $value) {
                            $tmpFile = array(
                                'name' => $document['name'][$i],
                                'type' => $document['type'][$i],
                                'tmp_name' => $document['tmp_name'][$i],
                                'error' => $document['error'][$i],
                                'size' => $document['size'][$i]
                            );
                            $uploadedFile = self::doUpload($tmpFile, $myFolderClass);
                            if ($uploadedFile) {
                                $myProjectForm->Lebenslaufs()->add($uploadedFile);
                            }
                            
                            $i++;
                        }
                    }
                }
            
                if (isset($data["Dokumente"])) {
                    /*$document = $data['Dokumente'];
                    if ($document['tmp_name'][0] != ""){ 
                        $myFolder = Folder::find_or_make($myFolder."/doc/");
                        
                        foreach ($document['tmp_name'] as $key => $value) {
                            $content = file_get_contents($value);
                            $file = File::create();
                            
                            $file->setFromString($content, $document['name'][$key]);
                            

                            $file->ParentID = $myFolder->ID;
                            $file->write();

                            $myProjectForm->Dokumente()->add($file);
                        }
                        
                    }*/

                    $document = $data['Dokumente'];
                    if ($document['tmp_name'][0] != ""){ 
                        $myFolderClass = Folder::find_or_make($myFolder."/doc/");
                        $i = 0;

                        foreach ($document['name'] as $key => $value) {
                            $tmpFile = array(
                                'name' => $document['name'][$i],
                                'type' => $document['type'][$i],
                                'tmp_name' => $document['tmp_name'][$i],
                                'error' => $document['error'][$i],
                                'size' => $document['size'][$i]
                            );
                            $uploadedFile = self::doUpload($tmpFile, $myFolderClass);
                            if ($uploadedFile) {
                                $myProjectForm->Dokumente()->add($uploadedFile);
                            }
                            
                            $i++;
                        }
                    }
                } 

                
                $myProjectForm->write();

                //myStep
                return $this->redirect($this->Link("?myStep=1"));
            }
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

        public function dosaveProjectAndPreview($data, $form) {
            return $this->redirect($this->Link("projectDetails"));
        }


        public function myProjectForm() {
            //$this->MySession()->set("myProjectID", 662);
            
            $WettbewerbAufmerksam = DropdownField::create('WettbewerbAufmerksam',
                                        '',
                                        singleton(Project::class)->dbObject('WettbewerbAufmerksam')->enumValues()
                                    );

            $myRegions = array(
                0=>'Kein NÖ-Bezirk',
                1=>'Amstetten',
                2=>'Baden',
                3=>'Bruck/Leitha',
                4=>'Gänserndorf',
                5=>'Gmünd',
                6=>'Hollabrunn',
                7=>'Horn',
                8=>'Korneuburg',
                9=>'Krems',
                27=>'Krems Land',
                10=>'Lilienfeld',
                11=>'Melk',
                12=>'Mistelbach',
                13=>'Mödling',
                14=>'Neunkirchen',
                15=>'Scheibbs',
                16=>'St. Pölten',
                17=>'St. Pölten Land',
                18=>'Tulln',
                19=>'Waidhofen/Thaya',
                20=>'Waidhofen/Ybbs',
                //'Wien Umgebung Nord',
                //'Wien Umgebung Süd',
                //'Wien Umgebung West',
                24=>'Wiener Neustadt',
                25=>'Wiener Neustadt Land',
                26=>'Zwettl'
            );

            $myCompetition = $this->getActiveCompetition();
            
            $fields = new FieldList(
                OptionsetField::create("Anrede", "", singleton('Project')->dbObject('Anrede')->enumValues()),
                TextField::create('AkademischerGrad', ""),
                
                TextField::create('Vorname', ''),
                TextField::create('Nachname', ''),
                TextField::create('AkademischerGradSufix', ""),
                TextField::create('Firma', ""),
                TextField::create('Abteilung', ""),
                TextField::create('Strasse', ''),
                TextField::create('PLZ', '')->setMaxLength(4),
                TextField::create('Ort', ''),

                DropdownField::create('Bezirk', '', $myRegions)->setEmptyString('Bitte wählen'),
                $Vorwahl = TextField::create('Vorwahl', ''),
                $Telefonnummer = NumericField::create('Telefonnummer', '')->setHTML5(true),
                $Durchwahl = TextField::create('Durchwahl', ''),
                TextField::create("Website", ""),
                EmailField::create('Email', ''),
                EmailField::create('Email2', ''),

                TextField::create('IdeenTitle', ''),
                
                //DropdownField::create('KategoriesID', '', Kategorie::get()->map()),
                DropdownField::create('KategoriesID', '', $myCompetition->Kategorie()->map()),
                TextareaField::create('KurzBeschreibung', '')->setAttribute('maxlength', 500),            

                /* team block */
                OptionsetField::create("Anrede1", "", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad1', ''),
                TextField::create('AkademischerGrad1Sufix', ''),
                TextField::create('Vorname1', ''),
                TextField::create('Nachname1', ''),

                OptionsetField::create("Anrede2", "", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad2', ''),
                TextField::create('AkademischerGrad2Sufix', ''),
                TextField::create('Vorname2', ''),
                TextField::create('Nachname2', ''),

                OptionsetField::create("Anrede3", "", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad3', ''),
                TextField::create('AkademischerGrad3Sufix', ''),
                TextField::create('Vorname3', ''),
                TextField::create('Nachname3', ''),

                OptionsetField::create("Anrede4", "", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad4', ''),
                TextField::create('AkademischerGrad4Sufix', ''),
                TextField::create('Vorname4', ''),
                TextField::create('Nachname4', ''),

                OptionsetField::create("Anrede5", "", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad5', ''),
                TextField::create('AkademischerGrad5Sufix', ''),
                TextField::create('Vorname5', ''),
                TextField::create('Nachname5', ''),

                TextareaField::create('OtherTeamMembers', ''),

                $WettbewerbAufmerksam,
                
                HiddenField::create("ProjectStep", "ProjectStep", 0)

            );

            $Vorwahl->setAttribute('placeholder', 'Vorwahl');
            //$Telefonnummer->setAttribute('placeholder', 'Telefonnummer');
            $Durchwahl->setAttribute('placeholder', 'Durchwahl');
            
            $actions = new FieldList(
                $mySubmit = FormAction::create('dosaveProject', 'Speichern und die Dateien hochladen')->addExtraClass("btn btn-warning btn-block")
                
            );

            $required = new RequiredFields(array('Anrede', 'Vorname', 'Nachname', 'Strasse','PLZ', 'Ort', 'Bezirk', 'Telefonnummer', 'Email', 'Email2', 'IdeenTitle', 'Kategorie', 'KurzBeschreibung'/*, 'Dokumente', 'Lebenslauf'*/));
         
            $form = new Form($this, 'myProjectForm', $fields, $actions, $required);

            $myID = $this->MySession()->get("myProjectID");
            if ($myID > 0) {
                $myProject = Project::get()->where("Project.ID='".$myID."'")->First();
                $myHiddenID = HiddenField::create("ProjectID", "projectid", $myID);
                $fields->push($myHiddenID);
                //$fields->push($upload1);
                //$fields->push($upload2);
                $myProject->Email2 = $myProject->Email;
                $form->loadDataFrom( $myProject );

                
            } else {
                $myHiddenID = HiddenField::create("ProjectID", "projectid", 0);
                $fields->push($myHiddenID);
                $mySubmit->setTitle('Speichern und die Dateien hochladen');
            }
            

            $form->setTemplate('ProjectForm');

            return $form;
        }

        public function dosaveProject($data, $form) {
            if ($data["Email"] != $data["Email2"]) {
                $validationResult = new ValidationResult();
                $validationResult->addFieldError('Email2', 'Email Felder müssen den gleichen Wert haben');
                $form->setSessionValidationResult($validationResult);
                $form->setSessionData($form->getData());
                return $this->redirectBack();
            } else {
                if ($data["ProjectID"] != 0) {
                    $myProjectForm = Project::get()->where("Project.ID='".$data["ProjectID"]."'")->First();
                    $myRedirection = "projectDetails";
                } else {
                    $myProjectForm = new Project();
                    $myProjectForm->write();
                    $myCompetition = $this->getActiveCompetition();
                    $myProjectForm->CompetitionID = $myCompetition->ID;
                    $myRedirection = "";
                }
                
                $form->saveInto($myProjectForm);
                $myProjectForm->write();

                $this->MySession()->set("myProjectID", $myProjectForm->ID);

                //myStep
                if ($data["ProjectStep"] == 0) {
                    return $this->redirect($this->Link("?myStep=1"));
                } else {
                    return $this->redirect($this->Link("projectDetails"));
                }
            }
            
            
        }


        public function userManual() {
            return Page::get()->where("ParentID='6'");
        }


        public function getAllCompetitions() {
            return Competition::get();
        }

        public function getActiveCompetition() {
            return $this->getAllCompetitions()->filter(array("Active"=>"1"))->First();
        }

        public function checkLoginForFile() {


            //18465
            $myFile = File::get()->byId(18465);
            if ($myFile->isPublished()) {
            } else {
                if ($myFile->publishSingle()) {
                    echo "<---- published <br />";
                } else {
                    echo "<---- NOT PUBLISHED <br />";
                }
            }

            //$myQuery = DB::query("SELECT * FROM File WHERE ClassName='SilverStripe\\Assets\\File'");
            //print_r($myQuery);

            /*$sqlQuery = new SQLSelect();
            $sqlQuery->setFrom('File');
            $sqlQuery->selectField('ID, ClassName');
            //$sqlQuery->addWhere('ClassName="SilverStripe\\\Assets\\\File"');
            echo $sqlQuery->sql();
            //print_r($sqlQuery);
            foreach ($sqlQuery->execute() as $key => $value) {
                if ($value["ClassName"] == "SilverStripe\\Assets\\File" ) {
                    echo $value["ID"];
                    $myFile = File::get()->byId($value["ID"]);
                    if ($myFile->isPublished()) {
                    } else {
                        if ($myFile->publishSingle()) {
                            echo "<---- published <br />";
                        } else {
                            echo "<---- NOT PUBLISHED <br />";
                        }
                    }

                }
                
            }*/

            //$myFile = Versioned::get_by_stage('File', Versioned::DRAFT); //File::get(); //->byId(13450);
            //echo $myFile->Name;
            //$myFile->publishSingle();
            /*foreach ($myFile as $key => $value) {
                
                if ($value->isPublished()) {
                    echo $value->Name ." ws published <---<br />";
                } else {
                    echo $value->Name ." was not published <---<br />";
                    $value->publishSingle();
                }
            }*/

            /*
            $myID = $this->request->param("ID");
            if ($this->getCurrentUser()) {
                $myFile = File::get()->byID($myID);
                if ($myFile->exists()) {
                    set_time_limit(0);
                    //echo getcwd();
                    $path = "..".$myFile->URL;
                    
                    // the file name of the download, change this if needed
                    $public_name = basename($path);

                    // get the file's mime type to send the correct content type header
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $path);

                    // send the headers
                    header("Content-Disposition: attachment; filename=$public_name;");
                    header("Content-Type: $mime_type");
                    header('Content-Length: ' . filesize($path));

                    // stream the file
                    $fp = fopen($path, 'rb');
                    fpassthru($fp);
                    exit;
                }
            }

            $this->redirect("Security/login?BackURL=home%2FcheckLoginForFile%2F".$myID);

            */
        }


        public function fileStatus() {
            $list = Project::get()->filter(array("Completed"=>"1", "Status"=>"geprüft&freigegeben"))->sort("Status DESC");

            $myCompetition = Competition::get()->filter(array("Active"=>"1"));
            if ($myCompetition->count() > 0) {
                $list = $list->filter(array("CompetitionID"=>$myCompetition->first()->ID));
            }
            //'Lebenslaufs' => File::class,
            //'Dokumente' => File::class
            $myHtml = "";
            foreach ($list as $key => $value) {
                $myHtml .= "<br /><hr><br />".$value->IdeenTitle." // ".$value->ProjectNumber ." - ".$value->Status."<br />";
                $myHtml .= "Name: ".$value->Vorname ." ". $value->Nachname;
                $myHtml .= "<br /><br />Lebenslauf:<br />";
                foreach ($value->Lebenslaufs() as $subkey => $subvalue) {
                    //$myHtml .= getcwd().$subvalue->URL."<br />";
                    if ( file_exists(getcwd().$subvalue->URL) ) {
                        //$myHtml .= "The file filename exists<br />";
                        $myHtml .= "<a href='".$subvalue->URL."' target='_blank'>".$subvalue->Filename."</a><br />";
                    } else {
                        
                        $myHtml .= "<span style='color: red;'>The file filename ".$subvalue->Filename." doesn't exists</span><br />";
                    }
                }

                $myHtml .= "<br />Dokumente:<br />";
                foreach ($value->Dokumente() as $subkey => $subvalue) {
                    //$myHtml .= getcwd().$subvalue->URL."<br />";
                    if ( file_exists(getcwd().$subvalue->URL) ) {
                        //$myHtml .= "The file filename exists<br />";
                        $myHtml .= "<a href='".$subvalue->URL."' target='_blank'>".$subvalue->Filename."</a><br />";
                    } else {
                        
                        $myHtml .= "<span style='color: red;'>The file filename ".$subvalue->Filename." doesn't exists</span><br />";
                    }
                }
            }

            echo $myHtml;
        }


        /* 
        * New Registration Form (multi step form)
        */
        public function RegistrationForm() {
            $form = RegistrationForm::create($this, 'RegistrationForm');

            $currentStep = $form->getCurrentStep();
            if ($currentStep instanceof \app\RegistrationForm\RegistrationForm_Step4) {
                $form->setTemplate('app\\RegistrationForm\\RegistrationForm_Step4');
            }

            return $form;
        }

        public function doUploadProjectFiles_Step3($data, $form) {
            //MultiFormSessionID
            // Save the form data for the current step
            //$this->save($data);
            $currentStep = $this->getCurrentStep($data['MultiFormSessionID'], $data['StepID']);
            if (is_array($data)) {
                $currentStep->saveData($data);

                // move files to temp folder and save the file references to the database 
                // RegistrationFormFiles
                if (isset($_FILES['Dokumente']) && is_array($_FILES['Dokumente'])) {
                    foreach ($_FILES['Dokumente']['tmp_name'] as $key => $tmpName) {
                        if ($tmpName != "") {
                            $fileGroup = 1; // 1 = Dokumente
                            $fileName = $_FILES['Dokumente']['name'][$key];
                            $multiFormSessionID = $currentStep->SessionID;
                            $this->saveTempFile($multiFormSessionID, $fileGroup, $fileName, $tmpName);
                        }
                    }
                }

                if (isset($_FILES['Lebenslaufs']) && is_array($_FILES['Lebenslaufs'])) {
                    foreach ($_FILES['Lebenslaufs']['tmp_name'] as $key => $tmpName) {
                        if ($tmpName != "") {
                            $fileGroup = 2; // 2 = Lebenslaufs
                            $fileName = $_FILES['Lebenslaufs']['name'][$key];
                            $multiFormSessionID = $currentStep->SessionID;
                            $this->saveTempFile($multiFormSessionID, $fileGroup, $fileName, $tmpName);
                        }
                    }
                }

                if (isset($_FILES['Urkunde']) && is_array($_FILES['Urkunde'])) {
                    foreach ($_FILES['Urkunde']['tmp_name'] as $key => $tmpName) {
                        if ($tmpName != "") {
                            $fileGroup = 3; // 3 = Urkunde
                            $fileName = $_FILES['Urkunde']['name'][$key];
                            $multiFormSessionID = $currentStep->SessionID;
                            $this->saveTempFile($multiFormSessionID, $fileGroup, $fileName, $tmpName);
                        }
                    }
                }

            }

            $this->redirectBack();
        }

        public function saveTempFile($multiFormSessionID, $fileGroup, $fileName, $tmpName) {
            // create temp folder if not exists
            $tempFolder = ASSETS_PATH . "/temp/registration-form/" . $multiFormSessionID . "/" . $fileGroup . "/"; // 3 = Urkunde
            if (!file_exists($tempFolder)) {
                mkdir($tempFolder, 0755, true);
            }

            // generate temp file path
            $tempFilePath = $tempFolder . $fileName;

            // check if same file already exists in temp folder, if yes add a suffix to the file name
            if (file_exists($tempFilePath)) {
                $fileInfo = pathinfo($tempFilePath);
                $baseName = $fileInfo['filename'];
                $extension = $fileInfo['extension'];
                $i = 1;
                do {
                    $tempFilePath = $tempFolder . $baseName . "_" . $i . "." . $extension;
                    $fileName = $baseName . "_" . $i . "." . $extension;
                    $i++;
                } while (file_exists($tempFilePath));
            }

            $registrationFormFile = RegistrationFormFiles::create();
            $registrationFormFile->FileGroup = $fileGroup;
            $registrationFormFile->FileName = $fileName;
            $registrationFormFile->MultiFormSessionID = $multiFormSessionID;
            $registrationFormFile->FilePath = $tempFilePath;
            $registrationFormFile->write();

            // move file to temp folder
            move_uploaded_file($tmpName, $tempFilePath);
        }

        public function getCurrentStep($multiFormSessionID = null, $stepID = null)
        {
            $currentStep = null;
            if (isset($stepID)) {
                $currentSession = MultiFormSession::get()->filter('Hash', $multiFormSessionID)->first();
                if ($currentSession) {
                    $currentStep = MultiFormStep::get()->filter([
                        'SessionID' => $currentSession->ID,
                        'ID' => $stepID
                    ]);
                }
            }

            if ($currentStep && $currentStep->count() > 0) {
                return $currentStep->first();
            }
            return null;
        }

        public function deleteRegistrationDocument() {
            $fileID = $this->request->param("ID");
            $sessionHash = $this->request->param("OtherID");
            $currentSession = MultiFormSession::get()->filter('Hash', $sessionHash)->first();
            if ($currentSession) {
                $myFile = RegistrationFormFiles::get()->filter( array("ID" => $fileID, "MultiFormSessionID" => $currentSession->ID) )->First();
                if ($myFile) {
                    // delete the file from temp folder
                    if (file_exists($myFile->generatedPath())) {
                        unlink($myFile->generatedPath());
                    }
                    // delete the database record
                    $myFile->delete();
                }
            }

            $this->redirectBack();
        }

        public function registrationfinished() {
            return $myData = [
                'RegistrationForm' => DBField::create_field('HTMLText',$this->ProjectFinishedText),
            ];
        }
    }
}
