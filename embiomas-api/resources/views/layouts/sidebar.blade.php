<div class="w-64 bg-gray-100 border-r border-gray-200 flex flex-col flex-shrink-0">

    <div class="h-16 flex items-center justify-center border-b bg-lime-600 border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo_tr.png') }}" alt="UmBiomas Logo" class="h-8 w-11">
            <span class="font-bold text-xl text-gray-800">UmBiomas</span>
        </a>
    </div>

    <nav class="flex-1 py-6 px-4 space-y-2 bg-gray-100">

        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['dashboard']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 8.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 018.25 20.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6A2.25 2.25 0 0115.75 3.75h2.25A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75A2.25 2.25 0 0115.75 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span>Painel de Controle</span>
        </a>

        <a href="{{ route('biomas.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['biomas.index', 'biomas.edit', 'biomas.create']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.869 5.186C3.12 5.56 2.25 5.016 2.25 4.18V15.82c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.875 2.437a1.125 1.125 0 001.006 0z" />
            </svg>
            <span>Biomas</span>
        </a>

        <a href="{{ route('post.indexBiomas') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['post.indexBiomas', 'posts.show']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <span>Posts</span>
        </a>

        <a href="{{ route('historico.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['historico.index']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Histórico</span>
        </a>

        <a href="{{ route('sugestoes.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['sugestoes.index', 'sugestoes.show']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3 7.5a3 3 0 11-6 0 3 3 0 016 0zM6.25 10.5h.008v.008H6.25v-.008zM17.75 10.5h.008v.008h-.008v-.008zM12 21a8.25 8.25 0 005.25-15.383c0-1.604.288-3.09.802-4.384a.757.757 0 01.31-.501.757.757 0 01.81.084a.757.757 0 01.217.437c.069.41.11.83.11 1.267 0 1.604-.288 3.09-.802 4.384a.75.75 0 01-.62.499A8.25 8.25 0 0012 21z" />
            </svg>
            <span>Sugestões</span>
        </a>

        <a href="{{ route('users.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors duration-150 {{ isActive(['users.index', 'users.create', 'profile.edit']) }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 00-12.008 0M18 18.72a9.094 9.094 0 01-12.008 0M12 11.25a3 3 0 100-6 3 3 0 000 6zM12 11.25a3 3 0 01-3 3m0 0a3 3 0 013 3m-3-3a3 3 0 00-3-3m3 3a3 3 0 013-3m-9.75 6.5a.75.75 0 01.75-.75h13.5a.75.75 0 01.75.75v3.642a.75.75 0 01-.673.745 12.028 12.028 0 01-13.604 0A.75.75 0 012.25 18.392V14.75z" />
            </svg>
            <span>Administradores</span>
        </a>
    </nav>

    <div class="p-4 mt-auto border-t border-gray-200 bg-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-gray-400 text-black hover:bg-red-700 hover:text-gray-100 transition-colors duration-150">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span class="font-medium">Sair</span>
            </a>
        </form>
    </div>
</div>
