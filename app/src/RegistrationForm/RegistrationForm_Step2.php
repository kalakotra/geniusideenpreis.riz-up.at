<?php

namespace app\RegistrationForm;

use app\RegistrationForm\RegistrationForm_Step3;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\ORM\FieldType\DBField;

class RegistrationForm_Step2 extends MultiFormStep {

    private static $next_steps = RegistrationForm_Step3::class;

    public function getFields() {

        $myCompetition = $this->getActiveCompetition();

        $fields = FieldList::create(
            HeaderField::create('header', 'Ihre RIZ UP GENIUS Geschäftsidee'),
            TextField::create('IdeenTitle', 'Titel der Idee *'),
                
            DropdownField::create('KategoriesID', 'Kategorie *', $myCompetition->Kategorie()->map())
                ->setDescription('Wir behalten uns vor, Einreichungen bei Bedarf in einer anderen Kategorie zu nominieren.'),
            TextareaField::create('KurzBeschreibung', 'Ideen-Kurz-Beschreibung (max. 5 Sätze) *')
                ->addExtraClass('no-grid')
                ->setAttribute('maxlength', 500)
                ->setDescription('Bitte beschreiben Sie die Idee in 5 Sätzen (max 500 Zeichen).'),

            // additional fields for step 2 - add to model to
            LiteralField::create('', '<hr />')->addExtraClass('w-100'),
            TextareaField::create('WarumEinzigartig', 'Warum sollten Kunden bei Ihnen kaufen, was macht Ihre Idee einzigartig? *'),
            OptionsetField::create('IdeeGeschuetzt', 'Haben Sie die Idee geschützt? *', 
                ['1'=>'Ja', '0'=>'Nein', '2'=> 'im Laufen']
            )->addExtraClass('no-grid'),
            DropdownField::create('Schutzart', 'Wählen Sie die Schutzart aus', 
                ['Patent'=>'Patent', 'Gebrauchsmuster'=>'Gebrauchsmuster', 'Anderer Schutz'=>'Anderer Schutz']
            )
                ->setEmptyString('Bitte wählen...')
                ->displayIf('IdeeGeschuetzt')->isEqualTo('1')->end(),
            
            OptionsetField::create('IdeeRealisiert', 'Haben Sie Ihre Idee bereits umgesetzt/realisiert? *', 
                ['1'=>'Ja', '0'=>'Nein']
            )->addExtraClass('no-grid'),
            TextareaField::create('Umsetzungsgrad', 'In welchem Stadium der Entwicklung stehen Sie mit Ihrer Geschäftsidee? Welche Schritte sind noch offen? *')
                ->displayIf('IdeeRealisiert')->isEqualTo('1')->end(),
            
            OptionsetField::create('Selbststaendig', 'Sind Sie bereits selbstständig? *', 
                ['1'=>'Ja', '0'=>'Nein']
            )->addExtraClass('no-grid'),
            TextField::create('SelbststaendigSeit', 'Wenn ja, seit wann?')
                ->displayIf('Selbststaendig')->isEqualTo('1')->end(),
            
            LiteralField::create('', '<hr />')->addExtraClass('w-100'),

            TextareaField::create('Zielgruppen', 'Welche Zielgruppen spricht Ihre Geschäftsidee an? *'),

            TextareaField::create('Einnahmequellen', 'Wie verdienen Sie Geld mit Ihrer Geschäftsidee? *'),

            TextareaField::create('MarktChancenRisiken', 'Welche Chancen und Risiken sehen Sie am (potenziellen) Markt? *'),

            OptionsetField::create('Wachstumsplanung', 'Planen Sie mit dem Geschäftsmodell zu wachsen? *', 
                ['1'=>'Ja', '0'=>'Nein']
            )->addExtraClass('no-grid'),
            TextField::create('WachstumsplanungDetails', 'Wie soll dieses Wachstum aussehen?')
                ->displayIf('Wachstumsplanung')->isEqualTo('1')->end(),
            
            LiteralField::create('', '<hr />')->addExtraClass('w-100'),

            TextareaField::create('MehrwertFuerNiederoesterreich', 'Abschließend: Wir suchen innovative, niederösterreichische Geschäftsideen. Was ist der Mehrwert Ihrer Idee für Niederösterreich? *')
                ->addExtraClass('no-grid'),

        );
        
        return $fields;
    }

    public function getAllCompetitions() {
        return \Competition::get();
    }

    public function getActiveCompetition() {
        return $this->getAllCompetitions()->filter(array("Active"=>"1"))->First();
    }

    public function getValidator__()
    {
        return RequiredFields::create(array(
            'IdeenTitle',
            'KurzBeschreibung',
            'WarumEinzigartig',
            'IdeeGeschuetzt',
            'IdeeRealisiert',
            'Selbststaendig',
            'Zielgruppen',
            'Einnahmequellen',
            'MarktChancenRisiken',
            'Wachstumsplanung',
            'MehrwertFuerNiederoesterreich'
        ));
    }

    public function getTitle() {
        return '2';
    }

    public function getContent() {
        $controller = Controller::curr();
        if ($controller) {
            return DBField::create_field('HTMLText', $controller->Step2Text);
        }
    }

}