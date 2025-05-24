<?php
declare(strict_types=1);

namespace Aicent\CostPreviewPlugin;

use Plugin\Domain\PluginInterface;
use Plugin\Domain\Context;
use Shared\Infrastructure\Services\ModelRegistry;
use Presentation\EventStream\Streamer;

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
        
        // Alternative: Kopiere das Template in das Haupt-Views-Verzeichnis
        // Dies ist eine Workaround-Lösung, falls die Twig-Namespace-Registrierung nicht funktioniert
        $pluginTemplateDir = dirname(__DIR__) . '/templates';
        $targetDir = dirname(dirname(dirname(dirname(__DIR__)))) . '/resources/views/plugins/cost-preview';
        
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }
        
        $sourceFile = $pluginTemplateDir . '/cost-preview.twig';
        $targetFile = $targetDir . '/cost-preview.twig';
        
        if (file_exists($sourceFile) && !file_exists($targetFile)) {
            @copy($sourceFile, $targetFile);
        }
    }
}
