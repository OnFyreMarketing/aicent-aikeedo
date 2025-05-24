# Cost Preview Plugin - Vollständige Projektdokumentation

## 📋 PROJEKT-ÜBERSICHT

**Ziel:** Entwicklung eines Aikeedo-Plugins, das in Echtzeit die Credit-Kosten für KI-Anfragen anzeigt, BEVOR der User auf "Generate" klickt.

**Problem:** Das Plugin zeigt völlig falsche Kosten an (0.09 Credits statt echte 8.29 Credits von Aikeedo).

## 🏗️ TECHNISCHE INFRASTRUKTUR

### Aikeedo-System Analyse
- **Framework:** PHP 8.2+ mit Domain-Driven Design (DDD)
- **Routing:** `iziphp/router` mit Attribute-basierten Routen (`#[Route(...)]`)
- **DI Container:** `Easy\Container\Container` 
- **Template Engine:** Twig
- **Frontend:** Alpine.js + Tailwind CSS + Vite
- **Datenbank:** Doctrine ORM mit MySQL/SQLite Support

### Plugin-Struktur
```
extra/extensions/aicent/cost-preview-plugin/
├── src/
│   ├── Plugin.php (Haupt-Plugin-Klasse)
│   └── CostPreviewApiController.php (API-Endpunkte)
├── assets/
│   └── cost-preview.js (Frontend-JavaScript)
├── templates/
│   └── cost-preview.twig (Templates)
└── composer.json (Plugin-Metadaten)
```

## 🔍 KERNPROBLEM-ANALYSE

### Problem 1: Falsche Token-Berechnung
**Plugin berechnet:** 77 Zeichen → 20 Tokens, 773 Zeichen → 30 Tokens
**Realität:** 77 Zeichen → ~19 Tokens ✅, 773 Zeichen → ~193 Tokens ❌

**Root Cause:** Vereinfachte Token-Schätzung vs. echte API-Token-Counts
```javascript
// FALSCH (aktuell):
const words = str_word_count($text);
return (int)($words * 1.3);

// BESSER:
const tokensByWords = Math.ceil(words * 1.33);
const tokensByChars = Math.ceil(text.length / 4);
return Math.max(tokensByWords, tokensByChars);
```

### Problem 2: Credit-Raten-Diskrepanz
**Plugin verwendet:** Fallback-Raten (0.0015/0.002) oder API-Fehler
**Aikeedo Backend:** 0.001/0.001 (1 Token = 0.001 Credits)

**Root Cause:** API-Route `/api/cost-preview/rates` gibt 404-Fehler

### Problem 3: Massive Kostendifferenz
**Plugin-Berechnung:** 0.09 Credits
**Aikeedo-Realität:** 8.29 Credits
**Faktor:** ~92x Unterschied!

## 🧮 KOSTEN-BERECHNUNGS-LOGIK

### Aikeedo's echte Berechnung:
```php
// 1. Echte Token-Counts von LLM-API:
$inputTokensCount += $data->usage->prompt_tokens ?? 0;
$outputTokensCount += $data->usage->completion_tokens ?? 0;

// 2. Mit CostCalculator:
$inputCost = $this->calc->calculate($inputTokens, $model, CostCalculator::INPUT);
$outputCost = $this->calc->calculate($outputTokens, $model, CostCalculator::OUTPUT);

// 3. Plus Tool-Kosten:
return new CreditCount($inputCost->value + $outputCost->value + $toolCost->value);
```

### Backend Credit-Raten (bestätigt):
- **GPT 3.5 turbo (input):** 1 Token = 0.001 Credits
- **GPT 3.5 turbo (output):** 1 Token = 0.001 Credits
- **Verhältnis:** 1 Credit = 1.000 Tokens

### Reverse Engineering:
```
8.29 Credits bei 0.001/0.001 Raten = 8.290 Tokens total
Mögliche Kombinationen:
- 100 Input + 8.190 Output Tokens
- 500 Input + 7.790 Output Tokens
- etc.
```

## 🛠️ BISHERIGE LÖSUNGSANSÄTZE

### 1. API-Controller Entwicklung
**Datei:** `src/CostPreviewApiController.php`
**Endpunkte:**
- `GET /api/cost-preview/rates` - Lädt echte Credit-Raten
- `POST /api/cost-preview/estimate` - Schätzt Kosten

**Status:** ✅ Code korrekt, aber 404-Fehler

### 2. Frontend JavaScript
**Datei:** `assets/cost-preview.js`
**Features:**
- Echtzeit Token-Schätzung
- Model-Detection
- Cost-Widget mit Floating UI
- API-Integration

**Status:** ✅ Funktioniert, aber mit falschen Daten

### 3. Plugin-Integration
**Datei:** `src/Plugin.php`
**Versuche:**
- Container-Registrierung ❌
- Route-Registrierung via SimpleMapper ❌
- Copy nach Core-API ❌ (immer noch 404)

## 🚨 AKTUELLE PROBLEME

### Problem A: 404 API-Route
**Symptom:** `GET /api/cost-preview/rates` → 404 Not Found
**Ursache:** Route wird nicht vom Aikeedo Router erkannt
**Versuche:**
1. Attribute-basierte Routen in Plugin ❌
2. Manuelle Route-Registrierung ❌  
3. Copy nach `src/Presentation/RequestHandlers/Api/` ❌

### Problem B: SFTP-Mount Schreibrechte
**Symptom:** `EPERM: operation not permitted`
**Ursache:** Desktop Commander kann nicht auf SFTP-Mount schreiben
**Impact:** Erschwert Debugging und Entwicklung massiv

### Problem C: Plugin-System Unklarheit
**Frage:** Wie registriert man API-Routes in Aikeedo-Plugins?
**Status:** Dokumentation unvollständig, Trial & Error erfolglos

## 🎯 LÖSUNGSSTRATEGIEN

### Strategie 1: Route-Problem lösen
**Option A:** Direkter VPS-Zugang für Debugging
**Option B:** Route-Registrierung über Core-System
**Option C:** Alternative API-Endpunkt nutzen

### Strategie 2: Token-Berechnung verbessern
```javascript
// Implementierung realistischer Token-Schätzung:
calculateTokensImproved(text) {
    const words = text.split(/\s+/).length;
    const tokensByWords = Math.ceil(words * 1.33);
    const tokensByChars = Math.ceil(text.length / 4);
    
    let adjustmentFactor = 1.0;
    if (/\{|\}|function|class/.test(text)) adjustmentFactor += 0.2; // Code
    if (/[^\w\s]/.test(text)) adjustmentFactor += 0.1; // Sonderzeichen
    
    return Math.ceil(Math.max(tokensByWords, tokensByChars) * adjustmentFactor);
}
```

### Strategie 3: Tool-Kosten berücksichtigen
```javascript
// Erkennung von Tool-Usage:
const usesGoogleSearch = /such.*nach|aktuelle|news/.test(prompt);
const usesImageGen = /generiere.*bild|create.*image/.test(prompt);

let toolCosts = 0;
if (usesGoogleSearch) toolCosts += 8.0; // Serper-Rate
if (usesImageGen) toolCosts += 5.0; // DALL-E Rate
```

## 🔧 TECHNISCHE ERKENNTNISSE

### Aikeedo Routing-System:
- **AttributeMapper:** Scannt `src/` nach `#[Route]` Attributen
- **SimpleMapper:** Für programmatische Route-Registrierung
- **Cache:** Routen werden gecacht, `rm -rf var/cache/*` erforderlich

### Plugin-System:
- **Entrypoint:** `Plugin::boot(Context $context)`
- **Container-Zugriff:** Über `$context` oder `Application::make()`
- **Namespace:** Muss `Plugin\Domain\PluginInterface` implementieren

### OptionResolver-System:
```php
// Korrekte Verwendung:
$allOptions = $this->optionResolver->getOptionMap();
$creditRates = $allOptions['option.credit_rate'] ?? [];

// FALSCH:
$creditRates = $this->optionResolver->get('credit_rate', []);
```

## 📊 DEBUGGING-DATEN

### Konfirmierte Werte:
- **Echter Input:** 77 Zeichen → ~19 Tokens
- **Echter Output:** 773 Zeichen → ~193 Tokens (geschätzt)
- **Backend Raten:** 0.001 Credits/Token
- **Plugin Fallback:** 0.0015/0.002 Credits/Token
- **Aikeedo Kosten:** 8.29 Credits
- **Plugin Kosten:** 0.09 Credits

### Testfall:
```
Input: "kurzer test prompt" (77 Zeichen)
Output: "längere antwort..." (773 Zeichen)
Aikeedo Result: 8.29 Credits
Plugin Result: 0.09 Credits
```

## 🚀 NÄCHSTE SCHRITTE

### Priorität 1: VPS-Zugang etablieren
- SSH-Zugang testen
- Web-Terminal optimieren
- Direkte Dateiberarbeitung ermöglichen

### Priorität 2: API-Route lösen
- Route-Registrierung debuggen
- Cache-Clearing testen
- Alternative Integration-Methoden

### Priorität 3: Token-Berechnung korrigieren
- Realistische Schätzalgorithmen
- API-basierte Token-Counts (falls möglich)
- Tool-Usage Detection

### Priorität 4: Testing & Validation
- End-to-End Tests
- Verschiedene Prompt-Typen
- Model-spezifische Raten

## 📁 WICHTIGE DATEIEN

### Core Files:
- `src/Ai/Infrastructure/Services/CostCalculator.php` - Echte Kostenberechnung
- `src/Option/Infrastructure/OptionResolver.php` - Credit-Raten laden
- `src/Presentation/ServerRequestHandler.php` - Route-Handling

### Plugin Files:
- `extra/extensions/aicent/cost-preview-plugin/src/Plugin.php`
- `extra/extensions/aicent/cost-preview-plugin/src/CostPreviewApiController.php`
- `extra/extensions/aicent/cost-preview-plugin/assets/cost-preview.js`

### Debug Files:
- `debug_cost_api.php` (geplant)
- `web-terminal.php` (implementiert)

## 🎯 ERFOLGSKRITERIEN

**Funktional:**
- [ ] API-Route `/api/cost-preview/rates` gibt echte Raten zurück
- [ ] Token-Schätzung liegt bei ±20% der Realität  
- [ ] Kostenschätzung liegt bei ±10% der Aikeedo-Kosten
- [ ] Plugin zeigt bei Testfall ~8.29 Credits an

**Technisch:**
- [ ] Saubere Plugin-Integration ohne Core-Modifikation
- [ ] Keine Performance-Impacts
- [ ] Fehlerbehandlung für API-Ausfälle
- [ ] Cross-Browser Kompatibilität

**UX:**
- [ ] Widget erscheint nur bei relevanten Eingaben
- [ ] Echtzeit-Updates während Typing
- [ ] Visuell ansprechende Darstellung
- [ ] Keine störenden Pop-ups

---

**Status:** 🔴 Blockiert - API-Route 404, VPS-Zugang erforderlich
**Letzte Aktualisierung:** 2025-01-24
**Nächster Chat:** Beginne mit VPS-Zugang und Route-Debugging