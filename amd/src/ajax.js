define([
    'core/yui',
    'filter_teamwork/popup',
    'filter_teamwork/loading',
    'core/ajax'

], function (Y, popup, loadingIcon, Ajax) {
    `use strict`;

    let ajax = {

        data: '',
        sesskey: M.cfg.sesskey,

        send: function () {

            var methodname = this.data.method;
            delete this.data.method;

            var promises = Ajax.call([{
                methodname: methodname,
                args: this.data
            }]);

            promises[0].done(function (response) {
            }).fail(function (ex) {
                popup.error();
            });
        },

        run: function (callback) {

            loadingIcon.show();

            var methodname = this.data.method;
            delete this.data.method;

            var promises = Ajax.call([{
                methodname: methodname,
                args: this.data
            }]);

            promises[0].done(function (response) {
                loadingIcon.remove();
                let result = JSON.parse(response.result);
                if (result.error) {
                    popup.textError = result.errormsg;
                    popup.error();
                    return;
                }
                if (callback) {
                    callback()
                }
            }).fail(function (ex) {
                popup.error();
            });
        },

        runPopup: function () {

            var methodname = this.data.method;
            delete this.data.method;

            var promises = Ajax.call([{
                methodname: methodname,
                args: this.data
            }]);

            promises[0].done(function (response) {
                let result = JSON.parse(response.result);
                popup.textHead = result.header;
                popup.text = result.content;
                popup.show();
            }).fail(function (ex) {
                popup.error();
            });
        },

    }

    return ajax

});
