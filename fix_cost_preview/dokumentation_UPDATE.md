# Dokumentation: Cost Preview Plugin für Aikeedo

## Aktueller Stand (Dezember 2024)

### GELÖSTES PROBLEM: Twig Service Name

**Fehlermeldung:**
```
PHP Fatal error: Uncaught Easy\Container\Exceptions\NotFoundException: 
An entry with an id of twig.loader is not registered
```

**Ursache:**
Das Plugin versuchte den Service 'twig.loader' zu verwenden, aber in Aikeedo ist der Service als `Twig\Loader\FilesystemLoader::class` registriert.

**Lösung:**
Die Plugin.php wurde korrigiert, um die richtigen Service-Namen zu verwenden:
- `Twig\Loader\FilesystemLoader::class` statt 'twig.loader'
- Fallback auf `Twig\Environment::class`

### Durchgeführte Korrekturen

1. **Fix-Dateien erstellt im Verzeichnis `fix_cost_preview/`:**
   - `Plugin_FIXED.php` - Korrigierte Version der Plugin-Klasse
   - `fix_plugin.sh` - Automatisches Fix-Script
   - `debug_twig_v2.php` - Debug-Script ohne Bootstrap-Laden
   - `SOFORT_LOESUNG.md` - Schnellanleitung

2. **Änderungen in Plugin.php:**
   - Verwendet jetzt `FilesystemLoader::class` statt 'twig.loader'
   - Fügt Fehlerbehandlung und Logging hinzu
   - Prüft mehrere mögliche Service-Namen

### Installation der Korrektur

```bash
# Automatisch mit Script:
bash /var/www/vhosts/aicent.de/httpdocs/aicent/fix_cost_preview/fix_plugin.sh

# ODER manuell:
cp fix_cost_preview/Plugin_FIXED.php extra/extensions/aicent/cost-preview-plugin/src/Plugin.php
rm -rf var/cache/*
systemctl restart php8.2-fpm
```

### Technische Details aus AGENT.md

- **ViewEngineProvider** registriert Twig-Services:
  - `Twig\Environment` 
  - `Twig\Loader\FilesystemLoader`
- **Keine** Services mit Namen wie 'twig.loader' oder 'twig'
- Plugins werden durch `PluginModuleBootstrapper` geladen
- Die `boot()` Methode wird für aktive Plugins aufgerufen

### Plugin-Struktur

```
extra/extensions/aicent/cost-preview-plugin/
├── composer.json
├── src/
│   ├── Plugin.php (Hauptklasse, implementiert PluginInterface)
│   ├── CostPreviewApiController.php
│   └── Services/
│       └── CostCalculationService.php
├── templates/
│   └── cost-preview.twig
└── assets/
    └── js/
        └── cost-preview.js
```

### Frontend-Integration

Das Plugin wird in `resources/views/templates/app/chat.twig` eingebunden:
```twig
{% include '@CostPreviewPlugin/cost-preview.twig' %}
```

Der Namespace `@CostPreviewPlugin` wird durch die Plugin-Klasse registriert.

### API-Endpunkt

- **Route:** `/api/cost-preview/estimate`
- **Method:** POST
- **Parameter:** 
  - `prompt` - Der Benutzer-Prompt
  - `model` - Das ausgewählte KI-Modell
  - `template` - Das verwendete Template (optional)

### Bekannte Probleme und Lösungen

1. **Twig-Namespace nicht gefunden**
   - Lösung: Plugin.php korrigieren (bereits durchgeführt)

2. **JavaScript wird nicht geladen**
   - Prüfen: composer.json muss assets deklarieren
   - Cache leeren und neu builden

3. **API gibt 404 zurück**
   - Route-Cache leeren
   - Prüfen ob Controller im Container registriert ist

### Testing-Checkliste

- [x] Plugin.php verwendet korrekten Service-Namen
- [ ] Chat-Seite lädt ohne Fehler
- [ ] Cost Preview Widget wird angezeigt
- [ ] Token werden beim Tippen gezählt
- [ ] Kostenschätzung wird angezeigt
- [ ] API-Endpunkt antwortet korrekt

### Wartung

- Error-Logs regelmäßig prüfen: `/var/log/php*/error.log`
- Bei Aikeedo-Updates Plugin-Kompatibilität prüfen
- Twig-Service-Namen können sich ändern - AGENT.md konsultieren

---

## Entwicklungshistorie

### Version 1.0 (Initial)
- Grundlegende Plugin-Struktur
- API-Endpunkt für Kostenschätzung
- Frontend-Widget

### Version 1.1 (Bugfix)
- Korrektur des Twig-Service-Namen
- Verbessertes Error-Handling
- Debug-Scripts hinzugefügt
