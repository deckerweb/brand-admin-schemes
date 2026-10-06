# Testing 1.0.0

[Deutsch](TESTING-1.0.0-de.md)

Prepared release; publication pending. Acceptance build with original Library 0.6.0 and Updater V2.1. Use a disposable WordPress installation. Historical isolated tests do not establish browser, provider or image-editor acceptance.

1. Update from the previous test build; retain schemes, login media and favicon choices. Choose manual or a readable provider palette; check original swatches, atmosphere, brand strength, keyboard/hover preview and saved CSS.
2. Open the optional four-step setup, change login and tab-icon choices, navigate backward and exit to the full editor. The draft remains unsaved until Save all changes. Import/export drafts, supported agency images, undo and the unsaved-change guard must retain their behavior.
3. Site Health Info contains exactly eight fields, no plugin status tests, file checks or external requests.
4. Check login logo/banner/Site Icon fallbacks, gradients, quote, title, alignment and responsive layout. SVG login images require Safe SVG and explicit confirmation.
5. Default tab icons require bas_view_context_icons; guests and other roles retain Core icons. Grant/revoke per site and verify revocation persists. Public audience is an explicit choice. Check recognized builder contexts using actual installed licensed products.
6. Download SVG and 512x512 PNG. Store a PNG with Core image processing, then cancel/confirm the separate official Site Icon action. It never saves unrelated draft settings or deletes existing media.
7. Test site-only and network activation. Save different schemes, login and media on two sites with the same user. BAS Save/Undo, Core profile picker and profile submission affect only that site. Network profile picker/submission and its reloaded display use the global preference and retain other site choices. A signed context survives Core AJAX; an invalid context nonce is rejected. Forced site color must not hide the network picker. Undo rejects a different storage scope.
8. Create a new site: network-active BAS provisions the viewing capability after Core initialization; site-only BAS leaves it untouched. Balanced blog switching and revocation must hold.
9. Remove upload permission and exhaust/bound site quota: PNG and agency writes fail before attaching files. Check combined package quota and actual WordPress image encoding/metadata.
10. Select English, German informal and German formal user locales; inspect all editor/setup/error/footer texts and the Library. Open the structured local history by keyboard, scroll and close with Escape. Focus returns to its opener and the draft survives. Check mobile layout and text/category contrast.
11. Exercise mixed Library 0.3/0.4/0.5 hosts, one shared tab and highest-compatible election. Deactivation preserves everything; uninstall clears BAS temporary state across sites/networks while preserving branding, users, roles and media. Installed inactive hosts protect shared Library data. Test last-host cleanup separately.

The final shipped ZIP, update path, minimum platform, PHP logs and browser console must be checked. GitHub private reporting and current platform release rules require separate verification before a stable publication. BAS functions without Leitstand; concrete integration awaits its actual adapter.
