# Dokumentation: Fehlerbehebung des Cost Preview Plugins

## Problem

Bei der Integration des Cost Preview Plugins in die Aikeedo-Plattform trat folgender Fehler auf:

```
Fatal error: Uncaught Twig\Error\LoaderError: Unable to find template "/extra/extensions/aicent/cost-preview-plugin/templates/cost-preview.twig" (looked into: /var/www/vhosts/aicent.de/httpdocs/aicent/resources/views, /var/www/vhosts/aicent.de/httpdocs/aicent/resources/views)
```

Der Fehler trat auf, weil Twig das Template nicht finden konnte. Die Fehlermeldung zeigt, dass Twig nur in den Verzeichnissen `/var/www/vhosts/aicent.de/httpdocs/aicent/resources/views` nach Templates sucht, aber nicht im Plugin-Verzeichnis.

## Ursache

Die Ursache des Problems war zweifach:

1. In der Datei `chat.twig` wurde das Template mit einem absoluten Pfad eingebunden:
   ```twig
   {% include '/extra/extensions/aicent/cost-preview-plugin/templates/cost-preview.twig' %}
   ```
   Twig sucht jedoch nur in den konfigurierten Template-Verzeichnissen nach Templates und nicht im gesamten Dateisystem.

2. Das Plugin hat keinen Twig-Namespace für seine Templates registriert, sodass Twig nicht wusste, wo es nach den Templates suchen sollte.

## Lösung

Die Lösung bestand aus zwei Schritten:

1. Änderung des Template-Pfads in `chat.twig`, um einen Twig-Namespace zu verwenden:
   ```twig
   {% include '@CostPreviewPlugin/cost-preview.twig' %}
   ```

2. Registrierung des Twig-Namespaces in der Plugin-Klasse:
   ```php
   // Registriere den Twig-Namespace für die Templates
   $twigLoader = $this->container->get('twig.loader');
   if ($twigLoader instanceof FilesystemLoader) {
       $pluginDir = dirname(__DIR__);
       $twigLoader->addPath($pluginDir . '/templates', 'CostPreviewPlugin');
   }
   ```

## Technische Details

### Twig-Namespaces

Twig verwendet Namespaces, um Templates aus verschiedenen Verzeichnissen zu laden. Ein Namespace wird mit dem `@`-Symbol gefolgt vom Namespace-Namen angegeben, z.B. `@CostPreviewPlugin/cost-preview.twig`.

Um einen Namespace zu registrieren, muss die `addPath`-Methode des `FilesystemLoader` aufgerufen werden:

```php
$twigLoader->addPath($path, $namespace);
```

### Plugin-Integration in Aikeedo

Aikeedo verwendet das Composer-Autoloading-System, um Plugins zu laden. Die Plugin-Klasse implementiert das `PluginInterface` und wird über die `boot`-Methode initialisiert.

In der `boot`-Methode können Dienste im Container registriert und Konfigurationen vorgenommen werden, wie z.B. die Registrierung von Twig-Namespaces.

## Fazit

Durch die Änderung des Template-Pfads in `chat.twig` und die Registrierung des Twig-Namespaces in der Plugin-Klasse konnte das Problem behoben werden. Das Cost Preview Plugin wird nun korrekt in der Aikeedo-Plattform angezeigt und funktioniert fehlerfrei.