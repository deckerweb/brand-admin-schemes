# Brand Admin Schemes

![Brand Admin Schemes plugin banner](assets-github/banner-github-1280x640.png)

**Your colors. Your WordPress.** Turn a few brand colors into a familiar WordPress admin, a welcoming login screen, and browser tabs you can tell apart. Use Core Framework, Bricks Builder, Automatic.css, or your own palette. Explore the mood and brand strength, preview, then save. No CSS homework.

**Version:** 0.18.0 · **Requires:** WordPress 6.4+ / PHP 8.0+ · **License:** GPL v2 or later

[Download](https://github.com/deckerweb/brand-admin-schemes/releases/latest) · [User guide](https://github.com/deckerweb/brand-admin-schemes/wiki/English) · [Deutsch](README-de.md)

## Contents

- [At a glance](#at-a-glance)
- [Installation and first scheme](#installation-and-first-scheme)
- [Brand colors and admin schemes](#brand-colors-and-admin-schemes)
- [Contextual browser tab icons](#contextual-browser-tab-icons)
- [Login and toolbar](#login-and-toolbar)
- [Import, export, and Gutenberg](#import-export-and-gutenberg)
- [Updates and documentation](#updates-and-documentation)
- [FAQ](#faq)
- [Multisite and Leitstand](#multisite-and-leitstand)
- [Screenshots](#screenshots)
- [Changelog](#changelog)
- [About](#about)

<a name="at-a-glance"></a>

## At a glance

- **Make the admin yours:** four moods, a brand strength slider, hover and keyboard previews, and up to 30 named schemes.
- **Use an existing palette:** optional Core Framework, Bricks, and ACSS integrations; manual colors always work.
- **Welcome your client:** responsive login layouts, a logo or small banner, a background photo or nine smooth gradients, editable text, and an optional quote.
- **Recognize every browser tab:** separate favicons for the website, admin, and recognized builder editor.
- **Spot the environment:** compact Local, Development, Staging, and Live badges on the frontend and backend toolbar, with matching colors and optional favicon markers.
- **Work across projects:** JSON settings, agency ZIP packages with supported login images, source-color comparison, Undo, and unsaved-change reminders.
- **Keep WordPress familiar:** optional default schemes, frontend toolbar colors, Gutenberg palette entries, bundled German translations, and regular WordPress updates.

<a name="installation-and-first-scheme"></a>

## Installation and first scheme

1. Download the **plugin ZIP** from [GitHub Releases](https://github.com/deckerweb/brand-admin-schemes/releases/latest).
2. Upload it via **Plugins → Add New → Upload Plugin** and activate it.
3. Open **Settings → Brand Admin Schemes**, choose a palette, and adjust the mood and brand strength.
4. Hover or focus a scheme card to preview it. Select your favorite, optionally name it, and save using the sticky toolbar.
5. Use **Reload page** to see the saved result throughout the current admin screen.

Everything is managed on one settings page. Login styling and generated tab icons are optional; enable and save them when you are ready.

<a name="brand-colors-and-admin-schemes"></a>

## Brand colors and admin schemes

Map colors to **Primary, Secondary, Tertiary, and Accent**. Three colors are enough: the plugin can derive Tertiary. The mood and slider create suitable tones for menus, the toolbar, buttons, and links. You can keep personal user choices, offer a default, or apply the active scheme to everyone.

Saved colors remain available if their provider is removed. When source colors change, compare the old and new palette before saving an update. The sample contrast check helps you review readability.

<a name="contextual-browser-tab-icons"></a>

## Contextual browser tab icons

By default, contextual favicons are restricted to signed-in users with `bas_view_context_icons`, granted once to the Administrator role. A role editor can grant viewing access to other roles or users without granting plugin-settings access. Choose **Everyone, including visitors** and save to restore unrestricted display. In restricted mode, visitors retain the official WordPress Site Icon. Under **Use & export**, each generated design can be downloaded as SVG or 512 × 512 PNG, saved as a PNG media attachment, or adopted as the official WordPress Site Icon. Media actions are immediate and separate from the settings draft. Adopting a Site Icon requires confirmation, omits its environment marker, and switches the saved frontend favicon mode to the WordPress Site Icon. Other drafts stay unsaved; existing images remain in the Media Library. SVG downloads do not enable SVG uploads.

See at a glance whether a browser tab contains the **public website**, **WordPress admin**, or **builder editor**. Create a favicon from a short abbreviation or an outline symbol, with palette colors or your own colors. Presets recognize Bricks, Elementor, and Oxygen editor contexts where supported.

You may retain the existing WordPress Site Icon on the frontend. Optional environment letters make Local, Development, Staging, and Live tabs easier to distinguish. The feature changes the browser-tab icon, not the Site Icon stored in WordPress.

<a name="login-and-toolbar"></a>

## Login and toolbar

The login design follows your active palette. Choose a split or centered layout, then add an optional photo, logo, or small banner. The Site Icon, website title, and tagline provide useful defaults. Nine gradient choices and an optional quote complete the visual panel. Check Desktop, Tablet, and Mobile previews before saving.

The frontend toolbar can use a palette color adjusted to your chosen mood. A compact environment badge appears on frontend and backend toolbars. Detection includes WordPress environment settings, Local app `.local` sites, and localhost addresses; manual selection and custom status colors are available.

<a name="import-export-and-gutenberg"></a>

## Import, export, and Gutenberg

Move settings and saved schemes as **JSON**, or include supported local login images in an **agency ZIP**. Review imported settings and save to apply them. ZIP imports add bundled images to the Media Library immediately and require PHP ZipArchive. SVG images are excluded from these packages.

Optionally add the four named brand colors to Gutenberg alongside the theme palette. Existing content keeps its colors.

<a name="updates-and-documentation"></a>

## Updates and documentation

Updates come directly from the [DECKERWEB plugin repository on GitHub](https://github.com/deckerweb/brand-admin-schemes/releases) and appear in the **regular WordPress plugin update system**. Update from the Plugins or Updates screen as usual; no additional updater plugin is needed.

The [English wiki guide](https://github.com/deckerweb/brand-admin-schemes/wiki/English) and [German wiki guide](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) cover every setting, palette sources, login images, tab icons, and common questions. The settings footer links to the guide in your language and opens the recent local history with a link to the complete changelog. German is included and follows the WordPress site or user language.

<a name="faq"></a>

## FAQ

**Do I need Core Framework, Bricks, or ACSS?** No. Enter your own colors; palette providers are optional.

**What happens if I disable a palette provider?** Saved scheme colors remain available. The provider is needed to read a fresh palette, not to display saved colors.

**Does this change my website or builder design?** It styles the admin shell, optional login and toolbar, and browser-tab icons. Page content and builder canvases keep their design; Gutenberg palette entries only add choices.

**Does it replace the WordPress Site Icon?** Contextual favicons leave it unchanged by default. The separate, confirmed Site Icon action can explicitly adopt a generated PNG.

**Does it work on Multisite?** Yes, with site-only or network activation. Branding, media and personal colors stay per site; the network profile uses your global color. Configure branding in each site’s admin.

**Does importing immediately change the live design?** No. Review the imported settings and save to apply them. Agency ZIP imports do add bundled images to the Media Library immediately.

**How do updates and uninstall work?** Updater V2 delivers GitHub updates through WordPress. Deactivation preserves data; uninstall removes temporary Undo and caches, retaining branding, media and color choices. See the data guide.

[More answers by topic](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-English)


## Guided setup

Optional guided setup walks through colors, atmosphere, login and tab icons, then review and save. It shares the existing draft, can be reopened, and leaves current settings unchanged until an explicit save.

## Site Health

A compact, read-only section in Tools → Site Health reports the selected scheme, palette source, user default mode, optional styling and resolved environment. No status tests, file checks or external requests are performed.

## Multisite and Leitstand

Activate on an individual site or across the network. Each site owns its schemes, login settings, toolbar, browser-tab icons, and media. Personal color choices also stay separate per site. New subsites receive the administrator tab-icon permission automatically; existing sites receive it on their first authorized visit. Deliberately revoked permissions stay revoked. Configure branding in each site’s admin.

BAS works independently of Leitstand. Leitstand can read standard WordPress site options and listen to the documented change hook. A dedicated Leitstand interface or network-wide branding distribution is not included yet. The deckerweb Plugin Library 0.5.0 is embedded; Updater V2 continues to deliver BAS updates through WordPress.

<a name="changelog"></a>


[Data and uninstall](docs/DATA.md) · [Security](SECURITY.md) · [Compatibility](docs/PROFILE.md)

## Screenshots

1. Manual brand colors and save controls in a real WordPress test site.

![Manual brand colors and save controls in a real WordPress test site.](assets-github/screenshots/screenshot-1.jpg)

2. Local changelog with labeled categories, keyboard controls and complete-history link.

![Local changelog with labeled categories, keyboard controls and complete-history link.](assets-github/screenshots/screenshot-2.jpg)

## Changelog

Seven recent versions; the Wiki and local full history retain all documented entries.

### 0.18.0

2026-10-05

- **New:** Optional four-step guided setup.
- **New:** Eight-field informational report in Tools → Site Health, without extra tests or external requests.
- **Improved:** Tab icons support audience selection, viewing permission, downloads, PNG media actions and official Site Icon adoption.
- **Improved:** Adds network activation, per-site personal colors, profile/AJAX/Undo isolation and new-subsite permission provisioning.
- **Improved:** Ships informal and formal German, shared documentation sources, a dated local changelog and localized GitHub banners.
- **Fix:** Keeps network-profile AJAX color changes global and rejects Undo snapshots from another storage scope.
- **Fix:** Checks upload permission and available Multisite space for agency images and PNG icons.
- **Fix:** Keeps save actions and long translated choices within narrow admin screens.
- **Fix:** Preserves named scheme colors during validation and protects later personal color changes from Undo.
- **Misc:** Includes deckerweb Plugin Library 0.5.0; preserves Updater V2.
- **Misc:** Documents security reporting and data ownership; uninstall clears temporary Undo and updater cache while preserving branding, media and user choices.

### 0.17.0 (development)

Release date not recorded

- **New:** Compact, read-only Site Health information without status tests.

### 0.16.3

2026-09-30

- **Improved:** Shows the plugin icon in WordPress update offers and localized English/German banners in plugin details.
- **Improved:** Links footer documentation directly to the localized Wiki and opens the complete bundled changelog in an accessible local dialog.
- **Fix:** Restores missing update artwork, including already cached update offers after this version is installed.
- **Misc:** Uses the shared DECKERWEB GitHub Updater V2 with plugin-scoped package identity and requirements checks.

### 0.16.2

2026-09-30

- **Improved:** Refreshes all four readmes with clear feature summaries, seven short FAQs, and the latest five version entries.
- **Improved:** Adds a German GitHub banner and expands the bilingual Wiki with 49 themed FAQ answers per language and complete changelogs.
- **Improved:** Adds checked contents links, presents browser-tab favicons alongside the main features, and explains GitHub updates through the regular WordPress update system.
- **Misc:** Packages the updated English and German documentation with this release.

### 0.16.1

2026-09-29

- **Improved:** Adopts the Daily Scripture footer layout, adds a documentation link beside the changelog, and includes a translated brand slogan.
- **Misc:** Sets the DECKERWEB copyright range to 2022–2026 throughout the plugin and documentation.

### 0.16.0

Release date not recorded

- **New:** Adds a compact settings footer with local documentation and changelog dialogs.
- **Improved:** Includes matching English and German Markdown and WordPress-style text readmes.
- **Improved:** Groups each release by New, Improved, Fixed, and Misc, in that order.
- **Fix:** Corrects the frontend-toolbar checkbox markup, translates missing German error messages, and registers three missing JavaScript translation labels.
- **Misc:** Adds a license file, release notes and repository packaging rules.

### 0.15.1

Release date not recorded

- **Improved:** Refreshes the short plugin description and GitHub documentation for the full feature set.
- **Misc:** Adds two banner concepts and two matching icon concepts as SVG and PNG design alternatives.

## About

Built by **David Decker – DECKERWEB** to make client sites feel familiar on both sides of the login screen. Ideas behind the plugin grew from snippets used since 2022.

The scheme styles the WordPress admin shell; third-party CSS can affect individual elements. Gutenberg content and builder canvases keep their own design. SVG login images require Safe SVG and administrator confirmation. More details are in the wiki.

Have an idea or found an issue? [Let us know on GitHub](https://github.com/deckerweb/brand-admin-schemes/issues).

© 2022–2026 David Decker – DECKERWEB · [GPL v2 or later](LICENSE)
