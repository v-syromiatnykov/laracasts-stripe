<template>
    <form action="/purchases" method="POST">

        <input type="hidden" id="stripeToken" v-model="stripeToken">
        <input type="hidden" id="stripeEmail" v-model="stripeEmail">

        <select name="product" v-model="product">
            <option v-for="product in products" :value="product.id">
                {{ product.name }} &mdash; ${{ product.price / 100 }}
            </option>
        </select>

        <button type="submit" @click.prevent="buy">Buy Me Book</button>
    </form>
</template>

<script>
    export default {
        props: ['products'],

        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
                product: 1
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
                let product = this.findProductById(this.product);

                this.stripe.open({
                    name: product.name,
                    description: product.description,
                    zipCode: true,
                    amount: product.price
                });
            },

            findProductById(id) {
                return this.products.find(product => product.id === id);
            }
        }
    }
</script>
