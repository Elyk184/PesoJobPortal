<?php
require __DIR__ . '/../vendor/autoload.php';

$pdfPath = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
$streamReader = new \setasign\Fpdi\PdfParser\StreamReader(fopen($pdfPath, 'rb'));
$parser = new \setasign\Fpdi\PdfParser\PdfParser($streamReader);
$reader = new \setasign\Fpdi\PdfReader\PdfReader($parser);

// Let's get the page count
$pagesCount = $reader->getPageCount();

echo "Total Pages: $pagesCount\n\n";

for ($i = 1; $i <= $pagesCount; $i++) {
    echo "--- PAGE $i ---\n";
    $page = $reader->getPage($i);
    // Get the page stream contents
    try {
        $contents = $page->getContentStream();
        echo "Stream length: " . strlen($contents) . "\n";
        
        // Match text objects inside parentheses: (Some Text) Tj or (Some Text) TJ
        preg_match_all('/\((.*?)\)/', $contents, $matches);
        echo "Found " . count($matches[1]) . " text items.\n";
        
        $textItems = [];
        foreach ($matches[1] as $item) {
            // Clean up backslashes for escaped parentheses
            $decoded = str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $item);
            // Remove non-printable characters for clean display
            $decoded = preg_replace('/[^a-zA-Z0-9\s\/\(\)\-\.:,;?]/', '', $decoded);
            if (strlen(trim($decoded)) > 1) {
                $textItems[] = trim($decoded);
            }
        }
        
        $unique = array_values(array_unique($textItems));
        echo "Sample text items:\n";
        foreach (array_slice($unique, 0, 80) as $text) {
            echo "  - $text\n";
        }
        echo "\n";
    } catch (\Exception $e) {
        echo "Error reading page $i: " . $e->getMessage() . "\n\n";
    }
}
