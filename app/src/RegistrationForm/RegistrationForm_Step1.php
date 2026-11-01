<?php

namespace app\RegistrationForm;

use app\RegistrationForm\RegistrationForm_Step2;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\ORM\FieldType\DBField;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class RegistrationForm_Step1 extends MultiFormStep {

    private static $next_steps = RegistrationForm_Step2::class;

    public function getFields(): FieldList {

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
        $fields = FieldList::create(
            HeaderField::create('header', 'Persönliche Daten'),
            LiteralField::create('', '
                <div class="row">
					<div class="col-12 col-lg-8">
						<span class="smallTextInForm">
							Bitte geben Sie Ihre persönlichen Daten ein.
						</span>
					</div>
					<div class="col-12 col-lg-4 text-right">
						<span class="smallTextInForm floatRight marginRight105">* Pflichtfeld</span>
					</div>
				</div>
            ')->addExtraClass('w-100'),
            OptionsetField::create("Anrede", "Anrede *", singleton('Project')->dbObject('Anrede')->enumValues()),
            TextField::create('AkademischerGrad', "Titel vorangestellt"),
            
            TextField::create('Vorname', 'Vorname *'),
            TextField::create('Nachname', 'Nachname *'),
            TextField::create('AkademischerGradSufix', "Titel nachgestellt"),
            TextField::create('Firma', "Firma"),
            TextField::create('Abteilung', "Abteilung"),
            TextField::create('Strasse', 'Straße, Hausnummer *'),
            TextField::create('PLZ', 'PLZ *')->setMaxLength(4),
            TextField::create('Ort', 'Ort *'),

            DropdownField::create('Bezirk', 'Bezirk *', $myRegions)->setEmptyString('Bitte wählen'),
            NumericField::create('Telefonnummer', 'Telefon *')
                ->setHTML5(true)
                ->setDescription('(bitte nur Zahlen eingeben)'),
            TextField::create("Website", "Website"),
            EmailField::create('Email', 'E-Mail *'),
            EmailField::create('Email2', 'E-Mail *')->setDescription('Bitte geben Sie Ihre E-Mail-Adresse erneut ein.'),
            DropdownField::create('WettbewerbAufmerksam',
                                        'Wie sind Sie auf den RIZ UP GENIUS aufmerksam geworden?',
                                        singleton(\Project::class)->dbObject('WettbewerbAufmerksam')->enumValues()
                                    )->addExtraClass('no-grid'),
            
            
            HeaderField::create('header', 'Teammitglieder'),
            LiteralField::create('info', '<p class="smallTextInForm">Bei Teamprojekten - bitte geben Sie die Namen aller Teammitglieder an:</p>')->addExtraClass('w-100'),
            DropdownField::create('Teammitglieder', 'Wie viele weitere Mitglieder sind in Ihrem Team?', ['1'=>'1 Teammitglied', '2'=>'2 Teammitglieder', '3'=>'3 Teammitglieder', '4'=>'4 Teammitglieder', '5'=>'5 Teammitglieder', '6'=>'6 oder mehr Teammitglieder'])->addExtraClass('no-grid')->setEmptyString('Bitte wählen'),

            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Teammitglied 1', 4),
                OptionsetField::create("Anrede1", "Anrede", singleton('Project')->dbObject('Anrede1')->enumValues()),
                TextField::create('AkademischerGrad1', 'Titel vorangestellt'),
                TextField::create('Vorname1', 'Vorname *'),
                TextField::create('Nachname1', 'Nachname *'),
                TextField::create('AkademischerGrad1Sufix', 'Titel nachgestellt'),
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('0')->end(),
            
            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Teammitglied 2', 4),
                OptionsetField::create("Anrede2", "Anrede", singleton('Project')->dbObject('Anrede2')->enumValues()),
                TextField::create('AkademischerGrad2', 'Titel vorangestellt'),
                TextField::create('Vorname2', 'Vorname *'),
                TextField::create('Nachname2', 'Nachname *'),
                TextField::create('AkademischerGrad2Sufix', 'Titel nachgestellt'),
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('1')->end(),
            
            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Teammitglied 3', 4),
                OptionsetField::create("Anrede3", "Anrede", singleton('Project')->dbObject('Anrede3')->enumValues()),
                TextField::create('AkademischerGrad3', 'Titel vorangestellt'),
                TextField::create('Vorname3', 'Vorname *'),
                TextField::create('Nachname3', 'Nachname *'),
                TextField::create('AkademischerGrad3Sufix', 'Titel nachgestellt'),
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('2')->end(),
            
            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Teammitglied 4', 4),
                OptionsetField::create("Anrede4", "Anrede", singleton('Project')->dbObject('Anrede4')->enumValues()),
                TextField::create('AkademischerGrad4', 'Titel vorangestellt'),
                TextField::create('Vorname4', 'Vorname *'),
                TextField::create('Nachname4', 'Nachname *'),
                TextField::create('AkademischerGrad4Sufix', 'Titel nachgestellt'),
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('3')->end(),
            
            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Teammitglied 5', 4),
                OptionsetField::create("Anrede5", "Anrede", singleton('Project')->dbObject('Anrede5')->enumValues()),
                TextField::create('AkademischerGrad5', 'Titel vorangestellt'),
                TextField::create('Vorname5', 'Vorname *'),
                TextField::create('Nachname5', 'Nachname *'),
                TextField::create('AkademischerGrad5Sufix', 'Titel nachgestellt'),
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('4')->end(),
            
            Wrapper::create(
                LiteralField::create('', '<hr />')->addExtraClass('w-100'),
                HeaderField::create('header', 'Weitere Teammitglieder', 4),
                TextareaField::create('OtherTeamMembers', 'Alle weiteren Teammitglieder anführen')
                    ->setDescription('Bitte erfassen Sie die weiteren TeilnehmerInnen mit Vor- und Nachnamen mit Beistrichen getrennt (Max Mustermann, Mara Musterfrau, ...)')
            )
                ->addExtraClass('no-grid')
                ->displayIf('Teammitglieder')->isGreaterThan('5')->end(),
        );
        return $fields;
    }

    public function getValidator()
    {
        return RequiredFieldsValidator::create(array(
            'Anrede',
            'Vorname',
            'Nachname',
            'Strasse',
            'PLZ',
            'Ort',
            'Bezirk',
            'Telefonnummer',
            'Email',
            'Email2'
        ));
    }

    public function validateStep(array $data, Form $form): bool
    {
        if ($data['Email'] !== $data['Email2']) {
            $validator = $this->getValidator();
            $validator->validationError(
                'Email2',
                'Die E-Mail-Adressen stimmen nicht überein.',
                'error');
            $form->sessionMessage('Die E-Mail-Adressen stimmen nicht überein.', 'bad');
            return false;
        }
        return true;
    }

    public function getTitle() {
        return '1';
    }

    public function getContent() {
        $controller = Controller::curr();
        if ($controller) {
            return DBField::create_field('HTMLText', $controller->Step1Text);
        }
    }

}