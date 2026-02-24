<?php

namespace app\RegistrationForm;

use app\RegistrationForm\RegistrationForm_Step1;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Upload;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\Debug;
use SilverStripe\MultiForm\Forms\MultiForm;
use SilverStripe\MultiForm\Models\MultiFormStep;
use SilverStripe\SiteConfig\SiteConfig;

class RegistrationForm extends MultiForm {
    private static $start_step = RegistrationForm_Step1::class;

    public function finish($data, $form) {
        parent::finish($data, $form);

        $steps = MultiFormStep::get()->filter(['SessionID' => $this->session->ID]);

        if($steps) {
            $allData = $this->mergeStepData($steps);
            if (!$allData) {
                return;
            }


            // save $allDate to Project 
            $myProject = \Project::create();
            $myProject->Completed = 1;
            $myProject->write();
            $myCompetition = $this->getActiveCompetition();
            $myProject->CompetitionID = $myCompetition->ID;
            $myProject->update($allData);
            $myProject->write();

            // move files to project folder
            $myFiles = RegistrationFormFiles::get()->filter(['MultiFormSessionID' => $this->session->ID]);
            $randomString = $myProject->ID."-".substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
            foreach ($myFiles as $file) {
                $oldPath = $file->generatedPath();
                
                $newPath = ASSETS_PATH . "/projects/" . $myCompetition->ShortCode . "/" .$randomString . "/" . $file->FileGroup . "/" . $file->FileName;
                if (!file_exists(dirname($newPath))) {
                    //mkdir(dirname($newPath), 0755, true);
                }
                //rename($oldPath, $newPath);

                // optionally update file record with new path or project association
                $fileClass = File::get_class_for_file_extension(File::get_file_extension($newPath));
                $newFile = Injector::inst()->create($fileClass);
                $newFile->setFromLocalFile($oldPath, "projects/" . $myCompetition->ShortCode . "/" .$randomString . "/" . $file->FileGroup . "/" . $file->FileName);
                $newFile->write();
                $newFile->publishFile();

                if ($file->FileGroup == 1) {
                    $myProject->Dokumente()->add($newFile);
                } elseif ($file->FileGroup == 2) {
                    $myProject->Lebenslaufs()->add($newFile);
                } elseif ($file->FileGroup == 3) {
                    $myProject->Urkunden()->add($newFile);
                }
            }

            $myProject->write();

            $config = SiteConfig::current_site_config();
                
            $email = new Email();
            $email->setFrom("genius@riz-up.at");

            $email->setSubject($config->MemberNewProjectTitle); 
            $messageBody = str_replace(
                "{PROJECT_TITLE}",
                (string)($myProject->IdeenTitle ?? ''),
                (string)($config->MemberNewProject ?? '')
            );

            $messageBody = str_replace("{PROJECT_STATUS}", (string)($myProject->Status ?? ''), $messageBody);
            
            $email->setBody($messageBody);
            
            
            $email->setTo($myProject->Email);
            $email->send();

        }

        //$this->session->delete();

        $this->controller->redirect($this->controller->Link() . 'registrationfinished');
    }

    private function mergeStepData($steps): array
    {
        $allData = [];

        foreach ($steps as $step) {
            $stepData = $step->loadData();
            if (is_array($stepData)) {
                $allData = array_merge($allData, $stepData);
            }
        }

        return $allData;
    }

    public function getAllCompetitions() {
        return \Competition::get();
    }

    public function getActiveCompetition() {
        return $this->getAllCompetitions()->filter(array("Active"=>"1"))->First();
    }
}