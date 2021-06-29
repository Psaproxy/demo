require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    let userIdEl = document.head.querySelector('meta[name="user-id"]');
    if (null === userIdEl) {
        throw new Error('User ID not found.');
    }
    let userId = userIdEl.content;

    let channel = Echo.private('banner.' + userId);

    channel.listen('NumberOfBannerViewsWasUpdated', (data) => {
        console.log('NumberOfBannerViewsWasUpdated', data);
    });

    channel.subscribed(() => {
        // Laravel WebSocket не поддерживает получение сервером клиентских сообщейни.
        // noinspection JSUnresolvedFunction
        setTimeout(
            () => {
                channel.whisper('BannerWasViewed');
            },
            1000
        );
    });
});