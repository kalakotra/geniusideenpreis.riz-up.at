<?php

namespace app\RegistrationForm;

use app\RegistrationForm\RegistrationForm_Step4;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\ORM\FieldType\DBField;

class RegistrationForm_Step3 extends MultiFormStep {

    private static $next_steps = RegistrationForm_Step4::class;

    public function getFields(): FieldList {
        $stepID = null;
        $controller = Controller::curr();
        if ($controller) {
            $request = $controller->getRequest();
            if ($request) {
                $stepID = $request->getVar('StepID');
            }
        }

        $getMyUploadedFiels = $this->getUploadedFiles();

        $myHtmlDocuments = $myHtmlLebenslauf = $myHtmlUrkunde = '<p class="smallTextInForm">Es wurden noch keine Dateien hochgeladen.</p>';
        if ($getMyUploadedFiels->count() > 0) {
            if ($getMyUploadedFiels->filter('FileGroup', 1)->count() > 0) {
                $myHtmlDocuments = $this->listUploadedFiles($controller, $getMyUploadedFiels->filter('FileGroup', 1), $this->getSession()->Hash);
            }

            if ($getMyUploadedFiels->filter('FileGroup', 2)->count() > 0) {
                $myHtmlLebenslauf = $this->listUploadedFiles($controller, $getMyUploadedFiels->filter('FileGroup', 2), $this->getSession()->Hash);
            }

            if ($getMyUploadedFiels->filter('FileGroup', 3)->count() > 0) {
                $myHtmlUrkunde = $this->listUploadedFiles($controller, $getMyUploadedFiels->filter('FileGroup', 3), $this->getSession()->Hash);
            }
        }
        
        $fields = FieldList::create(
            HeaderField::create('header', 'Dateienupload'),
            LiteralField::create('', '<div><span class="smallTextInForm">Bitte beachten Sie unbedingt die Dateigröße sowie das Dateiformat. Sowohl die Ideen-Beschreibung als auch der Kurz-Lebenslauf sind Pflichtfelder!</span></div>'),

            HeaderField::create('header', 'Ideen-Beschreibung *'),
            LiteralField::create('', '<div><span class="smallTextInForm">Unterlagen zur Idee mit Beantwortung der wichtigsten Fragen zu Innovationsgrad / Marktpotenzial / Nutzen für Kundinnen und Kunden / Realisierbarkeit.</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateigröße: max. 5 MB pro Datei</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateiformate: pdf, doc, docx, jpg, jpeg, gif, mp3, mp4, xls, xlsx, ppt, pptx, pps</span></div>'),
            $upload1 = FileField::create('Dokumente[]', ''),

            LiteralField::create('myUploadedDocuments', $myHtmlDocuments),

            HeaderField::create('header', 'Kurz-Lebenslauf *'),
            LiteralField::create('', '<div><span class="smallTextInForm">Erforderlicher Inhalt: Angaben zur Person, Ausbildung, relevante Berufserfahrung, relevante Projekterfahrung, falls vorhanden: Publikationsliste bzw. Empfehlungen. <br>Laden Sie bei Teameinreichungen Kurz-Lebensläufe aller Teammitglieder hoch.</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateigröße: max. 5 MB pro Datei</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateiformate: pdf, doc, docx</span></div>'),
            $upload2 = FileField::create('Lebenslaufs[]', ''),
            LiteralField::create('myUploadedDocuments2', $myHtmlLebenslauf),

            HeaderField::create('header', 'Urkunden etc.'),
            LiteralField::create('', '<div><span class="smallTextInForm">Falls Ihre Idee bereits geschützt ist oder gerade geschützt wird, laden Sie hier bitte Ihre Patenturkunde, Gebrauchsmuster oder andere Unterlagen dazu hoch.</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateigröße: max. 5 MB pro Datei</span>
            <br>
            <span class="smallTextInForm fw-bold">Dateiformate: pdf, doc, docx</span></div>'),
            $upload3 = FileField::create('Urkunde[]', ''),
            LiteralField::create('myUploadedDocuments3', $myHtmlUrkunde),

            HiddenField::create('StepID', null, $stepID)
        );

        $upload1->getValidator()->allowedExtensions = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'gif', 'mp3', 'mp4', 'xls', 'xlsx', 'ppt', 'pps', 'pptx');
        $upload1->getValidator()->setAllowedMaxFileSize('5m');

        $upload2->getValidator()->allowedExtensions = array('pdf', 'doc', 'docx');
        $upload2->getValidator()->setAllowedMaxFileSize('5m');

        $upload3->getValidator()->allowedExtensions = array('pdf', 'doc', 'docx');
        $upload3->getValidator()->setAllowedMaxFileSize('5m');


        $validator = 1;
        if ($getMyUploadedFiels->filter('FileGroup', 1)->count() == 0) {
            $validator = 0;
        }
        if ($getMyUploadedFiels->filter('FileGroup', 2)->count() == 0) {
            $validator = 0;
        }

        if ($validator == 0) {
            $fields->push(
                HiddenField::create('forceError', null, '1')
            );
        }

        return $fields;
    }

    public function getExtraActions() {
        return FieldList::create(
            FormAction::create('doUploadProjectFiles_Step3', 'Hochladen')->addExtraClass("btn btn-warning btn-block"),
        );
    }

    public function getUploadedFiles() {
        return RegistrationFormFiles::get()->filter('MultiFormSessionID', $this->getSession()->ID);;
    }

    public function listUploadedFiles($controller, $fileList, $sessionHash) {
        $myHtml = '<div class="row">';
        foreach ($fileList as $key => $value) {
            $myHtml .= '<div class="pt-2 pb-2 col-12 col-md-6 mt-3 uploadedFileHolder">
                            <div class="p-3 h100">
                                <div class="row h100">
                                    <div class="col-4">
                                        <div class="text-center "><img src="'.$controller->ThemeDir().'/images/file-icons/'.pathinfo((string) ($value->generatedPath() ?? ''), PATHINFO_EXTENSION).'.png" /></div>
                                    </div>
                                    <div class="col-8">
                                        <div class="fileName smallTextInForm">
                                            '.$value->Title.'
                                            <br />
                                            '.$value->getSize().'
                                        </div>
                                    </div>
                                    <div class=" smallTextInForm col-12 text-right align-self-bottom">
                                        Löschen <a href="'.$controller->Link('deleteRegistrationDocument/' . $value->ID . '/' . $sessionHash).'" class="youSure"><img src="'.$controller->ThemeDir().'/images/delete.png" alt="Delete" /></a>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }
        $myHtml .= '</div>';
        return $myHtml;
    }

    public function getValidator__()
    {
        $requiredFields = [];
        $uploadedFiles = $this->getUploadedFiles();
        if ($uploadedFiles->filter('FileGroup', 1)->count() == 0) {
            $requiredFields[] = 'Dokumente[]';
        }
        if ($uploadedFiles->filter('FileGroup', 2)->count() == 0) {
            $requiredFields[] = 'Lebenslaufs[]';
        }
        return RequiredFieldsValidator::create($requiredFields);
    }

    public function getTitle() {
        return '3';
    }

    public function getContent() {
        $controller = Controller::curr();
        if ($controller) {
            return DBField::create_field('HTMLText', $controller->Step3Text);
        }
    }

}