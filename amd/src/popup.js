define(['core/str'], function (str) {
    `use strict`;

    const mainBlock = document.querySelector(`body`);
    const popup = {

        textHead: ``,
        text: ``,

        show: function () {
            const popup = document.createElement(`div`);
            popup.innerHTML = `
            <div class = "teamwork-modal_header">
                <p class = "teamwork-modal_head">${this.textHead}</p>
                <span class = "teamwork-modal_close"></span>
            </div>
            <div class = "teamwork-modal_inner"></div>
        `;
            popup.classList.add(`teamwork-modal`);
            const popupInner = popup.querySelector(`.teamwork-modal_inner`);

            popupInner.innerHTML = this.text;
            this.remove();
            mainBlock.appendChild(popup);
        },

        error: function () {
            let self = this;
            str.get_strings([
                {key: 'close', component: 'filter_teamwork'},
                {key: 'error_message', component: 'filter_teamwork'}
            ]).done(function (s) {
              if (mainBlock.querySelector(`.teamwork-modal`)) {
                  const errorBlock = document.createElement(`div`);
                  errorBlock.classList.add(`teamwork-modal-error-abs`, `alert`, `alert-warning`);
                  errorBlock.innerHTML = `
                    <span>${s[1]}</span>
                    <button class = "btn btn-error close_popup">${s[0]}</button>
                  `;
                  mainBlock.querySelector(`.teamwork-modal`).appendChild(errorBlock);
              } else {
                  const popup = document.createElement(`div`);
                  popup.innerHTML = `
                    <span>${s[1]}</span>
                    <button class = "btn btn-error close_popup">${s[0]}</button>
                  `;
                  popup.classList.add('teamwork-modal', 'teamwork-modal-error');

                  self.remove();
                  mainBlock.appendChild(popup);
              }
            });
        },

        remove: function () {
            if (mainBlock.querySelector('.teamwork-modal')) {
                mainBlock.querySelector('.teamwork-modal').remove();
            }
        },

    };

    return popup

});
