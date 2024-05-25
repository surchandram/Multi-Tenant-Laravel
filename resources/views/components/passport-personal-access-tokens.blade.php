<div x-data="PersonalAccessTokens">
    <div>
        <x-card no-pad>
            <x-slot name="header" class="border-b">
                <div class="flex items-center justify-between">
                    <h4 class="text-lg font-semibold tracking-wider">
                        {{ __('Personal Access Tokens') }}
                    </h4>

                    <x-button x-data="" type="button" is-text size="sm" bold class="focus:ring" tabindex="-1" @click="showCreateTokenForm">
                        {{ __('Create New Token') }}
                    </x-button>
                </div>
            </x-slot>

            <div>
                <!-- No Tokens Notice -->
                <p class="mb-0 p-6" style="display:none;" x-show="tokens.length === 0">
                    {{ __('You have not created any personal access tokens.') }}
                </p>

                <!-- Personal Access Tokens -->
                <div
                    class="-mt-1 -mb-2 overflow-hidden"
                    style="display: none;"
                    x-show="tokens.length > 0"
                >
                    <x-table class="mb-0">
                        <x-slot name="header">
                            <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                            <x-table-col-head></x-table-col-head>
                        </x-slot>
                        <template x-for="(token, index) in tokens" :key="`token-${index}`">
                            <x-table-row>
                                <!-- Client Name -->
                                <x-table-col>
                                    <span x-text="token.name"></span>
                                </x-table-col>
                                <!-- Delete Button -->
                                <x-table-col>
                                    <div class="flex items-center justify-end">
                                        <x-button
                                            x-data=""
                                            type="button"
                                            variant="red"
                                            light
                                            bold
                                            size="sm"
                                            @click.prevent="revoke(token)"
                                        >
                                            {{ __('Delete') }}
                                        </x-button>
                                    </div>
                                </x-table-col>
                            </x-table-row>
                        </template>
                    </x-table>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Create Token Modal -->
    <x-modal name="modal-create-token" tabindex="-1" role="dialog">
        <x-card no-pad no-wrap-pad class="modal-content">
            <x-slot name="header" class="flex items-center justify-between border-b">
                <h4 class="text-lg font-semibold">
                    {{ __('Create Token') }}
                </h4>

                <x-button
                    type="button"
                    is-text
                    size="sm"
                    bold
                    class="focus:ring"
                    aria-hidden="true"
                    @click="$dispatch('close-modal', 'modal-create-token')"
                >
                    &times;
                </x-button>
            </x-slot>

            <div class="p-6">
                <!-- Form Errors -->
                <div
                    class="w-full px-4 py-2 mb-4 bg-red-200 text-red-500 font-semibold"
                    style="display: none;"
                    x-show="form.errors.length > 0"
                >
                    <p class="mb-2">
                        <strong>{{ __('Whoops!') }}</strong> {{ __('Something went wrong!') }}
                    </p>

                    <ul>
                        <template x-for="error in form.errors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Create Token Form -->
                <form role="form" @submit.prevent="store">
                    <!-- Name -->
                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4">
                        <x-input-label class="md:col-span-1">{{ __('Name') }}</x-input-label>

                        <div class="md:col-span-2">
                            <x-input id="create-token-name" type="text" class="w-full" name="name" x-model="form.name" />
                        </div>
                    </div>

                    <!-- Scopes -->
                    <div
                        class="flex flex-col md:grid md:grid-cols-3 md:gap-4 mt-4"
                        style="display:none;"
                        x-show="scopes.length > 0"
                    >
                        <x-input-label class="md:col-span-1">{{ __('Scopes') }}</x-input-label>

                        <div class="md:col-span-2">
                            <template x-for="scope in scopes" :key="scope.id">
                                <div class="checkbox py-2 first:mt-0 mt-2">
                                    <x-input-label>
                                        <x-checkbox
                                            x-data=""
                                            type="checkbox"
                                            class="rounded-sm"
                                            @click="toggleScope(scope.id)"
                                            x-bind:checked="scopeIsAssigned(scope.id)"
                                        />

                                        <span class="ml-2" x-text="scope.id" x-bind:title="scope.description"></span>
                                    </x-input-label>
                                </div>
                            </template>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Actions -->
            <x-slot name="footer" class="flex items-center justify-end gap-2">
                <x-button
                    x-data=""
                    type="button"
                    size="sm"
                    light
                    bold
                    x-bind:disabled="form.processing"
                    @click="$dispatch('close-modal', 'modal-create-token')"
                >
                    {{ __('Close') }}
                </x-button>

                <x-button
                    x-data=""
                    type="button"
                    size="sm"
                    light
                    bold
                    x-bind:disabled="form.processing"
                    @click="store"
                >
                    {{ __('Create') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>

    <!-- Access Token Modal -->
    <x-modal name="modal-access-token" tabindex="-1" role="dialog">
        <x-card no-wrap-pad no-pad>
            <x-slot name="header" class="flex items-center justify-between border-b">
                <h4 class="text-lg font-semibold">
                    {{ __('Personal Access Token') }}
                </h4>

                <x-button
                    type="button"
                    is-text
                    size="sm"
                    bold
                    class="focus:ring"
                    aria-hidden="true"
                    @click="$dispatch('close-modal', 'modal-access-token')"
                >
                    &times;
                </x-button>
            </x-slot>

            <div class="p-6">
                <p>
                    {{ __('Here is your new personal access token. This is the only time it will be shown so don\'t lose it!') }}
                    {{ __('You may now use this token to make API requests.') }}
                </p>

                <x-textarea class="w-full mt-1" readonly rows="10" x-model="accessToken"></x-textarea>
            </div>

            <!-- Modal Actions -->
            <x-slot name="footer" class="flex items-center justify-end">
                <x-button light type="button" variant="gray" @click="$dispatch('close-modal', 'modal-access-token')">
                    {{ __('Close') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('PersonalAccessTokens', () => ({
            /*
            * The component's data.
            */
            accessToken: null,

            tokens: [],
            scopes: [],

            form: {
                name: '',
                scopes: [],
                processing: false,
                errors: []
            },

            /**
             * Prepare the component.
             */
            init() {
                this.getTokens();
                this.getScopes();

                document.addEventListener('opened-modal', (event) => {
                    document.querySelector('#create-token-name').focus();
                });
            },

            /**
             * Get all of the personal access tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/personal-access-tokens')
                        .then(response => {
                            this.tokens = response.data;
                        });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes() {
                axios.get('/oauth/scopes')
                        .then(response => {
                            this.scopes = response.data;
                        });
            },

            /**
             * Show the form for creating new tokens.
             */
            showCreateTokenForm() {
                this.$dispatch('open-modal', 'modal-create-token');
            },

            /**
             * Create a new personal access token.
             */
            store() {
                this.accessToken = null;

                this.form.errors = [];
                this.form.processing = true;

                axios.post('/oauth/personal-access-tokens', this.form)
                        .then(response => {
                            this.form.name = '';
                            this.form.scopes = [];
                            this.form.errors = [];
                            this.form.processing = false;

                            this.tokens.push(response.data.token);

                            this.showAccessToken(response.data.accessToken);
                        })
                        .catch(error => {
                            this.form.processing = false;
                            if (typeof error.response.data === 'object') {
                                this.form.errors = _.flatten(_.toArray(error.response.data.errors));
                            } else {
                                this.form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, s => s == scope);
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken(accessToken) {
                this.$dispatch('close-modal', 'modal-create-token');

                this.accessToken = accessToken;

                this.$dispatch('open-modal', 'modal-access-token');
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                if (!confirm(`Are you sure you want to delete token "${token.name}"?`)) {
                    return;
                }

                axios.delete('/oauth/personal-access-tokens/' + token.id)
                        .then(response => {
                            this.getTokens();
                        });
            }
        }))
    })
</script>
