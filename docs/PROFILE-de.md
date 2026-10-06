# Plugin-Steckbrief

[English](PROFILE.md)

Brand Admin Schemes von David Decker – DECKERWEB gestaltet WordPress-Admin, Login, Toolbar und Browser-Tabs für Website-Betreiber und Agenturen. Bestehender Produktname und Slug: `brand-admin-schemes`; keine Serienumbenennung. Vertrieb: öffentlicher GitHub-Direktdownload mit Updater V2; dieser Build ist kein WordPress.org-Paket. Copyright © 2022–2026, GPL v2 oder höher. Aktueller Release: 1.0.0.

Bestehende Mindestanforderungen bleiben WordPress 6.4 und PHP 8.0. Die originale eingebettete Library 0.6.0 hat dieselben Minima. Eine Anhebung oder neue Designausnahme ist nicht freigegeben. Manuelle Paletten funktionieren unabhängig; Core Framework, Bricks und ACSS sind optionale, abgesichert gelesene Provider. Gespeicherte Farben bleiben ohne Provider verfügbar. SVG-Loginmedien benötigen Safe SVG und ausdrückliche Bestätigung; Agenturpakete benötigen ZipArchive; PNG-Medienaktionen benötigen einen unterstützten WordPress-Bildeditor.

Einzel- und Netzwerkaktivierung werden unterstützt; Einstellungen, Loginmedien und Website-Icons gehören zur jeweiligen Website. Persönliche Farben sind in Multisite websitebezogen und im Netzwerk-Admin global. Library-Einstellungen gelten je Netzwerk. BAS funktioniert ohne Leitstand; eine spätere Anbindung muss dessen tatsächliche dokumentierte Schnittstellen verwenden. `bas_site_settings_changed` meldet nur Website-ID und Vorgang.

Assets und Dokumentation bleiben lokal. [Daten](DATA-de.md), [Sicherheit](../SECURITY-de.md), [Sprachglossar](GLOSSARY-de.md), [Release-Regeln](RELEASE-POLICY-de.md) und [Tests](TESTING-1.0.0-de.md) erläutern das Verhalten. Screenshots bleiben eine optionale Übergangsaufgabe und ersetzen keine Laufzeitprüfungen.
