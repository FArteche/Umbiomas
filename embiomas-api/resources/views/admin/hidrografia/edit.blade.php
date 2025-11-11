<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando: {{ $hidrografia->nome_hidrografia }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('hidrografia.update', $hidrografia) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6 mb-6">
                        <div>
                            <label for="nome_hidrografia" class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                            <input type="text" name="nome_hidrografia" id="nome_hidrografia"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('nome_hidrografia', $hidrografia->nome_hidrografia) }}" required>
                            @error('nome_hidrografia')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo_hidrografia" class="block mb-2 text-sm font-medium text-gray-900">Tipo</label>
                            <input type="text" name="tipo_hidrografia" id="tipo_hidrografia"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('tipo_hidrografia', $hidrografia->tipo_hidrografia) }}" placeholder="Ex: Rio, Bacia Hidrográfica, Aquífero">
                            @error('tipo_hidrografia')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descricao_hidrografia" class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea name="descricao_hidrografia" id="descricao_hidrografia" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_hidrografia', $hidrografia->descricao_hidrografia) }}</textarea>
                            @error('descricao_hidrografia')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($hidrografia->imagem_hidrografia)
                            <div class="pt-4">
                                <label class="block text-sm font-medium text-gray-700">Imagem Atual:</label>
                                <img src="{{ asset('storage/' . $hidrografia->imagem_hidrografia) }}"
                                    alt="Imagem da {{ $hidrografia->nome_hidrografia }}" class="mt-2 h-40 w-auto rounded-lg shadow-sm">
                            </div>
                        @endif

                        <div>
                            <label for="imagem_hidrografia" class="block text-sm font-medium text-gray-900">
                                Substituir Imagem (opcional)
                            </label>
                            <input type="file" name="imagem_hidrografia" id="imagem_hidrografia"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            @error('imagem_hidrografia')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('biomas.manageHidrografia', ['bioma' => $hidrografia->bioma_id]) }}"
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
