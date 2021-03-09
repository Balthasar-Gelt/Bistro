<template>

    <div class="order">
        <h1>Your Order</h1>

        <div class="order-content">

            <ul class="ordered-items" v-show="!showCategories && selectedDishes && selectedDishes.length > 0">
                <li v-for="(selectedDish, index) in selectedDishes">
                    <img @click="removeDish(index,selectedDish.id)" src="images/remove.svg" alt="remove">

                    <div class="item-wrapper">
                        <strong>{{selectedDish.name}}</strong>
                        <div class="price">{{selectedDish.price}} {{currency}}</div>
                    </div>
                </li>
            </ul>

            <h2 v-show="!showCategories && selectedDishes.length <= 0">Your Lunch Bag is Empty!</h2>

            <div class="order-total" v-show="!showCategories">
                <span><strong>{{sum}} {{currency}}</strong></span>
            </div>

            <ul class="categories" v-show="showCategories">
                <li v-for="category in categoriesArray">

                    <a @click="getCategoryDishes(category[0])">{{ category[1] }}</a>

                </li>
            </ul>

            <ul class="dishes" v-show="dishes && dishes.length > 0 && showCategories">
                <li v-for="dish in dishes" class="dish">
                    <div class="dish-header">
                        <h2>{{dish.name}}</h2>
                        <a @click.prevent="selectDish(dish)" href="#">Select</a>
                    </div>
                    <ul class="ingredients">
                        <li><h3>Ingredients:</h3></li>
                        <li v-for="ingredient in dish.ingredients">
                            {{ingredient}}
                        </li>
                    </ul>
                    <span>
                        <strong>Price:</strong>
                        {{dish.price}}
                        {{currency}}
                    </span>
                </li>
            </ul>

        </div>
    </div>

</template>

<script>

export default {
    data: function() {
        return{
            categoriesArray: [],
            dishes: [],
            selectedDishes: [],
            sum: 0,
        } 
    },
    props: ['link', 'categories', 'showCategories', 'currency'],
    methods: {
        getCategories: function(){
            this.categoriesArray = this.categories.slice(1,-1).replace(/['"]+/g, '').split(',');

            this.categoriesArray.forEach((category, i) => {

                this.categoriesArray[i] = category.split(':');
            });
        },
        getCategoryDishes: function(id){

            this.dishes = [];

            fetch(this.link + '/api/categories/' + id)
            .then(r => r.json())
            .then(r =>  this.formatDishes(r.data.dishes));
        },
        formatDishes: function(data){

            this.dishes = data;

            this.dishes.forEach((dish,index) => {

                this.dishes[index]['price'] = this.formatPrice(dish['price']);
                this.dishes[index]['ingredients'] = dish['ingredients'].split('/');

            });
        },
        getCartContent: function(){

            fetch(this.link + '/cart/show')
            .then(r => r.json())
            .then(r =>  {

                let arr = r['items'];

                for (const e in arr) {

                    arr[e].dish.price = this.formatPrice(arr[e].dish.price);
                    
                    for (let i = 0; i < arr[e].quantity; i++){

                        this.selectedDishes.push(arr[e].dish);
                        this.sumAdd(arr[e].dish.price);
                    }
                }
            });
        },
        selectDish: function(dish){

            fetch(this.link + '/cart/add/' + dish.id)
            .then(r => r.json())
            .then(r => {
                console.log(r);
                this.selectedDishes.push(dish);
                this.sumAdd(dish['price']);
            });
        },
        formatPrice: function(price){
            return  price / 100;
        },
        removeDish: function(index, dishId){

            fetch(this.link + '/cart/delete/' + dishId)
            .then(r => r.json())
            .then(r => {
                console.log(r);
                this.sumDec(this.selectedDishes[index]['price']);
                this.selectedDishes.splice(index,1);
            });
        },
        sumAdd: function(price){
            this.sum += price;
            this.sum = parseFloat(this.sum.toFixed(2));

            this.$emit('changeCartTotal', this.sum);
        },
        sumDec: function(price){
            this.sum -= price;
            this.sum = parseFloat(this.sum.toFixed(2));
            
            this.$emit('changeCartTotal', this.sum);
        },
    },
    mounted(){
        this.getCategories();
        this.getCartContent();
    }
}
</script>

<style lang="scss" scoped>

@import '../../scss/variables';
@import '../../scss/mixins';

.order{
    margin: auto;

    h1{
        color: $secondaryColor;
        text-align: center;
        position: relative;
        padding-bottom: 1em;
        margin: 0;

        &::after{
            content: '';
            width: 70%;
            height: 3px;
            background-color: $mainColor;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
    }
}

.order-content{
    text-align: center;

    .categories{
        @include flex($justify: space-evenly);
        margin: 2em 0 5em 0;

        li{
            line-height: 3em;
            margin-right: 1em;
            cursor: pointer;
        }
    }
}

.ordered-items{
    line-height: 2em;
    margin: 3em auto;
    width: 60%;
    text-align: left;

    img{
        width: 5%;
        cursor: pointer;
    }

    li{
        margin-bottom: 1em;
        @include flex;

        .item-wrapper{
            @include flex;
            width: 90%;
        }

        strong{
            display: inline-block;
            text-align: left;
        }
    }

    .price{
        display: inline-block;
        width: 15%;
        text-align: right;
    }
}

.order-total{
    border-top: .1px solid $mainColor;
    padding-top: 1em;
    width: 60%;
    text-align: right;
    margin: 0 auto 3em auto;
}

.dishes{
    text-align: left;
    width: 90%;
    margin: auto;

    .dish{
        margin-bottom: 5em;

        h2{
            display: inline-block;
            margin-right: 1em;
            line-height: 1.5em;
        }

        a{
            border: .115em solid $mainColor;
            color: $mainColor;
            padding: .5em 1em;
            transition: color 300ms, background-color 300ms;

            &:hover{
                background-color: $mainColor;
                color: $secondaryColor;
            }

            &:active{
                background-color: unset;
                color: $mainColor;
            }
        }

        h3{
            width: 100%;
            margin: 0;
            color: $secondaryColor;
        }
    }

    .dish-header{
        @include flex($wrap: nowrap);
    }

    span{
        display: block;
        margin-top: 1em;
        text-align: right;

        strong{
            margin-right: 1em;
        }
    }
}

.ingredients{
    @include flex($justify: flex-start);

    li{
        margin-right: 1em;
        line-height: 2em;
        
        &::before{
            content: '-';
            color: $mainColor;
            margin-right: .3em;
        }

        &:first-of-type{
            border-bottom: none;

            &::before{
                content: none;
            }
        }
    }
}

@media(max-width: 900px){

    .dishes{
    width: 90%;
    }
}

@media(max-width: 900px){

    .dishes{

        .dish{

            h2{
                font-size: 1.3em;
            }

        }
    }
}

@media(max-width: 500px){

    .ordered-items, .order-total{
        width: 90% !important;
    }

    .ingredients{

        li{

            &:first-child{
                margin-bottom: .5em;
            }

            width: 100%;
        }
    }   
}

</style>
