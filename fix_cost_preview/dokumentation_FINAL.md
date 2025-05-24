# Dokumentation: Cost Preview Plugin für Aikeedo

## Stand: Dezember 2024 - Update 2

### ✅ GELÖST: Plugin läuft wieder

**Problem 1:** Twig Service Name
- **Fehler:** `An entry with an id of twig.loader is not registered`
- **Lösung:** Plugin.php korrigiert - verwendet jetzt `Twig\Loader\FilesystemLoader::class`
- **Status:** ✅ Behoben mit fix_plugin.sh

### ⚠️ AKTUELL: Widget wird nicht angezeigt

**Problem 2:** Cost Preview Widget ist unsichtbar
- **Symptom:** Website läuft, aber keine Kostenschätzung sichtbar
- **Ursache:** Fehlende Alpine.js Integration und Asset-Loading-Probleme

**Lösung verfügbar:**
```bash
cd /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview
bash fix_widget_display.sh
```

### 📁 Rechteproblem bei Dateizugriff

**Hindernis:** Desktop Commander kann nicht direkt schreiben
- **Fehler:** `EPERM: operation not permitted` über RaiDrive SFTP
- **Workaround:** Fix-Scripts erstellt, die manuell ausgeführt werden

**Lösungsmöglichkeiten für die Zukunft:**
1. SFTP-Benutzer mit vollen Schreibrechten
2. Direkter SSH-Zugriff statt SFTP-Mount
3. Lokale Entwicklung mit rsync/deployment

### 🔧 Technische Details

**Plugin-Struktur:**
```
extra/extensions/aicent/cost-preview-plugin/
├── composer.json          # Plugin-Metadaten
├── src/
│   ├── Plugin.php        # ✅ Korrigiert (Twig-Service)
│   └── CostPreviewApiController.php  # API-Endpunkt
├── templates/
│   └── cost-preview.twig # ⚠️ Wird aktualisiert für Alpine.js
└── assets/
    └── cost-preview.js   # Original JavaScript (nicht mehr verwendet)
```

**Integration in Aikeedo:**
- Template eingebunden in: `resources/views/templates/app/chat.twig` (Zeile 402)
- API-Route: `/api/cost-preview/estimate`
- Verwendet Alpine.js (bereits in Aikeedo vorhanden)

### 📊 Testing-Status

- [x] Plugin.php verwendet korrekten Service-Namen
- [x] Chat-Seite lädt ohne PHP-Fehler  
- [ ] Cost Preview Widget wird angezeigt
- [ ] Token werden beim Tippen gezählt
- [ ] API-Endpunkt antwortet korrekt
- [ ] Kostenschätzung wird berechnet

### 🐛 Debugging-Befehle

```bash
# PHP Error Logs
tail -f /var/log/php*/error.log | grep -E "(CostPreview|Twig)"

# API Test
curl -X POST https://aicent.de/api/cost-preview/estimate \
  -H "Content-Type: application/json" \
  -d '{"prompt":"Test","model":"gpt-3.5-turbo"}'

# Cache leeren
rm -rf var/cache/*
systemctl restart php8.2-fpm
```

### 📝 Nächste Schritte

1. **fix_widget_display.sh ausführen** - Behebt das Display-Problem
2. **Browser-Konsole prüfen** - JavaScript-Fehler identifizieren
3. **API-Response testen** - Funktioniert der Endpunkt?
4. **Alpine.js Integration verifizieren** - Wird das Widget initialisiert?

### 🚀 Zukünftige Verbesserungen

1. **Genauere Token-Berechnung**: Integration von tiktoken oder ähnlichen Libraries
2. **Model-spezifische Kosten**: Dynamisches Laden aus Aikeedo's ModelRegistry
3. **Historische Daten**: Analyse vergangener Generierungen für bessere Schätzungen
4. **Caching**: Reduzierung der API-Aufrufe durch intelligentes Caching

---

**Entwickelt von:** Aicent  
**Version:** 1.2 (Bugfix Release)  
**Kontakt:** Bei Problemen konsultieren Sie die AGENT.md für technische Details
