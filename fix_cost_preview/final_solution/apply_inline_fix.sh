#!/bin/bash

# SOFORT-FIX: Inline Alpine.js Template
# Behebt: "costPreviewData is not defined" Fehler

set -e

echo "🚀 INLINE Alpine.js Fix wird angewendet..."

PLUGIN_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/extra/extensions/aicent/cost-preview-plugin"
FIX_DIR="/var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/final_solution"

# Backup erstellen
echo "📁 Erstelle neues Backup..."
cp "$PLUGIN_DIR/templates/cost-preview.twig" "$PLUGIN_DIR/templates/cost-preview.twig.backup2.$(date +%Y%m%d_%H%M%S)"

# Inline Template installieren
echo "📄 Installiere Inline Alpine.js Template..."
cp "$FIX_DIR/cost-preview-INLINE.twig" "$PLUGIN_DIR/templates/cost-preview.twig"

# Rechte setzen
echo "🔐 Setze Rechte..."
chown -R www-data:www-data "$PLUGIN_DIR" 2>/dev/null || echo "Info: www-data user nicht gefunden (Windows?)"
chmod 644 "$PLUGIN_DIR/templates/cost-preview.twig" 2>/dev/null || echo "Info: chmod nicht verfügbar (Windows?)"

# Cache leeren
echo "🗑️ Leere Cache..."
rm -rf /var/www/vhosts/aicent.de/httpdocs/aicent/var/cache/* 2>/dev/null || echo "Info: Cache-Pfad nicht gefunden"

echo "✅ INLINE Fix angewendet!"
echo ""
echo "🔧 Änderungen:"
echo "   ✓ Vollständig inline Alpine.js (keine externen Abhängigkeiten)"
echo "   ✓ Alle Funktionen direkt im x-data definiert"  
echo "   ✓ Keine undefined Variablen mehr"
echo "   ✓ Sichere null-Checks"
echo ""
echo "🧪 SOFORT TESTEN:"
echo "   1. Chat-Seite neu laden"
echo "   2. Browser-Konsole öffnen (F12)"
echo "   3. Erwartete Meldung: 'Cost Preview Widget: Bereit'"
echo "   4. Text eingeben → Widget sollte funktionieren"
echo ""
echo "❗ Falls es nicht funktioniert:"
echo "   - Browser Cache leeren (Ctrl+F5)"
echo "   - Andere Browser testen"
echo "   - Browser-Konsole auf weitere Fehler prüfen"

