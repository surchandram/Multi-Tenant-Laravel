<div x-data="PassportAuthorizedClients">
    <div x-show="tokens.length > 0" style="display: none;">
        <x-card no-pad>
            <x-slot name="header">
                <h4 class="text-lg font-semibold tracking-wider">
                    {{ __('Authorized Applications') }}
                </h4>
            </x-slot>

            <div class="-mt-1 -mb-2">
                <!-- Authorized Tokens -->
                <x-table>
                    <x-slot name="header">
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Scopes') }}</x-table-col-head>
                        <x-table-col-head></x-table-col-head>
                    </x-slot>

                    <template x-for="token in tokens">
                        <x-table-row>
                            <!-- Client Name -->
                            <x-table-col style="vertical-align: middle;">
                                <span x-text="token.client.name"></span>
                            </x-table-col>

                            <!-- Scopes -->
                            <x-table-col style="vertical-align: middle;">
                                <template x-if="token.scopes.length > 0">
                                    <span x-text="token.scopes.join(', ')"></span>
                                </template>
                            </x-table-col>

                            <!-- Revoke Button -->
                            <x-table-col style="vertical-align: middle;">
                                <x-button size="sm" bold light variant="red" @click="revoke(token)">
                                    {{ __('Revoke') }}
                                </x-button>
                            </x-table-col>
                        </x-table-row>
                    </template>
                </x-table>
            </div>
        </x-card>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('PassportAuthorizedClients', () => ({
            /*
             * The component's data.
             */
            tokens: [],

            /**
             * Prepare the component.
             */
            init() {
                this.getTokens();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/tokens')
                        .then(response => {
                            this.tokens = response.data;
                        });
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                console.log(token)
                if (!confirm(`Are you sure you want to revoke token?`)) {
                    return;
                }
                axios.delete('/oauth/tokens/' + token.id)
                        .then(response => {
                            this.getTokens();
                        });
            }
        }))
    })
</script>
