# Security

[Deutsch](SECURITY-de.md)

Report suspected vulnerabilities privately through [GitHub security reporting for Brand Admin Schemes](https://github.com/deckerweb/brand-admin-schemes/security/advisories/new). This is also the reporting repository for the embedded deckerweb Plugin Library. If private reporting is unavailable, ask the maintainer to enable it in a normal issue without posting vulnerability details. This local build does not establish that the repository setting is enabled.

Include BAS and Library versions, WordPress/PHP versions, activation scope, a minimal reproduction and the potential impact. Do not include passwords, tokens, personal records or a customer database. Ordinary bugs and feature requests belong in public issues. The maintainer assesses the report privately, prepares and tests a fix, then coordinates disclosure. No response deadline is promised. Production sites should run the latest stable release; development packages require separate acceptance.

Settings changes require `manage_options` and a valid nonce. Media writes also require `upload_files` and respect allowed MIME types, per-file limits and available Multisite storage. Contextual SVG icons are generated from fixed shapes and sanitized text; pasted SVG is not accepted. SVG login images require Safe SVG and an explicit confirmation. Imports are reviewed before applying settings; agency images enter the Media Library immediately.

BAS has no telemetry. Assets are local. Updater V2 queries the public GitHub repository for release metadata and downloads the selected update; the service receives normal HTTP request information, such as server IP address and user agent. Results are cached. The Library online catalog is optional and off initially; its configured source receives normal request metadata. Catalog installation and activation are separate explicit actions. Branding settings and login media are not transmitted to GitHub by BAS. External links open only when followed. A custom login background or quote is website content and is visible to login visitors when enabled.
