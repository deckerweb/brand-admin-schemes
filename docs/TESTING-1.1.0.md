# Check an update

[Deutsch](TESTING-1.1.0-de.md)

Brand Admin Schemes 1.1.0 requires WordPress 6.4+ and PHP 8.1+. Test updates on a backed-up staging site.

1. Update from the previous version and compare saved schemes, personal colors, login media and the Site Icon.
2. Save branding, change personal profile colors and check Undo. In two open editors, a stale draft must not overwrite a newer save.
3. In Multisite, confirm independent website colors and the global network-profile preference. Upload a named network starter, preview it on a subsite and save deliberately. Existing branding must not be silently replaced.
4. Open and close the changelog with keyboard and pointer; check focus return and narrow layouts. With JavaScript unavailable, the link opens the local text history.
5. Check the Library and optional online catalog. Test contextual tab icons with the builders actually installed on the staging site; without a builder, ordinary admin pages keep their normal behavior.
6. Review English, informal German and formal German; check PHP logs and the browser console. Report ordinary bugs in Issues and security problems privately through the security policy.

Branding, media and personal colors are retained by updates. Imported settings are reviewed before saving; agency-package images enter the Media Library immediately.
