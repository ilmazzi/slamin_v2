document.addEventListener('DOMContentLoaded', function() {
    const mapContainer = document.getElementById('eventShowMap');
    
    if (mapContainer) {
        const lat = parseFloat(mapContainer.dataset.lat);
        const lng = parseFloat(mapContainer.dataset.lng);
        const name = mapContainer.dataset.name;
        
        // Initialize map
        const eventMap = L.map('eventShowMap', {
            scrollWheelZoom: false,
            dragging: true,
            zoomControl: true
        }).setView([lat, lng], 15);
        
        // Add Voyager tile layer
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap, © CartoDB',
            maxZoom: 19
        }).addTo(eventMap);
        
        // Add marker
        const marker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: `<div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4); border: 3px solid white;"></div>`,
                className: 'custom-event-marker',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            })
        }).addTo(eventMap);
        
        // Add popup
        marker.bindPopup(`<strong>${name}</strong>`).openPopup();
        
        console.log('✅ Event show map initialized at:', lat, lng);
    }
});
