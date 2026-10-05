# Anleitung

[English](https://github.com/deckerweb/brand-admin-schemes/wiki/English) · [Home](https://github.com/deckerweb/brand-admin-schemes/wiki)

Die praktische Anleitung zu Brand Admin Schemes 0.18.0 (unveröffentlichter Teststand). Springe über das Inhaltsverzeichnis direkt zur gewünschten Einstellung.

## Inhaltsverzeichnis

- [Installation und erstes Schema](#installation-und-erstes-schema)
- [Funktionsweise](#funktionsweise)
- [Favicons für Browser-Tabs](#favicons-fuer-browser-tabs)
- [Badge für die Installationsumgebung](#badge-fuer-die-installationsumgebung)
- [Login-Gestaltung](#login-gestaltung)
- [Schemas zwischen Websites übertragen](#schemas-zwischen-websites-uebertragen)
- [Prüfung und Übertragbarkeit](#pruefung-und-uebertragbarkeit)
- [Updates](#updates)
- [Übersetzungen](#uebersetzungen)
- [Erweiterungen](#erweiterungen)
- [Häufige Fragen](#haeufige-fragen)
- [Die Idee dahinter](#die-idee-dahinter)
- [Änderungsverlauf](#aenderungsverlauf)

<a name="installation-und-erstes-schema"></a>

## Installation und erstes Schema

1. Lade das Plugin-ZIP aus den [GitHub-Releases](https://github.com/deckerweb/brand-admin-schemes/releases), installiere es über **Plugins → Plugin hinzufügen → Plugin hochladen** und aktiviere es.
2. Öffne **Einstellungen → Markenfarben im Admin**. Der Link **Farbschema** auf der Plugins-Seite führt ebenfalls dorthin.
3. Wähle eine Farbquelle oder eigene Farben. Primary, Secondary und Akzent genügen; Tertiary lässt sich ableiten. Wähle Atmosphäre und Markennähe.
4. Prüfe eine Karte per Hover oder Tastaturfokus, wähle sie aus und gib optional einen Namen ein. Klicke oben auf **Alle Änderungen speichern**.
5. **Seite neu laden** zeigt das gespeicherte Ergebnis vollständig im aktuellen Adminbildschirm.

Die Einstellungsseite und Speicheraktionen erfordern die WordPress-Berechtigung `manage_options`.

<a name="funktionsweise"></a>

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

<a name="favicons-fuer-browser-tabs"></a>

## Favicons für Browser-Tabs

Aktiviere **Browser-Tab-Icons**, um Website, WordPress-Admin und einen erkannten Builder-Editor anhand eigener SVG-Favicons zu unterscheiden. Das bestehende WordPress-Website-Icon kann im Frontend erhalten bleiben. Bei vorhandenen Installationen startet die Funktion ausgeschaltet. Jeder Kontext bietet ein Kürzel mit bis zu drei Zeichen, einfache Umrisssymbole sowie automatische oder eigene Vorder- und Hintergrundfarben. Die Builder-Vorgabe folgt Bricks, Elementor oder Oxygen, sofern der Editor erkannt wird, oder wird manuell gewählt. Die geometrischen Symbole sind eigene Entwürfe, keine offiziellen Builderlogos.

Die Funktion betrifft den Browser-Tab im jeweiligen Kontext; sie ersetzt nicht den WordPress-Medieneintrag des Website-Icons. Die Erkennung beschränkt sich auf angemeldete Editoransichten mit bekannten Anfrageparametern. Öffentliche Seiten behalten ihren Frontendkontext. Wenn andere Plugins Favicons später überschreiben, kann die Ausgabereihenfolge eine Rolle spielen.

Optional kennzeichnen **L** (Lokal), **D** (Entwicklung), **S** (Staging) und **P** (Produktion/Live) generierte Favicons. Der Marker folgt der automatisch oder manuell gewählten Umgebung und lässt sich abschalten. Ein beibehaltenes WordPress-Website-Icon wird nicht verändert.

<a name="badge-fuer-die-installationsumgebung"></a>

## Badge für die Installationsumgebung

Das Badge erscheint im Admin und Frontend, wenn die WordPress-Toolbar sichtbar ist. Sein Hintergrund füllt die gesamte Toolbarhöhe; SVG-Icon und kurze Beschriftung benötigen wenig Breite. Tooltip und zugängliche Beschriftung nennen Umgebung und Erkennungsquelle. Für Administratoren zeigt das Untermenü bei Hover oder Tastaturfokus zusätzlich PHP-Version und `WP_DEBUG`-Status. Andere Benutzer sehen diese Laufzeitdetails nicht.

Wähle **Automatische Erkennung** oder **Lokal**, **Entwicklung**, **Staging** oder **Live**, speichere und lade neu. Die manuelle Auswahl steuert die Pluginanzeige einschließlich Favicon-Marker; sie ändert nicht die tatsächliche WordPress-Umgebung. Türkis für Lokal, Bernstein für Entwicklung, Violett für Staging und Grün für Live passen sich der Toolbar an und streben mindestens 3:1 Kontrast zwischen den Flächen an. Eigene Statusfarben behalten ihren Farbton; bei Bedarf wird ihre Helligkeit für den Kontrast angepasst. Die Textfarbe wechselt zwischen Hell und Dunkel. Die Vorschau zeigt die Kombination mit dem ausgewählten Schema.

Die Erkennung nutzt zuerst `wp_get_environment_type()`. Ein explizites `WP_ENVIRONMENT_TYPE` hat Vorrang, auch bei `production`. Liefert WordPress lediglich den unkonfigurierten Produktionsstandard, prüft das Plugin die gespeicherte Websiteadresse (`home_url()`): `localhost`, `.localhost`, `.test`, `.local` einschließlich Local App, gültige Adressen aus `127.0.0.0/8`, IPv6-Loopback `::1` einschließlich ausgeschriebener und IPv4-gemappter Varianten sowie die Präfixe `staging.`, `stage.`, `stg.`, `development.` und `dev.`. Andere Adressen gelten als Live. Domainnamen sind Hinweise; für abweichende Setups hilft die manuelle Auswahl.

<a name="login-gestaltung"></a>

## Login-Gestaltung

Aktiviere **Login-Gestaltung** und wähle **Bild links**, **Bild rechts** oder **Zentriert**. Das Standardlayout zeigt eine große Bildfläche neben dem vorhandenen WordPress-Formular. Auf kleinen Bildschirmen wird daraus ein kurzer Bannerbereich über dem Formular. Das zentrierte Layout verwendet einen vollflächigen Verlauf. Die Formularseite lässt sich unabhängig linksbündig oder zentriert ausrichten; linksbündig ist Standard.

Wähle Bilder über die WordPress-Mediathek. Ohne eigenes Logo nutzt das Plugin zuerst das Website-Icon, dann das Theme-Logo und schließlich den Websitetitel als Text. Ein kleines breites Banner kann das Logo ersetzen und bleibt innerhalb der Formularbreite. Ohne Hintergrundbild stehen acht sanfte, aus dem Schema berechnete Verläufe und eine für die Website stabile Überraschungsvariante als Farbvorschauen bereit. Bildposition und Überlagerungsstärke steuern Fokus und Farbstimmung eines Fotos. Optional ergänzt eine kurze Zitatbox mit Quellenangabe die Bild- oder Verlaufsfläche.

Überschrift und Untertitel übernehmen standardmäßig Websitetitel und Slogan. Beide lassen sich ändern und unabhängig ausblenden. „Willkommen zurück“ ist der Fallback bei fehlendem Titel. Prüfe Desktop, Tablet und Mobil in der Vorschau. Der Link in einem neuen Tab öffnet die **gespeicherte** Login-Gestaltung; ungespeicherte Änderungen bleiben in der Editorvorschau.

Die Loginfarben folgen dem aktiven Schema: dezenter Hintergrund auf der Formularseite, Akzentfarbe für den breiten Loginbutton. **Loginfarben individuell festlegen** überschreibt auf Wunsch Bildfläche, Seitenhintergrund, Formularfläche und Button. Anmeldung, Passwortwiederherstellung, Registrierung und andere WordPress-Formularaktionen bleiben erhalten. Bei bestehenden Installationen ist das Login-Styling zunächst ausgeschaltet.

JSON referenziert Bilder über lokale Medien-IDs und enthält keine Bilddateien. Wähle Bilder nach einem Wechsel der Installation erneut oder nutze das Agentur-ZIP. SVG-Logos oder -Banner erfordern das separate Plugin Safe SVG, eine Administratorbestätigung und einen bereinigten SVG-Medieneintrag. Dieses Plugin erlaubt keine unbearbeiteten SVG-Uploads.

<a name="schemas-zwischen-websites-uebertragen"></a>

## Schemas zwischen Websites übertragen

**Einstellungen als JSON exportieren** überträgt Einstellungen und bis zu 30 gespeicherte Schemas im Format `bas/v1`. Importiere, prüfe die Vorschau und speichere zum Aktivieren. Der Import allein aktiviert nichts. Für unterstützte lokale Login-Bilder gibt es das unten beschriebene Agentur-ZIP.

<a name="pruefung-und-uebertragbarkeit"></a>

## Prüfung und Übertragbarkeit

Ungespeicherte Änderungen werden angezeigt; vor dem Verlassen oder Neuladen warnt der Browser. Die Kontrastprüfung misst Beispieltexte für Admin und Login und schlägt bei Werten unter 4,5:1 eine Anpassung vor. Andere Plugins und Themes können das endgültige Erscheinungsbild beeinflussen.

Das **Agentur-ZIP** enthält Einstellungen sowie lokale PNG-, JPEG-, WebP- oder GIF-Dateien für Logo, Banner und Hintergrund. Pro Bild sind bis zu 4 MB erlaubt, das gesamte Importpaket bis zu 13 MB. SVG-Dateien sind ausgeschlossen. Importierte Bilder landen sofort in der Mediathek; die Einstellungen werden anschließend zur Prüfung geladen und erst beim Speichern angewendet. Der Server benötigt die PHP-Erweiterung ZipArchive.

Die optionale **Gutenberg-Palette** ergänzt nach dem Speichern bis zu vier Markenfarben neben vorhandenen Themefarben. Sie verändert keine bestehenden Inhalte und gestaltet nicht die Editoroberfläche.

<a name="updates"></a>

## Updates

Updates kommen aus dem [DECKERWEB-Plugin-Repository auf GitHub](https://github.com/deckerweb/brand-admin-schemes/releases) und erscheinen im regulären WordPress-Updatesystem. Öffne **Dashboard → Aktualisierungen** oder **Plugins** und aktualisiere Brand Admin Schemes wie gewohnt. Ein zusätzliches Updater-Plugin ist nicht erforderlich.

Wenn ein Update noch nicht erscheint, nutze **Erneut prüfen** auf der WordPress-Aktualisierungsseite. Alternativ kannst du das aktuelle Plugin-ZIP aus den GitHub-Releases herunterladen und über WordPress hochladen, um die installierte Version zu ersetzen.

Der eingebaute Updater schaltet automatische Updates nicht selbst ein.


<a name="uebersetzungen"></a>

## Übersetzungen

Englische Quelltexte und deutsche `de_DE`-Dateien (`.po`/`.mo`) sind enthalten. WordPress wählt die Sprache anhand von Website- oder Benutzerlocale. Die Textdomain lautet `brand-admin-schemes`, das Verzeichnis `/languages/`. Weitere Übersetzungen sind willkommen.

<a name="erweiterungen"></a>

## Erweiterungen

Der dokumentierte Hook bas_site_settings_changed meldet Website-ID und Vorgang save, undo oder site_icon. Eine spätere Leitstand-Anbindung benötigt dessen tatsächliche Schnittstellen; BAS hat keine Leitstand-Abhängigkeit.

<a name="haeufige-fragen"></a>

## Häufige Fragen

**Brauche ich Core Framework, Bricks oder ACSS?** Nein. Eigene Farben genügen; Farbprovider sind optional.

**Was passiert, wenn ich einen Farbprovider deaktiviere?** Gespeicherte Schemafarben bleiben verfügbar. Der Provider wird zum erneuten Einlesen der Palette benötigt, nicht zur Darstellung gespeicherter Farben.

**Verändert das Plugin mein Website- oder Builderdesign?** Es gestaltet den Adminrahmen, optional Login und Toolbar sowie Browser-Tab-Icons. Seiteninhalte und Builder-Arbeitsflächen behalten ihr Design; Gutenberg-Paletteneinträge ergänzen nur die Farbauswahl.

**Brauche ich ein Logo und ein Hintergrundfoto?** Nein. Website-Icon, Theme-Logo und Websitename liefern Rückfalloptionen; die Farbverläufe funktionieren ohne Foto.

**Ersetzt es das WordPress-Website-Icon?** Kontextabhängige Favicons erhalten das gespeicherte Website-Icon standardmäßig. Nur die gesonderte, ausdrücklich bestätigte PNG-Website-Icon-Aktion ersetzt es. Das ursprüngliche Frontend-Favicon kann erhalten bleiben.

**Verändert ein Import sofort die aktive Gestaltung?** Nein. Prüfe importierte Einstellungen und speichere zum Anwenden. Agentur-ZIP-Importe legen enthaltene Bilder allerdings sofort in der Mediathek an.

**Wie funktionieren Updates?** Updates kommen aus dem öffentlichen DECKERWEB-Repository auf GitHub über das reguläre WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht nötig.

[Alle Fragen nach Themen](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-Deutsch)

<a name="die-idee-dahinter"></a>

## Die Idee dahinter

Kunden sollen ihre Marke auch dort wiedererkennen, wo sie ihre Website pflegen. WordPress bietet Adminschemas, Frameworks und Builder liefern Markenpaletten. Brand Admin Schemes verbindet diese Farben mit einer einfachen visuellen Bedienung: Atmosphäre ausprobieren, Markennähe regeln, vertrautes Ergebnis speichern.

Entwickelt von David Decker – DECKERWEB für die Websites seiner Kunden. Viel Freude mit deinen Markenfarben! :-)

<a name="aenderungsverlauf"></a>

## Änderungsverlauf

[Vollständiger deutscher Änderungsverlauf](https://github.com/deckerweb/brand-admin-schemes/wiki/Changelog-Deutsch) · [GitHub-Releases](https://github.com/deckerweb/brand-admin-schemes/releases)

© 2022–2026 David Decker – DECKERWEB · GPL v2 oder höher

Der Footer verlinkt die deutsche beziehungsweise englische Wiki-Anleitung. Changelog öffnet die vollständige lokal mitgelieferte Historie; ohne JavaScript führt der Link zur passenden Changelog-Textdatei.

[Aktueller Stand und Abnahme](../PROFILE-de.md) · [Daten](../DATA-de.md) · [Vollständige FAQ](FAQ-Deutsch.md)
