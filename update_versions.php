<?php
$dir = 'd:/Server/www';
$files = glob($dir . '/*.php');

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $new_content = $content;
    
    // 1. Replace <?= defined('SITE_VERSION') ? SITE_VERSION : time() ? >
    $pattern1 = '/<\?=\s*defined\(\'SITE_VERSION\'\)\s*\?\s*SITE_VERSION\s*:\s*time\(\)\s*\?>/i';
    $new_content = preg_replace($pattern1, "<?= SITE_VERSION ?>", $new_content);

    // 2. Replace <?php echo time();? >
    $pattern2 = '/<\?php\s+echo\s+time\(\);\s*\?>/i';
    $new_content = preg_replace($pattern2, "<?= SITE_VERSION ?>", $new_content);

    // 3. movies.php specific fix for poster.jpg
    $new_content = str_replace('images/poster.jpg?v=" . SITE_VERSION', 'images/poster.jpg?v=" . SITE_VERSION', $new_content);

    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        echo "Updated: " . basename($file) . "\n";
        $count++;
    }
}
echo "Total files updated: $count\n";
