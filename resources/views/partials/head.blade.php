<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

{{-- Favicon y PWA --}}
<link rel="manifest" href="{{ url('/manifest.json') }}">
@php
    $assetFavicons = config('app.manifest_asset_favicons');
    $favicon = asset('favicons/favicon-128x128.png');
    if (! empty($assetFavicons)) {
        if (File::exists('favicons/'.$assetFavicons.'/favicon-128x128.png')) {
            $favicon = asset('favicons/'.$assetFavicons.'/favicon-128x128.png');
        }
    }
@endphp
<link rel="apple-touch-icon" href="{{ $favicon}}">
<link rel="icon" href="{{ $favicon }}" sizes="any">
<link rel="icon" href="{{ $favicon }}" type="image/svg+xml">

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register("{{ url('service-worker.js') }}")
                .then(reg => console.log('✅ Service Worker registrado en:', reg.scope))
                .catch(err => console.error('⚠️ Error al registrar el Service Worker:', err));
        });
    }
</script>

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
