**3. Kostenvorschau (Pre-Kalkulation von Credits)**

*   **Potenzial & Mehrwert:** Enorm wichtig für Transparenz und Nutzervertrauen! Einer der größten Schmerzpunkte bei vielen Token-basierten KI-Diensten.
*   **Differenzierung:** Würde Aikeedo deutlich von vielen Konkurrenten abheben, die hier intransparent sind.
*   **Herausforderungen:**
    *   **Komplexität der Kalkulation:**
        *   **Input-Token:** Kann vor Absenden des Prompts relativ genau berechnet werden (Anzahl der Wörter/Zeichen umrechnen in Tokens, modellspezifisch).
        *   **Output-Token:** Durchschnittliche Outputtoken (Wahrscheinlichkeit) berechnen oder maximale Output-Token als Grundlage.
        *   **Modellspezifische Kosten:** Jeder LLM-Anbieter und jedes Modell hat unterschiedliche Kosten pro Input- und Output-Token. Das muss im Plugin hinterlegt und aktuell gehalten werden --> In Aikeedo bereits pro Model hinterlegt irgendwo.
        *   **KI-Vorlagen:** Die Prompt-Länge der Vorlage selbst muss berücksichtigt werden.
        *   **KI-Assistenten/Workflows:** Wenn mehrere Schritte involviert sind, wird die Kalkulation noch komplexer.
*   **Umsetzungsideen für ein Plugin:**
    *   **Eingabefeld-Analyse:** Während der Nutzer tippt, könnte das Plugin die ungefähre Anzahl der Input-Tokens anzeigen.
    *   **Modellauswahl-Indikator:** Sobald ein LLM ausgewählt ist, könnten die bekannten Kosten pro 1k Input/Output-Token für dieses Modell (aus deiner OpenRouter-Konfiguration oder einer internen Datenbank) angezeigt werden.
    *   **Schätzung für Kosten:**
        *Zeige eine Spanne an ("voraussichtlich X bis Y Credits").
    *   **KI-Vorlagen:** Das Plugin könnte die Token-Länge der Vorlage selbst analysieren und zu den Input-Tokens des Nutzers addieren.
    *   **Transparente Anzeige:** Zeige dem Nutzer vor dem Klick auf "Generieren" eine Aufschlüsselung: "Geschätzte Credits: X (Mit einem Hinweis in Form eines Tooltips, dass die Output-Kosten variieren können).
    *   **Verlauf:** Im Nutzungsverlauf könnte man die tatsächlichen Kosten pro Generierung anzeigen, damit Nutzer ein Gefühl dafür bekommen.

**Technische Überlegungen für die Kostenvorschau:**

*   **Tokenisierungs-Bibliotheken:** Du bräuchtest serverseitig Zugriff auf Tokenizer, die kompatibel mit den jeweiligen Modellen sind (z.B. Tiktoken für OpenAI-Modelle, SentencePiece für andere). Das ist wichtig für eine genaue Input-Token-Zählung. OpenRouter könnte hier eventuell auch Infos liefern.
*   **Datenbank für Modellkosten:** Du musst die Kosten pro Token (Input/Output) für jedes Modell, das du anbietest, irgendwo speichern und aktuell halten --> Aikeedo hat intern irgendwo eine "Kostentabelle", diese müsste nach noch ergänzbar um die Custom LLM-Server und Modelle erweitert werden.
*   **Asynchrone Berechnung:** Die Token-Zählung und Kostenschätzung sollte das Frontend nicht blockieren.