<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\Form;

class ExportPageController extends PageController {

	private static $allowed_actions = array (
		'Form'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}

	public function Form() {
        

        $my_fields = array(
            'ProjectNumber' => 'HTMLText',
            'Anrede' => 'Enum("Frau,Herr", "Frau")',
            'AkademischerGrad' => 'Varchar(100)',
            'Vorname' => 'Varchar(50)',
            'Nachname' => 'Varchar(100)',
            'Firma' => 'Varchar(100)',
            'Abteilung' => 'Varchar(100)',
            'Strasse' => 'Varchar(100)',
            'PLZ' => 'Varchar(10)',
            'Ort' => 'Varchar(100)',
            //'Vorwahl' => 'Varchar(5)',
            'Telefonnummer' => 'Varchar(20)',
            //'Durchwahl' => 'Varchar(5)',
            'Email' => 'Varchar(100)',


            // ideen daten 
            'IdeenTitle' => 'Varchar(100)',
            'Kategorie' => 'Enum("Gewerbe/Dienstleistung, Technologie, Forschung, Schwerpunktthema XYZ", "Gewerbe/Dienstleistung")',
            'KurzBeschreibung' => 'Text',

            'Status' => 'Enum("geprüft&freigegeben,in Bearbeitung,nicht zugelassen,neu", "neu")',


            'InnovationsPunkte' => 'Decimal(9,2)',
            'MarktPunkte' => 'Decimal(9,2)',
            'UmsetzungsrelevanzPunkte' => 'Decimal(9,2)',
            'WirtschaftsrelevanzPunkte' => 'Decimal(9,2)',
            'QualitatPunkte' => 'Decimal(9,2)',
            'JuryPoints' => 'Decimal(9,2)',
            'JuryPlace' => 'Int',
            'AdminPoints' => 'Decimal(9,2)',
            'AdminPlace' => 'Int',

            'Nominierte' => 'Enum("Ja,Nein", "Nein")',

            'OffiziellerPlatz' => 'Int',

            'AdminKomentar' => 'HTMLText',

            // additional fields 2026
            'WarumEinzigartig' => 'Text',
            'IdeeGeschuetzt' => 'Int', // 0 = Nein, 1 = Ja, 2 = In Planung
            'Schutzart' => 'Varchar(255)',
            'IdeeRealisiert' => 'Int', // 0 = Nein, 1 = Ja
            'Umsetzungsgrad' => 'Text',
            'Selbststaendig' => 'Int', // 0 = Nein, 1 = Ja
            'SelbststaendigSeit' => 'Varchar(255)',
            'Zielgruppen' => 'Text',
            'Einnahmequellen' => 'Text',
            'MarktChancenRisiken' => 'Text',
            'Wachstumsplanung' => 'Int', // 0 = Nein, 1 = Ja
            'WachstumsplanungDetails' => 'Text',
            'MehrwertFuerNiederoesterreich' => 'Text'


        );

        $my_fields = array(
            'ProjectNumber' => 'Projektnummer',
            'Anrede' => 'Anrede',
            'AkademischerGrad' => 'Titel vorangestellt',
            'Vorname' => 'Vorname',
            'Nachname' => 'Nachname',
            'AkademischerGradSufix' => 'Titel nachgestellt',

            'TeamteilnehmerInnen' => 'Teammitglieder',
            
            'Firma' => 'Firma',
            'Abteilung' => 'Abteilung',
            'Strasse' => 'Straße',
            'PLZ' => 'PLZ',
            'Ort' => 'Ort',
            'Bezirk' => 'Bezirk',
            //'Vorwahl' => 'Vorwahl',
            'Telefonnummer' => 'Telefonnummer',
            //'Durchwahl' => 'Durchwahl',
            'Email' => 'E-Mail',
            'Website' => 'Website',
            'WettbewerbAufmerksam' => 'Wie sind Sie auf den RIZ UP GENIUS aufmerksam geworden?',


            /* ideen daten */
            'IdeenTitle' => 'Titel der Idee',
            'Kategorie' => 'Kategorie',
            'KurzBeschreibung' => 'Kurz-Beschreibung',

            'Status' => 'Status',


            //'InnovationsPunkte' => 'Kreativität / Neuartigkeit',
            //'MarktPunkte' => 'Nutzen',
            //'UmsetzungsrelevanzPunkte' => 'Umsetzbarkeit',
            //'WirtschaftsrelevanzPunkte' => 'Qualität der Einreichung',
            'Bewertung' => 'Bewertung',
            //'QualitatPunkte' => 'Decimal(9,2)',
            'JuryPoints' => 'Jury-Punkte',
            'JuryPlace' => 'Jury-Platz',
            'AdminPoints' => 'Finale Punkte',
            'AdminPlace' => 'Finale Platzierung',

            'Nominierte' => 'Nominiert',

            'OffiziellerPlatz' => 'Offizieller Platz',

            'AdminKomentar' => 'Admin-Kommentar',/*
            'Schule' => 'Schule',
            'ProfessorAkademischerGrad' => 'Professor Titel vorangestellt',
            'ProfessorAkademischerGradSufix' => 'Professor Titel nachgestellt',
            'ProfessorVorname' => 'Professor Vorname',
            'ProfessorNachname' => 'Professor Nachname',
            'ProfessorTelefon' => 'Professor Telefon',
            'ProfessorEmail' => 'Professor Email'*/

            // additional fields 2026
            'WarumEinzigartig' => 'Warum sollten Kunden bei Ihnen kaufen, was macht Ihre Idee einzigartig?',
            'IdeeGeschuetzt' => 'Haben Sie die Idee geschützt?', // 0 = Nein, 1 = Ja, 2 = In Planung
            'Schutzart' => 'Schutzart',
            'IdeeRealisiert' => 'Wurde die Idee bereits realisiert?', // 0 = Nein, 1 = Ja
            'Umsetzungsgrad' => 'Umsetzungsgrad',
            'Selbststaendig' => 'Sind Sie selbstständig?', // 0 = Nein, 1 = Ja
            'SelbststaendigSeit' => 'Seit wann sind Sie selbstständig?',
            'Zielgruppen' => 'Zielgruppen',
            'Einnahmequellen' => 'Einnahmequellen',
            'MarktChancenRisiken' => 'Chancen und Risiken',
            'Wachstumsplanung' => 'Wachstumsplanung', // 0 = Nein, 1 = Ja
            'WachstumsplanungDetails' => 'Wie soll dieses Wachstum aussehen?',
            'MehrwertFuerNiederoesterreich' => 'Was ist der Mehrwert Ihrer Idee für Niederösterreich?'


        );

        $options = array_combine(array_keys($my_fields), array_keys($my_fields));

        
        $myFields = new FieldList(
            CheckboxSetField::create("ExportFields", "Export fields", $my_fields),
            LiteralField::create("separator", "<hr>"),
            DropdownField::create("FilterCompetition", "Filter by Competition", Competition::get()->filter(["HideFromMenu"=>"0"])->map() )->setEmptyString('All'),
            DropdownField::create("FilterKategorie", "Filter by category", Kategorie::get()->map())->setEmptyString('All'),
            DropdownField::create("FilterStatus", "Filter by status", array("0"=>"All", "geprüft&freigegeben"=>"geprüft&freigegeben", "in Bearbeitung"=>"in Bearbeitung", "nicht zugelassen"=>"nicht zugelassen", "neu"=>"neu")),
            DropdownField::create("FilterNominierte", "Filter by Nominierte", array("0"=>"All", "Ja"=>"Ja", "Nein"=>"Nein"))
        );

        $myReqFields = new RequiredFieldsValidator();
        
        
        $actions = new FieldList( 
            new FormAction('exportDoc', 'Export CSV') 
        ); 
        return new Form($this, 'Form', $myFields, $actions, $myReqFields);

        //print_r(Project::$db);

        

    }


    public function exportDoc($data, $form) {
        $separator = ";";
        $newLine = "\n";
        $what = array("–", /*"Ü", "ü", "Ö", "ö", "Ä", "ä", "ß",*/ "\r", "\n", ";", "
            ", "
");
        $with = array("-", /*"UE", "ue", "OE", "oe", "AE", "ae", "ss",*/ " ", " ", " ", " ", " ");

        $myProjects = Project::get()->filter(array("Completed"=>"1"));

        if (isset($data['FilterCompetition']) && $data["FilterCompetition"] != "") {
            $myProjects = $myProjects->filter(array("CompetitionID"=>$data["FilterCompetition"]));
        }

        if (isset($data['FilterKategorie']) && $data["FilterKategorie"] != "") {
            $myProjects = $myProjects->filter(array("KategoriesID"=>$data["FilterKategorie"]));
        }

        if (isset($data['FilterStatus']) && $data["FilterStatus"] != "0") {
            $myProjects = $myProjects->filter(array("Status"=>$data["FilterStatus"]));
        }

        if (isset($data['FilterNominierte']) && $data["FilterNominierte"] != "0") {
            $myProjects = $myProjects->filter(array("Nominierte"=>$data["FilterNominierte"]));
        }

        $fileData = '';

        if (isset($data["ExportFields"])) {
            foreach ($data["ExportFields"] as $key => $value) {
                $fileData .= $this->switchTitle($value).$separator;
                
                
            }
            $fileData .= $newLine; //"\n";

            foreach ($myProjects as $pKey => $pValue) {
                foreach ($data["ExportFields"] as $key => $value) {
                    if ($value == "Telefonnummer") {
                        /*
                        //'Vorwahl' => 'Vorwahl',
                        'Telefonnummer' => 'Telefonnummer',
                        //'Durchwahl' => 'Durchwahl',
                        */

                        $fileData .= str_replace($what, $with, strip_tags((string)(($pValue->Vorwahl ." ". $pValue->Telefonnummer ." ". $pValue->Durchwahl) ?? ''))).$separator;
                    } else if ($value == "Kategorie") {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->Kategories()->Title ?? ''))).$separator;
                    } else if ($value == "TeamteilnehmerInnen") {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->myTeam() ?? ''))).$separator;
                    } else if ($value == "IdeeGeschuetzt" || $value == "IdeeRealisiert" || $value == "Selbststaendig" || $value == "Wachstumsplanung") {
                        $optionValue = "Nein";
                        if ($pValue->$value == 1) {
                            $optionValue = "Ja";
                        } else if ($pValue->$value == 2) {
                            $optionValue = "In Planung";
                        }
                        $fileData .= str_replace($what, $with, strip_tags((string)($optionValue ?? ''))).$separator;
                    } else if ($value == "Bezirk") {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->bezirkName($pValue->Bezirk) ?? ''))).$separator;
                    } else if ($value == "Bewertung") {
                        //CompetitionCriteriaAdmin - AdminPointsOverrule
                        if ($pValue->Competition()->CompetitionCriteria()->exists()) {
                            
                            if ($pValue->CompetitionCriteriaAdmin()->exists() ) {
                                $lineData = "";
                                $lineSeparator = "";
                                foreach ($pValue->CompetitionCriteriaAdmin() as $CCkey => $CCvalue) {
                                    $lineData .= $lineSeparator . $CCvalue->Title . " - " . $CCvalue->AdminPointsOverrule;

                                    $lineSeparator = " || ";
                                }

                                $fileData  .= $lineData.$separator;

                            } else if ($pValue->myAllBewertungs()->exists()) {
                                $criteriaArray = [];
                                foreach ($pValue->Competition()->CompetitionCriteria() as $CCarraykey => $CCarrayvalue) {
                                    $criteriaArray[$CCarrayvalue->ID] = 0;
                                }
                                $lineData = "";
                                $lineSeparator = "";
                                foreach ($pValue->myAllBewertungs() as $PBkey => $PBvalue) {
                                    foreach ($PBvalue->CompetitionCriteria() as $CCkey => $CCvalue) {
                                        //$lineData .= $lineSeparator . $CCvalue->Title . " - " . $CCvalue->CriteriaPunkte;

                                        //$lineSeparator = " || ";

                                        $criteriaArray[$CCvalue->ID] += $CCvalue->CriteriaPunkte;
                                    }
                                }

                                foreach ($pValue->Competition()->CompetitionCriteria() as $CCarraykey => $CCarrayvalue) {
                                    $lineData .= $lineSeparator . $CCarrayvalue->Title . " - " . $criteriaArray[$CCarrayvalue->ID];

                                    $lineSeparator = " || ";
                                }

                                $fileData  .= $lineData.$separator;
                                //$fileData .= "<br /><br /><br /><br /><br />";
                            } else {
                                $fileData  .= " --- ".$separator;
                            }
                            
                        } else {
                            $lineData = "InnovationsPunkte - ". $pValue->InnovationsPunkte;
                            $lineData .= " || MarktPunkte - ". $pValue->MarktPunkte;
                            $lineData .= " || UmsetzungsrelevanzPunkte - ". $pValue->UmsetzungsrelevanzPunkte;
                            $lineData .= " || WirtschaftsrelevanzPunkte - ". $pValue->WirtschaftsrelevanzPunkte;
                            $lineData .= " || QualitatPunkte - ". $pValue->QualitatPunkte;
                            $fileData  .= $lineData.$separator;
                        }
                        
                    } else if ($value == "JuryPoints" || $value == "AdminPoints") {
                        $fileData .= number_format($pValue->$value, 2, ",", ".").$separator;
                    } else {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->$value ?? ''))).$separator;
                    }
                    
                    
                }
                $fileData .= $newLine;
            }
        }
        
        //echo $fileData;
        //die();

        $now = Date("d-m-Y-H-i");
        $fileName = "export-$now.csv";

        return HTTPRequest::send_file($fileData, $fileName, 'text/csv');
        $this->redirectBack();
    }

    public function exportDoc_old($data, $form) {
        $separator = "#";
        $what = array("–", "Ü", "ü", "Ö", "ö", "Ä", "ä", "ß", ";", "
            ", "
");
        $with = array("-", "UE", "ue", "OE", "oe", "AE", "ae", "ss", " ", " ", " ");

        $myProjects = Project::get()->filter(array("Completed"=>"1"));

        if (isset($data['FilterCompetition']) && $data["FilterCompetition"] != "") {
            $myProjects = $myProjects->filter(array("CompetitionID"=>$data["FilterCompetition"]));
        }

        if (isset($data['FilterKategorie']) && $data["FilterKategorie"] != "") {
            $myProjects = $myProjects->filter(array("KategoriesID"=>$data["FilterKategorie"]));
        }

        if (isset($data['FilterStatus']) && $data["FilterStatus"] != "0") {
            $myProjects = $myProjects->filter(array("Status"=>$data["FilterStatus"]));
        }

        if (isset($data['FilterNominierte']) && $data["FilterNominierte"] != "0") {
            $myProjects = $myProjects->filter(array("Nominierte"=>$data["FilterNominierte"]));
        }

        $fileData = '';

        if (isset($data["ExportFields"])) {
            foreach ($data["ExportFields"] as $key => $value) {
                //echo $value;
                $fileData .= $value.$separator;
                
            }
            $fileData .= "\n";

            foreach ($myProjects as $pKey => $pValue) {
                foreach ($data["ExportFields"] as $key => $value) {
                    if ($value == "Kategorie") {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->Kategories()->Title ?? ''))).$separator;
                    } else {
                        $fileData .= str_replace($what, $with, strip_tags((string)($pValue->$value ?? ''))).$separator;
                    }
                    
                    
                }
                $fileData .= "\n";
            }
        }
        
        //echo $fileData;

        $now = Date("d-m-Y-H-i");
        $fileName = "export-$now.csv";

        return HTTPRequest::send_file($fileData, $fileName, 'text/csv');
        $this->redirectBack();
    }

    public function switchTitle($myKey) {
        $my_fields = array(
            'ProjectNumber' => 'Projektnummer',
            'Anrede' => 'Anrede',
            'AkademischerGrad' => 'Titel vorangestellt',
            'Vorname' => 'Vorname',
            'Nachname' => 'Nachname',
            'AkademischerGradSufix' => 'Titel nachgestellt',

            'TeamteilnehmerInnen' => 'TeamteilnehmerInnen',
            
            'Firma' => 'Firma',
            'Abteilung' => 'Abteilung',
            'Strasse' => 'Straße',
            'PLZ' => 'PLZ',
            'Ort' => 'Ort',
            'Bezirk' => 'Bezirk',
            'Vorwahl' => 'Vorwahl',
            'Telefonnummer' => 'Telefonnummer',
            'Durchwahl' => 'Durchwahl',
            'Email' => 'Email',
            'Website' => 'Website',

            'WettbewerbAufmerksam' => 'WettbewerbAufmerksam',


            /* ideen daten */
            'IdeenTitle' => 'Titel der Idee',
            'Kategorie' => 'Kategorie',
            'KurzBeschreibung' => 'Kurz-Beschreibung',

            'Status' => 'Status',


            'InnovationsPunkte' => 'Kreativität / Neuartigkeit',
            'MarktPunkte' => 'Nutzen',
            'UmsetzungsrelevanzPunkte' => 'Umsetzbarkeit',
            'WirtschaftsrelevanzPunkte' => 'Qualität der Einreichung',
            //'QualitatPunkte' => 'Decimal(9,2)',
            'Bewertung' => 'Bewertung',
            'JuryPoints' => 'Jury-Punkte',
            'JuryPlace' => 'Jury-Platz',
            'AdminPoints' => 'Finale Punkte',
            'AdminPlace' => 'Finale Platzierung',

            'Nominierte' => 'Nominiert',

            'OffiziellerPlatz' => 'Offizieller Platz',

            'AdminKomentar' => 'Admin-Kommentar',
            'Schule' => 'Schule',
            'ProfessorAkademischerGrad' => 'Professor Titel vorangestellt',
            'ProfessorAkademischerGradSufix' => 'Professor Titel nachgestellt',
            'ProfessorVorname' => 'Professor Vorname',
            'ProfessorNachname' => 'Professor Nachname',
            'ProfessorTelefon' => 'Professor Telefon',
            'ProfessorEmail' => 'Professor Email',

            'WarumEinzigartig' => 'Warum sollten Kunden bei Ihnen kaufen, was macht Ihre Idee einzigartig?',
            'IdeeGeschuetzt' => 'Haben Sie die Idee geschützt?', // 0 = Nein, 1 = Ja, 2 = In Planung
            'Schutzart' => 'Schutzart',
            'IdeeRealisiert' => 'Wurde die Idee bereits realisiert?', // 0 = Nein, 1 = Ja
            'Umsetzungsgrad' => 'Umsetzungsgrad',
            'Selbststaendig' => 'Sind Sie selbstständig?', // 0 = Nein, 1 = Ja
            'SelbststaendigSeit' => 'Seit wann sind Sie selbstständig?',
            'Zielgruppen' => 'Zielgruppen',
            'Einnahmequellen' => 'Einnahmequellen',
            'MarktChancenRisiken' => 'Chancen und Risiken',
            'Wachstumsplanung' => 'Wachstumsplanung', // 0 = Nein, 1 = Ja
            'WachstumsplanungDetails' => 'Wie soll dieses Wachstum aussehen?',
            'MehrwertFuerNiederoesterreich' => 'Was ist der Mehrwert Ihrer Idee für Niederösterreich?'


        );

        return $my_fields[$myKey];
    }

}
