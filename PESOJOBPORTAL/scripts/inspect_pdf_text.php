<?php
require __DIR__ . '/../vendor/autoload.php';

class MyFpdi extends \setasign\Fpdi\Fpdi {
    public function getPageContents($pageNumber) {
        $reader = $this->getPdfReader($this->currentReaderId);
        $page = $reader->getPage($pageNumber);
        return $page->getContents();
    }
}

$pdfPath = __DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf';

try {
    $fpdi = new MyFpdi();
    $pageCount = $fpdi->setSourceFile($pdfPath);
    echo "Total Pages: $pageCount\n\n";

    for ($i = 1; $i <= $pageCount; $i++) {
        echo "Page $i:\n";
        $contents = $fpdi->getPageContents($i);
        echo "Stream length: " . strlen($contents) . "\n";
        
        // Extract Tj and TJ strings
        preg_match_all('/(?:\((.*?)\)\s*Tj)|(?:\[(.*?)\]\s*TJ)/s', $contents, $matches);
        
        $allTexts = [];
        foreach ($matches[1] as $m) {
            if ($m !== '') {
                $allTexts[] = $m;
            }
        }
        foreach ($matches[2] as $m) {
            if ($m !== '') {
                preg_match_all('/\((.*?)\)/', $m, $subMatches);
                foreach ($subMatches[1] as $sm) {
                    $allTexts[] = $sm;
                }
            }
        }

        // Clean octal/escaped sequences
        $cleanedTexts = array_map(function($t) {
            $t = str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $t);
            $t = preg_replace_callback('/\\\\([0-7]{3})/', function($matches) {
                return chr(octdec($matches[1]));
            }, $t);
            return trim($t);
        }, $allTexts);

        $cleanedTexts = array_filter($cleanedTexts, function($t) {
            return strlen($t) > 1;
        });

        echo "Found text: " . implode(" | ", array_slice($cleanedTexts, 0, 80)) . "\n\n";
    }
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
