<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Control\Email\Email;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use Silverstripe\SiteConfig\SiteConfig;

class Project extends DataObject {

	//private static $default_sort = "ID";

	private static $db = [
		'ProjectNumber' => 'HTMLText',
		'OldProjectNumber' => 'HTMLText',
		'Anrede' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad' => 'Varchar(100)',
		'AkademischerGradSufix' => 'Varchar(100)',
		'Vorname' => 'Varchar(50)',
		'Nachname' => 'Varchar(100)',
		'Firma' => 'Varchar(100)',
		'Abteilung' => 'Varchar(100)',
		'Strasse' => 'Varchar(100)',
		'PLZ' => 'Varchar(10)',
		'Ort' => 'Varchar(100)',
		'Bezirk' => 'Varchar(100)',
		'Vorwahl' => 'Varchar(5)',
		'Telefonnummer' => 'Varchar(20)',
		'Durchwahl' => 'Varchar(5)',
		'Email' => 'Varchar(100)',
		'Website' => 'Varchar(250)',


		/* ideen daten */
		'IdeenTitle' => 'Varchar(100)',
		'Kategorie' => 'Enum("Gewerbe/Dienstleistung, Technologie, Forschung, Schwerpunktthema XYZ", "Gewerbe/Dienstleistung")',
		'KurzBeschreibung' => 'Text',


		/* team members (max 10) */
		'Anrede1' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad1' => 'Varchar(100)',
		'AkademischerGrad1Sufix' => 'Varchar(100)',
		'Vorname1' => 'Varchar(50)',
		'Nachname1' => 'Varchar(100)',

		'Anrede2' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad2' => 'Varchar(100)',
		'AkademischerGrad2Sufix' => 'Varchar(100)',
		'Vorname2' => 'Varchar(50)',
		'Nachname2' => 'Varchar(100)',

		'Anrede3' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad3' => 'Varchar(100)',
		'AkademischerGrad3Sufix' => 'Varchar(100)',
		'Vorname3' => 'Varchar(50)',
		'Nachname3' => 'Varchar(100)',

		'Anrede4' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad4' => 'Varchar(100)',
		'AkademischerGrad4Sufix' => 'Varchar(100)',
		'Vorname4' => 'Varchar(50)',
		'Nachname4' => 'Varchar(100)',

		'Anrede5' => 'Enum("Frau,Herr", "Frau")',
		'AkademischerGrad5' => 'Varchar(100)',
		'AkademischerGrad5Sufix' => 'Varchar(100)',
		'Vorname5' => 'Varchar(50)',
		'Nachname5' => 'Varchar(100)',

		'OtherTeamMembers' => 'Text',
		

		'Status' => 'Enum("geprüft&freigegeben,in Bearbeitung,nicht zugelassen,neu", "neu")',

		'Completed' => 'Boolean',
		'SendEmails' => 'Boolean',
		'SendEmailsJury1' => 'Boolean',
		'SendEmailsJury2' => 'Boolean',
		'SendEmailsAdmin' => 'Boolean',


		'InnovationsPunkte' => 'Decimal(9,2)',
		'MarktPunkte' => 'Decimal(9,2)',
		'UmsetzungsrelevanzPunkte' => 'Decimal(9,2)',
		'WirtschaftsrelevanzPunkte' => 'Decimal(9,2)',
		'QualitatPunkte' => 'Decimal(9,2)',
		'JuryPoints' => 'Decimal(9,2)',
		'JuryPlace' => 'Int',
		'AdminPoints' => 'Decimal(9,2)',
		'AdminPlace' => 'Int',
		'AdminWrited' => 'Boolean',
		'Nominierte' => 'Enum("Ja,Nein", "Nein")',
		'Jurysitzung' => 'Enum("Ja,Nein", "Nein")',
		'Preisgeld1' => 'Varchar(100)',
		'Preisgeld2' => 'Varchar(100)',
		'Preisgeld3' => 'Varchar(100)',
		'OffiziellerPlatz' => 'Int',

		'AdminKomentar' => 'HTMLText',
		'AdminKomentarExt' => 'HTMLText',
		'CompetitionOrder' => 'Int',

		'ActuallInfo' => 'Boolean',

		'WettbewerbAufmerksam' => 'Enum("Empfehlung, Aussendung, Social Media, Universität/(Fach-)Hochschule, Inserat, anderes", "anderes")',


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


	];

	private static $has_one = [
		'Lebenslauf' => File::class,
		'Jury1' => Member::class,
		'Jury2' => Member::class,
		'Jury3' => Member::class,
		'Sponsor1' => Sponsor::class,
		'Sponsor2' => Sponsor::class,
		'Sponsor3' => Sponsor::class,
		'Kategories' => Kategorie::class,
		'Competition' => Competition::class
	];

	private static $has_many = [
		'Document' => Document::class,
		'Bewertung' => Bewertung::class,
		'JuryLink' => JuryLink::class,
		'JuryProjectInfo' => JuryProjectInfo::class
	];

	private static $many_many = [
		'Lebenslaufs' => File::class,
		'Dokumente' => File::class,
		'Urkunden' => File::class,
		'CompetitionCriteriaAdmin' => CompetitionCriteria::class
	];

	private static $many_many_extraFields = [
		'CompetitionCriteriaAdmin' => [
			'AdminPointsOverrule' => 'Decimal(9,2)'
		]
	];

	private static $owns = [
		'Lebenslaufs',
		'Dokumente',
		'Urkunden'
		
	];

	private static $cascade_deletes = [
        'Lebenslaufs',
        'Dokumente',
        'Document',
        'JuryLink',
        'JuryProjectInfo',
		'Urkunden'
    ];


	// included fields for xls export
	private static $included_fields = [
		'ProjectNumber',
		'Vorname',
		'Nachname',
		'Firma',
		'Ort',
		'Bezirk',
		'WettbewerbAufmerksam',
		'IdeenTitle',
		'Kategorie',
		'KurzBeschreibung',
		'Bewertung',
		'JuryPoints',
		'JuryPlace',
		'AdminPoints',
		'AdminPlace',
		'Nominierte',
		'OffiziellerPlatz',
		'AdminKomentar',
		'Lebenslaufs',
		'Dokumente',
		'Urkunden',
	];

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->renameField("SendEmails", "Email sent");

		$fields->removeFieldFromTab("Root", "JuryProjectInfo");
		$fields->removeFieldFromTab("Root", "CompetitionCriteriaAdmin");
		$fields->removeFieldFromTab("Root.Main", "Kategorie");
		$fields->removeFieldFromTab("Root.Main", "OldProjectNumber");
		$fields->removeFieldFromTab("Root.Main", "SendEmailsAdmin");
		$fixRemove = array(
			'Document',
			'JuryLink',
			'AdminKomentarExt',
			'CompetitionID',
			'ActuallInfo'
		);
		$fields->removeFieldsFromTab("Root", $fixRemove);

		// replace integer fields with dropdowns for better readability
		$fields->replaceField('IdeeGeschuetzt', 
			OptionsetField::create('IdeeGeschuetzt', 'Ist Ihre Idee bereits geschützt oder gerade in Planung geschützt zu werden?', 
				['0'=>'Nein', '1'=>'Ja', '2'=>'im Laufen']
			)->addExtraClass('no-grid'),
		);

		$fields->replaceField('IdeeRealisiert', 
			OptionsetField::create('IdeeRealisiert', 'Ist Ihre Idee bereits realisiert?', 
				['1'=>'Ja', '0'=>'Nein']
			)->addExtraClass('no-grid'),
		);

		$fields->replaceField('Selbststaendig', 
			OptionsetField::create('Selbststaendig', 'Sind Sie bereits selbstständig?',
				['1'=>'Ja', '0'=>'Nein']
			)->addExtraClass('no-grid'),
		);

		$fields->replaceField('Wachstumsplanung', 
			OptionsetField::create('Wachstumsplanung', 'Planen Sie mit dem Geschäftsmodell zu wachsen?',
				['1'=>'Ja', '0'=>'Nein']
			)->addExtraClass('no-grid'),
		);

		$removeFields = array(
			'ProjectNumber',
			'OldProjectNumber',
			'Anrede',
			'AkademischerGrad',
			'AkademischerGradSufix',
			'Vorname',
			'Nachname',
			'Firma',
			'Abteilung',
			'Strasse',
			'PLZ',
			'Ort',
			'Bezirk',
			'Vorwahl',
			'Telefonnummer',
			'Durchwahl',
			'Email',


			/* ideen daten */
			'IdeenTitle',
			'Kategorie',
			'KategoriesID',
			'KurzBeschreibung',


			/* team members (max 10) */
			'Anrede1',
			'AkademischerGrad1',
			'AkademischerGrad1Sufix',
			'Vorname1',
			'Nachname1',

			'Anrede2',
			'AkademischerGrad2',
			'AkademischerGrad2Sufix',
			'Vorname2',
			'Nachname2',

			'Anrede3',
			'AkademischerGrad3',
			'AkademischerGrad3Sufix',
			'Vorname3',
			'Nachname3',

			'Anrede4',
			'AkademischerGrad4',
			'AkademischerGrad4Sufix',
			'Vorname4',
			'Nachname4',

			'Anrede5',
			'AkademischerGrad5',
			'AkademischerGrad5Sufix',
			'Vorname5',
			'Nachname5',

			'OtherTeamMembers',

			'Status',

			'Completed',
			'SendEmails',
			'SendEmailsJury1',
			'SendEmailsJury2',

			'JuryPoints',
			'JuryPlace',
			'AdminPoints',
			'AdminPlace',
			'Lebenslauf',
			'Jury1ID',
			'Jury2ID',
			'Jury3ID',
			'Sponsor1ID',
			'Sponsor2ID',
			'Sponsor3ID',
			'InnovationsPunkte',
			'MarktPunkte',
			'UmsetzungsrelevanzPunkte',
			'WirtschaftsrelevanzPunkte',
			'QualitatPunkte',
			'Preisgeld1',
			'Preisgeld2',
			'Preisgeld3',
			'OffiziellerPlatz',
			'AdminWrited',
			'CompetitionOrder',
			'AdminKomentar'
		);


		if (strpos($_SERVER['REQUEST_URI'],'auswertungen') !== false || strpos($_SERVER['REQUEST_URI'],'jurysitzung') !== false) {
			
			$fields->removeFieldsFromTab("Root", $removeFields);
			$fields->removeFieldFromTab("Root", "Dokumente");
			$fields->removeFieldFromTab("Root", "Lebenslaufs");
			$fields->removeFieldFromTab("Root", "Urkunden");
			//$fields->removeFieldFromTab("Root.Main", array("Jurysitzung", "AdminWrited"));


			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<h3>Projekt: ".$this->IdeenTitle."</h3>"));

			$jury1Bewertung = $this->bewertungByJury($this->Jury1ID);
			$jury2Bewertung = $this->bewertungByJury($this->Jury2ID);
			$jury3Bewertung = $this->bewertungByJury($this->Jury3ID);

			//$fields->addFieldToTab("Root.Main", new LiteralField("table", " <table border='1'><tr><td width='200'>Kriterium</td><td width='50'>".$this->Jury1()->Kuerzel."&nbsp;".$this->juryStatusFlag("Jury1ID")."&nbsp;&nbsp;&nbsp;</td><td width='50'>".$this->Jury2()->Kuerzel."&nbsp;".$this->juryStatusFlag("Jury2ID")."&nbsp;&nbsp;&nbsp;</td><td width='50'>".$this->Jury3()->Kuerzel."&nbsp;".$this->juryStatusFlag("Jury3ID")."&nbsp;&nbsp;&nbsp;</td><td  width='80'>Durchschn. Punkte</td><td width='80' align='right'>Finale Punkte</td></tr>"));

			$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = 0;

			$fields->addFieldToTab("Root.Main", new LiteralField("table", " <table border='1'><tr><td width='200'>Kriterium</td>"));

			if ($this->Jury1ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("table", "<td width='50'>".$this->Jury1()->generatedKurzel()."&nbsp;".$this->juryStatusFlag("Jury1ID")."&nbsp;&nbsp;&nbsp;</td>"));
			}

			if ($this->Jury2ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("table", "<td width='50'>".$this->Jury2()->generatedKurzel()."&nbsp;".$this->juryStatusFlag("Jury2ID")."&nbsp;&nbsp;&nbsp;</td>"));
			}

			if ($this->Jury3ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("table", "<td width='50'>".$this->Jury3()->generatedKurzel()."&nbsp;".$this->juryStatusFlag("Jury3ID")."&nbsp;&nbsp;&nbsp;</td>"));
			}

			$fields->addFieldToTab("Root.Main", new LiteralField("table", "<td  width='80'>Durchschn. Punkte</td><td width='150' align='right'>Finale Punkte</td></tr>"));

			$myCompetition = Competition::get()->filter(array("Active"=>"1"));
			if ($myCompetition->exists() ) {
				$myCompetitionCriteria = $myCompetition->First()->CompetitionCriteria();

				foreach ($myCompetitionCriteria as $key => $value) {
					//$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<tr><td><strong>".$value->Title."</strong></td><td>J1</td><td>J2</td><td>J3</td><td>AVG</td><td>"));
					$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<tr><td><strong>".$value->Title."</strong></td>"));

					$actCriteriaPoints = 0;

					if ($this->Jury1ID > 0) {
						$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($jury1Bewertung[$value->ID], 2, '.', '')."</td>"));
						$actCriteriaPoints = $actCriteriaPoints + $jury1Bewertung[$value->ID];

						$sum1 = $sum1 + $jury1Bewertung[$value->ID];
					}

					if ($this->Jury2ID > 0) {
						$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($jury2Bewertung[$value->ID], 2, '.', '')."</td>"));
						$actCriteriaPoints = $actCriteriaPoints + $jury2Bewertung[$value->ID];

						$sum2 = $sum2 + $jury2Bewertung[$value->ID];
					}

					if ($this->Jury3ID > 0) {
						$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($jury3Bewertung[$value->ID], 2, '.', '')."</td>"));
						$actCriteriaPoints = $actCriteriaPoints + $jury3Bewertung[$value->ID];

						$sum3 = $sum3 + $jury3Bewertung[$value->ID];
					}

					$sum4 = $sum4 + $actCriteriaPoints/$this->juryMemberCount();

					$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($actCriteriaPoints/$this->juryMemberCount(), 2, '.', '')."</td>"));
					

					$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>"));
					//$fields->addFieldToTab("Root.Main", new TextField("UmsetzungsrelevanzPunkte", " "));
					

					$criteriaAdminPoints = $actCriteriaPoints/$this->juryMemberCount();
					if ($this->CompetitionCriteriaAdmin()->filter("ID", $value->ID)->exists()) {
						if ($this->CompetitionCriteriaAdmin()->filter("ID", $value->ID)->First()->AdminPointsOverrule != "") {
							$criteriaAdminPoints = $this->CompetitionCriteriaAdmin()->filter("ID", $value->ID)->First()->AdminPointsOverrule;
						}
					}

					$sum5 = $sum5 + $criteriaAdminPoints;

					$myFieldName = "CompetitionCriteriaAdminField_".$value->ID;
					if ($this->AdminWrited == 1) {
						$fields->addFieldToTab("Root.Main", new TextField($myFieldName, " ", $criteriaAdminPoints));
					} else {
						$fields->addFieldToTab("Root.Main", new TextField($myFieldName, " ", $criteriaAdminPoints));
					}


					$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "</td></tr>"));
				}
			}

			$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<tr><td><strong>SUMME</strong></td>"));

			if ($this->Jury1ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($sum1, 2, '.', '')."</td>"));
			}

			if ($this->Jury2ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($sum2, 2, '.', '')."</td>"));
			}

			if ($this->Jury3ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($sum3, 2, '.', '')."</td>"));
			}

			$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "<td align='right'>".number_format($sum4, 2, '.', '')."</td><td align='right'>".number_format($sum5, 2, '.', '')."</td>"));

			$fields->addFieldToTab("Root.Main", new LiteralField("tablerow", "</tr>"));


			$fields->addFieldToTab("Root.Main", new LiteralField("table", "</table>"));

			$fields->addFieldToTab("Root.Main", new HiddenField("AdminWrited1", "ADMIN Overule", "1"));
			
			//$fields->addFieldToTab("Root.Main", new TextareaField("AdminKomentar"));




			/* preview project details in CMS
			----------------------------------*/
			$fields->addFieldToTab("Root.Details", new LiteralField("projectdetails", '
				<style>
					.previewFieldBox {
						margin-bottom: 10px;
						clear: both;
						float: left;
						width: 100%;
					}

					.previewFieldBox .title {
						float: left;
						width: 250px; 
					}

					.previewFieldBox div:nth-child(2) {
						float: left;
						width: 350px;
					}
				</style>
				<h2 class="marginTop30">Pers&ouml;nliche Daten</h2>
				<div class="previewFieldBox">
					<div class="title left">
						Anrede
					</div>
					<div>
						<strong>'.$this->Anrede.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Titel vorangestellt
					</div>
					<div>
						<strong>'.$this->AkademischerGrad.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Vorname
					</div>
					<div>
						<strong>'.$this->Vorname.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Nachname
					</div>
					<div>
						<strong>'.$this->Nachname.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Titel nachgestellt
					</div>
					<div>
						<strong>'.$this->AkademischerGradSufix.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Firma
					</div>
					<div>
						<strong>'.$this->Firma.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Abteilung
					</div>
					<div>
						<strong>'.$this->Abteilung.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Stra&szlig;e
					</div>
					<div>
						<strong>'.$this->Strasse.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Postleitzahl
					</div>
					<div>
						<strong>'.$this->PLZ.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Ort
					</div>
					<div>
						<strong>'.$this->Ort.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Bezirk
					</div>
					<div>
						<strong>'.$this->bezirkName($this->Bezirk).'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Telephone
					</div>
					<div>
						<strong>'.$this->Vorwahl." ". $this->Telefonnummer." ". $this->Durchwahl.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						E-Mail
					</div>
					<div>
						<strong>'.$this->Email.'</strong>
					</div>
					<div class="clear"></div>
				</div>

				<h2 class="marginTop30">Ideen Daten</h2>
				<div class="previewFieldBox">
					<div class="title">
						Titel der Idee
					</div>
					<div>
						<strong>'.$this->IdeenTitle.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Kategorie
					</div>
					<div>
						<strong>'.$this->Kategories()->Title.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				<div class="previewFieldBox">
					<div class="title">
						Ideen-Kurz-Beschreibung
					</div>
					<div>
						<strong>'.$this->KurzBeschreibung.'</strong>
					</div>
					<div class="clear"></div>
				</div>
				

			'));

			if ($this->Lebenslaufs()->count() > 0) {
				$fields->addFieldToTab("Root.Details", new LiteralField("llpart", '<div class="previewFieldBox">
					<div class="title">
						Lebenslauf
					</div>
					<div>' ));

				foreach ($this->Lebenslaufs() as $key => $value) {
					$fields->addFieldToTab("Root.Details", new LiteralField("continue", '
						<a href="'.$value->URL.'" target="_blank" >> '.$value->Name.'</a><br />
					'));
				}

				$fields->addFieldToTab("Root.Details", new LiteralField("llpart", '</div>
					<div class="clear"></div>
				</div>'));
			} else {
				$fields->addFieldToTab("Root.Details", new LiteralField("llpart", '<div class="previewFieldBox">
					<div class="title">
						Lebenslauf
					</div>
					<div>
						<a href="'.$this->Lebenslauf()->URL.'" target="_blank" >> '.$this->Lebenslauf()->Name.'</a>
					</div>
					<div class="clear"></div>
				</div>'));
			}

			if ($this->Urkunden()->count() > 0) {
				$fields->addFieldToTab("Root.Details", new LiteralField("llpart", '<div class="previewFieldBox">
					<div class="title">
						Urkunden
					</div>
					<div>' ));

				foreach ($this->Urkunden() as $key => $value) {
					$fields->addFieldToTab("Root.Details", new LiteralField("continue", '
						<a href="'.$value->URL.'" target="_blank" >> '.$value->Name.'</a><br />
					'));
				}

				$fields->addFieldToTab("Root.Details", new LiteralField("llpart", '</div>
					<div class="clear"></div>
				</div>'));
			}
			
			$fields->addFieldToTab("Root.Details", new LiteralField("continue", '
				<div class="previewFieldBox">
					<div class="title">
						Dateien
					</div>
					<div>
			'));

			foreach ($this->Dokumente() as $key => $value) {
				$fields->addFieldToTab("Root.Details", new LiteralField("continue", '
					<a href="'.$value->URL.'" target="_blank" >> '.$value->Name.'</a><br />
				'));
			}

			$fields->addFieldToTab("Root.Details", new LiteralField("continue", '
					</div>
					<div class="clear"></div>
				</div>
			'));



			if ($this->Jury1ID > 0) {
				$myBew = Bewertung::get()->where("JuryID='".$this->Jury1ID."' AND ProjectID='".$this->ID."'");
				if ($myBew->exists()) {
					//$fields->addFieldToTab("Root.".$this->Jury1()->Kuerzel, new LiteralField("continue", '');
					$myBew = $myBew->first();
					if ($myBew->CompetitionCriteria()->exists()) {
						foreach ($myBew->CompetitionCriteria() as $key => $value) {
							$fields->addFieldToTab("Root.".$this->Jury1()->generatedKurzel(), new LiteralField("continue", '
									<div class="previewFieldBox">
										<div class="title">
											'.$value->Title.' <br />Bewertung: <strong>'.$value->CriteriaPunkte.'</strong>
										</div>
										<div>
											<strong>'.$value->CriteriaKommentar.'</strong>
										</div>
										<div class="clear"></div>
									</div>
								')
							);
						}
					}
					$fields->addFieldToTab("Root.".$this->Jury1()->generatedKurzel(), new LiteralField("continue", '
						<div class="previewFieldBox">
							<div class="title">
								Kommentar zu Projektbezug Niederösterreich
							</div>
							<div>
								<strong>'.$myBew->ProjektbezugKommentar.'</strong>
							</div>
							<div class="clear"></div>
						</div>
						<div class="previewFieldBox">
							<div class="title">
								Gesamtkommentar
							</div>
							<div>
								<strong>'.$myBew->GesamtKommentar.'</strong>
							</div>
							<div class="clear"></div>
						</div>
					'));
				}
			}



			if ($this->Jury2ID > 0) {
				$myBew = Bewertung::get()->where("JuryID='".$this->Jury2ID."' AND ProjectID='".$this->ID."'");
				if ($myBew->exists()) {
					$myBew = $myBew->first();
					if ($myBew->CompetitionCriteria()->exists()) {
						foreach ($myBew->CompetitionCriteria() as $key => $value) {
							$fields->addFieldToTab("Root.".$this->Jury2()->generatedKurzel(), new LiteralField("continue", '
									<div class="previewFieldBox">
										<div class="title">
											'.$value->Title.' <br />Bewertung: <strong>'.$value->CriteriaPunkte.'</strong>
										</div>
										<div>
											<strong>'.$value->CriteriaKommentar.'</strong>
										</div>
										<div class="clear"></div>
									</div>
								')
							);
						}
					}
					$fields->addFieldToTab("Root.".$this->Jury2()->generatedKurzel(), new LiteralField("continue", '
						<div class="previewFieldBox">
							<div class="title">
								Kommentar zu Projektbezug Niederösterreich
							</div>
							<div>
								<strong>'.$myBew->ProjektbezugKommentar.'</strong>
							</div>
							<div class="clear"></div>
						</div>
						<div class="previewFieldBox">
							<div class="title">
								Gesamtkommentar
							</div>
							<div>
								<strong>'.$myBew->GesamtKommentar.'</strong>
							</div>
							<div class="clear"></div>
						</div>
					'));
				}
			}

			$fields->addFieldToTab("Root.AdminKommentar", new TextareaField("AdminKomentarExt", "Externer Admin Kommentar"));


		} else if (strpos($_SERVER['REQUEST_URI'],'nominierte') !== false) {


			$fields->removeFieldsFromTab("Root", $removeFields);
			$fields->removeFieldFromTab("Root", "Dokumente");
			//$fields->removeFieldFromTab("Root.Main", "AdminKomentar");
			$fields->removeFieldFromTab("Root.Main", array("Nominierte", "AdminWrited", "Jurysitzung"));

			$sponsors = Sponsor::get();

			$fields->addFieldToTab("Root.Main", new LiteralField("table", "<table border='1'><tr><td width='200'><h4>Sponsor</h4></td><td width='150'><h4>Preisgeld gesamt</h4></td><td width='150'><h4>Preisgeld vergeben</h4></td><td width='150'><h4>Preisgeld offen</h4></td></tr>"));
			foreach ($sponsors as $key => $value) {
				if ($value->PreisgeldOffen() < 0) {
					$PreisgeldOffen = "<span style='color: red; font-weight: bold;'>".$value->PreisgeldOffen()."</span>";
				} else {
					$PreisgeldOffen = $value->PreisgeldOffen();
				}
				$fields->addFieldToTab("Root.Main", new LiteralField("table", "<tr><td width='200'>".$value->Firma."</td><td width='120'>".$value->Preisgeld."</td><td width='120'>".$value->PreisgeldVergeben()."</td><td width='120' align='right'>".$PreisgeldOffen."</td></tr>"));
			}
			$fields->addFieldToTab("Root.Main", field: new LiteralField("table", "</table><hr />"));

			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<h3>Projekt: ".$this->IdeenTitle."</h3>"));
			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<h4>Kategorie: ".$this->Kategories()->Title."</h4>"));
			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<hr><h4>Sponsor 1</h4>"));
			$fields->addFieldToTab("Root.Main", $sponsor1 = new DropdownField("Sponsor1ID", "Sponsor", $sponsors->map("ID", "Firma")));
			$sponsor1->setEmptyString('(Select one)');
			$fields->addFieldToTab("Root.Main", new TextField("Preisgeld1", "Preisgeld"));

			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<hr><h4>Sponsor 2</h4>"));
			$fields->addFieldToTab("Root.Main", $sponsor2 = new DropdownField("Sponsor2ID", "Sponsor", $sponsors->map("ID", "Firma")));
			$sponsor2->setEmptyString('(Select one)');
			$fields->addFieldToTab("Root.Main", new TextField("Preisgeld2", "Preisgeld"));

			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<hr><h4>Sponsor 3</h4>"));
			$fields->addFieldToTab("Root.Main", $sponsor3 = new DropdownField("Sponsor3ID", "Sponsor", $sponsors->map("ID", "Firma")));
			$sponsor3->setEmptyString('(Select one)');
			$fields->addFieldToTab("Root.Main", new TextField("Preisgeld3", "Preisgeld"));

			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<hr>"));
			$fields->addFieldToTab("Root.Main", new LiteralField("title", "<h3>Finale Platzierung: ".$this->AdminPlace."</h3>"));
			/*if ($this->OffiziellerPlatz == 0) {
				$this->OffiziellerPlatz = $this->AdminPlace;
			}*/
			$fields->addFieldToTab("Root.Main", new TextField("OffiziellerPlatz", "Offizieller Platz"));


		} else {

			if ($this->ID > 0) {
				$fields->addFieldToTab("Root.Main", new LiteralField("detailsLink", "<div><a href='home/projectDetailsAdmin/".$this->ID."' target='_blank'>Projektdetails drucken</a></div>"), "Anrede");
			}

			$sizeMB = 10; // 2 MB
			$sizeUpload = $sizeMB * 1024 * 1024; // 2 MB in bytes

			$fields->removeFieldFromTab("Root", "ProjectNumber");
			$fields->removeFieldFromTab("Root", "Dokumente");
			$fields->addFieldToTab("Root.Dateien", $DokumenteField = new UploadField("Dokumente"));
			$DokumenteField->getValidator()->setAllowedMaxFileSize($sizeUpload);

			$myHtmlDoc = "";
			foreach ($this->Dokumente() as $key => $value) {
				$myHtmlDoc .= '<div class="documentBlock">
					<a href="'.$value->URL.'" target="_blank">'.$value->Name.'</a>
					<div >
						'.$value->Description.'
					</div>
				</div>';
			}
			$fields->addFieldToTab("Root.Dateien", LiteralField::create("juryDoc", $myHtmlDoc));

			$fields->removeFieldFromTab("Root", "Lebenslaufs");
			$fields->addFieldToTab("Root.Lebenslauf", $LebenslaufsField = new UploadField("Lebenslaufs"));
			$LebenslaufsField->getValidator()->setAllowedMaxFileSize($sizeUpload);

			$myHtmlDoc = "";
			foreach ($this->Lebenslaufs() as $key => $value) {
				$myHtmlDoc .= '<div class="documentBlock">
					<a href="'.$value->URL.'" target="_blank">'.$value->Name.'</a>
					<div >
						'.$value->Description.'
					</div>
				</div>';
			}
			$fields->addFieldToTab("Root.Lebenslauf", LiteralField::create("juryDoc", $myHtmlDoc));

			$fields->removeFieldFromTab("Root", "Urkunden");
			$fields->addFieldToTab("Root.Urkunden", $UrkundenField = new UploadField("Urkunden"));
			$UrkundenField->getValidator()->setAllowedMaxFileSize($sizeUpload);

			$myHtmlDoc = "";
			foreach ($this->Urkunden() as $key => $value) {
				$myHtmlDoc .= '<div class="documentBlock">
					<a href="'.$value->URL.'" target="_blank">'.$value->Name.'</a>
					<div >
						'.$value->Description.'
					</div>
				</div>';
			}
			$fields->addFieldToTab("Root.Urkunden", LiteralField::create("juryDoc", $myHtmlDoc));

			//$fields->removeFieldFromTab("Root.Jury", "Jury");
			$juryMembers = Member::get()->innerJoin("Group_Members", "Group_Members.MemberID=Member.ID AND GroupID='3'")->sort("FirstName, Surname");
			//$fields->addFieldToTab("Root.Jury", new CheckboxSetField("Jury", "Juroren zuordnen", $juryMembers));

			if ($this->Status == "geprüft&freigegeben") {

				$fields->addFieldsToTab("Root.Jury", [
					DropdownField::create("Jury1ID", "Juror 1", $juryMembers->map())->setEmptyString('(Select one)'),
					CheckboxField::create("SendEmailsJury1", "Email sent Juror 1"),
					DropdownField::create("Jury2ID", "Juror 2", $juryMembers->map())->setEmptyString('(Select one)'),
					CheckboxField::create("SendEmailsJury2", "Email sent Juror 2")
					//SendEmailsJury1
				]);

				//$fields->addFieldToTab("Root.Jury", DropdownField::create("Jury1ID", "Juror 1", $juryMembers->map())->setEmptyString('(Select one)'));
				//$fields->addFieldToTab("Root.Jury", DropdownField::create("Jury2ID", "Juror 2", $juryMembers->map())->setEmptyString('(Select one)'));
				//$fields->addFieldToTab("Root.Jury", DropdownField::create("Jury3ID", "Juror 3", $juryMembers->map())->setEmptyString('(Select one)'));
			} else {
				$fields->removeFieldFromTab("Root.Main", "Jury1ID");
				$fields->removeFieldFromTab("Root.Main", "Jury2ID");
				$fields->removeFieldFromTab("Root.Main", "Jury3ID");

			}

			$myHtmlDoc = "<h3>Documents</h3>";
			foreach ($this->Document() as $key => $value) {
				$myHtmlDoc .= '<div class="documentBlock">
					<a href="'.$value->URL.'" target="_blank">'.$value->Name.'</a>
					<div >
						'.$value->Description.'
					</div>
				</div>';
			}
			$fields->addFieldToTab("Root.Recherchedokumente", LiteralField::create("juryDoc", $myHtmlDoc));

			$myHtmlDoc = "<hr><h3>Links</h3>";
			foreach ($this->JuryLink() as $key => $value) {
				$myHtmlDoc .= '<div class="documentBlock">
					<a href="'.$value->URL.'" target="_blank">'.$value->Title.'</a>
					<div >
						'.$value->Description.'
					</div>
				</div>';
			}
			$fields->addFieldToTab("Root.Recherchedokumente", LiteralField::create("juryDoc", $myHtmlDoc));


			$fields->removeFieldFromTab("Root.Main", "InnovationsPunkte");
			$fields->removeFieldFromTab("Root.Main", "MarktPunkte");
			$fields->removeFieldFromTab("Root.Main", "UmsetzungsrelevanzPunkte");
			$fields->removeFieldFromTab("Root.Main", "WirtschaftsrelevanzPunkte");
			$fields->removeFieldFromTab("Root.Main", "QualitatPunkte");
			$fields->removeFieldFromTab("Root.Main", "AdminWrited");
			$fields->removeFieldFromTab("Root.Main", "Nominierte");

			$fields->removeFieldFromTab("Root.Main", "Sponsor1ID");
			$fields->removeFieldFromTab("Root.Main", "Sponsor2ID");
			$fields->removeFieldFromTab("Root.Main", "Sponsor3ID");
			$fields->removeFieldFromTab("Root.Main", "Preisgeld1");
			$fields->removeFieldFromTab("Root.Main", "Preisgeld2");
			$fields->removeFieldFromTab("Root.Main", "Preisgeld3");
			$fields->removeFieldFromTab("Root.Main", "OffiziellerPlatz");

			$fields->addFieldToTab("Root.Main", new TextareaField("AdminKomentar", "Interner Admin Kommentar"));
			$fields->addFieldToTab("Root.Main", new TextareaField("AdminKomentarExt", "Externer Admin Kommentar"));


			$fields->addFieldToTab("Root.Unfinished", new CheckboxField("Completed", "Switch to projects") );

			$myActive = 0;
			$myCompetition = Competition::get()->filter(array("Active"=>"1"));
			if ($myCompetition->exists() ) {
				$myActive = $myCompetition->First()->ID;
			}
			$fields->addFieldToTab("Root.Wettbewerb", new DropdownField("CompetitionID", "Competition", Competition::get()->map(), $myActive ) );

			$fields->addFieldToTab("Root.Main", DropdownField::create("Bezirk", "Bezirk", $this->BezirkArray()), "Vorwahl");

			/* akademischer Grad to Titel vor- nachangestellt */
			//if ($this->AkademischerGrad != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad", "Titel vorangestellt"), "Vorname");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad");
			//}

			//if ($this->AkademischerGradSufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGradSufix", "Titel nachangestellt"), "Firma");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGradSufix");
			//}

			//if ($this->AkademischerGrad1 != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad1", "Titel vorangestellt 1"), "Vorname1");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad1");
			//}

			//if ($this->AkademischerGrad1Sufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad1Sufix", "Titel nachangestellt 1"), "Anrede2");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad1Sufix");
			//}

			//if ($this->AkademischerGrad2 != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad2", "Titel vorangestellt 2"), "Vorname2");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad2");
			//}

			//if ($this->AkademischerGrad2Sufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad2Sufix", "Titel nachangestellt 2"), "Anrede3");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad2Sufix");
			//}

			//if ($this->AkademischerGrad3 != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad3", "Titel vorangestellt 3"), "Vorname3");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad3");
			//}

			//if ($this->AkademischerGrad3Sufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad3Sufix", "Titel nachangestellt 3"), "Anrede4");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad3Sufix");
			//}

			//if ($this->AkademischerGrad4 != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad4", "Titel vorangestellt 4"), "Vorname4");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad4");
			//}

			//if ($this->AkademischerGrad4Sufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad4Sufix", "Titel nachangestellt 4"), "Anrede5");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad4Sufix");
			//}

			//if ($this->AkademischerGrad5 != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad5", "Titel vorangestellt 5"), "Vorname5");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad5");
			//}

			//if ($this->AkademischerGrad5Sufix != "") {
				$fields->addFieldToTab("Root.Main", TextField::create("AkademischerGrad5Sufix", "Titel nachangestellt 5"), "OtherTeamMembers");
			//} else {
				//$fields->removeFieldFromTab("Root.Main", "AkademischerGrad5Sufix");
			//}

			if ($this->Vorname1 == "" && $this->Nachname1 == "") {
				$removeFields1 = ["Anrede1", "Vorname1", "Nachname1", "AkademischerGrad1", "AkademischerGrad1Sufix"];
				//$fields->removeFieldsFromTab("Root", $removeFields1);
			}

			if ($this->Vorname2 == "" && $this->Nachname2 == "") {
				$removeFields2 = ["Anrede2", "Vorname2", "Nachname2", "AkademischerGrad2", "AkademischerGrad2Sufix"];
				//$fields->removeFieldsFromTab("Root", $removeFields2);
			}

			if ($this->Vorname3 == "" && $this->Nachname3 == "") {
				$removeFields3 = ["Anrede3", "Vorname3", "Nachname3", "AkademischerGrad3", "AkademischerGrad3Sufix"];
				//$fields->removeFieldsFromTab("Root", $removeFields3);
			}

			if ($this->Vorname4 == "" && $this->Nachname4 == "") {
				$removeFields4 = ["Anrede4", "Vorname4", "Nachname4", "AkademischerGrad4", "AkademischerGrad4Sufix"];
				//$fields->removeFieldsFromTab("Root", $removeFields4);
			}

			if ($this->Vorname5 == "" && $this->Nachname5 == "") {
				$removeFields5 = ["Anrede5", "Vorname5", "Nachname5", "AkademischerGrad5", "AkademischerGrad5Sufix"];
				//$fields->removeFieldsFromTab("Root", $removeFields5);
			}

			if ($this->OtherTeamMembers == "") {
				$removeFieldsOther = ["OtherTeamMembers"];
				//$fields->removeFieldsFromTab("Root", $removeFieldsOther);
			} else {
				$fields->addFieldToTab("Root.Main", TextareaField::create("OtherTeamMembers", "Alle weiteren Teammitglieder anführen"), "Status");
			}

			/* renaming the fields */
			$fields->renameField("Strasse", "Straße, Hausnummer");
			$fields->renameField("PLZ", "Postleitzahl");
			$fields->renameField("IdeenTitle", "Titel der Idee");
			$fields->renameField("KurzBeschreibung", "Ideen-Kurz-Beschreibung");

		}

		$fields->renameField("Telefonnummer", "Telefon");
		$fields->renameField("OtherTeamMembers", "Weitere Teammitglieder");
		$fields->renameField("JuryPoints", "Jury Punkte");
		$fields->renameField("JuryPlace", "Jury Platz");
		$fields->renameField("AdminPoints", "Admin Punke");
		$fields->renameField("AdminPlace", "Admin Platz");
		$fields->renameField("KategoriesID", "Kategorien");
		$fields->renameField("InternesAdminKommentar", "Interner Admin Kommentar");
		$fields->renameField("Files", "Dateien");
		$fields->renameField("Competition", "Wettbewerb");

		$fields->removeFieldFromTab("Root.Main", "Completed");
		$fields->removeFieldFromTab("Root.Main", "Jury3ID");
		$fields->removeFieldFromTab("Root.Main", "Jury3");
		$fields->removeFieldFromTab("Root.Main", "CompetitionOrder");

		$fields->removeFieldFromTab("Root.Main", "Vorwahl");
		$fields->removeFieldFromTab("Root.Main", "Durchwahl");
		//$fields->addFieldToTab("Root.ProjectNR", TextField::create("ProjectNumber"));

		return $fields;
	}

	/*private static $CSVExportFields = array(
		'CustomProjectNumber' => 'Proj. nr.',
		'Created.Nice' => 'Einreichung',
		'IdeenTitle' => 'Projekttitel',
		'KurzBeschreibung' => 'Projektbeschreibung',
		'AdminKomentar' => 'AdminKomentar',
		'myFullName' => 'Name',
		'PLZ' => 'PLZ',
		'Firma' => 'Firma',
		'projectStatusIcon' => '*',
		'juryStatus' => 'Juroren (Status)'
	);*/


	public function myKurzBeschreibung() {
		$what = array("\n", "\r");
		$with = array(" ", " ");
		$where = strip_tags((string)($this->KurzBeschreibung ?? ''));

		return str_replace($what, $with, $where);
	}

	private static $summary_fields = array(
		'CustomProjectNumber' => 'Proj. nr.',
		'Created.Nice' => 'Einreichung',
		'IdeenTitle' => 'Projekttitel',
		'KurzBeschreibung' => 'Projektbeschreibung',
		'AdminKomentar' => 'AdminKomentar',
		'myFullName' => 'Name',
		'PLZ' => 'PLZ',
		'Firma' => 'Firma',
		'projectStatusIcon' => '*',
		'juryStatus' => 'Juroren (Status)'
		
	);

	private static $searchable_fields = array(
		"Vorname" => array(
	        "field" => TextField::class,
	        "filter" => "PartialMatchFilter", //"projectSearchFilter",
	        "title" => 'Vorname'
	    ),
	    "Nachname" => array(
	        "field" => TextField::class,
	        "filter" => "PartialMatchFilter", //"projectSearchFilter",
	        "title" => 'Nachname'
	    ),
	    "IdeenTitle" => array(
	        "field" => TextField::class,
	        "filter" => "PartialMatchFilter", //"projectSearchFilter",
	        "title" => 'Projekt Titel'
	    ),
		"KategoriesID" => array(
	        "filter" => "ExactMatchFilter",
	        "title" => 'Kategorie'
	    ),
		"Status" => array(
	        "filter" => "ExactMatchFilter",
	        "title" => 'Status'
	    )
	);

	public static $AuswertungensummaryFields = array(
		'ProjectNumber' => 'Pr. nr.',
		'IdeenTitle' => 'Projekttitel',
		'Nominierte' => 'Nominierte',
		'myFullName' => 'Name',
		'Firma' => 'Firma',
		'Kategories.Title' => 'Kategorie',
		'getJuryStatus' => 'Juror 1',
		'getJuryStatus2' => 'Juror 2',
		/*'getJuryStatus3' => 'Juror 3',*/
		'JuryPoints' => 'Vorl. Punk',
		'JuryPlace' => 'Vorl. Platz',
		'AdminPoints' => 'Fin. Punkte',
		'AdminPlace' => 'Fin. Platz',
		'KurzBeschreibung' => 'Projektbeschreibung'
	);

	public static $NominatedAuswertungensummaryFields = array(
		'ProjectNumber' => 'Pr. nr.',
		'IdeenTitle' => 'Projekttitel',
		'Nominierte' => 'Nominierte',
		'myFullName' => 'Name',
		'Firma' => 'Firma',
		'Kategories.Title' => 'Kategorie',
		'getJuryStatus' => 'Juror 1',
		'getJuryStatus2' => 'Juror 2',
		/*'getJuryStatus3' => 'Juror 3',*/
		'JuryPoints' => 'Vorl. Punk',
		'JuryPlace' => 'Vorl. Platz',
		'AdminPoints' => 'Fin. Punkte',
		'AdminPlace' => 'Fin. Platz',
		'KurzBeschreibung' => 'Projektbeschreibung'
	);

	public static $NominiertesummaryFields = array(
		'ProjectNumber' => 'Pr. nr.',
		'IdeenTitle' => 'Projekttitel',
		'Kategories.Title' => 'Kategorie',
		'Sponsor1.Firma' => 'Sponsor 1',
		'Preisgeld1' => 'Preisgeld',
		'Sponsor2.Firma' => 'Sponsor 2',
		'Preisgeld2' => 'Preisgeld',
		'Sponsor3.Firma' => 'Sponsor 3',
		'Preisgeld3' => 'Preisgeld',
		'AdminPlace' => 'Finale Platzierung',
		'OffiziellerPlatz' => 'Offizieller Platz'

	);


	function onBeforeWrite() {
		parent::onBeforeWrite();

		if (isset($this->AdminWrited1)) {
			$this->AdminWrited = 1;
		}

		$myAdminPoints = 0;

		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
		if ($myCompetition->exists() ) {
			$myCompetitionCriteria = $myCompetition->First()->CompetitionCriteria();
			foreach ($myCompetitionCriteria as $key => $value) {
			
				$myFieldName = "CompetitionCriteriaAdminField_".$value->ID;
				
				if (isset($this->$myFieldName)) {
					$this->CompetitionCriteriaAdmin()->add($value, ['AdminPointsOverrule' => $this->$myFieldName]);

					$myAdminPoints = $myAdminPoints + $this->$myFieldName;
				}
			}
		}
		

		if ($this->Sponsor1ID == 0) {
			$this->Preisgeld1 = '';
		}

		if ($this->Sponsor2ID == 0) {
			$this->Preisgeld2 = '';
		}

		if ($this->Sponsor3ID == 0) {
			$this->Preisgeld3 = '';
		}

		if ($this->AdminWrited == 1) {
			//$this->AdminPoints = $this->InnovationsPunkte+$this->MarktPunkte+$this->UmsetzungsrelevanzPunkte+$this->WirtschaftsrelevanzPunkte+$this->QualitatPunkte;
			$this->AdminPoints = $myAdminPoints;
		}
		

		if ($this->Status == "geprüft&freigegeben" && ($this->Jury1ID>0 || $this->Jury2ID>0 || $this->Jury3ID>0)){

			$config = SiteConfig::current_site_config(); 

			$email = new Email();
			 
	        $email->setFrom("genius@riz-up.at"); 
	        $email->setSubject($config->JuryNewProjectTitle); 
	        $messageBody = str_replace("{PROJECT_TITLE}", (string)($this->IdeenTitle ?? ''), (string)($config->JuryNewProject ?? ''));
	        $messageBody = str_replace("{PROJECT_STATUS}", (string)($this->Status ?? ''), $messageBody);
	        $messageBody = str_replace("{PROJECT_NUMBER}", (string)($this->ProjectNumber ?? ''), $messageBody);
		    
	        
			if ($this->Jury1ID > 0 && $this->SendEmailsJury1 == "0") {
				
		        $email->setTo($this->Jury1()->Email);
		        //$email->setTo("kalakotra@gmail.com");
				$messageBody1 = str_replace("{JURY_NAME}", (string)($this->Jury1()->FirstName ?? ''), $messageBody);
				$email->setBody($messageBody1);
		        $email->send();
			}

			if ($this->Jury2ID > 0 && $this->SendEmailsJury2 == "0") {
				$email->setTo($this->Jury2()->Email);
				//$email->setTo("kalakotra@gmail.com");
				$messageBody2 = str_replace("{JURY_NAME}", (string)($this->Jury2()->FirstName ?? ''), $messageBody);
				$email->setBody($messageBody2);
		        $email->send();
			}

			/*if ($this->Jury3ID != "0") {
				//$email->setTo($this->Jury3()->Email);
		        //$email->send();
			}*/

			//$email->setBody("ProjectID:".$this->ID."<br><br>".$messageBody);
			//$email->setTo("kalakotra@gmail.com");
		    //$email->send();

			$this->SendEmails = 1;
			$this->SendEmailsJury1 = 1;
			$this->SendEmailsJury2 = 1;
		}



		
		if ($this->Status != "geprüft&freigegeben" && ($this->Jury1ID != 0 || $this->Jury2ID != 0)) {

			$config = SiteConfig::current_site_config(); 

			$email = new Email();
			 
	        $email->setFrom("genius@riz-up.at"); 
	        $email->setSubject($config->JuryProjectStatusTitle); 
	        $messageBody = str_replace("{PROJECT_TITLE}", (string)($this->IdeenTitle ?? ''), (string)($config->JuryProjectStatus ?? ''));
	        $messageBody = str_replace("{PROJECT_STATUS}", (string)($this->Status ?? ''), $messageBody);
	        $messageBody = str_replace("{PROJECT_NUMBER}", (string)($this->ProjectNumber ?? ''), $messageBody);
		    $email->setBody($messageBody);
	        
			if ($this->Jury1()->exists()) {
				
		        $email->setTo($this->Jury1()->Email);
		        $email->send();
			}

			if ($this->Jury2()->exists()) {
				$email->setTo($this->Jury2()->Email);
		        $email->send();
			}

			if ($this->Jury3()->exists()) {
				//$email->setTo($this->Jury3()->Email);
		        //$email->send();
			}

			DB::query("DELETE FROM Bewertung WHERE ProjectID='".$this->ID."'");


			$this->Jury1ID = 0;
			$this->Jury2ID = 0;
			$this->Jury3ID = 0;
			$this->SendEmails = 0;
			$this->SendEmailsJury1 = 0;
			$this->SendEmailsJury2 = 0;

			//$email->setBody("ProjectID:".$this->ID."<br><br>".$messageBody);
			//$email->setTo("kalakotra@gmail.com");
		    //$email->send();
		}


		// this will be done in registration form class after project is added
		if ($this->Completed == "1" && $this->Status == "neu" && $this->SendEmailsAdmin == "0") {

			$this->Jury1ID = 0;
			$this->Jury2ID = 0;
			$this->Jury3ID = 0;
			$this->SendEmails = 0;
			$this->SendEmailsJury1 = 0;
			$this->SendEmailsJury2 = 0;
			$this->SendEmailsAdmin = 1;
		}

		if ($this->ProjectNumber == "" && $this->Completed == 1) {
			$myCompetition = Competition::get()->filter(array("Active"=>"1"));
			$competitionExtension = "";
		    if ($myCompetition->count() > 0) {
		        $myProjects = Project::get()->where("Completed='1' AND ProjectNumber!=''")->filter(array("CompetitionID"=>$myCompetition->first()->ID))->sort("ID");
		        $competitionExtension = " ".$myCompetition->first()->ShortCode;
			    
			    if ($myProjects->count() > 0) {
			    	//$myProjects = $myProjects->sort("CompetitionOrder DESC")->first();
			    	//$this->CompetitionOrder = $myProjects->CompetitionOrder + 1;
			    	$this->CompetitionOrder = $myProjects->count() + 1;
			    } else {
			    	$this->CompetitionOrder = 1;
			    }
			    

			    $myHtml = sprintf("%'.03d", $this->CompetitionOrder);
				$myHtml .= $competitionExtension;

				$this->ProjectNumber = $myHtml;
			}
		}
		
	}

	function onAfterWrite() {
		parent::onAfterWrite();
		$myPosition = $this->updateAdminPosition();
		
	}

	public function Title() {
		return $this->IdeenTitle;
	}

	public function myFullName($stripHtml = false) {
		$myHtml = "<strong>". $this->Nachname." ". $this->Vorname."</strong><br>";

		if ($this->Vorname1 != "") {
			$myHtml .= $this->Nachname1." ". $this->Vorname1."<br />";
		}

		if ($this->Vorname2 != "") {
			$myHtml .= $this->Nachname2." ". $this->Vorname2."<br />";
		}

		if ($this->Vorname3 != "") {
			$myHtml .= $this->Nachname3." ". $this->Vorname3."<br />";
		}

		if ($this->Vorname4 != "") {
			$myHtml .= $this->Nachname4." ". $this->Vorname4."<br />";
		}

		if ($this->Vorname5 != "") {
			$myHtml .= $this->Nachname5." ". $this->Vorname5."<br />";
		}

		if ($stripHtml == true) {
			$myHtml = strip_tags((string)($myHtml ?? ''));
		} 
		return DBField::create_field('HTMLVarchar', $myHtml);
	}


	public function myFullNameExport() {
		$myHtml = $this->Nachname." ". $this->Vorname;

		if ($this->Vorname1 != "") {
			$myHtml .= ", ".$this->Nachname1." ". $this->Vorname1;
		}

		if ($this->Vorname2 != "") {
			$myHtml .= ", ".$this->Nachname2." ". $this->Vorname2;
		}

		if ($this->Vorname3 != "") {
			$myHtml .= ", ".$this->Nachname3." ". $this->Vorname3;
		}

		if ($this->Vorname4 != "") {
			$myHtml .= ", ".$this->Nachname4." ". $this->Vorname4;
		}

		if ($this->Vorname5 != "") {
			$myHtml .= ", ".$this->Nachname5." ". $this->Vorname5;
		}

		return $myHtml;
	}

	public function getJuryPointsExport() {
		return DBField::create_field('HTMLVarchar', number_format($this->JuryPoints, 2, ",", ""));
	}

	public function getAdminPointsExport() {
		return DBField::create_field('HTMLVarchar', number_format($this->AdminPoints, 2, ",", ""));
	}



	public function myAdminKomentar() {
		$what = array("\n", "\r");
		$with = array(" ", " ");
		$where = strip_tags((string)($this->AdminKomentar ?? ''));

		return str_replace($what, $with, $where);
	}



	public function juryStatus() {
		$myHtml = "";

		if ($this->Jury1ID > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->Jury1ID, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				if ($myBewertung->First()->Status == 1) {
					$myStatus = '<img src="/icons/akzeptiert.jpg" title="akzeptiert" />';
				} else if ($myBewertung->First()->Status == 2) {
					$myStatus = '<img src="/icons/inbearbeitung.jpg" title="in Bearbeitung" />';
				} else if ($myBewertung->First()->Status == 3) {
					$myStatus = '<img src="/icons/bewertet.jpg" title="bewertet" />';
				} else if ($myBewertung->First()->Status == 4) {
					$myStatus = '<img src="/icons/abgelehnt.jpg" title="abgelehnt" />';
				} else {
					$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
				}
				
			} else {
				$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
			}

			if ($this->Jury1()->generatedKurzel() != "") {
				$myShort = $this->Jury1()->generatedKurzel();
			} else {
				$myShort = $this->Jury1()->FirstName[0].$this->Jury1()->Surname[0];
			}
			$myHtml .= $myShort."(".$myStatus.")<br />";
		}

		if ($this->Jury2ID > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->Jury2ID, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				if ($myBewertung->First()->Status == 1) {
					$myStatus = '<img src="/icons/akzeptiert.jpg" title="akzeptiert" />';
				} else if ($myBewertung->First()->Status == 2) {
					$myStatus = '<img src="/icons/inbearbeitung.jpg" title="in Bearbeitung" />';
				} else if ($myBewertung->First()->Status == 3) {
					$myStatus = '<img src="/icons/bewertet.jpg" title="bewertet" />';
				} else if ($myBewertung->First()->Status == 4) {
					$myStatus = '<img src="/icons/abgelehnt.jpg" title="abgelehnt" />';
				} else {
					$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
				}
				
			} else {
				$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
			}

			if ($this->Jury2()->generatedKurzel() != "") {
				$myShort = $this->Jury2()->generatedKurzel();
			} else {
				$myShort = $this->Jury2()->FirstName[0].$this->Jury2()->Surname[0];
			}
			$myHtml .= $myShort."(".$myStatus.")<br />";
		}

		/*if ($this->Jury3ID > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->Jury3ID, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				if ($myBewertung->First()->Status == 1) {
					$myStatus = '<img src="_resources/icons/akzeptiert.jpg" title="akzeptiert" />';
				} else if ($myBewertung->First()->Status == 2) {
					$myStatus = '<img src="_resources/icons/inbearbeitung.jpg" title="in Bearbeitung" />';
				} else if ($myBewertung->First()->Status == 3) {
					$myStatus = '<img src="_resources/icons/bewertet.jpg" title="bewertet" />';
				} else if ($myBewertung->First()->Status == 4) {
					$myStatus = '<img src="_resources/icons/abgelehnt.jpg" title="abgelehnt" />';
				} else {
					$myStatus = '<img src="_resources/icons/ungelesen.jpg" title="ungelesen" />';
				}
				
			} else {
				$myStatus = '<img src="_resources/icons/ungelesen.jpg" title="ungelesen" />';
			}

			if ($this->Jury3()->generatedKurzel() != "") {
				$myShort = $this->Jury3()->generatedKurzel();
			} else {
				$myShort = $this->Jury3()->FirstName{0}.$this->Jury3()->Surname{0};
			}
			$myHtml .= $myShort."(".$myStatus.")<br />";
		}*/

		return DBField::create_field('HTMLVarchar', $myHtml);
	}



	public function projectStatusIcon() {
		//geprüft&freigegeben,in Bearbeitung,nicht zugelassen,neu
		$myHtml = "";
		if ($this->Status == "in Bearbeitung") {
			$myHtml = '<img src="/icons/inbearbeitung_project.jpg" title="in Bearbeitung" />';
		} else if ($this->Status == "nicht zugelassen") {
			$myHtml = '<img src="/icons/nicht_zugelasen.jpg" title="nicht zugelassen" />';
		} else if ($this->Status == "neu") {
			$myHtml = '<img src="/icons/neu.jpg" title="neu" />';
		} else {
			$myHtml = '<img src="/icons/freigegeben.jpg" title="geprüft & freigegeben" />';
		}

		return DBField::create_field('HTMLVarchar', $myHtml);
	}



	public function getJuryStatus($juryIDField="Jury1ID", $juryRelationName="Jury1") {
		$myHtml = "";
		if ($this->$juryIDField > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->$juryIDField, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				$myStatus = $myBewertung->First()->sumAllPunkte();
			} else {
				$myStatus = ' - ';
			}

			if ($this->$juryRelationName()->generatedKurzel() != "") {
				$myShort = $this->$juryRelationName()->generatedKurzel();
			} else {
				$myShort = $this->$juryRelationName()->FirstName[0].$this->$juryRelationName()->Surname[0];
			}
			$myHtml .= $myShort."(".$myStatus.")<br />";
		} else {
			$myHtml = "-";
		}
		return DBField::create_field('HTMLVarchar', $myHtml);
	}

	public function getJuryStatusExport($juryIDField="Jury1ID", $juryRelationName="Jury1") {
		$myHtml = "";
		if ($this->$juryIDField > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->$juryIDField, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				$myStatus = $myBewertung->First()->sumAllPunkte();
			} else {
				$myStatus = ' - ';
			}

			if ($this->$juryRelationName()->generatedKurzel() != "") {
				$myShort = $this->$juryRelationName()->generatedKurzel();
			} else {
				$myShort = $this->$juryRelationName()->FirstName[0].$this->$juryRelationName()->Surname[0];
			}
			$myHtml .= $myShort."(".$myStatus.")";
		} else {
			$myHtml = "-";
		}
		return DBField::create_field('HTMLVarchar', $myHtml);
	}



	public function getAllBewertungPoints() {
		$myBewertung = Bewertung::get()->filter(array("ProjectID"=>$this->ID));
		$myPoints = 0;
		if ($myBewertung->exists()) {
			foreach ($myBewertung as $key => $value) {
				$myPoints += $value->sumAllPunkte();
			}
		}
		return $myPoints;
	}


	public function CustomProjectNumber() {

		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
        	$competitionExtension = " ".$myCompetition->first()->ShortCode;
            $myProjects = Project::get()->filter(array("CompetitionID"=>$myCompetition->first()->ID))->sort("ID");
            $i = 1;
            foreach ($myProjects as $key => $value) {
            	if ($this->ID == $value->ID) {
            		$myHtml = sprintf("%'.03d", $i);
					$myHtml .= $competitionExtension;
					return DBField::create_field('HTMLVarchar', $myHtml);
            	}

            	$i++;
            }

            
        }
		return DBField::create_field('HTMLVarchar', "--");
	}



	public function summaryFields() {
		//incompletedprojects
		if (strpos($_SERVER['REQUEST_URI'],'incompletedprojects') !== false) {
		    $rawFields = array(
				'ID' => 'ID',
				'Created.Nice' => 'Einreichung',
				'IdeenTitle' => 'Projekttitel',
				'KurzBeschreibung' => 'Projektbeschreibung',
				'AdminKomentar' => 'AdminKomentar',
				'myFullName' => 'Name',
				'PLZ' => 'PLZ',
				'Firma' => 'Firma',
				'projectStatusIcon' => '*',
				'juryStatus' => 'Juroren (Status)'
			);

		    
		} else if (strpos($_SERVER['REQUEST_URI'],'auswertungen') !== false) {
		    $rawFields = array(
				'ProjectNumber' => 'Pr. nr.',
				'IdeenTitle' => 'Projekttitel',
				'Nominierte' => 'Nominierte',
				'myFullName' => 'Name',
				'Firma' => 'Firma',
				'Kategories.Title' => 'Kategorie',
				'getJuryStatus' => 'Juror 1',
				'getJuryStatus2' => 'Juror 2',
				/*'getJuryStatus3' => 'Juror 3',*/
				'JuryPoints' => 'Vorl. Punk',
				'JuryPlace' => 'Vorl. Platz',
				'AdminPoints' => 'Fin. Punkte',
				'AdminPlace' => 'Fin. Platz',
				'KurzBeschreibung' => 'Projektbeschreibung'
			);

		    
		} else if (strpos($_SERVER['REQUEST_URI'],'nominierte') !== false) {
		    $summaryFieldsHolder="NominiertesummaryFields";
		    $rawFields = array(
				'ProjectNumber' => 'Pr. nr.',
				'IdeenTitle' => 'Projekttitel',
				'Kategories.Title' => 'Kategorie',
				'Sponsor1.Firma' => 'Sponsor 1',
				'Preisgeld1' => 'Preisgeld',
				'Sponsor2.Firma' => 'Sponsor 2',
				'Preisgeld2' => 'Preisgeld',
				'Sponsor3.Firma' => 'Sponsor 3',
				'Preisgeld3' => 'Preisgeld',
				'AdminPlace' => 'Finale Platzierung',
				'OffiziellerPlatz' => 'Offizieller Platz'

			);

		    
		} else if (strpos($_SERVER['REQUEST_URI'],'jurysitzung') !== false) {
		    $summaryFieldsHolder="NominatedAuswertungensummaryFields";
		    $rawFields = array(
				'ProjectNumber' => 'Pr. nr.',
				'IdeenTitle' => 'Projekttitel',
				'Nominierte' => 'Nominierte',
				'myFullName' => 'Name',
				'Firma' => 'Firma',
				'Kategories.Title' => 'Kategorie',
				'getJuryStatus' => 'Juror 1',
				'getJuryStatus2' => 'Juror 2',
				/*'getJuryStatus3' => 'Juror 3',*/
				'JuryPoints' => 'Vorl. Punk',
				'JuryPlace' => 'Vorl. Platz',
				'AdminPoints' => 'Fin. Punkte',
				'AdminPlace' => 'Fin. Platz',
				'KurzBeschreibung' => 'Projektbeschreibung'
			);

		    
		} else {
			$summaryFieldsHolder="summary_fields";
			$rawFields = array(
				'ProjectNumber' => 'Pr. nr.',
				'Created.Nice' => 'Einreichung',
				'IdeenTitle' => 'Projekttitel',
				'KurzBeschreibung' => 'Projektbeschreibung',
				'AdminKomentar' => 'AdminKomentar',
				'myFullName' => 'Name',
				'PLZ' => 'PLZ',
				'Firma' => 'Firma',
				'projectStatusIcon' => '*',
				'juryStatus' => 'Juroren (Status)'
				
			);
			
		}

		// Merge associative / numeric keys
        $fields = [];
        foreach ($rawFields as $key => $value) {
            if (is_int($key)) {
                $key = $value;
            }
            $fields[$key] = $value;
        }

        if (!$fields) {
            $fields = array();
            // try to scaffold a couple of usual suspects
            if ($this->hasField('Name')) {
                $fields['Name'] = 'Name';
            }
            if (static::getSchema()->fieldSpec($this, 'Title')) {
                $fields['Title'] = 'Title';
            }
            if ($this->hasField('Description')) {
                $fields['Description'] = 'Description';
            }
            if ($this->hasField('FirstName')) {
                $fields['FirstName'] = 'First Name';
            }
        }
        $this->extend("updateSummaryFields", $fields);

        // Final fail-over, just list ID field
        if (!$fields) {
            $fields['ID'] = 'ID';
        }

        // Localize fields (if possible)
        foreach ($this->fieldLabels(false) as $name => $label) {
            // only attempt to localize if the label definition is the same as the field name.
            // this will preserve any custom labels set in the summary_fields configuration
            if (isset($fields[$name]) && $name === $fields[$name]) {
                $fields[$name] = $label;
            }
        }

        return $fields;
	}

	public function getJuryStatus2() {
		return $this->getJuryStatus("Jury2ID", "Jury2");
	}

	public function getJuryStatus3() {
		return $this->getJuryStatus("Jury3ID", "Jury3");
	}

	public function getJuryStatusExport2() {
		return $this->getJuryStatusExport("Jury2ID", "Jury2");
	}

	public function getJuryStatusExport3() {
		return $this->getJuryStatusExport("Jury3ID", "Jury3");
	}


	public function getCurrentUser() {
		//return Member::currentUser();
		return Security::getCurrentUser();
	}

	public function getJuryStatusForFrontend() {
		$myBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$this->ID."'");
		if ($myBewertung->exists()) {
			$myBewertung = $myBewertung->first();
			if ($myBewertung->Status == 1) {
				return "akzeptiert";
			} else if ($myBewertung->Status == 2) {
				return "in Bearbeitung";
			} else if ($myBewertung->Status == 3) {
				return "bewertet";
			} else if ($myBewertung->Status == 4) {
				return "abgelehnt";
			}
		}

		return "neu";
	}

	public function getJuryPointsForFrontend() {
		$myBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$this->ID."'");
		if ($myBewertung->exists()) {
			$myBewertung = $myBewertung->first();
			if ($myBewertung->Status == 1) {
				return "--";
			} else if ($myBewertung->Status == 2) {
				return "--";
			} else if ($myBewertung->Status == 3) {
				//return $myBewertung->InnovationsPunkte + $myBewertung->MarktPunkte + $myBewertung->UmsetzungsrelevanzPunkte + $myBewertung->WirtschaftsrelevanzPunkte + $myBewertung->QualitatPunkte;
				//return "IP: ". $myBewertung->InnovationsPunkte ."<br />MP: ". $myBewertung->MarktPunkte ."<br />UP: ". $myBewertung->UmsetzungsrelevanzPunkte ."<br />WP: ". $myBewertung->WirtschaftsrelevanzPunkte ."<br />QP: ". $myBewertung->QualitatPunkte;
				return $myBewertung->CompetitionCriteria()->sum('CriteriaPunkte');
			} else if ($myBewertung->Status == 4) {
				return "--";
			}
		}

		return "neu";
	}

	public function getJuryStatusForFrontendInteger() {
		$myBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$this->ID."'");
		if ($myBewertung->exists()) {
			$myBewertung = $myBewertung->first();
			return $myBewertung->Status;
		}

		return 0;
	}

	public function myBewertung() {
		//$myUserID = $this->request->param("OtherID");
		$myBewertung = Bewertung::get()->where("JuryID='".$this->getCurrentUser()->ID."' AND ProjectID='".$this->ID."'");
		if ($myBewertung->exists()) {
			$myBewertung = $myBewertung->first();
			return $myBewertung;
		}
	}

	public function bewertungByJury($juryID=0) {
		$myBewertung = Bewertung::get()->where("JuryID='".$juryID."' AND ProjectID='".$this->ID."'");
		if ($myBewertung->exists()) {
			$myBewertung = $myBewertung->first();
			//return $myBewertung;
			$myPoints = [];
			foreach ($myBewertung->CompetitionCriteria() as $key => $value) {
				$myPoints[$value->ID] = $value->CriteriaPunkte;
			}

			return $myPoints;
		}

		return false;
		//return new Bewertung();
	}

	public function myProjectNumber() {
		$myHtml = sprintf("%'.03d", $this->ID);
		$myHtml .= " ".$this->Created[2].$this->Created[3];
		return DBField::create_field('HTMLVarchar', $myHtml);
	}


	public function myAllBewertungs() {
		$myBewertungs = Bewertung::get()->where("ProjectID='".$this->ID."'");

		return $myBewertungs;
	}


	public function countMyPoints($myID) {
		$myBewertungs = Bewertung::get()->where("ProjectID='".$myID."'");
		$innoPoints = $marktPoints = $UmsetzungPoints = $WirtschaftsPoints = $QualitatPoints = 0;

		foreach ($myBewertungs as $key => $value) {
			$innoPoints += $value->InnovationsPunkte;
			$marktPoints += $value->MarktPunkte;
			$UmsetzungPoints += $value->UmsetzungsrelevanzPunkte;
			$WirtschaftsPoints += $value->WirtschaftsrelevanzPunkte;
			$QualitatPoints += $value->QualitatPunkte;
		}

		$myPoints = array($innoPoints, $marktPoints, $UmsetzungPoints, $WirtschaftsPoints, $QualitatPoints);

		return $myPoints;
	}

	public function countMyPosition($myID) {
		$myProject = Project::get()->where("Project.ID='".$myID."'")->first();
		$projects = Project::get();
		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
		if ($myCompetition->exists() ) {
			$projects = $projects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
		}

		$projects = $projects->where("JuryPoints>'".$myProject->JuryPoints."' AND KategoriesID='".$myProject->KategoriesID."'");
		return $projects->count() +1;
	}


	public function updateAdminPosition() {
		$projects = Project::get();

		$myCompetition = Competition::get()->filter(array("Active"=>"1"));
		if ($myCompetition->exists() ) {
			$projects = $projects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
		}

		$projects = $projects->where("KategoriesID='".$this->KategoriesID."'")->sort("AdminPoints DESC");

		$i = 1;
		foreach ($projects as $key => $value) {
			DB::query("UPDATE Project SET AdminPlace='".$i."' WHERE ID='".$value->ID."'");
			$i++;
		}
		return $projects->count() +1;
	}


	public function myNominierte() {
		if ($this->Nominierte) {
			return "Ja";
		} 

		return "Nein";
	}

	public function juryMemberCount() {
		$i = 0;

		if ($this->Jury1ID > 0) {
			$i++;
		}

		if ($this->Jury2ID > 0) {
			$i++;
		}

		if ($this->Jury3ID > 0) {
			$i++;
		}

		return $i;
	}





	public function juryStatusFlag($juryIDField="Jury1ID") {
		$myStatus = "";

		if ($this->$juryIDField > 0) {
			$myStatus = "";
			$myBewertung = Bewertung::get()->filter(array("JuryID"=>$this->$juryIDField, "ProjectID"=>$this->ID));
			if ($myBewertung->exists()) {
				if ($myBewertung->First()->Status == 1) {
					$myStatus = '<img src="/icons/akzeptiert.jpg" title="akzeptiert" />';
				} else if ($myBewertung->First()->Status == 2) {
					$myStatus = '<img src="/icons/inbearbeitung.jpg" title="in Bearbeitung" />';
				} else if ($myBewertung->First()->Status == 3) {
					$myStatus = '<img src="/icons/bewertet.jpg" title="bewertet" />';
				} else if ($myBewertung->First()->Status == 4) {
					$myStatus = '<img src="/icons/abgelehnt.jpg" title="abgelehnt" />';
				} else {
					$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
				}
				
			} else {
				$myStatus = '<img src="/icons/ungelesen.jpg" title="ungelesen" />';
			}
		}

		return $myStatus;
	}





	public function CSVExportFields() {
		/*if (strpos($_SERVER['REQUEST_URI'],'auswertungen') !== false) {
		    $summaryFieldsHolder="AuswertungensummaryFields";

		    
		} else if (strpos($_SERVER['REQUEST_URI'],'nominierte') !== false) {
		    $summaryFieldsHolder="NominiertesummaryFields";

		    
		} else {
			$summaryFieldsHolder="summary_fields";
			
		}*/

		$summaryFieldsHolder = "CSVExportFields";

		$fields = $this->stat($summaryFieldsHolder);
		// if fields were passed in numeric array,
		// convert to an associative array
		if($fields && array_key_exists(0, $fields)) {
			$fields = array_combine(array_values($fields), array_values($fields));
		}
		
		// Final fail-over, just list ID field
		if(!$fields) $fields['ID'] = 'ID';

		// Localize fields (if possible)
		foreach($this->fieldLabels(false) as $name => $label) {
			// only attempt to localize if the label definition is the same as the field name.
			// this will preserve any custom labels set in the summary_fields configuration
			if(isset($fields[$name]) && $name === $fields[$name]) {
				$fields[$name] = $label;
			}
		}

		return $fields;
	}



	public function bezirkName($bezirkNr = 0) {
		$myRegions = $this->BezirkArray();
		if (isset($myRegions[$bezirkNr])) {
			return $myRegions[$bezirkNr];
		} else {
			return false;
		}
        
	}

	public function BezirkArray() {
		$myRegions = array(
            'Kein NÖ-Bezirk',
            'Amstetten',
            'Baden',
            'Bruck/Leitha',
            'Gänserndorf',
            'Gmünd',
            'Hollabrunn',
            'Horn',
            'Korneuburg',
            'Krems',
            'Lilienfeld',
            'Melk',
            'Mistelbach',
            'Mödling',
            'Neunkirchen',
            'Scheibbs',
            'St. Pölten',
            'St. Pölten Land',
            'Tulln',
            'Waidhofen/Thaya',
            'Waidhofen/Ybbs',
            'Wien Umgebung Nord',
            'Wien Umgebung Süd',
            'Wien Umgebung West',
            'Wiener Neustadt',
            'Wiener Neustadt Land',
            'Zwettl',
            'Krems Land'
        );

        return $myRegions;
	}


	public function myTeam() {
		$myTeam = "";

		if ($this->Vorname1 != "" && $this->Nachname1 != "" ) {
			if ($this->AkademischerGrad1) {
				$myTeam .= $this->AkademischerGrad1 ." "; 
			}
			$myTeam .= $this->Vorname1 ." ". $this->Nachname1;
			if ($this->AkademischerGrad1Sufix) {
				$myTeam .= ",". $this->AkademischerGrad1Sufix;
			}
		}

		if ($this->Vorname2 != "" && $this->Nachname2 != "" ) {
			$myTeam .= ",";
			if ($this->AkademischerGrad2) {
				$myTeam .= $this->AkademischerGrad2 ." "; 
			}
			$myTeam .= $this->Vorname2 ." ". $this->Nachname2;
			if ($this->AkademischerGrad2Sufix) {
				$myTeam .= ",". $this->AkademischerGrad2Sufix;
			}
		}

		if ($this->Vorname3 != "" && $this->Nachname3 != "" ) {
			//$myTeam .= ", " .$this->AkademischerGrad3 ." ". $this->Vorname3 ." ". $this->Nachname3  ." ". $this->AkademischerGrad3Sufix;

			$myTeam .= ",";
			if ($this->AkademischerGrad3) {
				$myTeam .= $this->AkademischerGrad3 ." "; 
			}
			$myTeam .= $this->Vorname3 ." ". $this->Nachname3;
			if ($this->AkademischerGrad3Sufix) {
				$myTeam .= ",". $this->AkademischerGrad3Sufix;
			}
		}

		if ($this->Vorname4 != "" && $this->Nachname4 != "" ) {
			//$myTeam .= ", " .$this->AkademischerGrad4 ." ". $this->Vorname4 ." ". $this->Nachname4  ." ". $this->AkademischerGrad4Sufix;

			$myTeam .= ",";
			if ($this->AkademischerGrad4) {
				$myTeam .= $this->AkademischerGrad4 ." "; 
			}
			$myTeam .= $this->Vorname4 ." ". $this->Nachname4;
			if ($this->AkademischerGrad4Sufix) {
				$myTeam .= ",". $this->AkademischerGrad4Sufix;
			}
		}

		if ($this->Vorname5 != "" && $this->Nachname5 != "" ) {
			//$myTeam .= ", " .$this->AkademischerGrad5 ." ". $this->Vorname5 ." ". $this->Nachname5  ." ". $this->AkademischerGrad5Sufix;

			$myTeam .= ",";
			if ($this->AkademischerGrad5) {
				$myTeam .= $this->AkademischerGrad5 ." "; 
			}
			$myTeam .= $this->Vorname5 ." ". $this->Nachname5;
			if ($this->AkademischerGrad5Sufix) {
				$myTeam .= ",". $this->AkademischerGrad5Sufix;
			}
		}

		if ($this->OtherTeamMembers ) {
			$myTeam .= "," .$this->OtherTeamMembers;
		}

		return $myTeam;
	}


	public function canView($member = null) 
    {
        return true; //Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null) 
    {
        return true; //Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = []) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }


}
