# Multisite and integrations

[Deutsch](MULTISITE-de.md)

BAS supports individual and network activation. Branding, login media and the Site Icon belong to each website. Open Settings → Brand Admin Schemes to configure them. Network activation does not copy settings or create ongoing inheritance.

## Network starter template

Under Network Admin → Settings → Branding starter template, upload portable bas/v1 JSON. The name and status stay visible; new uploads also show the source filename and time. Optionally seed newly created websites once while BAS is network-active, or explicitly choose an empty destination website by ID. Existing branding is not overwritten; attachment IDs and website-specific text are not distributed.

The saved network template is available under Branding templates on individual websites even when automatic use is disabled. Preview the changes, apply to the draft, then explicitly save. Delete network templates only in network settings with confirmation. Previously applied website branding is retained.

## Personal colors, permissions and lifecycle

Personal admin colors are website-scoped in Multisite and global in Network Admin and the network profile. The profile form, Core profile AJAX, BAS save and Undo use the same scope. A user-bound signed context protects the network profile path; Core also checks its own AJAX nonce. Single sites retain the global WordPress preference. Undo rejects other storage scopes and subsequently changed personal colors.

Settings require manage_options; media additionally require upload_files. bas_view_context_icons controls the default contextual-icon audience; public visibility is optional. Network-active BAS provisions new website administrators after Core initialization. Existing websites are provisioned once on the first authorized request; deliberate capability revocations are retained. Activation does not loop over every website. See [data lifecycle](DATA.md) for retention and optional cleanup.

## Shared components and optional integrations

Original Library 1.1.0 elects one compatible shared runtime; its catalog is independent of branding. Updater 2.2.0 remains owned by the BAS adapter. When the online catalog is enabled, its approved metadata and packages are used; online mode is disabled by default. Older updater copies loaded first are capability-checked rather than redeclared.

BAS does not require an external management plugin. An optional management integration can link website settings. bas_site_settings_changed announces only the website ID and operation after save, Undo or a Site Icon action; it does not distribute settings or grant permissions. Programmatic third-party option changes use the regular Core hooks.
