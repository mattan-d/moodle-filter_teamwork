define(['core/str'], function (str) {
    `use strict`;

    const mainBlock = document.querySelector(`body`);
    const style = document.createElement(`style`);

    const skin = {

        content: ``,
        shadow: 'skin_hide',

        show: function () {

            const popup = document.createElement(`div`);
            popup.classList.add(`skin`, `shadow`);
            popup.innerHTML = `
          <div class = "skin_close"></div>
          <div class = "skin_inner"></div>
          <div class = "skin_shadow ${this.shadow}"></div>`;
            const popupInner = popup.querySelector(`.skin_inner`);
            popupInner.innerHTML = this.content;
            this.remove();
            mainBlock.appendChild(style);
            mainBlock.appendChild(popup);
        },

        remove: function () {
            if (mainBlock.querySelector(`.skin`)) {
                mainBlock.querySelector(`.skin`).remove();
            }
        }

    };

    return skin

});
