# Multisite und Integrationen

[English](MULTISITE.md)

BAS unterstützt Einzel- und Netzwerkaktivierung. Branding, Loginmedien und Website-Icon gehören zur jeweiligen Website. Die Einstellungen liegen unter Einstellungen → Markenfarben im Admin. Die Netzwerkaktivierung kopiert keine Einstellungen und erzeugt keine laufende Vererbung.

## Netzwerk-Startvorlage

Unter Netzwerk-Admin → Einstellungen → Branding-Startvorlage eine portable bas/v1-JSON hochladen. Name und Status bleiben sichtbar; neue Uploads zeigen zusätzlich Quelldatei und Zeitpunkt. Optional werden neu angelegte Websites einmalig eingerichtet, wenn BAS netzwerkaktiv ist. Alternativ eine ausdrücklich gewählte leere Zielwebsite per ID einrichten. Bestehendes Branding wird dabei nicht überschrieben; Medien-IDs und websitespezifische Texte werden nicht verteilt.

Die gespeicherte Netzwerkvorlage steht auf den Untersites unter Branding-Vorlagen zur Auswahl, auch wenn ihre automatische Anwendung deaktiviert ist. Änderungen prüfen, in den Entwurf übernehmen und anschließend ausdrücklich speichern. Netzwerkvorlagen können nur in den Netzwerkeinstellungen mit Bestätigung gelöscht werden. Bereits übernommenes Website-Branding bleibt erhalten.

## Persönliche Farben, Rechte und Lebenszyklus

Persönliche Adminfarben sind in Multisite websitebezogen, im Netzwerk-Admin und Netzwerk-Profil global. Profilformular, Core-Profil-AJAX, BAS-Speichern und Undo verwenden denselben Speicherbereich. Ein benutzergebundener signierter Kontext sichert den Netzwerk-Profilpfad; Core prüft zusätzlich seine eigene AJAX-Nonce. Auf Einzelwebsites bleibt die globale WordPress-Auswahl erhalten. Undo verweigert fremde Speicherbereiche und nachträglich geänderte persönliche Farben.

Einstellungen benötigen manage_options, Medien zusätzlich upload_files. bas_view_context_icons steuert das Standardpublikum der Kontext-Icons; öffentliche Anzeige ist optional. Neue Websites erhalten bei Netzwerkaktivierung das Administrator-Anzeigerecht nach Core-Initialisierung. Bestehende Websites werden beim ersten berechtigten Aufruf einmal provisioniert; bewusste Rechteentzüge bleiben erhalten. Kein Aktivierungsdurchlauf über sämtliche Websites. Siehe [Datenregeln](DATA-de.md) für Aufbewahrung und optionale Bereinigung.

## Gemeinsame Komponenten und optionale Integrationen

Die originale Library 1.1.0 wählt eine gemeinsame kompatible Runtime; ihr Katalog ist vom Branding unabhängig. Der Updater 2.2.0 bleibt über den BAS-Adapter zuständig. Bei aktivem Online-Katalog werden dessen freigegebene Metadaten und Pakete verwendet; standardmäßig ist Online deaktiviert. Frühere zuerst geladene Updater-Kopien werden anhand ihrer Fähigkeiten behandelt und nicht doppelt deklariert.

BAS benötigt kein externes Verwaltungsplugin. Eine optionale Verwaltungsanbindung kann Website-Einstellungen verlinken. bas_site_settings_changed meldet nach Speichern, Undo oder Site-Icon-Aktion nur Website-ID und Vorgang; der Hook verteilt selbst keine Einstellungen und gewährt keine Rechte. Programmgesteuerte fremde Optionsänderungen verwenden die regulären Core-Hooks.
