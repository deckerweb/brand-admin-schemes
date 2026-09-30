=== Brand Admin Schemes ===
Contributors: deckerweb
Tags: admin colors, branding, login, favicon, gutenberg
Requires at least: 6.4
Requires PHP: 8.0
Stable tag: 0.16.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Your colors. Your WordPress. Turn a few brand colors into a familiar WordPress admin, a welcoming login screen, and browser tabs you can tell apart. Use Core Framework, Bricks Builder, Automatic.css, or your own palette. Explore the mood and brand strength, preview, then save. No CSS homework.

Version: 0.16.1 · Requires: WordPress 6.4+ / PHP 8.0+ · License: GPL v2 or later

Download (https://github.com/deckerweb/brand-admin-schemes/releases/latest) · User guide (https://github.com/deckerweb/brand-admin-schemes/wiki/English) · Deutsch (https://github.com/deckerweb/brand-admin-schemes/blob/main/README-de.md)

== Contents ==

- At a glance
- Installation and first scheme
- Brand colors and admin schemes
- Contextual browser tab icons
- Login and toolbar
- Import, export, and Gutenberg
- Updates and documentation
- Changelog
- About

== At a glance ==

- Make the admin yours: four moods, a brand strength slider, hover and keyboard previews, and up to 30 named schemes.
- Use an existing palette: optional Core Framework, Bricks, and ACSS integrations; manual colors always work.
- Welcome your client: responsive login layouts, a logo or small banner, a background photo or nine smooth gradients, editable text, and an optional quote.
- Recognize every browser tab: separate favicons for the website, admin, and recognized builder editor.
- Spot the environment: compact Local, Development, Staging, and Live badges on the frontend and backend toolbar, with matching colors and optional favicon markers.
- Work across projects: JSON settings, agency ZIP packages with supported login images, source-color comparison, Undo, and unsaved-change reminders.
- Keep WordPress familiar: optional default schemes, frontend toolbar colors, Gutenberg palette entries, bundled German translations, and regular WordPress updates.

== Installation and first scheme ==

1. Download the plugin ZIP from GitHub Releases (https://github.com/deckerweb/brand-admin-schemes/releases/latest).
2. Upload it via Plugins → Add New → Upload Plugin and activate it.
3. Open Settings → Brand Admin Schemes, choose a palette, and adjust the mood and brand strength.
4. Hover or focus a scheme card to preview it. Select your favorite, optionally name it, and save using the sticky toolbar.
5. Use Reload page to see the saved result throughout the current admin screen.

Everything is managed on one settings page. Login styling and generated tab icons are optional; enable and save them when you are ready.

== Brand colors and admin schemes ==

Map colors to Primary, Secondary, Tertiary, and Accent. Three colors are enough: the plugin can derive Tertiary. The mood and slider create suitable tones for menus, the toolbar, buttons, and links. You can keep personal user choices, offer a default, or apply the active scheme to everyone.

Saved colors remain available if their provider is removed. When source colors change, compare the old and new palette before saving an update. The sample contrast check helps you review readability.

== Contextual browser tab icons ==

See at a glance whether a browser tab contains the public website, WordPress admin, or builder editor. Create a favicon from a short abbreviation or an outline symbol, with palette colors or your own colors. Presets recognize Bricks, Elementor, and Oxygen editor contexts where supported.

You may retain the existing WordPress Site Icon on the frontend. Optional environment letters make Local, Development, Staging, and Live tabs easier to distinguish. The feature changes the browser-tab icon, not the Site Icon stored in WordPress.

== Login and toolbar ==

The login design follows your active palette. Choose a split or centered layout, then add an optional photo, logo, or small banner. The Site Icon, website title, and tagline provide useful defaults. Nine gradient choices and an optional quote complete the visual panel. Check Desktop, Tablet, and Mobile previews before saving.

The frontend toolbar can use a palette color adjusted to your chosen mood. A compact environment badge appears on frontend and backend toolbars. Detection includes WordPress environment settings, Local app .local sites, and localhost addresses; manual selection and custom status colors are available.

== Import, export, and Gutenberg ==

Move settings and saved schemes as JSON, or include supported local login images in an agency ZIP. Review imported settings and save to apply them. ZIP imports add bundled images to the Media Library immediately and require PHP ZipArchive. SVG images are excluded from these packages.

Optionally add the four named brand colors to Gutenberg alongside the theme palette. Existing content keeps its colors.

== Updates and documentation ==

Updates come directly from the DECKERWEB plugin repository on GitHub (https://github.com/deckerweb/brand-admin-schemes/releases) and appear in the regular WordPress plugin update system. Update from the Plugins or Updates screen as usual; no additional updater plugin is needed.

The English wiki guide (https://github.com/deckerweb/brand-admin-schemes/wiki/English) and German wiki guide (https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) cover every setting, palette sources, login images, tab icons, and common questions. Local documentation and the changelog are available in the settings footer. German is included and follows the WordPress site or user language.

== Changelog ==

= 0.16.1 =

- Improved: Adopts the Daily Scripture footer layout, adds a documentation link beside the changelog, and includes a translated brand slogan.
- Misc: Sets the DECKERWEB copyright range to 2022–2026 throughout the plugin and documentation.

= 0.16.0 =

- New: Adds a compact settings footer with local documentation and changelog dialogs.
- Improved: Includes matching English and German Markdown and WordPress-style text readmes.
- Improved: Groups each release by New, Improved, Fixed, and Misc, in that order.
- Fixed: Corrects the frontend-toolbar checkbox markup, translates missing German error messages, and registers three missing JavaScript translation labels.
- Misc: Adds a license file, release notes and repository packaging rules.

= 0.15.1 =

- Improved: Refreshes the short plugin description and GitHub documentation for the full feature set.
- Misc: Adds two banner concepts and two matching icon concepts as SVG and PNG design alternatives.

= 0.15.0 =

- New: Marks unsaved editor changes and asks before a reload or navigation would discard them.
- New: Adds optional environment letters to generated browser favicons for Local, Development, Staging and Live.
- New: Adds a contrast audit near the scheme cards with suggested text or background colors when a sample falls below 4.5:1.
- New: Exports a ZIP agency package with settings and supported local raster images, and imports it for review. Imported images are added to the Media Library immediately. SVG assets remain outside the bundle. Requires PHP ZipArchive.
- New: Adds optional Gutenberg palette entries for the four brand roles while preserving existing theme colors.

= 0.14.2 =

- Fixed: Translates the “Color scheme” settings link on the WordPress Plugins screen into German.

= 0.14.1 =

- New: Adds compact section jump links and moves scheme hover instructions beside the mood cards.
- Improved: Clarifies that contextual icons are favicons shown in browser tabs, and names each website, admin and builder tab explicitly.
- Improved: Clarifies the fixed save action and gives import/export its own section with a note that media files are not packaged in JSON.

= 0.14.0 =

- New: Introduces contextual browser tab icons for the frontend, WordPress admin and detected Bricks, Elementor or Oxygen editor shell. Existing installations keep their icons until enabled.
- New: Adds a three-context SVG icon creator with initials, simple geometric outlines, derived colors, explicit color choices, and live previews. The frontend may retain the WordPress Site Icon.
- Misc: Uses safe, generated SVG data URIs rather than accepting pasted SVG markup or changing the WordPress Site Icon attachment.

= 0.13.0 =

- New: Choose a wide customer banner in place of the logo or Site Icon; its displayed width stays within the login form.
- New: Optionally add a short, readable quote and attribution to the photo or gradient panel.
- Improved: Select from eight softer, palette-derived gradients or one stable per-site surprise, shown as live color swatches. Existing gradient names remain available with smoother transitions.

= 0.12.3 =

- New: Adds a left or centered alignment for the login content, with left alignment as the default. Form fields remain easy to scan.
- Improved: Adds SVG icons to the alignment controls and desktop, tablet, and mobile preview buttons.

= 0.12.2 =

- Fixed: Balances long login titles, keeps common short organization suffixes with the preceding word, and wraps unusually long words without horizontal overflow.
- Fixed: Applies the same title behavior to the settings preview.

= 0.12.1 =

- Fixed: Keeps the palette-derived login background continuous below the form and privacy link on tall or scrolling screens.
- Fixed: Positions the WordPress language selector without adding a desktop grid row.

= 0.12.0 =

- New: Uses the WordPress site title, tagline, and Site Icon automatically, with independent text overrides and visibility switches; the theme logo remains a fallback.
- New: Added three palette-generated gradients and a stable per-site surprise option for the visual panel.
- New: Allows confirmed administrator selection of SVG logos only when Safe SVG is active; does not enable unsanitized SVG uploads.
- Improved: Derived the form-side page color from the scheme, with a manual override, and made the Accent-colored login button full width with more space around it.

= 0.11.0 =

- New: Introduced responsive login design with split and centered layouts, customer logo, optional background image, focal-point and overlay controls, and a welcome message.
- New: Added palette-based or custom login colors and live desktop/tablet/mobile previews, while retaining the WordPress login forms.
- Improved: Included login settings in import/export; existing installations keep the current login appearance until enabled.

= 0.10.0 =

- New: Added four semantic environment colors that adapt to the visible toolbar and maintain an adjacent contrast target of 3:1.
- New: Added optional per-status custom colors with immediate previews and portable JSON settings.
- Improved: Adjusted badge icon and text colors for light badge backgrounds.

= 0.9.2 =

- Fixed: Localized the settings page title, subtitle, editor loading text, and sticky header in German as “Markenfarben im Admin.” The English plugin and repository name stay the same.

= 0.9.1 =

- New: Added an administrator-only submenu showing PHP version and WP_DEBUG state.
- Fixed: Filled the complete toolbar slot with the environment color.

= 0.9.0 =

- New: Added a compact environment badge with four original SVG icons to the frontend and backend admin bar.
- New: Added manual environment display and live status preview on the settings page, plus the plugin icon in its heading.
- New: Recognizes WordPress environment types first, then local and staging/development address hints when WordPress uses its unconfigured production default; includes .local, 127/8 and IPv6 loopback.

= 0.8.0 =

- Improved: Adjusts each selectable frontend toolbar color to the saved mood and brand strength, with a live tone preview. Existing schemes gain the adjustment when saved again.
- Improved: Shows color swatches beside selected Core Framework, Bricks, and ACSS role colors.
- Misc: Renames the internal Core Framework palette reader to coreframework_colors() while preserving saved source identifiers.
- Misc: Improves PHP layout and inline documentation.

= 0.7.0 =

- Misc: Extracted the GitHub Release updater into a reusable, versioned V1 class for DECKERWEB plugins.

= 0.6.0 =

- New: Added WordPress update integration for public GitHub Releases, including release details and source ZIP fallback.

= 0.5.1 =

- Improved: Gave the final Preview and apply section more breathing room.

= 0.5.0 =

- New: Added contrast indicators, source palette change review, and one-step Undo.
- Fixed: Fixed duplicate PHP methods accidentally introduced in the 0.4.0 prototype. Do not install 0.4.0.

= 0.4.0 =

- New: Added the Color scheme action on the Plugins screen and bundled German translations. This prototype build is superseded by 0.5.0 and later.

= 0.3.1 and earlier prototypes =

- New: Introduced mood proposals, the brand strength slider, hover/focus preview, named schemes, JSON portability, frontend toolbar color, source palettes, and default controls.

== About ==

Built by David Decker – DECKERWEB to make client sites feel familiar on both sides of the login screen. Ideas behind the plugin grew from snippets used since 2022.

The scheme styles the WordPress admin shell; third-party CSS can affect individual elements. Gutenberg content and builder canvases keep their own design. SVG login images require Safe SVG and administrator confirmation. More details are in the wiki.

Have an idea or found an issue? Let us know on GitHub (https://github.com/deckerweb/brand-admin-schemes/issues).

© 2022–2026 David Decker – DECKERWEB · GPL v2 or later (https://github.com/deckerweb/brand-admin-schemes/blob/main/LICENSE)
