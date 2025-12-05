<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar Novo Elemento de Relevo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('relevo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bioma_id" value="{{ $bioma_id }}">

                    <div class="space-y-6 mb-6">
                        <div>
                            <label for="nome_relevo" class="block mb-2 text-sm font-medium text-gray-900">Nome do
                                Relevo</label>
                            <input type="text" name="nome_relevo" id="nome_relevo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('nome_relevo') }}" required>
                            @error('nome_relevo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo_relevo" class="block mb-2 text-sm font-medium text-gray-900">Tipo do relevo
                                (Opcional)</label>
                            <input type="text" name="tipo_relevo" id="tipo_relevo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('tipo_relevo') }}">
                            @error('tipo_relevo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descricao_relevo"
                                class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea name="descricao_relevo" id="descricao_relevo" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_relevo') }}</textarea>
                            @error('descricao_relevo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="imagem_relevo" class="block text-sm font-medium text-gray-900">Imagem
                                (Opcional)</label>
                            <input type="file" name="imagem_relevo" id="imagem_relevo"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            @error('imagem_relevo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('biomas.manageRelevo', ['bioma' => $bioma_id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Elemento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
