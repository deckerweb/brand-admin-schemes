# Farbprovider

[English](PROVIDERS.md)

Öffne Einstellungen → Markenfarben im Admin → Farbquelle. WordPress / Website-Editor bietet Theme-Farben, eigene globale Farben und WordPress-Standardfarben getrennt an. Elementor nutzt Systemfarben und eigene globale Farben des aktiven Kits; Elementor Free genügt. Oxygen Classic liest seine globalen Farbsets mit ihren ursprünglichen Namen. Der Adapter ist für 4.x bestimmt und behandelt Oxygen 6+ nicht als Classic.

Quelle und Palette auswählen, Farben den vier Markenrollen zuordnen, Vorschau prüfen und speichern. Die Quellen werden nur gelesen; BAS verändert keine Originalpalette. Die optionale BAS-Gutenberg-Palette ist davon getrennt und wird beim Einlesen der nativen Quelle ausgeschlossen. Provider führen keine externen Anfragen aus. Zwischengespeicherte Ergebnisse gelten nur für einen Aufruf und sind nach Website, aktivem Theme und Oberflächensprache getrennt.

Unterstützt werden dreistellige/sechsstellige HEX-Werte, vollständig deckende achtstellige HEX-Werte und kommagetrennte RGB-/RGBA-Werte mit Deckkraft 1. Ausdrücke, Variablen und teiltransparente Werte entfallen. Quellen ohne nutzbare Farben bleiben verborgen. Fehlende Quellen oder Paletten führen zur manuellen Auswahl mit den gespeicherten Markenfarben zurück. Eine laufende Synchronisierung findet nicht statt.

Elementor Pro ist nicht nötig. Der Adapter nutzt das gemeinsame Kit-Farbmodell aus Free; Pro-spezifische Ergänzungen und Atomic-Variablensysteme gehören nicht zu diesem Adapter. Seiten- und Frontend-Farben werden nicht durchsucht. Bestehende JSON-/Vorlagenfunktionen übertragen gespeichertes Branding; portable Vorlagen enthalten konkrete Farben statt IDs fremder Websites.

In Multisite liest jede Website ihr eigenes Theme, aktives Kit und ihre Oxygen-Einstellungen. Ein nur auf einer anderen Website aktiver Provider wird nicht angeboten. Netzwerkaktivierung von BAS kopiert keine Farbeinstellungen.
