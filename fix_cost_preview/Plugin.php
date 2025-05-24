<?php
declare(strict_types=1);

namespace Aicent\CostPreviewPlugin;

use Plugin\Domain\PluginInterface;
use Plugin\Domain\Context;
use Shared\Infrastructure\Services\ModelRegistry;
use Presentation\EventStream\Streamer;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use Psr\Container\ContainerInterface;

class Plugin implements PluginInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function boot(Context $context): void
    {
        // Registriere den CostPreviewApiController
        $this->container->set(CostPreviewApiController::class, function ($container) {
            return new CostPreviewApiController(
                $container->get(ModelRegistry::class),
                $container->get(Streamer::class)
            );
        });
        
        // Registriere den Twig-Namespace für die Templates
        try {
            // Versuche beide möglichen Service-Namen
            $twig = null;
            $twigLoader = null;
            
            if ($this->container->has(Environment::class)) {
                $twig = $this->container->get(Environment::class);
                $twigLoader = $twig->getLoader();
            } elseif ($this->container->has(FilesystemLoader::class)) {
                $twigLoader = $this->container->get(FilesystemLoader::class);
            }
            
            if ($twigLoader instanceof FilesystemLoader) {
                $pluginDir = dirname(__DIR__);
                $templatePath = $pluginDir . '/templates';
                
                // Prüfe ob das Template-Verzeichnis existiert
                if (is_dir($templatePath)) {
                    $twigLoader->addPath($templatePath, 'CostPreviewPlugin');
                    error_log("CostPreviewPlugin: Successfully registered Twig namespace at: " . $templatePath);
                } else {
                    error_log("CostPreviewPlugin: Template directory not found: " . $templatePath);
                }
            } else {
                error_log("CostPreviewPlugin: Could not get Twig FilesystemLoader");
            }
        } catch (\Exception $e) {
            error_log("CostPreviewPlugin: Failed to register Twig namespace: " . $e->getMessage());
        }
        
        // Das Plugin wird automatisch geladen
        // Routen werden über #[Route] Attribute in den Controller-Klassen registriert
        // Assets werden über die composer.json Konfiguration registriert
    }
}
