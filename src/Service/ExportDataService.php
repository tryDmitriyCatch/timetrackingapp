<?php

namespace App\Service;

use App\Utils\DatesUtils;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ExportDataService
 * @package AppBundle\Service
 */
class ExportDataService
{
    /**
     * @param array $results
     * @return StreamedResponse
     */
    public function exportCSVAction(array $results): StreamedResponse
    {
        $response = new StreamedResponse();
        $headerArrayData = $this->getHeaderArrayData();
        $totalTime = $this->getTotalHoursAndMinutesArray($results);
        $response->setCallback(
            function () use ($headerArrayData, $results, $totalTime) {
                $handle = fopen('php://output', 'rb+');
                fputcsv($handle, $headerArrayData);
                foreach ($results as $row) {
                    $data = [
                        $row->getTitle(),
                        $row->getDescription(),
                        $row->getTimeSpent()
                    ];
                    fputcsv($handle, $data);
                }
                fputcsv($handle, ['', 'Total Time Spent', $totalTime['hours'] . ' hours and ' . $totalTime['minutes'] . ' minutes']);
                fclose($handle);
            }
        );

        return $response;
    }

    /**
     * @param array $results
     * @return array
     */
    private function getTotalHoursAndMinutesArray(array $results): array
    {
        $totalMinutes = DatesUtils::getSumOfAllTimeSpent($results);
        return [
            'minutes' => DatesUtils::getMinutes($totalMinutes),
            'hours' => DatesUtils::getHours($totalMinutes)
        ];
    }

    /**
     * @return array
     */
    private function getHeaderArrayData(): array
    {
        return [
            'Title',
            'Description',
            'Time spent'
        ];
    }

    /**
     * @param string $htmlTemplate
     * @return string|null
     */
    public function exportPDF(string $htmlTemplate): ?string
    {
        $domPDF = new Dompdf($this->setPDFOptionsAction());
        $htmlDocument = mb_convert_encoding($htmlTemplate, 'HTML-ENTITIES', 'UTF-8');
        $domPDF->loadHtml($htmlDocument, 'UTF-8');
        $domPDF->setPaper('A4', 'portrait');
        $domPDF->render();

        return $domPDF->output();
    }

    /**
     * @return Options
     */
    private function setPDFOptionsAction(): Options
    {
        $options = new Options();
        $options->setIsHtml5ParserEnabled(true);
        $options->setIsRemoteEnabled(true);
        $options->setDefaultFont('Open Sans');

        return $options;
    }
}
