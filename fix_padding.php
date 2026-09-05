<?php
$dir = 'd:/Server/www';
$files = glob($dir . '/*.php');

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Look for <div class="page-heading...">
    // and remove the padding declaration.
    
    $new_content = preg_replace_callback(
        '/(<div[^>]*class="[^"]*page-heading[^"]*"[^>]*style=")([^"]*)(")/i',
        function ($matches) {
            $style = $matches[2];
            // Remove any padding: ... ; or padding: ... at the end
            $style = preg_replace('/padding\s*:[^;]+;?/i', '', $style);
            // Cleanup extra spaces
            $style = trim($style);
            return $matches[1] . $style . $matches[3];
        },
        $content
    );
    
    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        echo "Updated: " . basename($file) . "\n";
        $count++;
    }
}
echo "Total files updated: $count\n";
?>
