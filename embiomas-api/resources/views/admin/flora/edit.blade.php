<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando: {{ $flora->nome_flora }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('flora.update', $flora) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="return_to" value="{{ $returnTo }}">
                    @method('PUT')

                    <div class="space-y-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nome_flora" class="block mb-2 text-sm font-medium text-gray-900">Nome
                                    Popular</label>
                                <input type="text" name="nome_flora" id="nome_flora"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                    value="{{ old('nome_flora', $flora->nome_flora) }}" required>
                                @error('nome_flora')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nome_cientifico_flora"
                                    class="block mb-2 text-sm font-medium text-gray-900">Nome Científico</label>
                                <input type="text" name="nome_cientifico_flora" id="nome_cientifico_flora"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                    value="{{ old('nome_cientifico_flora', $flora->nome_cientifico_flora) }}">
                            </div>
                        </div>

                        <div>
                            <label for="familia_flora"
                                class="block mb-2 text-sm font-medium text-gray-900">Família</label>
                            <input type="text" name="familia_flora" id="familia_flora"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('familia_flora', $flora->familia_flora) }}">
                        </div>

                        <div>
                            <label for="descricao_flora"
                                class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea name="descricao_flora" id="descricao_flora" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_flora', $flora->descricao_flora) }}</textarea>
                        </div>

                        @if ($flora->imagem_flora)
                            <div class="pt-4">
                                <label class="block text-sm font-medium text-gray-700">Imagem Atual:</p>
                                    <img src="{{ asset('storage/' . $flora->imagem_flora) }}"
                                        alt="Imagem do {{ $flora->nome_flora }}"
                                        class="mt-2 h-40 w-auto rounded-lg shadow-sm">
                            </div>
                        @endif
                        <div>
                            <label for="imagem_flora" class="block text-sm font-medium text-gray-900">
                                Substituir Imagem (opcional)
                            </label>
                            <input type="file" name="imagem_flora" id="imagem_flora"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            @error('imagem_flora')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                        <a href="{{ $returnTo }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
