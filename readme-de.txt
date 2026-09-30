=== Brand Admin Schemes ===
Contributors: deckerweb
Tags: admin colors, branding, login, favicon, gutenberg
Requires at least: 6.4
Requires PHP: 8.0
Stable tag: 0.16.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Deine Farben. Dein WordPress. Wenige Markenfarben genügen für einen vertrauten WordPress-Admin, einen schönen Login und Browser-Tabs, die du sofort auseinanderhalten kannst. Verwende Core Framework, Bricks Builder, Automatic.css oder deine eigene Palette. Atmosphäre und Markennähe ausprobieren, Vorschau prüfen, speichern. Kein eigenes CSS nötig.

Version: 0.16.1 · Voraussetzungen: WordPress 6.4+ / PHP 8.0+ · Lizenz: GPL v2 oder höher

Download (https://github.com/deckerweb/brand-admin-schemes/releases/latest) · Anleitung (https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) · English (https://github.com/deckerweb/brand-admin-schemes/blob/main/README.md)

== Inhaltsverzeichnis ==

- Auf einen Blick
- Installation und erstes Schema
- Markenfarben und Adminschemas
- Favicons für Browser-Tabs
- Login und Toolbar
- Import, Export und Gutenberg
- Updates und Dokumentation
- Häufige Fragen
- Changelog
- Über das Plugin

== Auf einen Blick ==

- Den Admin vertraut gestalten: vier Atmosphären, ein Regler für die Markennähe, Vorschau per Hover und Tastatur sowie bis zu 30 benannte Schemas.
- Vorhandene Farben nutzen: optionale Anbindungen an Core Framework, Bricks und ACSS; eigene Farben funktionieren immer.
- Kunden willkommen heißen: responsive Login-Layouts, Logo oder kleines Banner, Hintergrundfoto oder neun sanfte Verläufe, eigene Texte und ein optionales Zitat.
- Browser-Tabs sofort erkennen: unterschiedliche Favicons für Website, Admin und erkannten Builder-Editor.
- Die Umgebung im Blick behalten: kompakte Badges für Lokal, Entwicklung, Staging und Live in der Frontend- und Backend-Toolbar, mit passenden Farben und optionalen Favicon-Markern.
- Projekte leichter betreuen: JSON-Einstellungen, Agentur-ZIP mit unterstützten Login-Bildern, Vergleich geänderter Quellfarben, Rücknahme und Hinweise auf ungespeicherte Änderungen.
- WordPress vertraut bedienen: optionale Standardschemas, Frontend-Toolbarfarben, Gutenberg-Palette, mitgelieferte deutsche Übersetzungen und reguläre WordPress-Updates.

== Installation und erstes Schema ==

1. Lade das Plugin-ZIP aus den GitHub-Releases (https://github.com/deckerweb/brand-admin-schemes/releases/latest).
2. Installiere es über Plugins → Plugin hinzufügen → Plugin hochladen und aktiviere es.
3. Öffne Einstellungen → Markenfarben im Admin, wähle eine Palette und stelle Atmosphäre und Markennähe ein.
4. Prüfe eine Schemakarte per Hover oder Tastaturfokus. Wähle deinen Favoriten, vergib optional einen Namen und speichere über die fixierte Leiste oben.
5. Mit Seite neu laden siehst du das gespeicherte Ergebnis vollständig im aktuellen Adminbildschirm.

Alles wird auf einer Einstellungsseite verwaltet. Login-Gestaltung und generierte Tab-Icons sind optional; aktiviere und speichere sie bei Bedarf.

== Markenfarben und Adminschemas ==

Ordne Farben den Rollen Primary, Secondary, Tertiary und Akzent zu. Drei Farben genügen: Tertiary kann das Plugin ableiten. Atmosphäre und Regler erzeugen passende Töne für Menüs, Toolbar, Buttons und Links. Persönliche Benutzerfarben lassen sich beibehalten, ein Standard anbieten oder das aktive Schema für alle festlegen.

Gespeicherte Farben bleiben erhalten, wenn der Provider später fehlt. Bei Änderungen an der Quelle kannst du alte und neue Farben vergleichen, bevor du ein aktualisiertes Schema speicherst. Die Kontrastprüfung der Beispiele hilft beim Einschätzen der Lesbarkeit.

== Favicons für Browser-Tabs ==

Erkenne sofort, ob ein Browser-Tab die öffentliche Website, den WordPress-Admin oder den Builder-Editor zeigt. Erstelle Favicons aus einem kurzen Kürzel oder einem Umrisssymbol, mit Schemafarben oder eigenen Farben. Vorgaben erkennen unterstützte Editorkontexte von Bricks, Elementor und Oxygen.

Im Frontend darf das vorhandene WordPress-Website-Icon erhalten bleiben. Optionale Umgebungsbuchstaben unterscheiden Lokal, Entwicklung, Staging und Live. Die Funktion verändert das Icon im Browser-Tab; der in WordPress gespeicherte Website-Icon-Eintrag bleibt bestehen.

== Login und Toolbar ==

Die Login-Gestaltung folgt deiner aktiven Palette. Wähle ein geteiltes oder zentriertes Layout und ergänze optional Foto, Logo oder kleines Banner. Website-Icon, Websitetitel und Slogan liefern sinnvolle Vorgaben. Neun Verläufe und eine optionale Zitatbox gestalten die Bildfläche. Prüfe Desktop, Tablet und Mobil vor dem Speichern.

Die Frontend-Toolbar kann eine passend zur Atmosphäre berechnete Schemafarbe verwenden. Ein kompaktes Umgebungsbadge erscheint in Frontend und Backend. Die Erkennung berücksichtigt WordPress-Umgebungen, Local-App-Websites mit .local und localhost-Adressen; manuelle Auswahl und eigene Statusfarben sind möglich.

== Import, Export und Gutenberg ==

Übertrage Einstellungen und gespeicherte Schemas als JSON oder unterstützte lokale Login-Bilder zusätzlich in einem Agentur-ZIP. Prüfe importierte Einstellungen und speichere zum Anwenden. ZIP-Importe legen enthaltene Bilder sofort in der Mediathek an und benötigen PHP ZipArchive. SVG-Dateien sind von diesen Paketen ausgeschlossen.

Auf Wunsch stehen die vier benannten Markenfarben neben der Theme-Palette in Gutenberg bereit. Vorhandene Inhalte behalten ihre Farben.

== Updates und Dokumentation ==

Updates kommen direkt aus dem DECKERWEB-Plugin-Repository auf GitHub (https://github.com/deckerweb/brand-admin-schemes/releases) und erscheinen im regulären WordPress-Updatesystem. Aktualisiere wie gewohnt über Plugins oder Aktualisierungen; ein zusätzliches Updater-Plugin ist nicht nötig.

Die deutsche Wiki-Anleitung (https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) und die englische Wiki-Anleitung (https://github.com/deckerweb/brand-admin-schemes/wiki/English) erklären alle Einstellungen, Farbquellen, Login-Bilder, Tab-Icons und häufige Fragen. Lokale Dokumentation und Änderungsverlauf erreichst du im Footer der Einstellungsseite. Deutsch ist enthalten und folgt der WordPress-Website- oder Benutzersprache.

== Häufige Fragen ==

Brauche ich Core Framework, Bricks oder ACSS? Nein. Eigene Farben genügen; Farbprovider sind optional.

Was passiert, wenn ich einen Farbprovider deaktiviere? Gespeicherte Schemafarben bleiben verfügbar. Der Provider wird zum erneuten Einlesen der Palette benötigt, nicht zur Darstellung gespeicherter Farben.

Verändert das Plugin mein Website- oder Builderdesign? Es gestaltet den Adminrahmen, optional Login und Toolbar sowie Browser-Tab-Icons. Seiteninhalte und Builder-Arbeitsflächen behalten ihr Design; Gutenberg-Paletteneinträge ergänzen nur die Farbauswahl.

Brauche ich ein Logo und ein Hintergrundfoto? Nein. Website-Icon, Theme-Logo und Websitename liefern Rückfalloptionen; die Farbverläufe funktionieren ohne Foto.

Ersetzt es das WordPress-Website-Icon? Nein. Es erzeugt kontextabhängige Browser-Tab-Favicons, ohne das gespeicherte Website-Icon zu ändern. Das ursprüngliche Frontend-Favicon kann erhalten bleiben.

Verändert ein Import sofort die aktive Gestaltung? Nein. Prüfe importierte Einstellungen und speichere zum Anwenden. Agentur-ZIP-Importe legen enthaltene Bilder allerdings sofort in der Mediathek an.

Wie funktionieren Updates? Updates kommen aus dem öffentlichen DECKERWEB-Repository auf GitHub über das reguläre WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht nötig.

Alle Fragen nach Themen (https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-Deutsch)

== Changelog ==

= 0.16.1 =

- Verbessert: Footer-Layout von Daily Scripture übernommen, Dokumentationslink neben dem Changelog ergänzt und einen übersetzten Markenslogan eingefügt.
- Sonstiges: DECKERWEB-Copyright in Plugin und Dokumentation auf 2022–2026 gesetzt.

= 0.16.0 =

- Neu: Kompakter Einstellungsfooter mit lokaler Dokumentation und Changelog-Dialogen.
- Verbessert: Inhaltlich abgestimmte englische und deutsche Markdown- und Text-Readmes.
- Verbessert: Einträge je Version nach Neu, Verbessert, Behoben und Sonstiges sortiert.
- Behoben: HTML der Frontend-Toolbar-Checkbox korrigiert, fehlende deutsche Fehlermeldungen ergänzt und drei fehlende JavaScript-Übersetzungskennungen registriert.
- Sonstiges: Lizenzdatei, Release-Notizen und Regeln für das Repository-Paket ergänzt.

= 0.15.1 =

- Verbessert: Kurze Pluginbeschreibung und GitHub-Dokumentation auf den gesamten Funktionsumfang aktualisiert.
- Sonstiges: Zwei weitere Bannerentwürfe und zwei passende Iconentwürfe als SVG und PNG ergänzt.

= 0.15.0 =

- Neu: Anzeige ungespeicherter Änderungen und Warnung vor dem Verwerfen beim Neuladen oder Verlassen.
- Neu: Optionale Umgebungsbuchstaben auf generierten Favicons für Lokal, Entwicklung, Staging und Live.
- Neu: Kontrastprüfung neben den Schemakarten mit Farbempfehlungen bei Beispielwerten unter 4,5:1.
- Neu: Agentur-ZIP für Einstellungen und unterstützte lokale Rasterbilder mit Import zur Prüfung. Bilder werden sofort zur Mediathek hinzugefügt; SVG bleibt ausgeschlossen. ZipArchive erforderlich.
- Neu: Optionale Gutenberg-Palette mit vier Markenrollen neben vorhandenen Themefarben.

= 0.14.2 =

- Behoben: Einstellungslink „Farbschema“ auf der WordPress-Plugins-Seite ins Deutsche übersetzt.

Vollständiger Änderungsverlauf im Wiki (https://github.com/deckerweb/brand-admin-schemes/wiki/Changelog-Deutsch) · Releases (https://github.com/deckerweb/brand-admin-schemes/releases)

== Über das Plugin ==

Entwickelt von David Decker – DECKERWEB, damit Kunden ihre Marke auf beiden Seiten des Logins wiedererkennen. Einige Ideen wurden seit 2022 in eigenen Snippets eingesetzt.

Das Schema gestaltet den WordPress-Adminrahmen; fremdes CSS kann einzelne Elemente beeinflussen. Gutenberg-Inhalte und Builder-Arbeitsflächen behalten ihr eigenes Design. SVG-Loginbilder benötigen Safe SVG und eine Administratorbestätigung. Mehr dazu im Wiki.

Eine Idee oder einen Fehler gefunden? Melde dich auf GitHub (https://github.com/deckerweb/brand-admin-schemes/issues).

© 2022–2026 David Decker – DECKERWEB · GPL v2 oder höher (https://github.com/deckerweb/brand-admin-schemes/blob/main/LICENSE)
