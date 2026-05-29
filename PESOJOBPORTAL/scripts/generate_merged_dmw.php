<?php
// Quick standalone generator to merge DMW form + attachments for a given user id.
// Run from project: php scripts/generate_merged_dmw.php

$project = dirname(__DIR__);
require $project . '/vendor/autoload.php';

use setasign\Fpdi\Fpdi;
use Dompdf\Dompdf;

$userId = 3;
$mainForm = $project . '/public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
if (! file_exists($mainForm)) {
    echo "Template not found: $mainForm\n";
    exit(1);
}

$tmpDir = $project . '/storage/app/tmp/ofw_forms';
if (! is_dir($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

try {
    $fpdi = new Fpdi();
} catch (Throwable $e) {
    echo "FPDI init failed: " . $e->getMessage() . "\n";
    exit(1);
}

// import template pages
$templatePages = $fpdi->setSourceFile($mainForm);
for ($pageNumber = 1; $pageNumber <= $templatePages; $pageNumber++) {
    $templateId = $fpdi->importPage($pageNumber);
    $size = $fpdi->getTemplateSize($templateId);
    $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
    $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
    $fpdi->useTemplate($templateId);
}

// read attachments metadata
$metaPath = $project . '/storage/app/ofw_attachments/' . $userId . '.json';
$attachments = [];
if (file_exists($metaPath)) {
    $json = file_get_contents($metaPath);
    $attachments = json_decode($json, true) ?: [];
}

foreach ($attachments as $index => $attachmentPath) {
    $attachmentFullPath = $project . '/storage/app/public/' . $attachmentPath;
    if (! file_exists($attachmentFullPath)) {
        continue;
    }
    $mime = mime_content_type($attachmentFullPath) ?: '';
    if (strtolower($mime) === 'application/pdf' || str_ends_with($attachmentFullPath, '.pdf')) {
        try {
            $pageCount = $fpdi->setSourceFile($attachmentFullPath);
            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $templateId = $fpdi->importPage($pageNumber);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }
        } catch (Throwable $e) {
            echo "Failed appending PDF: " . $e->getMessage() . "\n";
        }
    } else {
        // convert image to PDF using Dompdf
        $data = file_get_contents($attachmentFullPath);
        if ($data === false) continue;
        $mime = mime_content_type($attachmentFullPath) ?: 'image/jpeg';
        $html = '<!doctype html><html><head><meta charset="utf-8"><style>@page{margin:0}html,body{width:100%;height:100%;margin:0}body{display:flex;align-items:center;justify-content:center;background:#fff}img{max-width:100%;max-height:100%;object-fit:contain}</style></head><body><img src="data:' . $mime . ';base64,' . base64_encode($data) . '" alt="attachment"></body></html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();
        $pdfPath = $tmpDir . '/attachment_' . $userId . '_' . $index . '.pdf';
        file_put_contents($pdfPath, $dompdf->output());

        try {
            $pageCount = $fpdi->setSourceFile($pdfPath);
            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $templateId = $fpdi->importPage($pageNumber);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }
        } catch (Throwable $e) {
            echo "Failed appending converted image PDF: " . $e->getMessage() . "\n";
        }
    }
}

$mergedPath = $tmpDir . '/dmw_merged_' . $userId . '_' . time() . '.pdf';
$fpdi->Output($mergedPath, 'F');

if (file_exists($mergedPath)) {
    echo "Merged PDF created: " . realpath($mergedPath) . "\n";
    echo "Size: " . filesize($mergedPath) . " bytes\n";
    exit(0);
}

echo "Failed to create merged PDF.\n";
exit(1);
