<?php
require __DIR__ . '/../vendor/autoload.php';
$fpdi = new \setasign\Fpdi\Fpdi();
$pages = $fpdi->setSourceFile(__DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf');
for ($i = 1; $i <= $pages; $i++) {
    $id = $fpdi->importPage($i);
    $size = $fpdi->getTemplateSize($id);
    echo "Page $i: width={$size['width']}, height={$size['height']}\n";
}
