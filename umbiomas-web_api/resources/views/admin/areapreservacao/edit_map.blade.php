<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Definindo Localização da Área: {{ $area->nome_ap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('areas-preservacao.updateMap', $area) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="area_geografica" id="area_geografica_input">

                    <p class="mb-4 text-sm text-gray-600">Clique no mapa para adicionar ou mover o marcador que
                        representa a localização da área de preservação.</p>

                    <div id="map" class="w-full h-[500px] rounded-lg border z-10"></div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 mt-6 pt-6">
                        <a href="{{ route('biomas.manageArea_Preservacao', ['bioma' => $area->bioma_id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Voltar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Localização
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([-14.235, -51.925], 4);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                const areaInput = document.getElementById('area_geografica_input');
                let marker = null;

                let savedCoords = @json($area->area_geografica);

                // console.log("Dados recebidos do banco:", savedCoords);
                // console.log("Tipo dos dados:", typeof savedCoords);

                if (typeof savedCoords === 'string' && savedCoords) {
                    try {
                        savedCoords = JSON.parse(savedCoords);
                    } catch (e) {
                        console.error("Erro ao converter as coordenadas JSON:", e);
                        savedCoords = null;
                    }
                }
                if (savedCoords && savedCoords.lat && savedCoords.lng) {
                    marker = L.marker([savedCoords.lat, savedCoords.lng]).addTo(map);
                    map.setView([savedCoords.lat, savedCoords.lng], 13);
                    areaInput.value = JSON.stringify(savedCoords);
                }

                map.on('click', function(e) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker(e.latlng).addTo(map);
                    const coords = {
                        lat: e.latlng.lat,
                        lng: e.latlng.lng
                    };
                    areaInput.value = JSON.stringify(coords);
                });
            });
        </script>
    @endpush
</x-app-layout>
