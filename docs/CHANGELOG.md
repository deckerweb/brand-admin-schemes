# Changelog

[Deutsch](CHANGELOG-de.md) · [Wiki](https://github.com/deckerweb/brand-admin-schemes/wiki)

### 0.16.2

- **Improved:** Refreshes all four readmes with clear feature summaries, seven short FAQs, and the latest five version entries.
- **Improved:** Adds a German GitHub banner and expands the bilingual Wiki with 49 themed FAQ answers per language and complete changelogs.
- **Improved:** Adds checked contents links, presents browser-tab favicons alongside the main features, and explains GitHub updates through the regular WordPress update system.
- **Misc:** Packages the updated English and German documentation with this release.

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
