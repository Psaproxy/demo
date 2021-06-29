require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    let preloaderEl = document.getElementById('banner_preloader');
    let statEl = document.getElementById('banner_stat');
    let statUrl = statEl.getAttribute('data-url');
    let valueEl = document.getElementById('banner_value');
    let updateAtEl = document.getElementById('banner_update_at');
    let isHidden = true;

    const updateStat = () => {
        axios
            .get(statUrl)
            .then((response) => {
                valueEl.innerHTML = response.data.value;
                // noinspection JSUnresolvedVariable
                updateAtEl.innerHTML = response.data.update_at;
                if (true === isHidden) {
                    statEl.setAttribute('style', 'display: inline-block !important');
                    preloaderEl.remove();
                    isHidden = false;
                }
            });
    }

    updateStat();

    setTimeout(updateStat, 26 * 1000);
});