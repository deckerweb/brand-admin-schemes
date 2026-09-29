# Brand Admin Schemes

**Make WordPress feel like your client's site.** Start with colors from Core Framework, Bricks Builder, Automatic.css, or your own palette. Explore four moods, move the brand strength slider, and preview the result before saving. The same palette can shape the admin, login, toolbar, browser tabs, and optionally Gutenberg's color choices.

No CSS homework. A client site can feel like *their* site on both sides of the login screen.

**Current version:** 0.16.1 · **Requires:** WordPress 6.4+ and PHP 8.0+ · **License:** GPL v2 or later

[Deutsche Dokumentation](README-de.md)

## At a glance

- **Know which tab is which:** optional generated favicons distinguish the public site, WordPress admin, and active builder editor, with a small environment marker if desired.

- **Use the colors you already have:** read available hex colors from Core Framework, a Bricks color palette, or Automatic.css (ACSS). Every integration is optional; manual colors always work.
- **Four moods:** Balanced, Calm, Bold, and Dark offer different starting points from the same brand palette.
- **Brand strength slider:** make the result more restrained or more expressive, with live card updates.
- **Try before you apply:** hover over a proposal, or focus it with the keyboard, for a temporary admin preview. Escape ends the preview.
- **Keep your favorites:** name schemes, save up to 30, and assign one to your account when saving.
- **Choose who sees it:** leave user choices alone, set the active scheme as a default, or force it for everyone.
- **Continue the look on the frontend:** optionally color the frontend admin bar with a mood- and strength-adjusted Primary, Secondary, Tertiary, or Accent.
- **Take it to the next project:** move settings as JSON or use an agency ZIP with supported local login images.
- **Recover and review:** undo your last save and compare source color changes before updating a saved scheme.
- **Spot the environment:** a compact icon and label on the frontend and backend admin bar show Local, Development, Staging, or Live. Auto-detection or a manual selection is available.
- **Make the login feel like the site:** responsive split, reversed, or centered layouts, an optional customer logo and background image, an editable welcome, and palette-derived or custom colors.
- **Catch problems early:** unsaved-change reminders and a sample contrast check keep your choices easy to review.
- **Share colors with Gutenberg:** optionally add the four brand roles to the editor palette alongside theme colors.
- **Update from GitHub Releases:** the bundled updater integrates published releases into WordPress's update screen.

## Installation and first scheme

1. Download the plugin ZIP from [GitHub Releases](https://github.com/deckerweb/brand-admin-schemes/releases), upload it via **Plugins → Add New → Upload Plugin**, and activate it.
2. Open **Settings → Brand Admin Schemes**. The **Color scheme** link on the Plugins screen takes you there too.
3. Choose an available source palette or enter your own colors. Primary, Secondary, and Accent are enough to get going; Tertiary can be derived. Choose a mood and move the slider.
4. Hover or focus a proposal to try it. Click the card you like, optionally name it, and use **Save scheme** in the sticky toolbar.
5. Click **Reload page** in that toolbar to see the saved scheme throughout the current admin screen.

The settings page and save actions require the WordPress `manage_options` capability.

## How it works

The brand roles are Primary, Secondary, Tertiary, and Accent. Map source colors to these roles or let the editor derive an intermediate Tertiary shade from Primary and Secondary. The mood and slider produce colors for the menu, submenu, toolbar, highlights, buttons, and links.

| Source | What is read |
| --- | --- |
| Core Framework | Simple six-digit hex custom properties in its readable generated stylesheet, when its Helper exposes that file. |
| Bricks Builder | Hex colors in available Bricks color palettes. |
| Automatic.css | Enabled, readable hex role colors through the ACSS settings API; the adapter was inspected against ACSS 3.3.7 and 4.0.1. |
| Manual | Colors you enter in the editor, without any other plugin. |

Only readable sources appear in the selector. Resulting colors are saved, so a scheme remains available if its source later disappears. **Source changes are not silently synchronized:** compare the old and new swatches and confirm before saving an updated scheme. The sample contrast check is a guide, not a complete accessibility audit.

| Default mode | Effect |
| --- | --- |
| No default | Users keep their own WordPress color scheme choices. |
| Default; allow personal selection | The active scheme applies to users on WordPress's `modern` default. WordPress cannot distinguish an untouched Modern choice from an explicit Modern choice. |
| Force for all users | The active scheme overrides personal choices and hides the profile color picker. |

Optional frontend admin-bar styling applies to logged-in users with a visible admin bar and a Brand Admin scheme selected. The chosen role receives the scheme’s mood and brand strength adjustment, with a live color swatch in the editor. It uses CSS without frontend JavaScript and calculates a readable text color. Schemes saved before 0.8.0 keep their original role color until you save them again. Third-party CSS may still override individual rules.

## Installation environment badge

The toolbar badge displays the installation status in both the admin and the frontend whenever the WordPress admin bar is visible. Its color fills the full toolbar height. Its SVG icon and short label take little space; the full name and detection source appear in the tooltip and accessible text. For site administrators, hovering or focusing the badge opens a submenu with the current PHP version and whether `WP_DEBUG` is enabled. These runtime details are hidden from other users. The plugin icon also appears on the settings page.

In **Settings → Brand Admin Schemes → Installation environment**, leave **Automatic detection** selected or manually choose **Local**, **Development**, **Staging**, or **Live**. Save the scheme and reload the page to see the toolbar update. A manual choice affects the badge and generated favicon markers; it does not change WordPress's actual environment setting. Four suggested status colors (turquoise for Local, amber for Development, violet for Staging, green for Live) shift subtly away from the visible toolbar color, keeping at least 3:1 contrast between the two areas. Select **Custom color** for any status to use your own hue; the plugin adjusts its lightness only if required for contrast. The badge text switches between dark and light for legibility. The editor previews the result against the selected admin scheme.

Auto-detection trusts `wp_get_environment_type()` first. An explicitly configured `WP_ENVIRONMENT_TYPE` wins even when it says `production`. If WordPress merely returns its unconfigured production default, the plugin examines the saved site address (`home_url()`): `localhost`, `.localhost`, `.test`, `.local` (including Local app sites), any valid `127.0.0.0/8` address, IPv6 loopback `::1` (also expanded or IPv4-mapped), plus `staging.`, `stage.`, `stg.`, `development.`, and `dev.` prefixes. All other addresses display **Live**. URL names are hints, so a manual choice is useful for less conventional setups.

## Login design

Open **Login design** below the environment controls. Enable the design, then choose **Image on the left**, **Image on the right**, or **Centered**. The default split layout gives a large visual panel to the image and a calm form area to the existing WordPress login form. On smaller screens the image becomes a short banner above the form. The centered layout uses a full-page gradient and a compact form.

Choose an optional customer logo and background image through the WordPress media library. With no chosen logo, the WordPress Site Icon is used first, then the theme Custom Logo, then the site name as text. With no background image, choose Diagonal, Aurora, Radial, or a stable per-site Surprise gradient made from the active scheme. The image position controls set the focal point on each axis, while **Overlay strength** lets the brand color soften a photograph. By default the heading uses the WordPress site title and the subtitle uses its tagline. Both can be overridden or hidden independently; “Welcome back” appears only if the site has no title. Preview Desktop, Tablet, and Mobile on the settings page. Choose an optional wide banner instead of the logo, browse nine palette-based gradient swatches, and add a short quote with attribution to the visual panel. The new-tab link opens the **saved** login design; unsaved changes stay in the editor preview.

The login palette follows the site-wide active Brand Admin scheme. It tints the form-side page background subtly and uses the brand Accent as the prominent full-width button. **Customize login colors** lets you override the visual hue, page background, form surface, and button. The original WordPress login, password recovery, registration, and other form actions remain in place; the plugin changes their presentation. Existing installations start with login styling **off** until it is enabled and saved. Image attachments are referenced by site-specific media IDs: when importing settings to another site, choose the logo and image there again if those IDs do not exist. The same JSON export includes the rest of the login settings. Optional SVG logos require the separate Safe SVG plugin, an administrator confirmation in this plugin, and a sanitized SVG attachment. This plugin does not enable raw SVG uploads.

## Move schemes between sites

**Export JSON** downloads the editor settings and saved schemes without image files. On another site, use **Import JSON**, check the preview, then click **Save scheme** to apply the imported result. Import alone does not activate it. The format is `bas/v1`; up to 30 saved schemes are accepted. The file can live in your agency project stack. For supported local image files, use the agency ZIP described below.

## GitHub updates

The built-in updater checks the latest **published, non-prerelease GitHub Release** of this public repository. A tag alone is insufficient. Newer releases appear in WordPress's normal plugin update flow, with GitHub release notes in the plugin details dialog. The updater does not enable automatic updates or use a GitHub token.

For each release, increment the main plugin file's `Version:`, tag the matching `vX.Y.Z` or `X.Y.Z`, and publish a GitHub Release. Prefer an attached `brand-admin-schemes.zip` or `brand-admin-schemes-X.Y.Z.zip` containing a single top-level `brand-admin-schemes/` folder and its `brand-admin-schemes.php` main file. Without a matching asset, the updater can use the release source ZIP if the repository root contains that main file or a matching plugin subfolder. It validates the archive layout before installation. API success is cached for 30 minutes, failure for 10 minutes.

**Release acceptance is pending:** test a real upgrade on staging with the attached ZIP and then the source ZIP fallback before rolling this updater out across client plugins. Confirm the plugin stays active and its settings survive. The reusable implementation is `includes/deckerweb-github-release-updater-v1.php`; its constructor takes the main plugin file, public repository URL, display name, and description. Incompatible library changes should use a new namespace/API version.

## Documentation

The settings footer opens local documentation and the changelog without leaving the editor. English files are `README.md` and `readme.txt`; German files are `README-de.md` and `readme-de.txt`. The Markdown readmes cover the same features as their text counterparts.

## Translations

English source strings and German (`de_DE`) `.po`/`.mo` files are included. WordPress selects German automatically for a German site or user locale. The text domain is `brand-admin-schemes`; files are in `/languages/`. Additional translations are welcome.

## Hooks and filters

Version 0.16.1 exposes **no dedicated public plugin actions or filters**. Internally it uses WordPress hooks such as `get_user_option_admin_color`, `admin_init`, `wp_enqueue_scripts`, `wp_theme_json_data_theme`, and AJAX actions for saving, importing, and undoing. The updater uses `update_plugins_github.com`, `plugins_api`, and `upgrader_source_selection`. These internal callbacks and stored option shapes are not a stable extension API. If a specific integration hook would help, please open an issue.

## FAQ

**Do I need Core Framework, Bricks, or ACSS?** No. Manual colors always work; integrations simply offer colors already present on the site.

**Why is my palette missing?** This version accepts readable hex values. Core Framework needs to expose a generated stylesheet through its Helper. ACSS expressions such as OKLCH/HSL, `light-dark()`, and CSS variables are not parsed as role values.

**Does this recolor Gutenberg or the Bricks editor?** The saved scheme styles the WordPress admin shell and selected elements. Editor and builder canvases are outside this version's styling scope.

**What does the Gutenberg option change?** It adds named brand colors to the editor picker. It does not change existing block colors or the editor interface.

**Will importing change the live scheme immediately?** No. Inspect the imported settings and save to activate.

**Can I update a private repository?** No. The updater supports public GitHub Releases without authentication.

## The story

A client's colors should feel at home where they manage their site. WordPress has admin color schemes, and site builders have brand palettes, yet bringing the two together should be a small, enjoyable task. Brand Admin Schemes grew from that idea: start with the CI colors you already have, play with the atmosphere, and make the dashboard feel familiar in a few clicks.

Built by David Decker for the sites he works on at DECKERWEB. Have fun making the admin your own. :-)

## Contextual browser tab icons

Enable **Tab icons** in the settings to give the public site, WordPress admin, and an active builder editor distinct generated SVG favicons. Frontend generation is optional: you may keep the existing WordPress Site Icon. The feature is initially off on existing sites. Each context offers a short abbreviation or a simple outline symbol plus automatic palette colors or explicit foreground and background colors. The builder preset follows Bricks, Elementor, or Oxygen when its editor is recognized, or you can choose a preset manually. The shapes are original geometric outlines, not official builder logos.

The plugin changes only the browser tab icon in the current context. It does not replace the Site Icon stored in WordPress or upload SVG files. Builder detection is limited to logged-in editor views using known request indicators; ordinary public pages retain their frontend icon. If another plugin rewrites favicons late in its editor shell, behavior may depend on its output order.

Generated favicons may also show a tiny environment letter: **L** for Local, **D** for Development, **S** for Staging, or **P** for Production. The marker follows the detected or manually selected environment and can be turned off. The retained WordPress Site Icon is left alone.

## Review and portability

The settings screen marks edits that have not been saved and asks before a reload or navigation discards them. A contrast check beside the scheme preview measures sample text against admin and login colors, and suggests a correction when a sample falls below 4.5:1. It is a guide to the generated palette; theme and plugin CSS may affect the final display.

Alongside the lightweight JSON settings export, an **agency ZIP package** can carry settings and locally stored PNG, JPEG, WebP or GIF login images. SVG images are excluded. Import places bundled images in the destination Media Library immediately, then loads settings into the editor for review; save to apply them. PHP's ZipArchive extension is required.

The **Gutenberg palette** setting adds up to four named brand colors to the editor's theme palette after a scheme is saved. It is optional and keeps the theme's own colors available. It does not recolor existing content or the editor interface.

## Changelog

### 0.16.1

- **Improved:** Adopts the Daily Scripture footer layout, adds a documentation link beside the changelog, and includes a translated brand slogan.
- **Misc:** Sets the DECKERWEB copyright range to 2022–2026 throughout the plugin and documentation.

### 0.16.0

- **New:** Adds a compact settings footer with local documentation and changelog dialogs.
- **Improved:** Includes matching English and German Markdown and WordPress-style text readmes.
- **Improved:** Groups each release by New, Improved, Fixed, and Misc, in that order.
- **Fixed:** Corrects the frontend-toolbar checkbox markup, translates missing German error messages, and registers three missing JavaScript translation labels.
- **Misc:** Adds a license file, release notes and repository packaging rules.

### 0.15.1

- **Improved:** Refreshes the short plugin description and GitHub documentation for the full feature set.
- **Misc:** Adds two banner concepts and two matching icon concepts as SVG and PNG design alternatives.

### 0.15.0

- **New:** Marks unsaved editor changes and asks before a reload or navigation would discard them.
- **New:** Adds optional environment letters to generated browser favicons for Local, Development, Staging and Live.
- **New:** Adds a contrast audit near the scheme cards with suggested text or background colors when a sample falls below 4.5:1.
- **New:** Exports a ZIP agency package with settings and supported local raster images, and imports it for review. Imported images are added to the Media Library immediately. SVG assets remain outside the bundle. Requires PHP ZipArchive.
- **New:** Adds optional Gutenberg palette entries for the four brand roles while preserving existing theme colors.

### 0.14.2

- **Fixed:** Translates the “Color scheme” settings link on the WordPress Plugins screen into German.

### 0.14.1

- **New:** Adds compact section jump links and moves scheme hover instructions beside the mood cards.
- **Improved:** Clarifies that contextual icons are favicons shown in browser tabs, and names each website, admin and builder tab explicitly.
- **Improved:** Clarifies the fixed save action and gives import/export its own section with a note that media files are not packaged in JSON.

### 0.14.0

- **New:** Introduces contextual browser tab icons for the frontend, WordPress admin and detected Bricks, Elementor or Oxygen editor shell. Existing installations keep their icons until enabled.
- **New:** Adds a three-context SVG icon creator with initials, simple geometric outlines, derived colors, explicit color choices, and live previews. The frontend may retain the WordPress Site Icon.
- **Misc:** Uses safe, generated SVG data URIs rather than accepting pasted SVG markup or changing the WordPress Site Icon attachment.

### 0.13.0

- **New:** Choose a wide customer banner in place of the logo or Site Icon; its displayed width stays within the login form.
- **New:** Optionally add a short, readable quote and attribution to the photo or gradient panel.
- **Improved:** Select from eight softer, palette-derived gradients or one stable per-site surprise, shown as live color swatches. Existing gradient names remain available with smoother transitions.

### 0.12.3

- **New:** Adds a left or centered alignment for the login content, with left alignment as the default. Form fields remain easy to scan.
- **Improved:** Adds SVG icons to the alignment controls and desktop, tablet, and mobile preview buttons.

### 0.12.2

- **Fixed:** Balances long login titles, keeps common short organization suffixes with the preceding word, and wraps unusually long words without horizontal overflow.
- **Fixed:** Applies the same title behavior to the settings preview.

### 0.12.1

- **Fixed:** Keeps the palette-derived login background continuous below the form and privacy link on tall or scrolling screens.
- **Fixed:** Positions the WordPress language selector without adding a desktop grid row.

### 0.12.0

- **New:** Uses the WordPress site title, tagline, and Site Icon automatically, with independent text overrides and visibility switches; the theme logo remains a fallback.
- **New:** Added three palette-generated gradients and a stable per-site surprise option for the visual panel.
- **New:** Allows confirmed administrator selection of SVG logos only when Safe SVG is active; does not enable unsanitized SVG uploads.
- **Improved:** Derived the form-side page color from the scheme, with a manual override, and made the Accent-colored login button full width with more space around it.

### 0.11.0

- **New:** Introduced responsive login design with split and centered layouts, customer logo, optional background image, focal-point and overlay controls, and a welcome message.
- **New:** Added palette-based or custom login colors and live desktop/tablet/mobile previews, while retaining the WordPress login forms.
- **Improved:** Included login settings in import/export; existing installations keep the current login appearance until enabled.

### 0.10.0

- **New:** Added four semantic environment colors that adapt to the visible toolbar and maintain an adjacent contrast target of 3:1.
- **New:** Added optional per-status custom colors with immediate previews and portable JSON settings.
- **Improved:** Adjusted badge icon and text colors for light badge backgrounds.

### 0.9.2

- **Fixed:** Localized the settings page title, subtitle, editor loading text, and sticky header in German as “Markenfarben im Admin.” The English plugin and repository name stay the same.

### 0.9.1

- **New:** Added an administrator-only submenu showing PHP version and `WP_DEBUG` state.
- **Fixed:** Filled the complete toolbar slot with the environment color.

### 0.9.0

- **New:** Added a compact environment badge with four original SVG icons to the frontend and backend admin bar.
- **New:** Added manual environment display and live status preview on the settings page, plus the plugin icon in its heading.
- **New:** Recognizes WordPress environment types first, then local and staging/development address hints when WordPress uses its unconfigured production default; includes `.local`, 127/8 and IPv6 loopback.

### 0.8.0

- **Improved:** Adjusts each selectable frontend toolbar color to the saved mood and brand strength, with a live tone preview. Existing schemes gain the adjustment when saved again.
- **Improved:** Shows color swatches beside selected Core Framework, Bricks, and ACSS role colors.
- **Misc:** Renames the internal Core Framework palette reader to `coreframework_colors()` while preserving saved source identifiers.
- **Misc:** Improves PHP layout and inline documentation.

### 0.7.0

- **Misc:** Extracted the GitHub Release updater into a reusable, versioned V1 class for DECKERWEB plugins.

### 0.6.0

- **New:** Added WordPress update integration for public GitHub Releases, including release details and source ZIP fallback.

### 0.5.1

- **Improved:** Gave the final **Preview and apply** section more breathing room.

### 0.5.0

- **New:** Added contrast indicators, source palette change review, and one-step Undo.
- **Fixed:** Fixed duplicate PHP methods accidentally introduced in the 0.4.0 prototype. Do not install 0.4.0.

### 0.4.0

- **New:** Added the **Color scheme** action on the Plugins screen and bundled German translations. This prototype build is superseded by 0.5.0 and later.

### 0.3.1 and earlier prototypes

- **New:** Introduced mood proposals, the brand strength slider, hover/focus preview, named schemes, JSON portability, frontend toolbar color, source palettes, and default controls.

## Scope and license

WordPress 6.4+ and PHP 8.0+ are declared minimum targets, not a claim of a completed compatibility matrix. Preview styling covers the menu, toolbar, and primary buttons; saved styling also covers links. Other plugins may override individual CSS rules. The GitHub upgrade path still needs the staging check above.

Licensed under [GPL v2 or later](https://www.gnu.org/licenses/gpl-2.0.html) (`GPL-2.0-or-later`). Author and copyright: © 2022–2026 David Decker – DECKERWEB. Repository: [github.com/deckerweb/brand-admin-schemes](https://github.com/deckerweb/brand-admin-schemes).
