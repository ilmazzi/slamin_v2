/**
 * Events Map - Leaflet Integration
 * Handles map initialization, markers, and style changes for events
 */

let map = null;
let markers = [];
let currentTileLayer = null;
let currentStyle = 'voyager';

// Category colors matching legend
const categoryColors = {
    'poetry_slam': '#EF4444',
    'workshop': '#F59E0B',
    'open_mic': '#10B981',
    'reading': '#3B82F6',
    'festival': '#8B5CF6',
    'concert': '#EC4899',
    'book_presentation': '#6B7280'
};

// Tile layers configuration
const tileLayers = {
    standard: {
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    },
    satellite: {
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        attribution: '© Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN',
        maxZoom: 19
    },
    dark: {
        url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
        attribution: '© OpenStreetMap, © CartoDB',
        maxZoom: 19
    },
    voyager: {
        url: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
        attribution: '© OpenStreetMap, © CartoDB',
        maxZoom: 19
    },
    positron: {
        url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        attribution: '© OpenStreetMap, © CartoDB',
        maxZoom: 19
    },
    topo: {
        url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
        attribution: '© OpenStreetMap, © OpenTopoMap',
        maxZoom: 17
    }
};

// Wait for Livewire to be ready
document.addEventListener('livewire:navigated', function() {
    console.log('livewire:navigated event fired');
    initMap();
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded event fired');
    // Give Livewire time to render
    setTimeout(function() {
        console.log('Calling initMap after 1000ms timeout');
        initMap();
    }, 1000);
});

// Use MutationObserver to watch for data-events changes
const observeMapData = () => {
    const dataElement = document.getElementById('mapEventsData');
    if (!dataElement) {
        console.warn('Map data element not found, retrying...');
        setTimeout(observeMapData, 500);
        return;
    }
    
    console.log('👀 Setting up MutationObserver for map data changes...');
    
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-events') {
                console.log('🔄 data-events attribute changed! Updating markers...');
                updateMapMarkers();
            }
        });
    });
    
    observer.observe(dataElement, {
        attributes: true,
        attributeFilter: ['data-events']
    });
    
    console.log('✅ MutationObserver active');
};

// Start observing after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(observeMapData, 1500);
});

/**
 * Initialize the map
 */
function initMap() {
    // Check if Leaflet is loaded
    if (typeof L === 'undefined') {
        console.error('Leaflet library not loaded yet, retrying in 500ms...');
        setTimeout(initMap, 500);
        return;
    }
    
    // Check if map already initialized
    if (map !== null) {
        console.log('Map already initialized, skipping');
        return;
    }
    
    // Check if element exists
    const mapElement = document.getElementById('eventsMap');
    if (!mapElement) {
        console.error('Map element not found! Retrying in 500ms...');
        setTimeout(initMap, 500);
        return;
    }
    
    console.log('🗺️ Initializing Leaflet map...');
    console.log('Map element found:', mapElement);
    
    try {
        // Initialize map centered on Italy (zoom 5 for wider view)
        map = L.map('eventsMap').setView([41.9028, 12.4964], 5);
        
        console.log('✅ Map object created successfully');
    
        // Create tile layer instances
        const tileLayerInstances = {};
        Object.keys(tileLayers).forEach(key => {
            const config = tileLayers[key];
            tileLayerInstances[key] = L.tileLayer(config.url, {
                attribution: config.attribution,
                maxZoom: config.maxZoom
            });
        });

        // Add default tile layer
        currentTileLayer = tileLayerInstances.voyager.addTo(map);
        currentStyle = 'voyager';
        
        console.log('Tiles added to map');
        
        // Add events to map
        const dataElement = document.getElementById('mapEventsData');
        if (!dataElement) {
            console.warn('Map data element not found');
            return;
        }
        
        const eventsData = dataElement.getAttribute('data-events');
        if (!eventsData) {
            console.warn('No events data found');
            return;
        }
        
        let events;
        try {
            events = JSON.parse(eventsData);
        } catch (e) {
            console.error('Error parsing events data:', e);
            return;
        }
        
        const totalEvents = parseInt(dataElement.getAttribute('data-total-count') || '0');
        
        console.log('📊 Map data received:', events);
        console.log('📍 Loading', events.length, 'events on map (out of', totalEvents, 'total)');
        
        if (events.length === 0) {
            console.warn('⚠️ No events with coordinates found!');
        } else if (events.length < totalEvents) {
            console.warn(`⚠️ Only ${events.length} out of ${totalEvents} events have coordinates!`);
        }
        
        // Add markers
        events.forEach((event, index) => {
            if (event.latitude && event.longitude) {
                addMarkerToMap(event, index, events.length);
            }
        });
        
        // Fit bounds to show all markers
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
            console.log('Map bounds fitted to', markers.length, 'markers');
        } else {
            console.warn('No markers to display on map');
        }
        
        // Force map to recalculate size
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
        
    } catch (error) {
        console.error('Error initializing map:', error);
    }
}

/**
 * Add a marker to the map
 */
function addMarkerToMap(event, index, total) {
    const color = categoryColors[event.category] || '#6B7280';
    
    // Custom marker icon
    const markerIcon = L.divIcon({
        className: 'custom-marker',
        html: `
            <div class="relative group">
                <div class="w-8 h-8 rounded-full border-3 border-white shadow-lg transition-all hover:scale-125"
                     style="background-color: ${color};">
                </div>
                <div class="absolute inset-0 rounded-full animate-ping" 
                     style="background-color: ${color}; opacity: 0.3;"></div>
            </div>
        `,
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });
    
    const marker = L.marker([event.latitude, event.longitude], {
        icon: markerIcon
    }).addTo(map);
    
    console.log(`Added marker ${index + 1}/${total}:`, event.title, `at [${event.latitude}, ${event.longitude}]`);
    
    // Create popup content
    const popupContent = createPopupContent(event);
    
    marker.bindPopup(popupContent, {
        maxWidth: event.ticket_html ? 220 : 320,
        minWidth: 0,
        className: 'custom-popup',
        autoPan: true,
        autoPanPadding: [50, 50]
    });
    
    // Force popup to resize after opening
    if (event.ticket_html) {
        marker.on('popupopen', function() {
            setTimeout(() => {
                const popup = marker.getPopup();
                if (popup) {
                    const content = popup.getContent();
                    const wrapper = popup.getElement();
                    if (wrapper) {
                        const contentWrapper = wrapper.querySelector('.leaflet-popup-content-wrapper');
                        const contentDiv = wrapper.querySelector('.leaflet-popup-content');
                        if (contentWrapper && contentDiv) {
                            // Get actual scaled dimensions
                            const scaledWidth = contentDiv.scrollWidth;
                            const scaledHeight = contentDiv.scrollHeight;
                            contentWrapper.style.width = scaledWidth + 'px';
                            contentWrapper.style.height = scaledHeight + 'px';
                            contentDiv.style.width = scaledWidth + 'px';
                            contentDiv.style.height = scaledHeight + 'px';
                            popup.update();
                        }
                    }
                }
            }, 10);
        });
    }
    
    markers.push(marker);
}

/**
 * Create popup content HTML for an event
 * Uses the ticket component HTML rendered server-side
 */
function createPopupContent(event) {
    // Use ticket HTML if available, otherwise fallback to simple popup
    if (event.ticket_html) {
        // Wrap ticket in container for popup
        return `<div class="map-popup-ticket-wrapper">${event.ticket_html}</div>`;
    }
    
    // Fallback (should not happen, but just in case)
    const viewDetailsText = document.querySelector('[data-view-details-text]')?.getAttribute('data-view-details-text') || 'Vedi dettagli';
    
    return `
        <div class="relative overflow-hidden" style="width: 320px;">
            ${event.image_url ? `
                <!-- Image Header with Gradient Overlay -->
                <div class="relative h-40 overflow-hidden">
                    <img src="${event.image_url}" 
                         class="w-full h-full object-cover" 
                         alt="${event.title}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    
                    <!-- Category Badge on Image -->
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-primary-700 text-xs font-bold uppercase rounded-full shadow-lg">
                            ${event.category ? event.category.replace('_', ' ') : 'Event'}
                        </span>
                    </div>
                    
                    <!-- Title on Image -->
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-xl font-bold text-white leading-tight">${event.title}</h3>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4 bg-white">
            ` : `
                <!-- No Image - Gradient Header -->
                <div class="relative p-6 bg-gradient-to-br from-primary-500 to-accent-600">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold uppercase rounded-full border border-white/30">
                            ${event.category ? event.category.replace('_', ' ') : 'Event'}
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-white pr-20">${event.title}</h3>
                </div>
                
                <!-- Content -->
                <div class="p-4 bg-white">
            `}
            
            <!-- Info Section -->
            <div class="space-y-2.5 mb-4">
                <div class="flex items-center gap-3 text-neutral-700">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Data</div>
                        <div class="text-sm font-semibold text-neutral-900">${event.start_datetime || ''}</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 text-neutral-700">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Luogo</div>
                        <div class="text-sm font-semibold text-neutral-900">${event.venue_name || ''}</div>
                        <div class="text-xs text-neutral-500">${event.city || ''}</div>
                    </div>
                </div>
            </div>
            
            <!-- CTA Button -->
            <a href="${event.url || '#'}" 
               class="block w-full text-center px-6 py-3 bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105"
               style="color: white !important; text-decoration: none !important;">
                ${viewDetailsText}
                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    `;
}

/**
 * Update map markers after filter changes
 */
function updateMapMarkers() {
    if (!map) {
        console.warn('Map not initialized yet, cannot update markers');
        return;
    }
    
    console.log('🗺️ Updating map markers after filter change...');
    
    // Get updated events data from data container
    const dataElement = document.getElementById('mapEventsData');
    if (!dataElement) {
        console.error('❌ Map data element not found!');
        return;
    }
    
    const eventsData = dataElement.getAttribute('data-events');
    if (!eventsData) {
        console.error('❌ No events data found in data element!');
        return;
    }
    
    console.log('📦 Raw data from attribute:', eventsData.substring(0, 100) + '...');
    
    let events;
    try {
        events = JSON.parse(eventsData);
    } catch (e) {
        console.error('❌ Error parsing events data:', e);
        return;
    }
    
    console.log('📍 Parsed events:', events);
    console.log('📍 Updating map with', events.length, 'events (filtered)');
    
    // Remove existing markers
    console.log('🗑️ Removing', markers.length, 'old markers...');
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    console.log('✅ Old markers removed');
    
    // Add new markers
    events.forEach((event, index) => {
        if (event.latitude && event.longitude) {
            addMarkerToMap(event, index, events.length);
        }
    });
    
    console.log('🎯 Total markers added:', markers.length);
    
    // Fit bounds to show all markers
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
        console.log('✅ Map updated successfully with', markers.length, 'markers');
        console.log('📌 Map re-centered to show all filtered events');
    } else {
        console.warn('⚠️ No markers after update - map will be empty');
        // Reset to default view if no markers
        map.setView([41.9028, 12.4964], 5);
    }
}

/**
 * Handle map style changes (standard, satellite, dark, voyager, positron, topo)
 * @param {string} style - Map style type
 */
window.changeMapStyle = function(style) {
    if (!map) {
        console.warn('Map not initialized');
        return;
    }
    
    if (!tileLayers[style]) {
        console.warn('Invalid map style:', style);
        return;
    }
    
    if (currentStyle === style) {
        return;
    }
    
    console.log('Changing map style to:', style);
    
    // Remove current layer
    if (currentTileLayer) {
        map.removeLayer(currentTileLayer);
    }
    
    // Add new layer
    const config = tileLayers[style];
    currentTileLayer = L.tileLayer(config.url, {
        attribution: config.attribution,
        maxZoom: config.maxZoom
    }).addTo(map);
    
    currentStyle = style;
    
    // Update button states
    document.querySelectorAll('.map-style-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const styleButton = document.getElementById('style-' + style);
    if (styleButton) {
        styleButton.classList.add('active');
    }
    
    console.log('Map style changed to:', style);
}
