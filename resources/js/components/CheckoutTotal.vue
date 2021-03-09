<template>
        
    <div class="sum-wrapper">
        <h2>ORDER TOTAL</h2>
        <div class="delivery-cost">
            <span>Delivery: </span>
            {{delivery}}
            {{currency}}
        </div>

        <div class="checkout-total">
            <span>Order Total: </span>
            {{parseFloat((sum + delivery).toFixed(2))}}
            {{currency}}
        </div>

    </div>

</template>

<script>

export default {
    props: {
        sum:{
            default: 0,
            type: Number,
        },   
        delivery:{
            default: 0,
            type: Number,
        },
        currency:{
            default: ''
        },
    }
}
</script>

<style lang="scss" scoped>

@import '../../scss/_variables';

    .sum-wrapper{
        position: fixed;
        bottom: 5%;
        right: 2%;
        border: solid 1px $mainColor;
        padding: 1em;
        width: 15.5em;
        background-color: white;
        text-align: left;
        line-height: 2em;
    }

    h2{
        text-align: center;
        margin: 0 0 .3em 0;
    }

    span{
        font-weight: 600;
    }

</style>