# Palette providers

[Deutsch](PROVIDERS-de.md)

Choose Settings → Brand Admin Schemes → Color source. WordPress / Site Editor groups Theme colors, Custom global colors and WordPress default colors. Elementor uses the active kit's system and custom global colors; Elementor Free is sufficient. Oxygen Classic reads its Global Colors sets, with the original names. Its adapter targets 4.x and does not treat Oxygen 6+ as Classic.

Select a source and palette, map colors to the four brand roles, preview and save. Sources are read only; BAS never edits the owner's palettes. The optional BAS Gutenberg palette is separate and is excluded from the native provider's input. No provider makes remote requests. Cached reads last only within one request and are isolated by website, active theme and interface language.

Supported values: three/six-digit HEX, fully opaque eight-digit HEX, and comma-separated RGB/RGBA with opacity 1. Unsupported expressions, variables and translucent values are omitted rather than approximated. Sources without usable colors remain hidden. Missing sources or palettes fall back to saved brand colors in manual mode. Saved branding does not synchronize automatically with a palette.

Elementor Pro is not required. The adapter uses Free's shared kit color model; Pro-specific additions and Atomic variable systems are outside this adapter's scope. No frontend/page colors are scanned. Use the existing JSON/portable template workflows to reuse saved branding; portable templates retain literal colors rather than references to another website's provider IDs.

In Multisite each website reads its own active theme, active kit and Oxygen options. A provider active only on another website is not offered. Network activation of BAS does not copy color settings.
