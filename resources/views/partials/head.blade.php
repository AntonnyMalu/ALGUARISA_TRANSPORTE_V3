<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<x-favicons/>

@push('service-worker')
    <x-service-worker/>
@endpush
@stack('service-worker')

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
