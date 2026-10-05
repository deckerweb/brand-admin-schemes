# Release-Regeln

[English](RELEASE-POLICY.md)

Neue kompatible Funktionen erhöhen die Funktionsversion, beispielsweise 0.18.0. Reine Fehlerkorrekturen erhöhen die letzte Zahl. Inkompatible Daten- oder Verhaltensänderungen benötigen eine gesondert dokumentierte Migration und ausdrückliche Prüfung von Version und Mindestanforderungen vor dem Release. `dev` und `rc` bleiben unveröffentlichte Abnahmepakete; ihre Datumsangaben sind Build-Daten und keine stabilen Veröffentlichungsdaten.

Readmes und lokaler Dialog zeigen sieben neueste Versionen. Bei Bedarf bis zur zweiten dokumentierten Funktionsversion erweitern. Der vorbereitete Stand 0.18.0 zeigt sieben Einträge bis 0.15.1; 0.17.0 bleibt ein unveröffentlichter Entwicklungseintrag. Das Veröffentlichungsdatum für 0.18.0 wird erst nach Release-Freigabe gesetzt. Vollständiger lokaler Text-/Markdown-Verlauf und Wiki erhalten alle bekannten Einträge. Datumsangaben stammen nur aus geprüften GitHub-Release-Metadaten; nicht verfügbare historische Daten bleiben klar unbekannt.

Kategorien: New, Improved, Fix, Misc; Deutsch: Neu, Verbessert, Behoben, Sonstiges, jeweils in dieser Reihenfolge. `docs/source/content.json` ist die gemeinsame Quelle für alle Readmes, deren sieben kurze FAQs, die vollständige Wiki-FAQ, Release-Notizen und Verlauf. Generierung: `python3 tools/build-documentation.py`. `docs/source/messages.json` enthält EN sowie Deutsch mit Du und Sie; Generierung: `python3 tools/build-languages.py`. Laufzeitdateien und Quellwerkzeuge haben getrennte Paketauswahlen.

Vor stabilem Release: tatsächliches ZIP, Minima, Updatepfad, Rechte, Sprachen, Datenerhalt, Einzel-/Netzwerkaktivierung, neue Websites, Rechteentzug, Core-Profil/AJAX/Undo, Bildverarbeitung und Quota prüfen. PHP-Log, Browser-Konsole, Tastatur/Fokus/mobile Darstellung, aktuelle Plattformregeln und private Sicherheitsmeldungen im Repository kontrollieren. Library und Updater bleiben geprüfte Originalkomponenten. Reale Provider-/Builder- und Screenreader-Abnahme benötigen deren tatsächliche Umgebungen. Veröffentlichung und Katalogänderung benötigen Release-Autorisierung; lokale Test-Builds führen sie nicht aus.
