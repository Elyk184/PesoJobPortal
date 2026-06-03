<?php
$content = file_get_contents(__DIR__ . '/../public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf');
// Extract strings inside parentheses ( Tj / TJ syntax in PDF)
preg_match_all('/\((.*?)\)/', $content, $matches);
echo "Extracted strings:\n";
$lines = [];
foreach ($matches[1] as $str) {
    $str = trim(str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $str));
    if (strlen($str) > 3) {
        $lines[] = $str;
    }
}
$unique_lines = array_unique($lines);
echo implode("\n", array_slice($unique_lines, 0, 150)) . "\n";
