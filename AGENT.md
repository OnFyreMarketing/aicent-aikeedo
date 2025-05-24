# Aikeedo Systemanalyse für LLMs

Dieses Dokument bietet eine tiefgehende Analyse des Aikeedo-Systems, um Sprachmodellen (LLMs) ein umfassendes Verständnis der Struktur, Technologie, Architektur, Abhängigkeiten, Funktionen, Abläufe, Logiken und Routen zu ermöglichen. Ziel ist es, Anpassungen, Änderungen und Ergänzungen des Systems zu erleichtern.

## 1. Übersicht

Aikeedo ist eine KI-gestützte Content-Plattform, die als Webanwendung konzipiert ist. Sie ermöglicht Benutzern das Generieren verschiedener Inhalte wie Blogs, Social-Media-Posts, Marketing-E-Mails, Programmiercode, Bilder, Videos und mehr.
Es ist nach dem Domain-Driven-Design (DDD) erstellt.

- **Offizielle Dokumentation:** [https://docs.aikeedo.com](https://docs.aikeedo.com)

## 2. Technologie-Stack

Basierend auf den ersten Analysen der `composer.json` und `package.json` Dateien, setzt Aikeedo auf folgende Technologien:

### 2.1. Backend

- **Programmiersprache:** PHP (Version ^8.2)
- **Framework/Hauptkomponenten:**
    - Symfony-Komponenten (HttpClient, Cache, Console, Intl, Mailer, Yaml)
    - Doctrine (ORM ^3.3, DBAL ^4.2, Migrations ^3.8) für Datenbankinteraktion und Schema-Management.
    - Iziphp Komponenten (http-server-dispatcher, http-response-emitter, http-message-util, autoloader, container, http-server-handler, router, event-dispatcher, emitter, menv)
    - Laminas Diactoros (PSR-7 HTTP Nachrichten Implementation)
    - Twig (^3.20) als Template-Engine.
- **Abhängigkeiten (Auswahl):**
    - `vlucas/phpdotenv`: Laden von Umgebungsvariablen.
    - `monolog/monolog`: Logging.
    - `firebase/php-jwt`: JSON Web Token Handling.
    - `stripe/stripe-php`: Integration von Stripe für Zahlungsabwicklungen.
    - `google/cloud-text-to-speech`: Google Cloud Text-to-Speech API.
    - `league/flysystem`: Dateisystemabstraktion.
    - `gettext/gettext`, `gettext/translator`, `gettext/php-scanner`: Internationalisierung und Lokalisierung.
    - `smalot/pdfparser`: Parsen von PDF-Dateien.
    - `phpoffice/phpword`: Arbeiten mit Word-Dokumenten.
- **PSR Standards:** Das Projekt nutzt diverse PSR-Interfaces (PSR-3, PSR-7, PSR-11, PSR-12, PSR-14, PSR-15, PSR-16, PSR-17, PSR-18).

### 2.2. Frontend

- **Build-Tool:** Vite
- **JavaScript-Framework/Bibliotheken:**
    - Alpine.js (^3.14.8) für reaktive UI-Komponenten.
    - Tailwind CSS (^4.1.6) für das Styling.
    - ApexCharts (^4.5.0) für Diagramme.
    - Highlight.js für Syntax-Hervorhebung.
    - Katex für mathematische Formeln.
    - Wavesurfer.js für Audio-Wellenformen.
- **CSS-Framework:** Tailwind CSS

### 2.3. Entwicklungswerkzeuge & QA

- **PHP:**
    - PHPUnit: Unit-Tests.
    - PHPStan: Statische Analyse.
    - PHP_CodeSniffer: Coding-Standards.
    - PHPMD: Mess Detector.
- **JavaScript:**
    - Vite als Build-System und Dev-Server.

## 3. Projektstruktur

Basierend auf der Analyse des Stammverzeichnisses ergibt sich folgende Struktur:

```
.
├── .babelrc.json       # Babel-Konfiguration (JavaScript-Compiler)
├── .env                # Umgebungsvariablen (lokal, nicht versioniert)
├── .env.example        # Beispiel für Umgebungsvariablen
├── .gitignore          # Definiert von Git ignorierte Dateien und Verzeichnisse
├── AGENT.md            # Dieses Analyse-Dokument
├── LICENSE             # Lizenzinformationen des Projekts
├── README.md           # Allgemeine Informationen zum Projekt
├── VERSION             # Aktuelle Version der Anwendung
├── bin/                # Ausführbare Skripte (z.B. Konsolenbefehle)
├── bootstrap/          # Initialisierungs-Skripte der Anwendung
├── ci/                 # Konfigurationsdateien für Continuous Integration
├── composer.json       # PHP-Abhängigkeitsmanagement
├── composer.lock       # Genaue Versionen der PHP-Abhängigkeiten
├── config/             # Konfigurationsdateien der Anwendung
├── cron.php            # Skript für Cronjobs
├── data/               # Speicherung von Anwendungsdaten (z.B. Uploads, Cache)
├── docs/               # Dokumentation (leitet aktuell auf externe Seite um)
├── etc/                # Weitere Konfigurationsdateien (oft System-nah)
├── extra/              # Zusätzliche Module, Plugins oder Artefakte
│   ├── artifacts/
│   └── extensions/
├── helpers/            # Verzeichnis für Hilfsfunktionen
│   └── helpers.php     # Globale PHP-Hilfsfunktionen
├── jsconfig.json       # Konfiguration für JavaScript-Projekte (oft für IDEs)
├── locale/             # Sprachdateien für Internationalisierung (i18n)
├── migrations/         # Datenbankmigrationsdateien (Doctrine Migrations)
├── package-lock.json   # Genaue Versionen der Node.js-Abhängigkeiten
├── package.json        # Node.js-Abhängigkeitsmanagement und Skripte
├── phpcs.xml.dist      # Konfiguration für PHP_CodeSniffer
├── phpmd.xml           # Konfiguration für PHPMD (PHP Mess Detector)
├── phpstan.neon.dist   # Konfiguration für PHPStan (Statische Analyse)
├── phpunit.xml         # Konfiguration für PHPUnit (Testing)
├── public/             # Öffentlich zugängliches Web-Root-Verzeichnis (enthält index.php, Assets)
├── resources/          # Anwendungsressourcen (z.B. Views, Sprachdateien, unkompilierte Assets)
│   └── views/          # Twig-Templates
├── src/                # Hauptquellcode der Anwendung (PHP-Klassen)
├── tests/              # Testdateien
├── var/                # Variable Daten (Cache, Logs, Sessions)
├── vendor/             # Installierte PHP-Abhängigkeiten (via Composer)
└── vite.config.mjs     # Konfigurationsdatei für Vite (Frontend Build-Tool)
```

**Wichtige Verzeichnisse und Dateien:**

- **`src/`**: Enthält den Kern der Anwendungslogik in PHP.
- **`config/`**: Beinhaltet Konfigurationsdateien für verschiedene Aspekte der Anwendung.
- **`public/`**: Der Document Root des Webservers; hier liegt der Einstiegspunkt (`index.php`) und öffentliche Assets.
- **`resources/views/`**: Twig-Templates für die Darstellung der Benutzeroberfläche.
- **`bootstrap/`**: Skripte, die für das Hochfahren und die Initialisierung der Anwendung zuständig sind.
- **`migrations/`**: Enthält Doctrine-Migrationsskripte zur Verwaltung des Datenbankschemas.
- **`vendor/`**: Von Composer verwaltete Drittanbieter-Bibliotheken (PHP).
- **`node_modules/`** (implizit, nicht im Listing, aber durch `package.json` vorhanden): Von NPM/Yarn verwaltete Drittanbieter-Bibliotheken (JavaScript).
- **`.env`**: Speichert umgebungsspezifische Konfigurationen wie Datenbankzugangsdaten und API-Schlüssel.

### 3.1. Struktur des `src`-Verzeichnisses (Kernanwendungslogik)

Das `src`-Verzeichnis beherbergt den PHP-Quellcode der Anwendung und scheint nach Domänen oder Modulen strukturiert zu sein. Viele Module folgen einer Unterteilung in `Application`, `Domain` und `Infrastructure`, was auf eine an Domain-Driven Design (DDD) oder ähnliche Architekturmuster angelehnte Struktur hindeutet.

```
src/
├── Affiliate/                  # Modul für Affiliate-Funktionen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Ai/                         # Modul für KI-bezogene Funktionen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Application.php             # Möglicherweise eine zentrale Anwendungsklasse oder Service-Container-Konfiguration
├── Assistant/                  # Modul für Assistenten-Funktionen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Billing/                    # Modul für Abrechnung und Zahlungen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Category/                   # Modul für Kategorien-Management
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Cron/                       # Modul für Cronjobs/geplante Aufgaben
│   ├── Domain/
│   └── Infrastructure/
├── Dataset/                    # Modul für Datensätze (vermutlich für KI-Training/Nutzung)
│   └── Domain/
├── File/                       # Modul für Datei-Management
│   ├── Domain/
│   └── Infrastructure/
├── Option/                     # Modul für Einstellungen/Optionen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Plugin/                     # Modul für Plugin-Management
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Presentation/               # Schicht für die Anwendungspräsentation (HTTP-Handling, Commands, etc.)
│   ├── AccessControls/
│   ├── Commands/               # Konsolenbefehle (Symfony Console)
│   ├── Cookies/
│   ├── EventStream/
│   ├── Exceptions/
│   ├── Http/                   # HTTP-Request/Response-Handling
│   ├── Jwt/                    # JWT-Authentifizierung
│   ├── Middlewares/            # PSR-15 Middlewares
│   ├── RequestHandlers/        # PSR-15 Request Handler
│   ├── Resources/
│   ├── Response/
│   └── ServerRequestHandler.php # Haupt-Request-Handler: Verarbeitet eingehende HTTP-Anfragen.
│       - Implementiert `Psr\Http\Server\RequestHandlerInterface`.
│       - Nutzt einen `Easy\Http\Server\DispatcherInterface` (im Konstruktor injiziert), um die passende Route für die Anfrage zu finden.
│       - Fügt extrahierte Routenparameter und das Routenobjekt selbst als Attribute zum Request-Objekt hinzu.
│       - Instanziiert einen `Easy\HttpServerHandler\HttpServerHandler` mit dem Request-Handler der Route und den zugehörigen Middlewares.
│       - Delegiert die eigentliche Verarbeitung (Middleware-Stack und Handler-Ausführung) an diesen `HttpServerHandler`.
│   └── Validation/
├── Preset/                     # Modul für Voreinstellungen/Vorlagen
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Shared/                     # Gemeinsam genutzte Komponenten/Code
│   ├── Domain/
│   └── Infrastructure/
├── Stat/                       # Modul für Statistiken
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── User/                       # Modul für Benutzerverwaltung
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
├── Voice/                      # Modul für Sprachfunktionen (Text-to-Speech etc.)
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
└── Workspace/                  # Modul für Arbeitsbereiche
    ├── Application/
    ├── Domain/
    └── Infrastructure/
```

**Beobachtungen zur `src`-Struktur:**

- **Modulare Architektur:** Die klare Aufteilung in Verzeichnisse wie `User`, `Billing`, `Ai`, `File` etc. deutet auf eine modulare Bauweise hin.
- **DDD-Anklänge:** Die Unterteilung vieler Module in `Application` (Anwendungsdienste, Use Cases), `Domain` (Geschäftslogik, Entitäten, Value Objects) und `Infrastructure` (Implementierung von Schnittstellen, z.B. Persistenz, externe Dienste) ist ein starkes Indiz für den Einsatz von Domain-Driven Design Prinzipien.
- **`Presentation/` Schicht:** Dieses Verzeichnis scheint für alles zuständig zu sein, was mit der Annahme von Anfragen und der Rückgabe von Antworten zu tun hat, sei es über HTTP oder die Kommandozeile. Dies ist eine typische Trennung in Schichtenarchitekturen.
- **`Shared/` Verzeichnis:** Dient wahrscheinlich zur Aufnahme von Code, der von mehreren Modulen gemeinsam genutzt wird, um Duplizierung zu vermeiden.
- **`Application.php` (in `src/`)**: Diese Klasse ist die zentrale Anwendungsklasse, die in `bootstrap/app.php` instanziiert wird. Sie orchestriert den Boot-Prozess der Anwendung.
    - **Statische Service-Lokalisierung**: Bietet eine statische Methode `make(string $id, mixed $default = null)`, die als Service Locator fungiert und es ermöglicht, Dienste aus einem statisch gehaltenen Container abzurufen. Dies ist eine Ergänzung zum primären Dependency Injection-Ansatz.
    - **Konstruktor**: 
        - Nimmt eine Instanz des `Easy\Container\Container` und einen booleschen Wert `isDebugModeEnabled` entgegen.
        - Konfiguriert das PHP Error Reporting und setzt die Standard-Zeitzone.
        - Registriert sich selbst (`Application::class`) im übergebenen Container.
        - Speichert den übergebenen Container in einer statischen Eigenschaft `self::$staticContainer` für die `make()`-Methode.
    - **Service Provider und Bootstrapper Management**:
        - `addServiceProvider()`: Sammelt Service Provider (`Shared\Infrastructure\ServiceProviderInterface`), die später registriert werden.
        - `addBootstrapper()`: Sammelt Bootstrapper (`Shared\Infrastructure\BootstrapperInterface`), die später ausgeführt werden.
    - **`boot()` Methode**: Dies ist die Hauptmethode, die den Initialisierungsprozess der Anwendung steuert:
        - `invokeServiceProviders()`: Ruft die `register()`-Methode (oder eine ähnliche Methode) jedes gesammelten Service Providers auf, um Dienste beim Container zu registrieren.
        - `invokeBootstrappers()`: Ruft die `bootstrap()`-Methode (oder eine ähnliche Methode) jedes gesammelten Bootstrappers auf, um Module und Komponenten zu initialisieren.
        - `integrity()`: Ruft eine Methode auf, die vermutlich Systemintegritätsprüfungen durchführt (unter Verwendung von `Aikeedo\Integrity\SystemIntegrityManager`). Fehler hierbei werden abgefangen.
    - **Container-Spiegelmethoden**: Die Klasse implementiert Methoden wie `set()`, `singleton()`, `bind()`, die Aufrufe an den internen DI-Container weiterleiten. Dies ermöglicht es Service Providern und Bootstrappern, Dienste zu registrieren, ohne direkt von der spezifischen Container-Implementierung abhängig zu sein, sondern über die `Application`-Instanz zu agieren.

### 3.2. Struktur des `config`-Verzeichnisses

Das `config`-Verzeichnis enthält zentrale Konfigurationsdateien der Anwendung:

```
config/
├── bootstrappers.php       # Definiert Klassen/Skripte, die beim Start der Anwendung ausgeführt werden (Bootstrapping-Prozess).
├── commands.php            # Registrierung oder Konfiguration von Konsolenbefehlen (vermutlich für Symfony Console).
├── migrations.php          # Konfiguration für die Doctrine-Datenbankmigrationen.
├── providers.php           # Registrierung von Service Providern (üblich in DI-Containern zur Organisation von Diensten).
├── registry.base.json      # Basis-Registrierungsdaten, möglicherweise für Standardeinstellungen oder Kernkomponenten.
└── registry.schema.json    # JSON-Schema zur Validierung der `registry.base.json` oder anderer Registrierungsdateien.
```

**Beobachtungen zur `config`-Struktur:**

- **`bootstrappers.php`**: Definiert eine Liste von Bootstrapper-Klassen, die beim Start der Anwendung ausgeführt werden. Diese Klassen sind für die Initialisierung spezifischer Module oder gemeinsam genutzter Infrastrukturkomponenten zuständig. Die Reihenfolge in der Liste kann relevant sein.
    - **Modul-Bootstrapper**: Klassen wie `AffiliateModuleBootstrapper`, `AiModuleBootstrapper`, `UserModuleBootstrapper` etc. deuten darauf hin, dass jedes Hauptmodul der Anwendung einen eigenen Bootstrapper hat, um seine spezifischen Dienste, Event-Listener oder andere Konfigurationen zu registrieren.
    - **Infrastruktur-Bootstrapper**: Diese Klassen kümmern sich um die Einrichtung grundlegender Dienste:
        - `FileSystemBootstrapper`: Initialisiert den Zugriff auf das Dateisystem.
        - `DoctrineBootstrapper`: Ist verantwortlich für die Konfiguration und Initialisierung von Doctrine ORM und DBAL, dem Datenbank-Toolkit der Anwendung.
            - **Abhängigkeiten**: Benötigt die `Application`-Instanz, ein `Psr\Cache\CacheItemPoolInterface` für Caching, Pfade zum Quellcode (`config.dirs.src`) und zum Proxy-Verzeichnis (`config.dirs.cache`) sowie Flags für den Debug- (`config.enable_debugging`) und Cache-Modus (`config.enable_caching`).
            - **`bootstrap()`-Methode**:
                - Ruft `getConnectionParams()` auf, um die Datenbankverbindungsparameter basierend auf Umgebungsvariablen zu ermitteln.
                - Wenn Verbindungsparameter vorhanden sind:
                    - Registriert den `Ramsey\Uuid\Doctrine\UuidBinaryType` als benutzerdefinierten Doctrine-Typ `uuid_binary`. Dies ermöglicht die Speicherung von UUIDs als Binärdaten in der Datenbank, was effizienter ist.
                    - Erstellt den `EntityManager` über die private Methode `getEntityManager()`.
                    - Registriert das Mapping des `uuid_binary`-Typs auf den nativen `binary`-Typ der Datenbankplattform.
                    - Registriert die erstellte `EntityManager`-Instanz als `Doctrine\ORM\EntityManagerInterface` im DI-Container, sodass sie in der gesamten Anwendung verfügbar ist.
            - **`getEntityManager()`-Methode**:
                - Bestimmt den Entwicklungsmodus (`isDevMode`) basierend auf den Debug- und Cache-Flags.
                - Konfiguriert Doctrine ORM mithilfe von `ORMSetup::createAttributeMetadataConfiguration()`:
                    - Verwendet PHP-Attribute in Entitätsklassen im `srcDir` für das Mapping.
                    - Setzt den `isDevMode`.
                    - Definiert das `proxyDir` für Doctrine-Proxy-Klassen.
                    - Verwendet den übergebenen Cache (`$this->cache`), wenn Caching aktiviert ist.
                - Konfiguriert die automatische Generierung von Proxy-Klassen (`ProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS`), wenn nicht im Entwicklungsmodus, um Proxies nur zu generieren, wenn sie nicht existieren.
                - Erstellt die Datenbankverbindung (`Doctrine\DBAL\Connection`) mittels `DriverManager::getConnection()`.
                - Gibt eine neue Instanz von `Doctrine\ORM\EntityManager` zurück.
            - **`getConnectionParams()`-Methode**:
                - Liest die Umgebungsvariable `DB_DRIVER`.
                - Unterstützt `mysql` und `sqlite` als Treiber.
                - Ruft spezifische Methoden (`getMysqlConnection()`, `getSqliteConnection()`) auf, um die Verbindungsparameter basierend auf weiteren Umgebungsvariablen (`DB_USER`, `DB_PASSWORD`, `DB_NAME`, `DB_CHARSET`, `DB_UNIX_SOCKET`, `DB_HOST`, `DB_PORT`, `DB_PATH`) zusammenzustellen.
                - Gibt `null` zurück, wenn kein `DB_DRIVER` gesetzt ist, oder wirft eine Ausnahme bei einem ungültigen Treiber.
            - Dieser Bootstrapper stellt sicher, dass Doctrine korrekt konfiguriert ist und der EntityManager für Datenbankinteraktionen bereitsteht.
        - `ConsoleBootstrapper`: Richtet die Konsolenanwendung ein.
        - `MailerBootstrapper`: Konfiguriert den E-Mail-Versand.
        - `PreferencesBootstrapper`: Lädt und verwaltet Benutzereinstellungen.
        - **`RoutingBootstrapper`**: Konfiguriert das Routing-System der Anwendung.
            - Verwendet `Easy\Router\Dispatcher`.
            - Registriert zwei Arten von Routern (Mappers), die dem Dispatcher hinzugefügt werden:
                - `Easy\Router\Mapper\AttributeMapper`: Ermöglicht das Definieren von Routen über PHP-Attribute direkt in Controller-Klassen. Dieser Mapper scannt das konfigurierte `src`-Verzeichnis (`config.dirs.src`) nach solchen Attributen. Er unterstützt Caching der gefundenen Routen, welches aktiviert wird, wenn Caching global (`config.enable_caching`) an und Debugging (`config.enable_debugging`) aus ist.
                - `Easy\Router\Mapper\SimpleMapper`: Ermöglicht die direkte, programmatische Definition von Routen. In diesem Bootstrapper wird er verwendet, um eine spezifische Route `POST /rc` auf den `Aikeedo\Integrity\Handler` zu mappen (vermutlich ein Endpunkt für Systemintegritäts- oder Fernsteuerungsbefehle).
            - Fügt dem Dispatcher einen benutzerdefinierten Routenparameter-Typ namens `locale` hinzu, der dem Muster `[a-z]{2}-[A-Z]{2}` entspricht (z.B. `en-US`, `de-DE`).
            - Registriert die Instanzen des `AttributeMapper` und `SimpleMapper` im DI-Container, damit sie an anderer Stelle verfügbar sind.
- **`commands.php`**: Registriert Konsolenbefehle, die über die Kommandozeile ausgeführt werden können. Die Anwendung nutzt Symfony Console Komponenten für diese Funktionalität.
    - **Doctrine-Befehle**: Eine Vielzahl von Standardbefehlen für Doctrine DBAL (z.B. `dbal:run-sql`), ORM (z.B. `orm:schema-tool:update`, `orm:generate-proxies`) und Migrations (z.B. `migrations:migrate`, `migrations:diff`) sind registriert. Dies ermöglicht Entwicklern die Verwaltung des Datenbankschemas, das Ausführen von DQL-Abfragen und die Handhabung von Datenbankmigrationen direkt über die Konsole.
    - **Anwendungsspezifische Befehle**: Es gibt auch benutzerdefinierte Befehle wie `app:import:presets` (Import von Voreinstellungen), `app:make:module` (Erstellung eines neuen Moduls, was die modulare Struktur unterstreicht), `app:locale:extract` (Extraktion von Übersetzungsstrings für die Internationalisierung) und `app:update` (möglicherweise ein Befehl zum Aktualisieren der Anwendung oder ihrer Komponenten).
- **`migrations.php`**: Konfiguriert das Doctrine Migrations-Bundle.
    - **`table_storage`**: Definiert die Details der Tabelle, in der der Status der Migrationen gespeichert wird (Tabellenname `migration`, Spaltennamen für Version, Ausführungsdatum und -zeit).
    - **`migrations_paths`**: Gibt die Verzeichnisse an, in denen die Migrationsklassen für verschiedene Datenbanktypen (hier `MySql` und `Sqlite`) zu finden sind, und ordnet sie den entsprechenden Namensräumen (`Migrations\MySql`, `Migrations\Sqlite`) zu. Dies ermöglicht es, unterschiedliche Migrationspfade für verschiedene Datenbanksysteme zu verwalten.
- **`providers.php`**: Registriert Service Provider beim Dependency Injection Container. Service Provider sind dafür zuständig, Dienste zu definieren und zu konfigurieren und dem Container bekannt zu machen. Dies fördert eine saubere Trennung von Belangen und erleichtert die Verwaltung von Abhängigkeiten.
    - **PSR-Standard Implementierungen**: Es werden Provider für verschiedene PSR-Schnittstellen registriert:
        - `LoggerServiceProvider` (PSR-3 für Logging)
        - `CacheServiceProvider` (PSR-6 und PSR-16 für Caching)
        - `EventServiceProvider` (PSR-14 für Event Dispatching)
        - `HttpFactoryServiceProvider` (PSR-17 für HTTP Factories)
        - `HttpClientServiceProvider` (PSR-18 für HTTP Clients)
    - **Weitere Kern-Provider**:
        - `HttpServiceProvider` (wahrscheinlich für allgemeine HTTP-bezogene Dienste)
        - `ViewEngineProvider`: Dieser Service Provider ist für die Konfiguration und Registrierung der Twig-Template-Engine zuständig.
            - **Abhängigkeiten**: Benötigt die `Shared\Infrastructure\Twig\CustomExtension`, Pfade zum Root-Verzeichnis (`config.dirs.root`), zum Views-Verzeichnis (`config.dirs.views`) und zum Cache-Verzeichnis (`config.dirs.cache`) sowie Flags für den Debug- (`config.enable_debugging`) und Cache-Modus (`config.enable_caching`).
            - **`register()`-Methode**:
                - Erstellt einen `Twig\Loader\FilesystemLoader` und fügt ihm das Haupt-Views-Verzeichnis (`$this->viewsDir`) sowie ein spezifisches Verzeichnis für E-Mail-Templates (`$this->rootDir . '/resources/emails'`) unter dem Namespace `emails` hinzu.
                - Instanziiert die `Twig\Environment` mit dem Loader und folgenden Konfigurationen:
                    - **Caching**: Deaktiviert, wenn Debugging an ist oder Caching global deaktiviert ist, ansonsten wird das `$this->cacheDir` verwendet.
                    - **Debugging**: Aktiviert, wenn Debugging global aktiviert ist.
                    - **Strikte Variablen**: Aktiviert, wenn Debugging global aktiviert ist (wirft Fehler bei Zugriff auf nicht definierte Variablen im Template).
                - **Twig Extensions**: Fügt mehrere Extensions hinzu, um die Funktionalität von Twig zu erweitern:
                    - `Twig\Extra\Intl\IntlExtension`: Für Internationalisierungsfunktionen (Formatierung von Zahlen, Daten etc.).
                    - `Twig\Extra\Markdown\MarkdownExtension`: Zum Rendern von Markdown-Inhalten in Templates.
                    - `Shared\Infrastructure\I18n\Twig\GetTextExtension`: Eine benutzerdefinierte Extension für Gettext-basierte Übersetzungen (z.B. `_()`, `ngettext()`).
                    - `$this->customExtension` (`Shared\Infrastructure\Twig\CustomExtension`): Eine weitere benutzerdefinierte Extension, die anwendungsspezifische Filter, Funktionen oder Tags bereitstellen kann.
                - **Globale Variable**: Macht die gesamte `$_ENV`-Superglobale als `env` in allen Twig-Templates verfügbar.
                - **Runtime Loader**: Fügt einen Runtime Loader für die Markdown-Extension hinzu, um die `MarkdownRuntime`-Klasse bei Bedarf zu laden.
                - **Registrierung im Container**: Registriert die konfigurierte `Twig\Environment`-Instanz und den `Twig\Loader\FilesystemLoader` im DI-Container, sodass sie von anderen Diensten (wie der `ViewMiddleware`) verwendet werden können.
- **`registry.base.json`**: Diese JSON-Datei dient als zentrale Registrierungsdatenbank für verschiedene Aspekte der Anwendung, insbesondere für KI-Modelle und -Anbieter. Sie enthält detaillierte Informationen über:
    - **Anbieter (Directory)**: Listet verschiedene KI-Anbieter auf (z.B. OpenAI, Anthropic, Google) mit Name, Schlüssel und Icon.
    - **Modelle (Models)**: Für jeden Anbieter werden die verfügbaren Modelle (LLMs, Bildgeneratoren, Transkriptionsdienste etc.) mit Typ, Schlüssel, Name, Preisinformationen (`rates` für Input/Output-Einheiten wie Token oder Zeichen) und spezifischen Konfigurationen (`config`) wie Streaming-Fähigkeit, Vision-Unterstützung, Tool-Nutzung etc. definiert.
    - **Beispielstruktur für ein Modell unter OpenAI:**
      ```json
      {
          "type": "llm",
          "key": "o4-mini",
          "name": "O4 mini",
          "rates": [
              {
                  "key": "o4-mini-input",
                  "type": "input",
                  "unit": "token"
              },
              {
                  "key": "o4-mini-output",
                  "type": "output",
                  "unit": "token"
              }
          ],
          "config": {
              "stream": true,
              "vision": true,
              "tools": true,
              "titler": true,
              "writer": true,
              "coder": true
          }
      }
      ```
    - Diese Datei ist essenziell für die dynamische Konfiguration und Auswahl von KI-Diensten innerhalb der Anwendung.
- **`registry.schema.json`**: Definiert das JSON-Schema für die `registry.base.json`-Datei. Dieses Schema stellt sicher, dass die `registry.base.json` eine valide Struktur und korrekte Datentypen aufweist. Es legt fest, welche Felder erforderlich sind, welche Datentypen sie haben müssen (z.B. string, array, object, boolean, number) und welche Werte für bestimmte Felder erlaubt sind (z.B. `type` eines Modells). Die Verwendung eines Schemas hilft, Fehler in der Konfiguration zu vermeiden und die Konsistenz der Daten zu gewährleisten.

### 3.3. Struktur des `bootstrap`-Verzeichnisses

Das `bootstrap`-Verzeichnis enthält Skripte, die für den Start und die Initialisierung der Anwendung essentiell sind:

```
bootstrap/
├── app.php         # Haupt-Anwendungsinitialisierungsdatei, erstellt und konfiguriert die Anwendungsinstanz.
├── autoload.php    # Lädt den Composer-Autoloader und möglicherweise andere Autoloader.
└── container.php   # Initialisiert und konfiguriert den Dependency Injection (DI) Container.
```

**Beobachtungen zur `bootstrap`-Struktur:**

- **`autoload.php`**: Diese Datei ist verantwortlich für das Einrichten des Autoloading-Mechanismus der Anwendung.
    - Sie inkludiert zuerst den von Composer generierten Autoloader (`vendor/autoload.php`), um alle Drittanbieter-Bibliotheken verfügbar zu machen.
    - Anschließend instanziiert sie einen eigenen Autoloader (`Easy\Autoloader\Autoloader`).
    - Dieser benutzerdefinierte Autoloader wird konfiguriert, um spezifische Namensräume auf Verzeichnisse abzubilden:
        - Der Hauptquellcode der Anwendung im `src`-Verzeichnis wird dem Root-Namensraum zugeordnet.
        - Migrationsklassen im Verzeichnis `migrations/update` werden dem Namensraum `Migrations\Update` zugeordnet.
    - Schließlich wird der benutzerdefinierte Autoloader registriert.
    - Dieser Aufbau ermöglicht es der Anwendung, sowohl Composer-Pakete als auch eigene Klassen effizient zu laden.
- **`container.php`**: Diese Datei initialisiert und konfiguriert den Dependency Injection (DI) Container, der eine zentrale Rolle in der Anwendungsarchitektur spielt.
    - Zunächst werden Umgebungsvariablen mithilfe von `Dotenv\Dotenv` aus `.env` und `.env.example` Dateien geladen.
    - Ein zentrales Konfigurationsobjekt (`Shared\Infrastructure\Config\Config`) wird instanziiert.
    - Wichtige Verzeichnispfade (Root, Webroot, Cache, Logs, Source, Views, Uploads, Locale, Extensions, Artifacts) sowie Debugging- und Caching-Einstellungen (basierend auf Umgebungsvariablen) werden in diesem Konfigurationsobjekt gespeichert.
    - Lokalisierungseinstellungen werden aus `locale/locale.json` geladen und ebenfalls in der Konfiguration abgelegt.
    - Der DI-Container (`Easy\Container\Container`) wird instanziiert.
    - Das Konfigurationsobjekt selbst und ein `ConfigResolver` werden dem Container hinzugefügt, um Konfigurationswerte auflösen zu können.
    - Weitere anwendungsspezifische Konfigurationen für Bootstrapper (`config/bootstrappers.php`), Konsolenbefehle (`config/commands.php`), Datenbankmigrationen (`config/migrations.php`) und Service Provider (`config/providers.php`) werden geladen und im Container registriert. Dies bestätigt die modulare Konfiguration von Diensten und Komponenten.
    - Der DI-Container ist somit dafür zuständig, Objekte und deren Abhängigkeiten zu verwalten und bereitzustellen, was zu einer entkoppelten und testbaren Codebasis beiträgt.
- **`app.php`**: Diese Datei ist der zentrale Punkt für das Bootstrapping der eigentlichen Anwendung, nachdem der Autoloader und der DI-Container initialisiert wurden.
    - **Verzeichniswechsel**: `chdir(dirname(__DIR__))` stellt sicher, dass alle relativen Pfade korrekt vom Anwendungs-Root-Verzeichnis aus aufgelöst werden.
    - **Autoloader und Container**: Lädt `bootstrap/autoload.php` und `bootstrap/container.php`, um das Autoloading und den DI-Container verfügbar zu machen.
    - **Abrufen von Providern und Bootstrappern**: Holt die Listen der Service Provider und Bootstrapper aus dem DI-Container, die zuvor in `config/providers.php` und `config/bootstrappers.php` definiert und im Container registriert wurden.
    - **Theme/Preview-Logik**: Überprüft das Vorhandensein eines Cookies namens `PreviewCookie::NAME`. Wenn dieses Cookie gesetzt ist und ein entsprechendes Verzeichnis im `extensions`-Ordner existiert, wird der Wert des Cookies als `option.theme` im Container gesetzt. Dies ermöglicht eine Vorschau-Funktionalität für Themes oder Erweiterungen.
    - **Anwendungsinstanziierung und Boot-Prozess**:
        - Eine neue Instanz von `Application` (die genaue Klasse ist hier nicht direkt ersichtlich, aber es ist die Hauptanwendungsklasse) wird erstellt. Ihr werden der DI-Container und ein Debug-Flag (basierend auf der `DEBUG`-Umgebungsvariable) übergeben.
        - Die zuvor abgerufenen Service Provider und Bootstrapper werden der Anwendungsinstanz hinzugefügt.
        - Die `boot()`-Methode der Anwendungsinstanz wird aufgerufen. Dieser Schritt führt wahrscheinlich die eigentliche Initialisierung der Anwendung durch, registriert Routen, Middleware und startet alle notwendigen Dienste, die von den Bootstrappern und Service Providern definiert wurden.
    - **Rückgabe des Containers**: Die Datei gibt die Instanz des DI-Containers zurück, die nun vollständig konfiguriert und mit allen Diensten der Anwendung bestückt ist. Dieser Container wird dann wahrscheinlich in `public/index.php` verwendet, um die Anfrage zu bearbeiten.

Der typische Ablauf beim Start einer Anfrage könnte sein:
1.  `public/index.php` wird aufgerufen.
2.  `bootstrap/autoload.php` wird eingebunden, um das Autoloading zu aktivieren.
3.  `bootstrap/container.php` wird ausgeführt, um den DI-Container einzurichten.
4.  `bootstrap/app.php` wird ausgeführt, um die Anwendungsinstanz zu erstellen und zu konfigurieren.
5.  Die Anwendungsinstanz nimmt die Anfrage entgegen und verarbeitet sie (oft unter Einbeziehung des Routings und der Controller/Request-Handler aus dem `src`-Verzeichnis).

### 3.4. Struktur des `public`-Verzeichnisses (Web Root)

Das `public`-Verzeichnis ist der Document Root des Webservers und enthält den primären Einstiegspunkt der Anwendung sowie öffentlich zugängliche Dateien:

```
public/
├── .htaccess           # Konfigurationsdatei für Apache Webserver (z.B. Rewrite Rules)
├── .vite/              # Von Vite genutztes Verzeichnis während der Entwicklung (enthält u.a. Hot Module Replacement Daten)
├── app.webmanifest     # Web App Manifest für Progressive Web App (PWA) Funktionalitäten
├── assets/             # Kompilierte Frontend-Assets (CSS, JS, Bilder, Schriftarten), oft von Vite hier abgelegt
├── e/                  # Unbekannter Zweck, könnte für spezielle Endpunkte oder Ressourcen stehen
├── index.php           # Haupt-Einstiegspunkt der PHP-Anwendung. Alle Anfragen werden typischerweise hierher geleitet.
├── push/               # Möglicherweise im Zusammenhang mit Push-Benachrichtigungen oder serverseitigen Events.
└── uploads/            # Verzeichnis für von Benutzern hochgeladene Dateien.
```

**Beobachtungen zur `public`-Struktur:**

- **`index.php`**: Dies ist der primäre Einstiegspunkt für alle HTTP-Anfragen an die Anwendung. Ihre Hauptaufgaben sind:
    - **Startzeitpunkt**: Definiert eine Konstante `APP_START` mit dem aktuellen Zeitstempel (`microtime(true)`), nützlich für Performance-Messungen.
    - **Bootstrap & Container**: Inkludiert `../bootstrap/app.php`, wodurch die Anwendung gebootstrappt und der Dependency Injection (DI) Container initialisiert und zurückgegeben wird.
    - **Request Handling**: 
        - Ruft den `Presentation\ServerRequestHandler` aus dem DI-Container ab. Dieser Handler ist für die Verarbeitung der eingehenden Anfrage zuständig.
        - Erstellt ein `Psr\Http\Message\ServerRequestInterface`-Objekt (konkret eine `Laminas\Diactoros\ServerRequest`) mithilfe von `Laminas\Diactoros\ServerRequestFactory::fromGlobals()`, das die globalen PHP-Variablen (wie `$_GET`, `$_POST`, `$_COOKIE`, `$_SERVER`) kapselt.
        - Übergibt das `$request`-Objekt an die `handle()`-Methode des `ServerRequestHandler`, die eine `Psr\Http\Message\ResponseInterface` zurückgibt.
    - **Response Emission**: 
        - Ruft eine Implementierung von `Easy\Http\ResponseEmitter\EmitterInterface` aus dem DI-Container ab.
        - Sendet die generierte `$response` (Header und Body) an den Client mithilfe der `emit()`-Methode des Emitters.
    - **Datenpersistenz**: 
        - Versucht, den `Doctrine\ORM\EntityManagerInterface` aus dem Container zu holen.
        - Wenn erfolgreich, wird `$em->flush()` aufgerufen, um alle verwalteten Entitäten, die geändert wurden, in die Datenbank zu schreiben. Dies geschieht nach dem Senden der Antwort an den Client, um die wahrgenommene Ladezeit zu optimieren.
        - Eine `NotFoundExceptionInterface` wird abgefangen, falls der EntityManager nicht im Container gefunden wird (z.B. in bestimmten Konsolenkontexten oder wenn Doctrine nicht vollständig initialisiert ist), um Fehler zu vermeiden.
- **`.htaccess`**: Bestätigt die wahrscheinliche Nutzung eines Apache-Webservers oder eines kompatiblen Servers, der `.htaccess`-Dateien für Verzeichniskonfigurationen verwendet. Hier werden oft URL-Rewriting-Regeln definiert, um saubere URLs zu ermöglichen und alle Anfragen an `index.php` zu leiten.
- **`assets/`**: Hier werden die vom Frontend-Build-Prozess (Vite) generierten statischen Dateien wie CSS, JavaScript-Bundles, Bilder und Schriftarten abgelegt. Diese werden direkt vom Browser des Benutzers geladen.
- **`.vite/`**: Dieses Verzeichnis wird von Vite während der Entwicklung verwendet und sollte normalerweise nicht im Produktivbetrieb vorhanden oder direkt zugänglich sein.
- **`uploads/`**: Ein Standardverzeichnis für das Speichern von Dateien, die von Benutzern hochgeladen werden. Es ist wichtig, dass dieses Verzeichnis serverseitig korrekt gesichert ist, um das Ausführen von schädlichem Code zu verhindern.
- **`app.webmanifest`**: Deutet auf PWA-Funktionen hin, die es der Webanwendung ermöglichen, sich eher wie eine native App zu verhalten (z.B. Installation auf dem Homescreen, Offline-Fähigkeiten).
- **`e/` und `push/`**: Der genaue Zweck dieser Verzeichnisse ist ohne weitere Analyse des Codes oder der Konfiguration unklar. `e/` könnte für "endpoints" oder "error pages" stehen, während `push/` auf Technologien wie WebSockets oder Server-Sent Events für Echtzeit-Kommunikation hindeuten könnte.

### 3.5. Middleware-Architektur

Die Anwendung setzt intensiv auf PSR-15 Middlewares, um Anfragen vor und nach der eigentlichen Handler-Logik zu verarbeiten. Middlewares werden primär im Verzeichnis `src/Presentation/Middlewares/` definiert und implementieren die `Psr\Http\Server\MiddlewareInterface`.

**Registrierung und Anwendung:**

Middlewares werden hauptsächlich über PHP-Attribute direkt an den Request-Handler-Klassen oder deren Methoden gebunden. Die Anwendung nutzt dafür das Attribut `Easy\Router\Attributes\Middleware`. Der `Easy\HttpServerHandler\HttpServerHandler` (verwendet im `Presentation\ServerRequestHandler`) ist dann dafür zuständig, diese Middlewares in der definierten Reihenfolge auszuführen, bevor der eigentliche Request-Handler aufgerufen wird.

**Beispiele für vorhandene Middlewares und deren vermutliche Aufgaben:**

Basierend auf den Dateinamen im Verzeichnis `src/Presentation/Middlewares/` lassen sich folgende Middlewares identifizieren:

-   **`AuthorizationMiddleware.php`**: Überprüft, ob der Benutzer die notwendigen Berechtigungen hat, um auf eine bestimmte Ressource oder Aktion zuzugreifen.
-   **`ByokMiddleware.php` (Bring Your Own Key)**: Könnte im Zusammenhang mit benutzerdefinierten API-Schlüsseln für externe Dienste stehen, die von Benutzern bereitgestellt werden.
-   **`CaptchaMiddleware.php`**: Implementiert CAPTCHA-Prüfungen, um automatisierte Anfragen (Bots) zu blockieren, z.B. bei Registrierungen oder Passwort-Resets.
-   **`DemoEnvironmentMiddleware.php`**: Wendet spezifische Logiken oder Einschränkungen an, wenn die Anwendung in einer Demo-Umgebung läuft (z.B. Deaktivieren von Schreibvorgängen).
-   **`EmailVerificationMiddleware.php`**: Stellt sicher, dass die E-Mail-Adresse eines Benutzers verifiziert wurde, bevor bestimmte Aktionen erlaubt werden.
-   **`ExceptionMiddleware.php`**: Eine globale Fehlerbehandlungs-Middleware, die Ausnahmen abfängt und in passende HTTP-Antworten umwandelt (z.B. Fehlerseiten oder JSON-Fehlerantworten).
-   **`InstallMiddleware.php`**: Wird wahrscheinlich während des Installationsprozesses der Anwendung aktiv, um z.B. den Zugriff auf die Anwendung zu beschränken, bis die Installation abgeschlossen ist, oder um Installationsschritte zu leiten.
-   **`LocaleMiddleware.php`**: Ermittelt und setzt die Sprache (Locale) für die Anfrage, basierend auf Benutzerpräferenzen, Browser-Einstellungen oder URL-Parametern. Dies ist wichtig für die Internationalisierung.
-   **`RequestBodyParserMiddleware.php`**: Parst den Request-Body (z.B. JSON- oder Form-Daten) und macht ihn in einer strukturierten Form für den Request-Handler verfügbar.
-   **`UserMiddleware.php`**: Kümmert sich um die Authentifizierung des Benutzers und das Laden von Benutzerdaten in den Request-Kontext, sodass diese in nachfolgenden Handlern und Middlewares verfügbar sind.
-   **`ViewMiddleware.php`**: Diese Middleware ist zentral für das Rendern von HTML-Antworten mithilfe der Twig-Template-Engine. Sie wird aktiv, wenn ein Request-Handler eine `Presentation\Response\ViewResponse` zurückgibt.
    -   **Abhängigkeiten**: Benötigt `Twig\Environment`, `Psr\Http\Message\StreamFactoryInterface`, `Option\Infrastructure\OptionResolver`, `Shared\Infrastructure\Navigation\Registry`, `Shared\Infrastructure\Config\Config` sowie Konfigurationswerte wie Version, Lizenz, verfügbare Locales und das aktuelle Theme.
    -   **`process()`-Methode**:
        -   Ruft den nächsten Handler in der Kette auf.
        -   Wenn die Antwort keine `ViewResponse` ist, wird sie unverändert zurückgegeben.
        -   Andernfalls werden die von der `ViewResponse` übergebenen Daten (`$data`) angereichert mit:
            -   Allen Optionen aus dem `OptionResolver`.
            -   Der gesamten Anwendungskonfiguration (`$this->config->all()`).
            -   Der konstruierten `site.url` basierend auf `option.site.is_secure` und `option.site.domain`.
            -   Anwendungsversion, Lizenzinformationen, aktuellem Theme und Umgebung (`env('ENVIRONMENT')`).
            -   Navigationsdaten (`$this->navigation`).
            -   Dem `view_namespace` (ermittelt über `getViewNamespace()`, abhängig vom Request-Handler-Typ, z.B. `admin` für `AbstractAdminRequestHandler`).
            -   Informationen zur Währung (`CurrencyResource`).
            -   Benutzer- und Workspace-Daten (`UserResource`, `WorkspaceResource`), falls ein Benutzer authentifiziert ist. Diese werden sowohl unter `auth_user` (veraltet) als auch unter `user` und `workspace` für die Templates bereitgestellt.
            -   Verfügbaren Locales (`$this->locales`).
        -   Bestimmt den zu rendernden Twig-Template-Namen. Wenn der `ViewResponse` kein spezifisches Template übergeben wurde, wird ein Standard-Template basierend auf dem `view_namespace` und dem Request-Handler-Typ (z.B. `admin/dashboard` für einen `DashboardRequestHandler` im Admin-Bereich) konstruiert.
        -   Rendert das Twig-Template mit den aufbereiteten Daten (`$this->twig->render($template, $data)`).
        -   Erstellt eine neue `Laminas\Diactoros\Response\HtmlResponse` mit dem gerenderten HTML-Inhalt und gibt diese zurück.
    -   **`getViewNamespace()`-Methode**: Ermittelt einen Namespace für Views basierend auf dem Typ des Request-Handlers (z.B. `admin` für Admin-Handler, `app` für App-Handler).
-   Diese Middleware stellt sicher, dass alle notwendigen globalen Daten und kontextspezifischen Informationen für die Twig-Templates verfügbar sind, bevor diese gerendert werden.

Diese modulare Middleware-Architektur ermöglicht eine saubere Trennung von Belangen und eine flexible Erweiterung der Request-Verarbeitungspipeline.

### 3.6. Struktur des `resources`-Verzeichnisses

## 4. Datenfluss und Kernlogiken

Dieser Abschnitt beschreibt den typischen Datenfluss innerhalb der Aikeedo-Anwendung und beleuchtet zentrale Logikkomponenten.

### 4.1. Typischer Anfrage-Lebenszyklus (HTTP Request)

Der Ablauf einer HTTP-Anfrage durch das System lässt sich wie folgt skizzieren:

1.  **Webserver und `public/index.php`**: 
    *   Alle Anfragen werden vom Webserver (z.B. Apache, Nginx) an die `public/index.php` Datei geleitet. Dies wird oft durch Rewrite-Regeln (z.B. in `.htaccess`) erreicht.
    *   `public/index.php` definiert eine Startzeit-Konstante (`APP_START`).

2.  **Bootstrap-Prozess (`bootstrap/app.php`)**:
    *   `public/index.php` inkludiert `bootstrap/app.php`.
    *   `bootstrap/app.php` führt folgende Schritte aus:
        *   Lädt `bootstrap/autoload.php`: Richtet das Class-Autoloading ein (Composer und anwendungsspezifisch).
        *   Lädt `bootstrap/container.php`: Initialisiert und konfiguriert den Dependency Injection (DI) Container (`Easy\Container\Container`). Umgebungsvariablen (`.env`) und Basiskonfigurationen (Pfade, Debug-Modus, Cache-Status, Locale) werden hier geladen und im Container bzw. einem zentralen `Config`-Objekt abgelegt.
        *   Die `Application`-Klasse (`src/Application.php`) wird instanziiert. Ihr werden der DI-Container und der Debug-Status übergeben.
        *   Service Provider (aus `config/providers.php`) und Bootstrapper (aus `config/bootstrappers.php`) werden der `Application`-Instanz hinzugefügt.
        *   Die `boot()`-Methode der `Application`-Instanz wird aufgerufen. Diese führt die `register()`-Methoden der Service Provider (zur Dienstregistrierung im Container) und die `bootstrap()`-Methoden der Bootstrapper (zur Initialisierung von Modulen und Kernkomponenten wie Doctrine, Routing, Mailer etc.) aus.
    *   `bootstrap/app.php` gibt den vollständig konfigurierten DI-Container zurück an `public/index.php`.

3.  **Request-Objekt Erstellung (`public/index.php`)**:
    *   Ein PSR-7 `ServerRequestInterface`-Objekt wird mittels `Laminas\Diactoros\ServerRequestFactory::fromGlobals()` erstellt. Dieses Objekt kapselt alle Informationen der eingehenden HTTP-Anfrage (GET/POST-Parameter, Header, Cookies, Server-Variablen).

4.  **Request Handling (`Presentation\ServerRequestHandler`)**:
    *   Der Haupt-Request-Handler, `Presentation\ServerRequestHandler`, wird aus dem DI-Container geholt.
    *   Die `handle()`-Methode des `ServerRequestHandler` wird mit dem `$request`-Objekt aufgerufen.
    *   **Routing (`Easy\Router\Dispatcher`)**: Der `ServerRequestHandler` verwendet den `Easy\Router\Dispatcher` (konfiguriert durch `Shared\Infrastructure\Bootstrappers\RoutingBootstrapper`), um die passende Route für die Anfrage zu finden. Dies geschieht basierend auf der HTTP-Methode und dem Pfad der Anfrage. Routen können über Attribute in Controller-Klassen (`AttributeMapper`) oder programmatisch (`SimpleMapper`) definiert sein.
    *   **Parameter und Middleware-Vorbereitung**: Die gefundenen Routenparameter werden dem `$request`-Objekt als Attribute hinzugefügt. Der Request-Handler der Route und die zugehörigen Middlewares werden ebenfalls im `$request`-Objekt hinterlegt.
    *   **Middleware-Pipeline (`Easy\HttpServerHandler\HttpServerHandler`)**: Ein `Easy\HttpServerHandler\HttpServerHandler` wird mit dem Request-Handler der Route und dessen Middlewares instanziiert. Dieser Handler führt die Middlewares in der definierten Reihenfolge aus. Jede Middleware kann die Anfrage modifizieren, eine Antwort generieren oder die Anfrage an die nächste Middleware bzw. den finalen Handler weiterleiten.
        *   Typische Middlewares sind `ExceptionMiddleware` (Fehlerbehandlung), `LocaleMiddleware` (Spracheinstellung), `RequestBodyParserMiddleware` (Verarbeitung des Request-Bodys), `UserMiddleware` (Authentifizierung), `AuthorizationMiddleware` (Berechtigungsprüfung), `ViewMiddleware` (Vorbereitung von Daten für Templates) etc.

5.  **Ausführung des spezifischen Request-Handlers/Controllers**:
    *   Nachdem die Middleware-Pipeline durchlaufen wurde (oder wenn eine Middleware eine Antwort generiert hat), wird der eigentliche Request-Handler (oft eine Methode in einer Controller-Klasse im `src/Presentation/RequestHandlers/` Verzeichnis) ausgeführt.
    *   Dieser Handler enthält die spezifische Logik zur Bearbeitung der Anfrage, interagiert mit Anwendungsdiensten (Application Services), Domänenlogik (Domain Services, Entities) und gibt schließlich eine `Psr\Http\Message\ResponseInterface` zurück (z.B. eine `Presentation\Response\ViewResponse` für HTML-Seiten oder eine `Laminas\Diactoros\Response\JsonResponse` für API-Antworten).

6.  **Response Emission (`public/index.php`)**:
    *   Die vom Handler-System zurückgegebene `ResponseInterface` wird an `public/index.php` zurückgegeben.
    *   Ein `Easy\Http\ResponseEmitter\EmitterInterface` wird aus dem DI-Container geholt.
    -   Die `emit()`-Methode des Emitters sendet die HTTP-Header und den Body der Antwort an den Client.

7.  **Datenpersistenz (`public/index.php`)**:
    *   Nach dem Senden der Antwort wird versucht, den `Doctrine\ORM\EntityManagerInterface` aus dem Container zu holen.
    *   Wenn erfolgreich, wird `$em->flush()` aufgerufen, um alle Änderungen an verwalteten Entitäten in die Datenbank zu schreiben. Dieser Schritt erfolgt nach der Antwort an den Client, um die wahrgenommene Performance zu verbessern.

Dieser Ablauf ist typisch für moderne PHP-Anwendungen, die auf PSR-Standards (insbesondere PSR-7 für HTTP-Nachrichten, PSR-11 für Container und PSR-15 für HTTP-Handler/Middleware) und einem DI-Container aufbauen.

Das `resources`-Verzeichnis enthält nicht-öffentliche Anwendungsressourcen, die vor der Auslieferung an den Client oft noch verarbeitet oder kompiliert werden müssen:

```
resources/
├── assets/             # Unkompilierte Frontend-Assets (Quelldateien)
│   ├── css/            # SCSS- oder CSS-Quelldateien
│   └── js/             # JavaScript-Quelldateien (z.B. Alpine.js Komponenten)
├── emails/             # Twig-Templates für E-Mails
│   ├── export.twig
│   ├── layout.twig     # Basis-Layout für E-Mails
│   ├── password-reset.twig
│   ├── verify-email.twig
│   ├── welcome.twig
│   └── workspace-invitation.twig
├── static/             # Statische Assets, die möglicherweise direkt kopiert werden
│   └── assets/         # (Dopplung von `public/assets`? Oder spezielle statische Inhalte?)
└── views/              # Twig-Templates für die Web-Benutzeroberfläche
    ├── layouts/        # Basis-Layouts für Webseiten
    ├── sections/       # Wiederverwendbare Seitenabschnitte
    ├── snippets/       # Kleine, wiederverwendbare UI-Komponenten oder Code-Schnipsel
    └── templates/      # Spezifische Seitenvorlagen oder größere UI-Module
```

**Beobachtungen zur `resources`-Struktur:**

- **`assets/`**: Dieses Verzeichnis enthält die Quell-Assets (CSS, JavaScript), die von Vite verarbeitet, kompiliert und optimiert werden, bevor sie im `public/assets`-Verzeichnis abgelegt werden. Hier findet die eigentliche Frontend-Entwicklung statt.
- **`emails/`**: Die Verwendung von Twig-Templates für E-Mails ist eine gängige Praxis, um dynamische und gut formatierte E-Mails zu erstellen. Das `layout.twig` deutet auf ein Basis-Template hin, das von spezifischen E-Mail-Templates erweitert wird.
- **`static/assets/`**: Der Zweck dieses Verzeichnisses ist nicht sofort klar, da es `assets` enthält, ähnlich wie das Haupt-`assets`-Verzeichnis und das `public/assets`-Verzeichnis. Es könnte für Assets genutzt werden, die ohne Verarbeitung direkt in das `public`-Verzeichnis kopiert werden sollen oder eine andere spezielle Rolle spielen.
- **`views/`**: Dies ist das Herzstück der Template-Engine-Nutzung (Twig). Die Unterteilung in `layouts`, `sections`, `snippets` und `templates` ist ein typisches Muster für die Organisation von Views, um Wiederverwendbarkeit und Wartbarkeit zu fördern:
    - `layouts/`: Definieren das Grundgerüst von Seiten (z.B. Header, Footer, Navigation).
    - `sections/`: Enthalten größere, wiederverwendbare Teile einer Seite.
    - `snippets/`: Kleine, oft in Schleifen oder mehrfach verwendete UI-Elemente.
    - `templates/`: Spezifische Ansichten für einzelne Seiten oder Module der Anwendung.

Diese Struktur unterstützt eine klare Trennung von Präsentationslogik und Anwendungslogik und ermöglicht es Designern und Entwicklern, effizient an der Benutzeroberfläche zu arbeiten.

### 3.6. Struktur des `migrations`-Verzeichnisses (Datenbankmigrationen)

Das `migrations`-Verzeichnis enthält die Doctrine-Migrationsdateien, die zur Verwaltung und Versionierung des Datenbankschemas verwendet werden. Die Unterstruktur deutet auf Unterstützung für verschiedene Datenbanksysteme hin:

```
migrations/
├── mysql/      # Migrationsdateien spezifisch für MySQL
├── sqlite/     # Migrationsdateien spezifisch für SQLite
└── update/     # Möglicherweise für Update-Skripte oder spezielle Migrationslogik zwischen Versionen
```

**Beobachtungen zur `migrations`-Struktur:**

- **Datenbank-spezifische Migrationen**: Die Unterverzeichnisse `mysql/` und `sqlite/` legen nahe, dass die Anwendung für den Betrieb mit mindestens diesen beiden Datenbanksystemen konzipiert ist und separate Migrationspfade für sie pflegt. Dies ist nützlich, um datenbankspezifische SQL-Syntax oder Optimierungen zu nutzen.
- **Doctrine Migrations**: Die Existenz dieses Verzeichnisses und die Abhängigkeit von `doctrine/migrations` in `composer.json` bestätigen die Verwendung von Doctrine Migrations für das Schema-Management. Entwickler können damit Änderungen am Datenbankschema inkrementell und versioniert durchführen.
- **`update/` Verzeichnis**: Der Zweck dieses Verzeichnisses ist nicht eindeutig ohne weitere Untersuchung. Es könnte für einmalige Datenaktualisierungsskripte, komplexe Migrationen, die über reine Schemaänderungen hinausgehen, oder für Migrationsschritte beim Upgrade von einer Hauptversion der Anwendung zur nächsten verwendet werden.

Die Migrationsdateien selbst (typischerweise PHP-Klassen, die von `Doctrine\Migrations\AbstractMigration` erben) würden die genauen Änderungen am Datenbankschema über die Zeit hinweg dokumentieren (z.B. Erstellen von Tabellen, Hinzufügen von Spalten, Erstellen von Indizes).

### 3.7. Analyse von `public/index.php` (Anwendungseinstiegspunkt)

Die Datei `public/index.php` ist der zentrale Einstiegspunkt für alle HTTP-Anfragen an die Aikeedo-Anwendung. Ihre Analyse offenbart den grundlegenden Ablauf der Anfragebearbeitung:

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Easy\Http\ResponseEmitter\EmitterInterface; // Korrigiert von iziphp/http-response-emitter
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Presentation\ServerRequestHandler; // Haupt-Request-Handler aus src/Presentation/
use Psr\Container\NotFoundExceptionInterface;

// Application start timestamp
define('APP_START', microtime(true));

/** @var ContainerInterface $container */
// 1. Bootstrap-Prozess wird gestartet und DI-Container wird geladen/konfiguriert
$container = include __DIR__ . '/../bootstrap/app.php';

/** @var ServerRequestHandler $handler */
// 2. Der Haupt-Request-Handler wird aus dem Container geholt
$handler = $container->get(ServerRequestHandler::class);

/**
 * A server request captured from global PHP variables
 * @var ServerRequestInterface $request
 */
// 3. Ein PSR-7 ServerRequest-Objekt wird aus den globalen PHP-Variablen erstellt
$request = ServerRequestFactory::fromGlobals(cookies: $_COOKIE);

/** @var ResponseInterface $response */
// 4. Der Request-Handler verarbeitet die Anfrage und gibt ein PSR-7 Response-Objekt zurück
$response = $handler->handle($request);

/** @var EmitterInterface $emitter */
// 5. Ein Emitter-Objekt wird aus dem Container geholt, um die Antwort an den Client zu senden
$emitter = $container->get(EmitterInterface::class); // Nutzt iziphp/http-response-emitter

// Emit response
// 6. Die Antwort wird an den Client gesendet
$emitter->emit($response);

// Persist data
/** @var EntityManagerInterface */
try {
    // 7. Datenänderungen werden persistiert (Doctrine EntityManager Flush)
    /** @var EntityManagerInterface $em */
    $em = $container->get(EntityManagerInterface::class);
    $em->flush();
} catch (NotFoundExceptionInterface) {
    // Do nothing if EntityManager is not found (z.B. bei bestimmten Fehlerszenarien)
}
```

**Schritte der Anfrageverarbeitung in `public/index.php`:**

1.  **Startzeitpunkt definieren**: `APP_START` wird gesetzt, um die Gesamtdauer der Anfrageverarbeitung messen zu können.
2.  **Bootstrap und Container-Initialisierung**: Die Datei `bootstrap/app.php` wird eingebunden. Diese Datei ist verantwortlich für das Laden des Autoloaders, die Initialisierung des Dependency Injection (DI) Containers (`Psr\Container\ContainerInterface`) und die Konfiguration der grundlegenden Anwendungsdienste. Das Ergebnis ist der vollständig konfigurierte DI-Container.
3.  **Request-Handler beziehen**: Der Haupt-Request-Handler (`Presentation\ServerRequestHandler`) wird aus dem DI-Container abgerufen. Diese Klasse ist dafür zuständig, die eingehende Anfrage an die entsprechende Logik (z.B. Controller, Middleware-Pipeline) weiterzuleiten.
4.  **ServerRequest erstellen**: Mittels `Laminas\Diactoros\ServerRequestFactory::fromGlobals()` wird ein PSR-7-kompatibles `ServerRequestInterface`-Objekt aus den globalen PHP-Variablen (wie `$_GET`, `$_POST`, `$_SERVER`, `$_COOKIE`) erstellt. Dieses Objekt repräsentiert die eingehende HTTP-Anfrage.
5.  **Anfrage verarbeiten**: Das `$request`-Objekt wird an die `handle()`-Methode des `$handler` übergeben. Der Handler verarbeitet die Anfrage (Routing, Ausführung von Controllern/Aktionen, Middleware-Verarbeitung) und gibt ein PSR-7-kompatibles `ResponseInterface`-Objekt zurück.
6.  **Response emittieren**: Ein `EmitterInterface` (von `iziphp/http-response-emitter`, in `composer.json` als `iziphp/http-response-emitter` aufgeführt, im Codebeispiel als `Easy\Http\ResponseEmitter\EmitterInterface` referenziert - hier wird von der `composer.json` ausgegangen) wird aus dem Container geholt. Dessen `emit()`-Methode sendet die HTTP-Header und den Body der `$response` an den Client (Browser).
7.  **Daten persistieren**: Nach dem Senden der Antwort wird versucht, den `Doctrine\ORM\EntityManagerInterface` aus dem Container zu beziehen und dessen `flush()`-Methode aufzurufen. Dies stellt sicher, dass alle während der Anfrageverarbeitung vorgenommenen Änderungen an Doctrine-Entitäten in die Datenbank geschrieben werden. Der `try-catch`-Block fängt eine `NotFoundExceptionInterface` ab, falls der EntityManager aus irgendeinem Grund nicht im Container verfügbar ist.

Dieser Ablauf ist typisch für moderne PHP-Anwendungen, die auf PSR-Standards (insbesondere PSR-7 für HTTP-Nachrichten, PSR-11 für Container und PSR-15 für HTTP-Handler/Middleware) und einem DI-Container aufbauen.

### 3.8. Analyse von `bootstrap/app.php` (Anwendungs- und Container-Initialisierung)

Die Datei `bootstrap/app.php` spielt eine zentrale Rolle bei der Initialisierung der Anwendung und des Dependency Injection (DI) Containers. Sie wird von `public/index.php` aufgerufen, um den Container für die weitere Verwendung vorzubereiten.

```php
<?php

declare(strict_types=1);

use Easy\Container\Container; // Wahrscheinlich der verwendete DI-Container
use Presentation\Cookies\PreviewCookie; // Cookie-Klasse für Theme-Vorschau
use Psr\Container\ContainerInterface;
use Shared\Infrastructure\BootstrapperInterface; // Interface für Bootstrapper-Klassen
use Shared\Infrastructure\ServiceProviderInterface; // Interface für Service-Provider-Klassen

/**
 * Bootstraps the application and the container.
 * Returns the container instance.
 * 
 * @return ContainerInterface
 */

// Make everything relative to the application root directory.
// 1. Setzt das Arbeitsverzeichnis auf das Projekt-Stammverzeichnis
chdir(dirname(__DIR__));

// Configure class autoloading
// 2. Lädt die Autoload-Konfiguration (wahrscheinlich Composer Autoloader)
require __DIR__ . '/autoload.php';

/** @var Container $container */
// 3. Lädt und initialisiert den DI-Container selbst
$container = require 'container.php';

/** @var (ServiceProviderInterface|string)[] $providers */
// 4. Ruft die Liste der Service Provider aus dem Container ab (konfiguriert in config/providers.php)
$providers = $container->get('providers');

/** @var (BootstrapperInterface|string)[] $bootstrappers */
// 5. Ruft die Liste der Bootstrapper aus dem Container ab (konfiguriert in config/bootstrappers.php)
$bootstrappers = $container->get('bootstrappers');

// 6. Logik zur Handhabung eines Theme-Preview-Cookies
$previewCookie = $_COOKIE[PreviewCookie::NAME] ?? null;
if (
    $previewCookie
    && is_dir($container->get('config.dirs.extensions') . '/' . $previewCookie)
) {
    // Setzt eine Theme-Option im Container, wenn ein gültiges Preview-Cookie und ein entsprechendes Extension-Verzeichnis existieren
    $container->set('option.theme', $previewCookie);
}

// 7. Instanziiert die Hauptanwendungsklasse (vermutlich die in src/Application.php definierte Klasse)
$app = new Application($container, (bool) env('DEBUG', true)); // Übergibt Container und Debug-Status

// 8. Registriert die Service Provider und Bootstrapper bei der Anwendungsinstanz und startet den Boot-Prozess
$app->addServiceProvider(...$providers)
    ->addBootstrapper(...$bootstrappers)
    ->boot();

// 9. Gibt den konfigurierten Container zurück an public/index.php
return $container;
```

**Schritte der Initialisierung in `bootstrap/app.php`:**

1.  **Arbeitsverzeichnis setzen**: `chdir(dirname(__DIR__))` stellt sicher, dass alle relativen Pfade korrekt vom Projektstammverzeichnis aus aufgelöst werden.
2.  **Autoloader laden**: `require __DIR__ . '/autoload.php';` bindet die Autoload-Logik ein, die primär den Composer-Autoloader (`vendor/autoload.php`) registriert, um das automatische Laden von Klassen zu ermöglichen.
3.  **Container laden**: `require 'container.php';` ist verantwortlich für die Instanziierung und grundlegende Konfiguration des DI-Containers (hier `Easy\Container\Container`).
4.  **Service Provider abrufen**: Eine Liste von Service Providern wird aus dem Container geholt. Diese Provider sind typischerweise in `config/providers.php` definiert und dienen dazu, Dienste im Container zu registrieren und zu konfigurieren.
5.  **Bootstrapper abrufen**: Ähnlich werden Bootstrapper-Klassen aus dem Container geholt, die in `config/bootstrappers.php` definiert sind. Bootstrapper führen Initialisierungsaufgaben aus, nachdem der Container und die grundlegenden Dienste konfiguriert wurden (z.B. Event-Listener registrieren, Routen laden).
6.  **Theme-Preview-Logik**: Überprüft, ob ein `PreviewCookie` gesetzt ist und ob ein entsprechendes Theme-Verzeichnis im `extensions`-Ordner existiert. Falls ja, wird eine `option.theme`-Einstellung im Container gesetzt. Dies ermöglicht das Testen von Themes oder Erweiterungen.
7.  **Anwendungsinstanz erstellen**: Eine Instanz der Klasse `Application` (wahrscheinlich `Src\Application` basierend auf der Verzeichnisstruktur `src/Application.php`) wird erstellt. Ihr werden der DI-Container und der Debug-Status (aus der Umgebungsvariable `DEBUG`) übergeben.
8.  **Provider und Bootstrapper registrieren und booten**: Die zuvor abgerufenen Service Provider und Bootstrapper werden der `$app`-Instanz hinzugefügt, und anschließend wird die `boot()`-Methode der `$app`-Instanz aufgerufen. In dieser Methode werden typischerweise die `register()`-Methoden der Service Provider und dann die `bootstrap()`-Methoden der Bootstrapper ausgeführt.
9.  **Container zurückgeben**: Der vollständig initialisierte und gebootete DI-Container wird an den Aufrufer (`public/index.php`) zurückgegeben.

Diese Datei orchestriert also den gesamten Startvorgang der Anwendung, indem sie Abhängigkeiten lädt, den Service-Container konfiguriert, Dienste registriert und Initialisierungsroutinen ausführt, bevor die eigentliche Anfrageverarbeitung beginnt.


### 3.3. Struktur und Zweck des `public/e`-Verzeichnisses

Das Verzeichnis `public/e/` dient der Bereitstellung von öffentlich zugänglichen Erweiterungen, insbesondere Themes und Frontend-Komponenten für Aikeedo. Die Inhalte dieses Verzeichnisses sind direkt über das Web erreichbar.

Basierend auf der Analyse (siehe Tool-Aufrufe 2-4):
- Das Verzeichnis `public/e/` enthält Unterverzeichnisse, die spezifische Erweiterungen oder Themes gruppieren, z.B. `heyaikeedo/`.
- Innerhalb von `heyaikeedo/` wurden die Verzeichnisse `default/` und `pulse/` gefunden.
    - `pulse/` enthält eine `composer.json`, die es als `"type": "aikeedo-theme"` deklariert. Es beinhaltet typische Theme-Strukturen wie `layouts/`, `sections/`, `snippets/`, `templates/` und `assets/`.
    - `default/` enthält hauptsächlich Frontend-Assets (CSS, JS, Bilder) und eine `.vite/manifest.json`, was ebenfalls auf ein Theme oder ein Frontend-Asset-Paket hindeutet.

**Unterschied zu `extra/extensions/`:**

- **`public/e/`**: Beinhaltet Komponenten, die direkt über den Webserver ausgeliefert werden müssen, wie z.B. Themes (CSS, JavaScript, Bilder, Templates für das Frontend-Rendering) oder andere Frontend-spezifische Erweiterungen. Die Struktur `public/e/{vendor}/{extension_name}/` scheint hier verwendet zu werden.
- **`extra/extensions/`**: Dient wahrscheinlich zur Ablage von serverseitigen Erweiterungen, Plugins oder Modulen, die nicht direkt öffentlich zugänglich sein müssen oder deren Assets über einen Build-Prozess in das `public`-Verzeichnis gelangen. Dies könnten PHP-basierte Plugins sein, die die Backend-Funktionalität erweitern.

Diese Unterscheidung ermöglicht eine klare Trennung zwischen öffentlich zugänglichen Frontend-Ressourcen von Erweiterungen und den eher im Backend angesiedelten oder nicht direkt exponierten Erweiterungskomponenten.

## 4. Kernfunktionen (Vermutet basierend auf Beschreibung und Abhängigkeiten)

- Benutzerregistrierung und -authentifizierung.
- Content-Generierung mittels KI (Text, Code, Bilder, Videos).
- Verwaltung von generierten Inhalten.
- Integration von Zahlungsdiensten (Stripe).
- Eigenes Token-/Credits-/-Währungsumrechnungssystem.
- Verarbeitung von PDF- und Word-Dateien.
- Text-to-Speech-Funktionalität.
- Workspace-Verwaltung.
- Internationalisierung.

## 5. Plugin-System

Das Plugin-System von Aikeedo ermöglicht die Erweiterung der Kernfunktionalität durch Composer-Pakete. Plugins und Themes werden im Verzeichnis `extra/extensions/` erwartet.

### 5.1. Entdeckung und Laden von Plugins

Der Prozess zum Entdecken und Laden von Plugins wird hauptsächlich durch die folgenden Komponenten gesteuert:

- **`Plugin\Infrastructure\PluginModuleBootstrapper.php`**: Dieser Bootstrapper ist verantwortlich für die Initialisierung des Plugin-Systems während des Anwendungsstarts.
    - Er registriert das `PluginRepositoryInterface` (mit `PluginRepository` als Implementierung) im DI-Container.
    - Er ruft die `loadPlugins()`-Methode auf, um alle verfügbaren Plugins zu laden.
    - Er ruft `loadTheme()` auf, um das aktive Theme zu laden und dessen Pfad dem Twig FilesystemLoader hinzuzufügen.

- **`Plugin\Infrastructure\PluginFinder.php`**: Diese Klasse ist dafür zuständig, Plugin-Verzeichnisse zu finden.
    - Die Methode `findPlugins(string $dir)` durchsucht das angegebene Verzeichnis (standardmäßig `extra/extensions/`) nach Unterverzeichnissen, die eine `composer.json`-Datei enthalten.
    - Die gefundenen Plugin-Pfade werden nach ihrer Erstellungszeit (neueste zuerst) sortiert zurückgegeben.

- **`Plugin\Infrastructure\PluginLoader.php`**: Diese Klasse lädt ein einzelnes Plugin.
    - Die Methode `load(string $path)` nimmt den Pfad zu einem Plugin-Verzeichnis entgegen.
    - Sie erstellt eine `Plugin\Domain\Context`-Instanz, die Metadaten aus der `composer.json` des Plugins liest und validiert (z.B. `name`, `type`, `entry-class`).
    - Wenn eine `entry-class` in der `composer.json` definiert ist, wird versucht, eine Instanz dieser Klasse über den DI-Container zu beziehen.
    - Es wird geprüft, ob die Plugin-Klasse das `Plugin\Domain\PluginInterface` implementiert.
    - Eine `Plugin\Domain\PluginWrapper`-Instanz wird erstellt, die den `Context` und die Plugin-Instanz (falls vorhanden) kapselt.
    - Das `PluginWrapper`-Objekt wird dem `PluginRepository` hinzugefügt.
    - Für Themes wird der Status basierend darauf gesetzt, ob es das aktuell konfigurierte Theme (`option.theme`) ist.
    - Wenn das Plugin aktiv ist (`Status::ACTIVE`) und eine Plugin-Instanz vorhanden ist, wird dessen `boot(Context $context)`-Methode aufgerufen.

### 5.2. Plugin-Interface und Kontext

- **`Plugin\Domain\PluginInterface.php`**: Definiert das Interface, das jede Plugin-Hauptklasse implementieren muss.
    - Es schreibt eine Methode `boot(Context $context): void` vor. Diese Methode wird aufgerufen, wenn die Anwendung startet (nachdem das Plugin geladen und als aktiv erkannt wurde), aber bevor die HTTP-Anfrage bearbeitet wird. Hier können Plugins ihre Dienste registrieren, Event-Listener anhängen oder andere Initialisierungsaufgaben durchführen.

- **`Plugin\Domain\Context.php`**: Diese Klasse repräsentiert den Kontext eines Plugins oder Themes.
    - Sie liest und validiert die `composer.json`-Datei des Plugins.
    - Sie stellt Metadaten wie Name, Typ (Plugin/Theme), Version, Beschreibung, Autor, Lizenzen, Entry-Klasse, Status (aktiv/inaktiv) etc. als Value Objects zur Verfügung.
    - Sie erlaubt das Ändern des Plugin-Status, wobei die Änderung auch in die `composer.json`-Datei zurückgeschrieben wird.
    - Wichtige Validierungen in der `composer.json`:
        - `type` muss entweder `aikeedo-plugin` oder `aikeedo-theme` sein.
        - `name` muss gesetzt sein.
        - Für `aikeedo-plugin` muss `extra.entry-class` gesetzt sein.
        - Alle Plugins/Themes müssen `heyaikeedo/composer` als Abhängigkeit deklarieren.

### 5.3. Plugin-Verwaltung und -Interaktion

- **Commands und Handler**: Das `Plugin`-Modul enthält diverse Commands (z.B. `InitializePluginCommand`, `InstallPluginCommand`, `ListPluginsCommand`, `UpdatePluginCommand`, `UninstallPluginCommand`) und deren Handler im `Plugin\Application` Namespace. Diese ermöglichen die Verwaltung von Plugins (Installieren, Aktivieren, Deaktivieren, Deinstallieren, Auflisten).
- **Repositories**: Das `PluginRepositoryInterface` (und seine Implementierung `InMemory\PluginRepository`) dient zur Speicherung und zum Abruf von `PluginWrapper`-Instanzen.
- **Routen und Assets**: Plugins können eigene Routen und Assets (JavaScript, CSS) definieren. Die `PluginInterface` könnte (basierend auf der `documentation.md`) Methoden wie `getRoutes()` und `getAssets()` vorsehen, die von der Anwendung aufgerufen werden, um diese zu registrieren. Die `Plugin.php` aus der `documentation.md` zeigt Beispiele dafür.
- **Hooks**: Das System scheint Hooks wie `InstallHookInterface`, `UninstallHookInterface`, `ActivateHookInterface`, `DeactivateHookInterface` zu unterstützen, die es Plugins ermöglichen, bei bestimmten Lebenszyklus-Ereignissen eigenen Code auszuführen.

### 5.4. Erstellung eines Plugins (basierend auf `docs/plugin-docu.md` und `docs/documentation.md`)

1.  **Verzeichnisstruktur**: Plugins werden unter `extra/extensions/<vendor>/<plugin-name>/` erstellt.
2.  **`composer.json`**: Jedes Plugin benötigt eine `composer.json` mit:
    - `name`: z.B. `aicent/cost-preview-plugin` (muss mit dem Pfad übereinstimmen).
    - `type`: `aikeedo-plugin` oder `aikeedo-theme`.
    - `version`.
    - `require`: Muss `heyaikeedo/composer` enthalten.
    - `extra.entry-class`: Der Namespace zur Hauptklasse des Plugins (z.B. `Aicent\CostPreviewPlugin\Plugin`).
    - `autoload`: PSR-4 Autoloading-Konfiguration für die Plugin-Klassen (z.B. `src/`).
3.  **Plugin-Hauptklasse**: Eine Klasse, die `Plugin\Domain\PluginInterface` implementiert und die `boot()`-Methode bereitstellt.
4.  **Installation**: Plugins werden über `composer require <vendor>/<plugin-name>` im Hauptverzeichnis der Aikeedo-Anwendung installiert.
5.  **Aktivierung**: Plugins müssen nach der Installation im Aikeedo-Backend aktiviert werden.

### 5.5. Wichtige Beobachtungen und Hinweise

- **Abhängigkeit von Composer**: Das Plugin-System ist stark auf Composer ausgerichtet, sowohl für die Definition von Metadaten als auch für die Installation.
- **Erweiterungsverzeichnis**: Das Standardverzeichnis für Erweiterungen (Plugins und Themes) ist `extra/extensions/`.
- **Internationalisierung**: Die `LocaleMiddleware` lädt auch Übersetzungen aus Plugin-Verzeichnissen (`<plugin-dir>/locale/{locale}/LC_MESSAGES/messages.po`).
- **Dokumentation**: Die Dateien `docs/plugin-docu.md` und `docs/documentation.md` (speziell für ein `CostPreviewPlugin`) liefern wertvolle Einblicke in die praktische Erstellung und Struktur von Plugins.

## 6. Routing-Mechanismen

Das Routing in Aikeedo ist dafür verantwortlich, eingehende HTTP-Anfragen an den entsprechenden Code (Request Handler) weiterzuleiten. Das System basiert maßgeblich auf Komponenten der `iziphp/router` Bibliothek (wie in `composer.json` deklariert), die unter dem Namespace `Easy\Router` im Projekt verwendet werden.

### 6.1. Konfiguration und Kernkomponenten

Die zentrale Konfiguration des Routings erfolgt im `Aikeedo\Application\Http\Bootstrap\RoutingBootstrapper` (definiert in `config/bootstrappers.php`), wie bereits in Abschnitt 3.2 beschrieben. Dieser Bootstrapper:
- Instanziiert einen `Easy\Router\Dispatcher`.
- Registriert zwei Haupt-Mapper beim Dispatcher:
    - **`Easy\Router\Mapper\AttributeMapper`**: Dieser Mapper scannt das `src/`-Verzeichnis nach PHP-Attributen in Klassen, um Routen zu entdecken. Routen werden typischerweise direkt in den Request Handler-Klassen mittels des `#[Route]`-Attributs definiert.
    - **`Easy\Router\Mapper\SimpleMapper`**: Ermöglicht die programmatische Definition von Routen. Wird im Bootstrapper beispielsweise für eine spezielle Route wie `POST /rc` verwendet.
- Registriert den konfigurierten `Dispatcher` als `Easy\Http\Server\DispatcherInterface` im DI-Container.

### 6.2. Routendefinition mittels Attributen

Routen werden primär durch PHP-Attribute in den Request Handler-Klassen (oft in `src/Presentation/RequestHandlers/`) definiert. Das verwendete Attribut ist `Easy\Router\Attributes\Route`.

**Beispiel für eine Routendefinition:**

```php
// In einer Klasse innerhalb von src/Presentation/RequestHandlers/
namespace Presentation\\RequestHandlers\\Admin;

use Easy\\Router\\Attributes\\Route;
use Easy\\Router\\Enums\\RequestMethod;
use Psr\\Http\\Message\\ServerRequestInterface;
use Psr\\Http\\Message\\ResponseInterface;
// ... weitere Use-Statements ...

class ExampleRequestHandler extends AbstractAdminViewRequestHandler
{
    #[Route(path: '/example/action', method: RequestMethod::GET, name: 'admin.example.action')]
    public function handleExample(ServerRequestInterface $request): ResponseInterface
    {
        // Logik zur Bearbeitung der Anfrage
        // ...
        return $this->view($request, 'admin/example-template.twig');
    }
}
```
In diesem Beispiel:
- `#[Route(...)]`: Definiert eine neue Route.
- `path`: Der URL-Pfad für die Route. Kann Platzhalter enthalten (z.B. `/users/{id}`).
- `method`: Die HTTP-Methode (z.B. `RequestMethod::GET`, `RequestMethod::POST`).
- `name`: Ein optionaler Name für die Route, nützlich für die Generierung von URLs.

Der `AttributeMapper` sammelt diese Definitionen beim Anwendungsstart.

### 6.3. Verarbeitung von Anfragen

Der `Aikeedo\Presentation\Http\ServerRequestHandler` (in `src/Presentation/Http/ServerRequestHandler.php`) ist der zentrale Einstiegspunkt für die Verarbeitung von HTTP-Anfragen (siehe Abschnitt 3.1).
- Er empfängt die eingehende `ServerRequestInterface`.
- Er verwendet den injizierten `Easy\Http\Server\DispatcherInterface` (der zuvor konfigurierte `Easy\Router\Dispatcher`), um die passende Route für die Anfrage zu finden.
- Der Dispatcher gibt bei Erfolg ein Routenobjekt zurück, das Informationen über den zugehörigen Handler und extrahierte Routenparameter enthält.
- Der `ServerRequestHandler` fügt diese Routeninformationen als Attribute zum Request-Objekt hinzu.
- Anschließend instanziiert er einen `Easy\HttpServerHandler\HttpServerHandler` mit dem Request-Handler der Route und den zugehörigen Middlewares.
- Die eigentliche Ausführung der Middlewares und des Request Handlers wird an diesen `HttpServerHandler` delegiert.

### 6.4. Zusammenhang mit `iziphp/router`

Obwohl die Implementierungsdetails oft den Namespace `Easy\Router` verwenden, ist `iziphp/router` die in `composer.json` deklarierte Kernbibliothek. Es ist anzunehmen, dass `Easy\Router` entweder ein direkter Namespace innerhalb der `iziphp/router`-Bibliothek ist oder eine eng damit verbundene Sammlung von Klassen und Abstraktionen darstellt, die Aikeedo für sein Routing-System nutzt. Die Funktionalitäten wie der Dispatcher, Attribute-basierte Routendefinition und Request-Handler-Integration sind typische Merkmale moderner PHP-Routing-Bibliotheken wie `iziphp/router`.

## 7. Haupt-Controller und Service-Klassen

Die Identifizierung von Haupt-Controllern und Service-Klassen ist entscheidend, um die Kernlogik der Anwendung zu verstehen.

### 7.1. Controller / Request Handler

In Aikeedo wird die Rolle der traditionellen Controller von **Request Handlern** übernommen. Diese befinden sich hauptsächlich im Verzeichnis `src/Presentation/RequestHandlers/`.

**Struktur und Typen von Request Handlern:**

- **Basis-Handler:**
    - `AbstractRequestHandler.php`: Wahrscheinlich eine Basisklasse für alle Request Handler, die gemeinsame Funktionalitäten bereitstellt.
- **Admin-Bereich Handler (`src/Presentation/RequestHandlers/Admin/`):**
    - `AbstractAdminRequestHandler.php`: Basisklasse für Handler, die im Admin-Bereich operieren.
    - `AbstractAdminViewRequestHandler.php`: Spezialisierte Basisklasse für Admin-Handler, die Twig-Views rendern.
    - `AdminViewRequestHandler.php`: Ein generischer Handler für verschiedene Admin-Ansichten, der dynamisch Templates basierend auf dem Routenparameter `:view` lädt (z.B. `/admin/analytics`, `/admin/plugins`).
    - **Spezifische View-Handler**: Viele Klassen sind direkt für das Rendern bestimmter Admin-Seiten zuständig (z.B. `DashboardView.php`, `PluginRequestHandler.php`, `UserRequestHandler.php`).
    - **API-Handler (`src/Presentation/RequestHandlers/Admin/Api/`):** Dieses Unterverzeichnis enthält eine Vielzahl von Handlern, die für die Admin-API-Endpunkte zuständig sind. Sie sind oft nach Modulen gruppiert (z.B. `Users/`, `Plugins/`, `Plans/`) und beinhalten Operationen wie Auflisten, Erstellen, Lesen, Aktualisieren und Löschen (CRUD).
        - `AdminApi.php`: Eine Basisklasse für Admin-API-Handler.
        - Modulspezifische API-Basisklassen (z.B. `PluginsApi.php`, `UserApi.php`).
        - Handler für spezifische Aktionen (z.B. `ListUsersRequestHandler.php`, `CreatePlanRequestHandler.php`).
- **Frontend/App-Bereich Handler (`src/Presentation/RequestHandlers/Api/` und `src/Presentation/RequestHandlers/App/`):**
    - **API-Handler (`src/Presentation/RequestHandlers/Api/`):** Diese Handler bedienen die öffentliche API der Anwendung, die von Frontend-Clients oder externen Diensten genutzt werden kann.
        - `Api.php`: Wahrscheinlich eine Basisklasse für öffentliche API-Handler.
        - Gruppierung nach Funktionalität (z.B. `Account/`, `Ai/`, `Billing/`, `Auth/`).
        - Beispiele: `CompletionsApi.php` (für KI-Textgenerierung), `SignupRequestHandler.php` (für Benutzerregistrierung), `CheckoutRequestHandler.php` (für Zahlungen).
    - **App-Handler (`src/Presentation/RequestHandlers/App/`):** Diese Handler sind für die Hauptanwendungsseiten zuständig, die von Endbenutzern gesehen werden (z.B. Dashboard, Editor-Ansichten).
- **Allgemeine Handler:**
    - `IndexRequestHandler.php`: Handler für die Startseite.
    - `LoginViewRequestHandler.php`, `LogoutRequestHandler.php`, `SignupViewRequestHandler.php`: Handler für Authentifizierungsvorgänge.
    - `NotFoundRequestHandler.php`: Handler für 404-Fehler.
    - `WebhookRequestHandler.php`: Handler für eingehende Webhooks von Drittanbietern (z.B. Stripe).

Die Request Handler sind typischerweise Klassen, die eine `handle()`-Methode (oder eine ähnlich benannte Methode, die durch das `#[Route]`-Attribut spezifiziert wird) implementieren, welche eine `Psr\Http\Message\ServerRequestInterface` entgegennimmt und eine `Psr\Http\Message\ResponseInterface` zurückgibt. Sie nutzen Dependency Injection, um auf andere Dienste und Repositories zuzugreifen.

### 7.2. Service-Klassen

Eine direkte, konsistente Namenskonvention wie `*Service.php` oder `*Manager.php` für dedizierte Service-Klassen konnte durch initiale Suchen nicht flächendeckend identifiziert werden.

Die Anwendungslogik, die typischerweise in Service-Klassen zu finden ist, scheint in Aikeedo auf folgende Weisen verteilt zu sein:

- **Application Layer Klassen (Command Handlers & Query Handlers):** Innerhalb der Modulstruktur (z.B. `src/User/Application/`) befinden sich Klassen, die spezifische Anwendungsfälle oder Befehle behandeln (z.B. `CreateUserCommandHandler.php`, `ListPluginsCommandHandler.php`). Diese Klassen orchestrieren Domain-Objekte und Repositories, um Aktionen auszuführen oder Daten abzurufen. Sie agieren als die primären "Application Services" im Sinne von DDD.
- **Domain Layer Klassen:** Komplexe Geschäftslogik, die nicht direkt einem einzelnen Anwendungsfall zugeordnet ist, kann in Domain Services innerhalb der `Domain`-Verzeichnisse der Module implementiert sein (z.B. `Plugin\Domain\Services\PluginValidationService.php`).
- **Infrastructure Layer Klassen:** Klassen im `Infrastructure`-Verzeichnis der Module bieten Implementierungen für Schnittstellen, die von der Domain- oder Anwendungsschicht definiert werden. Dazu gehören Repositories, aber auch Clients für externe Dienste (z.B. ein Stripe-Client, ein E-Mail-Versanddienst).
- **Helper-Klassen:** Im Verzeichnis `helpers/` und potenziell auch in `Plugin/Infrastructure/Helpers/` gibt es Hilfsklassen, die wiederverwendbare Funktionen bereitstellen.

Es ist davon auszugehen, dass die "Service"-Logik also nicht in einer separaten Schicht von Klassen mit einer einheitlichen `*Service.php`-Benennung konzentriert ist, sondern eher den Prinzipien des Domain-Driven Design folgt und in den Anwendungs-, Domain- und Infrastrukturschichten der jeweiligen Module verteilt ist.

## 8. Datenbankstruktur (Doctrine Entities und Migrationen)

Die Persistenzschicht von Aikeedo wird hauptsächlich durch Doctrine ORM verwaltet. Dies umfasst Entitätsklassen, die Datenbanktabellen repräsentieren, und Migrationsskripte, die Änderungen am Datenbankschema über die Zeit verfolgen.

### 8.1. Doctrine Entities

Doctrine Entities sind PHP-Klassen, die Datenbanktabellen und deren Spalten auf Objekteigenschaften mappen. In Aikeedo werden Entitäten durch das PHP-Attribut `#[ORM\Entity]` (oder kurz `#[Entity]`, da Doctrine den `ORM` Namespace importiert) gekennzeichnet. Diese Entitäten befinden sich typischerweise in den `Domain/Entities/` Unterverzeichnissen der jeweiligen Module im `src/` Ordner.

Eine Suche nach `#\[(ORM\\)?Entity` im `src`-Verzeichnis hat eine Vielzahl von Entitätsklassen aufgedeckt, die die Kernkonzepte der Anwendung abbilden. Hier eine Auswahl der gefundenen Entitäten, gruppiert nach Modulen (basierend auf ihrem Namespace):

- **Affiliate:**
    - `AffiliateEntity.php`
    - `PayoutEntity.php`
- **Ai:**
    - `AbstractLibraryItemEntity.php` (Basisklasse)
    - `ClassificationEntity.php`
    - `CodeDocumentEntity.php`
    - `CompositionEntity.php`
    - `ConversationEntity.php`
    - `DocumentEntity.php`
    - `ImageEntity.php`
    - `IsolatedVoiceEntity.php`
    - `MessageEntity.php`
    - `SpeechEntity.php`
    - `TranscriptionEntity.php`
    - `VideoEntity.php`
- **Assistant:**
    - `AssistantEntity.php`
- **Billing:**
    - `CouponEntity.php`
    - `OrderEntity.php`
    - `PlanEntity.php`
    - `PlanSnapshotEntity.php`
    - `SubscriptionEntity.php`
- **Category:**
    - `CategoryEntity.php`
- **Dataset:**
    - `AbstractDataUnitEntity.php` (Basisklasse)
    - `FileUnitEntity.php`
    - `LinkUnitEntity.php`
- **File:**
    - `AbstractFileEntity.php` (Basisklasse)
    - `FileEntity.php`
    - `ImageFileEntity.php`
- **Option:**
    - `OptionEntity.php`
- **Preset:**
    - `PresetEntity.php`
- **Stat:**
    - `AbstractStatEntity.php` (Basisklasse)
    - `OrderStatEntity.php`
    - `SignupStatEntity.php`
    - `SubscriptionStatEntity.php`
    - `UsageStatEntity.php`
- **User:**
    - `UserEntity.php`
- **Voice:**
    - `VoiceEntity.php`
- **Workspace:**
    - `WorkspaceEntity.php`
    - `WorkspaceInvitationEntity.php`

Diese Entitäten definieren die Struktur der Datenbanktabellen, ihre Spalten, Datentypen und Beziehungen untereinander (z.B. OneToMany, ManyToOne), die durch weitere Doctrine ORM-Attribute innerhalb der Klassen spezifiziert werden.

### 8.2. Datenbankmigrationen

Doctrine Migrations wird verwendet, um Änderungen am Datenbankschema versioniert zu verwalten. Die Migrationsskripte befinden sich im Verzeichnis `migrations/`.

Die Struktur des `migrations/`-Verzeichnisses deutet auf eine Unterstützung für verschiedene Datenbanksysteme hin:
- `migrations/mysql/`: Enthält Migrationsskripte spezifisch für MySQL-Datenbanken.
- `migrations/sqlite/`: Enthält Migrationsskripte spezifisch für SQLite-Datenbanken.
- `migrations/update/`: Der Zweck dieses Verzeichnisses ist unklar, könnte aber Update-Skripte oder spezifische Migrationslogik enthalten.

Eine Auflistung des `migrations/mysql/`-Verzeichnisses zeigt eine Reihe von PHP-Dateien, die typischerweise `VersionYYYYMMDDHHMMSS.php` oder einem ähnlichen semantischen Versionierungsschema wie `VersionMAJORMINORPATCH.php` (z.B. `Version100.php`, `Version210.php`, `Version30000.php`) folgen. Jede dieser Dateien repräsentiert eine spezifische Schemaänderung (z.B. Erstellen einer Tabelle, Hinzufügen einer Spalte, Erstellen eines Index).

Die Konfiguration für Doctrine Migrations befindet sich wahrscheinlich in `config/migrations.php`, wie in Abschnitt 3.2 erwähnt.

Diese Kombination aus Entities und Migrationen ermöglicht eine kontrollierte Entwicklung und Wartung des Datenbankschemas der Aikeedo-Anwendung.

## 9. Event-Dispatching-Mechanismen

Das Event-Dispatching-System in Aikeedo ermöglicht eine entkoppelte Kommunikation zwischen verschiedenen Teilen der Anwendung. Wenn ein bestimmtes Ereignis eintritt (z.B. ein Benutzer wird erstellt, eine Bestellung wird bezahlt), kann ein Event ausgelöst werden. Andere Teile der Anwendung (Listener) können auf diese Events reagieren, ohne dass der Auslöser des Events die Listener direkt kennen muss.

### 9.1. Kernkomponenten und Konfiguration

Das System basiert auf dem PSR-14 Standard (`psr/event-dispatcher`) und nutzt Komponenten, die unter dem Namespace `Easy\EventDispatcher` angesiedelt sind (vermutlich aus einer Bibliothek wie `iziphp/event-dispatcher` oder einer ähnlichen Eigenentwicklung, die dem `Easy\` Namespace-Muster folgt).

- **`Shared\Infrastructure\Providers\EventServiceProvider.php`**: Diese Klasse ist zentral für die Konfiguration des Event-Systems.
    - Sie registriert Implementierungen für `Psr\EventDispatcher\EventDispatcherInterface` (konkret `Easy\EventDispatcher\EventDispatcher`) und `Psr\EventDispatcher\ListenerProviderInterface` (konkret `Easy\EventDispatcher\ListenerProvider`) im DI-Container.
    - Der `ListenerProvider` wird mit verschiedenen Mappern konfiguriert, um Listener zu entdecken:
        - `Easy\EventDispatcher\Mapper\EventAttributeMapper`: Ermöglicht das Markieren von Event-Klassen mit Attributen, um sie für Listener auffindbar zu machen.
        - `Easy\EventDispatcher\Mapper\ListenerAttributeMapper`: Ermöglicht das Markieren von Listener-Klassen oder -Methoden mit Attributen, um sie Events zuzuordnen.
        - `Easy\EventDispatcher\Mapper\ArrayMapper`: Erlaubt die programmatische Registrierung von Listenern für spezifische Events (wie im `Stat\Infrastructure\StatModuleBootstrapper.php` zu sehen).

### 9.2. Definition von Events

Events sind typischerweise einfache PHP-Klassen, die Daten über das aufgetretene Ereignis enthalten. Sie befinden sich oft in den `Domain/Events/` Unterverzeichnissen der jeweiligen Module.

- **Beispiele für Event-Klassen:**
    - `User\Domain\Events\UserCreatedEvent.php`
    - `Billing\Domain\Events\OrderFulfilledEvent.php`
    - `Preset\Domain\Events\PresetUpdatedEvent.php`
- Oft erben diese spezifischen Events von einer abstrakten Basis-Event-Klasse innerhalb desselben Moduls (z.B. `User\Domain\Events\AbstractUserEvent.php`).
- Event-Klassen können mit dem `#[Listener]`-Attribut (aus `Easy\EventDispatcher\Attributes\Listener`) versehen werden, um direkt Listener zu definieren, die auf dieses Event reagieren sollen. Dies ist ein Muster zur automatischen Erkennung von Listenern für ein bestimmtes Event.

### 9.3. Auslösen von Events (Dispatching)

Events werden von verschiedenen Teilen der Anwendung ausgelöst, häufig am Ende von Operationen in Command Handlers (Application Layer).

- Der `Psr\EventDispatcher\EventDispatcherInterface` wird per Dependency Injection in die Klasse injiziert, die ein Event auslösen möchte.
- Eine Instanz der Event-Klasse wird erstellt und mit den relevanten Daten gefüllt.
- Die `dispatch()`-Methode des Event Dispatchers wird mit dem Event-Objekt aufgerufen.

**Beispiel aus `User\Application\CommandHandlers\CreateUserCommandHandler.php`:**
```php
// ...
$event = new UserCreatedEvent($user);
$this->dispatcher->dispatch($event);
// ...
```

### 9.4. Definition von Event Listeners

Event Listener sind Klassen oder Methoden, die auf bestimmte Events reagieren und entsprechende Logik ausführen.

- Listener befinden sich oft in den `Infrastructure/Listeners/` Unterverzeichnissen der Module.
- Eine Listener-Klasse implementiert typischerweise eine `__invoke()`-Methode, die das spezifische Event-Objekt als Parameter akzeptiert, auf das sie reagieren soll.
- Die Zuordnung von Listenern zu Events kann erfolgen durch:
    - **Attribute**: Verwendung des `#[Listener]`-Attributs entweder direkt an der Event-Klasse (um Listener zu definieren, die dieses Event abonnieren) oder an der Listener-Klasse/-Methode selbst (um zu spezifizieren, welche Events sie behandeln).
    - **Programmatische Registrierung**: Über den `ArrayMapper` im `EventServiceProvider` oder in Modul-Bootstrappern (z.B. `StatModuleBootstrapper` fügt Listener für `CreditUsageEvent`, `UserCreatedEvent` etc. hinzu).

**Beispiel eines Listeners (`User\Infrastructure\Listeners\SendWelcomeEmail.php`):**
```php
// ...
class SendWelcomeEmail
{
    // ...
    public function __invoke(UserCreatedEvent|EmailVerifiedEvent $event)
    {
        $user = $event->user;
        // Logik zum Senden der Willkommens-E-Mail
    }
}
```

### 9.5. Server-Sent Events (SSE)

Neben dem anwendungsinternen Event-System gibt es auch eine Implementierung für Server-Sent Events (SSE) unter `Presentation/EventStream/Streamer.php`. Diese wird in API-Endpunkten wie `CompletionsApi.php` und `MessageApi.php` verwendet, um Echtzeit-Updates an den Client zu senden (z.B. während der Generierung von KI-Inhalten). Dies ist ein spezifischer Anwendungsfall von Eventing für die Client-Kommunikation und unterscheidet sich vom allgemeinen PSR-14 Event Dispatcher.

### 9.6. Externe Events (Beispiel Stripe)

Die Anwendung verarbeitet auch Events von externen Systemen, wie z.B. Stripe Webhooks (`Billing\Infrastructure\Payments\Gateways\Stripe\WebhookRequestHandler.php`). Hierbei werden `Stripe\Event`-Objekte verwendet, die spezifisch für die Stripe-Bibliothek sind.

Das Event-System von Aikeedo ist somit ein wichtiger Mechanismus zur Entkopplung von Modulen und zur Implementierung von reaktiven Verhaltensweisen in der gesamten Anwendung.

## 10. Dateisystemabstraktion

Aikeedo verwendet eine Abstraktionsschicht für den Zugriff auf das Dateisystem und für Content Delivery Network (CDN)-Funktionalitäten. Dies ermöglicht es, die zugrundeliegende Speicherimplementierung bei Bedarf auszutauschen.

### 10.1. Konfiguration und Initialisierung

Die Initialisierung der Dateisystemkomponenten erfolgt im `Shared\Infrastructure\Bootstrappers\FileSystemBootstrapper.php`.

- **`FileSystemBootstrapper::bootstrap()` Methode:**
    - Erstellt eine `CdnAdapterCollection`, die verschiedene CDN-Adapter verwalten kann. Standardmäßig wird der `LocalCdnAdapter` registriert.
    - Registriert die folgenden Dienste im DI-Container (`$this->app`):
        - `FileSystemInterface`: Gebunden an eine Instanz von `Shared\Infrastructure\FileSystem\FileSystem`, die mit einem `LocalFileSystemAdapter` konfiguriert ist.
        - `CdnAdapterCollectionInterface`: Gebunden an die erstellte `CdnAdapterCollection`.
        - `CdnInterface`: Gebunden an die Klasse `Shared\Infrastructure\FileSystem\Cdn`.

### 10.2. Kernkomponenten

- **`Shared\Infrastructure\FileSystem\FileSystemInterface`**: Definiert den Vertrag für Dateisystemoperationen (Lesen, Schreiben, Löschen von Dateien und Verzeichnissen etc.).
- **`Shared\Infrastructure\FileSystem\FileSystem`**: Die konkrete Implementierung von `FileSystemInterface`. Sie verwendet einen Adapter (standardmäßig `LocalFileSystemAdapter`), um die tatsächlichen Dateioperationen durchzuführen.
- **`Shared\Infrastructure\FileSystem\Adapters\LocalFileSystemAdapter`**: Ein Adapter, der Dateioperationen auf dem lokalen Dateisystem durchführt. Er wird mit dem Root-Verzeichnis der Anwendung (`config.dirs.root`) initialisiert und kann so konfiguriert werden, dass er symbolische Links überspringt (`LocalFilesystemAdapter::SKIP_LINKS`).

- **`Shared\Infrastructure\FileSystem\CdnInterface`**: Definiert den Vertrag für CDN-bezogene Operationen, wie das Abrufen von URLs für Assets.
- **`Shared\Infrastructure\FileSystem\Cdn`**: Die konkrete Implementierung von `CdnInterface`. Sie verwendet die `CdnAdapterCollection`, um den passenden CDN-Adapter für eine bestimmte Aufgabe auszuwählen.
- **`Shared\Infrastructure\FileSystem\CdnAdapterCollectionInterface`**: Ein Interface für eine Sammlung von CDN-Adaptern.
- **`Shared\Infrastructure\FileSystem\CdnAdapterCollection`**: Verwaltet eine Liste von verfügbaren CDN-Adaptern. Ermöglicht das Hinzufügen und Abrufen von Adaptern über einen Lookup-Schlüssel.
- **`Shared\Infrastructure\FileSystem\Adapters\LocalCdnAdapter`**: Ein CDN-Adapter, der Assets vom lokalen Server bereitstellt. Dies ist nützlich für Entwicklungsumgebungen oder Setups ohne externes CDN. Er hat den Lookup-Schlüssel `LocalCdnAdapter::LOOKUP_KEY`.

### 10.3. Verwendung

Andere Teile der Anwendung können `FileSystemInterface` injizieren, um mit dem Dateisystem zu interagieren, und `CdnInterface`, um URLs für Assets zu generieren, die über ein CDN (oder die lokale Alternative) ausgeliefert werden sollen. Diese Abstraktion erleichtert das Testen und die Anpassung an verschiedene Hosting-Umgebungen oder Speicherlösungen (z.B. Cloud-Speicher wie Amazon S3 durch Hinzufügen eines entsprechenden Adapters).


## 5. Kommandozeilen-Interface (CLI) und Konsolenbefehle

Aikeedo nutzt das Symfony Console-Modul für die Implementierung von Kommandozeilenbefehlen. Diese ermöglichen administrative Aufgaben, Automatisierungen und Hintergrundprozesse.

### 5.1. Definition von Befehlen

- **Speicherort:** Konsolenbefehle sind typischerweise als PHP-Klassen im Verzeichnis `src/Presentation/Commands/` implementiert, wie in der Projektstruktur bereits angedeutet.
- **Struktur:** Jeder Befehl erbt üblicherweise von `Symfony\Component\Console\Command\Command`.
    - Der Name des Befehls (z.B. `app:create-user`) wird über das `#[AsCommand]`-Attribut (für Symfony 5.3+) oder durch Überschreiben der `configure()`-Methode und Setzen von `$this->setName('app:create-user')` festgelegt.
    - Die Logik des Befehls befindet sich in der `execute(InputInterface $input, OutputInterface $output)`-Methode. Diese Methode sollte einen Integer-Statuscode zurückgeben (typischerweise `Command::SUCCESS` oder `Command::FAILURE`).
    - Abhängigkeiten (Services, Konfigurationsparameter) werden über den Konstruktor injiziert (Dependency Injection), was durch den DI-Container der Anwendung ermöglicht wird.

### 5.2. Registrierung von Befehlen

Die Registrierung der Konsolenbefehle erfolgt zentral und wird maßgeblich durch den `ConsoleBootstrapper` gesteuert, der in `config/bootstrappers.php` aufgeführt ist:

- **`config/commands.php`:** Diese Datei enthält sehr wahrscheinlich ein Array von vollqualifizierten Klassennamen der Befehle, die der Anwendung hinzugefügt werden sollen.
    ```php
    // Beispielhafter Inhalt von config/commands.php
    return [
        \Aikeedo\Presentation\Commands\UserCreateCommand::class,
        \Aikeedo\Presentation\Commands\CacheClearCommand::class,
        // ... weitere Befehle
    ];
    ```
- **`ConsoleBootstrapper` (z.B. `Aikeedo\Shared\Infrastructure\Symfony\ConsoleBootstrapper` oder ähnlich, referenziert in `config/bootstrappers.php`):**
    - Dieser Bootstrapper ist verantwortlich für die Initialisierung der Konsolenanwendung.
    - In seiner `bootstrap()`-Methode (oder einer äquivalenten Methode, die von der `Application`-Klasse aufgerufen wird):
        1. Erstellt eine Instanz von `Symfony\Component\Console\Application` (oder einer benutzerdefinierten abgeleiteten Klasse wie z.B. `Aikeedo\Console\Application`, falls vorhanden).
        2. Lädt die Liste der Befehlsklassen aus der Konfigurationsdatei (z.B. `config/commands.php`).
        3. Iteriert über diese Liste. Für jede Befehlsklasse:
            - Fordert eine Instanz des Befehls vom DI-Container an (z.B. `$container->get($commandClassName)`). Der Container kümmert sich um die Auflösung der Konstruktorabhängigkeiten des Befehls.
            - Fügt die instanziierten Befehle zur `Symfony\Component\Console\Application`-Instanz hinzu (mittels `$consoleApplication->add($commandInstance)`).
        4. Registriert die `Symfony\Component\Console\Application`-Instanz selbst im DI-Container. Dies ermöglicht es dem Einstiegsskript (`bin/console`), die konfigurierte Konsolenanwendung abzurufen und auszuführen.

### 5.3. Ausführung von Befehlen

- **Einstiegspunkt:** Ein Skript wie `bin/console` (oder ein ähnliches im `bin/`-Verzeichnis) dient als Haupteinstiegspunkt für die Ausführung von CLI-Befehlen.
- **Funktionsweise von `bin/console` (typisch für Symfony Console basierte Anwendungen):
    1. **Bootstrap:** Lädt die zentrale Anwendungsinitialisierung (z.B. `require __DIR__.'/../bootstrap/app.php';`). Dies stellt sicher, dass der Autoloader, Umgebungsvariablen, der DI-Container und die Kernanwendung (`Aikeedo\Application`) initialisiert werden. Der Boot-Prozess der `Application`-Klasse führt alle registrierten Bootstrapper aus, einschließlich des `ConsoleBootstrapper`.
    2. **Konsolenanwendung abrufen:** Holt die konfigurierte `Symfony\Component\Console\Application`-Instanz aus dem DI-Container (z.B. `$application->getContainer()->get(Symfony\Component\Console\Application::class)`).
    3. **Ausführen:** Ruft die `run()`-Methode der `Symfony\Component\Console\Application`-Instanz auf. Diese Methode verarbeitet die übergebenen Kommandozeilenargumente, identifiziert den auszuführenden Befehl, validiert die Eingaben und ruft dessen `execute()`-Methode auf.

Diese Architektur ermöglicht eine saubere Trennung der Verantwortlichkeiten, eine gute Testbarkeit der einzelnen Befehle und eine einfache Erweiterbarkeit des CLI-Interfaces. Durch die Nutzung von Symfony Console stehen zudem viele Standardfunktionen wie Argumenten- und Optionsparsing, automatische Hilfe-Generierung, Fortschrittsbalken und Tabellenausgaben zur Verfügung.


## 11. Nächste Schritte der Analyse

- Detaillierte Untersuchung der Verzeichnisstruktur (`src`, `app`, `config` etc.). (Abgeschlossen)
- Analyse der Routing-Mechanismen (wahrscheinlich `iziphp/router`). (Abgeschlossen)
- Analyse der Routing-Mechanismen (wahrscheinlich `iziphp/router`). (Abgeschlossen)
- Identifizierung der Haupt-Controller und Service-Klassen. (Abgeschlossen)
- Untersuchung der Datenbankstruktur (Doctrine Entities und Migrations). (Abgeschlossen)
- Analyse der Event-Dispatching-Logik (`iziphp/event-dispatcher`). (Abgeschlossen)
- Identifizierung der Haupt-Controller und Service-Klassen. (Abgeschlossen)
- Untersuchung der Datenbankstruktur (Doctrine Entities und Migrations). (Abgeschlossen)
- Analyse der Event-Dispatching-Logik (`iziphp/event-dispatcher`). (Abgeschlossen)
- Untersuchung der Datenbankstruktur (Doctrine Entities und Migrations). (Abgeschlossen)
- Analyse der Event-Dispatching-Logik (`iziphp/event-dispatcher`). (Abgeschlossen)
- Analyse der Event-Dispatching-Logik (`iziphp/event-dispatcher`). (Abgeschlossen)
- Verständnis der Frontend-Komponentenstruktur und deren Interaktion mit dem Backend. (Abgeschlossen)
## 10. Event-Dispatching-Mechanismen

Das Event-Dispatching-System in Aikeedo ermöglicht eine entkoppelte Kommunikation zwischen verschiedenen Teilen der Anwendung. Wenn ein bestimmtes Ereignis eintritt (z.B. ein Benutzer wird erstellt, eine Bestellung wird bezahlt), kann ein Event ausgelöst werden. Andere Teile der Anwendung (Listener) können auf diese Events reagieren, ohne dass der Auslöser des Events die Listener direkt kennen muss.

**Kernkomponenten und Funktionsweise:**

1.  **Basis:** Das System basiert auf dem PSR-14 Standard (`psr/event-dispatcher`) und nutzt Komponenten, die unter dem Namespace `Easy\EventDispatcher` angesiedelt sind. Diese stammen wahrscheinlich aus der `iziphp/event-dispatcher`-Bibliothek oder einer eng verwandten Eigenentwicklung, die dem `Easy\` Namespace-Muster des Projekts folgt.

2.  **Service-Registrierung (`config/providers.php` und `src/Application.php`):
    *   Der `EventServiceProvider` (definiert in `config/providers.php`) ist dafür zuständig, die notwendigen Implementierungen für `Psr\EventDispatcher\EventDispatcherInterface` (konkret `Easy\EventDispatcher\EventDispatcher`) und `Psr\EventDispatcher\ListenerProviderInterface` (konkret `Easy\EventDispatcher\ListenerProvider`) im DI-Container zu registrieren.

3.  **Listener-Provider und Mapper (`Easy\EventDispatcher\ListenerProvider`):
    *   Der `ListenerProvider` ist dafür verantwortlich, alle relevanten Listener für ein gegebenes Event zu finden.
    *   Er verwendet verschiedene Mapper, um Listener zu entdecken:
        *   `Easy\EventDispatcher\Mapper\EventAttributeMapper`: Ermöglicht das Markieren von Event-Klassen mit Attributen (z.B. `#[Listener(MyListener::class)]`), um Listener direkt mit dem Event zu verknüpfen.
        *   `Easy\EventDispatcher\Mapper\ListenerAttributeMapper`: Ermöglicht das Markieren von Listener-Klassen oder -Methoden mit Attributen (z.B. `#[AsEventListener(event: MyEvent::class)]`), um sie Events zuzuordnen.
        *   `Easy\EventDispatcher\Mapper\ArrayMapper`: Erlaubt die programmatische Registrierung von Listenern für spezifische Events. Dies wird beispielsweise im `Stat\Infrastructure\StatModuleBootstrapper.php` verwendet, um Listener für `OrderPaidEvent`, `UserRegisteredEvent` etc. zu registrieren.

4.  **Definition von Events und Listenern:**
    *   **Events:** Sind einfache PHP-Klassen, die oft Daten über das Ereignis enthalten. Sie können das `Psr\EventDispatcher\StoppableEventInterface` implementieren, wenn sie die weitere Verarbeitung von Listenern stoppen können sollen.
    *   **Listeners:** Sind PHP-Klassen oder aufrufbare Methoden, die die Logik enthalten, die als Reaktion auf ein Event ausgeführt werden soll. Sie erhalten das Event-Objekt als Parameter.
        *   Listener können über Attribute (`#[AsEventListener]`) oder programmatisch (via `ArrayMapper` in einem Bootstrapper oder Service Provider) registriert werden.

5.  **Auslösen von Events (Dispatching):
    *   Um ein Event auszulösen, wird der `Psr\EventDispatcher\EventDispatcherInterface` per Dependency Injection in die Klasse injiziert, die das Event auslösen möchte.
    *   Die `dispatch()`-Methode des Event Dispatchers wird mit dem Event-Objekt als Argument aufgerufen.
    *   Beispiel:
        ```php
        // In einer Service-Klasse oder einem Command Handler
        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);
        ```
    *   Dies ist explizit in `cron.php` (`$dispatcher->dispatch(new CronEvent());`) und im `ModuleGenerator.php` zu sehen.

6.  **Abgrenzung zum Command Bus:**
    *   Es ist wichtig, den Event Dispatcher vom Command Bus (`Shared\Infrastructure\CommandBus\Dispatcher`) zu unterscheiden. Während der Command Bus dazu dient, Aktionen (Commands) an einen einzelnen Handler weiterzuleiten, dient der Event Dispatcher dazu, Ereignisse an potenziell mehrere, voneinander unabhängige Listener zu verteilen.
    *   Viele der Suchergebnisse für "Dispatcher" bezogen sich auf den Command Bus, der für die Ausführung von Anwendungsfällen zuständig ist.

7.  **Server-Sent Events (SSE):
    *   Neben dem anwendungsinternen PSR-14 Event-System gibt es auch eine Implementierung für Server-Sent Events (SSE) unter `Presentation/EventStream/Streamer.php`. Diese wird in API-Endpunkten wie `CompletionsApi.php` und `MessageApi.php` verwendet, um Echtzeit-Updates an den Client zu senden (z.B. während der Generierung von KI-Inhalten). Dies ist ein spezifischer Anwendungsfall von Eventing für die Client-Kommunikation und unterscheidet sich vom allgemeinen PSR-14 Event Dispatcher.

Zusammenfassend lässt sich sagen, dass Aikeedo ein robustes, auf PSR-14 basierendes Event-Dispatching-System verwendet, das eine lose Kopplung und Erweiterbarkeit der Anwendungslogik ermöglicht. Events werden ausgelöst, und registrierte Listener reagieren darauf, ohne dass direkte Abhängigkeiten zwischen den Komponenten bestehen müssen.

## 9. Datenbankstruktur (Doctrine Entities und Migrationen)

Aikeedo verwendet Doctrine ORM für die Datenbankinteraktion und das Schema-Management. Die Datenbankstruktur wird durch Doctrine Entities definiert und durch Migrationsdateien versioniert und aktualisiert.

**Doctrine Entities:**

Doctrine Entities sind PHP-Klassen, die Datenbanktabellen und deren Spalten auf Objekteigenschaften mappen. In Aikeedo werden Entitäten durch das PHP-Attribut `#[ORM\Entity]` (oder kurz `#[Entity]`, da Doctrine den `ORM` Namespace importiert) gekennzeichnet. Diese Entitäten befinden sich typischerweise in den `Domain/Entities/` Unterverzeichnissen der jeweiligen Module im `src/` Ordner.

Eine Suche nach `#[ORM\Entity]` im `src`-Verzeichnis hat eine Vielzahl von Entitätsklassen ergeben, die die Kernobjekte der Anwendung repräsentieren. Beispiele hierfür sind:

*   `User\Domain\Entities\UserEntity.php`
*   `Billing\Domain\Entities\PlanEntity.php`
*   `Billing\Domain\Entities\OrderEntity.php`
*   `Billing\Domain\Entities\SubscriptionEntity.php`
*   `Ai\Domain\Entities\ConversationEntity.php`
*   `Ai\Domain\Entities\MessageEntity.php`
*   `Ai\Domain\Entities\ImageEntity.php`
*   `Preset\Domain\Entities\PresetEntity.php`
*   `Workspace\Domain\Entities\WorkspaceEntity.php`
*   `File\Domain\Entities\FileEntity.php`
*   `Category\Domain\Entities\CategoryEntity.php`
*   `Affiliate\Domain\Entities\AffiliateEntity.php`
*   `Voice\Domain\Entities\VoiceEntity.php`
*   `Option\Domain\Entities\OptionEntity.php`
*   `Stat\Domain\Entities\UsageStatEntity.php`
*   Viele weitere Entitäten für spezifische KI-Artefakte (Document, Transcription, Speech, Video etc.) und Datasets.

Jede dieser Entitätsdateien enthält Definitionen für Spalten (`#[ORM\Column(...)]`), Beziehungen zu anderen Entitäten (`#[ORM\ManyToOne(...)]`, `#[ORM\OneToMany(...)]`, `#[ORM\ManyToMany(...)]`) und andere Doctrine-spezifische Metadaten.

**Doctrine Migrationen:**

Datenbankmigrationen werden verwendet, um Änderungen am Datenbankschema über die Zeit hinweg zu verwalten. Aikeedo nutzt `doctrine/migrations`.

*   Das Verzeichnis `migrations/` enthält die Migrationsdateien.
*   Es gibt Unterverzeichnisse für verschiedene Datenbanktreiber, z.B. `migrations/mysql/`.
*   Die Migrationsdateien sind PHP-Klassen, die von `Doctrine\Migrations\AbstractMigration` erben und `up()` sowie `down()` Methoden implementieren, um Schemaänderungen anzuwenden bzw. rückgängig zu machen.
*   Beispiele für Migrationsdateien sind `Version100.php`, `Version200.php` etc. Diese Dateien enthalten SQL-Anweisungen, um Tabellen zu erstellen, zu ändern oder zu löschen.
*   Die Konfiguration für Doctrine Migrations befindet sich wahrscheinlich in `config/migrations.php` und wird durch den `DoctrineBootstrapper` initialisiert.

**Zusammenfassend lässt sich sagen, dass die Datenbankstruktur von Aikeedo durch eine Vielzahl von Doctrine Entities definiert wird, die die verschiedenen Domänenobjekte der Anwendung abbilden. Änderungen an dieser Struktur werden systematisch über Doctrine Migrations verwaltet.** Eine genaue Analyse der einzelnen Entitätsbeziehungen und der in den Migrationen durchgeführten Schemaänderungen würde ein noch tieferes Verständnis der Datenmodelle ermöglichen.

## 3. Detaillierte Verzeichnisstruktur (Zusammenfassung)

Die detaillierte Untersuchung der Verzeichnisstruktur wurde im Laufe der Analyse verschiedener Komponenten und Konfigurationsdateien bereits umfassend durchgeführt. Die wichtigsten Erkenntnisse sind in den vorhergehenden Abschnitten dokumentiert, insbesondere:

*   **Abschnitt 2.3 Projektstruktur:** Gibt einen Überblick über die Hauptverzeichnisse im Stammverzeichnis des Projekts.
*   **Abschnitt 3.1 Struktur des `src`-Verzeichnisses:** Detailliert die modulare, DDD-inspirierte Struktur des PHP-Quellcodes.
*   **Abschnitt 3.2 Struktur des `config`-Verzeichnisses:** Beschreibt die Konfigurationsdateien für Bootstrapping, Service Provider, Befehle und Migrationen.
*   **Abschnitt 6 Frontend-Komponentenstruktur:** Erläutert die Struktur der Frontend-Assets in `resources/assets/` und `resources/views/` sowie die Build-Konfiguration.

Diese Abschnitte zusammen bieten ein umfassendes Bild der Organisation des Aikeedo-Projekts.

## 4. Haupt-Controller und Service-Klassen

Die Identifizierung der Haupt-Controller und Service-Klassen stützt sich auf die bereits durchgeführte Analyse der Projektstruktur, insbesondere des `src`-Verzeichnisses und der Konfigurationsdateien.

**Haupt-Controller (Request Handler):**

Die primären Controller-Aufgaben werden von den Klassen im Verzeichnis `src/Presentation/RequestHandlers/` wahrgenommen. Diese Klassen sind dafür zuständig, HTTP-Anfragen entgegenzunehmen, die entsprechende Logik anzustoßen und eine HTTP-Antwort zu generieren. Wie im Abschnitt "Routing-Mechanismen" und "Identifizierung von API-Endpunkten" detailliert beschrieben, werden diese Handler über `#[Route(...)]`-Attribute spezifischen URL-Pfaden und HTTP-Methoden zugeordnet.

Beispiele für Haupt-Controller-Pfade:

*   `src/Presentation/RequestHandlers/Api/`: Enthält Handler für die RESTful API-Endpunkte.
*   `src/Presentation/RequestHandlers/App/`: Enthält Handler für die Hauptanwendungsseiten (Dashboard, Editor-Ansichten etc.).
*   `src/Presentation/RequestHandlers/Admin/`: Enthält Handler für den Administrationsbereich.
*   `src/Presentation/RequestHandlers/Auth/`: Enthält Handler für Authentifizierungsprozesse (Login, Registrierung, Passwort-Reset-Seiten).
*   `src/Presentation/RequestHandlers/Installation/`: Handler für den Installationsprozess.

Jede Klasse in diesen Verzeichnissen, die eine `handle()`-Methode (oder eine ähnliche, durch ein Interface definierte Methode) implementiert und mit einem `#[Route(...)]`-Attribut versehen ist, agiert als Controller für die jeweilige Route.

**Service-Klassen:**

Service-Klassen kapseln die Geschäftslogik und Anwendungsfälle. Basierend auf der DDD-ähnlichen Struktur sind diese primär in den `Application/` und `Domain/` Unterverzeichnissen der einzelnen Module zu finden (`src/[ModulName]/Application/` und `src/[ModulName]/Domain/`).

*   **Anwendungs-Services (Use Cases):** Befinden sich typischerweise in `src/[ModulName]/Application/`. Oft sind dies Klassen, die Kommandos (Commands) entgegennehmen und Kommando-Handler (Command Handlers) implementieren oder direkt Anwendungsfälle ausführen. Beispiele:
    *   `src/User/Application/CommandHandlers/CreateUserCommandHandler.php`
    *   `src/Ai/Application/Services/ImageGenerationService.php` (hypothetisch, basierend auf Modulstruktur)
*   **Domain-Services:** Befinden sich in `src/[ModulName]/Domain/Services/`. Diese enthalten Geschäftslogik, die nicht natürlich einer einzelnen Entität oder einem Value Object zugeordnet werden kann.
*   **Repositories:** Definieren Schnittstellen für die Persistenz von Domain-Objekten (`src/[ModulName]/Domain/Repositories/`) und deren Implementierungen (`src/[ModulName]/Infrastructure/Repositories/`).
*   **Factories:** Zuständig für die Erstellung komplexer Objekte.

**Zentrale Anwendungsklasse und Service-Konfiguration:**

*   **`src/Application.php`**: Die zentrale Anwendungsklasse, die den DI-Container (`Easy\Container\Container`) verwaltet und Methoden zur Service-Registrierung (`set()`, `singleton()`, `bind()`) bereitstellt. Sie orchestriert auch das Booten der Anwendung durch Service Provider und Bootstrapper.
*   **`config/providers.php`**: Definiert Service Provider (`Shared\Infrastructure\ServiceProviderInterface`), die Dienste beim Container registrieren. Diese Provider sind oft modulspezifisch oder für bestimmte Infrastrukturkomponenten zuständig.
*   **`config/bootstrappers.php`**: Definiert Bootstrapper (`Shared\Infrastructure\BootstrapperInterface`), die beim Anwendungsstart ausgeführt werden, um Module zu initialisieren, Dienste zu konfigurieren oder andere Setup-Aufgaben durchzuführen. Beispiele:
    *   `DoctrineBootstrapper`: Konfiguriert Doctrine ORM und registriert den `EntityManager`.
    *   `RoutingBootstrapper`: Konfiguriert das Routing-System.
    *   Modulspezifische Bootstrapper wie `UserModuleBootstrapper`, `AiModuleBootstrapper` etc., die Dienste und Konfigurationen für ihre jeweiligen Module laden.

Die Identifizierung spezifischer "Haupt"-Service-Klassen hängt vom jeweiligen Anwendungsfall ab. Wichtige Services sind jedoch diejenigen, die über die Bootstrapper und Provider im DI-Container registriert und von den Controllern (Request Handlers) und anderen Services zur Erfüllung ihrer Aufgaben genutzt werden.

## 5. Routing-Mechanismen

Die Routing-Mechanismen in Aikeedo basieren auf dem `iziphp/router` Paket, wie im Technologie-Stack erwähnt, und werden durch den `RoutingBootstrapper` (`config/bootstrappers.php`) konfiguriert sowie durch den `ServerRequestHandler` (`src/Presentation/ServerRequestHandler.php`) genutzt.

**Kernkomponenten und Funktionsweise:**

1.  **`RoutingBootstrapper`** (siehe Details unter Abschnitt 3.2 `config`-Verzeichnis):
    *   Verwendet `Easy\Router\Dispatcher` als zentralen Dispatcher.
    *   Registriert Mapper, um Routen zu sammeln:
        *   `Easy\Router\Mapper\AttributeMapper`: Scannt das `src`-Verzeichnis nach PHP-Attributen (`#[Route(...)]`) in Klassen (typischerweise Request Handler), um Routen dynamisch zu definieren. Unterstützt Caching der Routen.
        *   `Easy\Router\Mapper\SimpleMapper`: Ermöglicht die programmatische Definition von Routen (z.B. für die Route `POST /rc`).
    *   Fügt möglicherweise Middlewares hinzu, wie z.B. `RoutePrefixerMiddleware`, um globale Pfadpräfixe (z.B. `/api`, `/admin`) zu handhaben.
    *   Registriert den konfigurierten `Dispatcher` im DI-Container.

2.  **`src/Presentation/ServerRequestHandler.php`** (siehe Details unter Abschnitt 3.1 Struktur des `src`-Verzeichnisses):
    *   Implementiert `Psr\Http\Server\RequestHandlerInterface`.
    *   Empfängt die HTTP-Anfrage.
    *   Nutzt den injizierten `Easy\Http\Server\DispatcherInterface` (welcher der konfigurierte `Easy\Router\Dispatcher` ist), um die passende Route für die Anfrage zu finden.
    *   Die `Route`-Attribute in den Request-Handler-Klassen definieren den Pfad, die HTTP-Methode(n) und optionale Parameter (z.B. `#[Route(path: '/users/[uuid:id]', method: RequestMethod::GET)]`).
    *   Nachdem eine Route gefunden wurde, werden Routenparameter extrahiert und dem Request-Objekt als Attribute hinzugefügt.
    *   Ein `Easy\HttpServerHandler\HttpServerHandler` wird mit dem eigentlichen Request-Handler der Route (die Controller-Klasse) und den zugehörigen Middlewares instanziiert.
    *   Die Anfrageverarbeitung wird an diesen `HttpServerHandler` delegiert, der den Middleware-Stack und den Request-Handler ausführt.

Die API-Endpunkte (siehe Abschnitt 7) werden größtenteils über diese `#[Route(...)]`-Attribute in den Klassen unter `src/Presentation/RequestHandlers/` definiert. Dies ermöglicht eine deklarative und gut auffindbare Art der Routendefinition.

## 6. Frontend-Komponentenstruktur und Interaktion mit dem Backend

Die Frontend-Struktur von Aikeedo basiert auf einer Kombination von serverseitig gerenderten Twig-Templates und clientseitiger Interaktivität durch Alpine.js. Tailwind CSS wird für das Styling verwendet.

**Technologien:**

*   **Build-Tool:** Vite (`vite.config.mjs`)
*   **JavaScript-Framework/Bibliotheken:**
    *   Alpine.js (^3.14.8) für reaktive UI-Komponenten.
    *   Tailwind CSS (^4.1.6) für das Styling.
    *   ApexCharts (^4.5.0) für Diagramme.
    *   Highlight.js für Syntax-Hervorhebung.
    *   Katex für mathematische Formeln.
    *   Wavesurfer.js für Audio-Wellenformen.
*   **CSS-Framework:** Tailwind CSS

**Verzeichnisstruktur relevant für das Frontend:**

*   **`resources/assets/`**: Enthält die unkompilierten Frontend-Assets.
    *   `css/`: CSS-Dateien, einschließlich des Haupteinstiegspunkts `index.css` und spezifischer Stile wie `icons.css`.
    *   `js/`: JavaScript-Dateien. Die Haupteinstiegspunkte für Vite sind:
        *   `base/index.js`
        *   `app/index.js`
        *   `auth/index.js`
        *   `admin/index.js`
        *   `install/index.js` (konditional)
        *   `api.js`: Enthält wahrscheinlich Funktionen für die Kommunikation mit Backend-APIs.
*   **`resources/views/`**: Enthält Twig-Templates, die vom PHP-Backend gerendert werden.
    *   `layouts/`: Basis-Layouts für verschiedene Seitentypen.
    *   `sections/`: Wiederverwendbare Teile von Seiten (z.B. Header, Footer, Sidebar).
    *   `snippets/`: Kleinere, oft wiederverwendbare UI-Komponenten oder Logikblöcke.
    *   `templates/`: Spezifische Seitentemplates für verschiedene Anwendungsbereiche (Auth, Admin, App etc.).
*   **`public/assets/`**: Das von Vite erzeugte Build-Verzeichnis für die kompilierten und optimierten Frontend-Assets.
*   **`vite.config.mjs`**: Konfigurationsdatei für Vite. Definiert die Eingabepunkte, das Ausgabeverzeichnis (`public`), und optimiert Abhängigkeiten.
*   **`package.json`**: Definiert Frontend-Abhängigkeiten (Alpine.js, Tailwind CSS, etc.) und Build-Skripte (`dev`, `build`).

**Interaktionsmodell Backend-Frontend:**

1.  **Serverseitiges Rendering:** Das PHP-Backend (Symfony/Iziphp-Komponenten) verarbeitet Anfragen und rendert Twig-Templates (`resources/views/`). Diese Templates generieren die initiale HTML-Struktur der Seite.
2.  **Asset-Einbindung:** Die gerenderten HTML-Seiten binden die von Vite kompilierten CSS- und JavaScript-Dateien aus dem `public/assets/`-Verzeichnis ein.
3.  **Clientseitige Initialisierung:** Nach dem Laden der Seite im Browser wird das JavaScript ausgeführt:
    *   Alpine.js initialisiert seine Komponenten. Alpine.js-Komponenten werden typischerweise direkt im HTML der Twig-Templates durch Attribute wie `x-data`, `x-init`, `x-on:click`, etc. definiert.
    *   Andere JavaScript-Bibliotheken (ApexCharts, Wavesurfer.js etc.) werden initialisiert und an die entsprechenden HTML-Elemente gebunden.
4.  **Dynamische Interaktionen:** Alpine.js übernimmt die dynamische Aktualisierung der Benutzeroberfläche basierend auf Benutzerinteraktionen oder Datenänderungen, ohne dass ein vollständiger Seiten-Neuladen erforderlich ist.
5.  **Backend-Kommunikation (API-Aufrufe):**
    *   Für Aktionen, die Daten vom Server benötigen oder Daten an den Server senden müssen (z.B. Formularübermittlungen, Laden von dynamischen Inhalten), werden AJAX-Anfragen (asynchrone JavaScript-Anfragen) an das Backend gesendet.
    *   Diese Anfragen zielen auf spezifische API-Endpunkte, die vom PHP-Backend bereitgestellt werden.
    *   Die Datei `resources/assets/js/api.js` könnte eine zentrale Rolle bei der Abwicklung dieser API-Aufrufe spielen, indem sie Wrapper-Funktionen oder eine standardisierte Methode zur Kommunikation mit dem Backend bereitstellt.
    *   Antworten vom Backend (oft im JSON-Format) werden vom clientseitigen JavaScript verarbeitet, um die Benutzeroberfläche entsprechend zu aktualisieren.

Diese Architektur ermöglicht eine schnelle initiale Ladezeit durch serverseitiges Rendering und eine reaktive, moderne Benutzererfahrung durch clientseitiges JavaScript, hauptsächlich mit Alpine.js.

- Identifizierung von API-Endpunkten. (Abgeschlossen)
## 7. Identifizierung von API-Endpunkten

Die API-Endpunkte in Aikeedo werden primär über PHP-Attribute (`#[Route(...)]`) in den Request-Handler-Klassen definiert. Diese befinden sich größtenteils im Verzeichnis `src/Presentation/RequestHandlers/`. Die Analyse der Suchergebnisse für Routendefinitionen zeigt eine klare Strukturierung der API-Endpunkte, oft unterteilt nach Modulen und Funktionalitäten.

**Haupt-API-Verzeichnisse und -Muster:**

*   **`src/Presentation/RequestHandlers/Api/`**: Dieses Verzeichnis scheint der zentrale Ort für die meisten RESTful API-Endpunkte zu sein. Es ist weiter unterteilt nach Modulen wie:
    *   `Account/`: Endpunkte für Benutzerkontenverwaltung (Login, Registrierung, Profilaktualisierung, Passwortänderung, API-Schlüssel, Affiliate-Informationen, E-Mail-Verifizierung).
    *   `Ai/`: Endpunkte für KI-Funktionen (Nachrichten, Bilder, Videos, Code-Vervollständigung, Transkriptionen, Klassifikationen, Kompositionen, Sprachisolierung).
    *   `Assistants/`: Endpunkte zur Verwaltung von KI-Assistenten (Auflisten, Zählen).
    *   `Auth/`: Endpunkte für Authentifizierung (Basic Auth, Passwort-Wiederherstellung, Registrierung).
    *   `Billing/`: Endpunkte für Abrechnung (Pläne auflisten/lesen, Bestellungen auflisten/zählen, Checkout, Abonnement kündigen).
    *   `Categories/`: Endpunkte zur Verwaltung von Kategorien (Auflisten, Lesen).
    *   `Library/`: Endpunkte für die Inhaltsbibliothek (Elemente auflisten, erstellen, lesen, aktualisieren, löschen, zählen).
    *   `Presets/`: Endpunkte zur Verwaltung von Vorlagen/Presets (Auflisten, Lesen, Zählen).
    *   `Voices/`: Endpunkte für Sprachgenerierung/Sprachklone (Auflisten, Erstellen, Aktualisieren, Löschen, Zählen).
    *   `Workspaces/`: Endpunkte zur Verwaltung von Arbeitsbereichen (Erstellen, Aktualisieren, Löschen, Einladungen, Nutzungsdaten).
*   **`src/Presentation/RequestHandlers/Admin/Api/`**: Dieses Verzeichnis enthält API-Endpunkte, die spezifisch für den Administrationsbereich sind. Ähnliche Unterteilung nach Modulen wie `Categories`, `Orders`, `Plans`, `Plugins`, `Presets`, `Reports`, `Subscriptions`, `Users`, `Voices`, `Workspaces`.
*   **Spezifische Handler für Webhooks und Callbacks:**
    *   `src/Presentation/RequestHandlers/WebhookRequestHandler.php`: Verarbeitet eingehende Webhooks von Drittanbietern (z.B. Zahlungs-Gateways).
        *   `POST /webhooks/[:gateway]`
    *   `src/Presentation/RequestHandlers/PaymentCallbackRequestHandler.php`: Verarbeitet Callbacks nach Zahlungsvorgängen.
        *   `GET /payment-callback/[uuid:oid]/[:gateway]`
        *   `POST /payment-callback/[uuid:oid]/[:gateway]`
    *   `src/Presentation/RequestHandlers/AuthCallbackRequestHandler.php`: Verarbeitet Callbacks von externen Authentifizierungsanbietern (OAuth etc.).
        *   `GET /auth/[*:provider]`
*   **Installations-API:**
    *   `src/Presentation/RequestHandlers/Installation/`: Enthält API-Endpunkte, die während des Installationsprozesses verwendet werden (Datenbank-Setup, Benutzererstellung, Umgebungsvariablen, Anforderungen prüfen).
        *   `POST /api/install/env`
        *   `POST /api/install/database`
        *   `POST /api/install/database/scheme`
        *   `POST /api/install/users`
        *   `POST /api/install/presets/import`
        *   `POST /api/install/activate`
        *   `GET /api/install/requirements`

**Typische HTTP-Methoden und Pfadstrukturen:**

*   **`GET`**: Zum Abrufen von Ressourcen (z.B. `/api/users`, `/api/plans/[uuid:id]`).
*   **`POST`**: Zum Erstellen neuer Ressourcen (z.B. `/api/users`, `/api/images`).
*   **`PUT` / `PATCH`**: Zum Aktualisieren bestehender Ressourcen (z.B. `/api/users/[uuid:id]`). Oft werden `POST` und `PUT`/`PATCH` synonym für Updates verwendet.
*   **`DELETE`**: Zum Löschen von Ressourcen (z.B. `/api/users/[uuid:id]`).
*   Pfade verwenden häufig UUIDs zur Identifizierung spezifischer Ressourcen (z.B. `/[uuid:id]`).
*   Viele API-Pfade scheinen unter einem gemeinsamen Präfix wie `/api/v1/` oder `/api/` zu liegen (dies muss noch genauer durch Analyse der Routing-Konfiguration im `RoutingBootstrapper` bestätigt werden, aber die Struktur der Handler-Klassen deutet stark darauf hin).

**Authentifizierung und Autorisierung:**

*   API-Endpunkte werden wahrscheinlich durch JWT (JSON Web Tokens) geschützt, wie durch die `firebase/php-jwt` Abhängigkeit und das `src/Presentation/Jwt/` Verzeichnis angedeutet.
*   Zugriffskontrollen (`src/Presentation/AccessControls/`) definieren, welche Benutzer welche Aktionen auf welchen Ressourcen durchführen dürfen.

**Beispiele für identifizierte API-Endpunkte (basierend auf Attributen):**

*   `GET /api/assistants/count` (Zählt Assistenten)
*   `POST /api/account/verification` (Sendet Verifizierungs-E-Mail)
*   `PUT /api/account/` (Aktualisiert Kontoinformationen)
*   `POST /api/ai/conversations/[uuid:cid]/messages` (Sendet eine Nachricht in einer Konversation)
*   `DELETE /api/voices/[uuid:id]` (Löscht eine Stimme)
*   `GET /admin/api/workspaces/` (Listet Workspaces im Admin-Bereich)
*   `POST /admin/api/presets/` (Erstellt ein neues Preset im Admin-Bereich)

Eine vollständige und exakte Liste aller API-Endpunkte mit ihren genauen Pfaden und Präfixen würde eine tiefere Analyse der `RoutingBootstrapper`-Klasse und der Art und Weise, wie die `Easy\Router\Dispatcher` die Routen aus den Attributen sammelt und registriert, erfordern. Die obige Analyse bietet jedoch einen sehr guten Überblick über die Struktur und die wichtigsten Endpunkte.

- Analyse der Plugin-funktionalität und Anforderungen an die korrekte Erstellung von Plugins für Aikeedo. (Abgeschlossen)
## 10. Event-Dispatching-Mechanismen

Das Event-Dispatching-System in Aikeedo ermöglicht eine entkoppelte Kommunikation zwischen verschiedenen Teilen der Anwendung. Wenn ein bestimmtes Ereignis eintritt (z.B. ein Benutzer wird erstellt, eine Bestellung wird bezahlt), kann ein Event ausgelöst werden. Andere Teile der Anwendung (Listener) können auf diese Events reagieren, ohne dass der Auslöser des Events die Listener direkt kennen muss.

**Kernkomponenten und Funktionsweise:**

1.  **Basis:** Das System basiert auf dem PSR-14 Standard (`psr/event-dispatcher`) und nutzt Komponenten, die unter dem Namespace `Easy\EventDispatcher` angesiedelt sind. Diese stammen wahrscheinlich aus der `iziphp/event-dispatcher`-Bibliothek oder einer eng verwandten Eigenentwicklung, die dem `Easy\` Namespace-Muster des Projekts folgt.

2.  **Service-Registrierung (`config/providers.php` und `src/Application.php`):
    *   Der `EventServiceProvider` (definiert in `config/providers.php`) ist dafür zuständig, die notwendigen Implementierungen für `Psr\EventDispatcher\EventDispatcherInterface` (konkret `Easy\EventDispatcher\EventDispatcher`) und `Psr\EventDispatcher\ListenerProviderInterface` (konkret `Easy\EventDispatcher\ListenerProvider`) im DI-Container zu registrieren.

3.  **Listener-Provider und Mapper (`Easy\EventDispatcher\ListenerProvider`):
    *   Der `ListenerProvider` ist dafür verantwortlich, alle relevanten Listener für ein gegebenes Event zu finden.
    *   Er verwendet verschiedene Mapper, um Listener zu entdecken:
        *   `Easy\EventDispatcher\Mapper\EventAttributeMapper`: Ermöglicht das Markieren von Event-Klassen mit Attributen (z.B. `#[Listener(MyListener::class)]`), um Listener direkt mit dem Event zu verknüpfen.
        *   `Easy\EventDispatcher\Mapper\ListenerAttributeMapper`: Ermöglicht das Markieren von Listener-Klassen oder -Methoden mit Attributen (z.B. `#[AsEventListener(event: MyEvent::class)]`), um sie Events zuzuordnen.
        *   `Easy\EventDispatcher\Mapper\ArrayMapper`: Erlaubt die programmatische Registrierung von Listenern für spezifische Events. Dies wird beispielsweise im `Stat\Infrastructure\StatModuleBootstrapper.php` verwendet, um Listener für `OrderPaidEvent`, `UserRegisteredEvent` etc. zu registrieren.

4.  **Definition von Events und Listenern:**
    *   **Events:** Sind einfache PHP-Klassen, die oft Daten über das Ereignis enthalten. Sie können das `Psr\EventDispatcher\StoppableEventInterface` implementieren, wenn sie die weitere Verarbeitung von Listenern stoppen können sollen.
    *   **Listeners:** Sind PHP-Klassen oder aufrufbare Methoden, die die Logik enthalten, die als Reaktion auf ein Event ausgeführt werden soll. Sie erhalten das Event-Objekt als Parameter.
        *   Listener können über Attribute (`#[AsEventListener]`) oder programmatisch (via `ArrayMapper` in einem Bootstrapper oder Service Provider) registriert werden.

5.  **Auslösen von Events (Dispatching):
    *   Um ein Event auszulösen, wird der `Psr\EventDispatcher\EventDispatcherInterface` per Dependency Injection in die Klasse injiziert, die das Event auslösen möchte.
    *   Die `dispatch()`-Methode des Event Dispatchers wird mit dem Event-Objekt als Argument aufgerufen.
    *   Beispiel:
        ```php
        // In einer Service-Klasse oder einem Command Handler
        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);
        ```
    *   Dies ist explizit in `cron.php` (`$dispatcher->dispatch(new CronEvent());`) und im `ModuleGenerator.php` zu sehen.

6.  **Abgrenzung zum Command Bus:**
    *   Es ist wichtig, den Event Dispatcher vom Command Bus (`Shared\Infrastructure\CommandBus\Dispatcher`) zu unterscheiden. Während der Command Bus dazu dient, Aktionen (Commands) an einen einzelnen Handler weiterzuleiten, dient der Event Dispatcher dazu, Ereignisse an potenziell mehrere, voneinander unabhängige Listener zu verteilen.
    *   Viele der Suchergebnisse für "Dispatcher" bezogen sich auf den Command Bus, der für die Ausführung von Anwendungsfällen zuständig ist.

7.  **Server-Sent Events (SSE):
    *   Neben dem anwendungsinternen PSR-14 Event-System gibt es auch eine Implementierung für Server-Sent Events (SSE) unter `Presentation/EventStream/Streamer.php`. Diese wird in API-Endpunkten wie `CompletionsApi.php` und `MessageApi.php` verwendet, um Echtzeit-Updates an den Client zu senden (z.B. während der Generierung von KI-Inhalten). Dies ist ein spezifischer Anwendungsfall von Eventing für die Client-Kommunikation und unterscheidet sich vom allgemeinen PSR-14 Event Dispatcher.

Zusammenfassend lässt sich sagen, dass Aikeedo ein robustes, auf PSR-14 basierendes Event-Dispatching-System verwendet, das eine lose Kopplung und Erweiterbarkeit der Anwendungslogik ermöglicht. Events werden ausgelöst, und registrierte Listener reagieren darauf, ohne dass direkte Abhängigkeiten zwischen den Komponenten bestehen müssen.

## 9. Datenbankstruktur (Doctrine Entities und Migrationen)

Aikeedo verwendet Doctrine ORM für die Datenbankinteraktion und das Schema-Management. Die Datenbankstruktur wird durch Doctrine Entities definiert und durch Migrationsdateien versioniert und aktualisiert.

**Doctrine Entities:**

Doctrine Entities sind PHP-Klassen, die Datenbanktabellen und deren Spalten auf Objekteigenschaften mappen. In Aikeedo werden Entitäten durch das PHP-Attribut `#[ORM\Entity]` (oder kurz `#[Entity]`, da Doctrine den `ORM` Namespace importiert) gekennzeichnet. Diese Entitäten befinden sich typischerweise in den `Domain/Entities/` Unterverzeichnissen der jeweiligen Module im `src/` Ordner.

Eine Suche nach `#[ORM\Entity]` im `src`-Verzeichnis hat eine Vielzahl von Entitätsklassen ergeben, die die Kernobjekte der Anwendung repräsentieren. Beispiele hierfür sind:

*   `User\Domain\Entities\UserEntity.php`
*   `Billing\Domain\Entities\PlanEntity.php`
*   `Billing\Domain\Entities\OrderEntity.php`
*   `Billing\Domain\Entities\SubscriptionEntity.php`
*   `Ai\Domain\Entities\ConversationEntity.php`
*   `Ai\Domain\Entities\MessageEntity.php`
*   `Ai\Domain\Entities\ImageEntity.php`
*   `Preset\Domain\Entities\PresetEntity.php`
*   `Workspace\Domain\Entities\WorkspaceEntity.php`
*   `File\Domain\Entities\FileEntity.php`
*   `Category\Domain\Entities\CategoryEntity.php`
*   `Affiliate\Domain\Entities\AffiliateEntity.php`
*   `Voice\Domain\Entities\VoiceEntity.php`
*   `Option\Domain\Entities\OptionEntity.php`
*   `Stat\Domain\Entities\UsageStatEntity.php`
*   Viele weitere Entitäten für spezifische KI-Artefakte (Document, Transcription, Speech, Video etc.) und Datasets.

Jede dieser Entitätsdateien enthält Definitionen für Spalten (`#[ORM\Column(...)]`), Beziehungen zu anderen Entitäten (`#[ORM\ManyToOne(...)]`, `#[ORM\OneToMany(...)]`, `#[ORM\ManyToMany(...)]`) und andere Doctrine-spezifische Metadaten.

**Doctrine Migrationen:**

Datenbankmigrationen werden verwendet, um Änderungen am Datenbankschema über die Zeit hinweg zu verwalten. Aikeedo nutzt `doctrine/migrations`.

*   Das Verzeichnis `migrations/` enthält die Migrationsdateien.
*   Es gibt Unterverzeichnisse für verschiedene Datenbanktreiber, z.B. `migrations/mysql/`.
*   Die Migrationsdateien sind PHP-Klassen, die von `Doctrine\Migrations\AbstractMigration` erben und `up()` sowie `down()` Methoden implementieren, um Schemaänderungen anzuwenden bzw. rückgängig zu machen.
*   Beispiele für Migrationsdateien sind `Version100.php`, `Version200.php` etc. Diese Dateien enthalten SQL-Anweisungen, um Tabellen zu erstellen, zu ändern oder zu löschen.
*   Die Konfiguration für Doctrine Migrations befindet sich wahrscheinlich in `config/migrations.php` und wird durch den `DoctrineBootstrapper` initialisiert.

**Zusammenfassend lässt sich sagen, dass die Datenbankstruktur von Aikeedo durch eine Vielzahl von Doctrine Entities definiert wird, die die verschiedenen Domänenobjekte der Anwendung abbilden. Änderungen an dieser Struktur werden systematisch über Doctrine Migrations verwaltet.** Eine genaue Analyse der einzelnen Entitätsbeziehungen und der in den Migrationen durchgeführten Schemaänderungen würde ein noch tieferes Verständnis der Datenmodelle ermöglichen.

## 3. Detaillierte Verzeichnisstruktur (Zusammenfassung)

Die detaillierte Untersuchung der Verzeichnisstruktur wurde im Laufe der Analyse verschiedener Komponenten und Konfigurationsdateien bereits umfassend durchgeführt. Die wichtigsten Erkenntnisse sind in den vorhergehenden Abschnitten dokumentiert, insbesondere:

*   **Abschnitt 2.3 Projektstruktur:** Gibt einen Überblick über die Hauptverzeichnisse im Stammverzeichnis des Projekts.
*   **Abschnitt 3.1 Struktur des `src`-Verzeichnisses:** Detailliert die modulare, DDD-inspirierte Struktur des PHP-Quellcodes.
*   **Abschnitt 3.2 Struktur des `config`-Verzeichnisses:** Beschreibt die Konfigurationsdateien für Bootstrapping, Service Provider, Befehle und Migrationen.
*   **Abschnitt 6 Frontend-Komponentenstruktur:** Erläutert die Struktur der Frontend-Assets in `resources/assets/` und `resources/views/` sowie die Build-Konfiguration.

Diese Abschnitte zusammen bieten ein umfassendes Bild der Organisation des Aikeedo-Projekts.

## 4. Haupt-Controller und Service-Klassen

Die Identifizierung der Haupt-Controller und Service-Klassen stützt sich auf die bereits durchgeführte Analyse der Projektstruktur, insbesondere des `src`-Verzeichnisses und der Konfigurationsdateien.

**Haupt-Controller (Request Handler):**

Die primären Controller-Aufgaben werden von den Klassen im Verzeichnis `src/Presentation/RequestHandlers/` wahrgenommen. Diese Klassen sind dafür zuständig, HTTP-Anfragen entgegenzunehmen, die entsprechende Logik anzustoßen und eine HTTP-Antwort zu generieren. Wie im Abschnitt "Routing-Mechanismen" und "Identifizierung von API-Endpunkten" detailliert beschrieben, werden diese Handler über `#[Route(...)]`-Attribute spezifischen URL-Pfaden und HTTP-Methoden zugeordnet.

Beispiele für Haupt-Controller-Pfade:

*   `src/Presentation/RequestHandlers/Api/`: Enthält Handler für die RESTful API-Endpunkte.
*   `src/Presentation/RequestHandlers/App/`: Enthält Handler für die Hauptanwendungsseiten (Dashboard, Editor-Ansichten etc.).
*   `src/Presentation/RequestHandlers/Admin/`: Enthält Handler für den Administrationsbereich.
*   `src/Presentation/RequestHandlers/Auth/`: Enthält Handler für Authentifizierungsprozesse (Login, Registrierung, Passwort-Reset-Seiten).
*   `src/Presentation/RequestHandlers/Installation/`: Handler für den Installationsprozess.

Jede Klasse in diesen Verzeichnissen, die eine `handle()`-Methode (oder eine ähnliche, durch ein Interface definierte Methode) implementiert und mit einem `#[Route(...)]`-Attribut versehen ist, agiert als Controller für die jeweilige Route.

**Service-Klassen:**

Service-Klassen kapseln die Geschäftslogik und Anwendungsfälle. Basierend auf der DDD-ähnlichen Struktur sind diese primär in den `Application/` und `Domain/` Unterverzeichnissen der einzelnen Module zu finden (`src/[ModulName]/Application/` und `src/[ModulName]/Domain/`).

*   **Anwendungs-Services (Use Cases):** Befinden sich typischerweise in `src/[ModulName]/Application/`. Oft sind dies Klassen, die Kommandos (Commands) entgegennehmen und Kommando-Handler (Command Handlers) implementieren oder direkt Anwendungsfälle ausführen. Beispiele:
    *   `src/User/Application/CommandHandlers/CreateUserCommandHandler.php`
    *   `src/Ai/Application/Services/ImageGenerationService.php` (hypothetisch, basierend auf Modulstruktur)
*   **Domain-Services:** Befinden sich in `src/[ModulName]/Domain/Services/`. Diese enthalten Geschäftslogik, die nicht natürlich einer einzelnen Entität oder einem Value Object zugeordnet werden kann.
*   **Repositories:** Definieren Schnittstellen für die Persistenz von Domain-Objekten (`src/[ModulName]/Domain/Repositories/`) und deren Implementierungen (`src/[ModulName]/Infrastructure/Repositories/`).
*   **Factories:** Zuständig für die Erstellung komplexer Objekte.

**Zentrale Anwendungsklasse und Service-Konfiguration:**

*   **`src/Application.php`**: Die zentrale Anwendungsklasse, die den DI-Container (`Easy\Container\Container`) verwaltet und Methoden zur Service-Registrierung (`set()`, `singleton()`, `bind()`) bereitstellt. Sie orchestriert auch das Booten der Anwendung durch Service Provider und Bootstrapper.
*   **`config/providers.php`**: Definiert Service Provider (`Shared\Infrastructure\ServiceProviderInterface`), die Dienste beim Container registrieren. Diese Provider sind oft modulspezifisch oder für bestimmte Infrastrukturkomponenten zuständig.
*   **`config/bootstrappers.php`**: Definiert Bootstrapper (`Shared\Infrastructure\BootstrapperInterface`), die beim Anwendungsstart ausgeführt werden, um Module zu initialisieren, Dienste zu konfigurieren oder andere Setup-Aufgaben durchzuführen. Beispiele:
    *   `DoctrineBootstrapper`: Konfiguriert Doctrine ORM und registriert den `EntityManager`.
    *   `RoutingBootstrapper`: Konfiguriert das Routing-System.
    *   Modulspezifische Bootstrapper wie `UserModuleBootstrapper`, `AiModuleBootstrapper` etc., die Dienste und Konfigurationen für ihre jeweiligen Module laden.

Die Identifizierung spezifischer "Haupt"-Service-Klassen hängt vom jeweiligen Anwendungsfall ab. Wichtige Services sind jedoch diejenigen, die über die Bootstrapper und Provider im DI-Container registriert und von den Controllern (Request Handlers) und anderen Services zur Erfüllung ihrer Aufgaben genutzt werden.

## 5. Routing-Mechanismen

Die Routing-Mechanismen in Aikeedo basieren auf dem `iziphp/router` Paket, wie im Technologie-Stack erwähnt, und werden durch den `RoutingBootstrapper` (`config/bootstrappers.php`) konfiguriert sowie durch den `ServerRequestHandler` (`src/Presentation/ServerRequestHandler.php`) genutzt.

**Kernkomponenten und Funktionsweise:**

1.  **`RoutingBootstrapper`** (siehe Details unter Abschnitt 3.2 `config`-Verzeichnis):
    *   Verwendet `Easy\Router\Dispatcher` als zentralen Dispatcher.
    *   Registriert Mapper, um Routen zu sammeln:
        *   `Easy\Router\Mapper\AttributeMapper`: Scannt das `src`-Verzeichnis nach PHP-Attributen (`#[Route(...)]`) in Klassen (typischerweise Request Handler), um Routen dynamisch zu definieren. Unterstützt Caching der Routen.
        *   `Easy\Router\Mapper\SimpleMapper`: Ermöglicht die programmatische Definition von Routen (z.B. für die Route `POST /rc`).
    *   Fügt möglicherweise Middlewares hinzu, wie z.B. `RoutePrefixerMiddleware`, um globale Pfadpräfixe (z.B. `/api`, `/admin`) zu handhaben.
    *   Registriert den konfigurierten `Dispatcher` im DI-Container.

2.  **`src/Presentation/ServerRequestHandler.php`** (siehe Details unter Abschnitt 3.1 Struktur des `src`-Verzeichnisses):
    *   Implementiert `Psr\Http\Server\RequestHandlerInterface`.
    *   Empfängt die HTTP-Anfrage.
    *   Nutzt den injizierten `Easy\Http\Server\DispatcherInterface` (welcher der konfigurierte `Easy\Router\Dispatcher` ist), um die passende Route für die Anfrage zu finden.
    *   Die `Route`-Attribute in den Request-Handler-Klassen definieren den Pfad, die HTTP-Methode(n) und optionale Parameter (z.B. `#[Route(path: '/users/[uuid:id]', method: RequestMethod::GET)]`).
    *   Nachdem eine Route gefunden wurde, werden Routenparameter extrahiert und dem Request-Objekt als Attribute hinzugefügt.
    *   Ein `Easy\HttpServerHandler\HttpServerHandler` wird mit dem eigentlichen Request-Handler der Route (die Controller-Klasse) und den zugehörigen Middlewares instanziiert.
    *   Die Anfrageverarbeitung wird an diesen `HttpServerHandler` delegiert, der den Middleware-Stack und den Request-Handler ausführt.

Die API-Endpunkte (siehe Abschnitt 7) werden größtenteils über diese `#[Route(...)]`-Attribute in den Klassen unter `src/Presentation/RequestHandlers/` definiert. Dies ermöglicht eine deklarative und gut auffindbare Art der Routendefinition.

## 6. Frontend-Komponentenstruktur und Interaktion mit dem Backend

Die Frontend-Struktur von Aikeedo basiert auf einer Kombination von serverseitig gerenderten Twig-Templates und clientseitiger Interaktivität durch Alpine.js. Tailwind CSS wird für das Styling verwendet.

**Technologien:**

*   **Build-Tool:** Vite (`vite.config.mjs`)
*   **JavaScript-Framework/Bibliotheken:**
    *   Alpine.js (^3.14.8) für reaktive UI-Komponenten.
    *   Tailwind CSS (^4.1.6) für das Styling.
    *   ApexCharts (^4.5.0) für Diagramme.
    *   Highlight.js für Syntax-Hervorhebung.
    *   Katex für mathematische Formeln.
    *   Wavesurfer.js für Audio-Wellenformen.
*   **CSS-Framework:** Tailwind CSS

**Verzeichnisstruktur relevant für das Frontend:**

*   **`resources/assets/`**: Enthält die unkompilierten Frontend-Assets.
    *   `css/`: CSS-Dateien, einschließlich des Haupteinstiegspunkts `index.css` und spezifischer Stile wie `icons.css`.
    *   `js/`: JavaScript-Dateien. Die Haupteinstiegspunkte für Vite sind:
        *   `base/index.js`
        *   `app/index.js`
        *   `auth/index.js`
        *   `admin/index.js`
        *   `install/index.js` (konditional)
        *   `api.js`: Enthält wahrscheinlich Funktionen für die Kommunikation mit Backend-APIs.
*   **`resources/views/`**: Enthält Twig-Templates, die vom PHP-Backend gerendert werden.
    *   `layouts/`: Basis-Layouts für verschiedene Seitentypen.
    *   `sections/`: Wiederverwendbare Teile von Seiten (z.B. Header, Footer, Sidebar).
    *   `snippets/`: Kleinere, oft wiederverwendbare UI-Komponenten oder Logikblöcke.
    *   `templates/`: Spezifische Seitentemplates für verschiedene Anwendungsbereiche (Auth, Admin, App etc.).
*   **`public/assets/`**: Das von Vite erzeugte Build-Verzeichnis für die kompilierten und optimierten Frontend-Assets.
*   **`vite.config.mjs`**: Konfigurationsdatei für Vite. Definiert die Eingabepunkte, das Ausgabeverzeichnis (`public`), und optimiert Abhängigkeiten.
*   **`package.json`**: Definiert Frontend-Abhängigkeiten (Alpine.js, Tailwind CSS, etc.) und Build-Skripte (`dev`, `build`).

**Interaktionsmodell Backend-Frontend:**

1.  **Serverseitiges Rendering:** Das PHP-Backend (Symfony/Iziphp-Komponenten) verarbeitet Anfragen und rendert Twig-Templates (`resources/views/`). Diese Templates generieren die initiale HTML-Struktur der Seite.
2.  **Asset-Einbindung:** Die gerenderten HTML-Seiten binden die von Vite kompilierten CSS- und JavaScript-Dateien aus dem `public/assets/`-Verzeichnis ein.
3.  **Clientseitige Initialisierung:** Nach dem Laden der Seite im Browser wird das JavaScript ausgeführt:
    *   Alpine.js initialisiert seine Komponenten. Alpine.js-Komponenten werden typischerweise direkt im HTML der Twig-Templates durch Attribute wie `x-data`, `x-init`, `x-on:click`, etc. definiert.
    *   Andere JavaScript-Bibliotheken (ApexCharts, Wavesurfer.js etc.) werden initialisiert und an die entsprechenden HTML-Elemente gebunden.
4.  **Dynamische Interaktionen:** Alpine.js übernimmt die dynamische Aktualisierung der Benutzeroberfläche basierend auf Benutzerinteraktionen oder Datenänderungen, ohne dass ein vollständiger Seiten-Neuladen erforderlich ist.
5.  **Backend-Kommunikation (API-Aufrufe):**
    *   Für Aktionen, die Daten vom Server benötigen oder Daten an den Server senden müssen (z.B. Formularübermittlungen, Laden von dynamischen Inhalten), werden AJAX-Anfragen (asynchrone JavaScript-Anfragen) an das Backend gesendet.
    *   Diese Anfragen zielen auf spezifische API-Endpunkte, die vom PHP-Backend bereitgestellt werden.
    *   Die Datei `resources/assets/js/api.js` könnte eine zentrale Rolle bei der Abwicklung dieser API-Aufrufe spielen, indem sie Wrapper-Funktionen oder eine standardisierte Methode zur Kommunikation mit dem Backend bereitstellt.
    *   Antworten vom Backend (oft im JSON-Format) werden vom clientseitigen JavaScript verarbeitet, um die Benutzeroberfläche entsprechend zu aktualisieren.

Diese Architektur ermöglicht eine schnelle initiale Ladezeit durch serverseitiges Rendering und eine reaktive, moderne Benutzererfahrung durch clientseitiges JavaScript, hauptsächlich mit Alpine.js.

- Identifizierung von API-Endpunkten. (Abgeschlossen)
## 7. Identifizierung von API-Endpunkten

Die API-Endpunkte in Aikeedo werden primär über PHP-Attribute (`#[Route(...)]`) in den Request-Handler-Klassen definiert. Diese befinden sich größtenteils im Verzeichnis `src/Presentation/RequestHandlers/`. Die Analyse der Suchergebnisse für Routendefinitionen zeigt eine klare Strukturierung der API-Endpunkte, oft unterteilt nach Modulen und Funktionalitäten.

**Haupt-API-Verzeichnisse und -Muster:**

*   **`src/Presentation/RequestHandlers/Api/`**: Dieses Verzeichnis scheint der zentrale Ort für die meisten RESTful API-Endpunkte zu sein. Es ist weiter unterteilt nach Modulen wie:
    *   `Account/`: Endpunkte für Benutzerkontenverwaltung (Login, Registrierung, Profilaktualisierung, Passwortänderung, API-Schlüssel, Affiliate-Informationen, E-Mail-Verifizierung).
    *   `Ai/`: Endpunkte für KI-Funktionen (Nachrichten, Bilder, Videos, Code-Vervollständigung, Transkriptionen, Klassifikationen, Kompositionen, Sprachisolierung).
    *   `Assistants/`: Endpunkte zur Verwaltung von KI-Assistenten (Auflisten, Zählen).
    *   `Auth/`: Endpunkte für Authentifizierung (Basic Auth, Passwort-Wiederherstellung, Registrierung).
    *   `Billing/`: Endpunkte für Abrechnung (Pläne auflisten/lesen, Bestellungen auflisten/zählen, Checkout, Abonnement kündigen).
    *   `Categories/`: Endpunkte zur Verwaltung von Kategorien (Auflisten, Lesen).
    *   `Library/`: Endpunkte für die Inhaltsbibliothek (Elemente auflisten, erstellen, lesen, aktualisieren, löschen, zählen).
    *   `Presets/`: Endpunkte zur Verwaltung von Vorlagen/Presets (Auflisten, Lesen, Zählen).
    *   `Voices/`: Endpunkte für Sprachgenerierung/Sprachklone (Auflisten, Erstellen, Aktualisieren, Löschen, Zählen).
    *   `Workspaces/`: Endpunkte zur Verwaltung von Arbeitsbereichen (Erstellen, Aktualisieren, Löschen, Einladungen, Nutzungsdaten).
*   **`src/Presentation/RequestHandlers/Admin/Api/`**: Dieses Verzeichnis enthält API-Endpunkte, die spezifisch für den Administrationsbereich sind. Ähnliche Unterteilung nach Modulen wie `Categories`, `Orders`, `Plans`, `Plugins`, `Presets`, `Reports`, `Subscriptions`, `Users`, `Voices`, `Workspaces`.
*   **Spezifische Handler für Webhooks und Callbacks:**
    *   `src/Presentation/RequestHandlers/WebhookRequestHandler.php`: Verarbeitet eingehende Webhooks von Drittanbietern (z.B. Zahlungs-Gateways).
        *   `POST /webhooks/[:gateway]`
    *   `src/Presentation/RequestHandlers/PaymentCallbackRequestHandler.php`: Verarbeitet Callbacks nach Zahlungsvorgängen.
        *   `GET /payment-callback/[uuid:oid]/[:gateway]`
        *   `POST /payment-callback/[uuid:oid]/[:gateway]`
    *   `src/Presentation/RequestHandlers/AuthCallbackRequestHandler.php`: Verarbeitet Callbacks von externen Authentifizierungsanbietern (OAuth etc.).
        *   `GET /auth/[*:provider]`
*   **Installations-API:**
    *   `src/Presentation/RequestHandlers/Installation/`: Enthält API-Endpunkte, die während des Installationsprozesses verwendet werden (Datenbank-Setup, Benutzererstellung, Umgebungsvariablen, Anforderungen prüfen).
        *   `POST /api/install/env`
        *   `POST /api/install/database`
        *   `POST /api/install/database/scheme`
        *   `POST /api/install/users`
        *   `POST /api/install/presets/import`
        *   `POST /api/install/activate`
        *   `GET /api/install/requirements`

**Typische HTTP-Methoden und Pfadstrukturen:**

*   **`GET`**: Zum Abrufen von Ressourcen (z.B. `/api/users`, `/api/plans/[uuid:id]`).
*   **`POST`**: Zum Erstellen neuer Ressourcen (z.B. `/api/users`, `/api/images`).
*   **`PUT` / `PATCH`**: Zum Aktualisieren bestehender Ressourcen (z.B. `/api/users/[uuid:id]`). Oft werden `POST` und `PUT`/`PATCH` synonym für Updates verwendet.
*   **`DELETE`**: Zum Löschen von Ressourcen (z.B. `/api/users/[uuid:id]`).
*   Pfade verwenden häufig UUIDs zur Identifizierung spezifischer Ressourcen (z.B. `/[uuid:id]`).
*   Viele API-Pfade scheinen unter einem gemeinsamen Präfix wie `/api/v1/` oder `/api/` zu liegen (dies muss noch genauer durch Analyse der Routing-Konfiguration im `RoutingBootstrapper` bestätigt werden, aber die Struktur der Handler-Klassen deutet stark darauf hin).

**Authentifizierung und Autorisierung:**

*   API-Endpunkte werden wahrscheinlich durch JWT (JSON Web Tokens) geschützt, wie durch die `firebase/php-jwt` Abhängigkeit und das `src/Presentation/Jwt/` Verzeichnis angedeutet.
*   Zugriffskontrollen (`src/Presentation/AccessControls/`) definieren, welche Benutzer welche Aktionen auf welchen Ressourcen durchführen dürfen.

**Beispiele für identifizierte API-Endpunkte (basierend auf Attributen):**

*   `GET /api/assistants/count` (Zählt Assistenten)
*   `POST /api/account/verification` (Sendet Verifizierungs-E-Mail)
*   `PUT /api/account/` (Aktualisiert Kontoinformationen)
*   `POST /api/ai/conversations/[uuid:cid]/messages` (Sendet eine Nachricht in einer Konversation)
*   `DELETE /api/voices/[uuid:id]` (Löscht eine Stimme)
*   `GET /admin/api/workspaces/` (Listet Workspaces im Admin-Bereich)
*   `POST /admin/api/presets/` (Erstellt ein neues Preset im Admin-Bereich)

Eine vollständige und exakte Liste aller API-Endpunkte mit ihren genauen Pfaden und Präfixen würde eine tiefere Analyse der `RoutingBootstrapper`-Klasse und der Art und Weise, wie die `Easy\Router\Dispatcher` die Routen aus den Attributen sammelt und registriert, erfordern. Die obige Analyse bietet jedoch einen sehr guten Überblick über die Struktur und die wichtigsten Endpunkte.

- Analyse der Plugin-funktionalität und Anforderungen an die korrekte Erstellung von Plugins für Aikeedo. (Abgeschlossen)
## 7. Identifizierung von API-Endpunkten

Die API-Endpunkte in Aikeedo werden primär über PHP-Attribute (`#[Route(...)]`) in den Request-Handler-Klassen definiert. Diese befinden sich größtenteils im Verzeichnis `src/Presentation/RequestHandlers/`. Die Analyse der Suchergebnisse für Routendefinitionen zeigt eine klare Strukturierung der API-Endpunkte, oft unterteilt nach Modulen und Funktionalitäten.

**Haupt-API-Verzeichnisse und -Muster:**

*   **`src/Presentation/RequestHandlers/Api/`**: Dieses Verzeichnis scheint der zentrale Ort für die meisten RESTful API-Endpunkte zu sein. Es ist weiter unterteilt nach Modulen wie:
    *   `Account/`: Endpunkte für Benutzerkontenverwaltung (Login, Registrierung, Profilaktualisierung, Passwortänderung, API-Schlüssel, Affiliate-Informationen, E-Mail-Verifizierung).
    *   `Ai/`: Endpunkte für KI-Funktionen (Nachrichten, Bilder, Videos, Code-Vervollständigung, Transkriptionen, Klassifikationen, Kompositionen, Sprachisolierung).
    *   `Assistants/`: Endpunkte zur Verwaltung von KI-Assistenten (Auflisten, Zählen).
    *   `Auth/`: Endpunkte für Authentifizierung (Basic Auth, Passwort-Wiederherstellung, Registrierung).
    *   `Billing/`: Endpunkte für Abrechnung (Pläne auflisten/lesen, Bestellungen auflisten/zählen, Checkout, Abonnement kündigen).
    *   `Categories/`: Endpunkte zur Verwaltung von Kategorien (Auflisten, Lesen).
    *   `Library/`: Endpunkte für die Inhaltsbibliothek (Elemente auflisten, erstellen, lesen, aktualisieren, löschen, zählen).
    *   `Presets/`: Endpunkte zur Verwaltung von Vorlagen/Presets (Auflisten, Lesen, Zählen).
    *   `Voices/`: Endpunkte für Sprachgenerierung/Sprachklone (Auflisten, Erstellen, Aktualisieren, Löschen, Zählen).
    *   `Workspaces/`: Endpunkte zur Verwaltung von Arbeitsbereichen (Erstellen, Aktualisieren, Löschen, Einladungen, Nutzungsdaten).
*   **`src/Presentation/RequestHandlers/Admin/Api/`**: Dieses Verzeichnis enthält API-Endpunkte, die spezifisch für den Administrationsbereich sind. Ähnliche Unterteilung nach Modulen wie `Categories`, `Orders`, `Plans`, `Plugins`, `Presets`, `Reports`, `Subscriptions`, `Users`, `Voices`, `Workspaces`.
*   **Spezifische Handler für Webhooks und Callbacks:**
    *   `src/Presentation/RequestHandlers/WebhookRequestHandler.php`: Verarbeitet eingehende Webhooks von Drittanbietern (z.B. Zahlungs-Gateways).
        *   `POST /webhooks/[:gateway]`
    *   `src/Presentation/RequestHandlers/PaymentCallbackRequestHandler.php`: Verarbeitet Callbacks nach Zahlungsvorgängen.
        *   `GET /payment-callback/[uuid:oid]/[:gateway]`
        *   `POST /payment-callback/[uuid:oid]/[:gateway]`
    *   `src/Presentation/RequestHandlers/AuthCallbackRequestHandler.php`: Verarbeitet Callbacks von externen Authentifizierungsanbietern (OAuth etc.).
        *   `GET /auth/[*:provider]`
*   **Installations-API:**
    *   `src/Presentation/RequestHandlers/Installation/`: Enthält API-Endpunkte, die während des Installationsprozesses verwendet werden (Datenbank-Setup, Benutzererstellung, Umgebungsvariablen, Anforderungen prüfen).
        *   `POST /api/install/env`
        *   `POST /api/install/database`
        *   `POST /api/install/database/scheme`
        *   `POST /api/install/users`
        *   `POST /api/install/presets/import`
        *   `POST /api/install/activate`
        *   `GET /api/install/requirements`

**Typische HTTP-Methoden und Pfadstrukturen:**

*   **`GET`**: Zum Abrufen von Ressourcen (z.B. `/api/users`, `/api/plans/[uuid:id]`).
*   **`POST`**: Zum Erstellen neuer Ressourcen (z.B. `/api/users`, `/api/images`).
*   **`PUT` / `PATCH`**: Zum Aktualisieren bestehender Ressourcen (z.B. `/api/users/[uuid:id]`). Oft werden `POST` und `PUT`/`PATCH` synonym für Updates verwendet.
*   **`DELETE`**: Zum Löschen von Ressourcen (z.B. `/api/users/[uuid:id]`).
*   Pfade verwenden häufig UUIDs zur Identifizierung spezifischer Ressourcen (z.B. `/[uuid:id]`).
*   Viele API-Pfade scheinen unter einem gemeinsamen Präfix wie `/api/v1/` oder `/api/` zu liegen (dies muss noch genauer durch Analyse der Routing-Konfiguration im `RoutingBootstrapper` bestätigt werden, aber die Struktur der Handler-Klassen deutet stark darauf hin).

**Authentifizierung und Autorisierung:**

*   API-Endpunkte werden wahrscheinlich durch JWT (JSON Web Tokens) geschützt, wie durch die `firebase/php-jwt` Abhängigkeit und das `src/Presentation/Jwt/` Verzeichnis angedeutet.
*   Zugriffskontrollen (`src/Presentation/AccessControls/`) definieren, welche Benutzer welche Aktionen auf welchen Ressourcen durchführen dürfen.

**Beispiele für identifizierte API-Endpunkte (basierend auf Attributen):**

*   `GET /api/assistants/count` (Zählt Assistenten)
*   `POST /api/account/verification` (Sendet Verifizierungs-E-Mail)
*   `PUT /api/account/` (Aktualisiert Kontoinformationen)
*   `POST /api/ai/conversations/[uuid:cid]/messages` (Sendet eine Nachricht in einer Konversation)
*   `DELETE /api/voices/[uuid:id]` (Löscht eine Stimme)
*   `GET /admin/api/workspaces/` (Listet Workspaces im Admin-Bereich)
*   `POST /admin/api/presets/` (Erstellt ein neues Preset im Admin-Bereich)

Eine vollständige und exakte Liste aller API-Endpunkte mit ihren genauen Pfaden und Präfixen würde eine tiefere Analyse der `RoutingBootstrapper`-Klasse und der Art und Weise, wie die `Easy\Router\Dispatcher` die Routen aus den Attributen sammelt und registriert, erfordern. Die obige Analyse bietet jedoch einen sehr guten Überblick über die Struktur und die wichtigsten Endpunkte.

- Analyse der Plugin-funktionalität und Anforderungen an die korrekte Erstellung von Plugins für Aikeedo. (Abgeschlossen)

---
## 8. Plugin-Funktionalität und Anforderungen

Aikeedo verfügt über ein Plugin-System, das es ermöglicht, die Kernfunktionalität der Anwendung zu erweitern. Die Plugin-Verwaltung und -Logik ist hauptsächlich im Verzeichnis `src/Plugin/` angesiedelt.

**Kernkomponenten des Plugin-Systems:**

*   **`src/Plugin/Domain/PluginInterface.php`**: Definiert den Vertrag, den jedes Plugin erfüllen muss. Es enthält eine einzige Methode:
    *   `boot(Context $context): void`: Diese Methode wird beim Start der Anwendung für jedes aktive Plugin aufgerufen, nachdem die grundlegenden Dienste initialisiert wurden, aber bevor die HTTP-Anfrageverarbeitung beginnt. Sie dient dazu, dass Plugins ihre Dienste registrieren, Event-Listener anhängen oder andere Initialisierungsaufgaben durchführen können.
*   **`src/Plugin/Domain/Context.php`**: Stellt den Kontext bereit, der an die `boot()`-Methode eines Plugins übergeben wird. Dieser Kontext enthält wahrscheinlich Zugriff auf den DI-Container, die Anwendungskonfiguration und andere wichtige Dienste, die ein Plugin für seine Initialisierung benötigt.
*   **`src/Plugin/Infrastructure/PluginModuleBootstrapper.php`**: Dieser Bootstrapper ist verantwortlich für das Auffinden, Laden und Initialisieren aller Plugins während des Anwendungsstarts.
    *   Er verwendet `PluginFinder`, um nach Plugins im Verzeichnis `extra/extensions/` zu suchen.
    *   Für jedes gefundene Plugin wird der `PluginLoader` verwendet, um die Hauptklasse des Plugins zu laden und zu instanziieren.
    *   Anschließend wird die `boot()`-Methode des Plugins aufgerufen.
*   **`src/Plugin/Infrastructure/PluginFinder.php`**: Durchsucht das Plugin-Verzeichnis (`extra/extensions/`) nach gültigen Plugin-Strukturen (wahrscheinlich basierend auf dem Vorhandensein einer `composer.json`-Datei und einer definierten Haupt-Plugin-Klasse).
*   **`src/Plugin/Infrastructure/PluginLoader.php`**: Lädt die Hauptklasse eines Plugins und stellt sicher, dass sie `PluginInterface` implementiert.
*   **`src/Plugin/Application/`**: Enthält Kommando- und Kommando-Handler-Klassen für die Verwaltung von Plugins über die Konsole (z.B. Installieren, Deinstallieren, Auflisten, Aktualisieren).
*   **`extra/extensions/`**: Das Standardverzeichnis, in dem Plugins abgelegt werden. Jedes Plugin befindet sich typischerweise in einem eigenen Unterverzeichnis (z.B. `extra/extensions/vendor/plugin-name/`).

**Anforderungen an die Erstellung eines Plugins:**

1.  **Verzeichnisstruktur:**
    *   Plugins sollten im Verzeichnis `extra/extensions/` in einer Struktur wie `vendor_name/plugin_name/` abgelegt werden (z.B. `aicent/cost-preview-plugin/`).
2.  **`composer.json`:**
    *   Jedes Plugin benötigt eine eigene `composer.json`-Datei.
    *   Diese Datei muss Metadaten über das Plugin enthalten, wie Name, Beschreibung, Version, Autor und die Haupt-Plugin-Klasse (Entry Class), die `PluginInterface` implementiert. Die `PluginValidationService.php` deutet auf die Validierung dieser Metadaten hin.
    *   Sie definiert auch die Abhängigkeiten des Plugins.
3.  **Haupt-Plugin-Klasse:**
    *   Muss das `Plugin\Domain\PluginInterface` implementieren.
    *   Muss eine `boot(Context $context): void` Methode definieren, die die Initialisierungslogik des Plugins enthält.
4.  **Hooks (optional):**
    *   Das System sieht Interfaces für verschiedene Lebenszyklus-Hooks vor (`InstallHookInterface`, `UninstallHookInterface`, `ActivateHookInterface`, `DeactivateHookInterface`). Plugins können diese Interfaces implementieren, um bei bestimmten Ereignissen (Installation, Deinstallation, Aktivierung, Deaktivierung) benutzerdefinierte Aktionen auszuführen.
5.  **Service-Registrierung und Konfiguration:**
    *   Innerhalb der `boot()`-Methode können Plugins Dienste beim DI-Container registrieren, Routen hinzufügen, Event-Listener konfigurieren, Twig-Erweiterungen laden oder andere Modifikationen am System vornehmen.
6.  **Namenskonventionen und Autoloading:**
    *   Plugins sollten PSR-4 Autoloading-Standards folgen, die in ihrer `composer.json` definiert sind.

**Beispiel für ein Plugin (`extra/extensions/aicent/cost-preview-plugin/`):**

Obwohl der genaue Inhalt dieses Beispiel-Plugins nicht eingesehen wurde, deutet seine Existenz darauf hin, dass es als Referenz für die Plugin-Entwicklung dienen könnte.

**Themes als spezielle Plugins:**

Der `PluginModuleBootstrapper` lädt auch Themes. Themes scheinen eine spezielle Art von Plugin zu sein, die sich im `extra/extensions/` Verzeichnis befinden (z.B. `heyaikeedo/default`). Sie erweitern Twig um spezifische Pfade und möglicherweise auch Funktionen über die `ThemeExtension`.

**Zusammenfassend lässt sich sagen, dass das Plugin-System von Aikeedo modular aufgebaut ist und Entwicklern klare Schnittstellen und Konventionen bietet, um die Anwendung zu erweitern. Die `PluginInterface` und die `composer.json` sind zentrale Elemente für die Entwicklung eines jeden Plugins.**