<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

class JuryProjectInfo extends DataObject {
	private static $db = array(
		'Text' => 'Text'
	);

	private static $has_one = array(
		'Project' => Project::class,
		'Member' => Member::class
	);

	public function isOwner() {
		$currentUser = Security::getCurrentUser();
		if ($currentUser && $this->MemberID == $currentUser->ID) {
			return true;
		}

		return false;
	}
}
