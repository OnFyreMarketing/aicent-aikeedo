# DOKUMENTATION: Cost Preview Plugin Fehlerbehebung

## Zusammenfassung

Das Cost Preview Plugin für Aikeedo zeigt einen Twig-Template-Fehler. Das Problem liegt darin, dass der Twig-Namespace für das Plugin nicht korrekt registriert wird.

## Dateien zur Fehlerbehebung

Im Verzeichnis `fix_cost_preview/` finden Sie:

1. **Plugin.php** - Korrigierte Version der Plugin-Hauptklasse
2. **Plugin_Alternative.php** - Alternative Lösung mit Template-Kopie
3. **VOLLSTAENDIGE_ANLEITUNG.md** - Detaillierte Schritt-für-Schritt Anleitung
4. **debug_twig.php** - Debug-Skript zur Fehlerdiagnose

## Schnellstart

1. Führen Sie zuerst das Debug-Skript aus:
   ```bash
   cd /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview
   php debug_twig.php
   ```

2. Basierend auf der Ausgabe, wählen Sie eine der Lösungen aus der VOLLSTAENDIGE_ANLEITUNG.md

3. Nach den Änderungen:
   - Cache leeren: `rm -rf var/cache/*`
   - PHP-FPM neustarten: `systemctl restart php-fpm`

## Technische Details

Das Problem entsteht, weil:
- Twig das Plugin-Template-Verzeichnis nicht kennt
- Der Namespace '@CostPreviewPlugin' nicht registriert wurde
- Die Plugin boot() Methode möglicherweise den falschen Service aus dem Container abruft

Die Lösung registriert den Twig-Namespace korrekt, sodass Templates mit `@CostPreviewPlugin/template.twig` referenziert werden können.

## Support

Bei weiteren Problemen:
1. Prüfen Sie die PHP-Error-Logs
2. Nutzen Sie das debug_twig.php Skript
3. Konsultieren Sie die AGENT.md für Details zur Aikeedo-Architektur
