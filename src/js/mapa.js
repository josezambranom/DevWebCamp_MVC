if(document.querySelector('#mapa')){
    const latitud = -1.012564;
    const longitud = -79.469529;
    const zoom = 16;

    const map = L.map('mapa').setView([latitud, longitud], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitud, longitud]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Universidad Técnica Estatal de Quevedo</p>
            `)
        .openPopup();
}