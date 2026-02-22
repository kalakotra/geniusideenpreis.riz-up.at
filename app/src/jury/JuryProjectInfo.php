<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class JuryProjectInfo extends DataObject {
	private static $db = array(
		'Text' => 'Text'
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
