<?php
require __DIR__ . '/../vendor/autoload.php';

$pdfPath = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
$fpdi = new \setasign\Fpdi\Fpdi();
$pages = $fpdi->setSourceFile($pdfPath);

for ($i = 1; $i <= $pages; $i++) {
    $fpdiPage = new \setasign\Fpdi\Fpdi();
    $fpdiPage->setSourceFile($pdfPath);
    $id = $fpdiPage->importPage($i);
    $size = $fpdiPage->getTemplateSize($id);
    $orient = $size['width'] > $size['height'] ? 'L' : 'P';
    $fpdiPage->AddPage($orient, [$size['width'], $size['height']]);
    $fpdiPage->useTemplate($id);
    
    $out = __DIR__ . "/../public/dmw_page_$i.pdf";
    $fpdiPage->Output($out, 'F');
    echo "Saved Page $i to $out\n";
}
