# Admin-Anleitung: ESK Blog Freigabeprozess

## Übersicht

Der ESK Blog ermöglicht Schülern und Alumni, Beiträge über ein Frontend-Formular einzureichen. Alle Beiträge müssen vor der Veröffentlichung geprüft und freigegeben werden.

---

## 1. Beiträge prüfen und freigeben

### Neue Beiträge finden

1. Im WordPress-Admin einloggen: `https://blog.europaschulekoeln.eu/wp-admin/`
2. Links im Menü auf **Beiträge** klicken
3. Oben auf **Ausstehend** klicken (zeigt alle zur Prüfung wartenden Beiträge)

### Beitrag prüfen

1. Auf den Beitragstitel klicken zum Bearbeiten
2. Prüfen Sie:
   - **Inhalt:** Ist der Text angemessen und frei von beleidigenden Inhalten?
   - **Bilder:** Sind die Bilder passend und in guter Qualität?
   - **Kategorie:** Ist die richtige Kategorie gewählt?
   - **Autor-Name:** Wird im Feld "Eingereichter Name" angezeigt

### Beitrag freigeben

1. Im rechten Bereich unter **Veröffentlichen**
2. Status von "Ausstehender Review" auf **Veröffentlicht** ändern
3. Auf **Aktualisieren** klicken

### Beitrag ablehnen

1. Beitrag in den **Papierkorb** verschieben
2. Optional: Autor per E-Mail informieren (E-Mail-Adresse im Beitrag sichtbar)

---

## 2. E-Mail-Benachrichtigungen

Das System sendet automatisch E-Mails:

| Ereignis | Empfänger | Inhalt |
|----------|-----------|--------|
| Neuer Beitrag eingereicht | Admin/Editor | "Neuer Beitrag zur Prüfung" |
| Beitrag veröffentlicht | Autor | "Dein Beitrag wurde veröffentlicht" |

**Einstellungen:** Planner → Benachrichtigungen

---

## 3. Kategorien verwalten

### Vorhandene Kategorien
- Schüler
- Alumni
- Projekte
- Events
- Schulleben
- Internationales

### Neue Kategorie anlegen
1. **Beiträge → Kategorien**
2. Name eingeben
3. Titelform (Slug) wird automatisch erstellt
4. **Neue Kategorie erstellen** klicken

---

## 4. Benutzer verwalten

### Rollen-Übersicht

| Rolle | Rechte |
|-------|--------|
| **Mitarbeiter** | Kann Beiträge einreichen (keine Veröffentlichung) |
| **Redakteur** | Kann Beiträge prüfen, bearbeiten und freigeben |
| **Administrator** | Vollzugriff |

### Neuen Benutzer anlegen
1. **Benutzer → Neu hinzufügen**
2. Benutzername und E-Mail eingeben
3. Rolle auswählen (meist "Redakteur" für Schulpersonal)
4. **Neuen Benutzer hinzufügen**

---

## 5. Formular-Einstellungen

Das Frontend-Formular ist unter **Einstellungen → User Submitted Posts** konfigurierbar.

### Wichtige Einstellungen
- **Spam-Schutz:** Challenge Question ist aktiviert
- **Erlaubte Dateitypen:** jpg, jpeg, png, gif
- **Max. Dateigröße:** 5 MB
- **Beitragsstatus:** Ausstehend (zur Prüfung)

---

## 6. Sicherheit

### Installierte Sicherheitsmaßnahmen
- **Brute-Force-Schutz:** Begrenzt Login-Versuche
- **Zwei-Faktor-Authentifizierung:** Aktiviert für Admins
- **Starke Passwörter:** Erforderlich für Redakteure und Admins

### Backup
- Automatisches wöchentliches Backup (BackWPup)
- Speicherort: Server (`uploads/backwpup/`)
- Max. 15 Backups werden aufbewahrt

### Manuelles Backup erstellen
1. **BackWPup → Aufträge**
2. Bei "Vollständiges Backup" auf **Jetzt starten** klicken

---

## 7. Häufige Fragen

### Warum sehe ich den eingereichten Autor-Namen nicht?
Der Name wird aus dem Formularfeld "Name" übernommen und erscheint automatisch auf der Website statt des WordPress-Benutzernamens.

### Kann ich einen Beitrag vor der Veröffentlichung bearbeiten?
Ja, Sie können Titel, Text, Kategorien und Bilder vor der Freigabe anpassen.

### Wie lösche ich einen Beitrag endgültig?
1. Beitrag in Papierkorb verschieben
2. **Beiträge → Papierkorb**
3. **Endgültig löschen** klicken

### Wie ändere ich das Spam-Schutz-Rätsel?
**Einstellungen → User Submitted Posts → Challenge Question**

---

## 8. Kontakt bei Problemen

**Technischer Support:** Studio Orange
**E-Mail:** [kontakt@studioorange.de]

---

*Stand: 16.12.2025*


