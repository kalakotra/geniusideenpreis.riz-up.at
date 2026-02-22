<?php

namespace app\RegistrationForm;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\ORM\FieldType\DBField;

class RegistrationForm_Step4 extends MultiFormStep {

    private static $is_final_step = true;

    public function getFields() {

        
        $fields = FieldList::create(
            HeaderField::create('header', 'Persönliche Daten'),
            LiteralField::create('personalData', $this->personalDataHtml()),

            HeaderField::create('header', 'Teammitglieder'),
            LiteralField::create('teamMembers', $this->teamMembersHtml()),

            HeaderField::create('header', 'Ihre RIZ UP GENIUS Geschäftsidee'),
            LiteralField::create('ideeData', $this->ideeDataHtml()),

            HeaderField::create('header', 'Dateien'),
            LiteralField::create('uploadedFiles', $this->uploadedFilesHtml()),

            HeaderField::create('header', 'Bestätigung und Datenschutz'),
            CheckboxField::create('AktInfoCheckbox', 'Ja, ich möchte aktuelle Informationen zu den RIZ UP Services erhalten.')->addExtraClass('no-grid'),
            CheckboxField::create('bewertungCheckbox', 'Ich bestätige, dass alle Angaben vollständig und bereit für die Bewertung durch die RIZ UP GENIUS Jury sind.')->addExtraClass('no-grid'),
            CheckboxField::create('informationenCheckbox', 'Ich bestätige, die folgenden Informationen gelesen und zur Kenntnis genommen zu haben:')->addExtraClass('no-grid'),
            LiteralField::create('confirmationText', '<strong>Vertraulichkeit:</strong> Alle Daten, die Sie in unser System eingetragen haben, werden selbstverständlich streng vertraulich behandelt. Bei der Registrierung angegebene Kontakt- und Stammdaten werden ausschließlich in der RIZ UP Datenbank gespeichert und nur für die Jurybewertung, Kontaktaufnahme und Information im Rahmen des Wettbewerbs und des RIZ UP verwendet. Unsere Expertinnen und Experten verpflichten sich zur strengsten Geheimhaltung aller Daten, die sie im Rahmen ihrer RIZ UP GENIUS Juryverantwortung erhalten. 
						<br /><br />
						<strong>Auskunftsrecht und Widerruf:</strong> Wir erteilen Ihnen jederzeit Auskunft darüber, welche Daten wir über Sie gespeichert haben. Dazu senden Sie bitte eine E-Mail an genius@riz-up.at. Außerdem können Sie die Nutzung der persönlichen Daten jederzeit mit Wirkung für die Zukunft widerrufen. Dazu ist eine E-Mail an kontakt@riz-up.at zu senden. '),

        );

        return $fields;
    }

    public function getValidator()
    {
        return RequiredFields::create(array(
            'bewertungCheckbox',
            'informationenCheckbox',
        ));
    }

    public function getFieldValue($field, $step = null) {
        return $this->getValueFromOtherStep($step, $field);
    }

    public function personalDataHtml() {
        $myRegions = [
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
        ];

        $personalDataHtml = '<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Anrede
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Anrede', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Titel vorangestellt
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('AkademischerGrad', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Vorname 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Vorname', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Nachname 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Nachname', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Titel nachgestellt
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('AkademischerGradSufix', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Firma
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Firma', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Abteilung
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Abteilung', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Stra&szlig;e, Hausnummer 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Strasse', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>


		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Postleitzahl 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('PLZ', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Ort 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Ort', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Bezirk 
			</div>
			<div class="col-12 col-lg-8">
				' . ($this->getFieldValue('Bezirk', 'app\\RegistrationForm\\RegistrationForm_Step1') ? $myRegions[$this->getFieldValue('Bezirk', 'app\\RegistrationForm\\RegistrationForm_Step1')] : '') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Telefon 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Telefonnummer', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Website
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Website', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				E-Mail 
			</div>
			<div class="col-12 col-lg-8">
				' . $this->getFieldValue('Email', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>

		<div class="row align-items-center mb-1">
			<div class="col-12">
				Wie sind Sie auf den RIZ UP GENIUS aufmerksam geworden?
			</div>
			<div class="col-12">
				' . $this->getFieldValue('WettbewerbAufmerksam', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
			</div>
		</div>';

        //WettbewerbAufmerksam

        return $personalDataHtml;
    }

    public function teamMembersHtml() {

        $teamMembersHtml = '';

        if ($this->getFieldValue('Vorname1', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<h4 >Person 1</h4>';
            $teamMembersHtml .= $this->teamMemberTemplate(
                $this->getFieldValue('Anrede1', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad1', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad1Sufix', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Vorname1', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Nachname1', 'app\\RegistrationForm\\RegistrationForm_Step1')
            );
        }

        if ($this->getFieldValue('Vorname2', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<hr />';
            $teamMembersHtml .= '<h4 >Person 2</h4>';
            $teamMembersHtml .= $this->teamMemberTemplate(
                $this->getFieldValue('Anrede2', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad2', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad2Sufix', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Vorname2', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Nachname2', 'app\\RegistrationForm\\RegistrationForm_Step1')
            );
        }

        if ($this->getFieldValue('Vorname3', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<hr />';
            $teamMembersHtml .= '<h4 >Person 3</h4>';
            $teamMembersHtml .= $this->teamMemberTemplate(
                $this->getFieldValue('Anrede3', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad3', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad3Sufix', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Vorname3', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Nachname3', 'app\\RegistrationForm\\RegistrationForm_Step1')
            );
        }

        if ($this->getFieldValue('Vorname4', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<hr />';
            $teamMembersHtml .= '<h4 >Person 4</h4>';
            $teamMembersHtml .= $this->teamMemberTemplate(
                $this->getFieldValue('Anrede4', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad4', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad4Sufix', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Vorname4', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Nachname4', 'app\\RegistrationForm\\RegistrationForm_Step1')
            );
        }

        if ($this->getFieldValue('Vorname5', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<hr />';
            $teamMembersHtml .= '<h4 >Person 5</h4>';
            $teamMembersHtml .= $this->teamMemberTemplate(
                $this->getFieldValue('Anrede5', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad5', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('AkademischerGrad5Sufix', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Vorname5', 'app\\RegistrationForm\\RegistrationForm_Step1'),
                $this->getFieldValue('Nachname5', 'app\\RegistrationForm\\RegistrationForm_Step1')
            );
        }

        if ($this->getFieldValue('OtherTeamMembers', 'app\\RegistrationForm\\RegistrationForm_Step1')) {
            $teamMembersHtml .= '<hr />';
            $teamMembersHtml .= '<h4 >Weitere Teammitglieder</h4>
';
            $teamMembersHtml .= '<div class="row align-items-center mb-1">
                    <div class="col-12">
                        Alle weiteren Teammitglieder anführen
                    </div>
                    <div class="col-12">
                        ' . $this->getFieldValue('OtherTeamMembers', 'app\\RegistrationForm\\RegistrationForm_Step1') . '
                    </div>
                </div>';
        }

        return $teamMembersHtml;
    }

    public function teamMemberTemplate($Anrede, $AkademischerGrad, $AkademischerGradSufix, $Vorname, $Nachname) {
        $html = '<div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Anrede
                </div>
                <div class="col-12 col-lg-8">
                    ' . $Anrede . '
                </div>
            </div>
            <div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Titel vorangestellt
                </div>
                <div class="col-12 col-lg-8">
                    ' . $AkademischerGrad . '
                </div>
            </div>
            <div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Titel nachgestellt
                </div>
                <div class="col-12 col-lg-8">
                    ' . $AkademischerGradSufix . '
                </div>
            </div>
            <div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Vorname
                </div>
                <div class="col-12 col-lg-8">
                    ' . $Vorname . '
                </div>
            </div>
            <div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Nachname
                </div>
                <div class="col-12 col-lg-8">
                    ' . $Nachname . '
                </div>
            </div>';

        return $html;
    }

    public function ideeDataHtml() {
        $html = '<div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4 ">
                    Titel der Idee 
                </div>
                <div class="col-12 col-lg-8">
                    ' . $this->getFieldValue('IdeenTitle', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                </div>
            </div>
            <div class="row align-items-center mb-1">
                <div class="col-12 col-lg-4">
                    Kategorie 
                </div>
                <div class="col-12 col-lg-8">
                    ' . $this->CompetitionCategory() . '
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-12">
                    Ideen-Kurz-Beschreibung
                </div>
                <div class="col-12">
                    ' . $this->getFieldValue('KurzBeschreibung', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                </div>
            </div>';

            if ($this->getFieldValue('WarumEinzigartig', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12">
                        Warum sollten Kunden bei Ihnen kaufen, was macht Ihre Idee einzigartig?
                    </div>
                    <div class="col-12">
                        ' . $this->getFieldValue('WarumEinzigartig', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                    </div>
                </div>';
            }

            //IdeeGeschuetzt
            if ($value = $this->getFieldValue('IdeeGeschuetzt', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $valueTitle = $value == '1' ? 'Ja' : ($value == '0' ? 'Nein' : 'im Laufen');
                
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12 col-lg-4">
                        Haben Sie die Idee geschützt?
                    </div>
                    <div class="col-12 col-lg-8">
                        ' . $valueTitle . '
                    </div>
                </div>';

                if ($value == '1') {
                    $html .= '<div class="row mb-1">
                        <div class="col-12 col-lg-4">
                            Schutzart
                        </div>
                        <div class="col-12 col-lg-8">
                            ' . $this->getFieldValue('Schutzart', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                        </div>
                    </div>';
                }
            }

            //IdeeRealisiert
            if ($value = $this->getFieldValue('IdeeRealisiert', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $valueTitle = $value == '1' ? 'Ja' : 'Nein';
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12 col-lg-4">
                        Haben Sie Ihre Idee bereits umgesetzt/realisiert?
                    </div>
                    <div class="col-12 col-lg-8">
                        ' . $valueTitle . '
                    </div>
                </div>';

                if ($value == '1') {
                    $html .= '<div class="row mb-1">
                        <div class="col-12">
                            In welchem Stadium der Entwicklung stehen Sie mit Ihrer Geschäftsidee? Welche Schritte sind noch offen?
                        </div>
                        <div class="col-12 ">
                            ' . $this->getFieldValue('Umsetzungsgrad', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                        </div>
                    </div>';
                }
            }

            //Selbststaendig
            if ($value = $this->getFieldValue('Selbststaendig', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $valueTitle = $value == '1' ? 'Ja' : 'Nein';
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12 col-lg-4">
                        Sind Sie bereits selbstständig?
                    </div>
                    <div class="col-12 col-lg-8">
                        ' . $valueTitle . '
                    </div>
                </div>';

                if ($value == '1') {
                    $html .= '<div class="row mb-1">
                        <div class="col-12 col-lg-4">
                            Seit
                        </div>
                        <div class="col-12 col-lg-8">
                            ' . $this->getFieldValue('SelbststaendigSeit', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                        </div>
                    </div>';
                }
            }

            //Zielgruppen
            if ($value = $this->getFieldValue('Zielgruppen', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12">
                        Welche Zielgruppen spricht Ihre Geschäftsidee an?
                    </div>
                    <div class="col-12 ">
                        ' . $value . '
                    </div>
                </div>';
            }

            //Einnahmequellen
            if ($value = $this->getFieldValue('Einnahmequellen', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12">
                        Wie verdienen Sie Geld mit Ihrer Geschäftsidee?
                    </div>
                    <div class="col-12 ">
                        ' . $value . '
                    </div>
                </div>';
            }

            //MarktChancenRisiken
            if ($value = $this->getFieldValue('MarktChancenRisiken', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12">
                        Welche Chancen und Risiken sehen Sie am (potenziellen) Markt?
                    </div>
                    <div class="col-12 ">
                        ' . $value . '
                    </div>
                </div>';
            }

            // Wachstumsplanung
            if ($value = $this->getFieldValue('Wachstumsplanung', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $valueTitle = $value == '1' ? 'Ja' : 'Nein';
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12 col-lg-4">
                        Planen Sie mit dem Geschäftsmodell zu wachsen?
                    </div>
                    <div class="col-12 col-lg-8">
                        ' . $valueTitle . '
                    </div>
                </div>';

                if ($value == '1') {
                    $html .= '<div class="row mb-1">
                        <div class="col-12 col-lg-4">
                            Wie soll dieses Wachstum aussehen?
                        </div>
                        <div class="col-12 col-lg-8">
                            ' . $this->getFieldValue('WachstumsplanungDetails', 'app\\RegistrationForm\\RegistrationForm_Step2') . '
                        </div>
                    </div>';
                }
            }

            //MehrwertFuerNiederoesterreich
            if ($value = $this->getFieldValue('MehrwertFuerNiederoesterreich', 'app\\RegistrationForm\\RegistrationForm_Step2')) {
                $html .= ' <hr /><div class="row mb-1">
                    <div class="col-12">
                        Abschließend: Wir suchen innovative, niederösterreichische Geschäftsideen. Was ist der Mehrwert Ihrer Idee für Niederösterreich?
                    </div>
                    <div class="col-12 ">
                        ' . $value . '
                    </div>
                </div>';
            }

            return $html;
    }

    public function CompetitionCategory() {
        $categoryID = $this->getFieldValue('KategoriesID', 'app\\RegistrationForm\\RegistrationForm_Step2');
        return $this->getActiveCompetition()->Kategorie()->filter('ID', $categoryID) ? $this->getActiveCompetition()->Kategorie()->filter('ID', $categoryID)->First()->Title : '';
    }

    public function getAllCompetitions() {
        return \Competition::get();
    }

    public function getActiveCompetition() {
        return $this->getAllCompetitions()->filter(array("Active"=>"1"))->First();
    }

    public function uploadedFilesHtml() {
        $html = '' . $this->getUploadedFiles()->count() . ' Datei(en) hochgeladen.<br />';

        if ($files = $this->getUploadedFiles()->filter(['FileGroup' => '1'])) {
            $links = '';
            foreach ($files as $file) {
                $links .= '<a href="assets/' . $file->generatedPath(false) . '" target="_blank">' . $file->FileName . '</a><br />';
            }
            $html .= '<div class="row mb-1">
                <div class="col-12 col-lg-4">
                    Ideen-Beschreibung
                </div>
                <div class="col-12 col-lg-8">
                    ' . $links . '
                </div>
            </div>';
        }

        if ($files = $this->getUploadedFiles()->filter(['FileGroup' => '2'])) {
            $links = '';
            foreach ($files as $file) {
                $links .= '<a href="assets/' . $file->generatedPath(false) . '" target="_blank">' . $file->FileName . '</a><br />';
            }
            $html .= '<div class="row mb-1">
                <div class="col-12 col-lg-4">
                    Lebenslauf 
                </div>
                <div class="col-12 col-lg-8">
                    ' . $links . '
                </div>
            </div>';
        }

        if ($files = $this->getUploadedFiles()->filter(['FileGroup' => '3'])) {
            $links = '';
            foreach ($files as $file) {
                $links .= '<a href="assets/' . $file->generatedPath(false) . '" target="_blank">' . $file->FileName . '</a><br />';
            }
            $html .= '<div class="row mb-1">
                <div class="col-12 col-lg-4">
                    Weitere Unterlagen
                </div>
                <div class="col-12 col-lg-8">
                    ' . $links . '
                </div>
            </div>';
        }

        return $html;
    }

    public function getUploadedFiles() {
        return RegistrationFormFiles::get()->filter('MultiFormSessionID', $this->getSession()->ID);;
    }

    public function getTitle() {
        return '4';
    }

    public function getContent() {
        $controller = Controller::curr();
        if ($controller) {
            return DBField::create_field('HTMLText', $controller->Step4Text);
        }
    }
}