<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Histórico de Alterações do Sistema
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Filtrar Histórico</h3>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                        Voltar
                    </a>
                </div>

                <form action="{{ route('historico.index') }}" method="GET"
                    class="mb-8 p-4 bg-gray-50 rounded-lg border">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                        <div>
                            <label for="tipo_alteracao" class="block text-sm font-medium text-gray-700">Tipo de
                                Ação</label>
                            <select name="tipo_alteracao" id="tipo_alteracao"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">Todos os Tipos</option>
                                <option value="criacao" @selected(request('tipo_alteracao') == 'criacao')>Criação</option>
                                <option value="edicao" @selected(request('tipo_alteracao') == 'edicao')>Edição</option>
                                <option value="exclusao" @selected(request('tipo_alteracao') == 'exclusao')>Exclusão</option>
                            </select>
                        </div>

                        <div>
                            <label for="bioma_id" class="block text-sm font-medium text-gray-700">Filtrar por
                                Bioma</label>
                            <select name="bioma_id" id="bioma_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">Todos os Biomas</option>
                                @foreach ($biomas as $bioma)
                                    <option value="{{ $bioma->id_bioma }}" @selected(request('bioma_id') == $bioma->id_bioma)>
                                        {{ $bioma->nome_bioma }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700">Ordenar Por</label>
                            <select name="sort" id="sort"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="desc" @selected(request('sort', 'desc') == 'desc')>Mais Recentes</option>
                                <option value="asc" @selected(request('sort') == 'asc')>Mais Antigos</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                                Filtrar
                            </button>
                            <a href="{{ route('historico.index') }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                                Limpar
                            </a>
                        </div>

                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuário</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ação</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Objeto</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Detalhes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($historico as $registro)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $registro->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $registro->user->name ?? 'N/A' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ ucfirst($registro->tipo_alteracao) }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $registro->nome_objeto }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $registro->detalhes_alteracao }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum registro
                                        encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $historico->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
