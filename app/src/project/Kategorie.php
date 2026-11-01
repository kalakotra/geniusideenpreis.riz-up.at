<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBField;

class Kategorie extends DataObject {

	private static $default_sort = "Sort";

	private static $db = array(
		'Title' => 'Varchar(100)',
		'Sort' => 'Int'

	);

	private static $has_one = array(
				
	);

	private static $many_many = array(
		
	);

	private static $belongs_many_many = [
		'Competition' => Competition::class
	];

	private static $summary_fields = array(
		'Title' => 'Title',
		'myProjects' => 'Anzahl Projekte'
	);

	public function myProjects() {
		$projects = Project::get()->where("KategoriesID='".$this->ID."'");
		return DBField::create_field('HTMLVarchar', $projects->count() );
	}

	public function canView($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
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