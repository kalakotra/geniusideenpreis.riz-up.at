<?php


use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;
use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\CMS\Controllers\CMSMain;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridField_ActionMenu;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldViewButton;


class Jury extends DataObject {
	private static $db = array(
		
	);

	public function getCMSFields() {
		$myProject = Project::get();

        $myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $myProject = $myProject->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }
        $myIds = "0";
        foreach ($myProject as $key => $value) {
            $myIds .= ",".$value->ID;
        }

		$list = Member::get();
        $list = $list->innerJoin("Group_Members", "Group_Members.MemberID=Member.ID AND GroupID='3'");

        $gridConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldGesamt = GridField::create("Member", "Jury", $list, $gridConfig);

        $listAktuell = $list->filter(array("ActiveForCompetition"=>"1"));

        $gridConfig = GridFieldConfig_RecordEditor::create();
        
        $myColumns = $gridConfig->getComponentByType(GridFieldDataColumns::class);
        $myColumns->setDisplayFields( array(
            'Anrede' => 'Anrede',
            'AkademischerGrad' => 'Title',
            'FirstName' => 'Vorname',
            'Surname' => 'Nachname',
            'Kuerzel' => 'Kürzel',
            'Firma' => 'Firma',
            'Email' => 'e-Mail/BN',
            'myProjectCount' => 'Projekte',
            'myProjectPercent' => 'bewertet in %'
        ) );

        $gridFieldAktuell = GridField::create("Jury", "Jury", $listAktuell, $gridConfig);

        /*
			Bewertungen
        */
		$myBewertung = Bewertung::get();
        $myBewertung = $myBewertung->where("ProjectID IN (".$myIds.")");

		$gridConfig = GridFieldConfig_RecordViewer::create();
        $myColumns = $gridConfig->getComponentByType(GridFieldDataColumns::class);
        $myColumns->setDisplayFields( array(
            'ID' => 'ID',
            'Project.ProjectNumber' => 'Projekt Nr',
            'Project.IdeenTitle' => 'Projekttitel',
                        //'myPointsForPreview' => 'Punkte',
            //'InnovationsPunkte' => 'Innovation',
            //'MarktPunkte' => 'Markt',
            //'UmsetzungsrelevanzPunkte' => 'Umsetzung',
            //'WirtschaftsrelevanzPunkte' => 'Wirtsch./ges.pol. Rel.',
            //'QualitatPunkte' => 'Qualitat',
            'sumAllPunkte' => 'Gesamtpunkte',
            'Jury.Kuerzel' => 'Juror'
        ) );
        
        $gridFieldBewertung = GridField::create("Bewertung", "Jury Bewertung", $myBewertung, $gridConfig);


        /* Statistic */
        $myMeberIDList = "0";
        foreach ($myProject as $projectKey => $projectValue) {
            if  ($projectValue->Jury1ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury1ID;
            }
            if  ($projectValue->Jury2ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury2ID;
            }
            if  ($projectValue->Jury3ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury3ID;
            }
        }


        $myHtml = "";
        $competitionMember = Member::get()->where("ID IN (".$myMeberIDList.")");
        foreach ($competitionMember as $memberKey => $memberValue) {
            $myHtml .= "<div style='padding: 10px 0;'>
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>ID:</div>".$memberValue->ID."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Name:</div>".$memberValue->FirstName." ".$memberValue->Surname."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Project count:</div>".$memberValue->getCompetitionProjects()->count(). "
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Rating count:</div>".$memberValue->getCompetitionBewertung()->count()."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Finished (in %):</div>".$memberValue->myProjectPercent()."
                        </div>";
        }


        $fields = FieldList::create(
            TabSet::create(
            	"Root",
                $tabJuryAktuell = Tab::create(
                    'JuryAktuell',
                    $gridFieldAktuell
                ),
                $tabJuryBewertung = Tab::create(
                    'JuryBewertung',
                    $gridFieldBewertung
                ),
                $tabJuryStatistic = Tab::create(
                    'JuryStatistic',
                    LiteralField::create("floorTitle", "<div style='clear: both; float: left; width: 100%; padding-left: 50px;'>"),
                    LiteralField::create("floorTitle", $myHtml),
                    LiteralField::create("floorTitle", "</div>")
                ),
                $tabJuryGesamt = Tab::create(
                    'JuryGesamt',
                    $gridFieldGesamt
                )
            )
        );

        //$tabJuryAktuell->setTitle(_t(self::class . '.TABMAIN', "Main"));
        //$tabJuryBewertung->setTitle(_t(self::class . '.TABACCESS', "Access"));

        $this->extend('updateCMSFields', $fields);
        return $fields;

	}

	public static function current_jury()
    {
        $myJury = Jury::get();
        if ($myJury->count() > 0) {
            return $myJury->First();
        }

        return self::make_jury();
    }

    public static function make_jury()
    {
        $myJury = Jury::create();
        $myJury->write();

        return $myJury;
    }


    public function juryStatistic() {

        $fields = new FieldList(); //$siteConfig->getCMSFields();

        $fields->push(LiteralField::create("floorTitle", "<div style='clear: both; float: left; width: 100%; padding-left: 50px;'><h2>Jury statistic</h2>"));

        $myProjects = Project::get();
        $myCompetition = Competition::get()->filter(array("Active"=>"1"));
        if ($myCompetition->count() > 0) {
            $myProjects = $myProjects->filter(array("CompetitionID"=>$myCompetition->first()->ID));
        }

        $myMeberIDList = "0";
        foreach ($myProjects as $projectKey => $projectValue) {
            if  ($projectValue->Jury1ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury1ID;
            }
            if  ($projectValue->Jury2ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury2ID;
            }
            if  ($projectValue->Jury3ID > 0) {
                $myMeberIDList .= ",".$projectValue->Jury3ID;
            }
        }


        //$fields->push(LiteralField::create("floorTitle", $myMeberIDList));
        $myHtml = "";
        $competitionMember = Member::get()->where("ID IN (".$myMeberIDList.")");
        foreach ($competitionMember as $memberKey => $memberValue) {
            $myHtml .= "<div style='padding: 10px 0;'>
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>ID:</div>".$memberValue->ID."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Name:</div>".$memberValue->FirstName." ".$memberValue->Surname."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Project count:</div>".$memberValue->getCompetitionProjects()->count(). "
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Rating count:</div>".$memberValue->getCompetitionBewertung()->count()."
                            <br />
                            <div style='display: inline-block; width: 200px; font-weight: bold;'>Finished (in %):</div>".$memberValue->myProjectPercent()."
                        </div>";
        }

        $fields->push(LiteralField::create("floorTitle", $myHtml));//getBewertungByProject





        $fields->push(LiteralField::create("floorTitle", "</div>"));
        return $fields;
    }
}
