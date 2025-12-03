<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Caixa de Sugestões
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 md:mb-0">Sugestões Recebidas</h3>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                        Voltar
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sugestão</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Enviado por</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100 divide-y divide-gray-200">
                            @forelse ($sugestoes as $sugestao)
                                <tr class="{{ is_null($sugestao->lido_em) ? 'bg-green-50 font-medium' : '' }}">
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm">
                                        @if (is_null($sugestao->lido_em))
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Não
                                                Lido</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lido</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ Str::limit($sugestao->texto_sugestao, 80) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $sugestao->postador->nome_postador ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $sugestao->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('sugestoes.show', $sugestao) }}"
                                            class="text-green-700 hover:text-green-900 font-semibold">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhuma sugestão
                                        recebida.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($sugestoes->hasPages())
                    <div class="mt-6">
                        {{ $sugestoes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
