<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Novo Bioma
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('biomas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nome_bioma" class="block mb-2 text-sm font-medium text-gray-900">Nome do Bioma</label>
                            <input type="text" name="nome_bioma" id="nome_bioma"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('nome_bioma') }}" required>
                            @error('nome_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="populacao_bioma" class="block mb-2 text-sm font-medium text-gray-900">População (Aproximada)</label>
                            <input type="number" name="populacao_bioma" id="populacao_bioma"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('populacao_bioma') }}" required>
                            @error('populacao_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="descricao_bioma" class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea id="descricao_bioma" name="descricao_bioma" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_bioma') }}</textarea>
                            @error('descricao_bioma')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="imagem_bioma" class="block text-sm font-medium text-gray-900">Imagem do Bioma</label>
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
                            Salvar Bioma
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
