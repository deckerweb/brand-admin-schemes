# Markenfarben im Admin · Brand Admin Schemes

**WordPress soll sich wie die Website deines Kunden anfühlen.** Übernimm Farben aus Core Framework, Bricks Builder, Automatic.css oder einer eigenen Palette. Probiere vier Atmosphären aus, bewege den Regler für die Markennähe und prüfe das Ergebnis vor dem Speichern. Dieselbe Palette gestaltet Admin, Login, Toolbar, Browser-Tabs und auf Wunsch die Farbauswahl in Gutenberg.

Kein eigenes CSS nötig. Die Website bekommt auf beiden Seiten des Logins ein vertrautes Gesicht.

**Aktuelle Version:** 0.16.1 · **Voraussetzungen:** WordPress 6.4+ und PHP 8.0+ · **Lizenz:** GPL v2 oder höher

[English documentation](README.md)

## Auf einen Blick

- **Vorhandene Markenfarben verwenden:** Core Framework, Bricks-Paletten und Automatic.css sind optionale Quellen; eigene Farben funktionieren immer.
- **Vier Atmosphären:** Ausgewogen, Ruhig, Kräftig und Dunkel erzeugen unterschiedliche Vorschläge aus derselben Palette.
- **Markennähe regeln:** Der Schieberegler macht die Farben zurückhaltender oder ausdrucksstärker und aktualisiert die Vorschauen direkt.
- **Vorher ausprobieren:** Hover oder Tastaturfokus auf einer Karte färben den Admin vorübergehend ein. Escape beendet die Vorschau.
- **Favoriten behalten:** Bis zu 30 Schemas benennen und speichern. Beim Speichern wird das gewählte Schema deinem Benutzerkonto zugewiesen.
- **Benutzerwahl steuern:** Persönliche Auswahl beibehalten, ein Standardschema anbieten oder das aktive Schema für alle erzwingen.
- **Toolbar im Frontend:** Primary, Secondary, Tertiary oder Akzent werden passend zu Atmosphäre und Markennähe eingefärbt.
- **Umgebung erkennen:** Kompakte Toolbar-Badges zeigen Lokal, Entwicklung, Staging oder Live – automatisch oder manuell, mit anpassbaren Farben.
- **Login gestalten:** Responsive Layouts, Logo oder kleines Banner, Hintergrundbild oder neun Verlaufsvarianten, änderbare Texte und eine optionale Zitatbox.
- **Browser-Tabs unterscheiden:** Generierte Favicons für Website, Admin und Builder; optional mit kleinem Umgebungsmarker.
- **Änderungen prüfen:** Kontrastwerte, Vergleich geänderter Providerfarben, Rücknahme des letzten Speicherns und Schutz vor dem Verwerfen ungespeicherter Einstellungen.
- **Zum nächsten Projekt mitnehmen:** JSON für Einstellungen oder ein Agentur-ZIP mit unterstützten lokalen Login-Bildern.
- **Gutenberg-Farben ergänzen:** Auf Wunsch erscheinen die vier Markenfarben zusätzlich zu den Themefarben im Editor.
- **Über GitHub aktualisieren:** Veröffentlichte Releases erscheinen über den eingebauten Updater in der WordPress-Updateansicht.

## Installation und erstes Schema

1. Lade das Plugin-ZIP aus den [GitHub-Releases](https://github.com/deckerweb/brand-admin-schemes/releases), installiere es über **Plugins → Plugin hinzufügen → Plugin hochladen** und aktiviere es.
2. Öffne **Einstellungen → Markenfarben im Admin**. Der Link **Farbschema** auf der Plugins-Seite führt ebenfalls dorthin.
3. Wähle eine Farbquelle oder eigene Farben. Primary, Secondary und Akzent genügen; Tertiary lässt sich ableiten. Wähle Atmosphäre und Markennähe.
4. Prüfe eine Karte per Hover oder Tastaturfokus, wähle sie aus und gib optional einen Namen ein. Klicke oben auf **Alle Änderungen speichern**.
5. **Seite neu laden** zeigt das gespeicherte Ergebnis vollständig im aktuellen Adminbildschirm.

Die Einstellungsseite und Speicheraktionen erfordern die WordPress-Berechtigung `manage_options`.

## Funktionsweise

Die Rollen heißen Primary, Secondary, Tertiary und Akzent. Ordne Providerfarben zu oder lasse eine Zwischenfarbe für Tertiary aus Primary und Secondary erzeugen. Atmosphäre und Regler bestimmen Menü, Untermenü, Toolbar, Hervorhebungen, Buttons und Links.

| Quelle | Unterstützte Werte |
| --- | --- |
| Core Framework | Einfache sechsstellige HEX-Werte aus lesbaren CSS-Variablen im erzeugten Stylesheet, sofern der Helper die Datei bereitstellt. |
| Bricks Builder | HEX-Farben aus verfügbaren Bricks-Farbpaletten. |
| Automatic.css | Aktivierte, lesbare HEX-Rollenfarben über die ACSS-Einstellungs-API; der Adapter wurde anhand von ACSS 3.3.7 und 4.0.1 geprüft. |
| Eigene Farben | Direkt im Editor gewählte Farben, ohne weitere Plugins. |

Nur lesbare Quellen erscheinen in der Auswahl. Gespeicherte Farbwerte bleiben erhalten, wenn der Provider später fehlt. Änderungen an der Quelle werden **nicht automatisch übernommen**: Prüfe alte und neue Farbvorschauen und bestätige das Aktualisieren. Die Kontrastprüfung der Beispieltexte ist eine Orientierung, kein vollständiges Barrierefreiheits-Audit.

| Benutzervorgabe | Wirkung |
| --- | --- |
| Keine Vorgabe | Die persönliche WordPress-Farbauswahl bleibt bestehen. |
| Standard; persönliche Auswahl erlauben | Das aktive Schema gilt für Benutzer mit WordPress' Standard „Modern“. WordPress unterscheidet dabei nicht zwischen einer unveränderten und einer bewusst gewählten Modern-Auswahl. |
| Für alle erzwingen | Das aktive Schema überschreibt persönliche Auswahlen und blendet die Farbauswahl im Benutzerprofil aus. |

Die optionale Frontend-Toolbarfarbe gilt für angemeldete Benutzer mit sichtbarer Adminbar und ausgewähltem Markenfarbschema. Die gewählte Rolle berücksichtigt Atmosphäre und Markennähe; der Editor zeigt den berechneten Farbton. Das Frontend-Styling benötigt kein JavaScript und berechnet eine lesbare Textfarbe. Vor Version 0.8.0 gespeicherte Schemas erhalten die Anpassung beim erneuten Speichern. Andere Plugins können einzelne CSS-Regeln überschreiben.

## Badge für die Installationsumgebung

Das Badge erscheint im Admin und Frontend, wenn die WordPress-Toolbar sichtbar ist. Sein Hintergrund füllt die gesamte Toolbarhöhe; SVG-Icon und kurze Beschriftung benötigen wenig Breite. Tooltip und zugängliche Beschriftung nennen Umgebung und Erkennungsquelle. Für Administratoren zeigt das Untermenü bei Hover oder Tastaturfokus zusätzlich PHP-Version und `WP_DEBUG`-Status. Andere Benutzer sehen diese Laufzeitdetails nicht.

Wähle **Automatische Erkennung** oder **Lokal**, **Entwicklung**, **Staging** oder **Live**, speichere und lade neu. Die manuelle Auswahl steuert die Pluginanzeige einschließlich Favicon-Marker; sie ändert nicht die tatsächliche WordPress-Umgebung. Türkis für Lokal, Bernstein für Entwicklung, Violett für Staging und Grün für Live passen sich der Toolbar an und streben mindestens 3:1 Kontrast zwischen den Flächen an. Eigene Statusfarben behalten ihren Farbton; bei Bedarf wird ihre Helligkeit für den Kontrast angepasst. Die Textfarbe wechselt zwischen Hell und Dunkel. Die Vorschau zeigt die Kombination mit dem ausgewählten Schema.

Die Erkennung nutzt zuerst `wp_get_environment_type()`. Ein explizites `WP_ENVIRONMENT_TYPE` hat Vorrang, auch bei `production`. Liefert WordPress lediglich den unkonfigurierten Produktionsstandard, prüft das Plugin die gespeicherte Websiteadresse (`home_url()`): `localhost`, `.localhost`, `.test`, `.local` einschließlich Local App, gültige Adressen aus `127.0.0.0/8`, IPv6-Loopback `::1` einschließlich ausgeschriebener und IPv4-gemappter Varianten sowie die Präfixe `staging.`, `stage.`, `stg.`, `development.` und `dev.`. Andere Adressen gelten als Live. Domainnamen sind Hinweise; für abweichende Setups hilft die manuelle Auswahl.

## Login-Gestaltung

Aktiviere **Login-Gestaltung** und wähle **Bild links**, **Bild rechts** oder **Zentriert**. Das Standardlayout zeigt eine große Bildfläche neben dem vorhandenen WordPress-Formular. Auf kleinen Bildschirmen wird daraus ein kurzer Bannerbereich über dem Formular. Das zentrierte Layout verwendet einen vollflächigen Verlauf. Die Formularseite lässt sich unabhängig linksbündig oder zentriert ausrichten; linksbündig ist Standard.

Wähle Bilder über die WordPress-Mediathek. Ohne eigenes Logo nutzt das Plugin zuerst das Website-Icon, dann das Theme-Logo und schließlich den Websitetitel als Text. Ein kleines breites Banner kann das Logo ersetzen und bleibt innerhalb der Formularbreite. Ohne Hintergrundbild stehen acht sanfte, aus dem Schema berechnete Verläufe und eine für die Website stabile Überraschungsvariante als Farbvorschauen bereit. Bildposition und Überlagerungsstärke steuern Fokus und Farbstimmung eines Fotos. Optional ergänzt eine kurze Zitatbox mit Quellenangabe die Bild- oder Verlaufsfläche.

Überschrift und Untertitel übernehmen standardmäßig Websitetitel und Slogan. Beide lassen sich ändern und unabhängig ausblenden. „Willkommen zurück“ ist der Fallback bei fehlendem Titel. Prüfe Desktop, Tablet und Mobil in der Vorschau. Der Link in einem neuen Tab öffnet die **gespeicherte** Login-Gestaltung; ungespeicherte Änderungen bleiben in der Editorvorschau.

Die Loginfarben folgen dem aktiven Schema: dezenter Hintergrund auf der Formularseite, Akzentfarbe für den breiten Loginbutton. **Loginfarben individuell festlegen** überschreibt auf Wunsch Bildfläche, Seitenhintergrund, Formularfläche und Button. Anmeldung, Passwortwiederherstellung, Registrierung und andere WordPress-Formularaktionen bleiben erhalten. Bei bestehenden Installationen ist das Login-Styling zunächst ausgeschaltet.

JSON referenziert Bilder über lokale Medien-IDs und enthält keine Bilddateien. Wähle Bilder nach einem Wechsel der Installation erneut oder nutze das Agentur-ZIP. SVG-Logos oder -Banner erfordern das separate Plugin Safe SVG, eine Administratorbestätigung und einen bereinigten SVG-Medieneintrag. Dieses Plugin erlaubt keine unbearbeiteten SVG-Uploads.

## Schemas zwischen Websites übertragen

**Einstellungen als JSON exportieren** überträgt Einstellungen und bis zu 30 gespeicherte Schemas im Format `bas/v1`. Importiere, prüfe die Vorschau und speichere zum Aktivieren. Der Import allein aktiviert nichts. Für unterstützte lokale Login-Bilder gibt es das unten beschriebene Agentur-ZIP.

## GitHub-Updates

Der Updater prüft das neueste **veröffentlichte GitHub-Release ohne Vorabversionsstatus** des öffentlichen Repositorys. Ein Tag allein reicht nicht. Neuere Versionen erscheinen im normalen WordPress-Updateablauf; Release-Notizen werden im Plugin-Detailsdialog angezeigt. Der Updater aktiviert keine automatischen Updates und verwendet keinen GitHub-Token.

Erhöhe vor jedem Release die Versionsnummer in der Hauptdatei, setze einen passenden Tag `vX.Y.Z` oder `X.Y.Z` und veröffentliche ein GitHub-Release. Empfohlen ist ein angehängtes `brand-admin-schemes.zip` oder `brand-admin-schemes-X.Y.Z.zip` mit genau einem obersten Ordner `brand-admin-schemes/` und der Hauptdatei `brand-admin-schemes.php`. Ohne passenden Anhang kann der Updater das Quellcode-ZIP verwenden, sofern dessen Wurzel oder ein passender Unterordner die Hauptdatei enthält. Er prüft das Archivlayout vor der Installation. Erfolgreiche API-Abfragen werden 30 Minuten, Fehler 10 Minuten zwischengespeichert.

**Die Updateabnahme steht noch aus:** Prüfe auf Staging ein echtes Update mit Release-Anhang und anschließend den Quellcode-ZIP-Fallback. Das Plugin muss aktiv bleiben und seine Einstellungen behalten. Die wiederverwendbare Klasse liegt in `includes/deckerweb-github-release-updater-v1.php`; ihr Konstruktor erwartet Hauptdatei, öffentliche Repository-URL, Anzeigename und Beschreibung. Inkompatible Änderungen benötigen einen neuen Namespace beziehungsweise eine neue API-Version.

## Dokumentation

Der Footer öffnet die lokale Anleitung und den Changelog direkt auf der Einstellungsseite. Englisch: `README.md` und `readme.txt`. Deutsch: `README-de.md` und `readme-de.txt`. Die Textdateien werden aus den Markdown-Dateien abgeleitet und beschreiben dieselben Funktionen.

## Übersetzungen

Englische Quelltexte und deutsche `de_DE`-Dateien (`.po`/`.mo`) sind enthalten. WordPress wählt die Sprache anhand von Website- oder Benutzerlocale. Die Textdomain lautet `brand-admin-schemes`, das Verzeichnis `/languages/`. Weitere Übersetzungen sind willkommen.

## Hooks und Filter

Version 0.16.1 bietet **keine eigenen öffentlichen Plugin-Actions oder -Filter**. Intern verwendet sie unter anderem `get_user_option_admin_color`, `admin_init`, `wp_enqueue_scripts`, `wp_theme_json_data_theme` und AJAX-Actions für Speichern, Import und Rücknahme. Der Updater nutzt `update_plugins_github.com`, `plugins_api` und `upgrader_source_selection`. Interne Callbacks und gespeicherte Optionsstrukturen sind keine stabile Erweiterungs-API. Wünsche für Integrationshooks gehören in ein GitHub-Issue.

## Häufige Fragen

**Brauche ich Core Framework, Bricks oder ACSS?** Nein. Eigene Farben funktionieren immer; Provider bieten vorhandene Farben an.

**Warum fehlt meine Palette?** Unterstützt werden lesbare HEX-Werte. Core Framework muss sein erzeugtes Stylesheet über den Helper bereitstellen. ACSS-Ausdrücke wie OKLCH/HSL, `light-dark()` und CSS-Variablen werden nicht als Rollenfarben ausgewertet.

**Färbt das Plugin Gutenberg oder den Builder um?** Das Schema gestaltet den WordPress-Adminrahmen und ausgewählte Elemente. Inhalte und Builder-Arbeitsflächen werden nicht umgefärbt.

**Was macht die Gutenberg-Option?** Sie ergänzt benannte Markenfarben im Farbwähler. Bereits vorhandene Blockfarben und die Editoroberfläche ändern sich dadurch nicht.

**Wirkt ein Import sofort?** Die importierten Einstellungen werden erst beim Speichern aktiviert. Beim Agentur-ZIP werden die enthaltenen Bilder allerdings sofort zur Mediathek hinzugefügt.

**Funktionieren private Repositorys?** Der Updater unterstützt öffentliche GitHub-Releases ohne Authentifizierung.

## Die Idee dahinter

Kunden sollen ihre Marke auch dort wiedererkennen, wo sie ihre Website pflegen. WordPress bietet Adminschemas, Frameworks und Builder liefern Markenpaletten. Brand Admin Schemes verbindet diese Farben mit einer einfachen visuellen Bedienung: Atmosphäre ausprobieren, Markennähe regeln, vertrautes Ergebnis speichern.

Entwickelt von David Decker – DECKERWEB für die Websites seiner Kunden. Viel Freude mit deinen Markenfarben! :-)

## Favicons für Browser-Tabs

Aktiviere **Browser-Tab-Icons**, um Website, WordPress-Admin und einen erkannten Builder-Editor anhand eigener SVG-Favicons zu unterscheiden. Das bestehende WordPress-Website-Icon kann im Frontend erhalten bleiben. Bei vorhandenen Installationen startet die Funktion ausgeschaltet. Jeder Kontext bietet ein Kürzel mit bis zu drei Zeichen, einfache Umrisssymbole sowie automatische oder eigene Vorder- und Hintergrundfarben. Die Builder-Vorgabe folgt Bricks, Elementor oder Oxygen, sofern der Editor erkannt wird, oder wird manuell gewählt. Die geometrischen Symbole sind eigene Entwürfe, keine offiziellen Builderlogos.

Die Funktion betrifft den Browser-Tab im jeweiligen Kontext; sie ersetzt nicht den WordPress-Medieneintrag des Website-Icons. Die Erkennung beschränkt sich auf angemeldete Editoransichten mit bekannten Anfrageparametern. Öffentliche Seiten behalten ihren Frontendkontext. Wenn andere Plugins Favicons später überschreiben, kann die Ausgabereihenfolge eine Rolle spielen.

Optional kennzeichnen **L** (Lokal), **D** (Entwicklung), **S** (Staging) und **P** (Produktion/Live) generierte Favicons. Der Marker folgt der automatisch oder manuell gewählten Umgebung und lässt sich abschalten. Ein beibehaltenes WordPress-Website-Icon wird nicht verändert.

## Prüfung und Übertragbarkeit

Ungespeicherte Änderungen werden angezeigt; vor dem Verlassen oder Neuladen warnt der Browser. Die Kontrastprüfung misst Beispieltexte für Admin und Login und schlägt bei Werten unter 4,5:1 eine Anpassung vor. Andere Plugins und Themes können das endgültige Erscheinungsbild beeinflussen.

Das **Agentur-ZIP** enthält Einstellungen sowie lokale PNG-, JPEG-, WebP- oder GIF-Dateien für Logo, Banner und Hintergrund. Pro Bild sind bis zu 4 MB erlaubt, das gesamte Importpaket bis zu 13 MB. SVG-Dateien sind ausgeschlossen. Importierte Bilder landen sofort in der Mediathek; die Einstellungen werden anschließend zur Prüfung geladen und erst beim Speichern angewendet. Der Server benötigt die PHP-Erweiterung ZipArchive.

Die optionale **Gutenberg-Palette** ergänzt nach dem Speichern bis zu vier Markenfarben neben vorhandenen Themefarben. Sie verändert keine bestehenden Inhalte und gestaltet nicht die Editoroberfläche.

## Changelog

### 0.16.1

- **Improved:** Footer-Layout von Daily Scripture übernommen, Dokumentationslink neben dem Changelog ergänzt und einen übersetzten Markenslogan eingefügt.
- **Misc:** DECKERWEB-Copyright in Plugin und Dokumentation auf 2022–2026 gesetzt.

### 0.16.0

- **New:** Kompakter Einstellungsfooter mit lokaler Dokumentation und Changelog-Dialogen.
- **Improved:** Inhaltlich abgestimmte englische und deutsche Markdown- und Text-Readmes.
- **Improved:** Einträge je Version nach New, Improved, Fixed und Misc sortiert.
- **Fixed:** HTML der Frontend-Toolbar-Checkbox korrigiert, fehlende deutsche Fehlermeldungen ergänzt und drei fehlende JavaScript-Übersetzungskennungen registriert.
- **Misc:** Lizenzdatei, Release-Notizen und Regeln für das Repository-Paket ergänzt.

### 0.15.1

- **Improved:** Kurze Pluginbeschreibung und GitHub-Dokumentation auf den gesamten Funktionsumfang aktualisiert.
- **Misc:** Zwei weitere Bannerentwürfe und zwei passende Iconentwürfe als SVG und PNG ergänzt.

### 0.15.0

- **New:** Anzeige ungespeicherter Änderungen und Warnung vor dem Verwerfen beim Neuladen oder Verlassen.
- **New:** Optionale Umgebungsbuchstaben auf generierten Favicons für Lokal, Entwicklung, Staging und Live.
- **New:** Kontrastprüfung neben den Schemakarten mit Farbempfehlungen bei Beispielwerten unter 4,5:1.
- **New:** Agentur-ZIP für Einstellungen und unterstützte lokale Rasterbilder mit Import zur Prüfung. Bilder werden sofort zur Mediathek hinzugefügt; SVG bleibt ausgeschlossen. ZipArchive erforderlich.
- **New:** Optionale Gutenberg-Palette mit vier Markenrollen neben vorhandenen Themefarben.

### 0.14.2

- **Fixed:** Einstellungslink „Farbschema“ auf der WordPress-Plugins-Seite ins Deutsche übersetzt.

### 0.14.1

- **New:** Kompakte Sprunglinks und Vorschauhilfe neben den Atmosphärenkarten ergänzt.
- **Improved:** Texte verdeutlichen Website-, Admin- und Builder-Favicons in Browser-Tabs.
- **Improved:** Fixierten Speicherbutton erklärt und Import/Export mit Hinweis auf im JSON nicht enthaltene Bilder in einem eigenen Bereich zusammengefasst.

### 0.14.0

- **New:** Kontextabhängige Favicons für Website, WordPress-Admin und erkannte Bricks-, Elementor- oder Oxygen-Editoransichten. Bei bestehenden Installationen zunächst ausgeschaltet.
- **New:** SVG-Icon-Generator für drei Kontexte mit Kürzeln, Umrisssymbolen, abgeleiteten oder eigenen Farben und Live-Vorschauen. Frontend kann das WordPress-Website-Icon behalten.
- **Misc:** Sichere, generierte SVG-Daten-URIs statt eingefügtem SVG-Markup oder Änderungen am Website-Icon-Medieneintrag.

### 0.13.0

- **New:** Breites Kundenbanner als Alternative zu Logo oder Website-Icon, maximal so breit wie das Loginformular.
- **New:** Optionale kurze Zitatbox mit Quellenangabe auf der Bild- oder Verlaufsfläche.
- **Improved:** Acht weichere Schemapaletten-Verläufe und eine stabile Überraschungsvariante als Live-Farbvorschauen. Bestehende Verlaufsnamen bleiben erhalten.

### 0.12.3

- **New:** Linksbündige oder zentrierte Ausrichtung der Login-Inhalte; Standard linksbündig. Formularfelder bleiben gut erfassbar.
- **Improved:** SVG-Icons für Ausrichtungsoptionen und Desktop-, Tablet- und Mobilvorschau.

### 0.12.2

- **Fixed:** Lange Logintitel ausgewogener umgebrochen; kurze Rechtsformzusätze bleiben beim vorherigen Wort, lange Einzelwörter erzeugen keinen horizontalen Überlauf.
- **Fixed:** Dasselbe Titelverhalten auf die Einstellungsvorschau angewendet.

### 0.12.1

- **Fixed:** Schemahintergrund bleibt auch unter Formular und Datenschutzlink auf hohen oder scrollbaren Bildschirmen durchgehend.
- **Fixed:** WordPress-Sprachauswahl positioniert, ohne eine zusätzliche Desktop-Grid-Zeile zu erzeugen.

### 0.12.0

- **New:** Websitetitel, Slogan und Website-Icon automatisch verwendet, mit unabhängigen Textänderungen und Sichtbarkeitsschaltern; Theme-Logo als Fallback.
- **New:** Drei schemabasierte Verläufe und eine stabile Überraschungsvariante ergänzt.
- **New:** Bestätigte SVG-Logoauswahl nur für Administratoren mit aktivem Safe SVG; keine unbearbeiteten SVG-Uploads.
- **Improved:** Hintergrund der Formularseite aus dem Schema abgeleitet und manuell überschreibbar gemacht; Akzentbutton auf volle Breite gesetzt und Abstände verbessert.

### 0.11.0

- **New:** Responsive Login-Gestaltung mit geteilten und zentrierten Layouts, Kundenlogo, Hintergrundbild, Fokus- und Überlagerungsreglern sowie Willkommenstext.
- **New:** Schemabasierte oder eigene Loginfarben und Desktop-/Tablet-/Mobilvorschauen bei Beibehaltung der WordPress-Formulare.
- **Improved:** Logineinstellungen in Import/Export aufgenommen; bestehende Installationen behalten bis zur Aktivierung das bisherige Erscheinungsbild.

### 0.10.0

- **New:** Vier semantische Umgebungsfarben, die sich der Toolbar anpassen und einen angrenzenden Kontrast von 3:1 anstreben.
- **New:** Optionale eigene Statusfarben mit sofortiger Vorschau und übertragbaren JSON-Einstellungen.
- **Improved:** Badge-Icon und Textfarbe für helle Hintergründe angepasst.

### 0.9.2

- **Fixed:** Einstellungstitel, Untertitel, Ladetext und fixierter Header als „Markenfarben im Admin“ übersetzt. Englischer Plugin- und Repositoryname bleiben bestehen.

### 0.9.1

- **New:** Administrator-Untermenü mit PHP-Version und WP_DEBUG-Status ergänzt.
- **Fixed:** Umgebungsfarbe füllt jetzt den vollständigen Toolbarbereich.

### 0.9.0

- **New:** Kompaktes Umgebungsbadge mit vier eigenen SVG-Icons für Frontend- und Backend-Toolbar.
- **New:** Manuelle Umgebungsanzeige und Live-Vorschau sowie Plugin-Icon in der Einstellungsüberschrift.
- **New:** WordPress-Umgebung zuerst geprüft; bei unkonfiguriertem Produktionsstandard lokale und Staging-/Entwicklungsadressen erkannt, einschließlich .local, 127/8 und IPv6-Loopback.

### 0.8.0

- **Improved:** Frontend-Toolbarfarben an gespeicherte Atmosphäre und Markennähe angepasst, mit Farbtonvorschau; vorhandene Schemas erhalten dies beim erneuten Speichern.
- **Improved:** Farbvorschauen neben gewählten Core-Framework-, Bricks- und ACSS-Rollenfarben.
- **Misc:** Internen Core-Framework-Palettenleser in coreframework_colors() umbenannt, gespeicherte Quellenkennungen beibehalten.
- **Misc:** PHP-Formatierung und Inline-Dokumentation verbessert.

### 0.7.0

- **Misc:** GitHub-Release-Updater in eine wiederverwendbare, versionierte V1-Klasse für DECKERWEB-Plugins ausgelagert.

### 0.6.0

- **New:** WordPress-Updateintegration für öffentliche GitHub-Releases, einschließlich Releasedetails und Quellcode-ZIP-Fallback.

### 0.5.1

- **Improved:** Mehr Abstand oberhalb des letzten Vorschau- und Übernahmebereichs.

### 0.5.0

- **New:** Kontrastindikatoren, Vergleich geänderter Quellfarben und Rücknahme des letzten Speicherns.
- **Fixed:** Doppelte PHP-Methoden aus dem Prototyp 0.4.0 entfernt. Version 0.4.0 nicht installieren.

### 0.4.0

- **New:** Einstellungslink „Farbschema“ und deutsche Übersetzungen ergänzt. Dieser Prototyp wurde durch Version 0.5.0 und spätere ersetzt.

### 0.3.1 und frühere Prototypen

- **New:** Atmosphärenvorschläge, Markennäheregler, Hover-/Fokusvorschau, benannte Schemas, JSON-Übertragung, Frontend-Toolbarfarbe, Providerpaletten und Benutzervorgaben eingeführt.

## Umfang und Lizenz

WordPress 6.4+ und PHP 8.0+ sind deklarierte Mindestziele; eine vollständige Kompatibilitätsmatrix wurde noch nicht durchgetestet. Die Vorschau gestaltet Menü, Toolbar und primäre Buttons; das gespeicherte Styling zusätzlich Links. Andere Plugins können CSS-Regeln überschreiben. Der GitHub-Updatepfad benötigt noch den oben beschriebenen Staging-Test.

Autor: David Decker – DECKERWEB. Copyright © 2022–2026 David Decker – DECKERWEB. [GPL v2 oder höher](https://www.gnu.org/licenses/gpl-2.0.html) (`GPL-2.0-or-later`). Repository: [github.com/deckerweb/brand-admin-schemes](https://github.com/deckerweb/brand-admin-schemes).
