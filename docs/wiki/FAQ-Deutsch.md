# Häufige Fragen

[Anleitung / Guide](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) · [English](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-English) · [Deutsch](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-Deutsch)

Antworten zu den Funktionen der aktuellen Version. Geplante Funktionen sind hier nicht als verfügbar beschrieben.

## Themen

- [Einstieg](#topic-1)
- [Paletten und Adminschemas](#topic-2)
- [Vorschau und Speichern](#topic-3)
- [Login-Gestaltung und Bilder](#topic-4)
- [Browser-Tabs und Umgebungen](#topic-5)
- [Import, Export und Gutenberg](#topic-6)
- [Updates, Sprache und Fehlerhilfe](#topic-7)

<a name="topic-1"></a>

## Einstieg

### Brauche ich Core Framework, Bricks oder ACSS?

Nein. Eigene Farben genügen; Farbprovider sind optional.

### Welche Voraussetzungen gibt es?

WordPress ab 6.4 und PHP ab 8.0. Installiere das Plugin-ZIP aus den GitHub-Releases.

### Wer darf Einstellungen ändern?

Benutzer mit der WordPress-Berechtigung manage_options, normalerweise Administratoren.

### Muss ich alle Funktionen aktivieren?

Nein. Login-Gestaltung, generierte Favicons und Gutenberg-Farben sind optional. Aktiviere nur, was du benötigst.

### Ist das Plugin kostenpflichtig?

Das Plugin ist freie Software unter GPL v2 oder höher. Optionale Farbprovider können eigene Lizenzen benötigen.


<a name="topic-2"></a>

## Paletten und Adminschemas

### Wie viele Farben brauche ich?

Primary, Secondary und Akzent genügen. Tertiary lässt sich ableiten; vier eigene Farben sind ebenfalls möglich.

### Warum fehlt meine Providerpalette?

Nur lesbare HEX-Quellen erscheinen. Core Framework muss sein erzeugtes Stylesheet über den Helper bereitstellen. ACSS-Rollenwerte als OKLCH, HSL, light-dark() oder CSS-Variablen werden nicht ausgewertet. Verwende bei Bedarf eigene HEX-Farben.

### Ändert sich das Schema automatisch mit dem Provider?

Nein. Vergleiche alte und neue Quellfarben und speichere das aktualisierte Schema, wenn es passt.

### Was passiert, wenn ich einen Farbprovider deaktiviere?

Gespeicherte Schemafarben bleiben verfügbar. Der Provider wird zum erneuten Einlesen der Palette benötigt, nicht zur Darstellung gespeicherter Farben.

### Was verändern Atmosphäre und Markennähe?

Sie leiten aus den Quellfarben die Töne für Menüs, Toolbar, Buttons und Links ab. Prüfe einen Vorschlag, bevor du ihn auswählst und speicherst.

### Können Benutzer ihre persönlichen Adminfarben behalten?

Ja. Behalte persönliche Farben bei, biete einen Standard an oder erzwinge das aktive Schema für alle. Der Standard gilt für die WordPress-Auswahl Modern; WordPress erkennt nicht, ob sie bewusst gewählt wurde.

### Kann ich mehrere Schemas benennen und speichern?

Ja, bis zu 30 benannte Schemas. Ein kurzer Kunden- oder Atmosphärenname erleichtert die spätere Auswahl.

### Verändert das Plugin mein Website- oder Builderdesign?

Es gestaltet den Adminrahmen, optional Login und Toolbar sowie Browser-Tab-Icons. Seiteninhalte und Builder-Arbeitsflächen behalten ihr Design; Gutenberg-Paletteneinträge ergänzen nur die Farbauswahl.

### Garantiert die Kontrastprüfung Barrierefreiheit?

Nein. Sie prüft beispielhafte Farbkombinationen. Prüfe zusätzlich echte Bildschirme, Fokuszustände und Elemente anderer Plugins; dies ersetzt keine vollständige Prüfung der Barrierefreiheit.


<a name="topic-3"></a>

## Vorschau und Speichern

### Speichert Hover über einem Schema bereits?

Nein. Hover oder Tastaturfokus zeigt die Vorschau. Wähle die Karte aus und nutze den fixierten Speichern-Button zum Übernehmen.

### Warum zeigt ein anderer Tab noch alte Farben?

Speichere zuerst und lade danach den anderen Tab neu. Die Vorschau gilt für die Einstellungsseite; sie synchronisiert nicht alle offenen Browser-Tabs.

### Kann ich einen Speichervorgang rückgängig machen?

Die Rücknahme kann den vorherigen Speicherstand wiederherstellen, wenn verfügbar. Sie umfasst einen Schritt, kein Versionsarchiv; exportiere wichtige Konfigurationen.

### Kann ich Vorschauen ohne Maus bedienen?

Schemakarten zeigen auch bei Tastaturfokus eine Vorschau. Achte auf den sichtbaren Fokus und bediene die Einstellungen per Tastatur.


<a name="topic-4"></a>

## Login-Gestaltung und Bilder

### Brauche ich ein Logo und ein Hintergrundfoto?

Nein. Website-Icon, Theme-Logo und Websitename liefern Rückfalloptionen; die Farbverläufe funktionieren ohne Foto.

### Kann ich ein breites Banner statt eines quadratischen Logos nutzen?

Ja. Wähle ein Login-Banner; seine dargestellte Breite bleibt innerhalb des Formularbereichs.

### Kann ich Titel, Slogan und Login-Farben ändern?

Ja. Websitetitel und Slogan sind Vorgaben; überschreibe oder verstecke beide unabhängig. Bei Bedarf lassen sich Seitenhintergrund, Formularfläche, Bildfarbe und Button anpassen.

### Was hilft bei langen Websitetiteln?

Titel umbrechen innerhalb des Formularbereichs. Probiere zentrierte Inhalte oder einen kürzeren eigenen Titel und prüfe Desktop, Tablet und Mobil.

### Warum unterscheidet sich der Login im neuen Tab von der Vorschau?

Der Link zum neuen Tab zeigt die gespeicherte Gestaltung. Speichere alle Änderungen, bevor du mit der Editorvorschau vergleichst.

### Kann ich SVG-Loginbilder verwenden?

Nur mit dem separaten Plugin Safe SVG, Administratorbestätigung und bereinigtem Mediathek-Anhang. Brand Admin Schemes erlaubt keine ungeprüften SVG-Uploads. Agentur-ZIP-Pakete schließen SVG-Dateien aus.

### Ersetzt es den WordPress-Login oder die Passwortwiederherstellung?

Nein. Es verändert die Darstellung; WordPress-Formulare und ihre Aktionen bleiben erhalten. Andere Login-Plugins können die Darstellung beeinflussen; prüfe ihr Zusammenspiel.

### Ändern sich Verläufe bei jedem Neuladen?

Nein. Die Überraschungsvariante bleibt je Website stabil. Wähle einen der neun Vorschauverläufe, um die Darstellung festzulegen.


<a name="topic-5"></a>

## Browser-Tabs und Umgebungen

### Ersetzt es das WordPress-Website-Icon?

Nein. Es erzeugt kontextabhängige Browser-Tab-Favicons, ohne das gespeicherte Website-Icon zu ändern. Das ursprüngliche Frontend-Favicon kann erhalten bleiben.

### Welche Builderkontexte werden erkannt?

Unterstützte Editor-Merkmale von Bricks, Elementor und Oxygen werden in angemeldeten Editoransichten erkannt. Die Erkennung ist auf diese Merkmale begrenzt; andere Plugins oder geänderte Editoroberflächen können sie beeinflussen.

### Wie lang darf das Favicon-Kürzel sein?

Bis zu drei Zeichen. Ein oder zwei bleiben in Browser-Tab-Größe meist besser lesbar; Umrisssymbole stehen ebenfalls bereit.

### Warum sehe ich noch ein altes Favicon?

Speichere die Icon-Einstellungen und lade den Tab neu oder öffne ihn erneut. Browser speichern Favicons im Cache. Prüfe auch, ob ein anderes Plugin oder der Builder das Icon später ersetzt.

### Wie werden Lokal, Entwicklung, Staging und Live erkannt?

Eine explizit konfigurierte WordPress-Umgebung hat Vorrang. Sonst dienen typische lokale Adressen und Dev-/Staging-Präfixe als Hinweise. .local, localhost, 127.0.0.0/8 und IPv6-Loopback werden berücksichtigt; ungewöhnliche Domains erfordern eventuell eine manuelle Auswahl.

### Ändert die manuelle Auswahl Staging die WordPress-Konfiguration?

Nein. Sie verändert das angezeigte Badge und den generierten Favicon-Marker, nicht WP_ENVIRONMENT_TYPE, Debugging oder Indexierungseinstellungen.

### Wer sieht PHP- und WP_DEBUG-Informationen?

Website-Administratoren können das Untermenü des Toolbar-Badges öffnen. Andere Benutzer sehen diese Laufzeitinformationen nicht.

### Kann ich eigene Umgebungsfarben wählen?

Ja. Jeder Status darf einen eigenen Farbton haben. Die Helligkeit kann für den Kontrast zur Toolbar angepasst werden; der Badgetext wechselt zwischen hell und dunkel.

### Warum fehlt das Badge im Frontend?

Es benötigt eine sichtbare WordPress-Adminleiste. Prüfe deine Anmeldung und ob Profil, Theme oder ein anderes Plugin die Toolbar ausblendet.


<a name="topic-6"></a>

## Import, Export und Gutenberg

### Verändert ein Import sofort die aktive Gestaltung?

Nein. Prüfe importierte Einstellungen und speichere zum Anwenden. Agentur-ZIP-Importe legen enthaltene Bilder allerdings sofort in der Mediathek an.

### Sollte ich JSON oder ein Agentur-ZIP verwenden?

JSON überträgt Einstellungen und Schemas ohne Dateien. ZIP kann zusätzlich unterstützte lokale Login-Bilder enthalten. Nutze JSON für leichte Vorlagen und ZIP für übertragbare Bildgestaltungen.

### Welche Bilddateien und Größen unterstützt das Agenturpaket?

Lokale PNG-, JPEG-, WebP- und GIF-Bilder bis 4 MB je Datei und 13 MB je Paket. SVG-Dateien sind ausgeschlossen. Import und Export benötigen PHP ZipArchive.

### Warum stellt der JSON-Import mein Logo nicht wieder her?

JSON speichert websitespezifische Medienverweise, keine Bilddateien. Wähle Bilder auf der Zielwebsite erneut aus oder nutze ein Agentur-ZIP mit unterstützten Bildern.

### Verändert die Gutenberg-Palette bestehende Blöcke?

Nein. Sie ergänzt bis zu vier Markenfarben neben der Theme-Palette. Vorhandene Blockfarben und die Editoroberfläche bleiben bestehen.


<a name="topic-7"></a>

## Updates, Sprache und Fehlerhilfe

### Wie funktionieren Updates?

Updates kommen aus dem öffentlichen DECKERWEB-Repository auf GitHub über das reguläre WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht nötig.

### Warum erscheint ein GitHub-Release noch nicht als Update?

Nutze Erneut prüfen unter Dashboard → Aktualisierungen. Prüfe den Serverzugriff auf GitHub. Alternativ kannst du das neueste Plugin-ZIP über WordPress hochladen und die installierte Version ersetzen.

### Aktiviert das Plugin automatische Updates für mich?

Nein. Wähle automatische Updates selbst über die verfügbaren WordPress-Einstellungen.

### Kann ich ein privates GitHub-Repository für Updates nutzen?

Nicht mit dem enthaltenen Updater. Er liest öffentliche GitHub-Releases ohne Anmeldung.

### Wie wechsle ich zu Deutsch?

Deutsche Übersetzungen sind enthalten. Wähle Deutsch als WordPress-Website- oder Benutzersprache; kein Sprachpaket-Download ist nötig.

### Benötigt die Farberzeugung einen externen Dienst?

Nein. Palettenverarbeitung und Icon-Erzeugung erfolgen lokal. Updateprüfungen und Downloads kontaktieren GitHub.

### Löscht die Deaktivierung meine Einstellungen?

Nein. Die Gestaltung endet während der Deaktivierung; gespeicherte Einstellungen bleiben erhalten. Exportiere eine Konfiguration vor größeren Änderungen.

### Gibt es eine netzwerkweite Multisite-Einstellungsseite?

Diese Version speichert Einstellungen pro Website und hat keinen netzwerkweiten Vorlagenmanager. Prüfe jede Website separat; diese Anleitung garantiert keine umfassende Multisite-Kompatibilität.

### Was gehört in einen Fehlerbericht?

Plugin-, WordPress- und PHP-Version; relevante Provider- oder Builderversion; betroffener Bildschirm und Schritte zum Nachstellen. Nutze anonymisierte Screenshots und entferne Zugangsdaten sowie private Kundeninformationen vor einem öffentlichen GitHub-Issue.

© 2022–2026 David Decker – DECKERWEB · GPL v2 oder höher
