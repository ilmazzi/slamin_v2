/**
 * Events Map - Leaflet Integration
 * Handles map initialization, markers, and style changes for events
 */

let map = null;
let markers = [];

// Wait for Livewire to be ready
document.addEventListener('livewire:init', () => {
    console.log('✅ Livewire initialized, setting up map...');
    
    Livewire.on('map-ready', (data) => {
        console.log('🗺️ Map ready event received:', data);
        initMap(data);
    });
    
    // Also try to init immediately if data is available
    if (window.mapData) {
        initMap(window.mapData);
    }
});

/**
 * Initialize the map with events data
 * @param {Object} data - Events data with latitude/longitude
 */
function initMap(data) {
    if (!data || !data.events || data.events.length === 0) {
        console.log('⚠️ No events data available for map');
        return;
    }
    
    console.log('🗺️ Initializing map with', data.events.length, 'events');
    
    // Destroy existing map if any
    if (map) {
        map.remove();
        markers = [];
    }
    
    // Create map centered on first event or default location
    const firstEvent = data.events[0];
    const centerLat = firstEvent?.latitude || 41.9028;
    const centerLng = firstEvent?.longitude || 12.4964;
    
    map = L.map('events-map').setView([centerLat, centerLng], 6);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add markers for each event
    data.events.forEach(event => {
        if (event.latitude && event.longitude) {
            const marker = L.marker([event.latitude, event.longitude])
                .addTo(map)
                .bindPopup(`
                    <div class="custom-popup">
                        <a href="${event.url}" class="block p-4 bg-gradient-to-br from-primary-600 to-primary-700 text-white rounded-2xl hover:from-primary-700 hover:to-primary-800 transition-all">
                            <h3 class="font-bold text-lg mb-2">${event.title}</h3>
                            <p class="text-sm opacity-90 mb-3">${event.city || ''}</p>
                            <div class="flex items-center gap-2 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>${event.date || ''}</span>
                            </div>
                        </a>
                    </div>
                `);
            
            markers.push(marker);
        }
    });
    
    // Fit map to show all markers
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
    
    console.log('✅ Map initialized with', markers.length, 'markers');
}

/**
 * Handle map style changes (standard, satellite, terrain)
 * @param {string} style - Map style type
 */
window.changeMapStyle = function(style) {
    if (!map) return;
    
    // Remove existing tile layer
    map.eachLayer((layer) => {
        if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
        }
    });
    
    let tileUrl, attribution;
    
    switch(style) {
        case 'satellite':
            tileUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
            attribution = '© Esri';
            break;
        case 'terrain':
            tileUrl = 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png';
            attribution = '© OpenTopoMap';
            break;
        default: // standard
            tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            attribution = '© OpenStreetMap contributors';
    }
    
    L.tileLayer(tileUrl, {
        attribution: attribution,
        maxZoom: 19
    }).addTo(map);
    
    // Update active button
    document.querySelectorAll('.map-style-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.map-style-btn')?.classList.add('active');
}

