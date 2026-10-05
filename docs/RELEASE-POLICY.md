# Release policy

[Deutsch](RELEASE-POLICY-de.md)

New backward-compatible features increment the feature version (for example 0.18.0). Fix-only releases increment the final number. Incompatible data or behavior changes require a separately documented migration and an explicit version/minimum review before release. `dev` and `rc` builds remain unpublished acceptance packages; their dates are build dates, not stable release dates.

Seven recent versions appear in readmes and the local modal. Expand that range until two documented feature versions are included. The prepared 0.18.0 build shows seven records, through 0.15.1; 0.17.0 remains an unpublished development entry. The 0.18.0 publication date is assigned only after release approval. Full local text/Markdown and Wiki history retain all known entries. Release dates are taken only from verified GitHub release metadata; unavailable historical dates remain clearly unidentified.

Categories are New, Improved, Fix, Misc, in that order; German uses Neu, Verbessert, Behoben, Sonstiges. `docs/source/content.json` is the shared source for all readmes, their seven short FAQs, complete Wiki FAQ, release notes and history. Run `python3 tools/build-documentation.py`. `docs/source/messages.json` supplies EN, informal and formal German; run `python3 tools/build-languages.py`. Runtime outputs and source tools are separate package selections.

Before stable release: validate the actual ZIP, platform minimums, update path, permissions, languages, settings preservation, site and network activation, new sites, role revocation, Core profile/AJAX/Undo, image processing and quota. Review PHP logs, browser console, keyboard/focus/mobile behavior, current platform policies and the repository's private security reporting setting. Library and Updater must remain the reviewed original components. Real provider/builder and assistive-technology acceptance require their actual environments. Publication and catalog updates require release authorization; no local test build performs them.
