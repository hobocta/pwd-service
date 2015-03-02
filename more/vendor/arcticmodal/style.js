;(function($) {
	$(document).ready(function() {

		/**
		 * Подключаем css
		 */
		$('<link>', {
			'type': 'text/css',
			'rel': 'stylesheet',
			'href': 'more/vendor/arcticmodal/jquery.arcticmodal-custom.css'
		}).appendTo($('head'));
		$('<link>', {
			'type': 'text/css',
			'rel': 'stylesheet',
			'href': 'more/vendor/arcticmodal/themes/dark-custom.css'
		}).appendTo($('head'));

	});
})(jQuery);
