# ESK Blog - Europaschule Köln Community

## Projektübersicht

**Website:** Blog für Europaschule Köln - Schüler & Alumni Community
**Anlass:** 50-Jahresfeier der Europaschule Köln

**Live-URL (geplant):** https://blog.europaschulekoeln.eu
**Lokal:** http://localhost:8201

**Status:** ✅ Installation abgeschlossen - Grundkonfiguration läuft

---

## 🎯 Konzept & Ziele

### Projektziel
Ehemalige und aktuelle Schüler sollen witzige Geschichten, Bilder und Erinnerungen zu ihrer Schulzeit posten können. Der Blog ist Teil der Feierlichkeiten zum 50-jährigen Jubiläum.

### Sicherheitskonzept
- **Separate Installation:** Blog läuft auf eigenem Server/Subdomain, getrennt von der Hauptseite
- **Begründung:** Bei einem Hack geht nur der Blog offline, nicht die gesamte Europaschule-Website
- **Freigabeprozess:** Alle Beiträge müssen vor Veröffentlichung geprüft und freigegeben werden

### Benutzer-Konzept

**Rollen:**
| Rolle | Rechte | Zielgruppe |
|-------|--------|------------|
| Contributor | Beiträge einreichen (keine Veröffentlichung) | Schüler, Alumni |
| Editor | Beiträge prüfen, bearbeiten, freigeben | Schuladministration |
| Administrator | Vollzugriff | Studio Orange / IT |

**Frontend-Formular:**
- Benutzerfreundliches Eingabeformular ohne WordPress-Login
- Senkt Hemmschwelle für Beiträge
- Felder: Titel, Text, Bilder, Kategorie-Auswahl
- Spam-Schutz integriert

### Freigabe-Workflow
1. Schüler/Alumni reicht Beitrag ein (via Frontend-Formular oder WP-Backend)
2. E-Mail-Benachrichtigung an Editor
3. Editor prüft Inhalt auf Angemessenheit
4. Freigabe oder Rückfrage/Ablehnung
5. Veröffentlichung

### Kategorien (5 Basis-Themen)
- **Schüler** – Aktuelle Geschichten
- **Alumni** – Erinnerungen ehemaliger Schüler
- **Projekte** – Schulprojekte und Aktionen
- **Events** – Veranstaltungen und Feiern
- **Schulleben** – Alltag an der Europaschule
- **Internationales** – Austausch, Erasmus+, etc.

---

## 🛠 Technische Spezifikationen

### WordPress Setup
- **Version:** WordPress 6.x (aktuell)
- **Haupttheme:** Uncode (Premium Theme)
- **Child-Theme:** ESK Blog v1.0.0
- **Datenbank:** MySQL `eskblog_local`
- **Tabellen-Präfix:** `eskb_`
- **PHP:** 8.4.x
- **Memory Limit:** 256M

### Design-System
```css
:root {
    --brand-primary: #145e7e;    /* Blau */
    --brand-secondary: #f49c00;  /* Orange */
    --brand-dark: #0b0b0b;
    --brand-light: #f7f7f7;
    --brand-white: #ffffff;
}
```

---

## 🚀 Lokale Entwicklungsumgebung

### Server
- **Webserver:** nginx + php-fpm
- **Port:** 8201
- **Config:** `/opt/homebrew/etc/nginx/servers/eskblog.conf`

### Datenbank
- **Host:** localhost
- **Database:** eskblog_local
- **User:** root
- **Password:** (leer)
- **Prefix:** eskb_

### URLs
- **Frontend:** http://localhost:8201
- **Admin:** http://localhost:8201/wp-admin/

---

## 🔌 Installierte Plugins

### Uncode Plugins
- Uncode Core
- Uncode WPBakery Page Builder
- Uncode Wireframes
- Uncode Privacy
- Uncode Dave's WordPress Live Search
- LayerSlider
- RevSlider
- VC Clipboard
- VC Particles Background

### Standard Plugins
- Contact Form 7
- Yoast SEO
- Adminimize
- CMS Tree Page View
- SVG Support
- Better Search Replace
- Duplicate Post
- Akismet

### Workflow & Formular Plugins (11.12.2025)
- **PublishPress Planner** – Editorial Workflow & Notifications
- **User Submitted Posts** – Frontend-Formular für Beitragseinreichung

### Security Plugin (15.12.2025)
- **Solid Security Basic** – Brute Force Protection, Firewall, Login-Schutz

### Backup Plugin (15.12.2025)
- **BackWPup** – Automatische Backups (Files + Database)

---

## 📁 Projektstruktur

```
/Users/orange/Sites/europaschule-blog/
├── wp-content/
│   ├── themes/
│   │   ├── uncode/          # Parent Theme
│   │   └── eskblog/         # Child Theme (kopiert von Europaschule)
│   │       ├── functions.php
│   │       ├── style.css
│   │       └── fonts/       # Lato Webfonts
│   └── plugins/             # 19 Plugins
├── wp-config.php
├── Uncode/                  # Theme-Paket (Lizenz)
├── Europaschule-Koeln-Logo.svg  # Logo für Upload
├── favicon.png              # Favicon für Upload
└── ESKBLOG.md
```

---

## 📝 Offene ToDo-Liste

### Priorität 1: Installation abschließen ✅
- [x] WordPress-Installation auf separatem Server/Subdomain
- [x] Admin-User erstellen
- [x] Child-Theme "ESK Blog" aktivieren
- [x] Plugins aktivieren
- [x] Permalinks auf "Beitragsname" setzen
- [x] SSL-Zertifikat (lokal nicht relevant)

### Priorität 2: Grundkonfiguration ✅
- [x] Uncode Theme-Optionen konfigurieren (von Europaschule übernommen)
- [x] Logo einbinden
- [x] Favicon einbinden
- [x] Kategorien anlegen (6 Themen)
- [x] Footer Content Block importiert
- [x] 9 Beispiel-Beiträge importiert
- [x] Demo-Layout eingerichtet

### Priorität 3: Freigabe-Workflow & Benutzer-System ✅
- [x] Benutzerrollen konfiguriert (Mitarbeiter/Contributor, Redakteur/Editor)
- [x] PublishPress Planner installiert und aktiviert
- [x] E-Mail-Benachrichtigungen konfiguriert:
  - "Pending Review" → Benachrichtigung an Admin/Editor
  - "Published" → Benachrichtigung an Autor
- [x] Freigabe-Workflow getestet (funktioniert)

### Priorität 4: Frontend-Formular ✅
- [x] Plugin ausgewählt: **User Submitted Posts**
- [x] Plugin installiert und Grundkonfiguration
- [x] CTA-Button im Mobile-Header (via Filter `uncode_mobile_extra_menu_elements`)
- [x] Formular-Seite mit Shortcode `[user-submitted-posts]` erstellt
- [x] Formular-Styling CSS angepasst (12.12.) - Selektoren auf `#usp_form` korrigiert
- [x] Formular-Styling mit Playwright MCP geprüft und finalisiert
- [x] Spam-Schutz (Challenge Question) aktiviert
- [x] Deutsche Fehlermeldungen für Parsley.js Validierung (`functions.php`)
- [x] Input-Felder auf volle Breite angepasst
- [x] Antispam-Feld mit orangenem Pflichtfeld-Indikator

### Priorität 5: Sicherheit ✅
- [x] Security-Plugin installieren: **Solid Security Basic** (15.12.2025)
- [x] Login-Schutz aktivieren (Brute Force Protection)
- [x] Firewall konfiguriert (Local + Network Brute Force)
- [x] Starke Passwörter erzwingen
- [x] Kompromittierte Passwörter ablehnen
- [x] Two-Factor Authentication aktiviert
- [x] Backup-Lösung einrichten: **BackWPup** (15.12.2025)

### Priorität 6: Design & Finalisierung
- [x] Farben an Europaschule anpassen (via Theme übernommen)
- [x] Footer Content Block importiert (ID: 166309)
- [x] Header: CTA-Button und Burger-Menü vertikal ausgerichtet (alle Breakpoints)
- [x] Burger-Menü 25% größer skaliert
- [x] Off-Canvas-Menü: Petrol-Hintergrund, weiße Schrift
- [x] **Kategorien ins Menü aufnehmen** (15.12.2025)
- [x] **Kategorie-Übersichtsseiten erstellen/stylen** ✅
- [x] **Blog-Startseite: Beiträge mit Kategorie-Anzeige** ✅
- [x] **Autoren-Namen auf Beiträgen anzeigen** (16.12.2025)
- [x] **Formular: Text/Bild bei Validierungsfehler behalten** (16.12.2025)
- [x] **Success-Seite auf Content-Seite umleiten** (16.12.2025)
- [ ] Blog-Startseite finalisieren
- [ ] Mobile-Ansicht testen (weitere Tests)

### Priorität 7: Dokumentation & Schulung
- [ ] Admin-Anleitung für Freigabeprozess erstellen
- [ ] Schritt-für-Schritt-Anleitung für Schüler/Alumni
- [ ] Online-Schulung durchführen (60 Min.)

---

## 🔧 Nächste Schritte

1. ~~**Benutzerrollen:** Contributor/Editor-Rollen konfigurieren~~ ✅
2. ~~**Freigabe-Workflow:** PublishPress Planner eingerichtet~~ ✅
3. **Frontend-Formular:** Styling anpassen, Seite erstellen
4. **Sicherheit:** Security-Plugins aktivieren
5. **Schulung:** Dokumentation und Einweisung vorbereiten

---

## 📋 Changelog

### 16.12.2025 - Author Display, Form Persistence & Success Redirect
- **Autoren-Namen:** WordPress-User durch eingereichten Namen ersetzt
  - Filter `the_author` und `get_the_author_display_name` für Uncode-Kompatibilität
  - Filter `author_link` deaktiviert Links für eingereichte Beiträge
  - Zeigt `user_submit_name` Meta-Feld statt WP-Benutzername
- **Formular-Datenpersistenz:** sessionStorage speichert Eingaben bei Validierungsfehlern
  - Text-, E-Mail-, Select- und TinyMCE-Felder werden gespeichert
  - Automatische Wiederherstellung beim Neuladen der Seite
  - Daten werden nach erfolgreicher Übermittlung gelöscht
- **Success-Redirect:** Weiterleitung zur `/danke/` Seite nach erfolgreicher Einreichung
  - Action Hook `usp_submit_success` statt Filter
  - Custom Content-Seite statt Standard-Erfolgsmeldung
- **Auto-Excerpt:** Automatische Teaser-Generierung für Beiträge ohne Excerpt
  - `save_post` Hook generiert 20-Wort-Excerpt aus Content
  - Wichtig für USP-Beiträge (haben standardmäßig kein Excerpt)
  - Uncode Related Posts zeigen jetzt korrekte Teaser
- **Danke-Seite:** `/danke/` mit individuellem Inhalt erstellt

### 15.12.2025 - Security & Backup Setup
- **Solid Security Basic** Plugin installiert und aktiviert
- Setup-Wizard durchlaufen mit folgenden Einstellungen:
  - Website-Typ: Blog
  - Local Brute Force Protection aktiviert
  - Network Brute Force Protection aktiviert
  - Starke Passwörter erzwingen (Editor+)
  - Kompromittierte Passwörter ablehnen
  - Two-Factor Authentication aktiviert
  - Security Check Pro aktiviert
  - Authorized IP: 127.0.0.1 (localhost)
- Client-Benutzer definiert: Dirk Bosbach, Simone Bosbach
- Admin-Benutzer für Security: orange
- **BackWPup** Plugin installiert und konfiguriert:
  - Vollständiges Backup (Files + Database)
  - Wöchentlicher automatischer Zeitplan
  - Speicherort: Website Server (`uploads/backwpup/46bda3/backups/`)
  - Max. 15 Backups werden aufbewahrt
  - Erstes Backup erfolgreich gestartet

### 14.12.2025 - Header-Positionierung & Responsive CTA
- CTA-Button und Burger-Menü vertikal ausgerichtet bei allen Breakpoints
- Burger-Menü-Icon mit CSS `top: -15px` Korrektur für kleine Viewports (<768px)
- Deutsche Parsley.js Validierungsmeldungen hinzugefügt (`functions.php`)
- Input-Felder auf 100% Breite angepasst
- Antispam-Feld (Challenge Question) aktiviert und mit orangenem Indikator versehen
- **CTA-Button responsive optimiert:**
  - Abstände zwischen CTA und Burger-Menü angepasst (kein Überlappen mehr)
  - Kompaktere Darstellung auf kleinen Screens (500px-768px)
  - CTA wird auf sehr kleinen Screens (<400px) ausgeblendet (Logo-Überlappung vermeiden)
  - Breakpoints: Desktop 95px, 959px 95px, 768px 100px, 500px 120px, <400px hidden

### 12.12.2025 - Formular-Styling & Playwright MCP
- Formular-CSS überarbeitet (Selektoren `#usp_form` statt `.usp-form`)
- Pflichtfeld-Indikator (orangener Rand links)
- Playwright MCP Server installiert für localhost-Testing
- Dokumentation in `_docs/README.md` aktualisiert

### 11.12.2025 - Workflow & Formular Setup
- PublishPress Planner installiert und konfiguriert
- E-Mail-Benachrichtigungen eingerichtet (Pending Review, Published)
- User Submitted Posts Plugin installiert
- Mobile CTA-Button im Header implementiert (`functions.php`)
- CSS für Mobile CTA und Formular-Styling hinzugefügt (`style.css`)
- Benutzerrollen getestet (Mitarbeiter → Redakteur → Veröffentlichung)

### 08.12.2025 - Grundkonfiguration
- Demo-Beiträge importiert
- Kategorien angelegt
- Footer Content Block importiert

### 02.12.2025 - Theme Setup
- Child-Theme von Europaschule kopiert
- Uncode Theme Options per DB übertragen

### 26.11.2025 - Installation
- Lokale WordPress-Installation
- nginx + php-fpm Konfiguration

---

**Erstellt:** 26.11.2025
**Aktualisiert:** 16.12.2025
**Version:** 1.6.0 (Author Display, Form Persistence, Success Redirect)
**Entwicklungsumgebung:** macOS mit nginx + php-fpm
**Ansprechpartner Kunde:** Herr Gruner (Europaschule Köln)
