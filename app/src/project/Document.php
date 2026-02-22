<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Assets\File;

class Document extends DataObject {
	private static $db = array(
		'Description' => 'Text'
	);

	private static $has_one = array(
		'Project' => Project::class,
		'Member' => Member::class,
		'Document' => File::class
	);

	private static $owns = [
		'Document'
		
	];

	private static $cascade_deletes = [
        'Document'
    ];

	public function isOwner() {
		if ($this->MemberID == Member::currentUserID()) {
			return true;
		}

		return false;
	}
}