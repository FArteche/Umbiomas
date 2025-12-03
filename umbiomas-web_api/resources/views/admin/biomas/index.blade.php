<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciamento de Biomas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Lista de Biomas</h3>

                    <div class="flex space-x-3">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                            Voltar
                        </a>

                        <a href="{{ route('biomas.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150">
                            Criar Novo Bioma
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome do Bioma
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Ações</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100 divide-y divide-gray-200">

                            @forelse ($biomas as $bioma)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bioma->nome_bioma }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('biomas.edit', $bioma) }}"
                                            class="text-green-700 hover:text-green-900 font-semibold">Gerenciar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Nenhum bioma cadastrado.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
