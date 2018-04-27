<template>
    <form action="/purchases" method="POST">

        <input type="hidden" id="stripeToken" v-model="stripeToken">
        <input type="hidden" id="stripeEmail" v-model="stripeEmail">

        <div class="form-group">
            <select name="plan" v-model="plan" class="form-control">
                <option v-for="plan in plans" :value="plan.id">
                    {{ plan.name }} &mdash; ${{ plan.price / 100 }}
                </option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-control"
                   name="coupon" placeholder="Have a coupon code?"
                   v-model="coupon">
        </div>

        <div class="form-group">
            <button type="submit" class="form-control btn btn-info"
                    @click.prevent="subscribe">Subscribe
            </button>
        </div>

        <p class="help is-danger" v-show="status" v-text="status"></p>
    </form>
</template>

<script>
    export default {
        props: ['plans'],

        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
                plan: 1,
                status: false,
                coupon: ''
            }
        },

        created() {
            this.stripe = StripeCheckout.configure({
                key: Laracasts.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                panelLabel: "Subscribe For",
                email: Laracasts.user.email,
                token: (token) => {
                    console.log(token);

                    this.stripeEmail = token.email;
                    this.stripeToken = token.id;

                    axios.post('/subscriptions', this.$data)
                        .then(() => alert('Complete! Thanks for your payment!'))
                        .catch(error => this.status = error.response.data.status);
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
