#!/bin/bash

# Fix für Cost Preview Plugin - Alpine.js Kompatibilität
# Behebt: "Alpine is not defined" und null result errors

set -e

echo "🔧 Cost Preview Plugin Alpine.js Fix wird angewendet..."

PLUGIN_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin"
FIX_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/final_solution"

# Backup erstellen
echo "📁 Erstelle Backup..."
cp "$PLUGIN_DIR/templates/cost-preview.twig" "$PLUGIN_DIR/templates/cost-preview.twig.backup.$(date +%Y%m%d_%H%M%S)"

# Neues Template installieren
echo "📄 Installiere Alpine.js-kompatibles Template..."
cp "$FIX_DIR/cost-preview-FIXED.twig" "$PLUGIN_DIR/templates/cost-preview.twig"

# Verzeichnisrechte setzen
echo "🔐 Setze Rechte..."
chown -R www-data:www-data "$PLUGIN_DIR"
chmod 644 "$PLUGIN_DIR/templates/cost-preview.twig"

# Cache leeren
echo "🗑️ Leere Cache..."
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/*

# Twig Cache leeren
if [ -d "/var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/twig" ]; then
    rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/twig/*
fi

# PHP-FPM neustarten
echo "🔄 Starte PHP-FPM neu..."
systemctl restart php8.2-fpm

# Status prüfen
echo "✅ Fix angewendet!"
echo ""
echo "🔍 Was wurde geändert:"
echo "   ✓ Alpine.js-kompatibles Template installiert"
echo "   ✓ Verwendet document.ready statt globales Alpine"
echo "   ✓ Bessere Fehlerbehandlung für null-Werte"
echo "   ✓ Robustere Prompt-Feld-Erkennung"
echo "   ✓ Cache geleert"
echo ""
echo "🧪 Testen Sie jetzt:"
echo "   1. Chat-Seite aufrufen"
echo "   2. Browser-Konsole öffnen (F12)"
echo "   3. Nach 'Cost Preview Widget: Bereit' suchen"
echo "   4. Text in Prompt-Feld eingeben"
echo "   5. Kostenschätzung sollte erscheinen"
echo ""
echo "📋 Bei Problemen:"
echo "   - Logs: tail -f /var/log/php*/error.log | grep -i cost"
echo "   - Browser-Konsole auf JavaScript-Fehler prüfen"
echo "   - Network-Tab auf API-Aufrufe prüfen"

