<template>

<div>
    <div class="error-message" v-show="error != ''">{{error}}</div>

    <form id="checkout-form" @submit.prevent="getCSRFToken" method="post">

        <input type="hidden" name="_token" :value="csrf">

        <div class="form_input form_row">
            <div v-if="formErrors.email" class="input-error">{{formErrors.email[0]}}</div>
            <label for="email">Email address</label>
            <input required class="checkout_input" placeholder="Email address" type="email" id="form_email" name="email" v-model="formInputs.email">
        </div>

        <div class="form_input form_row">
            <div v-if="formErrors.name" class="input-error">{{formErrors.name[0]}}</div>
            <label for="name">Full Name</label>
            <input required class="checkout_input" placeholder="Full Name" type="text" id="form_name" name="name" v-model="formInputs.name">
        </div>

        <div class="form-multiple-input-row form_row">
            <div class="form_input">
                <div v-if="formErrors.street" class="input-error">{{formErrors.street[0]}}</div>
                <label for="street">Street address</label>
                <input required class="checkout_input" placeholder="Street address" type="text" id="form_street" name="street" v-model="formInputs.street">
            </div>

            <div class="form_input">
                <div v-if="formErrors.postalCode" class="input-error">{{formErrors.postalCode[0]}}</div>
                <label for="post">Postal Code</label>
                <input required class="checkout_input" placeholder="Postal Code" type="text" id="form_post" name="postalCode" v-model="formInputs.postalCode">
            </div>
        </div>

        <div class="form_input form_row">
            <div v-if="formErrors.city" class="input-error">{{formErrors.city[0]}}</div>
            <label for="city">City</label>
            <input required class="checkout_input" placeholder="City" type="text" id="form_city" name="city" v-model="formInputs.city">
        </div>

        <div class="form_input select-input form_row" exclude> 
            <div v-if="formErrors.region" class="input-error">{{formErrors.region[0]}}</div>
            <select id="select" v-model="selectedRegion" v-on:change="setDelivery" name="region" >
                <option value="TT">Trnava</option>
                <option value="BA">Bratislava</option>
                <option value="TN">Trencin</option>
                <option value="NA">Nitra</option>
                <option value="ZA">Zilina</option>
                <option value="BB">Banska Bystrica</option>
                <option value="PE">Presov</option>
                <option value="KE">Kosice</option>
            </select>
        </div>

        <button class="submit-button" id="submit">Submit the Information</button>

    </form>

    <StripePayment 
        v-if="wantsToPay" 
        v-on:cancelPayment="wantsToPay = false"
        v-on:showError="showError($event)"
        :link="link"
        >
    </StripePayment>
</div>

</template>

<script>

import StripePayment from './StripePayment.vue';

export default {
    props: ['link', 'shipping'],
    components:{
        StripePayment,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            formInputs: {},
            error: '',
            formErrors: [],
            selectedRegion: '',
            sending: false,
            wantsToPay: false,
        }
    },
    mounted() {

        let mySelect = new vanillaSelectBox("#select", { placeHolder: "Select Region" });

        let inputWrappers = document.querySelectorAll('.form_input');

        for (const wrapper of inputWrappers) {

            if(!wrapper.hasAttribute('exclude')){

                this.toggleInputLabel(wrapper);
            
                wrapper.querySelector('input').addEventListener( 'keyup', () => this.toggleInputLabel(wrapper) );
            }
        }
    },
    methods:{
        setDelivery: function(){
            this.$emit('setDelivery', Number(this.shipping) / 100);
        },
        getCSRFToken: function(){
            fetch(this.link + '/refresh-csrf')
            .then(r => r.text())
            .then(r => this.submitForm(r));
        },
        submitForm: function(token){

            let formData = new FormData(document.querySelector('#checkout-form'));

            if(!this.sending){

                this.sending = true;

                fetch(this.link + '/order/validate', {
                    method: 'POST',
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": token,
                        },
                    body: formData,
                    })
                    .then(r => r.json())
                    .then(r => {
                        this.handleMessage(r);
                        this.sending = false;
                    })
            }
        },
        handleMessage: function(response){

            switch (response.message) {
                case 'The given data was invalid.':

                    this.formErrors = response.errors;
                    this.showError('Could not submit form!');
                    break;

                case 'success':

                    this.wantsToPay = true;
                    break;

                default:

                    this.showError(response.message);
                    break;
            }
        },
        showError: function(error){
            this.error = error;

            setTimeout(() => {
                this.error = '';
            }, 2000);
        },
        toggleInputLabel: function (inputWrapper){

            let input = inputWrapper.querySelector('input');
            let label = inputWrapper.querySelector('label');
            let inputVal = input.value;

            inputVal = inputVal.replace(/\s/g,'');

            if(label != null)
                inputVal != '' ? label.style.opacity = '1' : label.style.opacity = '0';
        },
    },
}

</script>

<style lang="scss" scoped>

    .error-message{
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 99999;
        padding: 1.3em 1.9em;
        background-color: red;
        color: white;
        font-weight: 600;
    }

    @media (max-width: 410px) {

        .submit-button{
            width: 100%;
            font-size: .9em;
        }
    }

</style>