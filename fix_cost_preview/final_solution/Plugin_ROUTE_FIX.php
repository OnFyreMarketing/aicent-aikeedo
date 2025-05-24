<?php
declare(strict_types=1);

namespace Aicent\CostPreviewPlugin;

use Plugin\Domain\PluginInterface;
use Plugin\Domain\Context;
use Shared\Infrastructure\Services\ModelRegistry;
use Presentation\EventStream\Streamer;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Easy\Router\Mapper\SimpleMapper;
use Easy\Router\Enums\RequestMethod;

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
        // 1. Registriere den CostPreviewApiController
        $this->container->set(CostPreviewApiController::class, function ($container) {
            return new CostPreviewApiController(
                $container->get(ModelRegistry::class),
                $container->get(Streamer::class)
            );
        });
        
        // 2. MANUELL Route registrieren (weil AttributeMapper nur src/ scannt)
        try {
            if ($this->container->has(SimpleMapper::class)) {
                $simpleMapper = $this->container->get(SimpleMapper::class);
                $simpleMapper->map(
                    RequestMethod::POST,
                    '/api/cost-preview/estimate',
                    CostPreviewApiController::class . '@estimate'
                );
                error_log("CostPreviewPlugin: Route manuell registriert: POST /api/cost-preview/estimate");
            }
        } catch (\Exception $e) {
            error_log("CostPreviewPlugin: Failed to register route: " . $e->getMessage());
        }
        
        // 3. Registriere den Twig-Namespace für die Templates
        try {
            // Laut AGENT.md wird Twig als Twig\Loader\FilesystemLoader registriert
            if ($this->container->has(FilesystemLoader::class)) {
                $twigLoader = $this->container->get(FilesystemLoader::class);
                $this->registerTwigNamespace($twigLoader);
            } 
            // Falls das nicht funktioniert, versuche es über Twig\Environment
            elseif ($this->container->has(Environment::class)) {
                $twig = $this->container->get(Environment::class);
                $twigLoader = $twig->getLoader();
                if ($twigLoader instanceof FilesystemLoader) {
                    $this->registerTwigNamespace($twigLoader);
                }
            }
        } catch (\Exception $e) {
            error_log("CostPreviewPlugin: Failed to register Twig namespace: " . $e->getMessage());
        }
    }
    
    private function registerTwigNamespace(FilesystemLoader $twigLoader): void
    {
        $pluginDir = dirname(__DIR__);
        $templatePath = $pluginDir . '/templates';
        
        if (is_dir($templatePath)) {
            $twigLoader->addPath($templatePath, 'CostPreviewPlugin');
            error_log("CostPreviewPlugin: Successfully registered Twig namespace at: " . $templatePath);
        } else {
            error_log("CostPreviewPlugin: Template directory not found: " . $templatePath);
        }
    }
}
