/** Reapply a validated contextual favicon after a builder updates its document head. */
(() => {
 'use strict';
 const icon = window.BAS_CONTEXT_ICON;
 if (typeof icon !== 'string' || !icon.startsWith('data:image/svg+xml,')) return;
 /** @returns {void} Restore only the BAS-owned favicon link. */
 function apply() {
  let link = document.getElementById('bas-context-icon');
  if (!link) { link = document.createElement('link'); link.id = 'bas-context-icon'; link.rel = 'icon'; link.type = 'image/svg+xml'; document.head.appendChild(link); }
  link.href = icon;
 }
 if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', apply, {once: true}); else apply();
 if (document.readyState !== 'complete') window.addEventListener('load', apply, {once: true});
 window.setTimeout(apply, 1200);
})();
