<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\AssetAdmin\Forms\UploadField;

    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [
        	"AnsprechPartner" => AnsprechPartner::class,
			"WeitereInfo" => File::class
        ];

        private static $owns = [
            'WeitereInfo'
        ];

        function getCMSFields() { 
			$fields = parent::getCMSFields();
			$persons = AnsprechPartner::get()->sort("Name");
			$fields->addFieldToTab("Root.SideBox", DropdownField::create("AnsprechPartnerID", "Ansprechperson", $persons->map())->setEmptyString('(Select one)'));

			$fields->addFieldToTab("Root.SideBox", new UploadField("WeitereInfo"));
			    
			return $fields; 
		}
    }
}
