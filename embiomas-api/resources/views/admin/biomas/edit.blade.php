<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Bioma: {{ $bioma->nome_bioma }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Informações Principais</h3>

                <form action="{{ route('biomas.update', $bioma) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nome_bioma" class="block mb-2 text-sm font-medium text-gray-900">Nome do Bioma</label>
                            <input type="text" id="nome_bioma" name="nome_bioma"
                                value="{{ old('nome_bioma', $bioma->nome_bioma) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                            @error('nome_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="populacao_bioma" class="block mb-2 text-sm font-medium text-gray-900">População</label>
                            <input type="number" id="populacao_bioma" name="populacao_bioma"
                                value="{{ old('populacao_bioma', $bioma->populacao_bioma) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                            @error('populacao_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="descricao_bioma" class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea id="descricao_bioma" name="descricao_bioma" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_bioma', $bioma->descricao_bioma) }}</textarea>
                            @error('descricao_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            @if ($bioma->imagem_bioma)
                                <div class="mb-4">
                                    <p class="block text-sm font-medium text-gray-700">Imagem Atual:</p>
                                    <img src="{{ asset('storage/' . $bioma->imagem_bioma) }}"
                                        alt="Imagem do {{ $bioma->nome_bioma }}" class="mt-2 h-40 w-auto rounded-lg shadow-sm">
                                </div>
                            @endif

                            <label for="imagem_bioma" class="block text-sm font-medium text-gray-700">
                                Substituir Imagem (opcional)
                            </label>
                            <input type="file" name="imagem_bioma" id="imagem_bioma"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            @error('imagem_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('biomas.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Voltar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Atualizar Informações
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Gerenciar Atributos do Bioma</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('biomas.manageFauna', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Fauna</span>
                    </a>
                    <a href="{{ route('biomas.manageFlora', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Flora</span>
                    </a>
                    <a href="{{ route('biomas.manageClima', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Clima</span>
                    </a>
                    <a href="{{ route('biomas.manageCaracteristicas', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Características</span>
                    </a>
                    <a href="{{ route('biomas.manageArea_Preservacao', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Áreas de Preservação</span>
                    </a>
                    <a href="{{ route('biomas.manageRelevo', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Relevo</span>
                    </a>
                    <a href="{{ route('biomas.manageHidrografia', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Hidrografia</span>
                    </a>
                    <a href="{{ route('biomas.editMap', $bioma) }}" class="block p-4 rounded-xl text-center bg-lime-500 transition-colors duration-150 bg-[#E9F1FE] text-gray-900 hover:bg-lime-600 active:bg-lime-400">
                        <span class="font-medium text-sm">Editar Mapa do Bioma</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
