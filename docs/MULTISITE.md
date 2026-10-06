# Multisite and Leitstand integration

[Deutsch](MULTISITE-de.md)

## Activation and ownership

Brand Admin Schemes supports individual-site and network activation. Configuration remains **per website** in the standard `bas_settings` option (use the `BAS_Plugin::OPTION` constant for the authoritative key). No automatic copying, inheritance, or network-wide enforcement is introduced. Login media and official Site Icons belong to the current site's media library and options. Configure each site under Settings → Brand Admin Schemes; the network plugin-list link opens the current site's settings.

Personal colors saved by BAS use WordPress's site-prefixed `admin_color` user option in Multisite. Profile submissions and the Core profile-picker AJAX action follow the same scope when BAS is active on that website. Save and Undo leave other websites and the global preference intact. WordPress network admin keeps its global user preference and uses its current site's branding. Single-site behavior stays global, as before. A legacy global `bas-*` choice that is unavailable on this website resolves to the Core/default scheme instead of a missing scheme. Existing valid choices are not bulk-migrated.

## Permissions and scale

Settings require `manage_options`; media actions also require `upload_files`. The `bas_view_context_icons` capability controls the default icon audience. The optional public audience remains explicit and per site. New sites receive the administrator capability after Core initializes their roles, only if BAS is network active. Existing sites are provisioned once on their first logged-in administrator request. Revoked capabilities remain revoked. No full-network activation loop is used.

## Leitstand adapter boundary

BAS has no Leitstand dependency. A future Leitstand adapter can discover activation with WordPress APIs and read website options using `get_blog_option()` or a balanced `switch_to_blog()` / `restore_current_blog()` pair. Do not use network options for BAS branding or interpret role assignments as exportable scheme settings.

`do_action( 'bas_site_settings_changed', int $site_id, string $operation )` runs after BAS saves (`save`), restores (`undo`), or adopts an official Site Icon (`site_icon`). It exposes only the site ID and operation, so consumers can invalidate their own cached summaries. It does not grant permission, distribute settings, or run for unrelated programmatic option writes. Consumers needing all option writes can use native WordPress option hooks. No Leitstand-specific UI or calls to an unverified API are shipped.

## Shared components

The original deckerweb Plugin Library **0.6.0** is embedded unchanged. It elects one newest shared runtime across hosts and already supports the network catalog/settings context. Its catalog is independent of site branding. BAS's own **Updater V2** remains unchanged and responsible for release updates. No new private-repository authentication is included in this test build.

## Verification

`bas-tests/multisite.php` (maintainer test source, outside the plugin ZIP) runs 48 isolated behavior checks using the actual host methods with modeled WordPress storage, roles, permissions, and AJAX responses. All PHP files pass syntax validation; the German catalog compiles. The Library's previously supplied validation report is not a new runtime test of this BAS modification. The host uses protocol-2 registration and the shared lifecycle contract; uninstall preserves BAS settings and media.

Before stable release, test in a real Multisite: two sites with different branding, the same user choosing different schemes, Core profile selection and BAS Undo, site-only and network activation, a new subsite, revoked permissions, official Site Icon/media actions, site admin versus network admin, and mixed Library hosts. A concrete Leitstand integration requires testing its actual adapter when available.

Network-profile AJAX carries a user-bound context nonce from the network picker; Core continues to validate its own nonce and write the global preference. Site profiles and BAS Save/Undo remain local. Undo also refuses a subsequent personal color change. See [data lifecycle](DATA.md).


Optional network starter: Network Admin → Settings → Branding starter template. Upload portable bas/v1 JSON, opt into one-time provisioning of new websites, or enter one empty destination site ID. Existing branding and personal color settings are never overwritten. Network activation is required for automatic new-site provisioning. Portable templates do not transfer media IDs. The optional Leitstand module exposes links; no Leitstand installation is required.
