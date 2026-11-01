<?php

use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class ProjectPageController extends PageController {

	protected function init() {
        parent::init();
        
        // Block the combined JS from parent to reorder them
        Requirements::block('javascripts.js');
        
        // Get theme path
        $myThemes = SSViewer::get_themes();
        $myThemePath = "themes/".$myThemes[1]."/";
        
        // CRITICAL: Load display-logic IMMEDIATELY after entwine (which is loaded in parent)
        Requirements::javascript('unclecheese/display-logic: client/dist/js/bundle.js');
        Requirements::css('unclecheese/display-logic: client/dist/styles/bundle.css');
        
        // Now load other JS after display-logic
        Requirements::javascript($myThemePath.'javascript/jquery-ui.min.js');
        Requirements::javascript($myThemePath.'javascript/popper.min.js');
        Requirements::javascript($myThemePath.'javascript/bootstrap.min.js');
        Requirements::javascript($myThemePath.'javascript/datatables.min.js');
        Requirements::javascript($myThemePath.'javascript/script.js');
    }

}
