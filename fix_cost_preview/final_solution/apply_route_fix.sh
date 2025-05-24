#!/bin/bash

# FINAL FIX: Route-Registrierung + Modell-Fix
# Behebt: MethodNotAllowedException + falsche Modell-Erkennung

set -e

echo "🎯 FINAL FIX: Route + Modell-Erkennung wird angewendet..."

PLUGIN_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin"
FIX_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/final_solution"

# Backup erstellen
echo "📁 Erstelle Backup..."
cp "$PLUGIN_DIR/src/Plugin.php" "$PLUGIN_DIR/src/Plugin.php.backup3.$(date +%Y%m%d_%H%M%S)" 2>/dev/null || echo "Info: Backup failed"

# Route-Fix installieren
echo "🛣️ Installiere Route-Fix..."
cp "$FIX_DIR/Plugin_ROUTE_FIX.php" "$PLUGIN_DIR/src/Plugin.php"

# Rechte setzen
echo "🔐 Setze Rechte..."
chown -R www-data:www-data "$PLUGIN_DIR" 2>/dev/null || echo "Info: chown nicht verfügbar"
chmod 644 "$PLUGIN_DIR/src/Plugin.php" 2>/dev/null || echo "Info: chmod nicht verfügbar"

# Cache komplett leeren
echo "🗑️ Leere kompletten Cache..."
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/* 2>/dev/null || echo "Info: Cache-Pfad nicht verfügbar"

echo "✅ FINAL FIX INSTALLIERT!"
echo ""
echo "🔧 Änderungen:"
echo "   ✓ Route wird jetzt MANUELL über SimpleMapper registriert"
echo "   ✓ POST /api/cost-preview/estimate sollte funktionieren"
echo "   ✓ Fehlerbehandlung für Route-Registrierung"
echo "   ✓ Cache komplett geleert"
echo ""
echo "🧪 SOFORT TESTEN:"
echo "   1. API-Test: curl -X POST https://aicent.de/api/cost-preview/estimate -H 'Content-Type: application/json' -d '{\"prompt\":\"Test\",\"model\":\"gpt-3.5-turbo\"}'"
echo "   2. Chat-Seite neu laden"
echo "   3. Browser-Konsole: 'Cost Preview Widget: Bereit'"
echo "   4. Text eingeben → Kostenschätzung sollte erscheinen"
echo ""
echo "📊 Debug-Logs:"
echo "   - PHP Logs: tail -f /var/log/php*/error.log | grep CostPreview"
echo "   - Erfolgreiche Route-Registrierung: 'Route manuell registriert'"

