<?php
// Debug-Skript V2 - Prüft die Twig-Konfiguration ohne das fehlerhafte Plugin zu laden

echo "=== Cost Preview Plugin Debug V2 ===\n\n";

// Prüfe Plugin-Verzeichnisstruktur
$pluginBase = dirname(__DIR__) . '/extra/extensions/aicent/cost-preview-plugin';
echo "Plugin-Verzeichnis: $pluginBase\n";
echo "Existiert: " . (is_dir($pluginBase) ? "✓ Ja" : "✗ Nein") . "\n\n";

$dirs = [
    'src' => $pluginBase . '/src',
    'templates' => $pluginBase . '/templates',
    'assets' => $pluginBase . '/assets',
];

echo "Unterverzeichnisse:\n";
foreach ($dirs as $name => $path) {
    echo "- $name: " . (is_dir($path) ? "✓" : "✗") . " $path\n";
}

echo "\nTemplate-Dateien:\n";
$templateDir = $pluginBase . '/templates';
if (is_dir($templateDir)) {
    $files = scandir($templateDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- $file\n";
        }
    }
} else {
    echo "✗ Template-Verzeichnis nicht gefunden!\n";
}

echo "\nPlugin-Klassen:\n";
$srcDir = $pluginBase . '/src';
if (is_dir($srcDir)) {
    $files = scandir($srcDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            echo "- $file\n";
            
            // Prüfe ob die aktuelle Plugin.php noch 'twig.loader' verwendet
            if ($file === 'Plugin.php') {
                $content = file_get_contents($srcDir . '/' . $file);
                if (strpos($content, "'twig.loader'") !== false) {
                    echo "  ⚠️  WARNUNG: Plugin.php verwendet noch 'twig.loader' - muss korrigiert werden!\n";
                } elseif (strpos($content, "FilesystemLoader::class") !== false) {
                    echo "  ✓ Plugin.php verwendet korrekt FilesystemLoader::class\n";
                }
            }
        }
    }
}

echo "\nLösung:\n";
echo "--------\n";
echo "1. Führen Sie das Fix-Script aus:\n";
echo "   bash " . dirname(__FILE__) . "/fix_plugin.sh\n";
echo "\nODER manuell:\n";
echo "2. Kopieren Sie Plugin_FIXED.php nach:\n";
echo "   $srcDir/Plugin.php\n";
echo "3. Cache leeren: rm -rf var/cache/*\n";
echo "4. PHP-FPM neustarten: systemctl restart php-fpm\n";
