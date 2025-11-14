@once
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@vite(['resources/css/events-map.css', 'resources/css/events-index.css'])
@endpush
@endonce

@once
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@vite(['resources/js/events-map.js'])
@endpush
@endonce

