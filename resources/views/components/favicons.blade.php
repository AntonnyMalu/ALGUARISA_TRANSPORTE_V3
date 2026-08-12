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
