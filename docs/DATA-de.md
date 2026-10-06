# Daten und Deinstallation

[English](DATA.md)

| Daten | Geltungsbereich | Entfernung |
|---|---|---|
| `bas_settings`: Schemen, Providerwahl, Login, Umgebung, Favicons | Website | Bleiben erhalten |
| `bas_last_undo`: vorherige Einstellungen, Benutzer-ID, Farbauswahl und Zustandshash | Website, temporär | Bei Deinstallation auf allen Multisite-Websites entfernt |
| `bas_context_icons_capability_version` und Rollenrecht `bas_view_context_icons` | Website | Bleiben erhalten, damit entzogene Rechte nicht neu vergeben werden |
| `admin_color` | Benutzer, global auf Single-Site und im Netzwerk-Admin | Bleibt erhalten; gemeinsam mit WordPress verwendet |
| Website-Präfix plus `admin_color` | Benutzer je Multisite-Website | Bleibt erhalten |
| `site_icon`, Medien und `_bas_icon_context` | Website und Mediathek | Bleiben als Nutzerinhalte erhalten |
| `ddw_ghru_` plus erste 24 Zeichen der MD5 der BAS-Repository-URL | Netzwerk / Single-Site-Transient | Nur dieser BAS-Updater-Cache wird bei Deinstallation entfernt |
| Library-Einstellungen, Zuordnung, Hinweisstatus und Caches | Netzwerk oder Single-Site; Hinweisstatus als globale Benutzermetadaten | Originaler Library-Lebenszyklus |

Deaktivierung entfernt keine Daten. Deinstallation bereinigt temporäre Undo-Snapshots und den Repository-spezifischen Updater-Cache, ohne andere Plugins oder WordPresss gemeinsamen `update_plugins`-Transient anzutasten. In Multisite werden diese temporären BAS-Werte auf allen Websites und Netzwerken entfernt; Branding wird weder kopiert noch vererbt. BAS plant keine Hintergrundaufgaben und hält keinen dauerhaften Branding-Cache. Arbeitsdateien für Agentur-Export und -Import werden beim normalen Abschluss der Anfrage entfernt; WordPress verwaltet temporäre Upload-Dateien.

Library 0.4.0 erhält gemeinsame Daten, solange ein weiterer Library-Host physisch installiert ist, auch deaktiviert. Erst der letzte Host bereinigt temporäre gemeinsame Caches und erfasste Arbeitsverzeichnisse. Library-Einstellungen bleiben standardmäßig erhalten; ihre gesonderte Löschoption ist zunächst aus und wirkt nur beim letzten Host. Installierte Plugins, deren Daten und BAS-Einstellungen werden niemals darüber gelöscht. Das vollständige Library-Dateninventar steht in der mit dem Komponenten-Kit gelieferten Dokumentation.

BAS erhält keinen pauschalen Schalter zum Löschen aller Daten: Medien und das offizielle Website-Icon sind Website-Inhalte; `admin_color` ist gemeinsamer WordPress-Zustand; Capability-Migrationsmarker bewahren bewusste Rollenentscheidungen. Automatisches Löschen könnte die weitere Website-Nutzung beeinflussen. Für einen bewussten Reset: zuerst exportieren, gewünschte WordPress-Farbe und Website-Icon wiederherstellen, ausgewählte Medien in der Mediathek löschen und nur bestätigte BAS-Optionen mit üblichen WordPress-Verwaltungswerkzeugen entfernen. Das Entfernen des Capability-Migrationsmarkers kann bei erneuter BAS-Aktivierung das Standard-Anzeigerecht wieder vergeben.

JSON-Importe bleiben bis zum Speichern Entwürfe. Agentur-Importe legen begrenzte Rasterbilder sofort an, prüfen Rechte und Quota und entfernen bei fehlgeschlagenem Import nur die neu angelegten Bilder. Bestehende Medien werden dabei nie gelöscht. Rollenrechte werden nicht exportiert. Undo gilt nur für seinen Autor, die Website und den Speicherbereich bei unveränderten gespeicherten Einstellungen; es ist kein websiteübergreifender Verlauf.


## Daten der Branding-Abläufe

Je Website: bas_templates speichert höchstens zehn portable Vorlagen; bas_history höchstens zehn frühere Branding-Stände mit Zeit, Benutzer-ID und persönlichem Farbspeicherbereich. Beide werden nicht automatisch geladen und bleiben standardmäßig erhalten. bas_write_lock ist eine temporäre Schreibsperre, wird nach der Speicherung und bei Deinstallation entfernt und kann nach 120 Sekunden als veraltet freigegeben werden. Im Netzwerk speichert bas_network_template die portable Startvorlage und ihren Aktivierungsstatus; sie bleibt bei Deinstallation erhalten. Die optionale Einstellung delete_workflows entfernt Website-Vorlagen und Verlauf bei Deinstallation, niemals Branding, Bilder oder Benutzervorlieben. Deaktivierung und gewöhnliche Netzwerkanfragen durchlaufen nicht alle Websites.
