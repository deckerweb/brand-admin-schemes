/** Preserve Core's global color preference when the picker is in network admin. */
(($) => {
	'use strict';
	$.ajaxPrefilter((options, originalOptions) => {
		const data = originalOptions.data;
		if (!data || typeof data !== 'object' || data.action !== 'save-user-color-scheme' || !window.BAS_PROFILE_SCOPE) return;
		options.data += '&' + $.param({
			bas_color_scope: 'network',
			bas_color_scope_nonce: window.BAS_PROFILE_SCOPE.nonce
		});
	});
})(jQuery);
