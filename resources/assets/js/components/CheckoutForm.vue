<template>
    <form action="/purchases" method="POST">

        <input type="hidden" id="stripeToken" v-model="stripeToken">
        <input type="hidden" id="stripeEmail" v-model="stripeEmail">

        <button type="submit" @click.prevent="buy">Buy Me Book</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                stripeEmail: '',
                stripeToken: ''
            }
        },

        created() {
            this.stripe = StripeCheckout.configure({
                key: Laracasts.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                token: (token) => {
                    console.log(token);

                    this.stripeEmail = token.email;
                    this.stripeToken = token.id;

                    axios.post('/purchases', this.$data)
                        .then(response => alert('Complete'));
                }
            });
        },

        methods: {
            buy() {
                this.stripe.open({
                    name: 'My Book',
                    description: 'Some details about the book.',
                    zipCode: true,
                    amount: 2500
                });
            }
        }
    }
</script>
