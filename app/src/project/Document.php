<?php

use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

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
		$currentUser = Security::getCurrentUser();
		if ($currentUser && $this->MemberID == $currentUser->ID) {
			return true;
		}

		return false;
	}
}