<?php

namespace app\RegistrationForm;

use SilverStripe\MultiForm\Models\MultiFormSession;
use SilverStripe\ORM\DataObject;

class RegistrationFormFiles extends DataObject {

    private static $table_name = 'app_RegistrationFormFiles';

    private static $db = [
        'FileGroup' => 'Int', // 1 = Dokumente, 2 = Lebenslauf, 3 = Urkunde
        'FileName' => 'Varchar',
    ];

    private static array $has_one = [
        'MultiFormSession' => MultiFormSession::class
    ];

    public function generatedPath($absolute = true) {
        $multiFormSessionID = $this->MultiFormSessionID;
        $fileGroup = $this->FileGroup;
        $path = "/temp/registration-form/" . $multiFormSessionID . "/" . $fileGroup . "/" . $this->FileName;
        return $absolute ? ASSETS_PATH . $path : $path;
    }

    public function getSize() {
        $filePath = $this->generatedPath();
        if (file_exists($filePath)) {
            $sizeInBytes = filesize($filePath);
            if ($sizeInBytes >= 1073741824) {
                return number_format($sizeInBytes / 1073741824, 2) . ' GB';
            } elseif ($sizeInBytes >= 1048576) {
                return number_format($sizeInBytes / 1048576, 2) . ' MB';
            } elseif ($sizeInBytes >= 1024) {
                return number_format($sizeInBytes / 1024, 2) . ' KB';
            } else {
                return $sizeInBytes . ' Bytes';
            }
        }
        return 'Datei nicht gefunden';
    }

    public function getTitle() {
        return $this->FileName;
    }

}