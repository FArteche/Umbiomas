<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciando Fauna do Bioma: {{ $bioma->nome_bioma }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mb-6">
                    <form action="{{ route('biomas.manageFauna', $bioma) }}" method="GET">
                        <label for="search" class="sr-only">Buscar</label>
                        <div class="flex">
                            <input type="text" name="search" id="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                placeholder="Buscar por nome, família, etc..." value="{{ request('search') }}">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white font-semibold rounded-r-lg shadow-md hover:bg-green-700 transition-colors duration-150">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>

                <form action="{{ route('biomas.syncFauna', $bioma) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 md:mb-0">Selecione a Fauna Associada</h3>
                        <a href="{{ route('fauna.create', ['return_to' => url()->current()]) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Adicionar Novo Elemento
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($all_fauna as $animal)
                            <label class="relative cursor-pointer">
                                <input type="checkbox" name="fauna_ids[]" value="{{ $animal->id_fauna }}"
                                    class="hidden peer" @if (in_array($animal->id_fauna, $attached_fauna_ids)) checked @endif>
                                <div
                                    class="w-full h-64 flex flex-col bg-gray-100 rounded-lg shadow-md border border-gray-200
                                            overflow-hidden transition-all duration-200
                                            peer-checked:ring-2 peer-checked:ring-green-500 peer-checked:border-transparent">
                                    <div class="flex-shrink-0 h-32">
                                        <img class="h-full w-full object-cover"
                                            src="{{ $animal->imagem_fauna ? asset('storage/' . $animal->imagem_fauna) : 'https://upload.wikimedia.org/wikipedia/commons/b/b9/No_photo_%282067963%29_-_The_Noun_Project.svg' }}"
                                            alt="Imagem de {{ $animal->nome_fauna }}">
                                    </div>

                                    <div class="flex-grow p-3 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-800 truncate"
                                                title="{{ $animal->nome_fauna }}">{{ $animal->nome_fauna }}</h4>
                                            <p class="text-sm text-gray-600 italic truncate"
                                                title="{{ $animal->nome_cientifico_fauna }}">
                                                {{ $animal->nome_cientifico_fauna }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 truncate"
                                            title="{{ $animal->familia_fauna }}">{{ $animal->familia_fauna }}</p>

                                        <div class="flex items-center justify-end space-x-2 mt-2">
                                            <a href="{{ route('fauna.edit', ['fauna' => $animal, 'return_to' => url()->current()]) }}"
                                                class="text-gray-400 hover:text-green-600 p-1 rounded-full transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('fauna.destroy', $animal) }}')"
                                                class="text-gray-400 hover:text-red-600 p-1 rounded-full transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="absolute top-2 right-2 h-6 w-6 bg-green-600 rounded-full text-white
                                            flex items-center justify-center
                                            opacity-0 peer-checked:opacity-100 transition-opacity duration-300
                                            transform scale-75 peer-checked:scale-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6 mt-8">
                        <a href="{{ route('biomas.edit', $bioma) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Voltar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Fauna
                        </button>
                    </div>
                </form>

                <form id="delete-form" action="" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                <script>
                    function confirmDelete(deleteUrl) {
                        if (confirm('Tem certeza que deseja deletar este item? Esta ação não pode ser desfeita.')) {
                            let form = document.getElementById('delete-form');
                            form.action = deleteUrl;
                            form.submit();
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
