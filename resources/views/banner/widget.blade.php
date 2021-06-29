@once
    @push('scripts')
        <script src="{{ asset('js/bannerWidget.js') }}" defer></script>
    @endpush
@endonce

<section id="banner_widget" class="bg-blue-200 text-xs text-center sm:px-7 py-1">
    <img src="{{ route('banner.get') }}" style="width:20px; display:inline-block" alt="" title="">
    <span id="banner_preloader">Загрузка...</span>
    <span id="banner_stat" class="hidden" data-url="{{ route('banner.getStat') }}">
        Просмотров: <span id="banner_value">?</span>
        Обновление: <span id="banner_update_at">?</span> (раз в 26 сек.)
    </span>
</section>