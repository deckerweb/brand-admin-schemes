=== Brand Admin Schemes ===
Contributors: deckerweb
Tags: admin colors, branding, login, favicon, gutenberg
Requires at least: 6.4
Requires PHP: 8.0
Tested up to: 7.1.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Markenfarben für WordPress-Admin, Login, Toolbar und Browser-Tabs.

== Description ==

**Deine Farben. Dein WordPress.** Wenige Markenfarben genügen für einen vertrauten WordPress-Admin, einen schönen Login und Browser-Tabs, die du sofort auseinanderhalten kannst. Verwende Core Framework, Bricks Builder, Automatic.css oder deine eigene Palette. Atmosphäre und Markennähe ausprobieren, Vorschau prüfen, speichern. Kein eigenes CSS nötig.


[Download](https://github.com/deckerweb/brand-admin-schemes/releases/latest) · [Anleitung](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) · [English](README.md)

== Auf einen Blick ==

* Den Admin vertraut gestalten: vier Atmosphären, ein Regler für die Markennähe, Vorschau per Hover und Tastatur sowie bis zu 30 benannte Schemas.
* Vorhandene Farben nutzen: optionale Anbindungen an Core Framework, Bricks und ACSS; eigene Farben funktionieren immer.
* Kunden willkommen heißen: responsive Login-Layouts, Logo oder kleines Banner, Hintergrundfoto oder neun sanfte Verläufe, eigene Texte und ein optionales Zitat.
* Browser-Tabs sofort erkennen: unterschiedliche Favicons für Website, Admin und erkannten Builder-Editor.
* Die Umgebung im Blick behalten: kompakte Badges für Lokal, Entwicklung, Staging und Live in der Frontend- und Backend-Toolbar, mit passenden Farben und optionalen Favicon-Markern.
* Projekte leichter betreuen: JSON-Einstellungen, Agentur-ZIP mit unterstützten Login-Bildern, Vergleich geänderter Quellfarben, Rücknahme und Hinweise auf ungespeicherte Änderungen.
* WordPress vertraut bedienen: optionale Standardschemas, Frontend-Toolbarfarben, Gutenberg-Palette, mitgelieferte deutsche Übersetzungen und reguläre WordPress-Updates.


== Installation ==

1. Lade das **Plugin-ZIP** aus den [GitHub-Releases](https://github.com/deckerweb/brand-admin-schemes/releases/latest).
2. Installiere es über **Plugins → Plugin hinzufügen → Plugin hochladen** und aktiviere es.
3. Öffne **Einstellungen → Markenfarben im Admin**, wähle eine Palette und stelle Atmosphäre und Markennähe ein.
4. Prüfe eine Schemakarte per Hover oder Tastaturfokus. Wähle deinen Favoriten, vergib optional einen Namen und speichere über die fixierte Leiste oben.
5. Mit **Seite neu laden** siehst du das gespeicherte Ergebnis vollständig im aktuellen Adminbildschirm.

Alles wird auf einer Einstellungsseite verwaltet. Login-Gestaltung und generierte Tab-Icons sind optional; aktiviere und speichere sie bei Bedarf.


== Markenfarben und Adminschemas ==

Ordne Farben den Rollen **Primary, Secondary, Tertiary und Akzent** zu. Drei Farben genügen: Tertiary kann das Plugin ableiten. Atmosphäre und Regler erzeugen passende Töne für Menüs, Toolbar, Buttons und Links. Persönliche Benutzerfarben lassen sich beibehalten, ein Standard anbieten oder das aktive Schema für alle festlegen.

Gespeicherte Farben bleiben erhalten, wenn der Provider später fehlt. Bei Änderungen an der Quelle kannst du alte und neue Farben vergleichen, bevor du ein aktualisiertes Schema speicherst. Die Kontrastprüfung der Beispiele hilft beim Einschätzen der Lesbarkeit.


== Favicons für Browser-Tabs ==

Erkenne sofort, ob ein Browser-Tab die **öffentliche Website**, den **WordPress-Admin** oder den **Builder-Editor** zeigt. Erstelle Favicons aus einem kurzen Kürzel oder einem Umrisssymbol, mit Schemafarben oder eigenen Farben. Vorgaben erkennen unterstützte Editorkontexte von Bricks, Elementor und Oxygen.

Im Frontend darf das vorhandene WordPress-Website-Icon erhalten bleiben. Optionale Umgebungsbuchstaben unterscheiden Lokal, Entwicklung, Staging und Live. Die Funktion verändert das Icon im Browser-Tab; der in WordPress gespeicherte Website-Icon-Eintrag bleibt bestehen.


== Login und Toolbar ==

Die Login-Gestaltung folgt deiner aktiven Palette. Wähle ein geteiltes oder zentriertes Layout und ergänze optional Foto, Logo oder kleines Banner. Website-Icon, Websitetitel und Slogan liefern sinnvolle Vorgaben. Neun Verläufe und eine optionale Zitatbox gestalten die Bildfläche. Prüfe Desktop, Tablet und Mobil vor dem Speichern.

Die Frontend-Toolbar kann eine passend zur Atmosphäre berechnete Schemafarbe verwenden. Ein kompaktes Umgebungsbadge erscheint in Frontend und Backend. Die Erkennung berücksichtigt WordPress-Umgebungen, Local-App-Websites mit `.local` und localhost-Adressen; manuelle Auswahl und eigene Statusfarben sind möglich.


== Import, Export und Gutenberg ==

Übertrage Einstellungen und gespeicherte Schemas als **JSON** oder unterstützte lokale Login-Bilder zusätzlich in einem **Agentur-ZIP**. Prüfe importierte Einstellungen und speichere zum Anwenden. ZIP-Importe legen enthaltene Bilder sofort in der Mediathek an und benötigen PHP ZipArchive. SVG-Dateien sind von diesen Paketen ausgeschlossen.

Auf Wunsch stehen die vier benannten Markenfarben neben der Theme-Palette in Gutenberg bereit. Vorhandene Inhalte behalten ihre Farben.


== Updates und Dokumentation ==

Updates kommen direkt aus dem [DECKERWEB-Plugin-Repository auf GitHub](https://github.com/deckerweb/brand-admin-schemes/releases) und erscheinen im **regulären WordPress-Updatesystem**. Aktualisiere wie gewohnt über Plugins oder Aktualisierungen; ein zusätzliches Updater-Plugin ist nicht nötig.

Die [deutsche Wiki-Anleitung](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) und die [englische Wiki-Anleitung](https://github.com/deckerweb/brand-admin-schemes/wiki/English) erklären alle Einstellungen, Farbquellen, Login-Bilder, Tab-Icons und häufige Fragen. Der Footer der Einstellungsseite verlinkt die Anleitung in deiner Sprache und öffnet den jüngsten lokalen Verlauf mit einem Link zur vollständigen Historie. Deutsch ist enthalten und folgt der WordPress-Website- oder Benutzersprache.


== Frequently Asked Questions ==

= Wie funktioniert der neue Farbdialog? =
Neben einem bearbeitbaren HEX-Feld auf Farbe auswählen klicken. Eine Farbe visuell prüfen oder ihren HEX-Wert eingeben. Fertig schließt den Dialog; mit Alle Änderungen speichern das Branding übernehmen. Gesperrte Rollen vor dem Bearbeiten entsperren.

= Kann ich Branding auf einer anderen Website verwenden? =
Eine portable Vorlage oder ein Agentur-ZIP exportieren. Portable Vorlagen schließen Bilder, Website-Texte, Kürzel und erzwungene Benutzervorgaben aus. Bilder auf der Zielwebsite auswählen. Beim Agenturimport werden Bilder sofort hinzugefügt; Einstellungen anschließend prüfen und speichern.

= Was passiert, wenn ein anderer Editor zuerst speichert? =
Die veraltete Speicherung wird abgewiesen. Deinen Entwurf vor dem Neuladen exportieren und mit dem aktuellen Stand vergleichen.

= Wie funktioniert der Verlauf? =
Auf dieser Website bleiben bis zu zehn frühere Einstellungsstände erhalten. Du kannst Einträge deines Kontos und Speicherbereichs wiederherstellen. Dabei wird auch deine vorherige persönliche Farbe übernommen und ein ungespeicherter Entwurf ersetzt; der aktuelle Stand wird zum neuen Verlaufseintrag.

= Kann das Netzwerk Branding automatisch verteilen? =
Eine optionale Netzwerk-Startvorlage wird einmalig auf neu angelegte Websites angewendet. Vorhandenes Branding wird nie überschrieben. Es gibt keine laufende Vererbung oder Synchronisierung. Leitstand ist optional.

= Ersetzt BAS das WordPress-Website-Icon? =
Im Frontend bleibt es standardmäßig erhalten. Nur die separate, ausdrücklich bestätigte Aktion Als offizielles Website-Icon verwenden ersetzt es. Medienaktionen wirken sofort und sind vom Speichern des Editorentwurfs unabhängig.

= Was passiert bei der Deinstallation? =
Branding, Bilder und persönliche Farben bleiben erhalten. Temporäres Undo und Schreibsperren werden entfernt. Die optionale Bereinigung entfernt nur gespeicherte Vorlagen und Verlauf dieser Website; sie ist standardmäßig aus. Netzwerk-Startvorlagen bleiben erhalten.

[Alle Fragen nach Themen](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-Deutsch)


== Geführte Einrichtung ==

Die optionale geführte Einrichtung führt durch Farben, Atmosphäre, Login und Tab-Icons sowie Prüfung und Speichern. Sie verwendet den vorhandenen Entwurf, lässt sich erneut öffnen und übernimmt Änderungen erst beim ausdrücklichen Speichern.

== Website-Zustand ==

Ein kompakter, rein informativer Bereich unter Werkzeuge → Website-Zustand zeigt die Schema-Auswahl, Palettenquelle, den Standardmodus für Benutzer, optionale Gestaltung und die erkannte Umgebung. Es erfolgen keine Status-Tests, Dateiprüfungen oder externen Abfragen.

== Multisite und Leitstand ==

Einzeln oder netzwerkweit aktivierbar. Jede Website verwaltet ihre eigenen Schemen, Login-Einstellungen, Toolbar, Browser-Tab-Icons und Medien. Auch die persönliche Farbauswahl bleibt je Website getrennt. Neue Unterwebsites erhalten die Administrator-Berechtigung für Tab-Icons automatisch; bestehende Websites beim ersten berechtigten Aufruf. Bewusst entzogene Rechte werden nicht wieder vergeben. Einstellungen findest du im Admin der jeweiligen Website.

BAS funktioniert ohne Leitstand. Leitstand kann die regulären WordPress-Site-Optionen lesen und auf den dokumentierten Änderungshook reagieren. Ein optionales Leitstand-Modul verlinkt die Website-Einstellungen. Netzwerk-Startvorlagen lassen sich auf jeder Website prüfen und ausdrücklich übernehmen. Die deckerweb Plugin Library 0.6.0 ist eingebettet; BAS-Updates liefert weiterhin der Updater V2 über WordPress.



[Daten und Deinstallation](docs/DATA-de.md) · [Sicherheit](SECURITY-de.md) · [Kompatibilität](docs/PROFILE-de.md)



== Branding-Abläufe ==

Den Farbdialog für Marken-, Login-, Umgebungs- und Favicon-Farben verwenden. Gesperrte Rollen behalten exakte Markenfarben. Schemas duplizieren oder umbenennen, einen Abschnitt zurücksetzen, gespeicherten Stand und Entwurf vergleichen und Importe vor dem Speichern prüfen. Portable Vorlagen schließen lokale Bilder und Website-Texte aus. Der Verlauf behält bis zu zehn Einstellungsstände; Wiederherstellen ersetzt den Entwurf und betrifft die persönliche Farbe auf dieser Website.
== Screenshots ==

1. Eigene Markenfarben und Speicherleiste in einer echten WordPress-Testwebsite.

== Changelog ==

Sieben jüngste Versionen; Wiki und lokaler vollständiger Verlauf erhalten alle dokumentierten Einträge.

= 1.0.0 =

2026-10-06

* Verbessert: Portable Exporte unabhängig vom Schema benennen und Netzwerk-Startvorlagen auf einzelnen Websites vor dem Speichern prüfen. Netzwerkvorlagen bleiben durch Netzwerkadministratoren verwaltet.
* Behoben: Gespeicherte Multisite-Startvorlage mit Name und Status anzeigen, Speicherung bestätigen und bestätigtes Entfernen ohne Änderung bestehenden Website-Brandings anbieten.
* Neu: Alle bearbeitbaren Farben im gemeinsamen Dialog mit HEX-Eingabe, Farbvorschau und Tastaturbedienung auswählen.
* Neu: Markenfarben sperren, Kontrastanpassungen prüfen und gespeichertes Branding mit dem Entwurf vergleichen.
* Neu: Portable Branding-Vorlagen speichern und bis zu zehn jüngste Einstellungsstände wiederherstellen.
* Neu: Neue Multisite-Websites optional mit einer Netzwerk-Startvorlage einrichten; vorhandenes Branding bleibt unabhängig.
* Neu: Website-Branding über die optionale Leitstand-Anbindung öffnen.
* Verbessert: Schemas duplizieren, umbenennen oder entfernen, einzelne Abschnitte zurücksetzen und Importänderungen vor der Übernahme prüfen.
* Behoben: Veraltete Editor-Speicherungen abweisen und Updatepakete bei Einzel- und Sammelupdates prüfen.
* Verbessert: Live-Vorschauen bündeln und Provider-Daten innerhalb eines Seitenaufrufs wiederverwenden.
* Sonstiges: Behält den eingebetteten Plugin-Katalog und GitHub-Updates bei.
* Sonstiges: Enthält deckerweb Plugin Library 0.6.0 und deckerweb Updater 2.1.0.

= 0.18.0 =

2026-10-05

* Neu: Optionale geführte Einrichtung mit vier Schritten.
* Neu: Informativer Bericht mit acht Feldern unter Werkzeuge → Website-Zustand, ohne zusätzliche Tests oder externe Aufrufe.
* Verbessert: Tab-Icons bieten Sichtbarkeitsauswahl, Anzeige-Berechtigung, Downloads, PNG-Mediathek-Aktionen und Übernahme als offizielles Website-Icon.
* Verbessert: Ergänzt Netzwerkaktivierung, persönliche Farbauswahl je Website, Profil-/AJAX-/Undo-Isolation und neue Unterwebsites.
* Verbessert: Liefert Deutsch mit Du und Sie, gemeinsame Dokumentationsquellen, einen datierten lokalen Änderungsverlauf und lokalisierte GitHub-Banner.
* Behoben: Speichert AJAX-Farbänderungen im Netzwerk-Profil global und weist Undo-Snapshots aus einem anderen Speicherbereich ab.
* Behoben: Prüft Upload-Rechte und freien Multisite-Speicher für Agenturbilder und PNG-Icons.
* Behoben: Hält Speicheraktionen und lange übersetzte Auswahlfelder innerhalb schmaler Adminbildschirme.
* Behoben: Erhält benannte Schemafarben bei der Validierung und schützt spätere persönliche Farbänderungen vor Undo.
* Sonstiges: Enthält deckerweb Plugin Library 0.5.0; Updater V2 bleibt erhalten.
* Sonstiges: Dokumentiert Sicherheitsmeldungen und Datenhaltung; die Deinstallation bereinigt temporäres Undo und den Updater-Cache und erhält Branding, Medien und Benutzerauswahl.

= 0.17.0 (Entwicklung) =

Veröffentlichungsdatum nicht dokumentiert

* Neu: Kompakter, rein informativer Website-Zustand-Bericht ohne Status-Tests.

= 0.16.3 =

2026-09-30

* Verbessert: Zeigt das Plugin-Icon in WordPress-Updateangeboten und englische beziehungsweise deutsche Banner in den Plugindetails.
* Verbessert: Verlinkt die Footer-Dokumentation direkt ins sprachabhängige Wiki und öffnet den vollständigen mitgelieferten Änderungsverlauf in einem zugänglichen lokalen Dialog.
* Behoben: Ergänzt fehlende Updategrafiken, auch bei bereits gespeicherten Updateangeboten nach Installation dieser Version.
* Sonstiges: Verwendet den gemeinsamen DECKERWEB GitHub-Updater V2 mit pluginspezifischer Prüfung von Paketidentität und Voraussetzungen.

= 0.16.2 =

2026-09-30

* Verbessert: Überarbeitet alle vier Readmes mit verständlichen Funktionsübersichten, sieben kurzen FAQs und den letzten fünf Versionseinträgen.
* Verbessert: Ergänzt ein deutsches GitHub-Banner und erweitert das zweisprachige Wiki um 49 thematisch gegliederte FAQ-Antworten je Sprache und vollständige Änderungsverläufe.
* Verbessert: Ergänzt geprüfte Sprungmarken, stellt Browser-Tab-Favicons bei den Hauptfunktionen vor und erklärt GitHub-Updates über das reguläre WordPress-Updatesystem.
* Sonstiges: Liefert die aktualisierte englische und deutsche Dokumentation mit diesem Release aus.

= 0.16.1 =

2026-09-29

* Verbessert: Footer-Layout von Daily Scripture übernommen, Dokumentationslink neben dem Changelog ergänzt und einen übersetzten Markenslogan eingefügt.
* Sonstiges: DECKERWEB-Copyright in Plugin und Dokumentation auf 2022–2026 gesetzt.

= 0.16.0 =

Veröffentlichungsdatum nicht dokumentiert

* Neu: Kompakter Einstellungsfooter mit lokaler Dokumentation und Changelog-Dialogen.
* Verbessert: Inhaltlich abgestimmte englische und deutsche Markdown- und Text-Readmes.
* Verbessert: Einträge je Version nach Neu, Verbessert, Behoben und Sonstiges sortiert.
* Behoben: HTML der Frontend-Toolbar-Checkbox korrigiert, fehlende deutsche Fehlermeldungen ergänzt und drei fehlende JavaScript-Übersetzungskennungen registriert.
* Sonstiges: Lizenzdatei, Release-Notizen und Regeln für das Repository-Paket ergänzt.

== Über das Plugin ==

Entwickelt von **David Decker – DECKERWEB**, damit Kunden ihre Marke auf beiden Seiten des Logins wiedererkennen. Einige Ideen wurden seit 2022 in eigenen Snippets eingesetzt.

Das Schema gestaltet den WordPress-Adminrahmen; fremdes CSS kann einzelne Elemente beeinflussen. Gutenberg-Inhalte und Builder-Arbeitsflächen behalten ihr eigenes Design. SVG-Loginbilder benötigen Safe SVG und eine Administratorbestätigung. Mehr dazu im Wiki.

Eine Idee oder einen Fehler gefunden? [Melde dich auf GitHub](https://github.com/deckerweb/brand-admin-schemes/issues).

© 2022–2026 David Decker – DECKERWEB · [GPL v2 oder höher](LICENSE)

== Berechtigungen für Tab-Icons ==

Standardmäßig sehen nur angemeldete Benutzer mit `bas_view_context_icons` die kontextabhängigen Favicons; die Administratorrolle erhält diese Berechtigung einmalig. Über einen Rollen-Editor kannst du anderen Rollen oder Benutzern die Anzeige erlauben, ohne Zugriff auf Plugin-Einstellungen zu geben. Wähle **Alle, einschließlich Besucher** und speichere, um die Anzeige für alle freizugeben. Bei eingeschränkter Anzeige behalten Besucher das offizielle WordPress-Website-Icon. Unter **Verwenden und exportieren** kannst du jede erzeugte Gestaltung als SVG oder PNG mit 512 × 512 Pixeln herunterladen, als PNG in der Mediathek speichern oder als offizielles WordPress-Website-Icon übernehmen. Mediathek-Aktionen wirken sofort, unabhängig vom Einstellungsentwurf. Die Übernahme als Website-Icon erfordert eine Bestätigung, lässt den Umgebungsmarker weg und stellt den gespeicherten Frontend-Favicon-Modus auf das WordPress-Website-Icon um. Andere Entwürfe bleiben ungespeichert; bisherige Bilder bleiben in der Mediathek. SVG-Downloads erlauben keine SVG-Uploads.
