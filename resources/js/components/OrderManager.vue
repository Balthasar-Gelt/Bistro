<template>
    <div class="components-wrapper">
        <Notification v-show="showNotification == true" :notificationMessage="notificationObj.notificationMessage"
            :notificationClass="notificationObj.class"></Notification>

        <OrderList v-show="!showForm" :categories="categories" :showCategories="showCategories"
            v-on:changeCartTotal="cartTotal = $event" v-on:showMessage="processNotification($event)"
            :currency="currency" :link="link">
        </OrderList>

        <CheckoutForm v-show="showForm" v-on:setDelivery="delivery = $event" v-on:closeCheckout="showForm = false"
            v-on:showError="processNotification($event)" :shipping="shipping" :link="link">
        </CheckoutForm>

        <div v-show="!showForm">
            <a class="full-button" v-show="!showCategories" id="show-categories" @click="showCategories = true">ADD
                DISH</a>
            <a class="full-button" v-show="showCategories" id="back-to-list" @click="showCategories = false">BACK TO
                ORDER</a>
            <a class="full-button" v-show="!showForm" id="show-checkout-form" @click="showForm = !showForm">CHECKOUT</a>
        </div>

        <CheckoutTotal :currency="currency" :sum="cartTotal" :delivery="delivery" v-show="showForm || showCategories">
        </CheckoutTotal>
    </div>
</template>

<script>

import Notification from './Notification.vue';
import OrderList from './OrderList.vue';
import CheckoutForm from './CheckoutForm.vue';
import CheckoutTotal from './CheckoutTotal.vue';

export default {
    props: ['link', 'categories', 'currency', 'shipping'],
    components: {
        Notification,
        OrderList,
        CheckoutForm,
        CheckoutTotal,
    },
    data: function () {
        return {
            showCategories: false,
            showForm: false,
            delivery: 0,
            cartTotal: 0,
            notificationObj: {
                notificationMessage: '',
                class: '',
            },
            showNotification: false,
            setTimeout: null,
        }
    },
    methods: {
        treska() { console.log(123) },
        processNotification(event) {

            clearTimeout(this.timeout);
            this.notificationObj.notificationMessage = event.notificationMessage;
            this.notificationObj.class = event.class;
            this.showNotification = true;

            this.timeout = setTimeout(() => {
                this.notificationMessage = '';
                this.showNotification = false;
            }, "2500");
        },
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/variables';

.components-wrapper {
    position: relative;
    padding: 3em 5em;
    width: 70%;
    margin: auto;
    margin-top: 10em;
    margin-bottom: 5em;
    border: 1px solid $mainColor;
    text-align: center;
}

@media(max-width: 1150px) {

    .components-wrapper {
        width: 90%;
    }
}

@media(max-width: 900px) {

    .components-wrapper {
        width: 95%;
        padding: 3em;
    }

    @media(max-width: 900px) {

        .components-wrapper {
            font-size: .9em;
        }
    }

    @media(max-width: 750px) {

        .components-wrapper {
            padding: 2em;
        }
    }

    @media(max-width: 750px) {

        .components-wrapper {
            font-size: .8em;
        }
    }
}
</style>