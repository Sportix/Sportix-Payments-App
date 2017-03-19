<template>
    <div>
        <div class="row mt-20">
            <div class="col-md-4 col-md-offset-4">
                <button class="btn btn-primary btn-block"
                        @click="openStripe"
                        :class="{ 'btn-loading': processing }"
                        :disabled="processing">Pay Now</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'price',
            'productName',
            'productId',
        ],
        data() {
            return {
                quantity: 1,
                stripeHandler: null,
                processing: false,
            }
        },
        computed: {
            description() {
                return `Payment for ${this.productName}`
            },
            totalPrice() {
                return this.price
            },
            priceInDollars() {
                return (this.price / 100).toFixed(2)
            },
            totalPriceInDollars() {
                return (this.totalPrice / 100).toFixed(2)
            },
        },
        methods: {
            initStripe() {
                const handler = StripeCheckout.configure({
                    key: App.stripePublicKey
                })
                window.addEventListener('popstate', () => {
                    handler.close()
                })
                return handler
            },
            openStripe(callback) {
                this.stripeHandler.open({
                    name: 'Sportix',
                    description: this.description,
                    currency: "usd",
                    allowRememberMe: false,
                    panelLabel: 'Pay {{amount}}',
                    amount: this.totalPrice,
                    image: '/img/checkout-icon.png',
                    token: this.makePayment,
                })
            },
            makePayment(token) {
                this.processing = true
                axios.post(`/products/${this.productId}/orders`, {
                    email: token.email,
                    payment_token: token.id,
                }).then(response => {
                    console.log("Charge succeeded")
                }).catch(response => {
                    this.processing = false
                })
            }
        },
        created() {
            this.stripeHandler = this.initStripe()
        }
    }
</script>
