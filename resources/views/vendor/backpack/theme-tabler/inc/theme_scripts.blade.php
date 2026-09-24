{{-- tabler.min.js — раньше грузился через @basset, не смог скачаться с CDN. Отдаём локальную копию. --}}
<script src="{{ asset('vendor/tabler/tabler.min.js') }}"></script>

@basset(base_path('vendor/backpack/theme-tabler/resources/assets/js/tabler.js'))
