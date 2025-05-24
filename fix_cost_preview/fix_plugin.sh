#!/bin/bash

# Fix Script für Cost Preview Plugin
# Dieses Script behebt das Twig-Namespace Problem

echo "=== Cost Preview Plugin Fix Script ==="
echo ""

# Backup der aktuellen Plugin.php
if [ -f "/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin/src/Plugin.php" ]; then
    cp /var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin/src/Plugin.php \
       /var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin/src/Plugin.php.backup
    echo "✓ Backup erstellt: Plugin.php.backup"
fi

# Kopiere die korrigierte Version
cp /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/Plugin_FIXED.php \
   /var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin/src/Plugin.php

echo "✓ Plugin.php aktualisiert"

# Cache leeren
if [ -d "/var/www/vhosts/aicent.de/httpdocs/aicent/var/cache" ]; then
    rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/*
    echo "✓ Cache geleert"
fi

# PHP-FPM neustarten
systemctl restart php8.2-fpm 2>/dev/null || systemctl restart php-fpm 2>/dev/null
echo "✓ PHP-FPM neugestartet"

echo ""
echo "Fix abgeschlossen! Testen Sie nun die Chat-Seite."
echo ""
echo "Falls weiterhin Probleme auftreten:"
echo "1. Prüfen Sie die Error-Logs: tail -f /var/log/php*/error.log"
echo "2. Führen Sie das Debug-Script aus: php /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/debug_twig_v2.php"
