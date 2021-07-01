require('../bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    let widgetEl = document.getElementById('banner_widget');
    const statUrl = widgetEl.getAttribute('data-url');
    const updatingTimerSec = widgetEl.getAttribute('data-updating-timer-sec');
    let preloaderEl = document.getElementById('banner_preloader');
    let valueEl = document.getElementById('banner_value');
    let valueWrapperEl = document.getElementById('banner_value_wrapper');
    let updatedAtEl = document.getElementById('banner_updated_at');
    let updatedAtWrapperEl = document.getElementById('banner_updated_at_wrapper');

    const updateStat = () => {
        axios
            .get(statUrl)
            .then((response) => {
                valueEl.innerHTML = response.data.value;
                if ('1' !== valueWrapperEl.getAttribute('data-show')) {
                    valueWrapperEl.setAttribute('data-show', '1');
                }

                // noinspection JSUnresolvedVariable
                const updatedAt = response.data.update_at;
                if ('' !== updatedAt) {
                    updatedAtEl.innerHTML = updatedAt;
                    if ('1' !== updatedAtWrapperEl.getAttribute('data-show')) {
                        updatedAtWrapperEl.setAttribute('data-show', '1');
                    }
                }

                if (undefined !== preloaderEl) {
                    preloaderEl.remove();
                    preloaderEl = undefined;
                }
            });
    }

    updateStat();

    setInterval(updateStat, 1000 * updatingTimerSec);
});