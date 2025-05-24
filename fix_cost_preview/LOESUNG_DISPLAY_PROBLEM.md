# Lösung: Cost Preview Widget Anzeige

## Zusammenfassung der Probleme

### 1. Rechteproblem beim Dateizugriff
**Problem:** Ich konnte die Dateien nicht direkt bearbeiten wegen:
```
Error: EPERM: operation not permitted, open '\\RaiDrive-krziw\SFTP\...'
```

**Ursache:** Die Dateien sind über RaiDrive als SFTP-Mount eingebunden, und ich habe keine Schreibrechte.

**Lösungsmöglichkeiten für zukünftige Arbeiten:**
- Option 1: SFTP-Benutzer mit Schreibrechten verwenden
- Option 2: Direkter SSH-Zugriff auf den Server
- Option 3: RaiDrive-Einstellungen anpassen (falls möglich)
- Option 4: Lokale Entwicklungsumgebung mit Sync zum Server

### 2. Widget wird nicht angezeigt
**Problem:** Die Website läuft, aber das Cost Preview Widget ist nicht sichtbar.

**Ursachen:**
1. Das JavaScript findet die DOM-Elemente nicht (Alpine.js Integration fehlt)
2. Der Asset-Filter funktioniert nicht für Plugin-Assets
3. Die API-Route antwortet möglicherweise nicht korrekt

## Lösung für das Display-Problem

Führen Sie das neue Fix-Script aus:

```bash
cd /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview
chmod +x fix_widget_display.sh
bash fix_widget_display.sh
```

## Was das Fix-Script macht:

1. **Neues Alpine.js-basiertes Template installieren**
   - Nutzt die vorhandene Alpine.js Integration von Aikeedo
   - Überwacht das Prompt-Eingabefeld automatisch
   - Zeigt die Kostenschätzung in Echtzeit an

2. **API-Controller mit Debug-Logging aktualisieren**
   - Fügt Logging hinzu für besseres Debugging
   - Vereinfachte Token-Berechnung für Tests

3. **Cache leeren und PHP neustarten**

## Debugging nach der Installation:

1. **Browser-Konsole öffnen (F12)**
   - Suchen Sie nach: "Cost Preview Widget initialized"
   - Prüfen Sie auf JavaScript-Fehler

2. **Network-Tab prüfen**
   - Tippen Sie Text ins Chat-Feld
   - Schauen Sie nach Anfragen an `/api/cost-preview/estimate`
   - Prüfen Sie die Response

3. **PHP-Logs prüfen**
   ```bash
   tail -f /var/log/php*/error.log | grep CostPreview
   ```

## Falls es immer noch nicht funktioniert:

1. **Prüfen Sie ob das Widget im HTML ist:**
   - Rechtsklick → Element untersuchen
   - Suchen nach: `cost-preview-widget`

2. **Alpine.js Debugging:**
   ```javascript
   // In der Browser-Konsole:
   Alpine.version  // Sollte eine Version zeigen
   document.querySelector('[x-data*="costPreview"]')  // Sollte das Widget finden
   ```

3. **Manuelle API-Test:**
   ```bash
   curl -X POST https://aicent.de/api/cost-preview/estimate \
     -H "Content-Type: application/json" \
     -d '{"prompt":"Test prompt","model":"gpt-3.5-turbo"}'
   ```

## Alternative Schnelllösung:

Falls das Widget weiterhin nicht erscheint, können Sie die Kosten-Info direkt ins Chat-Interface einbauen:

1. Öffnen Sie `resources/views/templates/app/chat.twig`
2. Fügen Sie nach Zeile 402 (statt des include) folgendes ein:
   ```twig
   <div class="text-xs text-gray-500 px-4 py-2">
     💰 Token-Kosten werden in Kürze angezeigt...
   </div>
   ```

---

Die Hauptursache ist wahrscheinlich die fehlende Alpine.js Integration. Das neue Template sollte dies beheben.
