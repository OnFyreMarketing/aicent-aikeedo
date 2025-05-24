# ✅ LÖSUNG BEREIT: Cost Preview Plugin Fix

## Problem identifiziert und gelöst!

Der Fehler war: Das Plugin verwendete `'twig.loader'` als Service-Namen, aber Aikeedo registriert den Service als `Twig\Loader\FilesystemLoader::class`.

## Sofort-Lösung

Führen Sie diesen einen Befehl aus:

```bash
bash /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/fix_plugin.sh
```

Das war's! Die Website sollte wieder funktionieren.

## Was das Fix-Script macht:
1. ✓ Backup der alten Plugin.php
2. ✓ Installation der korrigierten Version
3. ✓ Cache leeren
4. ✓ PHP-FPM Neustart

## Falls Sie es manuell machen möchten:

```bash
# 1. Korrigierte Plugin.php kopieren
cp fix_cost_preview/Plugin_FIXED.php extra/extensions/aicent/cost-preview-plugin/src/Plugin.php

# 2. Cache leeren
rm -rf var/cache/*

# 3. PHP neustarten
systemctl restart php8.2-fpm
```

## Dateien in diesem Fix-Paket:
- `Plugin_FIXED.php` - Die korrigierte Plugin-Klasse
- `fix_plugin.sh` - Automatisches Fix-Script
- `SOFORT_LOESUNG.md` - Diese Datei
- `dokumentation_UPDATE.md` - Vollständige technische Dokumentation
- `debug_twig_v2.php` - Debug-Tool falls nötig

---
Viel Erfolg! 🚀
