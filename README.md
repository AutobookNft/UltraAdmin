# UltraAdmin

## Disclaimer
UltraAdmin è attualmente in fase di sviluppo e ha uno scopo principalmente didattico. Questa applicazione è stata progettata per approfondire e consolidare la conoscenza di Laravel, delle sue best practices e dei principi avanzati di sviluppo software, come l’iniezione delle dipendenze, la gestione centralizzata delle configurazioni e l’architettura basata su kernel. UltraAdmin non è ancora pronto per un utilizzo in produzione, e tutte le funzionalità implementate sono pensate per l'apprendimento e la sperimentazione in un ambiente di sviluppo.


**UltraAdmin** (versione 0.0.2) è un pannello di amministrazione modulare e leggero, attualmente in fase di sviluppo, creato per l'orchestrazione delle librerie `Ultra`. Progettato per semplificare la configurazione e il controllo delle dipendenze, UltraAdmin offre un ambiente centralizzato per la gestione delle librerie `Ultra` con un’interfaccia intuitiva, ottimizzata per progetti complessi e ambienti di produzione.

## Caratteristiche Principali

- **Architettura Basata su Kernel**: La gestione dell’applicazione avviene tramite un kernel centralizzato, che registra e avvia i vari service provider, semplificando la struttura e migliorando l’efficienza e modularità del codice.

- **Gestione delle Librerie**: La dashboard di UltraAdmin consente di visualizzare, aggiungere, modificare e rimuovere le librerie Ultra. Ogni libreria può essere amministrata con i dettagli specifici, inclusi metadati, versioni e dipendenze.

- **Configurazione Centralizzata**: Con `UltraConfigManager`, è possibile caricare e modificare le configurazioni di tutte le librerie in un’unica posizione, semplificando la gestione di variabili critiche e riducendo i conflitti.

- **Service Container e Dependency Injection**: UltraAdmin sfrutta un **Service Container** con supporto per l’autowiring e l’iniezione delle dipendenze, mantenendo il codice modulare e altamente manutenibile.

- **Sistema di Logging Avanzato**: Grazie a `UltraLogManager`, tutte le attività rilevanti sono monitorabili tramite log. UltraAdmin consente la visualizzazione diretta dei log nella dashboard per una diagnostica immediata e una gestione delle ottimizzazioni.

- **Gestione Versioni e Dipendenze**: UltraAdmin supporta la gestione delle versioni (`major`, `minor`, `patch`) e delle dipendenze tra librerie, garantendo compatibilità e controllo sugli aggiornamenti di ogni componente.

- **Automazione della Pubblicazione**: Con uno script dedicato, UltraAdmin facilita la pubblicazione delle nuove versioni delle librerie su Packagist, riducendo errori e accelerando il processo.

- **Interfaccia di Monitoraggio**: La dashboard mostra metriche, stato delle librerie e gestione utenti. Il sistema rileva automaticamente e gestisce le librerie con prefisso `ultra_fc_`, rendendo l’uso efficiente per la gestione di librerie simili.

- **Sicurezza Potenziata**: Operazioni critiche come la pubblicazione e modifica delle configurazioni sono protette da un sistema di autenticazione e autorizzazione avanzato, garantendo l’accesso solo agli utenti abilitati.

## Perché UltraAdmin?

UltraAdmin è progettato per fornire un sistema di amministrazione sicuro, flessibile e conforme agli standard di eccellenza del settore, che semplifica la gestione delle librerie Ultra in modo centralizzato. Ogni libreria Ultra è sinonimo di sicurezza, eleganza e pulizia del codice, e UltraAdmin aiuta a mantenere queste qualità in un ambiente coeso e ben organizzato.

L'obiettivo principale è fornire un’esperienza di amministrazione intuitiva e potente che consenta agli utenti di concentrarsi sullo sviluppo delle proprie applicazioni senza dover gestire manualmente complesse configurazioni.

## Installazione

1. **Clonare il repository**:
   ```sh
   git clone https://github.com/fabiocherici/ultra-admin.git
   cd ultra-admin
   ```

2. **Installare le dipendenze**:
   Usa Composer per installare le dipendenze.
   ```sh
   composer install
   ```

3. **Configurare il file `.env`**:
   Crea un file `.env` partendo dall’esempio `.env.example` e configura i parametri necessari, come le credenziali del database.

4. **Esegui il setup iniziale**:
   ```sh
   php artisan ultraadmin:setup
   ```
   Questo comando esegue i task iniziali, come la migrazione del database e la pubblicazione dei file di configurazione.

## Utilizzo

UltraAdmin fornisce una **interfaccia web** per la gestione delle librerie Ultra. Dopo l'installazione, puoi accedere alla dashboard principale tramite il browser (ad esempio, `http://localhost:8000`).

Attraverso la dashboard, è possibile:
- **Visualizzare e modificare** le configurazioni delle librerie
- **Gestire le versioni** e le dipendenze delle librerie
- **Monitorare i log e lo stato del sistema**
- **Automatizzare la pubblicazione** su Packagist

## Note di Rilascio

**Versione 0.0.2**:
- Introduzione del kernel per la gestione centralizzata dei provider e delle risorse.
- Nuova homepage con navbar integrata per una navigazione più intuitiva.
- Miglioramento della modularità con rotte gestite dinamicamente tramite il `RouteServiceProvider`.

## Descrizione dei Componenti Principali

### Core
Contiene i componenti fondamentali del framework. Questi componenti formano le "fondamenta" del sistema e sono utilizzati da tutti gli altri moduli.

- **Kernel**: Gestisce il ciclo di vita dell'applicazione
- **Container**: Implementa il pattern Dependency Injection
- **ServiceProvider**: Classe base per la registrazione dei servizi
- **Bootstrap**: Gestisce l'avvio dell'applicazione

### Framework
Contiene i componenti di livello superiore che si basano sul Core. Questi moduli forniscono funzionalità specifiche come routing, database, ecc.

- **Database**: Gestione delle connessioni e delle query al database
- **Routing**: Gestione delle rotte dell'applicazione
- **Http**: Gestione delle richieste e risposte HTTP

### Providers
Contiene i service provider specifici dell'applicazione. Questi provider utilizzano i componenti Core e Framework per registrare e configurare i servizi dell'applicazione.

## Convenzioni di Codice

- I namespace seguono la struttura delle cartelle (es: `App\Core`, `App\Framework`)
- Ogni classe ha una singola responsabilità
- I nomi delle classi utilizzano il PascalCase
- I metodi utilizzano il camelCase
- Le proprietà private/protected iniziano con underscore (es: `_container`)

## Sicurezza

Il framework implementa diverse misure di sicurezza:
- Protezione contro XSS
- Protezione contro CSRF
- Sanitizzazione degli input
- Prepared statements per le query SQL

## Contribuire

Questo è un progetto didattico personale, ma suggerimenti e feedback sono sempre benvenuti.

## Note di Sviluppo

Questo framework è stato creato per scopi didattici e non è inteso per uso in produzione. È un esercizio per comprendere meglio i meccanismi interni di un framework PHP moderno.


app/
├── Core/ # Componenti fondamentali del framework
│ ├── Kernel.php # Gestisce il bootstrap dell'applicazione
│ ├── Container.php # Implementazione del container IoC
│ ├── ServiceProvider.php # Classe base per i service provider
│ └── Bootstrap/ # Componenti di inizializzazione
│ └── Application.php
│
├── Framework/ # Componenti di livello superiore
│ ├── Database/ # Gestione database
│ │ ├── Connect.php
│ │ └── DatabaseConnection.php
│ ├── Routing/ # Sistema di routing
│ │ └── Router.php
│ └── Http/ # Gestione richieste HTTP
│ └─ Request.php
│
├── Providers/ # Service provider dell'applicazione
│ ├── RouteServiceProvider.php
│ └── UltraAdminServiceProvider.php

