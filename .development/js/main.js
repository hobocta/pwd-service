import Noty from 'noty/lib/noty.js';
import ClipboardJS from 'clipboard/dist/clipboard.js';
import nocache from 'superagent-no-cache';
import request from 'superagent';

!function () {
    let clipboard = new ClipboardJS('.js-clipboard', {
        text: function (trigger) {
            return trigger.innerText;
        }
    });

    // noinspection JSUnresolvedFunction
    clipboard.on('success', function (event) {
        let item = event.trigger;

        item.className += ' copied';

        showNoty(event.text);

        loadPwd(item);
    });

    // noinspection JSUnresolvedFunction
    clipboard.on('error', function (event) {
        console.error(event);
    });

    function showNoty(pwd) {
        let text = 'Copied: <span class="nowrap">' + pwd + '</span>';

        // noinspection JSUnresolvedFunction
        new Noty({
            text: text,
            layout: 'topCenter',
            theme: 'relax',
            type: 'success',
            timeout: 1000,
            progressBar: false
        }).show();
    }

    function loadPwd(item) {
        let data = {
            length: item.dataset.length,
            number: item.dataset.number,
            mark: item.dataset.mark,
            extra: item.dataset.extra
        };

        request
            .get('/ajax/get-pwd.php')
            .query(data)
            .use(nocache)
            .set('accept', 'json')
            .end((error, result) => {
                if (error) {
                    console.error('error', error);
                } else {
                    if (result.body.error) {
                        console.error('error', result.body.message);
                    } else {
                        setTimeout(function () {
                            // noinspection JSUnresolvedVariable
                            item.innerText = result.body.pwd;
                            item.classList.remove('copied');
                        }, 1000);
                    }
                }
            });
    }
}();
