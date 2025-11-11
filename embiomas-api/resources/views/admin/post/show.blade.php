<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Post: {{ Str::limit($post->titulo_post, 40) }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2">
                <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">{{ $post->titulo_post }}</h3>
                    @if ($post->midia_post)
                        <img src="{{ asset('storage/' . $post->midia_post) }}" alt="Mídia do post"
                            class="w-full h-auto rounded-lg mb-4 border border-gray-200">
                    @endif
                    <div class="prose prose-lg max-w-none text-gray-700">
                        {!! nl2br(e($post->texto_post)) !!}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-4">Informações</h4>

                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Postador:</strong> {{ $post->postador->nome_postador ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $post->postador->email_postador ?? 'N/A' }}</p>
                        <p><strong>Telefone:</strong> {{ $post->postador->telefone_postador ?? 'N/A' }}</p>
                        <p><strong>Instituição:</strong> {{ $post->postador->instituicao_postador ?? 'N/A' }}</p>
                        <p><strong>Criado em:</strong> {{ $post->created_at->format('d/m/y H:i') }}</p>
                    </div>

                    <div class="mt-4 text-center">
                        @if ($post->aprovado_post === null)
                            <span
                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendente
                            </span>
                        @elseif ($post->aprovado_post === 1)
                            <span
                                class_models="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aprovado
                            </span>
                        @else
                            <span
                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Reprovado
                            </span>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-4">Moderação</h4>
                    <div class="flex flex-col space-y-3">

                        <form action="{{ route('post.approve', $post) }}" method="POST">
                            @csrf @method('PUT')
                            <button type"submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-colors duration-150
                                       disabled:opacity-50 disabled:cursor-not-allowed"
                                @disabled($post->aprovado_post !== null)>
                                Aprovar Post
                            </button>
                        </form>

                        <form action="{{ route('post.reject', $post) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 transition-colors duration-150
                                       disabled:opacity-50 disabled:cursor-not-allowed"
                                @disabled($post->aprovado_post !== null)>
                                Reprovar Post
                            </button>
                        </form>

                        <form action="{{ route('post.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja DELETAR este post?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 transition-colors duration-150">
                                Deletar Post
                            </button>
                        </form>
                    </div>
                </div>

                <a href="{{ route('biomas.managePost', $post->bioma_id) }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 font-semibold rounded-lg shadow-sm hover:bg-gray-50 text-xs uppercase tracking-widest transition-colors duration-150">
                    Voltar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
