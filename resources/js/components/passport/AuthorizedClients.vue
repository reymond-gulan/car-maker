<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div v-if="tokens.length > 0">
            <div class="panel panel-default">
                <div class="panel-heading">Authorized Applications</div>

                <div class="panel-body">
                    <!-- Authorized Tokens -->
                    <table class="table table-borderless m-b-none">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Scopes</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="token in tokens">
                                <!-- Client Name -->
                                <td style="vertical-align: middle;">
                                    {{ token.client.name }}
                                </td>

                                <!-- Scopes -->
                                <td style="vertical-align: middle;">
                                    <span v-if="token.scopes.length > 0">
                                        {{ token.scopes.join(', ') }}
                                    </span>
                                </td>

                                <!-- Revoke Button -->
                                <td style="vertical-align: middle;">
                                    <a class="action-link text-danger" @click="revoke(token)">
                                        Revoke
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script scoped>
    export default {
        /*
         * The component's data.
         */
        data () {
            return {
                tokens: []
            };
        },

        mounted () {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             *
             * @returns {void}
             */
            prepareComponent () {
                this.getTokens();
            },

            /**
             * Get all of the authorized tokens for the user.
             *
             * @returns {void}
             */
            getTokens () {
                axios.get('/oauth/tokens')
                    .then((response) => {
                        this.tokens = response;
                    });
            },

            /**
             * Revoke the given token.
             *
             * @returns {void}
             */
            revoke (token) {
                axios.delete(`/oauth/tokens/${token.id}`)
                    .then(response => {
                        this.getTokens();
                    });
            }
        }
    }
</script>
