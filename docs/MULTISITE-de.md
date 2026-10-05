# Multisite und Leitstand

[English](MULTISITE.md)

BAS unterstützt Einzel- und Netzwerkaktivierung. bas_settings gehört immer zur jeweiligen Website. Es gibt keinen Netzwerk-Branding-Editor, keine automatische Verteilung oder Vererbung. Loginmedien und Website-Icon bleiben in der lokalen Mediathek und den Website-Optionen. Die Einstellungen werden auf jeder Website unter Einstellungen → Brand Admin Schemes verwaltet.

Persönliche Farben verwenden in Multisite den websitebezogenen admin_color-Schlüssel. Profilformular, Core-Profil-AJAX, BAS Save und Undo verwenden denselben Website-Bereich. Netzwerk-Profil und Netzwerk-Admin behalten die globale Auswahl. Ein benutzergebundener signierter Kontext überträgt den Netzwerk-Profilbereich an Core-AJAX; Core prüft weiterhin seine eigene Nonce und speichert global. Single-Site bleibt global. Alte globale bas-Auswahlen ohne passendes lokales Schema fallen auf eine gültige Core-/Standardfarbe zurück; keine Massenmigration. Undo verweigert fremde Speicherbereiche und nachträglich geänderte persönliche Farbauswahlen.

Einstellungen benötigen manage_options, Medien zusätzlich upload_files. bas_view_context_icons steuert das Standardpublikum; öffentliche Anzeige ist ausdrücklich optional. Neue Websites erhalten bei Netzwerkaktivierung das Administrator-Anzeigerecht erst nach Core-Initialisierung. Bestehende Websites werden beim ersten berechtigten Aufruf einmal provisioniert; bewusste Entzüge bleiben erhalten. Kein Aktivierungsdurchlauf über alle Websites. Bei Deinstallation gelten die dokumentierten [Datenregeln](DATA-de.md).

BAS funktioniert ohne Leitstand. Eine spätere Anbindung kann get_blog_option oder sauber gepaarte switch_to_blog/restore_current_blog-Aufrufe nutzen. bas_site_settings_changed meldet nach save, undo oder site_icon nur Website-ID und Vorgang. Der Hook verteilt keine Einstellungen und gewährt keine Rechte. Beliebige programmgesteuerte Optionsänderungen lösen ihn nicht aus; dafür existieren Core-Optionshooks. Eine konkrete Leitstand-Oberfläche oder validierte direkte Anbindung ist nicht enthalten.

Library 0.5.0 ist original eingebettet, wählt eine gemeinsame kompatible Runtime und verwaltet ihren Katalog unabhängig vom Branding. Updater V2 bleibt für BAS zuständig. Keine private GitHub-Authentifizierung wurde ergänzt. Vor stabilem Release tatsächliches ZIP auf Single-Site, zwei Multisite-Websites, gleichem Benutzer, Netzwerk-Profil, Undo, Einzel-/Netzwerkaktivierung, neuen Websites, Rechteentzug, Medien/Quota, gemischten Hosts und Browser-/Builder-Kontexten prüfen.
