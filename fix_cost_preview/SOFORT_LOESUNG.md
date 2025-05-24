# SOFORT-LÖSUNG für Cost Preview Plugin

## Das Problem
Das Plugin verwendet den falschen Service-Namen 'twig.loader', der in Aikeedo nicht existiert.
Stattdessen muss es `Twig\Loader\FilesystemLoader::class` verwenden.

## Schnellste Lösung

Führen Sie einfach diesen Befehl aus:

```bash
bash /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/fix_plugin.sh
```

Das Script wird:
1. Ein Backup der aktuellen Plugin.php erstellen
2. Die korrigierte Version installieren
3. Den Cache leeren
4. PHP-FPM neustarten

## Manuelle Lösung (falls das Script nicht funktioniert)

1. Kopieren Sie die korrigierte Plugin-Datei:
```bash
cp /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/Plugin_FIXED.php \
   /var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin/src/Plugin.php
```

2. Cache leeren:
```bash
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/*
```

3. PHP-FPM neustarten:
```bash
systemctl restart php8.2-fpm
```

## Überprüfung

Nach der Korrektur sollte die Chat-Seite wieder normal laden und das Cost Preview Widget anzeigen.

Falls weiterhin Probleme auftreten, führen Sie das Debug-Script V2 aus:
```bash
php /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/debug_twig_v2.php
```
