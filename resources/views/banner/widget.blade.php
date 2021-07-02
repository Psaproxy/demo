@once
    <link rel="stylesheet" href="{{ asset('css/banner/widget.css') }}">

    @push('scripts')
        <script src="{{ asset('js/banner/widget.js') }}" defer></script>
    @endpush
@endonce

<section id="banner_widget"
         class="bg-blue-200 text-xs text-center sm:px-7 py-1"
         data-url="{{ route('banner.getStat') }}"
         data-updating-timer-sec="{{ config('core.banner.widget.updating_timer_sec') }}">
    <img src="{{ route('banner.get') }}?{{ microtime(true) }}" style="width:20px; display:inline-block" alt="" title="">
    <span id="banner_preloader">Загрузка...</span>
    <span id="banner_value_wrapper" class="hidden">
        Просмотров: <span id="banner_value">?</span>
    </span>
    <span id="banner_updated_at_wrapper" class="hidden">
        Обновление: <span id="banner_updated_at">?</span> (раз в {{ config('core.banner.widget.updating_timer_sec') }} сек.)
    </span>
</section>