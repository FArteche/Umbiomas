<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Nova Característica Socioeconômica
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="caracteristicaFormComponent()" class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('caracteristica_se.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bioma_id" value="{{ $bioma_id }}">

                    <div class="space-y-6 mb-6">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="tipocse_id" class="block text-sm font-medium text-gray-900">Tipo de Característica</label>
                                <button type="button" @click.prevent="isModalOpen = true"
                                    class="text-sm text-green-600 hover:text-green-900 font-semibold">
                                    + Adicionar Novo
                                </button>
                            </div>
                            <select name="tipocse_id" id="tipocse_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                required>
                                <option value="" disabled selected>-- Selecione um tipo --</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id_tipocse }}"
                                        {{ old('tipocse_id') == $tipo->id_tipocse ? 'selected' : '' }}>
                                        {{ $tipo->nome_tipocse }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocse_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nome_cse" class="block mb-2 text-sm font-medium text-gray-900">Nome da Característica</label>
                            <input type="text" name="nome_cse" id="nome_cse"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ old('nome_cse') }}" required>
                            @error('nome_cse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descricao_cse" class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                            <textarea name="descricao_cse" id="descricao_cse" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">{{ old('descricao_cse') }}</textarea>
                            @error('descricao_cse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="imagem_cse" class="block text-sm font-medium text-gray-900">Imagem (Opcional)</label>
                            <input type="file" name="imagem_cse" id="imagem_cse"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            @error('imagem_cse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('biomas.manageCaracteristicas', ['bioma' => $bioma_id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Salvar Característica
                        </button>
                    </div>
                </form>

                <div x-show="isModalOpen" @keydown.escape.window="isModalOpen = false"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                    x-cloak>
                    <div @click.away="isModalOpen = false"
                        class="relative mx-auto p-6 border w-full max-w-md shadow-lg rounded-2xl bg-gray-100">
                        <div class="mt-3 text-center">
                            <h3 class="text-lg leading-6 font-semibold text-gray-900">Adicionar Novo Tipo</h3>
                            <div class="mt-4 px-7 py-3">
                                <input type="text" x-model="newTipoName" placeholder="Nome do novo tipo"
                                    class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="items-center px-4 py-3 space-y-2">
                                <button @click.prevent="addNewTipo()"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                                    Salvar Novo Tipo
                                </button>
                                <button @click.prevent="isModalOpen = false"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-base transition-colors duration-150">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function caracteristicaFormComponent() {
            return {
                isModalOpen: false,
                newTipoName: '',
                addNewTipo() {
                    let newName = this.newTipoName;
                    if (!newName.trim()) {
                        alert('Por favor, insira um nome para o tipo.');
                        return;
                    }
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('{{ route('tipos-cse.storeAjax') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                nome_tipocse: newName
                            }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(data => Promise.reject(data));
                            }
                            return response.json();
                        })
                        .then(newTipo => {
                            const select = document.getElementById('tipocse_id');
                            const option = new Option(newTipo.nome_tipocse, newTipo.id_tipocse);
                            select.add(option);
                            select.value = newTipo.id_tipocse;
                            this.newTipoName = '';
                            this.isModalOpen = false;
                            alert('Tipo "' + newTipo.nome_tipocse + '" adicionado com sucesso!');
                        })
                        .catch(errorData => {
                            console.error('Error:', errorData);
                            alert('Erro ao adicionar tipo: ' + (errorData.error ||
                                'Erro desconhecido. Verifique o console.'));
                        });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
