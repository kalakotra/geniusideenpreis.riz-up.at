<?php

namespace app\Competition;

use Competition;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Project;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DataObjectSchema;

class CompetitionExportController extends \SilverStripe\Control\Controller
{
    private const BEWERTUNG_EXPORT_FIELDS = [
        'Jury.Kuerzel' => 'Juror',
        'sumAllPunkte' => 'Gesamtpunkte',
    ];

    private $bewertungBlockCount = 0;
    private $criteriaMap = [];

    private static $allowed_actions = [
        'index',
    ];

    public function index(\SilverStripe\Control\HTTPRequest $request)
    {
        $id = $request->param('ID');
        $competition = Competition::get()->byID($id);

        if (!$competition) {
            return $this->httpError(404);
        }

        $projects = Project::get()
            ->filter([
                'CompetitionID' => $competition->ID,
            ]);
            // ->filterByCallback(function ($project) {
            //     $bewertung = $project->Bewertung()->filter('Status', '3');
            //     return $bewertung->count() > 0;
            // });
        $fileName = $competition->ShortCode ? "competition-{$competition->ShortCode}" : "competition-{$competition->ID}";
        $filePath = $this->generateSingleExcelDocument(
            $projects,
            $fileName,
            '/exports/' . $competition->ID,
            $competition
        );

        header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        readfile($filePath);
        exit;
    }

    protected function generateDataArray(DataObject $dataObject)
    {
        $dataArray = [];

        foreach ($this->getFields($dataObject) as $field) {
            if (strpos($field, 'Bewertung#') === 0) {
                $dataArray[] = $this->resolveBewertungFieldValue($dataObject, $field);
                continue;
            }

            if ($field === 'Bezirk') {
                $dataArray[] = $this->resolveBezirkValue($dataObject);
                continue;
            }

            if ($field === 'Kategorie') {
                $dataArray[] = $dataObject->Kategories()->Title ?? '';
                continue;
            }

            if ($field === 'Created' || $field === 'LastEdited') {
                $dataArray[] = $dataObject->dbObject($field)->Nice();
                continue;
            }

            if (!$dataObject->hasField($field) && strpos($field, '.') > 0) {
                $dataArray[] = $dataObject->relField($field) ?? '';

                continue;
            }

            $dataArray[] = $dataObject->{$field};
        }

        return $dataArray;
    }

    /**
     * @param iterable $dataObjects
     * @param string $title
     * @param string $folderName
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    protected function generateSingleExcelDocument($dataObjects, string $title, string $folderName, $competition = null)
    {
        $baseFolder = Director::baseFolder();
        $targetDirectory = rtrim($baseFolder, '/') . '/' . trim($folderName, '/');
        $targetFile = "{$targetDirectory}/{$title}-export.xlsx";
        $this->bewertungBlockCount = $this->resolveBewertungBlockCount($dataObjects);
        $this->criteriaMap = $this->resolveCompetitionCriteriaMap($dataObjects, $competition);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($title);
        $this->insertData($sheet, $dataObjects);

        $writer = new Xlsx($spreadsheet);
        $writer->save($targetFile);
        chmod($targetFile, 0777);

        return $targetFile;
    }

    /**
     * @param DataObject $dataObject
     * @return array
     */
    protected function getFields(DataObject $dataObject)
    {
        $dataObjectSchema = new DataObjectSchema();
        $includedFields = (array)$dataObject->config()->get('included_fields');

        $schemaFields = array_keys($dataObjectSchema->databaseFields(get_class($dataObject)));
        $fields = !empty($includedFields) ? $includedFields : $schemaFields;

        $myFields = [];
        foreach ($fields as $field) {
            if ($field === 'Bewertung') {
                for ($index = 1; $index <= $this->bewertungBlockCount; $index++) {
                    foreach (array_keys(self::BEWERTUNG_EXPORT_FIELDS) as $bewertungField) {
                        $myFields[] = "Bewertung#{$index}.{$bewertungField}";
                    }

                    foreach ($this->criteriaMap as $criteriaId => $criteriaTitle) {
                        $myFields[] = "Bewertung#{$index}.CompetitionCriteria#{$criteriaId}.CriteriaPunkte";
                        $myFields[] = "Bewertung#{$index}.CompetitionCriteria#{$criteriaId}.CriteriaKommentar";
                    }
                }
                continue;
            }

            $myFields[] = $field;
        }
        
        return $myFields;
    }

    /**
     * @param Worksheet $sheet
     * @param iterable $dataObjects
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function insertData(Worksheet $sheet, $dataObjects)
    {
        $dataArray = [];
        $headersAdded = false;

        foreach ($dataObjects as $dataObject) {
            if (!$headersAdded) {
                $dataArray[] = $this->generateExcelHeaders($dataObject);
                $headersAdded = true;
            }

            $dataArray[] = $this->generateDataArray($dataObject);
        }

        if (empty($dataArray)) {
            return;
        }

        $sheet->fromArray(
            $dataArray,
            null,
            'A4'
        );

        $this->styleSheet($sheet);
    }

    protected function styleSheet(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        for ($columnIndex = 1; $columnIndex <= $highestColumnIndex; $columnIndex++) {
            $letter = Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->getColumnDimension($letter)->setWidth(25);
        }
        $sheet->getColumnDimension('A')->setWidth(5);

        $sheet->getStyle("A4:{$highestColumn}4")->getFont()->setBold(true)
            ->setSize(14);

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->getAlignment()->setWrapText(true);
    }

    protected function generateExcelHeaders(DataObject $firstObject)
    {
        return array_map(
            function ($field) use ($firstObject) {
                if (strpos($field, 'Bewertung#') === 0) {
                    return $this->resolveBewertungFieldLabel($field);
                }

                return $firstObject->fieldLabel($field);
            },
            $this->getFields($firstObject)
        );
    }

    protected function resolveBezirkValue($dataObject)
    {
        try {
            return $dataObject->bezirkNameExport() ?? '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    protected function resolveBewertungBlockCount($dataObjects)
    {
        $max = 0;

        foreach ($dataObjects as $dataObject) {
            if (!$dataObject instanceof DataObject) {
                continue;
            }

            try {
                $count = $dataObject->Bewertung()->count();
            } catch (\Throwable $e) {
                continue;
            }

            if ($count > $max) {
                $max = $count;
            }
        }

        return $max;
    }

    protected function resolveBewertungFieldLabel(string $field)
    {
        if (preg_match('/^Bewertung#(\d+)\.CompetitionCriteria#(\d+)\.(CriteriaPunkte|CriteriaKommentar)$/', $field, $criteriaMatches)) {
            $index = (int)$criteriaMatches[1];
            $criteriaId = (int)$criteriaMatches[2];
            $metric = $criteriaMatches[3];
            $criteriaTitle = $this->criteriaMap[$criteriaId] ?? "Criteria {$criteriaId}";
            $suffix = $metric === 'CriteriaKommentar' ? ' (Komentar)' : '';

            return "Bewertung {$index} - {$criteriaTitle}{$suffix}";
        }

        if (!preg_match('/^Bewertung#(\d+)\.(.+)$/', $field, $matches)) {
            return $field;
        }

        $index = (int)$matches[1];
        $innerField = $matches[2];
        $innerLabel = self::BEWERTUNG_EXPORT_FIELDS[$innerField] ?? $innerField;

        return "Bewertung {$index} - {$innerLabel}";
    }

    protected function resolveBewertungFieldValue(DataObject $dataObject, string $field)
    {
        if (preg_match('/^Bewertung#(\d+)\.CompetitionCriteria#(\d+)\.(CriteriaPunkte|CriteriaKommentar)$/', $field, $criteriaMatches)) {
            $index = (int)$criteriaMatches[1];
            $criteriaId = (int)$criteriaMatches[2];
            $metric = $criteriaMatches[3];

            try {
                $bewertungList = $dataObject->Bewertung();
            } catch (\Throwable $e) {
                return '';
            }

            $bewertung = $bewertungList
                ->sort('ID')
                ->limit(1, $index - 1)
                ->first();

            if (!$bewertung) {
                return '';
            }

            $criteria = $bewertung->CompetitionCriteria()
                ->filter('ID', $criteriaId)
                ->first();

            if (!$criteria) {
                return '';
            }

            return $criteria->{$metric} ?? '';
        }

        if (!preg_match('/^Bewertung#(\d+)\.(.+)$/', $field, $matches)) {
            return '';
        }

        $index = (int)$matches[1];
        $innerField = $matches[2];

        try {
            $bewertungList = $dataObject->Bewertung();
        } catch (\Throwable $e) {
            return '';
        }

        $bewertung = $bewertungList
            ->sort('ID')
            ->limit(1, $index - 1)
            ->first();

        if (!$bewertung) {
            return '';
        }

        if (strpos($innerField, '.') !== false) {
            return $bewertung->relField($innerField) ?? '';
        }

        if (method_exists($bewertung, $innerField)) {
            return $bewertung->{$innerField}();
        }

        return $bewertung->{$innerField} ?? '';
    }

    protected function resolveCompetitionCriteriaMap($dataObjects, $competition = null)
    {
        $criteriaMap = [];

        if ($competition instanceof DataObject) {
            try {
                foreach ($competition->CompetitionCriteria()->sort('Sort ASC, ID ASC') as $criteria) {
                    $criteriaMap[(int)$criteria->ID] = $criteria->Title;
                }
            } catch (\Throwable $e) {
                // Fallback to data-derived criteria map below.
            }
        }

        if (!empty($criteriaMap)) {
            return $criteriaMap;
        }

        foreach ($dataObjects as $dataObject) {
            if (!$dataObject instanceof DataObject) {
                continue;
            }

            try {
                $bewertungen = $dataObject->Bewertung();
            } catch (\Throwable $e) {
                continue;
            }

            foreach ($bewertungen as $bewertung) {
                foreach ($bewertung->CompetitionCriteria()->sort('Sort ASC, ID ASC') as $criteria) {
                    $criteriaMap[(int)$criteria->ID] = $criteria->Title;
                }
            }
        }

        return $criteriaMap;
    }
}
