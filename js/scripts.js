$(function () {
    var $html = $('html');

    /**
     * Проверяем наличие флеша
     */

    if (navigator.plugins['Shockwave Flash']) {
        $html.removeClass('no-shockwave-flash').addClass('shockwave-flash');
    }

    /**
     * Функция вывода уведомления
     */

    /** флаг факта открытия хотя бы одного уведомления */
    var hasNoty = false;

    $.fn.alert = function (pwd) {
        var text;

        pwd = $(this).text();

        if (typeof pwd === 'undefined') {
            text = 'Пароль скопирован';
        } else {
            text = 'Скопирован пароль ' + pwd;
        }

        // noinspection JSUnresolvedVariable
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
            hasNoty = true;
        }
        return this;
    };

    /**
     * Функция получения нового пароля
     */

    $.fn.getPwd = function () {
        var item = $(this);

        $.ajax({
            url: 'ajax-pwd-get.php',
            data: {
                length: item.data('length'),
                number: item.data('number'),
                mark: item.data('mark'),
                extra: item.data('extra')
            },
            dataType: 'json',
            /**
             * @param {string} data.pwd
             */
            success: function (data) {
                if (data.pwd) {
                    setTimeout(function () {
                        item.removeClass('copied');
                        item.siblings('.zclip').remove();
                        item.text(data.pwd);
                        item.unbind('zClip_copy zClip_beforeCopy zClip_afterCopy');
                        item.zClipRun();
                    }, 1700);
                } else {
                    alert('Error');
                }
            }
        });

        return this;
    };

    /**
     * zClip run
     */

    $.fn.zClipRun = function () {
        var $item = $(this);

        $item.zclip({
            path: 'js/vendor/jquery.zclip.1.1.1/ZeroClipboard.swf',
            copy: function () {
                return $item.text();
            },
            afterCopy: function () {
                $item
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
        !$html.hasClass('lt-ie9') &&
        navigator.plugins['Shockwave Flash']
    ) {
        var $pwds = $('.pwd');

        $pwds.each(function (index, item) {
            $(item).zClipRun();
        });
    }
});
