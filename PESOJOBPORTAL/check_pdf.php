<?php
// This script generates a test filled PDF so we can visually verify field positions
require 'vendor/autoload.php';

$fpdi = new \setasign\Fpdi\Fpdi();
$pdfPath = __DIR__ . '/public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';

$pages = $fpdi->setSourceFile($pdfPath);

// The DMW RFA form is a standard 2-page form:
// Page 1: Header, Section A (OFW Info), Section B (Relative Info)
// Page 2: Section C (Assistance Types), Section D (Narrative), Section E (Bank), Certification

// Page dimensions: 207.772 x 294.894 (mm) - standard A4
$pageW = 207.772;
$pageH = 294.894;

// Let's extract text positions from the PDF by analyzing common DMW RFA form layouts
// The standard DMW RFA form has these sections on page 1:
// - Header with logos at ~y=5-25mm 
// - Form title "REQUEST FOR ASSISTANCE (RFA) FORM" at ~y=28mm
// - Mode checkboxes (Online/Walk-in/Referral) at ~y=32mm
// - Section A header at ~y=38mm
// - OFW Name row at ~y=42-50mm
// - Birthdate row at ~y=52-56mm  
// - Sex row at ~y=58-62mm
// - Civil Status row at ~y=64-70mm
// - Passport row at ~y=72-76mm
// - Address Abroad row at ~y=78-82mm
// - Address PH row at ~y=84-88mm
// - Contact row at ~y=90-94mm
// - Email row at ~y=96-100mm
// - Section B header at ~y=104mm
// - Relative name at ~y=108-116mm
// - Relative birthdate at ~y=118-122mm
// - Relationship at ~y=124-130mm
// - ID No at ~y=132-136mm
// - Relative Address at ~y=138-142mm
// - Relative Mobile at ~y=144-148mm
// - Relative Email at ~y=150-154mm

// Let's write labeled markers to the PDF to identify exact positions
for ($p = 1; $p <= $pages; $p++) {
    $tpl = $fpdi->importPage($p);
    $size = $fpdi->getTemplateSize($tpl);
    $fpdi->AddPage('P', [$size['width'], $size['height']]);
    $fpdi->useTemplate($tpl);
    
    // Draw fine grid every 5mm
    $fpdi->SetDrawColor(200, 200, 255);
    for ($x = 0; $x <= $size['width']; $x += 5) {
        $fpdi->Line($x, 0, $x, $size['height']);
    }
    for ($y = 0; $y <= $size['height']; $y += 5) {
        $fpdi->Line(0, $y, $size['width'], $y);
    }
    
    // Major grid every 10mm
    $fpdi->SetDrawColor(255, 0, 0);
    $fpdi->SetFont('Helvetica', '', 4);
    $fpdi->SetTextColor(255, 0, 0);
    
    for ($x = 0; $x <= $size['width']; $x += 10) {
        $fpdi->Line($x, 0, $x, $size['height']);
        if ($x > 0) {
            $fpdi->SetXY($x + 0.5, 0.5);
            $fpdi->Cell(5, 2, $x, 0, 0, 'L');
        }
    }
    
    for ($y = 0; $y <= $size['height']; $y += 10) {
        $fpdi->Line(0, $y, $size['width'], $y);
        $fpdi->SetXY(0.5, $y + 0.5);
        $fpdi->Cell(5, 2, $y, 0, 0, 'L');
    }
}

$outPath = __DIR__ . '/public/forms/DMW_GRID_FINE.pdf';
$fpdi->Output($outPath, 'F');
echo "Fine grid overlay saved to: $outPath\n";
echo "Open this file to map exact field positions from the template\n";
