/** Local documentation dialogs preserve the current editor draft. */
(() => {
	'use strict';
	let opener;
	document.querySelectorAll('[data-bas-document]').forEach(button => {
		button.addEventListener('click', event => {
			const dialog = document.getElementById('bas-document-' + button.dataset.basDocument);
			if (!dialog || typeof dialog.showModal !== 'function') return;
			event.preventDefault();
			opener = button;
			dialog.showModal();
			dialog.querySelector('pre').scrollTop = 0;
		});
	});
	document.querySelectorAll('.bas-document-dialog').forEach(dialog => {
		dialog.querySelector('[data-bas-close]').addEventListener('click', () => dialog.close());
		dialog.addEventListener('click', event => {
			const bounds = dialog.getBoundingClientRect();
			if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) dialog.close();
		});
		dialog.addEventListener('close', () => opener?.focus());
	});
})();
