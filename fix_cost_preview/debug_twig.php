<?php
// Debug-Skript für Cost Preview Plugin
// Dieses Skript prüft die Twig-Konfiguration und zeigt verfügbare Namespaces

require_once __DIR__ . '/../bootstrap/app.php';

try {
    // Container holen
    /** @var \Psr\Container\ContainerInterface $container */
    
    echo "=== Twig Debug Information ===\n\n";
    
    // Versuche Twig Environment zu holen
    if ($container->has(\Twig\Environment::class)) {
        $twig = $container->get(\Twig\Environment::class);
        $loader = $twig->getLoader();
        
        if ($loader instanceof \Twig\Loader\FilesystemLoader) {
            echo "Twig FilesystemLoader gefunden!\n\n";
            
            echo "Registrierte Namespaces:\n";
            $namespaces = $loader->getNamespaces();
            foreach ($namespaces as $namespace) {
                echo "- $namespace\n";
                $paths = $loader->getPaths($namespace);
                foreach ($paths as $path) {
                    echo "  -> $path\n";
                }
            }
            
            echo "\nStandard-Pfade (ohne Namespace):\n";
            $paths = $loader->getPaths();
            foreach ($paths as $path) {
                echo "- $path\n";
            }
        }
    } else {
        echo "Twig Environment nicht im Container gefunden.\n";
    }
    
    echo "\n=== Plugin Status ===\n\n";
    
    // Plugin-Verzeichnis prüfen
    $pluginDir = __DIR__ . '/../extra/extensions/aicent/cost-preview-plugin';
    echo "Plugin-Verzeichnis: $pluginDir\n";
    echo "Existiert: " . (is_dir($pluginDir) ? "Ja" : "Nein") . "\n";
    
    $templateDir = $pluginDir . '/templates';
    echo "\nTemplate-Verzeichnis: $templateDir\n";
    echo "Existiert: " . (is_dir($templateDir) ? "Ja" : "Nein") . "\n";
    
    $templateFile = $templateDir . '/cost-preview.twig';
    echo "\nTemplate-Datei: $templateFile\n";
    echo "Existiert: " . (file_exists($templateFile) ? "Ja" : "Nein") . "\n";
    
} catch (\Exception $e) {
    echo "Fehler: " . $e->getMessage() . "\n";
    echo "Stack Trace:\n" . $e->getTraceAsString() . "\n";
}
