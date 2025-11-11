<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes da Sugestão
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-4">Sugestão Recebida</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $sugestao->texto_sugestao }}</p>

                <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500 space-y-1">
                    <p><strong>Enviada em:</strong> {{ $sugestao->created_at->format('d/m/Y \à\s H:i') }}</p>
                    <p><strong>Lida em:</strong>
                        {{ $sugestao->lido_em ? $sugestao->lido_em->format('d/m/Y \à\s H:i') : 'Ainda não lida' }}
                    </p>
                </div>
            </div>

            <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-4">Informações do Autor
                </h4>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Nome:</strong> {{ $sugestao->postador->nome_postador ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $sugestao->postador->email_postador ?? 'N/A' }}</p>
                    <p><strong>Telefone:</strong> {{ $sugestao->postador->telefone_postador ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('sugestoes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                    Voltar
                </a>

                <form action="{{ route('sugestoes.destroy', $sugestao) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja DELETAR esta sugestão?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 transition-colors duration-150">
                        Deletar Sugestão
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
