<?php
require __DIR__ . '/../vendor/autoload.php';

$pdfPath = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';
$parser = new \setasign\Fpdi\PdfParser\PdfParser(
    new \setasign\Fpdi\PdfReader\PdfReader(new \setasign\Fpdi\PdfParser\StreamReader(fopen($pdfPath, 'rb')))
);

// Let's get the page count
$fpdi = new \setasign\Fpdi\Fpdi();
$pagesCount = $fpdi->setSourceFile($pdfPath);

echo "Total Pages: $pagesCount\n\n";

for ($i = 1; $i <= $pagesCount; $i++) {
    echo "--- PAGE $i ---\n";
    $page = $parser->getPage($i);
    // Get the page stream contents
    try {
        $contents = $page->getContents();
        echo "Stream length: " . strlen($contents) . "\n";
        // Let's look for text blocks in the stream
        // Clean up binary chars if any, but since it's uncompressed by getContents() (or not?)
        // Let's print out lines containing Tj or TJ or text
        preg_match_all('/[(<](.*?)[)>]\s*(Tj|TJ)/i', $contents, $matches);
        echo "Found " . count($matches[1]) . " text items.\n";
        $textItems = [];
        foreach ($matches[1] as $item) {
            // hex decode if <...>
            if (str_starts_with($item, '<') || preg_match('/^[0-9a-fA-F]+$/', $item)) {
                // hex decode
                $decoded = hex2bin(trim($item, '<> '));
            } else {
                $decoded = $item;
            }
            $decoded = preg_replace('/[^a-zA-Z0-9\s\/\(\)\-\.:,;]/', '', $decoded);
            if (strlen(trim($decoded)) > 2) {
                $textItems[] = trim($decoded);
            }
        }
        $unique = array_unique($textItems);
        echo "Sample text items:\n";
        echo implode("\n", array_slice($unique, 0, 50)) . "\n\n";
    } catch (\Exception $e) {
        echo "Error reading page $i: " . $e->getMessage() . "\n\n";
    }
}
