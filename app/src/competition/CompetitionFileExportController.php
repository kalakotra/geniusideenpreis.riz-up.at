<?php

namespace app\Competition;

use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use ZipArchive;

class CompetitionFileExportController extends Controller {
    private static $allowed_actions = [
        'index'
    ];

    public function index(HTTPRequest $request) {
        $id = $request->param('ID');
        
        $competition = Competition::get()->byID($id);
        if (!$competition) {
            return $this->httpError(404, 'Wettbewerb nicht gefunden'); 
        }

        $zipNames = $this->generateApplicationsZipArchive($competition->ID);
    }


    /**
	 * @return array
	 */
	protected function generateApplicationsZipArchive($competitionId)
	{
		$baseFolder = Director::baseFolder();
		$zip = new ZipArchive;
		$zipNumber = 1;

		//We can't create zip archive for a big number of files because this will lead to a memory overflow
        $baseFolder = Director::baseFolder();
        $targetDirectory = $baseFolder.static::$target_dir;
        $zipname = $targetDirectory.'/doc-'.$competitionId.'.zip';

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (file_exists($zipname)) {
            unlink($zipname);
        }

        $projects = Project::get()
            ->filter([
                'CompetitionID' => $competitionId,
            ])
            ->filterByCallback(function ($project) {
                $bewertung = $project->Bewertung()->filter('Status', '3');
                return $bewertung->count() > 0;
            });

		//The initial available memory before starting zip generation
		$memory_limit = intval(ini_get('memory_limit'));
		// catch misconfigured memory_limit on h_da Server: Set fallback value to 1024M (which is the real memory limit of the server)
		$memory_limit = ($memory_limit  <= 0) ? 1024 : $memory_limit;
		$initAllowedMemory = $memory_limit*1024*1024 - memory_get_usage();

		$allowedMemory = $initAllowedMemory;

		$zip->open($zipname, ZipArchive::CREATE);

		// echo "Creating zip archive: $zipname <br />";

		foreach ($projects as $application) {
			$filesCount = $application->Files()->count();

			if ($filesCount > 0) {
				// echo "Processing application: {$application->ID} with {$filesCount} files <br />";
				//We predict the needed memory with some safety margin by substracting the the double of the file size
				//the rest $allowedMemory value
				$allowedMemory -= $application->getTotalFilesSize()*2;
				//If the remaining value of $allowedMemory is equal or less than 0 then we close the currently opened
				//archive and remove its reference in the memory then we create a new archive to hold the files of the
				//current application
				if ($allowedMemory <= 0) {
					// echo "Allowed memory is less than 0, closing zip archive: $zipname <br />";
					$zip->close();
					// echo "Closing zip archive: $zipname <br /><br />";

					$allowedMemory = $initAllowedMemory;
					unset($zip);
					$zip = new ZipArchive;
					$zipNumber = $application->ID;
					$zipname = $baseFolder.'/'.static::$target_dir.'/antraege-unterlagen-ab-'.$zipNumber.'.zip';
					// echo "Creating new zip archive: $zipname <br />";

					// commented out because it will not add last application files to the zip archive and it make error on $zip->close(); (line 304)
					//if ($application->ID != $lastApplicationId) {
						$zip->open($zipname, ZipArchive::CREATE);
						foreach ($application->Files() as $file) {
							// echo "Adding file: {$file->Name} to zip archive: $zipname <br />";
							$zip->addFromString(
								'antraege-unterlagen-ab-'.$zipNumber.'-'.$application->getFolderPath().'/'.$file->Name,
								$file->getString()
							);
						}
					//}

				} else {
					// echo "Allowed memory is enough, adding files to zip archive: $zipname <br />";
					foreach ($application->Files() as $file) {
						// echo "Adding file: {$file->Name} to zip archive: $zipname <br />";
						$zip->addFromString(
							'antraege-unterlagen-ab-'.$zipNumber.'-'.$application->getFolderPath().'/'.$file->Name,
							$file->getString()
						);
					}
				}
			}

		}
		// echo "Closing zip archive: $zipname <br /><br />";
		$code_close = $zip->close();

		$zipNames = [];
		$zipNames[] = $zipname;

		# set access permissions on all zip files
		foreach($zipNames as $tmpZipName) {
			// we need to enable access to all users and groups
			@chmod($tmpZipName, 0777);
		}

		return $zipNames;
	}

	/**
	 * Returns the content of the archive file with the given name e.g "antraege-unterlagen-ab-1"
	 * @example url: http://localhost/asta-rmv-rueckerstattung/applications/export/files/antraege-unterlagen-ab-1.zip
	 * @param HTTPRequest $request
	 * @return false|string
	 * @throws \SilverStripe\Control\HTTPResponse_Exception
	 */
	public function files(HTTPRequest $request)
	{
		$fileName = $request->param('fileName');
		$ext = $request->getExtension();
		$mimeType = mime_content_type(Director::baseFolder().static::$target_dir.'/'.$fileName.'.'.$ext);

		if (empty($fileName)) {
			$this->httpError(404);
		}
		$this->getResponse()->addHeader(
			'Content-Type',
			$mimeType
		);

		$this->getResponse()->addHeader(
			'Content-Disposition',
			'attachment;filename="'.$fileName.'.'.$ext.'"'
		);

		return  file_get_contents(Director::baseFolder().static::$target_dir.'/'.$fileName.'.'.$ext);
	}

	/**
	 * Returns an array of urls that allow to access the files stored in application/tmp/export folder
	 * which are the exported excel sheet of all the applications as well as the zip files containing
	 * the application documents
	 *
	 * @return array
	 */
	public static function getFileLinks()
	{
		$links = [];
		foreach (scandir(Director::baseFolder().static::$target_dir) as $fileName) {
			if (!is_dir($fileName) && strpos($fileName, '.') !== 0) {
				$links[] = [
					'URL' => Director::absoluteBaseURL().'/applications/export/files/'.$fileName,
					'Name' => $fileName,
					'Date' => date('d.m.Y H:i', filemtime(Director::baseFolder().static::$target_dir.'/'.$fileName))
				];
			}
		}

		return $links;
	}

	public function cleanDir($dir)
	{
		if (!is_dir($dir)) {
			return true;
		}
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? $this->cleanDir("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}
}