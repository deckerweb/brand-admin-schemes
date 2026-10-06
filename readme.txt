=== Brand Admin Schemes ===
Contributors: deckerweb
Tags: admin colors, branding, login, favicon, gutenberg
Requires at least: 6.4
Requires PHP: 8.0
Tested up to: 7.1.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Brand colors for the WordPress admin, login, toolbar and browser tabs.

== Description ==

**Your colors. Your WordPress.** Turn a few brand colors into a familiar WordPress admin, a welcoming login screen, and browser tabs you can tell apart. Use Core Framework, Bricks Builder, Automatic.css, or your own palette. Explore the mood and brand strength, preview, then save. No CSS homework.


[Download](https://github.com/deckerweb/brand-admin-schemes/releases/latest) · [User guide](https://github.com/deckerweb/brand-admin-schemes/wiki/English) · [Deutsch](README-de.md)

== At a glance ==

* Make the admin yours: four moods, a brand strength slider, hover and keyboard previews, and up to 30 named schemes.
* Use an existing palette: optional Core Framework, Bricks, and ACSS integrations; manual colors always work.
* Welcome your client: responsive login layouts, a logo or small banner, a background photo or nine smooth gradients, editable text, and an optional quote.
* Recognize every browser tab: separate favicons for the website, admin, and recognized builder editor.
* Spot the environment: compact Local, Development, Staging, and Live badges on the frontend and backend toolbar, with matching colors and optional favicon markers.
* Work across projects: JSON settings, agency ZIP packages with supported login images, source-color comparison, Undo, and unsaved-change reminders.
* Keep WordPress familiar: optional default schemes, frontend toolbar colors, Gutenberg palette entries, bundled German translations, and regular WordPress updates.


== Installation ==

1. Download the **plugin ZIP** from [GitHub Releases](https://github.com/deckerweb/brand-admin-schemes/releases/latest).
2. Upload it via **Plugins → Add New → Upload Plugin** and activate it.
3. Open **Settings → Brand Admin Schemes**, choose a palette, and adjust the mood and brand strength.
4. Hover or focus a scheme card to preview it. Select your favorite, optionally name it, and save using the sticky toolbar.
5. Use **Reload page** to see the saved result throughout the current admin screen.

Everything is managed on one settings page. Login styling and generated tab icons are optional; enable and save them when you are ready.


== Brand colors and admin schemes ==

Map colors to **Primary, Secondary, Tertiary, and Accent**. Three colors are enough: the plugin can derive Tertiary. The mood and slider create suitable tones for menus, the toolbar, buttons, and links. You can keep personal user choices, offer a default, or apply the active scheme to everyone.

Saved colors remain available if their provider is removed. When source colors change, compare the old and new palette before saving an update. The sample contrast check helps you review readability.


== Contextual browser tab icons ==

By default, contextual favicons are restricted to signed-in users with `bas_view_context_icons`, granted once to the Administrator role. A role editor can grant viewing access to other roles or users without granting plugin-settings access. Choose **Everyone, including visitors** and save to restore unrestricted display. In restricted mode, visitors retain the official WordPress Site Icon. Under **Use & export**, each generated design can be downloaded as SVG or 512 × 512 PNG, saved as a PNG media attachment, or adopted as the official WordPress Site Icon. Media actions are immediate and separate from the settings draft. Adopting a Site Icon requires confirmation, omits its environment marker, and switches the saved frontend favicon mode to the WordPress Site Icon. Other drafts stay unsaved; existing images remain in the Media Library. SVG downloads do not enable SVG uploads.

See at a glance whether a browser tab contains the **public website**, **WordPress admin**, or **builder editor**. Create a favicon from a short abbreviation or an outline symbol, with palette colors or your own colors. Presets recognize Bricks, Elementor, and Oxygen editor contexts where supported.

You may retain the existing WordPress Site Icon on the frontend. Optional environment letters make Local, Development, Staging, and Live tabs easier to distinguish. The feature changes the browser-tab icon, not the Site Icon stored in WordPress.


== Login and toolbar ==

The login design follows your active palette. Choose a split or centered layout, then add an optional photo, logo, or small banner. The Site Icon, website title, and tagline provide useful defaults. Nine gradient choices and an optional quote complete the visual panel. Check Desktop, Tablet, and Mobile previews before saving.

The frontend toolbar can use a palette color adjusted to your chosen mood. A compact environment badge appears on frontend and backend toolbars. Detection includes WordPress environment settings, Local app `.local` sites, and localhost addresses; manual selection and custom status colors are available.


== Import, export, and Gutenberg ==

Move settings and saved schemes as **JSON**, or include supported local login images in an **agency ZIP**. Review imported settings and save to apply them. ZIP imports add bundled images to the Media Library immediately and require PHP ZipArchive. SVG images are excluded from these packages.

Optionally add the four named brand colors to Gutenberg alongside the theme palette. Existing content keeps its colors.


== Updates and documentation ==

Updates come directly from the [DECKERWEB plugin repository on GitHub](https://github.com/deckerweb/brand-admin-schemes/releases) and appear in the **regular WordPress plugin update system**. Update from the Plugins or Updates screen as usual; no additional updater plugin is needed.

The [English wiki guide](https://github.com/deckerweb/brand-admin-schemes/wiki/English) and [German wiki guide](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) cover every setting, palette sources, login images, tab icons, and common questions. The settings footer links to the guide in your language and opens the recent local history with a link to the complete changelog. German is included and follows the WordPress site or user language.


== Frequently Asked Questions ==

= How does the new color dialog work? =
Click Choose color beside an editable HEX field. Preview a color visually or enter its HEX value. Done closes the dialog; save all changes to apply branding. Locked roles must be unlocked before editing.

= Can I reuse branding on another website? =
Export a portable template or an agency ZIP. Portable templates omit images, website text, initials and forced user defaults. Choose local images on the destination. An agency import adds images immediately; its settings still require review and saving.

= What happens if another editor saves first? =
Your stale save is rejected. Export your draft before reloading and compare it with the latest settings.

= How does the history work? =
Up to ten previous settings snapshots are stored on this website. You can restore entries from your own account and storage scope. Restoration also restores your prior personal color and replaces an unsaved draft; the current state becomes a new history entry.

= Can the network distribute branding automatically? =
Optionally use a network starter template once for newly created websites. Existing branding is never overwritten. There is no continuing inheritance or synchronization. Leitstand is optional.

= Does BAS replace the WordPress Site Icon? =
The frontend keeps it by default. Only the separate, explicitly confirmed Use as official Site Icon action replaces it. Media actions take effect immediately and are independent of saving the editor draft.

= What happens when I uninstall BAS? =
Branding, images and personal colors are retained. Temporary Undo and write locks are removed. The optional workflow cleanup setting removes only this website’s stored templates and history; it is off by default. Network starter templates are retained.

[More answers by topic](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-English)


== Guided setup ==

Optional guided setup walks through colors, atmosphere, login and tab icons, then review and save. It shares the existing draft, can be reopened, and leaves current settings unchanged until an explicit save.

== Site Health ==

A compact, read-only section in Tools → Site Health reports the selected scheme, palette source, user default mode, optional styling and resolved environment. No status tests, file checks or external requests are performed.

== Multisite and Leitstand ==

Activate on an individual site or across the network. Each site owns its schemes, login settings, toolbar, browser-tab icons, and media. Personal color choices also stay separate per site. New subsites receive the administrator tab-icon permission automatically; existing sites receive it on their first authorized visit. Deliberately revoked permissions stay revoked. Configure branding in each site’s admin.

BAS works independently of Leitstand. Leitstand can read standard WordPress site options and listen to the documented change hook. An optional Leitstand module links to website branding. Network starter templates can be previewed on individual websites and explicitly saved. The deckerweb Plugin Library 0.6.0 is embedded; Updater V2 continues to deliver BAS updates through WordPress.



[Data and uninstall](docs/DATA.md) · [Security](SECURITY.md) · [Compatibility](docs/PROFILE.md)



== Branding workflows ==

Use the color dialog for brand, login, environment and favicon colors. Locked roles retain exact brand colors. Duplicate or rename schemes, reset one section, compare saved/draft previews and review imports before saving. Portable templates exclude local images and site-specific text. Recent changes retain up to ten snapshots; restoring replaces the draft and affects your personal color on this website.
== Screenshots ==

1. Manual brand colors and save controls in a real WordPress test site.

== Changelog ==

Seven recent versions; the Wiki and local full history retain all documented entries.

= 1.0.0 =

2026-10-06

* Improved: Name portable exports independently of schemes and preview network starter templates on individual websites before saving. Network templates remain managed by network administrators.
* Fixed: Display the saved Multisite starter template with its name and status, show save confirmation, and offer confirmed removal without changing existing website branding.
* New: Choose every editable color in a shared dialog with HEX input, swatches and keyboard support.
* New: Lock brand colors, review contrast adjustments and compare saved branding with your draft.
* New: Save portable branding templates and restore up to ten recent settings snapshots.
* New: Optionally seed new Multisite websites from a network starter template; existing branding stays independent.
* New: Access website branding through the optional Leitstand integration.
* Improved: Duplicate, rename or remove schemes, reset individual sections and review imported changes before applying them.
* Fixed: Reject stale editor saves and validate update packages during both individual and bulk updates.
* Improved: Batch live previews and reuse provider reads within a request.
* Misc: Retains the embedded plugin catalog and GitHub updates.
* Misc: Includes deckerweb Plugin Library 0.6.0 and deckerweb Updater 2.1.0.

= 0.18.0 =

2026-10-05

* New: Optional four-step guided setup.
* New: Eight-field informational report in Tools → Site Health, without extra tests or external requests.
* Improved: Tab icons support audience selection, viewing permission, downloads, PNG media actions and official Site Icon adoption.
* Improved: Adds network activation, per-site personal colors, profile/AJAX/Undo isolation and new-subsite permission provisioning.
* Improved: Ships informal and formal German, shared documentation sources, a dated local changelog and localized GitHub banners.
* Fixed: Keeps network-profile AJAX color changes global and rejects Undo snapshots from another storage scope.
* Fixed: Checks upload permission and available Multisite space for agency images and PNG icons.
* Fixed: Keeps save actions and long translated choices within narrow admin screens.
* Fixed: Preserves named scheme colors during validation and protects later personal color changes from Undo.
* Misc: Includes deckerweb Plugin Library 0.5.0; preserves Updater V2.
* Misc: Documents security reporting and data ownership; uninstall clears temporary Undo and updater cache while preserving branding, media and user choices.

= 0.17.0 (development) =

Release date not recorded

* New: Compact, read-only Site Health information without status tests.

= 0.16.3 =

2026-09-30

* Improved: Shows the plugin icon in WordPress update offers and localized English/German banners in plugin details.
* Improved: Links footer documentation directly to the localized Wiki and opens the complete bundled changelog in an accessible local dialog.
* Fixed: Restores missing update artwork, including already cached update offers after this version is installed.
* Misc: Uses the shared DECKERWEB GitHub Updater V2 with plugin-scoped package identity and requirements checks.

= 0.16.2 =

2026-09-30

* Improved: Refreshes all four readmes with clear feature summaries, seven short FAQs, and the latest five version entries.
* Improved: Adds a German GitHub banner and expands the bilingual Wiki with 49 themed FAQ answers per language and complete changelogs.
* Improved: Adds checked contents links, presents browser-tab favicons alongside the main features, and explains GitHub updates through the regular WordPress update system.
* Misc: Packages the updated English and German documentation with this release.

= 0.16.1 =

2026-09-29

* Improved: Adopts the Daily Scripture footer layout, adds a documentation link beside the changelog, and includes a translated brand slogan.
* Misc: Sets the DECKERWEB copyright range to 2022–2026 throughout the plugin and documentation.

= 0.16.0 =

Release date not recorded

* New: Adds a compact settings footer with local documentation and changelog dialogs.
* Improved: Includes matching English and German Markdown and WordPress-style text readmes.
* Improved: Groups each release by New, Improved, Fixed, and Misc, in that order.
* Fixed: Corrects the frontend-toolbar checkbox markup, translates missing German error messages, and registers three missing JavaScript translation labels.
* Misc: Adds a license file, release notes and repository packaging rules.

== About ==

Built by **David Decker – DECKERWEB** to make client sites feel familiar on both sides of the login screen. Ideas behind the plugin grew from snippets used since 2022.

The scheme styles the WordPress admin shell; third-party CSS can affect individual elements. Gutenberg content and builder canvases keep their own design. SVG login images require Safe SVG and administrator confirmation. More details are in the wiki.

Have an idea or found an issue? [Let us know on GitHub](https://github.com/deckerweb/brand-admin-schemes/issues).

© 2022–2026 David Decker – DECKERWEB · [GPL v2 or later](LICENSE)
