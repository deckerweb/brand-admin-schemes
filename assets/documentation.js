/** Accessible local documentation with native dialog fallbacks and retained link targets. */
(() => {
 'use strict';
 if (window.BAS_DOCUMENT_CONTROLLER) return;
 window.BAS_DOCUMENT_CONTROLLER = true;
 // Keep notices visible outside the branding header, including late third-party insertions.
 const heading = document.querySelector('.bas-root > .bas-page-heading');
 const noticeAnchor = heading?.parentElement.querySelector(':scope > .wp-header-end');
 if (heading && noticeAnchor) {
  /** Move complete notice nodes without changing their content or event listeners. @returns {void} */
  const placeNotices = () => {
   let cursor = noticeAnchor;
   heading.querySelectorAll('.notice, .updated, .error').forEach(notice => {
    if (notice.parentElement?.closest('.notice, .updated, .error')) return;
    cursor.after(notice);
    cursor = notice;
   });
  };
  placeNotices();
  new MutationObserver(placeNotices).observe(heading, { childList: true, subtree: true });
 }
 const native = window.HTMLDialogElement?.prototype;
 let opener;
 /** @param {HTMLDialogElement} dialog Active dialog. @returns {void} Close via the native implementation. */
 function close(dialog) { if (dialog.open && native?.close) native.close.call(dialog); }
 document.addEventListener('click', event => {
  const button = event.target.closest?.('[data-bas-document]');
  if (!button) return;
  const dialog = document.getElementById('bas-document-' + button.dataset.basDocument);
  if (!dialog || !native?.showModal) return;
  try {
   dialog.hidden = false;
   if (!dialog.open) native.showModal.call(dialog);
   opener = button;
   const content = dialog.querySelector('.bas-document-content');
   if (content) content.scrollTop = 0;
   event.preventDefault();
  } catch (_) { dialog.hidden = !dialog.open; /* Keep the real documentation link available. */ }
 }, true);
 document.querySelectorAll('.bas-document-dialog').forEach(dialog => {
  dialog.querySelector('[data-bas-close]')?.addEventListener('click', event => { event.preventDefault(); close(dialog); });
  dialog.addEventListener('click', event => {
   const bounds = dialog.getBoundingClientRect();
   if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) close(dialog);
  });
  dialog.addEventListener('close', () => { dialog.hidden = true; opener?.focus(); });
 });
})();
