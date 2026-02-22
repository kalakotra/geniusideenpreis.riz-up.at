<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class JuryLink extends DataObject {
	private static $db = array(
		'URL' => 'Varchar(100)',
		'Title' => 'Varchar(100)',
		'Description' => 'Text'
	);

	private static $has_one = array(
		'Project' => Project::class,
		'Member' => Member::class
	);

	public function isOwner() {
		if ($this->MemberID == Member::currentUserID()) {
			return true;
		}

		return false;
	}
	
}
