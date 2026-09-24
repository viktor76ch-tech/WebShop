{{--
    we use a render blocking script in <head> to force the theme attribute to be in the document before it renders
    avoiding white flicks when for example, using the dark color mode.
--}}
<script>document.documentElement.setAttribute("data-bs-theme", localStorage.colorMode ?? 'light');</script>

{{-- tabler.min.css — раньше грузился через @basset, не смог скачаться с CDN. Отдаём локальную копию. --}}
<link href="{{ asset('vendor/tabler/tabler.min.css') }}" rel="stylesheet" type="text/css" />

@basset(base_path('vendor/backpack/theme-tabler/resources/assets/css/style.css'))
@basset(base_path('vendor/backpack/theme-tabler/resources/assets/css/color-adjustments.css'))
