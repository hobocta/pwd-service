import 'noty/lib/noty.css';
import 'noty/lib/themes/relax.css';
import '../css/main.css';
import '../css/noty.css';

import $ from 'jquery';
import Noty from 'noty/lib/noty.js';
import ClipboardJS from 'clipboard/dist/clipboard.js';

$(function () {
    let clipboard = new ClipboardJS('.js-clipboard', {
        text: function (trigger) {
            let $trigger = $(trigger);

            return $trigger.text();
        }
    });

    // noinspection JSUnresolvedFunction
    clipboard.on('success', function (event) {
        let $item = $(event.trigger);

        $item
            .addClass('copied')
            .alert(event.text)
            .getPwd();
    });

    // noinspection JSUnresolvedFunction
    clipboard.on('error', function (event) {
        console.error(event);
    });

    /**
     * Выводит уведомление
     *
     * @param copiedText
     * @returns {$}
     */
    $.fn.alert = function (copiedText) {
        let text;

        if (typeof copiedText === 'undefined') {
            text = 'Пароль скопирован';
        } else {
            text = 'Скопирован пароль <span class="nowrap">' + copiedText + '</span>';
        }

        // noinspection JSUnresolvedFunction
        new Noty({
            text: text,
            layout: 'topCenter',
            theme: 'relax',
            type: 'success',
            timeout: 250,
            progressBar: false
        }).show();

        return this;
    };

    /**
     * Получает новый пароль
     *
     * @returns {$}
     */
    $.fn.getPwd = function () {
        let $item = $(this);

        // noinspection JSUnusedGlobalSymbols
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
                    }, 500);
                } else {
                    alert('Error');
                }
            }
        });

        return this;
    };
});
