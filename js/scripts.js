/**
 * @var {object} Clipboard
 * @var {boolean} Clipboard.isSupported
 */
$(function () {
    var $html = $('html');

    // noinspection JSValidateTypes
    if (!Clipboard.isSupported()) {
        $html.addClass('no-clipboard');
    }

    // noinspection JSUnresolvedFunction
    var clipboard = new Clipboard('.js-clipboard', {
        text: function (trigger) {
            var $trigger = $(trigger);

            return $trigger.text();
        }
    });

    clipboard.on('success', function (event) {
        var $item = $(event.trigger);

        $item
            .addClass('copied')
            .alert(event.text)
            .getPwd();
    });

    /**
     * Выводит уведомление
     *
     * @param copiedText
     * @returns {$}
     */
    $.fn.alert = function (copiedText) {
        var text;

        if (typeof copiedText === 'undefined') {
            text = 'Пароль скопирован';
        } else {
            text = 'Скопирован пароль ' + copiedText;
        }

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

        return this;
    };

    /**
     * Получает новый пароль
     *
     * @returns {$}
     */
    $.fn.getPwd = function () {
        var $item = $(this);

        $.ajax({
            url: 'ajax/get-pwd.php',
            data: {
                length: $item.data('length'),
                number: $item.data('number'),
                mark: $item.data('mark'),
                extra: $item.data('extra')
            },
            dataType: 'json',
            /**
             * @param {boolean} data.error
             * @param {string} data.pwd
             */
            success: function (data) {
                if (!data.error && data.pwd) {
                    setTimeout(function () {
                        $item.removeClass('copied');
                        $item.text(data.pwd);
                    }, 1700);
                } else {
                    alert('Error');
                }
            }
        });

        return this;
    };
});
