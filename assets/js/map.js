import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

class Map {
  static init() {
    let map = document.getElementById('map');
    if (!map){
      return;
    }
    const center = [map.dataset.lat, map.dataset.lng];
    map = L.map('map').setView(center, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 18,
      minZoom: 12
    }).addTo(map);
    const icon = L.icon({
      iconUrl: '/images/marker-icon.png'
    });
    L.marker(center, { icon }).addTo(map);
    // L.marker([50.505, 30.57], {icon: myIcon}).addTo(map);
    //L.marker(center)
    //  .addTo(map)
    //  //.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
      //.openPopup();
  }
}

export default Map;
