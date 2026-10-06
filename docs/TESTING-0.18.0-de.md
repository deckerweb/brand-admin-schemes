# Tests für 1.0.0

[English](TESTING-1.0.0.md)

Vorbereiteter Release; Veröffentlichung steht noch aus. Originale Library 0.6.0 und Updater V2.1. Verwende eine entbehrliche WordPress-Testinstallation. Modellierte Tests ersetzen keine echten Laufzeit- und Browserprüfungen.

1. Von der vorherigen Version aktualisieren. Schemen, Loginmedien und Favicons müssen erhalten bleiben. Eigene Farben und verfügbare Provider-Paletten, Original-Swatches, Atmosphäre, Markennähe, Tastatur-/Hover-Vorschau und gespeichertes CSS prüfen.
2. Die optionale Einrichtung mit vier Schritten öffnen, Login und Tab-Icons ändern, zurückgehen und zum vollständigen Editor wechseln. Der Entwurf bleibt bis „Alle Änderungen speichern“ ungespeichert. JSON-/Agenturimport, Export, Undo und Schutz vor dem Verwerfen prüfen.
3. Werkzeuge → Website-Zustand → Bericht enthält acht informative Felder, keine zusätzlichen Status-Tests, Dateiprüfungen oder externen Aufrufe.
4. Login-Fallbacks für Logo/Banner/Website-Icon, Verläufe, Zitat, Titel, Ausrichtung und kleine Bildschirme prüfen. SVG-Loginbilder benötigen Safe SVG und ausdrückliche Bestätigung.
5. Kontext-Icons sind standardmäßig auf bas_view_context_icons beschränkt. Besucher und andere Rollen behalten Core-Icons. Rechte je Website vergeben/entziehen; bewusster Entzug muss erhalten bleiben. Öffentliches Publikum ist eine ausdrückliche Auswahl. Builderkontexte nur mit tatsächlich installierten Produkten abnehmen.
6. SVG und PNG mit 512 × 512 herunterladen. PNG über den WordPress-Bildeditor speichern; gesonderte Website-Icon-Aktion abbrechen/bestätigen. Sie speichert keine anderen Entwurfsänderungen und löscht keine vorhandenen Medien.
7. Einzelwebsite- und Netzwerkaktivierung prüfen. Derselbe Benutzer speichert verschiedene Farben und Medien auf zwei Websites. BAS-Speichern/Undo und Core-Profil/AJAX ändern nur die jeweilige Website. Netzwerk-Profilfarbe wird global gespeichert und angezeigt. Ungültiger Kontext-Nonce wird abgewiesen. Lokaler Zwangsstandard darf den Netzwerk-Picker nicht verstecken. Undo aus fremdem Speicherbereich wird abgewiesen.
8. Neue Website anlegen: netzwerkaktives BAS provisioniert das Icon-Recht nach Core-Initialisierung. Einzelwebsite-Aktivierung provisioniert fremde Websites nicht. Blog-Switching und bewusster Rechteentzug bleiben korrekt.
9. Upload-Recht entziehen und Site-Quota begrenzen/ausschöpfen. PNG- und Agenturschreibzugriffe müssen kontrolliert scheitern; Gesamtquota des Pakets, echtes Bildprocessing und Attachment-Metadaten prüfen.
10. Englisch, Deutsch mit Du und Sie für Benutzer einstellen. Editor, Einrichtung, Fehler, Footer und Library prüfen. Lokalen Verlauf per Tastatur öffnen, scrollen und mit Escape schließen. Fokus kehrt zurück, Entwurf bleibt erhalten. Schmale Darstellung und Kontrast prüfen.
11. Library-Hosts mit 0.3/0.4/0.5 kombinieren. Neueste kompatible Runtime, ein gemeinsamer Tab, kombinierte Suche/Serie/Kompatibilität und drei Sprachen prüfen. Deaktivierung erhält Daten; Deinstallation entfernt nur temporäre BAS-Daten und schützt Branding, Benutzer, Rollen und Medien. Installierte inaktive Hosts schützen gemeinsame Library-Daten; letzten Host gesondert prüfen.

Tatsächlich ausgeliefertes ZIP, Updatepfad, Minima, PHP-Logs und Browser-Konsole prüfen. Privater GitHub-Meldeweg und aktuelle Plattformregeln werden vor Veröffentlichung kontrolliert. BAS funktioniert ohne Leitstand; konkrete Anbindung wartet auf dessen tatsächlichen Adapter.
