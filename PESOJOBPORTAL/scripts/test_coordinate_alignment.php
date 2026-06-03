<?php
require __DIR__ . '/../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

function generatePdf($outputPath, $useCorrectPages) {
    $mainForm = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
    $fpdi = new Fpdi();
    $templatePages = $fpdi->setSourceFile($mainForm);

    $defaults = [
        'name' => ['page' => 1, 'left' => 10, 'top' => 12, 'width' => 70, 'fontSize' => 12],
        'birthdate' => ['page' => 1, 'left' => 10, 'top' => 18, 'width' => 30, 'fontSize' => 10],
        'sex' => ['page' => 1, 'left' => 60, 'top' => 18, 'width' => 20, 'fontSize' => 10],
        'passport' => ['page' => 1, 'left' => 10, 'top' => 24, 'width' => 35, 'fontSize' => 10],
        'contact' => ['page' => 1, 'left' => 10, 'top' => 30, 'width' => 45, 'fontSize' => 10],
        'email' => ['page' => 1, 'left' => 10, 'top' => 34, 'width' => 55, 'fontSize' => 10],
        'contract' => ['page' => 1, 'left' => 10, 'top' => 50, 'width' => 70, 'fontSize' => 10],
        'narrative' => ['page' => 1, 'left' => 6, 'top' => 60, 'width' => 88, 'fontSize' => 10],
        'civil_status' => ['page' => 1, 'left' => 10, 'top' => 22, 'width' => 45, 'fontSize' => 10],
        'address_abroad' => ['page' => 1, 'left' => 10, 'top' => 38, 'width' => 88, 'fontSize' => 10],
        'address_ph' => ['page' => 1, 'left' => 10, 'top' => 42, 'width' => 88, 'fontSize' => 10],
        'relative_name' => ['page' => 1, 'left' => 10, 'top' => 54, 'width' => 70, 'fontSize' => 10],
        'relative_relationship' => ['page' => 1, 'left' => 10, 'top' => 58, 'width' => 40, 'fontSize' => 10],
        'relative_contact' => ['page' => 1, 'left' => 52, 'top' => 58, 'width' => 42, 'fontSize' => 10],
        'bank_account_no' => ['page' => 1, 'left' => 10, 'top' => 80, 'width' => 30, 'fontSize' => 10],
        'bank_name' => ['page' => 1, 'left' => 42, 'top' => 80, 'width' => 30, 'fontSize' => 10],
        'bank_branch' => ['page' => 1, 'left' => 74, 'top' => 80, 'width' => 20, 'fontSize' => 10],
        'account_name' => ['page' => 1, 'left' => 10, 'top' => 84, 'width' => 60, 'fontSize' => 10],
        'signature_printed' => ['page' => 1, 'left' => 10, 'top' => 90, 'width' => 50, 'fontSize' => 10],
        'help-repatriation' => ['page' => 1, 'left' => 10, 'top' => 52, 'width' => 5, 'fontSize' => 10],
        'help-legal' => ['page' => 1, 'left' => 28, 'top' => 52, 'width' => 5, 'fontSize' => 10],
        'help-medical' => ['page' => 1, 'left' => 46, 'top' => 52, 'width' => 5, 'fontSize' => 10],
        'help-rescue' => ['page' => 1, 'left' => 64, 'top' => 52, 'width' => 5, 'fontSize' => 10],
        'help-welfare_senior' => ['page' => 1, 'left' => 10, 'top' => 56, 'width' => 5, 'fontSize' => 10],
        'help-shipment' => ['page' => 1, 'left' => 28, 'top' => 56, 'width' => 5, 'fontSize' => 10],
        'help-compassionate' => ['page' => 1, 'left' => 46, 'top' => 56, 'width' => 5, 'fontSize' => 10],
        'help-food' => ['page' => 1, 'left' => 64, 'top' => 56, 'width' => 5, 'fontSize' => 10],
        'help-transportation' => ['page' => 1, 'left' => 10, 'top' => 60, 'width' => 5, 'fontSize' => 10],
        'help-temporary_shelter' => ['page' => 1, 'left' => 28, 'top' => 60, 'width' => 5, 'fontSize' => 10],
        'help-others' => ['page' => 1, 'left' => 46, 'top' => 60, 'width' => 30, 'fontSize' => 10],
    ];

    // If correct pages are requested, adjust coordinates for Page 2
    if ($useCorrectPages) {
        $page2Fields = [
            'narrative', 'bank_account_no', 'bank_name', 'bank_branch', 'account_name', 'signature_printed',
            'help-repatriation', 'help-legal', 'help-medical', 'help-rescue',
            'help-welfare_senior', 'help-shipment', 'help-compassionate', 'help-food',
            'help-transportation', 'help-temporary_shelter', 'help-others'
        ];
        foreach ($page2Fields as $field) {
            if (isset($defaults[$field])) {
                $defaults[$field]['page'] = 2;
            }
        }
    }

    for ($pageNumber = 1; $pageNumber <= $templatePages; $pageNumber++) {
        $templateId = $fpdi->importPage($pageNumber);
        $size = $fpdi->getTemplateSize($templateId);
        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
        $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
        $fpdi->useTemplate($templateId);

        $fpdi->SetTextColor(255, 0, 0);

        foreach ($defaults as $fieldKey => $coords) {
            $fieldPage = $coords['page'] ?? 1;
            if ($useCorrectPages) {
                if ($fieldPage !== $pageNumber) {
                    continue;
                }
            } else {
                if ($pageNumber !== 1) {
                    continue;
                }
            }

            $left = $coords['left'];
            $top = $coords['top'];
            $width = $coords['width'];
            $fontSize = $coords['fontSize'];

            $x = ($size['width'] * $left) / 100;
            $y = ($size['height'] * $top) / 100;
            $w = max(10, ($size['width'] * $width) / 100);

            $fpdi->SetFont('Helvetica', '', $fontSize);
            $fpdi->SetXY($x, $y);
            $fpdi->Cell($w, 4.5, $fieldKey, 1, 0, 'L'); // draw border to see alignment
        }
    }

    $fpdi->Output($outputPath, 'F');
}

$tmpDir = __DIR__ . '/../storage/app/tmp';
if (!is_dir($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

generatePdf($tmpDir . '/dmw_test_page1_only.pdf', false);
generatePdf($tmpDir . '/dmw_test_pages_split.pdf', true);

echo "Done generating test PDFs.\n";
