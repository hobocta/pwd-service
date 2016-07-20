(function($) {
	$(document).ready(function() {

		/**
		 * Проверяем наличие флеша
		 */

		if (navigator.plugins['Shockwave Flash']) {
			$('html').removeClass('no-shockwave-flash').addClass('shockwave-flash');
		}

		/**
		 * Определяем браузер
		 */

		var browser;
		if ($.browser.webkit || $.browser.safari) {
			browser = 'webkit';
		} else if ($.browser.opera) {
			browser = 'opera';
		} else if ($.browser.msie) {
			browser = 'ie';
		} else if ($.browser.mozilla) {
			browser = 'mozilla';
		}

		/**
		 * Функция вывода уведомления
		 */

		// флаг факта открытия хотя бы одного уведомления
		var has_noty = false;

		$.fn.alert = function(pwd) {
			pwd = $(this).text();
			if (typeof pwd == 'undefined') {
				text = 'Пароль скопирован';
			} else {
				text = 'Скопирован пароль ' + pwd;
			}
			if (!$.browser.mozilla) {
				noty({
					layout: 'topCenter',
					type: 'success',
					text: text,
					timeout: 1500,
					maxVisible: 3,
					animation: {
						open: {height: 'toggle'},
						close: {height: 'toggle'},
						easing: 'swing',
						speed: 100
					}
				});
				has_noty = true;
			}
			return this;
		};

		/**
		 * Функция получения нового пароля
		 */

		$.fn.getPwd = function() {
			var e = this;
			$.ajax({
				url: 'generate.php',
				data: {
					length: $(e).data('length'),
					number: $(e).data('number'),
					mark: $(e).data('mark'),
					extra: $(e).data('extra')
				},
				success: function(data) {
					setTimeout(function() {
						$(e).removeClass('copied');
						$(e).siblings('.zclip').remove();
						$(e).text(data);
						$(e).unbind('zClip_copy zClip_beforeCopy zClip_afterCopy');
						$(e).zClipRun();
					}, 1700);
				}
			});
			return this;
		};

		/**
		 * zClip run
		 */

		$.fn.zClipRun = function() {
			var e = this;
			$(e).zclip({
				path: 'js/vendor/jquery.zclip.1.1.1/ZeroClipboard.swf',
				copy: function() {
					return $(e).text();
				},
				afterCopy: function() {
					$(e)
						.addClass('copied')
						.alert()
						.getPwd();
				}
			});
		};

		/**
		 * Если это не старые IE и включен флеш, то вешаем обработку копирования в буфер
		 * и уведомление об этом
		 */
		if (
			!$('html').hasClass('lt-ie9') &&
			navigator.plugins['Shockwave Flash']
		) {
			var pwds = $('.pwd');
			pwds.each(function(i, e) {
				$(e).zClipRun();
			});
		}

	});
})(jQuery);
