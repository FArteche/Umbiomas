<section class="bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200">
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            Deletar Conta
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente apagados.
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="mt-6">{{ __('Deletar Conta') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Você tem certeza que quer deletar sua conta?
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente apagados. Por
                favor, digite sua senha para confirmar que você deseja deletar permanentemente sua conta.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Senha') }}" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Senha') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Deletar Conta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
