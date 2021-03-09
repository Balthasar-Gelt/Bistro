<template>

    <div class="stripe-overlay">
        <div class="stripe-form-wrapper">

            <a @click="$emit('cancelPayment')">
                <img src="images/x.svg" alt="cancel">
            </a>

            <h2>Pay with Card</h2>

            <form id="payment-form">
                <div class="form-row">

                    <!-- Used to display form errors. -->
                    <div id="card-errors" class="input-error" role="alert">
                    </div>

                    <label for="card-element"> Credit or debit card </label>

                    <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                    </div>

                </div>
                
                <button class="submit-button" id="submit">Pay</button>
            </form>

        </div>
    </div>  

</template>

<script>

export default {
    props: ['link'],
    data() {
        return {
            style : {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '13.333333px',
                    fontWeight: 'thin',
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            },
            cardLabel: null,
            displayError: null,
            cardWrapper: null,
            form: null,
            stripe: null,
            card: null,
            paying: false,
        }
    },
    mounted() {

        this.cardLabel = document.querySelector('.form-row label');
        this.displayError = document.getElementById('card-errors');
        this.cardWrapper = document.querySelector('.form-row');
        this.form = document.querySelector('#payment-form');

        this.initializeStripe();
    },
    methods:{
        initializeStripe: function(){

            this.stripe = Stripe('pk_test_51HxE57FFdjrD1rG7GwG9rz5Koi9eXoMWFe75QJkWzGnmmFWdbRbcL49jHzBfO3gDHgnGBwlAb1Nq48jRxLZYI65Q00ututz0dc');

            let elements = this.stripe.elements();

            this.initializeCard(elements.create("card", { style: this.style }));
            this.initializeStripeForm();
        },
        initializeStripeForm: async function(){

            const response = await fetch(this.link + '/order/makePayment/stripePayment');
            const {client_secret: clientSecret} = await response.json();

            this.form.addEventListener('submit', (e) =>{

                e.preventDefault();

                if(!this.paying){
                    
                    this.paying = true;

                    this.stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                        card: this.card,
                        }
                    })
                    .then(result => {

                        if (result.error) 
                            this.$emit('showError', result.error.message);

                        else if (result.paymentIntent.status === 'succeeded')
                            window.location.replace(this.link + '/order/success');
                    });
                }
            });
        },
        initializeCard: function(card){

            this.card = card;
            this.card.mount("#card-element");
            this.attachCardEvents();
        },
        attachCardEvents: function(){

            this.card.on('change', event => {
                
                event.empty ? this.cardLabel.style.opacity = '0' : this.cardLabel.style.opacity = '1';

                if (event.error) 
                    this.displayError.textContent = event.error.message;
                else 
                    this.displayError.textContent = '';
            });
            this.card.on('focus', () => this.cardWrapper.style.borderColor = 'black' );
            this.card.on('blur', () => this.cardWrapper.style.borderColor = '#B81D13' );
        }
    }
}
</script>

<style lang="scss" scoped>

    .stripe-form-wrapper{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 3em;
        min-width: 420px;
        width: 50%;

        background-color: white;

        h2{
            margin-top: 0;
        }

        a{
            width: 28px;
            height: 28px;
            position: absolute;
            top: 2%;
            right: 1%;
            cursor: pointer;

            img{
                width: 100%;
                height: 100%;
            }
        }
    }

    .stripe-overlay{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 99;
        background-color: rgba(0, 0, 0, 0.150);
        text-align: center;
    }

    .form-row {

        #card-errors{
            font-size: 1em;
            transform: translateY(-120%);
        }

        label{
            font-size: .875em;
            top: 1px;
            opacity: 0;
        }
        
        font-size: .8em;
        position: relative;
        width: 100%;
        height: 4em;
        border: 1px solid #B81D13;
        background-color: white;
        transition: border-color 300ms;
    }

    .StripeElement{
        box-sizing: border-box;
        width: calc(100% - .5em);
        position: absolute;
        top: 50%;
        left: .5em;
        transform: translateY(-50%);
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    @media(max-width: 501px){
        
        .stripe-form-wrapper{
            min-width: 95%;
            width: 95%;
            font-size: .9em;
        }
    }

</style>