<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Painel de Controle
            </h2>
            <p class="text-sm text-gray-500">Bem-vindo(a) de volta!</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-12 gap-6">

                <div class="col-span-12 lg:col-span-8">
                    <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                        <div class="flex items-center space-x-3">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Gerenciamento de Conteúdo</h3>
                                <p class="text-sm text-gray-500">Gerencie biomas, posts e histórico de alterações.</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('biomas.index') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.869 5.186C3.12 5.56 2.25 5.016 2.25 4.18V15.82c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.875 2.437a1.125 1.125 0 001.006 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Gerenciar Biomas</span>
                                </div>
                            </a>
                            <a href="{{ route('post.indexBiomas') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Gerenciar Posts</span>
                                </div>
                            </a>
                            <a href="{{ route('historico.index') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Histórico de Alterações</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4">
                    <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                        <div class="flex items-center space-x-3">
                            <div class="p-3 rounded-full bg-blue-100">
                                <svg class="h-6 w-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3 7.5a3 3 0 11-6 0 3 3 0 016 0zM6.25 10.5h.008v.008H6.25v-.008zM17.75 10.5h.008v.008h-.008v-.008zM12 21a8.25 8.25 0 005.25-15.383c0-1.604.288-3.09.802-4.384a.757.757 0 01.31-.501.757.757 0 01.81.084a.757.757 0 01.217.437c.069.41.11.83.11 1.267 0 1.604-.288 3.09-.802 4.384a.75.75 0 01-.62.499A8.25 8.25 0 0012 21z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Sugestões</h3>
                                <p class="text-sm text-gray-500">Analise as sugestões dos usuários.</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4">
                            <a href="{{ route('sugestoes.index') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25S3.75 16.556 3.75 12 7.61 3.75 12.375 3.75m0 0S12.375 3 12 3m0 0s-.375 0-.375.375m10.125 8.625c0 .621-.504 1.125-1.125 1.125H3.375c-.621 0-1.125-.504-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v1.5z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Visualizar Sugestões</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">

                        <div class="flex items-center space-x-3">
                            <div class="p-3 rounded-full bg-orange-100">
                                <svg class="h-6 w-6 text-orange-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Administradores</h3>
                                <p class="text-sm text-gray-500">Gerencie as contas de administradores.</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('profile.edit') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Gerenciar Minha Conta</span>
                                </div>
                            </a>
                            <a href="{{ route('users.index') }}"
                                class="block p-4 rounded-xl text-center transition-colors duration-150 bg-gray-300 text-gray-900 hover:bg-lime-200 active:bg-lime-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-8 w-8 text-gray-700 mb-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 00-12.008 0M18 18.72a9.094 9.094 0 01-12.008 0M12 11.25a3 3 0 100-6 3 3 0 000 6zM12 11.25a3 3 0 01-3 3m0 0a3 3 0 013 3m-3-3a3 3 0 00-3-3m3 3a3 3 0 013-3m-6 0a3 3 0 100-6 3 3 0 000 6zM12 14.25a3 3 0 01-3 3m0 0a3 3 0 013 3m-3-3a3 3 0 00-3-3m3 3a3 3 0 013-3m-9.75 6.5a.75.75 0 01.75-.75h13.5a.75.75 0 01.75.75v3.642a.75.75 0 01-.673.745 12.028 12.028 0 01-13.604 0A.75.75 0 012.25 18.392V14.75z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Gerenciar e Criar Contas</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
