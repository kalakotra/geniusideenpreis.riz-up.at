<?php

use SilverStripe\Admin\LeftAndMain;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Versioned\RecursivePublishable;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

class JuryAdmin extends LeftAndMain {



	//private static $menu_icon_class = 'font-icon-menu-security';
	private static $url_segment = 'jury'; 
    private static $url_rule = '/$Action/$ID/$OtherID';
	private static $menu_title = "Jury";
    private static $tree_class = Jury::class;

    public function init()
    {
        parent::init();
        Requirements::javascript('silverstripe/cms: client/dist/js/bundle.js');
        //Requirements::javascript('app/javascript/script.js');
        Requirements::customCSS(<<<CSS
            .cms-content-header-tabs.cms-tabset-nav-primary > ul {
                display: none;
            }
CSS
);
    }

    public function getEditForm($id = null, $fields = null)
    {

        $siteConfig = Jury::current_jury();
        $fields = $siteConfig->getCMSFields();

        // Tell the CMS what URL the preview should show
        $home = Director::absoluteBaseURL();
        $fields->push(new HiddenField('PreviewURL', 'Preview URL', $home));

        // Added in-line to the form, but plucked into different view by LeftAndMain.Preview.js upon load
        /** @skipUpgrade */
        $fields->push($navField = new LiteralField('SilverStripeNavigator', $this->getSilverStripeNavigator()));
        $navField->setAllowHTML(true);

        // Retrieve validator, if one has been setup (e.g. via data extensions).
        if ($siteConfig->hasMethod("getCMSValidator")) {
            $validator = $siteConfig->getCMSValidator();
        } else {
            $validator = null;
        }

        $actions = $siteConfig->getCMSActions();
        $negotiator = $this->getResponseNegotiator();
        /** @var Form $form */
        $form = Form::create(
            $this,
            'EditForm',
            $fields,
            $actions,
            $validator
        )->setHTMLID('Form_EditForm');
        $form->setValidationResponseCallback(function (ValidationResult $errors) use ($negotiator, $form) {
            $request = $this->getRequest();
            if ($request->isAjax() && $negotiator) {
                $result = $form->forTemplate();
                return $negotiator->respond($request, array(
                    'CurrentForm' => function () use ($result) {
                        return $result;
                    }
                ));
            }
        });
        $form->addExtraClass('flexbox-area-grow fill-height cms-content cms-edit-form');
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        if ($form->Fields()->hasTabSet()) {
            //$form->Fields()->findOrMakeTab('Root')->setTemplate('SilverStripe\\Forms\\CMSTabSet');
        }
        $form->setHTMLID('Form_EditForm');
        $form->loadDataFrom($siteConfig);
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));

        // Use <button> to allow full jQuery UI styling
        $actions = $actions->dataFields();
        if ($actions) {
            /** @var FormAction $action */
            foreach ($actions as $action) {
                $action->setUseButtonTag(true);
            }
        }

        $this->extend('updateEditForm', $form);

        return $form;


    }

    public function Breadcrumbs($unlinked = false)
    {
        return new ArrayList(array(
            new ArrayData(array(
                'Title' => static::menu_title(),
                'Link' => $this->Link()
            ))
        ));
    }
	
}