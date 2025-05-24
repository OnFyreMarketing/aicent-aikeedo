#!/bin/bash

# SOFORT-FIX: Korrigierter RequestMethod Import
# Behebt: "Easy\Router\Enums\RequestMethod" not found

set -e

echo "🔧 NAMESPACE-FIX wird angewendet..."

PLUGIN_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin"
FIX_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/final_solution"

# Backup erstellen
echo "📁 Erstelle Backup..."
cp "$PLUGIN_DIR/src/Plugin.php" "$PLUGIN_DIR/src/Plugin.php.backup.namespace.$(date +%Y%m%d_%H%M%S)" 2>/dev/null || true

# Korrigierte Plugin.php installieren
echo "✅ Installiere korrekte Plugin.php..."
cp "$FIX_DIR/Plugin_CORRECTED.php" "$PLUGIN_DIR/src/Plugin.php"

# Rechte setzen  
echo "🔐 Setze Rechte..."
chown -R www-data:www-data "$PLUGIN_DIR" 2>/dev/null || echo "Info: chown nicht verfügbar"
chmod 644 "$PLUGIN_DIR/src/Plugin.php" 2>/dev/null || echo "Info: chmod nicht verfügbar"

# Cache leeren
echo "🗑️ Leere Cache..."
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/* 2>/dev/null || echo "Info: Cache-Pfad nicht verfügbar"

echo ""
echo "✅ NAMESPACE-FIX INSTALLIERT!"
echo ""
echo "🔧 Was wurde korrigiert:"
echo "   ✓ RequestMethod Import: Easy\\Http\\Message\\RequestMethod"
echo "   ✓ SimpleMapper.map() Syntax korrigiert"
echo "   ✓ Entfernt: Easy\\Router\\Enums\\RequestMethod (existiert nicht!)"
echo "   ✓ Cache geleert"
echo ""
echo "🧪 SOFORT TESTEN:"
echo "   1. API-Test:"
echo "      curl -X POST https://aicent.de/api/cost-preview/estimate \\"
echo "           -H 'Content-Type: application/json' \\"
echo "           -d '{\"prompt\":\"Test\",\"model\":\"gpt-3.5-turbo\"}'"
echo ""
echo "   2. Erwartung: JSON-Response (kein MethodNotAllowedException mehr!)"
echo ""
echo "📊 Debug-Log prüfen:"
echo "   tail -f /var/log/php*/error.log | grep CostPreview"
echo "   Erwartete Meldung: 'Route manuell registriert: POST /api/cost-preview/estimate'"

