define([
    'jquery',
    'core/str'
], function ($, str) {
    `use strict`;

    const loadingIcon = {

        icon: {
          spinner: 'loading',
          component: 'filter_teamwork'
        },

        show: function () {
            let oldIcon = document.querySelector('.raspberry_loading');
            if (oldIcon) {
                oldIcon.remove();
            }

            const body = document.querySelector(`body`);
            let image = document.createElement('img');
            let src = M.util.image_url(this.icon.spinner, this.icon.component);
            const raspberry_loading = document.createElement(`div`);

            raspberry_loading.classList.add(`raspberry_loading`);

            raspberry_loading.innerHTML = `<img src = ${src}>`;
            str.get_string('please_wait', this.icon.component).done(function(s){
              raspberry_loading.innerHTML += s;
            });

            body.appendChild(raspberry_loading);
        },
        remove: function () {
            if (document.querySelector(`.raspberry_loading`)) {
                $('.raspberry_loading').fadeOut('slow');
                setTimeout(function (e) {
                    document.querySelector('.raspberry_loading').remove();
                }, 1000);
            }
        }
    }

    return loadingIcon;
});
