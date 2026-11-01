<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;

class AnsprechPartner extends DataObject {

	private static $plural_name = "Ansprechperson";
	private static $singular_name = "Ansprechperson";

	private static $db = array(
		'Name' => 'Varchar(100)',
		'Telephone' => 'Varchar(100)',
		'Email' => 'Varchar(100)',
		'SubPosition' => 'Varchar(100)'
	);

	private static $has_one = array(
		'Picture' => Image::class
	);

	private static $has_many = array(
		
	);

	private static $belongs_many_many = array(
	);

	private static $owns = array(
	    'Picture'
	);


	public function getCMSFields() {
	  	$fields = parent::getCMSFields();

	  	return $fields;
	}

	private static $summary_fields = array(
		'getThumbnail' => 'Bild',
		'Name' => 'Name',
		'Telephone' => 'Telefon',
		'Email' => 'E-Mail'
	);

	public function getThumbnail() { 
		return $this->Picture()->CMSThumbnail(); 
	}

}
