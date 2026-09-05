<?php
$dir = 'd:/Server/www';
$files = glob($dir . '/*.php');

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Look for <div class="page-heading..."> and remove the style attribute entirely
    $new_content = preg_replace('/(<div[^>]*class="[^"]*page-heading[^"]*"[^>]*)style="[^"]*"(>)/i', '$1$2', $content);
    
    // Some files might have multiple spaces before the > after removing style, clean it up
    $new_content = preg_replace('/(<div[^>]*class="[^"]*page-heading[^"]*"[^>]*)\s+(>)/i', '$1$2', $new_content);

    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        echo "Updated: " . basename($file) . "\n";
        $count++;
    }
}
echo "Total files updated: $count\n";
?>
