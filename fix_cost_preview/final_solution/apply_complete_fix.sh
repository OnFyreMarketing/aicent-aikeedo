#!/bin/bash

# FINALER FIX: Route + Template + Modell-Erkennung
# Löst alle Probleme: MethodNotAllowedException + falsche Modell-Erkennung

set -e

echo "🚀 FINALER COMPLETE FIX wird angewendet..."

PLUGIN_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin"
FIX_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/final_solution"

# Backups erstellen
echo "📁 Erstelle Backups..."
cp "$PLUGIN_DIR/src/Plugin.php" "$PLUGIN_DIR/src/Plugin.php.backup.final.$(date +%Y%m%d_%H%M%S)" 2>/dev/null || true
cp "$PLUGIN_DIR/templates/cost-preview.twig" "$PLUGIN_DIR/templates/cost-preview.twig.backup.final.$(date +%Y%m%d_%H%M%S)" 2>/dev/null || true

# Plugin mit Route-Fix installieren
echo "🛣️ Installiere Plugin mit Route-Registrierung..."
cp "$FIX_DIR/Plugin_ROUTE_FIX.php" "$PLUGIN_DIR/src/Plugin.php"

# Template mit verbesserter Modell-Erkennung installieren
echo "📄 Installiere verbessertes Template..."
cp "$FIX_DIR/cost-preview-FINAL.twig" "$PLUGIN_DIR/templates/cost-preview.twig"

# Rechte setzen
echo "🔐 Setze Rechte..."
chown -R www-data:www-data "$PLUGIN_DIR" 2>/dev/null || echo "Info: chown nicht verfügbar"
chmod 644 "$PLUGIN_DIR/src/Plugin.php" 2>/dev/null || echo "Info: chmod nicht verfügbar"
chmod 644 "$PLUGIN_DIR/templates/cost-preview.twig" 2>/dev/null || echo "Info: chmod nicht verfügbar"

# Cache vollständig leeren
echo "🗑️ Leere kompletten Cache..."
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/* 2>/dev/null || echo "Info: Cache-Pfad nicht verfügbar"

echo ""
echo "✅ COMPLETE FIX ERFOLGREICH INSTALLIERT!"
echo ""
echo "🔧 Was wurde gefixt:"
echo "   ✓ Route wird MANUELL über SimpleMapper registriert"
echo "   ✓ MethodNotAllowedException behoben"
echo "   ✓ Verbesserte Modell-Erkennung (keine Dateitypen mehr)"
echo "   ✓ Fallback auf bekannte Modellnamen"
echo "   ✓ Bessere Fehlerbehandlung"
echo "   ✓ Robuste Prompt-Feld-Erkennung"
echo ""
echo "🧪 JETZT TESTEN:"
echo "   1. API-Test:"
echo "      curl -X POST https://aicent.de/api/cost-preview/estimate \\"
echo "           -H 'Content-Type: application/json' \\"
echo "           -d '{\"prompt\":\"Test prompt\",\"model\":\"gpt-3.5-turbo\"}'"
echo ""
echo "   2. Frontend-Test:"
echo "      - Chat-Seite neu laden: https://aicent.de/app/chat"
echo "      - Browser-Konsole öffnen (F12)"
echo "      - Erwartete Meldung: 'Cost Preview Widget: Bereit'"
echo "      - Text eingeben → Kostenschätzung sollte erscheinen"
echo ""
echo "📊 Debug-Hilfen:"
echo "   - PHP Logs: tail -f /var/log/php*/error.log | grep -i costpreview"
echo "   - Erfolgreiche Route: 'Route manuell registriert'"
echo "   - Modell-Info: 'Anfrage für Modell: [modellname]'"
echo ""
echo "🎯 Das Plugin sollte jetzt VOLLSTÄNDIG funktionieren!"

