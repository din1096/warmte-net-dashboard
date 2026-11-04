import './bootstrap';

import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.Alpine = Alpine;

Alpine.data('energyMap', () => ({
	map: null,

	init() {
		this.map = L.map(this.$refs.map, { zoomControl: false }).setView([51.7982559, 4.6795546], 16);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap-bijdragers</a>',
		}).addTo(this.map);

		L.circleMarker([51.7982559, 4.6795546], {
			radius: 8,
			color: '#fff',
			weight: 3,
			fillColor: '#e9954c',
			fillOpacity: 1,
		}).addTo(this.map).bindPopup('<strong>Leerparkpromenade</strong><br>Dordrecht').openPopup();

		this.$nextTick(() => this.map.invalidateSize());
	},

	zoomIn() {
		this.map?.zoomIn();
	},

	zoomOut() {
		this.map?.zoomOut();
	},
}));

Alpine.start();
