<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Mapa do Bioma: {{ $bioma->nome_bioma }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="text-sm text-gray-600 mb-4">Use as ferramentas no canto esquerdo do mapa para desenhar o polígono que representa a área geográfica do bioma. Clique em "Salvar Mapa" para guardar o desenho.</p>

                <form action="{{ route('biomas.updateMap', $bioma) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="area_geografica" id="area_geografica_input">

                    <div id="map" class="w-full h-[500px] rounded-lg border z-10"></div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 mt-6 pt-6">
                        <a href="{{ route('biomas.edit', $bioma) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Voltar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Mapa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Adiciona um listener para garantir que o L (Leaflet) esteja carregado
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([-14.235, -51.925], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            const drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems,
                    remove: true
                },
                draw: {
                    polygon: true,
                    polyline: false,
                    rectangle: false,
                    circle: false,
                    marker: false,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);

            const areaInput = document.getElementById('area_geografica_input');

            // Carrega os dados salvos
            const savedCoords = @json($bioma->area_geografica);
            if (savedCoords) {
                try {
                    const polygon = L.polygon(savedCoords).addTo(drawnItems);
                    map.fitBounds(polygon.getBounds());
                    areaInput.value = JSON.stringify(savedCoords);
                } catch (e) {
                    console.error('Erro ao carregar polígono salvo:', e);
                }
            }

            // Evento de criação
            map.on(L.Draw.Event.CREATED, function(event) {
                const layer = event.layer;
                drawnItems.clearLayers();
                drawnItems.addLayer(layer);

                const coords = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);
                areaInput.value = JSON.stringify(coords);
            });

            // Evento de edição/deleção
            map.on('draw:edited draw:deleted', function(e) {
                const layers = drawnItems.getLayers();
                if (layers.length > 0) {
                    const coords = layers[0].getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);
                    areaInput.value = JSON.stringify(coords);
                } else {
                    areaInput.value = '';
                }
            });
        });
    </script>
    @endpush

    </x-app-layout>
