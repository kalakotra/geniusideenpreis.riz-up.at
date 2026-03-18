<?php

namespace app\Competition;

use Competition;
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

	private static $target_dir = '/exports/';

    public function index(HTTPRequest $request) {
        $id = $request->param('ID');
        
        $competition = Competition::get()->byID($id);
        if (!$competition) {
            return $this->httpError(404, 'Wettbewerb nicht gefunden'); 
        }

        $zipNames = $this->generateApplicationsZipArchive($competition->ID);

		if (count($zipNames) > 0) {
			// Assuming only one zip file is generated, you can adjust this if multiple files are expected
			$zipName = $zipNames[0];
			$filePath = Director::baseFolder() . static::$target_dir . '/' . basename($zipName);

			if (file_exists($filePath)) {
				$this->getResponse()->addHeader('Content-Type', 'application/zip');
				$this->getResponse()->addHeader('Content-Disposition', 'attachment; filename="' . basename($zipName) . '"');
				return file_get_contents($filePath);
			} else {
				return $this->httpError(404, 'Datei nicht gefunden');
			}
		} else {
			return $this->httpError(500, 'Fehler bei der Erstellung der ZIP-Datei');
		}
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
        

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $projects = \Project::get()
            ->filter([
                'CompetitionID' => $competitionId,
            ])
            ->filterByCallback(function ($project) {
                $bewertung = $project->Bewertung()->filter('Status', '3');
                return $bewertung->count() > 0;
            });
		
		if ($projects->count() == 0) {
			return [];
		}
		
		$ShortCode = $projects->first()->Competition()->ShortCode;
		$zipname = $targetDirectory.'/competition-'.$ShortCode.'.zip';

        if (file_exists($zipname)) {
            unlink($zipname);
        }

		//The initial available memory before starting zip generation
		$memory_limit = intval(ini_get('memory_limit'));
		// catch misconfigured memory_limit on h_da Server: Set fallback value to 1024M (which is the real memory limit of the server)
		$memory_limit = ($memory_limit  <= 0) ? 1024 : $memory_limit;
		$initAllowedMemory = $memory_limit*1024*1024 - memory_get_usage();

		$allowedMemory = $initAllowedMemory;

		$zip->open($zipname, ZipArchive::CREATE);

		// echo "Creating zip archive: $zipname <br />";

		foreach ($projects as $project) {

			/*
			Lebenslaufs' => File::class,
			'Dokumente' => File::class,
			'Urkunden' => File::class,
			 */
			$LebenslaufsCount = $project->Lebenslaufs()->count();
			$DokumenteCount = $project->Dokumente()->count();
			$UrkundenCount = $project->Urkunden()->count();
			if ($LebenslaufsCount > 0) {
				$nr = 1;
				foreach ($project->Lebenslaufs() as $file) {
					if ($file->exists()) {
						$zip->addFromString($project->ProjectNumber.'/Lebenslaufs/'. $nr. '-' .$file->Name, $file->getString());
						$nr++;
					}
				}
			}

			if ($DokumenteCount > 0) {
				$nr = 1;
				foreach ($project->Dokumente() as $file) {
					if ($file->exists()) {
						$zip->addFromString($project->ProjectNumber.'/Dokumente/'. $nr. '-' .$file->Name, $file->getString());
						$nr++;
					}
				}
			}

			if ($UrkundenCount > 0) {
				$nr = 1;
				foreach ($project->Urkunden() as $file) {
					if ($file->exists()) {
						$zip->addFromString($project->ProjectNumber.'/Urkunden/'. $nr. '-' .$file->Name, $file->getString());
						$nr++;
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