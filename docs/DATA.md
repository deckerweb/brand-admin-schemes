# Data and uninstall

[Deutsch](DATA-de.md)

| Data | Scope | Removal |
|---|---|---|
| `bas_settings`: schemes, provider selection, login, environment, favicon settings | Website | Preserved |
| `bas_last_undo`: previous settings, author ID, color preference and state hash | Website, temporary | Removed on uninstall across all Multisite websites |
| `bas_context_icons_capability_version` and `bas_view_context_icons` role capability | Website | Preserved so revoked permissions are never provisioned again |
| `admin_color` | User, global on single-site and in network admin | Preserved; shared with WordPress |
| Site-prefixed `admin_color` | User per Multisite website | Preserved |
| `site_icon`, media attachments and `_bas_icon_context` | Website and Media Library | Preserved; user content |
| `ddw_ghru_` followed by the first 24 characters of the BAS repository URL MD5 | Network / single-site transient | Only this BAS updater cache is removed on uninstall |
| Library settings, ownership, introduction status and caches | Network, or single-site options; introduction status is global user metadata | Managed by the original Library lifecycle contract |

Deactivation removes no data. Removing BAS clears its temporary Undo snapshots and repository-specific updater cache, without touching other plugins or WordPress's shared `update_plugins` transient. Multisite uninstall removes these temporary BAS values from all websites and networks; it does not copy or inherit branding. BAS schedules no background tasks and keeps no persistent branding cache. Bundle export/import work files are removed when their request finishes normally; WordPress manages its upload temporary files.

Library 0.4.0 retains shared data while another Library host is physically installed, including an inactive host. The last host clears temporary shared caches and tracked working directories. Library settings are preserved by default; its separate optional deletion setting, initially off, applies only to the last host. It never deletes installed plugins, their data or BAS settings. See the shipped Library documentation in the component kit for its complete inventory.

No BAS-wide delete-all switch is introduced: media and official Site Icons are website content; `admin_color` is shared WordPress state; capability migration markers preserve deliberate role decisions. Automatic deletion would affect continuing site behavior. For a deliberate reset, export a backup, restore the desired WordPress color and Site Icon, delete selected attachments through the Media Library, and remove only confirmed BAS options using normal WordPress administration tools. Removing the capability migration marker may grant the default viewing capability again when BAS is reactivated.

JSON imports are drafts until saved. Agency imports create bounded raster attachments immediately, check rights and quota, and roll back images created by a failed import. Existing attachments are never deleted by that rollback. Role assignments are excluded from exports. Undo is limited to its author, website/storage scope and unchanged saved settings; it is not a cross-site history.


## Branding workflow data

Per website: bas_templates stores at most ten portable templates; bas_history stores at most ten prior branding snapshots with timestamp, actor ID and personal color scope. Both are non-autoloaded and retained by default. bas_write_lock is a temporary write mutex, cleared after the write and at uninstall, with a 120-second stale-lock recovery. Network bas_network_template stores a portable starter and its enabled flag; it is retained on uninstall. The optional delete_workflows setting removes website templates/history on uninstall, never branding, images or user preferences. Neither deactivation nor ordinary network requests enumerate all websites.
