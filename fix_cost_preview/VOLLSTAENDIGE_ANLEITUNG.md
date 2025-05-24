# Vollständige Anleitung zur Fehlerbehebung des Cost Preview Plugins

## Problem
Das Cost Preview Plugin verursacht einen Twig-Template-Fehler beim Laden der Chat-Seite:
```
Fatal error: Uncaught Twig\Error\LoaderError: Unable to find template 
"/extra/extensions/aicent/cost-preview-plugin/templates/cost-preview.twig"
```

## Lösungsansätze

### Lösung 1: Twig-Namespace korrekt registrieren (Empfohlen)

1. Ersetzen Sie den Inhalt der Datei:
   `extra/extensions/aicent/cost-preview-plugin/src/Plugin.php`
   mit dem Inhalt aus:
   `fix_cost_preview/Plugin.php`

2. Leeren Sie den Cache:
   ```bash
   rm -rf var/cache/*
   ```

3. Starten Sie PHP-FPM neu:
   ```bash
   systemctl restart php-fpm
   ```

### Lösung 2: Alternative mit Template-Kopie

Falls Lösung 1 nicht funktioniert:

1. Verwenden Sie die alternative Plugin.php:
   Ersetzen Sie `extra/extensions/aicent/cost-preview-plugin/src/Plugin.php`
   mit dem Inhalt aus: `fix_cost_preview/Plugin_Alternative.php`

2. Ändern Sie in der Datei:
   `resources/views/templates/app/chat.twig`
   
   Von:
   ```twig
   {% include '@CostPreviewPlugin/cost-preview.twig' %}
   ```
   
   Zu:
   ```twig
   {% include 'plugins/cost-preview/cost-preview.twig' %}
   ```

### Lösung 3: Direkte Template-Integration (Notlösung)

Falls beide obigen Lösungen nicht funktionieren:

1. Kopieren Sie den Inhalt von:
   `extra/extensions/aicent/cost-preview-plugin/templates/cost-preview.twig`

2. Fügen Sie ihn direkt in die chat.twig ein, anstelle des include-Statements:
   ```twig
   {# Anstelle von include, direkt einfügen: #}
   <div id="cost-preview" class="p-4 bg-gray-50 rounded-lg mb-2" x-show="showCostPreview">
       <!-- Inhalt von cost-preview.twig hier einfügen -->
   </div>
   ```

## Debugging-Schritte

1. **PHP Error Logs prüfen:**
   ```bash
   tail -f /var/log/php-fpm/error.log
   ```

2. **Aikeedo Debug-Modus aktivieren:**
   In `.env`:
   ```
   DEBUG=true
   ```

3. **Verfügbare Twig-Pfade ausgeben:**
   Fügen Sie temporär in Plugin.php ein:
   ```php
   error_log("Available Twig paths: " . print_r($twigLoader->getPaths(), true));
   ```

## Wichtige Hinweise aus AGENT.md

- Die ViewMiddleware verwendet Twig\Environment, das im ViewEngineProvider registriert wird
- Der Twig FilesystemLoader wird als Twig\Loader\FilesystemLoader im Container registriert
- Plugins werden durch den PluginModuleBootstrapper geladen
- Theme-Verzeichnisse werden speziell behandelt und dem Twig Loader hinzugefügt

## Prüfung nach der Korrektur

1. Öffnen Sie die Chat-Seite
2. Prüfen Sie die Browser-Konsole auf JavaScript-Fehler
3. Prüfen Sie die PHP-Error-Logs
4. Testen Sie die Kostenschätzung durch Eingabe eines Prompts

## Status-Checkliste

- [ ] Plugin.php korrigiert
- [ ] Cache geleert
- [ ] PHP-FPM neugestartet
- [ ] Chat-Seite lädt ohne Fehler
- [ ] Cost Preview wird angezeigt
- [ ] Kostenschätzung funktioniert
