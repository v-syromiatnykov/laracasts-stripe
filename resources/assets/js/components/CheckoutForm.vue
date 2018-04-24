<template>
    <form action="/purchases" method="POST">

        <input type="hidden" id="stripeToken" v-model="stripeToken">
        <input type="hidden" id="stripeEmail" v-model="stripeEmail">

        <select name="plan" v-model="plan">
            <option v-for="plan in plans" :value="plan.id">
                {{ plan.name }} &mdash; ${{ plan.price / 100 }}
            </option>
        </select>

        <button type="submit" @click.prevent="subscribe">Subscribe</button>
    </form>
</template>

<script>
    export default {
        props: ['plans'],

        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
                plan: 1
            }
        },

        created() {
            this.stripe = StripeCheckout.configure({
                key: Laracasts.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                panelLabel: "Subscribe For",
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
            subscribe() {
                let plan = this.findPlanById(this.plan);

                this.stripe.open({
                    name: plan.name,
                    description: plan.name,
                    zipCode: true,
                    amount: plan.price
                });
            },

            findPlanById(id) {
                return this.plans.find(plan => plan.id === id);
            }
        }
    }
</script>
