;(function($) {
	$(document).ready(function() {

		/**
		 * Проверяем наличие флеша
		 */

		if ( navigator.plugins["Shockwave Flash"] ) {
			$('html').removeClass('no-shockwave-flash').addClass('shockwave-flash');
		}


		/**
		 * Определяем браузер
		 */

		var browser;
		if ( $.browser.webkit || $.browser.safari ) {
			browser = "webkit";
		} else if ( $.browser.opera ) {
			browser = "opera";
		} else if ( $.browser.msie ) {
			browser = "ie";
		} else if ( $.browser.mozilla ) {
			browser = "mozilla";
		}


		/**
		 * Функция показывает noty
		 */

		// флаг факта открытия хотя бы одного уведомления
		var has_noty = false;

		$.fn.alert = function( pwd ) {
			if ( typeof pwd == "undefined" ) {
				text = 'Пароль скопирован';
			} else {
				text = 'Скопирован пароль ' + pwd;
			}
			if ( !$.browser.mozilla ) {
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
		};


		/**
		 * Если это не старые IE и включен флеш, то вешаем обработку копирования в буфер
		 * и уведомление об этом
		 */
		if ( !$('html').hasClass('lt-ie9') && navigator.plugins["Shockwave Flash"] ) {

			var pwds = $('.pwd');
			pwds.each(function(i, e) {

				var pwd = $(e).text();
				$(e).zclip({
					path: 'js/vendor/jquery.zclip.1.1.1/ZeroClipboard.swf',
					copy: function() {
						return pwd;
					},
					beforeCopy: function() {
						pwds.removeClass('copied');
					},
					afterCopy: function() {

						$(this).addClass('copied');

						$.fn.alert( pwd );

					}
				});

			});

		}


		/**
		 * Обновляем страницу по клику на кнопку
		 */

		$('.refresh').eq(0).on('click', function(event) {

			event.preventDefault();

			// Скрываем уведомления, если они были
			if ( has_noty ) {
				$.noty.closeAll();
			}

			$(this).addClass('loader');

			setTimeout(function() {
				location.reload();
			}, 115);

		});

	});
})(jQuery);
