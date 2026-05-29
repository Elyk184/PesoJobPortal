<?php
require __DIR__ . "/../vendor/autoload.php";
$pdfPath = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
if (! file_exists($pdfPath)) {
    echo "Template missing: $pdfPath\n";
    exit(1);
}
$fpdi = new \setasign\Fpdi\Fpdi();
$pages = $fpdi->setSourceFile($pdfPath);
$defaults = require __DIR__ . '/../app/Http/Controllers/dmw_defaults.php';
$fieldCoords = $defaults();
for ($i=1;$i<=$pages;$i++){
    $id = $fpdi->importPage($i);
    $size = $fpdi->getTemplateSize($id);
    $orient = $size['width'] > $size['height'] ? 'L' : 'P';
    $fpdi->AddPage($orient, [$size['width'],$size['height']]);
    $fpdi->useTemplate($id);
    if ($i === 1) {
        $fpdi->SetTextColor(255,0,0);
        $fpdi->SetFont('Helvetica','',8);
        foreach ($fieldCoords as $k=>$c){
            $x = ($size['width'] * $c['left'])/100;
            $y = ($size['height'] * $c['top'])/100;
            $fpdi->SetXY($x,$y);
            $fpdi->Cell(40,4,$k,0,0,'L');
        }
    }
}
$out = __DIR__ . '/../storage/app/tmp/dmw_sample_debug.pdf';
if (! is_dir(dirname($out))) mkdir(dirname($out),0777,true);
$fpdi->Output($out,'F');
echo "Written: $out\n";