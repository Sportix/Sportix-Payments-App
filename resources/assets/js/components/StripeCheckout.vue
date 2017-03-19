<template>
    <div>
        <div class="row middle-xs">
            <div class="col col-xs-6">
                <div class="form-group m-xs-b-4">
                    <label class="form-label">
                        Price
                    </label>
                    <span class="form-control-static">
                        ${{ priceInDollars }}
                    </span>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-primary btn-block"
                    @click="openStripe"
                    :class="{ 'btn-loading': processing }"
                    :disabled="processing"
            >
                Pay Now
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'price',
            'productTitle',
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
                return `Payment for ${this.productTitle}`
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
                    token: this.purchaseTickets,
                })
            },
            purchaseTickets(token) {
                this.processing = true
                axios.post(`/concerts/${this.concertId}/orders`, {
                    email: token.email,
                    ticket_quantity: this.quantity,
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
