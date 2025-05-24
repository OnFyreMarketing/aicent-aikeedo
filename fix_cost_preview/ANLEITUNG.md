# Anleitung zur Fehlerbehebung des Cost Preview Plugins

## Problem
Das Cost Preview Plugin verursacht einen Twig-Template-Fehler beim Laden der Chat-Seite.

## Lösung

### 1. Plugin.php korrigieren

Ersetzen Sie den Inhalt der Datei:
`extra/extensions/aicent/cost-preview-plugin/src/Plugin.php`

mit dem Inhalt aus der Datei:
`fix_cost_preview/Plugin.php`

### 2. Alternative Lösung (falls die erste nicht funktioniert)

Basierend auf der AGENT.md Analyse gibt es einen anderen Weg, die Twig-Templates zu registrieren.

Erstellen Sie eine neue Datei:
`extra/extensions/aicent/cost-preview-plugin/src/TwigExtension.php`
