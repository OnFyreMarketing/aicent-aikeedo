# Aikeedo Cost Preview Plugin - Entwicklungsdokumentation

Dieses Dokument beschreibt die Entwicklung des Cost Preview Plugins für Aikeedo v3.0.

## Initialisierung

- Erstellung dieser Dokumentationsdatei.

## Plugin-Grundstruktur

- Erstellung der `composer.json` Datei für das Plugin unter `extra/extensions/aicent/cost-preview-plugin/composer.json`.
  - Definiert Metadaten wie Name, Typ, Version, Beschreibung, Abhängigkeiten (insbesondere `heyaikeedo/composer`) und den Autoloader.
  - Legt die `entry-class` auf `Aicent\CostPreviewPlugin\Plugin` fest.
- Erstellung der Haupt-Plugin-Klasse `Plugin.php` unter `extra/extensions/aicent/cost-preview-plugin/src/Plugin.php`.
  - Implementiert die `Plugin\Domain\PluginInterface`.
  - Enthält grundlegende Methoden wie `getName()`, `getDescription()`, `install()`, `uninstall()`, `activate()`, und `deactivate()`.

## Backend-Logik: API Endpunkt

- Erstellung der `ApiController.php` unter `extra/extensions/aicent/cost-preview-plugin/src/ApiController.php`.
  - Diese Klasse wird die Logik zur Berechnung der Kostenvorschau enthalten.
  - Aktuell enthält sie eine Platzhalterimplementierung `getCostPreview()`, die Dummy-Daten zurückgibt.
- Aktualisierung der `Plugin.php`:
  - Hinzufügen der `getRoutes(Context $context): ?RouteCollection` Methode.
  - Registrierung einer POST-Route `/api/cost-preview`, die auf `Aicent\CostPreviewPlugin\ApiController::getCostPreview` verweist.
  - Import von `Plugin\Domain\Routes\RouteCollection`.

## Frontend-Logik

- Erstellung der JavaScript-Datei `cost-preview.js` unter `extra/extensions/aicent/cost-preview-plugin/assets/js/cost-preview.js`.
  - Diese Datei enthält die Logik, um auf Änderungen in den Prompt- und LLM-Auswahlfeldern zu lauschen.
  - Bei Änderungen sendet sie eine Anfrage an den `/api/cost-preview` Endpunkt.
  - Das Ergebnis (geschätzte Kosten oder Fehler) wird in einem dafür vorgesehenen HTML-Element angezeigt.
  - Enthält Platzhalter für DOM-Selektoren, die an das spezifische Aikeedo-Frontend angepasst werden müssen.
  - Implementiert eine Debounce-Funktion, um die Anzahl der API-Anfragen zu reduzieren.
- Aktualisierung der `Plugin.php`:
  - Hinzufügen der `getAssets(Context $context): ?AssetCollection` Methode.
  - Registrierung der `cost-preview.js` Datei als JavaScript-Asset, das auf den relevanten Seiten geladen wird.
  - Import von `Plugin\Domain\Assets\AssetCollection`.

## Fehlerbehebung: Fatal Error durch ungültigen Plugin-Namen

- **Problem:** Die Webseite war nicht aufrufbar aufgrund eines `InvalidArgumentException` in `Plugin\Domain\ValueObjects\Name`. Die Fehlermeldung zeigte, dass der Name `AikeedoPlugins/CostPreviewPlugin` ungültig war, wahrscheinlich wegen des Schrägstrichs.
- **Lösungsschritte:**
    1.  Der Plugin-Name in `extra/extensions/AikeedoPlugins/CostPreviewPlugin/composer.json` (jetzt `extra/extensions/AikeedoPlugins-CostPreviewPlugin/composer.json`) wurde von `AikeedoPlugins/CostPreviewPlugin` zu `AikeedoPlugins-CostPreviewPlugin` geändert.
    2.  Der Plugin-Ordner `extra/extensions/AikeedoPlugins/CostPreviewPlugin` wurde zu `extra/extensions/AikeedoPlugins-CostPreviewPlugin` umbenannt.
- **Ergebnis:** Der Fatal Error wurde behoben und die Seite ist wieder aufrufbar.

## Implementierung der Kostenberechnung im Backend (`ApiController.php`)

- **Ziel:** Die Platzhalterlogik zur Kostenberechnung durch eine tatsächliche Implementierung ersetzen, die auf Aikeedo-spezifische Konfigurationen für LLM-Kosten zugreift.
- **Untersuchung:**
    - Es wurde festgestellt, dass Aikeedo LLM-Modelle und deren Konfigurationen (inklusive potenzieller Kostenraten) über die Klasse `Shared\Infrastructure\Services\ModelRegistry` verwaltet.
    - Diese Registry lädt Daten aus `config/registry.base.json` und `config/registry.json`.
    - Die Struktur in `registry.json` (und `LlmConfigApi.php`) zeigt, dass Modelle 'rates' für 'input' und 'output' Tokens haben können, inklusive 'cost' und 'per' (z.B. Kosten pro 1000 Tokens).
- **Implementierungsschritte:**
    1.  Die Klasse `Aicent\CostPreviewPlugin\ApiController` wurde angepasst, um `Shared\Infrastructure\Services\ModelRegistry` per Dependency Injection zu erhalten.
    2.  Die Methode `getCostPreview` wurde überarbeitet:
        - Sie extrahiert `prompt` und `llm_id` aus dem `ServerRequestInterface`.
        - Sie sucht die Konfiguration des ausgewählten `llm_id` in der `ModelRegistry`.
        - Sie liest die `rates` (Kosten pro Input/Output-Token) aus der LLM-Konfiguration. Es wird angenommen, dass die Kosten pro Token oder bereits umgerechnet sind. Eine Logik zur Behandlung von Kosten pro X Tokens (z.B. pro 1000) wurde hinzugefügt (`$costValue / $perUnit`).
        - Eine einfache Token-Zählfunktion (`countTokens`) basierend auf der Zeichenlänge (`mb_strlen($text) / 3`) wurde implementiert, da eine modellspezifische Tokenizer-Bibliothek nicht unmittelbar verfügbar war.
        - Die geschätzten Output-Tokens werden aktuell als das Doppelte der Input-Tokens angenommen. Dies ist eine grobe Schätzung.
        - Die Gesamtkosten werden berechnet und als JSON-Antwort zurückgegeben, inklusive der geschätzten Credits, der verwendeten LLM-ID, der Anzahl der Input-Tokens und der angenommenen Output-Tokens.
        - Fallback-Kosten und eine entsprechende Benutzernachricht wurden hinzugefügt, falls keine spezifischen Raten für ein Modell konfiguriert sind.
- **Wichtige Annahmen und Hinweise:**
    - Die genaue Struktur der `cost` und `per` Felder in den `rates` der `registry.json` ist entscheidend für die korrekte Kostenberechnung. Die aktuelle Implementierung geht von Kosten pro Token aus, nachdem sie durch `per` geteilt wurden.
    - Die Token-Zählung ist eine grobe Schätzung und sollte idealerweise durch eine präzisere, modellspezifische Methode ersetzt werden.
    - Die Schätzung der Output-Token-Anzahl ist ebenfalls sehr grob und sollte verfeinert werden (z.B. durch einen konfigurierbaren Durchschnittswert pro Modell oder eine dynamischere Schätzung).
    - Die `currency` wird nun aus der LLM-Konfiguration bezogen oder fällt auf 'Credits' zurück.

## Offene Punkte und nächste Schritte

Das Grundgerüst des Cost Preview Plugins ist nun erstellt. Für eine vollständige Funktionalität sind jedoch folgende Schritte notwendig:

1.  **Backend-Implementierung (`ApiController.php`): (Größtenteils abgeschlossen, siehe oben)
    *   **Zugriff auf Aikeedo-Dienste:** Die Platzhalter für `ConfigService` und `LlmService` (oder deren Äquivalente in Aikeedo v3.0) müssen durch die tatsächlichen Dienste ersetzt werden, um auf Konfigurationen und LLM-Daten zugreifen zu können.
    *   **LLM-Kostendaten:** Die Logik zum Abrufen der Kosten pro Input- und Output-Token wurde implementiert unter Verwendung der `ModelRegistry`. Eine genauere Schätzung der Output-Token-Länge ist noch offen.
    *   **Token-Zählung:** Eine einfache Methode zur Zählung der Input-Tokens (`mb_strlen / 3`) wurde implementiert. Für höhere Genauigkeit wäre eine modellspezifische Tokenizer-Bibliothek erforderlich.
    *   **Vorlagen-Logik:** Falls die Kostenberechnung auch KI-Vorlagen berücksichtigen soll, muss die `fetchTemplateText()` Methode implementiert werden, um den Text der ausgewählten Vorlage abzurufen.
    *   **Request- und Response-Objekte:** `ServerRequestInterface` wird nun für den Request verwendet. Die Response ist ein Array, das Aikeedo vermutlich in ein JSON-Objekt umwandelt. Spezifische Aikeedo `Request`/`JsonResponse`-Objekte werden noch nicht direkt verwendet, da ihre genaue Signatur im Plugin-Kontext unklar ist.

2.  **Frontend-Anpassung (`cost-preview.js`):
    *   **DOM-Selektoren:** Die Platzhalter-Selektoren (`promptInputSelector`, `llmSelectSelector`, `generateButtonSelector`, `costPreviewDisplaySelector`) müssen exakt an die HTML-Struktur des Aikeedo-Frontends (speziell der Seite, auf der die KI-Generierung stattfindet) angepasst werden.
    *   **CSRF-Token/Header:** Falls von Aikeedo für POST-Requests an API-Endpunkte erforderlich, müssen entsprechende CSRF-Token oder andere Security-Header im `fetch`-Aufruf ergänzt werden.
    *   **Styling:** Das Styling des `costPreviewDisplay`-Elements kann weiter verfeinert werden, um sich nahtlos in das Aikeedo UI-Design einzufügen.
    *   **Genauigkeit der Output-Token-Schätzung:** Die aktuelle Annahme (doppelte Input-Tokens) ist sehr ungenau und sollte verbessert werden, z.B. durch einen konfigurierbaren Durchschnittswert pro Modell.

3.  **Testing:
    *   Umfangreiche Tests mit verschiedenen Prompts, LLMs und (falls implementiert) Vorlagen sind notwendig, um die Korrektheit der Kostenberechnung und die Stabilität des Plugins sicherzustellen.

4.  **Plugin-Installation und Aktivierung in Aikeedo:
    *   Nach der Entwicklung muss das Plugin im Aikeedo-Backend installiert und aktiviert werden, um seine Funktionalität zu testen.

Diese Dokumentation dient als Grundlage für die weitere Entwicklung und Integration des Cost Preview Plugins in die Aikeedo v3.0 Plattform.