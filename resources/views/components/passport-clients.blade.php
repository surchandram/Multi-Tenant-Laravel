<div x-data="PassportClients">
    <x-card no-pad class="mt-4">
        <x-slot name="header" class="flex items-center justify-between border-b">
            <h4 class="text-lg font-semibold tracking-wider">
                {{ __('OAuth Clients') }}
            </h4>

            <x-button
                is-text
                size="sm"
                bold
                type="button"
                class="focus:ring"
                tabindex="-1"
                @click.prevent="showCreateClientForm"
            >
                {{ __('Create New Client') }}
            </x-button>
        </x-slot>

        <div>
            <!-- Current Clients -->
            <p class="p-6" x-show="clients.length === 0">
                {{ __('You have not created any OAuth clients.') }}
            </p>

            <div class="-mt-1 -mb-2" x-show="clients.length > 0" style="display: none;">
                <x-table>
                    <x-slot name="header">
                        <x-table-col-head>{{ __('Client ID') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Secret') }}</x-table-col-head>
                        <x-table-col-head></x-table-col-head>
                        <x-table-col-head></x-table-col-head>
                    </x-slot>

                    <tbody>
                        <template x-for="client in clients">
                            <x-table-row>
                                <!-- ID -->
                                <x-table-col style="vertical-align: middle;">
                                    <span x-text="client.id"></span>
                                </x-table-col>

                                <!-- Name -->
                                <x-table-col style="vertical-align: middle;">
                                    <span x-text="client.name"></span>
                                </x-table-col>

                                <!-- Secret -->
                                <x-table-col style="vertical-align: middle;">
                                    <code x-text="client.secret"></code>
                                </x-table-col>

                                <!-- Edit Button -->
                                <x-table-col style="vertical-align: middle;">
                                    <x-button size="sm" is-text bold tabindex="-1" @click="edit(client)">
                                        {{ __('Edit') }}
                                    </x-button>
                                </x-table-col>

                                <!-- Delete Button -->
                                <x-table-col style="vertical-align: middle;">
                                    <x-button size="sm" light bold variant="red" @click="destroy(client)">
                                        {{ __('Delete') }}
                                    </x-button>
                                </x-table-col>
                            </x-table-row>
                        </template>
                    </tbody>
                </x-table>
            </div>
        </div>
    </x-card>

    <!-- Create Client Modal -->
    <x-modal name="modal-create-client" tabindex="-1" role="dialog">
        <x-card no-wrap-pad no-pad>
            <x-slot name="header" class="flex items-center justify-between border-b">
                <h4 class="text-lg font-semibold">
                    {{ __('Create Client') }}
                </h4>

                <x-button
                    type="button"
                    is-text
                    size="sm"
                    class="focus:ring"
                    aria-hidden="true"
                    @click="$dispatch('close-modal', 'modal-create-client')"
                >
                    &times;
                </x-button>
            </x-slot>

            <div class="p-6">
                <!-- Form Errors -->
                <div class="px-4 py-2 mb-4 text-white bg-red-600" x-show="createForm.errors.length > 0">
                    <p class="text-sm font-semibold mb-2">
                        <strong>{{ __('Whoops!') }}</strong> {{ __('Something went wrong!') }}
                    </p>
                    <ul>
                        <template x-for="error in createForm.errors">
                            <li>
                                <span x-text="error"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Create Client Form -->
                <form role="form">
                    <!-- Name -->
                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4 mt-4">
                        <x-input-label class="md:col-span-1">{{ __('Name') }}</x-input-label>

                        <div class="md:col-span-2">
                            <x-input
                                id="create-client-name"
                                type="text"
                                class="w-full mt-2 md:mt-0"
                                @keyup.enter="store"
                                x-model="createForm.name"
                            />

                            <div class="text-sm text-slate-500 mt-2">
                                {{ __('Something your users will recognize and trust.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Redirect URL -->
                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4 mt-4">
                        <x-input-label class="md:col-span-1">{{ __('Redirect URL') }}</x-input-label>

                        <div class="md:col-span-2">
                            <x-input
                                type="text"
                                class="w-full mt-2 md:mt-0"
                                name="redirect"
                                @keyup.enter="store"
                                x-model="createForm.redirect"
                            />

                            <div class="text-sm text-slate-500 mt-2">
                                {{ __('Your application\'s authorization callback URL.') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Actions -->
            <x-slot name="footer" class="flex items-center justify-end gap-2">
                <x-button
                    type="button"
                    light
                    size="sm"
                    bold
                    variant="gray"
                    x-bind:disabled="createForm.processing"
                    @click="$dispatch('close-modal', 'modal-create-client')"
                >
                    {{ __('Close') }}
                </x-button>

                <x-button
                    type="button"
                    light
                    size="sm"
                    bold
                    x-bind:disabled="createForm.processing"
                    @click="store">
                    {{ __('Create') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>

    <!-- Edit Client Modal -->
    <x-modal name="modal-edit-client" tabindex="-1" role="dialog">
        <x-card no-wrap-pad no-pad>
            <x-slot name="header" class="flex items-center justify-between border-b">
                <h4 class="text-lg font-semibold">
                    {{ __('Edit Client') }}
                </h4>

                <x-button
                    type="button"
                    is-text
                    size="sm"
                    class="focus:ring"
                    aria-hidden="true"
                    @click="$dispatch('close-modal', 'modal-edit-client')"
                >
                    &times;
                </x-button>
            </x-slot>

            <div class="p-6">
                <!-- Form Errors -->
                <div class="px-4 py-2 mb-4 text-white bg-red-600" x-show="editForm.errors.length > 0">
                    <p class="text-sm font-semibold mb-2">
                        <strong>{{ __('Whoops!') }}</strong> {{ __('Something went wrong!') }}
                    </p>
                    <ul>
                        <template x-for="error in editForm.errors">
                            <li>
                                <span x-text="error"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Edit Client Form -->
                <form role="form">
                    <!-- Name -->
                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4 mt-4">
                        <x-input-label class="md:col-span-1">{{ __('Name') }}</x-input-label>

                        <div class="md:col-span-2">
                            <x-input
                                id="edit-client-name"
                                type="text"
                                class="w-full mt-2 md:mt-0"
                                @keyup.enter="update"
                                x-model="editForm.name"
                            />

                            <div class="text-sm text-slate-500 mt-2">
                                {{ __('Something your users will recognize and trust.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Redirect URL -->
                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4 mt-4">
                        <x-input-label class="md:col-span-1">{{ __('Redirect URL') }}</x-input-label>

                        <div class="md:col-span-2">
                            <x-input
                                type="text"
                                class="w-full mt-2 md:mt-0"
                                name="redirect"
                                @keyup.enter="update" x-model="editForm.redirect"
                            />

                            <div class="text-sm text-slate-500 mt-2">
                                {{ __('Your application\'s authorization callback URL.') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Actions -->
            <x-slot name="footer" class="flex items-center justify-end gap-2">
                <x-button
                    type="button"
                    light
                    size="sm"
                    bold
                    variant="gray"
                    x-bind:disabled="editForm.processing"
                    @click="$dispatch('close-modal', 'modal-edit-client')"
                >
                    {{ __('Close') }}
                </x-button>

                <x-button
                    type="button"
                    light
                    size="sm"
                    bold
                    x-bind:disabled="editForm.processing"
                    @click="update">
                    {{ __('Save Changes') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('PassportClients', () => ({
            /*
             * The component's data.
             */
            clients: [],

            createForm: {
                errors: [],
                name: '',
                redirect: '',
                processing: false
            },

            editForm: {
                errors: [],
                name: '',
                redirect: '',
                processing: false
            },

            /**
             * Prepare the component.
             */
            init() {
                this.getClients();

                document.addEventListener('opened-modal', (event) => {
                    if (event.detail === 'modal-create-client') {
                        document.querySelector('#create-client-name').focus();
                    } else if (event.detail === 'modal-edit-client') {
                        document.querySelector('#edit-client-name').focus();
                    }
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                this.$dispatch('open-modal', 'modal-create-client');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, 'modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                this.$dispatch('open-modal', 'modal-edit-client');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, 'modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];
                form.processing = true;

                axios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];
                        form.processing = false;

                        this.$dispatch('close-modal', modal);
                    })
                    .catch(error => {
                        form.processing = false;
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                if (!confirm(`Are you sure you want to delete "${client.name}" from OAuth Clients?`)) {
                    return;
                }

                axios.delete('/oauth/clients/' + client.id)
                        .then(response => {
                            this.getClients();
                        });
            }
        }))
    })
</script>
