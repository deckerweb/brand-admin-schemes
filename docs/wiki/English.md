# User guide

[Deutsch](https://github.com/deckerweb/brand-admin-schemes/wiki/Deutsch) · [Home](https://github.com/deckerweb/brand-admin-schemes/wiki)

A practical guide to Brand Admin Schemes 0.16.3. Use the contents below to jump to a setting.

## Contents

- [Installation and first scheme](#installation-and-first-scheme)
- [How it works](#how-it-works)
- [Contextual browser tab icons](#contextual-browser-tab-icons)
- [Installation environment badge](#installation-environment-badge)
- [Login design](#login-design)
- [Move schemes between sites](#move-schemes-between-sites)
- [Review and portability](#review-and-portability)
- [Updates](#updates)
- [Translations](#translations)
- [Extensions](#extensions)
- [FAQ](#faq)
- [The story](#the-story)
- [Changelog](#changelog)

<a name="installation-and-first-scheme"></a>

## Installation and first scheme

1. Download the plugin ZIP from [GitHub Releases](https://github.com/deckerweb/brand-admin-schemes/releases), upload it via **Plugins → Add New → Upload Plugin**, and activate it.
2. Open **Settings → Brand Admin Schemes**. The **Color scheme** link on the Plugins screen takes you there too.
3. Choose an available source palette or enter your own colors. Primary, Secondary, and Accent are enough to get going; Tertiary can be derived. Choose a mood and move the slider.
4. Hover or focus a proposal to try it. Click the card you like, optionally name it, and use **Save scheme** in the sticky toolbar.
5. Click **Reload page** in that toolbar to see the saved scheme throughout the current admin screen.

The settings page and save actions require the WordPress `manage_options` capability.

<a name="how-it-works"></a>

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

<a name="contextual-browser-tab-icons"></a>

## Contextual browser tab icons

Enable **Tab icons** in the settings to give the public site, WordPress admin, and an active builder editor distinct generated SVG favicons. Frontend generation is optional: you may keep the existing WordPress Site Icon. The feature is initially off on existing sites. Each context offers an abbreviation of up to three characters or a simple outline symbol plus automatic palette colors or explicit foreground and background colors. The builder preset follows Bricks, Elementor, or Oxygen when its editor is recognized, or you can choose a preset manually. The shapes are original geometric outlines, not official builder logos.

The plugin changes only the browser tab icon in the current context. It does not replace the Site Icon stored in WordPress or upload SVG files. Builder detection is limited to logged-in editor views using known request indicators; ordinary public pages retain their frontend icon. If another plugin rewrites favicons late in its editor shell, behavior may depend on its output order.

Generated favicons may also show a tiny environment letter: **L** for Local, **D** for Development, **S** for Staging, or **P** for Production. The marker follows the detected or manually selected environment and can be turned off. The retained WordPress Site Icon is left alone.

<a name="installation-environment-badge"></a>

## Installation environment badge

The toolbar badge displays the installation status in both the admin and the frontend whenever the WordPress admin bar is visible. Its color fills the full toolbar height. Its SVG icon and short label take little space; the full name and detection source appear in the tooltip and accessible text. For site administrators, hovering or focusing the badge opens a submenu with the current PHP version and whether `WP_DEBUG` is enabled. These runtime details are hidden from other users. The plugin icon also appears on the settings page.

In **Settings → Brand Admin Schemes → Installation environment**, leave **Automatic detection** selected or manually choose **Local**, **Development**, **Staging**, or **Live**. Save the scheme and reload the page to see the toolbar update. A manual choice affects the badge and generated favicon markers; it does not change WordPress's actual environment setting. Four suggested status colors (turquoise for Local, amber for Development, violet for Staging, green for Live) shift subtly away from the visible toolbar color, keeping at least 3:1 contrast between the two areas. Select **Custom color** for any status to use your own hue; the plugin adjusts its lightness only if required for contrast. The badge text switches between dark and light for legibility. The editor previews the result against the selected admin scheme.

Auto-detection trusts `wp_get_environment_type()` first. An explicitly configured `WP_ENVIRONMENT_TYPE` wins even when it says `production`. If WordPress merely returns its unconfigured production default, the plugin examines the saved site address (`home_url()`): `localhost`, `.localhost`, `.test`, `.local` (including Local app sites), any valid `127.0.0.0/8` address, IPv6 loopback `::1` (also expanded or IPv4-mapped), plus `staging.`, `stage.`, `stg.`, `development.`, and `dev.` prefixes. All other addresses display **Live**. URL names are hints, so a manual choice is useful for less conventional setups.

<a name="login-design"></a>

## Login design

Open **Login design** below the environment controls. Enable the design, then choose **Image on the left**, **Image on the right**, or **Centered**. The default split layout gives a large visual panel to the image and a calm form area to the existing WordPress login form. On smaller screens the image becomes a short banner above the form. The centered layout uses a full-page gradient and a compact form. Independently choose left or centered alignment for the form-side content; left alignment is the default.

Choose an optional customer logo and background image through the WordPress media library. With no chosen logo, the WordPress Site Icon is used first, then the theme Custom Logo, then the site name as text. With no background image, choose Diagonal, Aurora, Radial, or a stable per-site Surprise gradient made from the active scheme. The image position controls set the focal point on each axis, while **Overlay strength** lets the brand color soften a photograph. By default the heading uses the WordPress site title and the subtitle uses its tagline. Both can be overridden or hidden independently; “Welcome back” appears only if the site has no title. Preview Desktop, Tablet, and Mobile on the settings page. Choose an optional wide banner instead of the logo, browse nine palette-based gradient swatches, and add a short quote with attribution to the visual panel. The new-tab link opens the **saved** login design; unsaved changes stay in the editor preview.

The login palette follows the site-wide active Brand Admin scheme. It tints the form-side page background subtly and uses the brand Accent as the prominent full-width button. **Customize login colors** lets you override the visual hue, page background, form surface, and button. The original WordPress login, password recovery, registration, and other form actions remain in place; the plugin changes their presentation. Existing installations start with login styling **off** until it is enabled and saved. Image attachments are referenced by site-specific media IDs: when importing settings to another site, choose the logo and image there again if those IDs do not exist. The same JSON export includes the rest of the login settings. Optional SVG logos require the separate Safe SVG plugin, an administrator confirmation in this plugin, and a sanitized SVG attachment. This plugin does not enable raw SVG uploads.

<a name="move-schemes-between-sites"></a>

## Move schemes between sites

**Export JSON** downloads the editor settings and saved schemes without image files. On another site, use **Import JSON**, check the preview, then click **Save scheme** to apply the imported result. Import alone does not activate it. The format is `bas/v1`; up to 30 saved schemes are accepted. The file can live in your agency project stack. For supported local image files, use the agency ZIP described below.

<a name="review-and-portability"></a>

## Review and portability

The settings screen marks edits that have not been saved and asks before a reload or navigation discards them. A contrast check beside the scheme preview measures sample text against admin and login colors, and suggests a correction when a sample falls below 4.5:1. It is a guide to the generated palette; theme and plugin CSS may affect the final display.

Alongside the lightweight JSON settings export, an **agency ZIP package** can carry settings and locally stored PNG, JPEG, WebP or GIF login images. SVG images are excluded. Import places bundled images in the destination Media Library immediately, then loads settings into the editor for review; save to apply them. PHP's ZipArchive extension is required. Each image may be up to 4 MB; the total import package may be up to 13 MB.

The **Gutenberg palette** setting adds up to four named brand colors to the editor's theme palette after a scheme is saved. It is optional and keeps the theme's own colors available. It does not recolor existing content or the editor interface.

<a name="updates"></a>

## Updates

Updates come from the [DECKERWEB plugin repository on GitHub](https://github.com/deckerweb/brand-admin-schemes/releases) and appear in WordPress’s regular update system. Open **Dashboard → Updates** or **Plugins**, then update Brand Admin Schemes as usual. No additional updater plugin is required.

If an update is not visible yet, use **Check again** on the WordPress Updates screen. You can also download the latest plugin ZIP from GitHub Releases and upload it through WordPress to replace the installed version.

The built-in updater does not enable automatic updates for you.


<a name="translations"></a>

## Translations

English source strings and German (`de_DE`) `.po`/`.mo` files are included. WordPress selects German automatically for a German site or user locale. The text domain is `brand-admin-schemes`; files are in `/languages/`. Additional translations are welcome.

<a name="extensions"></a>

## Extensions

Version 0.16.3 has no dedicated public plugin hooks or filters. Please [open an issue](https://github.com/deckerweb/brand-admin-schemes/issues) if a documented integration would help your project.

<a name="faq"></a>

## FAQ

**Do I need Core Framework, Bricks, or ACSS?** No. Enter your own colors; palette providers are optional.

**What happens if I disable a palette provider?** Saved scheme colors remain available. The provider is needed to read a fresh palette, not to display saved colors.

**Does this change my website or builder design?** It styles the admin shell, optional login and toolbar, and browser-tab icons. Page content and builder canvases keep their design; Gutenberg palette entries only add choices.

**Do I need a logo and a background photo?** No. The Site Icon, theme logo, and site name provide fallbacks; palette gradients work without a photo.

**Does it replace the WordPress Site Icon?** No. It generates contextual browser-tab favicons without changing the stored Site Icon. You can retain the original frontend favicon.

**Does importing immediately change the live design?** No. Review the imported settings and save to apply them. Agency ZIP imports do add bundled images to the Media Library immediately.

**How do updates work?** Updates come from the public DECKERWEB GitHub repository through the regular WordPress plugin update system. No extra updater plugin is required.

[More answers by topic](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-English)

<a name="the-story"></a>

## The story

A client's colors should feel at home where they manage their site. WordPress has admin color schemes, and site builders have brand palettes, yet bringing the two together should be a small, enjoyable task. Brand Admin Schemes grew from that idea: start with the CI colors you already have, play with the atmosphere, and make the dashboard feel familiar in a few clicks.

Built by David Decker for the sites he works on at DECKERWEB. Have fun making the admin your own. :-)

<a name="changelog"></a>

## Changelog

[Full English changelog](https://github.com/deckerweb/brand-admin-schemes/wiki/Changelog-English) · [GitHub Releases](https://github.com/deckerweb/brand-admin-schemes/releases)

© 2022–2026 David Decker – DECKERWEB · GPL v2 or later

The footer links to the German or English Wiki guide. Changelog opens the complete bundled local history; without JavaScript, the link opens its localized changelog text file.
