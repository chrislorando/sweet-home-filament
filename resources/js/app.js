import './bootstrap';

// Livewire navigate + Leaflet map initializer
document.addEventListener('livewire:init', () => {
	const initMap = () => {
		const el = document.getElementById('map');
		if (!el) return;

		if (el.dataset.mapInited === '1') {
			return;
		}

		const lat = parseFloat(el.dataset.lat || '');
		const lng = parseFloat(el.dataset.lng || '');
		const title = el.dataset.title || '';

		if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
			return;
		}

		if (typeof window.L === 'undefined') {
			return;
		}

		// Build a custom icon with absolute CDN URLs to avoid path issues
		const icon = L.icon({
			iconRetinaUrl:
				'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/images/marker-icon-2x.png',
			iconUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/images/marker-icon.png',
			shadowUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/images/marker-shadow.png',
			iconSize: [25, 41],
			iconAnchor: [12, 41],
			popupAnchor: [1, -34],
			shadowSize: [41, 41],
		});

		const map = L.map(el).setView([lat, lng], 13);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution:
				'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		}).addTo(map);

		L.marker([lat, lng], { icon }).addTo(map).bindPopup(title).openPopup();

		el.dataset.mapInited = '1';
	};

	// Initial run on DOM ready
	if (document.readyState === 'complete' || document.readyState === 'interactive') {
		queueMicrotask(initMap);
	} else {
		document.addEventListener('DOMContentLoaded', initMap, { once: true });
	}

	// Re-run after SPA navigations
	document.addEventListener('livewire:navigated', () => initMap());
});
