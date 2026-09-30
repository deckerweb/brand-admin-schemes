# Frequently asked questions

[Anleitung / Guide](https://github.com/deckerweb/brand-admin-schemes/wiki/English) · [English](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-English) · [Deutsch](https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-Deutsch)

Answers about the current version. Planned features are not described as available here.

## Topics

- [Getting started](#topic-1)
- [Palettes and admin schemes](#topic-2)
- [Previewing and saving](#topic-3)
- [Login design and images](#topic-4)
- [Browser tabs and environments](#topic-5)
- [Import, export, and Gutenberg](#topic-6)
- [Updates, language, and troubleshooting](#topic-7)

<a name="topic-1"></a>

## Getting started

### Do I need Core Framework, Bricks, or ACSS?

No. Enter your own colors; palette providers are optional.

### What are the requirements?

WordPress 6.4 or later and PHP 8.0 or later. Install the plugin ZIP from GitHub Releases.

### Who can change settings?

Users with the WordPress manage_options capability, normally administrators.

### Do I have to enable every feature?

No. Login design, generated favicons, and Gutenberg palette entries are optional. Enable only what you need.

### Is the plugin paid software?

The plugin is free software under GPL v2 or later. Optional palette providers may have their own licenses.


<a name="topic-2"></a>

## Palettes and admin schemes

### How many colors do I need?

Primary, Secondary, and Accent are enough. Tertiary can be derived; four explicit colors are also supported.

### Why is my provider palette missing?

Only readable hex sources appear. Core Framework must expose its generated stylesheet through its Helper. ACSS role expressions such as OKLCH, HSL, light-dark(), and CSS variables are not parsed. Try manual hex colors if needed.

### Will source changes update my scheme automatically?

No. Compare the old and new source swatches and save an updated scheme when you are ready.

### What happens if I disable a palette provider?

Saved scheme colors remain available. The provider is needed to read a fresh palette, not to display saved colors.

### What do mood and brand strength change?

They derive the tones used for menus, toolbar, buttons, and links from your source colors. Preview a proposal before selecting and saving it.

### Can users keep their own admin colors?

Yes. Keep personal choices, offer a default, or force the active scheme for everyone. The default applies to the WordPress Modern choice; WordPress cannot tell whether that choice was made explicitly.

### Can I name and save several schemes?

Yes, up to 30 named schemes. A short client or atmosphere name helps you find them later.

### Does this change my website or builder design?

It styles the admin shell, optional login and toolbar, and browser-tab icons. Page content and builder canvases keep their design; Gutenberg palette entries only add choices.

### Does the contrast check guarantee accessibility?

No. It checks representative color samples. Inspect real screens, focus states, and third-party elements as well; this is not a full accessibility audit.


<a name="topic-3"></a>

## Previewing and saving

### Does hovering over a scheme save it?

No. Hover or keyboard focus previews it. Select the card and use the sticky save button to apply your settings.

### Why does another tab still show old colors?

Save first, then reload that tab. The preview affects the settings screen; it does not synchronize every open browser tab.

### Can I undo a save?

The Undo action can restore the previous save when available. It is a single-step safety net, not a version archive; export important configurations.

### Can I use the previews without a mouse?

Scheme cards also preview on keyboard focus. Check the visible focus and use the settings controls with the keyboard.


<a name="topic-4"></a>

## Login design and images

### Do I need a logo and a background photo?

No. The Site Icon, theme logo, and site name provide fallbacks; palette gradients work without a photo.

### Can I use a wide banner instead of a square logo?

Yes. Choose a login banner; its displayed width stays within the form area.

### Can I change the title, tagline, and login colors?

Yes. Website title and tagline are defaults; override or hide each independently. Customize the page background, form surface, visual hue, and button if needed.

### What helps with long website titles?

Titles wrap within the form-side area. Try centered content alignment or a shorter custom title, and review Desktop, Tablet, and Mobile previews.

### Why does the login opened in a new tab look different from the preview?

The new-tab link shows the saved design. Save all changes before comparing it with the editor preview.

### Can I use SVG login images?

Only with the separate Safe SVG plugin, an administrator confirmation, and a sanitized attachment. Brand Admin Schemes does not enable raw SVG uploads. Agency ZIP packages exclude SVG files.

### Does it replace WordPress login or password recovery?

No. It changes presentation; the WordPress forms and their actions remain. Other login plugins can affect the final appearance, so check their interaction.

### Are gradients different on every reload?

No. The Surprise variant is stable per site. Choose one of the nine swatches to control the appearance.


<a name="topic-5"></a>

## Browser tabs and environments

### Does it replace the WordPress Site Icon?

No. It generates contextual browser-tab favicons without changing the stored Site Icon. You can retain the original frontend favicon.

### Which builder contexts are recognized?

Supported editor indicators for Bricks, Elementor, and Oxygen are recognized for logged-in editor views. Detection is limited to those indicators; other plugins or changed editor shells can affect it.

### How long can the favicon abbreviation be?

Up to three characters. One or two usually remain easier to read at browser-tab size; outline symbols are also available.

### Why do I still see an old favicon?

Save the icon settings and reload or reopen the tab. Browsers cache favicons. Also check whether another plugin or builder replaces the icon later.

### How is Local, Development, Staging, or Live detected?

An explicitly configured WordPress environment wins. Otherwise common local addresses and dev/staging host prefixes are hints. .local, localhost, 127.0.0.0/8, and IPv6 loopback are covered; unusual domains may need manual selection.

### Does manually selecting Staging change WordPress configuration?

No. It changes the displayed badge and generated favicon marker, not WP_ENVIRONMENT_TYPE, debugging, or indexing settings.

### Who can see PHP and WP_DEBUG details?

Site administrators can open the toolbar badge submenu. These runtime details are hidden from other users.

### Can I choose my own environment colors?

Yes. A custom hue is allowed for every status. Lightness may be adjusted for contrast with the toolbar; badge text switches between dark and light.

### Why is the frontend badge missing?

It needs a visible WordPress admin bar. Check that you are logged in and that your profile, theme, or another plugin has not hidden the toolbar.


<a name="topic-6"></a>

## Import, export, and Gutenberg

### Does importing immediately change the live design?

No. Review the imported settings and save to apply them. Agency ZIP imports do add bundled images to the Media Library immediately.

### Should I use JSON or an agency ZIP?

JSON carries settings and schemes, without files. ZIP can also carry supported local login images. Use JSON for a light preset and ZIP for a portable visual setup.

### Which image files and sizes are supported in agency packages?

Local PNG, JPEG, WebP, and GIF images, up to 4 MB each and 13 MB for the package. SVG files are excluded. Import/export requires PHP ZipArchive.

### Why did a JSON import not restore my logo?

JSON stores site-specific media references, not image files. Select the images again on the destination site, or use an agency ZIP with supported images.

### Does the Gutenberg palette change existing blocks?

No. It adds up to four brand colors alongside the theme palette. Existing block colors and the editor interface stay as they are.


<a name="topic-7"></a>

## Updates, language, and troubleshooting

### How do updates work?

Updates come from the public DECKERWEB GitHub repository through the regular WordPress plugin update system. No extra updater plugin is required.

### Why is a GitHub release not visible as an update yet?

Use Check again on Dashboard → Updates. Check server access to GitHub. You can also upload the latest plugin ZIP through WordPress to replace the installed version.

### Does the plugin enable automatic updates for me?

No. Choose automatic updates yourself using the available WordPress controls.

### Can I use a private GitHub repository for updates?

Not with the bundled updater. It reads public GitHub Releases without authentication.

### How do I switch to German?

German translations are bundled. Choose German as the WordPress site language or your user language; no language pack download is needed.

### Does it need a remote service to generate colors?

No. Palette processing and icon generation happen locally. Update checks and downloads contact GitHub.

### Does deactivation delete my settings?

No. Styling stops while the plugin is inactive; saved settings remain. Export a configuration before making major changes.

### Is there a network-wide multisite settings screen?

This version stores settings per site and has no network-wide preset manager. Review each site separately; broad multisite compatibility is not guaranteed by this guide.

### What should I include in a bug report?

Plugin, WordPress, and PHP versions; relevant provider or builder version; the affected screen; and steps to reproduce. Use anonymized screenshots and remove credentials or private client information before posting a public GitHub issue.

© 2022–2026 David Decker – DECKERWEB · GPL v2 or later
